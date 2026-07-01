<?php

use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
require_once __DIR__.'/user.php';
Route::redirect('/', 'login');
Route::get('/news',[NewsController::class,'index']);
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



use Laravel\Socialite\Socialite;
use App\Http\Controllers\User\SocialLoginController;


Route::get('/auth/google/redirect', [SocialLoginController::class, 'socialredirect'])->name('socialLogin');

Route::get('/auth/google/callback', [SocialLoginController::class, 'callback'])->name('socialCallback');
