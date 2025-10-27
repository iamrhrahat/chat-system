<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/inbox', [ChatController::class, 'index'])->name('inbox');
    Route::get('/dashboard/chat/{id}', [ChatController::class, 'show'])->name('dashboard.chat');
    Route::post('/dashboard/chat/{id}/send', [ChatController::class, 'send'])->name('chat.send');
});
Route::middleware(['auth'])->group(function () {
    // Route::get('/inbox', [ConversationController::class, 'index'])->name('inbox');
    Route::get('/chat/{conversation}', [ConversationController::class, 'show'])->name('chat.show');

    Route::post('/chat/{conversation}/send', [ChatController::class, 'store'])->name('chat.send');
});

require __DIR__.'/auth.php';
