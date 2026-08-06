<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\ChatParticipant;
use App\Models\User;
use Illuminate\Http\Request;

class ChatParticipantController extends Controller
{
    public function add(Request $request, Chat $chat)
    {
        if ($chat->type !== 'group') {
            return response()->json(['error' => 'Can only add participants to group chats'], 422);
        }

        $userId = auth()->id();

        if (!$chat->chatParticipants()->where('user_id', $userId)->where('role', 'admin')->exists()) {
            return response()->json(['error' => 'Only admins can add participants'], 403);
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $exists = $chat->participants()->where('user_id', $request->user_id)->exists();

        if ($exists) {
            return response()->json(['error' => 'User already in chat'], 422);
        }

        ChatParticipant::create([
            'chat_id' => $chat->id,
            'user_id' => $request->user_id,
            'role' => 'member',
            'joined_at' => now(),
        ]);

        return response()->json(['success' => true]);
    }

    public function remove(Request $request, Chat $chat, User $user)
    {
        $userId = auth()->id();

        $isAdmin = $chat->chatParticipants()->where('user_id', $userId)->where('role', 'admin')->exists();
        $isSelf = $userId === $user->id;

        if (!$isAdmin && !$isSelf) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $chat->participants()->detach($user->id);

        return response()->json(['success' => true]);
    }

    public function toggleMute(Request $request, Chat $chat)
    {
        $participant = $chat->chatParticipants()->where('user_id', auth()->id())->first();

        if (!$participant) {
            return response()->json(['error' => 'Not a participant'], 403);
        }

        $participant->update(['is_muted' => !$participant->is_muted]);

        return response()->json([
            'is_muted' => $participant->is_muted,
        ]);
    }

    public function togglePin(Request $request, Chat $chat)
    {
        $participant = $chat->chatParticipants()->where('user_id', auth()->id())->first();

        if (!$participant) {
            return response()->json(['error' => 'Not a participant'], 403);
        }

        $participant->update(['is_pinned' => !$participant->is_pinned]);

        return response()->json([
            'is_pinned' => $participant->is_pinned,
        ]);
    }
}
