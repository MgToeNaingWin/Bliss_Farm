<?php

use App\Http\Controllers\User\AdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin' , 'middleware' => 'admin'], function(){
    Route::get('home', [AdminController::class, 'adminHome'])->name('adminHome');
});
