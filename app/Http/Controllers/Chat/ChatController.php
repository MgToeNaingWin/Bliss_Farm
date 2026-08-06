<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\ChatParticipant;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();

        $chats = Chat::whereHas('participants', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })
        ->with(['latestMessage.sender', 'participants' => function ($q) use ($userId) {
            $q->where('users.id', '!=', $userId);
        }])
        ->withCount(['participants as total_participants'])
        ->orderByDesc(
            ChatParticipant::select('is_pinned')
                ->whereColumn('chat_id', 'chats.id')
                ->where('user_id', $userId)
                ->orderByDesc('is_pinned')
                ->limit(1)
        )
        ->get()
        ->map(function ($chat) use ($userId) {
            $chat->unread_count = $chat->getUnreadCount($userId);
            $chat->other_user = $chat->getOtherParticipant($userId);
            return $chat;
        })
        ->sortByDesc(function ($chat) {
            return $chat->latest_message?->created_at ?? $chat->created_at;
        })
        ->values();

        if ($request->ajax()) {
            return response()->json(['chats' => $chats]);
        }

        return view('user.chat.index', compact('chats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $userId = auth()->id();
        $otherUserId = $request->user_id;

        if ($userId === $otherUserId) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Cannot create chat with yourself.'], 422);
            }
            return back()->with('error', 'Cannot create chat with yourself.');
        }

        // Check if individual chat already exists
        $existingChat = Chat::where('type', 'individual')
            ->whereHas('participants', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->whereHas('participants', function ($q) use ($otherUserId) {
                $q->where('user_id', $otherUserId);
            })
            ->first();

        if ($existingChat) {
            if ($request->ajax()) {
                return response()->json(['chat_id' => $existingChat->id, 'redirect' => route('chat.show', $existingChat)]);
            }
            return redirect()->route('chat.show', $existingChat);
        }

        $chat = DB::transaction(function () use ($userId, $otherUserId) {
            $chat = Chat::create([
                'type' => 'individual',
                'created_by' => $userId,
            ]);

            ChatParticipant::insert([
                ['chat_id' => $chat->id, 'user_id' => $userId, 'role' => 'admin', 'joined_at' => now()],
                ['chat_id' => $chat->id, 'user_id' => $otherUserId, 'role' => 'member', 'joined_at' => now()],
            ]);

            return $chat;
        });

        if ($request->ajax()) {
            return response()->json(['chat_id' => $chat->id, 'redirect' => route('chat.show', $chat)]);
        }

        return redirect()->route('chat.show', $chat);
    }

    public function storeGroup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'participants' => 'required|array|min:1',
            'participants.*' => 'exists:users,id',
            'avatar' => 'nullable|image|max:2048',
        ]);

        $userId = auth()->id();
        $participantIds = array_unique(array_merge($request->participants, [$userId]));

        $chat = DB::transaction(function () use ($request, $userId, $participantIds) {
            $chat = Chat::create([
                'type' => 'group',
                'name' => $request->name,
                'created_by' => $userId,
            ]);

            if ($request->hasFile('avatar')) {
                $path = $request->file('avatar')->store('chats/avatars', 'public');
                $chat->update(['avatar' => $path]);
            }

            $participants = array_map(fn($id) => [
                'chat_id' => $chat->id,
                'user_id' => $id,
                'role' => $id === $userId ? 'admin' : 'member',
                'joined_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ], $participantIds);

            ChatParticipant::insert($participants);

            return $chat;
        });

        return redirect()->route('chat.show', $chat);
    }

    public function show(Chat $chat)
    {
        $userId = auth()->id();

        if (!$chat->participants()->where('user_id', $userId)->exists()) {
            abort(403);
        }

        $chat->load(['participants' => function ($q) {
            $q->with('onlineStatus');
        }]);

        $messages = $chat->messages()
            ->with(['sender', 'parentMessage.sender', 'reactions.user'])
            ->orderBy('created_at', 'asc')
            ->paginate(50);

        $otherUser = $chat->getOtherParticipant($userId);

        return view('user.chat.show', compact('chat', 'messages', 'otherUser'));
    }

    public function contacts()
    {
        $userId = auth()->id();

        $contacts = User::where('id', '!=', $userId)
            ->where('role', 'user')
            ->get()
            ->map(function ($user) use ($userId) {
                $existingChat = Chat::where('type', 'individual')
                    ->whereHas('participants', function ($q) use ($userId) {
                        $q->where('user_id', $userId);
                    })
                    ->whereHas('participants', function ($q) use ($user) {
                        $q->where('user_id', $user->id);
                    })
                    ->first();

                $user->existing_chat_id = $existingChat?->id;
                return $user;
            });

        return response()->json(['contacts' => $contacts]);
    }
}
