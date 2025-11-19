<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\LevelsController;
use App\Http\Controllers\UsersController;

use App\Http\Controllers\SubjectsController;

// Redirection de la page d'accueil vers login
Route::get('/', function () {
    return redirect()->route('login');
});

// Routes d'authentification
Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

// Routes protégées par authentification
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', function () {
        return view('profile.edit');
    })->name('profile.edit');

    Route::resource('agents', AgentController::class);
    Route::resource('roles', RolesController::class);
    Route::resource('levels', LevelsController::class);
    Route::resource('users', UsersController::class);
    Route::resource('subjects', SubjectsController::class);
});