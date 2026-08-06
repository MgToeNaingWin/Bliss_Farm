<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $query = News::withCount('comments');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhere('writer', 'like', '%' . $search . '%');
            });
        }

        $news = $query->latest()->paginate(9)->withQueryString();
        return view('user.news.index', compact('news'));
    }

    public function show(News $news)
    {
        $sessionKey = 'news_viewed_' . $news->id;
        if (!session()->has($sessionKey)) {
            $news->increment('view_count');
            session()->put($sessionKey, true);
        }

        $comments = $news->comments()->with('user')->latest()->get();

        $reactions = [
            'like' => $news->reactions()->where('type', 'like')->count(),
            'helpful' => $news->reactions()->where('type', 'helpful')->count(),
            'thanks' => $news->reactions()->where('type', 'thanks')->count(),
        ];

        $userReaction = null;
        if (auth()->check()) {
            $userReaction = $news->reactions()
                ->where('user_id', auth()->id())
                ->value('type');
        }

        // Sidebar data
        $latestNews = News::where('id', '!=', $news->id)->latest()->take(5)->get();
        $mostRead = News::where('id', '!=', $news->id)->orderByDesc('view_count')->take(5)->get();

        return view('user.news.single-news', compact('news', 'comments', 'reactions', 'userReaction', 'latestNews', 'mostRead'));
    }
}
