<?php

use App\Http\Controllers\User\AdminController;
use App\Http\Controllers\User\DiseaseController;
use App\Http\Controllers\User\ProfileController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin' , 'middleware' => 'admin'], function(){
    Route::get('home', [AdminController::class, 'adminHome'])->name('adminHome');
    Route::delete('/posts/{id}', [AdminController::class, 'deletePost'])->name('admin.posts.delete');


    //news
   Route::group(['prefix' => 'news'],function(){
    Route::get('create', [AdminController:: class, 'newsCreatePage'])->name('newsCreatePage');
    Route::post('create',[AdminController::class, 'newsCreate'])->name('newsCreate');
    Route::get('edit/{id}', [AdminController::class, 'newsEditPage'])->name('newsEditPage');
    Route::post('update/{id}', [AdminController::class, 'newsUpdate'])->name('newsUpdate');
    Route::get('delete/{id}', [AdminController::class, 'newsDelete'])->name('newsDelete');
    Route::get('manage-all', [AdminController::class, 'manageAllNews'])->name('newsManageAll');
    Route::get('{id}/detail', [AdminController::class, 'newsDetail'])->name('newsDetail');
   });

   //disease info
   Route::group(['prefix' => 'disease'],function(){
    Route::get('/', [DiseaseController::class, 'index'])->name('diseaseManagePage');
    Route::get('/create', [DiseaseController::class, 'create'])->name('diseaseCreatePage');
    Route::post('/store', [DiseaseController::class, 'store'])->name('diseaseStore');
    Route::get('/{id}/detail', [DiseaseController::class, 'show'])->name('diseaseDetail');
    Route::get('/{id}/edit', [DiseaseController::class, 'edit'])->name('diseaseEditPage');
    Route::post('/{id}/update', [DiseaseController::class, 'update'])->name('diseaseUpdate');
    Route::get('/{id}/delete', [DiseaseController::class, 'destroy'])->name('diseaseDelete');

   });

   //add new admin
   // CRUD Routes for Admin/User Management
    Route::get('/users', [ProfileController::class, 'indexAdmin'])->name('admin.users.index');
    Route::get('/users/create-admin', [ProfileController::class, 'createAdmin'])->name('admin.users.create');
    Route::post('/users/store-admin', [ProfileController::class, 'storeAdmin'])->name('admin.users.store');
    Route::get('/users/{id}', [ProfileController::class, 'showAdmin'])->name('admin.users.show');
    Route::delete('/users/{id}', [ProfileController::class, 'destroyAdmin'])->name('admin.users.destroy');

   //profile
   Route::group(['prefix' => 'profile'],function(){
    Route::get('/home', [ProfileController::class, 'index'])->name('admin.profile.index');
    Route::put('/update', [ProfileController::class, 'update'])->name('admin.profile.update');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('admin.profile.password');
   });
});
