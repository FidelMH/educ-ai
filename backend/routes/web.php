<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\LevelsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\DiscussController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\SubjectsController;
use App\Http\Controllers\ChatController;

// Home page
Route::get('/', function () {
    return view('home');
});

// Routes d'authentification
Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

// Routes protégées par authentification
Route::middleware('auth')->group(function () {
    Route::get('/profile', function () {
        return view('profile.edit');
    })->name('profile.edit');

    /*
    |--------------------------------------------------------------------------
    | User-Facing Chat Routes
    |--------------------------------------------------------------------------
    */
    Route::get('/chat/{discuss?}', [ChatController::class, 'index'])->name('chat');
    Route::post('/chat/create', [ChatController::class, 'store'])->name('chat.store');
    Route::delete('/chat/{discuss}', [ChatController::class, 'destroy'])->name('chat.destroy');
    Route::post('/chat/{discuss}/message', [ChatController::class, 'message'])->name('chat.message');

    // Admin-only Dashboard routes
    Route::middleware('admin')->prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/', function () {
            return view('dashboard');
        })->name('index'); // Becomes dashboard.index

        Route::resource('agents', AgentController::class);
        Route::resource('roles', RolesController::class);
        Route::resource('levels', LevelsController::class);
        Route::resource('users', UsersController::class);
        Route::resource('subjects', SubjectsController::class);
        Route::resource('discuss', DiscussController::class);
        Route::resource('messages', MessagesController::class);
    });
});
