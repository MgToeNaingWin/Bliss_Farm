<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;

class AdminController extends Controller
{
    //admin home
    public function adminHome(){
        // dd(auth()->check(), auth()->user());
        return view('admin.home.home');
    }
}
