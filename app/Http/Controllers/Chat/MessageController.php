<?php

namespace App\Http\Controllers\Chat;

use App\Events\MessageDeleted;
use App\Events\MessageReactionEvent;
use App\Events\MessageStatusUpdated;
use App\Events\NewMessage;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Message;
use App\Models\MessageReaction;
use App\Models\MessageStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function send(Request $request, Chat $chat)
    {
        $userId = auth()->id();

        if (!$chat->participants()->where('user_id', $userId)->exists()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'content' => 'required_without:file|string|max:5000',
            'file' => 'nullable|file|max:51200',
            'type' => 'in:text,image,video,audio,file,location',
        ]);

        $data = [
            'chat_id' => $chat->id,
            'sender_id' => $userId,
            'type' => $request->type ?? 'text',
            'content' => $request->content ?? '',
        ];

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store("chats/{$chat->id}", 'public');
            $data['content'] = $path;
            $data['type'] = $request->type ?? $this->guessFileType($file->getMimeType());
            $data['metadata'] = [
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize(),
            ];
        }

        $message = Message::create($data);

        // Create status for all participants
        $participants = $chat->participants()->where('user_id', '!=', $userId)->pluck('user_id');
        foreach ($participants as $participantId) {
            MessageStatus::create([
                'message_id' => $message->id,
                'user_id' => $participantId,
                'status' => 'delivered',
            ]);
        }

        // Load relations
        $message->load(['sender', 'reactions']);

        try { broadcast(new NewMessage($message)); } catch (\Exception $e) {}

        return response()->json(['message' => $message]);
    }

    public function edit(Request $request, Message $message)
    {
        if (!$message->isOwnedBy(auth()->id())) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'content' => 'required|string|max:5000',
        ]);

        $message->update([
            'content' => $request->content,
            'is_edited' => true,
        ]);

        try { broadcast(new \App\Events\MessageStatusUpdated($message, 'edited')); } catch (\Exception $e) {}
        return response()->json(['message' => $message]);
    }

    public function destroy(Request $request, Message $message)
    {
        if (!$message->isOwnedBy(auth()->id())) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $message->update(['is_deleted' => true, 'content' => '']);
        try { broadcast(new MessageDeleted($message)); } catch (\Exception $e) {}
        return response()->json(['success' => true]);
    }

    public function reply(Request $request, Message $message)
    {
        $userId = auth()->id();
        $chat = $message->chat;
        if (!$chat->participants()->where('user_id', $userId)->exists()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $request->validate(['content' => 'required|string|max:5000']);
        $reply = Message::create([
            'chat_id' => $chat->id, 'sender_id' => $userId, 'type' => 'text',
            'content' => $request->content, 'parent_message_id' => $message->id,
        ]);
        $reply->load(['sender', 'parentMessage', 'reactions']);
        try { broadcast(new NewMessage($reply)); } catch (\Exception $e) {}
        return response()->json(['message' => $reply]);
    }

    public function forward(Request $request, Message $message)
    {
        $request->validate(['chat_ids' => 'required|array', 'chat_ids.*' => 'exists:chats,id']);
        $userId = auth()->id();
        foreach ($request->chat_ids as $chatId) {
            $chat = Chat::find($chatId);
            if (!$chat->participants()->where('user_id', $userId)->exists()) continue;
            $forwarded = Message::create([
                'chat_id' => $chatId, 'sender_id' => $userId, 'type' => $message->type,
                'content' => $message->content, 'metadata' => $message->metadata,
            ]);
            $forwarded->load(['sender']);
            try { broadcast(new NewMessage($forwarded)); } catch (\Exception $e) {}
        }
        return response()->json(['success' => true]);
    }

    public function toggleReaction(Request $request, Message $message)
    {
        $request->validate(['emoji' => 'required|string|max:4']);
        $userId = auth()->id();
        $existing = MessageReaction::where('message_id', $message->id)->where('user_id', $userId)->first();
        if ($existing) {
            if ($existing->emoji === $request->emoji) { $existing->delete(); $action = 'removed'; }
            else { $existing->update(['emoji' => $request->emoji]); $action = 'updated'; }
        } else {
            MessageReaction::create(['message_id' => $message->id, 'user_id' => $userId, 'emoji' => $request->emoji]);
            $action = 'added';
        }
        $message->load('reactions.user');
        try { broadcast(new MessageReactionEvent($message, $action, $request->emoji)); } catch (\Exception $e) {}
        return response()->json(['reactions' => $message->reactions, 'action' => $action]);
    }

    public function markAsRead(Request $request, Chat $chat)
    {
        $userId = auth()->id();

        $lastMessage = $chat->messages()->latest()->first();

        if ($lastMessage) {
            $chat->chatParticipants()
                ->where('user_id', $userId)
                ->update(['last_read_message_id' => $lastMessage->id]);

            // Mark all unread messages as read
            $unreadMessages = $chat->messages()
                ->where('sender_id', '!=', $userId)
                ->where('id', '>', $chat->chatParticipants()
                    ->where('user_id', $userId)
                    ->first()?->last_read_message_id ?? 0)
                ->get();

            foreach ($unreadMessages as $msg) {
                MessageStatus::updateOrCreate(
                    ['message_id' => $msg->id, 'user_id' => $userId],
                    ['status' => 'read']
                );

                try {
                    broadcast(new MessageStatusUpdated($msg, 'read'));
                } catch (\Exception $e) {}
            }
        }

        return response()->json(['success' => true]);
    }

    private function guessFileType(string $mimeType): string
    {
        return match(true) {
            str_starts_with($mimeType, 'image/') => 'image',
            str_starts_with($mimeType, 'video/') => 'video',
            str_starts_with($mimeType, 'audio/') => 'audio',
            default => 'file',
        };
    }
}
