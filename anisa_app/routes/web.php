<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;

// 🌐 Landing Page (PUBLIC)
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/kategori/{id}', [BukuController::class, 'filterByKategori'])->name('buku.byKategori');

// 🔓 Public routes: login & register
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 🔐 Protected routes (hanya setelah login)
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [BukuController::class, 'dashboard'])->name('dashboard');

    // CRUD Buku
    Route::resource('bukus', BukuController::class);
});