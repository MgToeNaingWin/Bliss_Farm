<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
        public function index(){
            $News = News::all();
            return view('user.news.index', [
                'news' => $News
            ]);
    }
}
