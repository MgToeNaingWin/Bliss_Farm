<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsReaction;
use Illuminate\Http\Request;

class NewsReactionController extends Controller
{
    public function toggle(Request $request, News $news)
    {
        $request->validate([
            'type' => 'required|in:like,helpful,thanks',
        ]);

        $existing = NewsReaction::where('user_id', auth()->id())
            ->where('news_id', $news->id)
            ->where('type', $request->type)
            ->first();

        if ($existing) {
            $existing->delete();
            $active = null;
        } else {
            NewsReaction::where('user_id', auth()->id())
                ->where('news_id', $news->id)
                ->delete();

            NewsReaction::create([
                'user_id' => auth()->id(),
                'news_id' => $news->id,
                'type' => $request->type,
            ]);
            $active = $request->type;
        }

        $reactions = [
            'like' => $news->reactions()->where('type', 'like')->count(),
            'helpful' => $news->reactions()->where('type', 'helpful')->count(),
            'thanks' => $news->reactions()->where('type', 'thanks')->count(),
        ];

        return response()->json(['reactions' => $reactions, 'active' => $active]);
    }
}
