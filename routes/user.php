<?php

use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'user'], function(){
    Route::get('home', [UserController::class, 'userHome'])->name('userHome');
});
