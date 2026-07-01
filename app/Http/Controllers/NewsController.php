<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        // Fetch 5 news items per page
        $news = News::paginate(5);
        return view('user.news.index', [
            'news' => $news
        ]);
    }
    public function show(News $news){
        return view('user.news.single-news', ['single_news' => $news]);
    }
}
