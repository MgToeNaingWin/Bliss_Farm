<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\DiseaseController;
use App\Http\Controllers\ReactionController;
use App\Http\Controllers\SystemUser\ProfileController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;
Route::get('/home', function () {
    return view('user.home.home'); // သင့် Home Blade File လမ်းကြောင်း သတ်မှတ်ပါ
})->name('userHome');

    Route::group(['prefix' => 'user/disease'],function(){
        Route::get('/animals', [DiseaseController::class, 'index'])->name('diseaseList');
        Route::get('/animals/{animal}', [DiseaseController::class, 'showAnimalDiseases'])->name('showDisease');
        Route::get('/animals/detail/{disease:id}', [DiseaseController::class, 'showDiseaseDetail'])->name('userDiseaseDetail');
    });

        Route::get('/list', [UserController::class, 'listPage'])->name('postListPage');

    Route::group(['prefix' => 'user' , 'middleware' => 'user'], function(){
    Route::get('home', [UserController::class, 'userHome'])->name('userHome');


    Route::group(['prefix'=>'profile'],function(){
        Route::get('/profileEdit',[ProfileController::class, 'editProfilePage'])->name('editProfilePage');
        Route::get('/home',[ProfileController::class, 'profilePage'])->name('profilePage');
        Route::post('/edit',[ProfileController::class, 'profileEdit'])->name('profileEdit');
    });



    Route::group(['prefix' => 'sellPost'], function () {
  // Post Pages & Creation
    Route::get('/create', [UserController::class, 'createPage'])->name('postCreatePage');
    // Route::get('/list', [UserController::class, 'listPage'])->name('postListPage');
    Route::post('/create', [UserController::class, 'createPost'])->name('createPost');

    // AJAX Interactive Routes
    Route::post('/reaction', [UserController::class, 'toggleReaction'])->name('post.reaction');
    Route::post('/comment', [UserController::class, 'storeComment'])->name('post.comment');
    Route::post('/increment-view', [UserController::class, 'incrementView'])->name('post.incrementView');

    // Delete & Edit Routes (Route::delete ဖြင့် ပြောင်းလဲထားပါသည်)
    Route::delete('/delete/{id}', [UserController::class, 'deletePost'])->name('post.delete');
    Route::get('/edit/{id}', [UserController::class, 'editPostPage'])->name('post.editPage');
    Route::put('/update/{id}', [UserController::class, 'updatePost'])->name('post.update');
});

    // Comments
    Route::post('/disease/comment/{disease:id}', [CommentController::class, 'store'])->name('comment.store');
    Route::delete('/comment/{comment}', [CommentController::class, 'destroy'])->name('comment.destroy');

    // Reactions
    Route::post('/disease/react/{disease:id}', [ReactionController::class, 'toggle'])->name('reaction.toggle');
});
