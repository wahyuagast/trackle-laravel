<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Web\ProjectViewController;

// Rute Autentikasi
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// Rute utama aplikasi (Dashboard)
// ->middleware('auth') akan mewajibkan login sebelum bisa mengakses
Route::get('/', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

// Contoh rute untuk halaman form proyek
Route::get('/projects/create', [ProjectViewController::class, 'create'])->name('projects.create')->middleware('auth');
Route::get('/projects/{project}', [ProjectViewController::class, 'show'])->name('projects.show')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
// Ini akan otomatis membuat rute untuk create, show, edit, dll.
Route::resource('projects', ProjectViewController::class)->only(['create', 'show', 'edit']);
});

// Rute default dari Laravel Breeze/UI untuk autentikasi jika Anda menggunakannya nanti
// require __DIR__.'/auth.php';