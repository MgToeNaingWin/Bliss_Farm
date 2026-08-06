<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsComment;
use Illuminate\Http\Request;

class NewsCommentController extends Controller
{
    public function store(Request $request, News $news)
    {
        $request->validate([
            'body' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:news_comments,id',
        ]);

        $comment = $news->comments()->create([
            'user_id' => auth()->id(),
            'body' => $request->body,
            'parent_id' => $request->parent_id,
        ]);

        $comment->load('user');

        $html = view('user.news._comment', ['comment' => $comment])->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'count' => $news->comments()->count(),
        ]);
    }

    public function destroy(NewsComment $comment)
    {
        if ($comment->user_id !== auth()->id()) {
            abort(403);
        }

        $newsId = $comment->news_id;
        $comment->delete();

        return response()->json([
            'success' => true,
            'count' => \App\Models\NewsComment::where('news_id', $newsId)->count(),
        ]);
    }
}
