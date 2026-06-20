<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
require_once __DIR__.'/user.php';
Route::get('/', function () {
    return view('auth.home.register');
});

Route::get('/disease-info', function(){
    return view('user.home.disease-info');
});
Route::get('/news', function(){
    return view('user.home.news');
});
Route::get('/market', function(){
    return view('user.home.market');
});

Route::get('/home', function () {
    return view('user.home.home');
});
// restore-auth-branch
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
