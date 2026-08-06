<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\Request;

class ChatSearchController extends Controller
{
    public function search(Request $request)
    {
        $request->validate([
            'q' => 'required|string|min:1',
        ]);

        $query = $request->q;
        $userId = auth()->id();

        // Search messages in user's chats
        $messages = Message::whereHas('chat', function ($q) use ($userId) {
            $q->whereHas('participants', function ($q2) use ($userId) {
                $q2->where('user_id', $userId);
            });
        })
        ->where('content', 'LIKE', "%{$query}%")
        ->with(['chat', 'sender'])
        ->orderByDesc('created_at')
        ->limit(50)
        ->get();

        // Search contacts
        $contacts = \App\Models\User::where('id', '!=', $userId)
            ->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('email', 'LIKE', "%{$query}%");
            })
            ->limit(20)
            ->get();

        return response()->json([
            'messages' => $messages,
            'contacts' => $contacts,
        ]);
    }
}
