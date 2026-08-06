<?php

use App\Http\Controllers\Chat\ChatController;
use App\Http\Controllers\Chat\ChatParticipantController;
use App\Http\Controllers\Chat\ChatSearchController;
use App\Http\Controllers\Chat\MessageController;
use App\Models\UserOnlineStatus;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('chat')->name('chat.')->group(function () {
    // Chat list
    Route::get('/', [ChatController::class, 'index'])->name('index');

    // Create individual chat
    Route::post('/', [ChatController::class, 'store'])->name('store');

    // Create group chat
    Route::post('/group', [ChatController::class, 'storeGroup'])->name('storeGroup');

    // Search & Contacts (BEFORE {chat} route to avoid conflict)
    Route::get('/search', [ChatSearchController::class, 'search'])->name('search');
    Route::get('/contacts', [ChatController::class, 'contacts'])->name('contacts');

    // Chat room (MUST be after specific routes)
    Route::get('/{chat}', [ChatController::class, 'show'])->name('show');

    // Messages
    Route::post('/{chat}/message', [MessageController::class, 'send'])->name('message.send');
    Route::put('/message/{message}', [MessageController::class, 'edit'])->name('message.edit');
    Route::delete('/message/{message}', [MessageController::class, 'destroy'])->name('message.delete');
    Route::post('/message/{message}/reply', [MessageController::class, 'reply'])->name('message.reply');
    Route::post('/message/{message}/forward', [MessageController::class, 'forward'])->name('message.forward');
    Route::post('/message/{message}/react', [MessageController::class, 'toggleReaction'])->name('message.react');

    // Mark as read
    Route::post('/{chat}/read', [MessageController::class, 'markAsRead'])->name('markAsRead');

    // Participants
    Route::post('/{chat}/participants', [ChatParticipantController::class, 'add'])->name('participants.add');
    Route::delete('/{chat}/participants/{user}', [ChatParticipantController::class, 'remove'])->name('participants.remove');
    Route::put('/{chat}/mute', [ChatParticipantController::class, 'toggleMute'])->name('mute');
    Route::put('/{chat}/pin', [ChatParticipantController::class, 'togglePin'])->name('pin');

    // Typing indicators
    Route::post('/{chat}/typing/start', function ($chat) {
        $userId = auth()->id();
        Cache::put("typing_{$chat}_{$userId}", true, 5);
        try {
            broadcast(new \App\Events\TypingStarted(auth()->user(), $chat));
        } catch (\Exception $e) {}
        return response()->json(['success' => true]);
    })->name('typing.start');

    Route::post('/{chat}/typing/stop', function ($chat) {
        $userId = auth()->id();
        Cache::forget("typing_{$chat}_{$userId}");
        try {
            broadcast(new \App\Events\TypingStopped(auth()->user(), $chat));
        } catch (\Exception $e) {}
        return response()->json(['success' => true]);
    })->name('typing.stop');

    // Online status
    Route::post('/status/online', function () {
        UserOnlineStatus::updateOrCreate(
            ['user_id' => auth()->id()],
            ['is_online' => true, 'last_seen_at' => now()]
        );
        return response()->json(['success' => true]);
    })->name('status.online');

    Route::post('/status/offline', function () {
        UserOnlineStatus::updateOrCreate(
            ['user_id' => auth()->id()],
            ['is_online' => false, 'last_seen_at' => now()]
        );
        return response()->json(['success' => true]);
    })->name('status.offline');
});
