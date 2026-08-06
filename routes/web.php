<?php

use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NewsCommentController;
use App\Http\Controllers\NewsReactionController;
use App\Http\Controllers\AiDiseaseController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
require_once __DIR__.'/user.php';
require_once __DIR__.'/chat.php';

// NEWS Routes
Route::get('/news', [NewsController::class, 'index'])->name('newsIndex');
Route::get('/news/{news}', [NewsController::class, 'show'])->name('newsShow');

// News Comment & Reaction (auth required)
Route::middleware('auth')->group(function () {
    Route::post('/news/{news}/comment', [NewsCommentController::class, 'store'])->name('newsComment.store');
    Route::delete('/news-comment/{comment}', [NewsCommentController::class, 'destroy'])->name('newsComment.destroy');
    Route::post('/news/{news}/react', [NewsReactionController::class, 'toggle'])->name('newsReaction.toggle');
});

Route::get('/market', function(){
    return view('user.home.market');
});

Route::redirect('/', 'login');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

use App\Http\Controllers\User\SocialLoginController;

Route::get('/auth/google/redirect', [SocialLoginController::class, 'socialredirect'])->name('socialLogin');
Route::get('/auth/google/callback', [SocialLoginController::class, 'callback'])->name('socialCallback');

// AI Disease Prediction Routes
Route::get('/ai-disease', [AiDiseaseController::class, 'index'])->name('aiDisease.index');
Route::post('/ai-disease/symptoms', [AiDiseaseController::class, 'getSymptoms'])->name('aiDisease.symptoms');
Route::post('/ai-disease/analyze', [AiDiseaseController::class, 'analyze'])->name('aiDisease.analyze');
Route::post('/ai-disease/analyze-image', [AiDiseaseController::class, 'analyzeImage'])->name('aiDisease.analyzeImage');
