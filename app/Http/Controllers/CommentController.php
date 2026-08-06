<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\DiseaseInfo;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, DiseaseInfo $disease)
    {
        $request->validate([
            'body' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $comment = $disease->comments()->create([
            'user_id' => auth()->id(),
            'body' => $request->body,
            'parent_id' => $request->parent_id,
        ]);

        $comment->load('user');

        $html = view('user.disease._comment', ['comment' => $comment])->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'count' => $disease->comments()->count(),
        ]);
    }

    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== auth()->id()) {
            abort(403);
        }

        $diseaseId = $comment->disease_info_id;
        $comment->delete();

        return response()->json([
            'success' => true,
            'count' => \App\Models\Comment::where('disease_info_id', $diseaseId)->count(),
        ]);
    }
}
