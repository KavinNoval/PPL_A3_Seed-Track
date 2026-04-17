<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ControllerLupaPW;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

// belum login
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // Ubah Password
    Route::get('/ubah-password', [ControllerLupaPW::class, 'showResetForm'])->name('password.request');
    Route::post('/ubah-password', [ControllerLupaPW::class, 'update'])->name('password.update');
});

// udah login auth
Route::middleware('auth')->group(function () {
    
    // 1. Dashboard Admin
    Route::get('/dashboard-admin', function () {
        return view('dashboard-admin'); 
    })->name('dashboard.admin');

    // 2. Dashboard Staf Lapang
    Route::get('/dashboard-lapang', function () {
        return view('dashboard-lapang'); 
    })->name('dashboard.lapang');

    // 3. Dashboard Staf Gudang
    Route::get('/dashboard-gudang', function () {
        return view('dashboard-gudang'); 
    })->name('dashboard.gudang');

    // 4. Dashboard Default (Jaga-jaga)
    Route::get('/dashboard', function () {
        return view('dashboard-admin');
    })->name('dashboard');

    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});