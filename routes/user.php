<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\DiseaseController;
use App\Http\Controllers\FinancialController;
use App\Http\Controllers\LivestockController;
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

Route::group(['prefix' => 'user', 'middleware' => 'user', 'as' => 'user.'], function () {
    // ... other routes ...

    // ─── Livestock Management Routes ───
    Route::group(['prefix' => 'livestock', 'as' => 'livestock.'], function () {
        // Dashboard
        Route::get('/dashboard', [LivestockController::class, 'dashboard'])->name('dashboard');

        // Main CRUD Routes
        Route::get('/', [LivestockController::class, 'index'])->name('index');
        Route::get('/create', [LivestockController::class, 'create'])->name('create');
        Route::post('/', [LivestockController::class, 'store'])->name('store');
        Route::get('/{livestock}', [LivestockController::class, 'show'])->name('show');
        Route::get('/{livestock}/edit', [LivestockController::class, 'edit'])->name('edit');
        Route::put('/{livestock}', [LivestockController::class, 'update'])->name('update');
        Route::delete('/{livestock}', [LivestockController::class, 'destroy'])->name('destroy');

        // Health Records
        Route::get('/{livestock}/health-records', [LivestockController::class, 'healthRecords'])->name('health-records');
        Route::post('/{livestock}/health-records', [LivestockController::class, 'addHealthRecord'])->name('add-health-record');

        // Feeding Records
        Route::get('/{livestock}/feeding-records', [LivestockController::class, 'feedingRecords'])->name('feeding-records');
        Route::post('/{livestock}/feeding-records', [LivestockController::class, 'addFeedingRecord'])->name('add-feeding-record');
    });

    // ─── Financial Management Routes ───



    // ─── Financial Management Routes ───
    Route::group(['prefix' => 'financial', 'as' => 'financial.'], function () {

        // Dashboard
        Route::get('/dashboard', [FinancialController::class, 'dashboard'])->name('dashboard');

        // Fixed Page & Report Routes (Place SPECIFIC routes above wildcards!)
        Route::get('/records', [FinancialController::class, 'records'])->name('records');
        Route::get('/create', [FinancialController::class, 'create'])->name('create');
        Route::post('/store', [FinancialController::class, 'store'])->name('store');

        Route::get('/monthly-report', [FinancialController::class, 'monthlyReport'])->name('monthly-report');
        Route::get('/yearly-report', [FinancialController::class, 'yearlyReport'])->name('yearly-report');

        // Dynamic / Parameterized Routes (Keep WILDCARDS at the bottom)
        Route::get('/{record}', [FinancialController::class, 'show'])->name('show');
        Route::get('/{record}/edit', [FinancialController::class, 'edit'])->name('edit');
        Route::put('/{record}', [FinancialController::class, 'update'])->name('update');
        Route::delete('/{record}', [FinancialController::class, 'destroy'])->name('destroy');
    });

});

