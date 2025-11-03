<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use Illuminate\Support\Facades\Route;

// 🔓 Public routes: login & register
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 🔐 Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return redirect()->route('bukus.index');
    });
    Route::resource('bukus', BukuController::class);
});

Route::get('/dashboard', [BukuController::class, 'dashboard'])
    ->middleware('auth')
    ->name('dashboard');