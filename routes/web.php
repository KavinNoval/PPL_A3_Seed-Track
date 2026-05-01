<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ControllerLupaPW;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ControllerStaf;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

// Middleware untuk User yang belum login
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // Ubah Password
    Route::get('/ubah-password', [ControllerLupaPW::class, 'showResetForm'])->name('password.request');
    Route::post('/ubah-password', [ControllerLupaPW::class, 'update'])->name('password.update');
});

// Middleware untuk User yang sudah login (Auth)
Route::middleware('auth')->group(function () {
    
    // --- 1. ADMIN SECTION ---
    Route::get('/dashboard-admin', [DashboardController::class, 'indexAdmin'])->name('dashboard.admin');

    // List Data (Read)
    Route::get('/data-staf', [DashboardController::class, 'dataStaf'])->name('data.staf');
    Route::get('/data-mitra', [DashboardController::class, 'dataMitra'])->name('data.mitra');
    Route::get('/data-kios', [DashboardController::class, 'dataKios'])->name('data.kios');

    // CRUD Staf
    Route::get('/tambah-staf', [DashboardController::class, 'createStaf'])->name('tambahinstaf');
    Route::post('/tambah-staf', [DashboardController::class, 'storeStaf'])->name('rubahstaf');
    Route::get('/edit-staf/{id}', [DashboardController::class, 'editStaf'])->name('editstaf');
    Route::post('/edit-staf/{id}', [DashboardController::class, 'updateStaf'])->name('updatestaf'); // Diubah agar spesifik

    // CRUD Mitra
    Route::get('/tambah-mitra', [DashboardController::class, 'createMitra'])->name('tambahinmitra');
    Route::post('/tambah-mitra', [DashboardController::class, 'storeMitra'])->name('simpanmitra');
    Route::get('/edit-mitra/{id}', [DashboardController::class, 'editMitra'])->name('editmitra');
    Route::post('/edit-mitra/{id}', [DashboardController::class, 'updateMitra'])->name('updatemitra');

    // Batal Simpan Mitra
    Route::get('/batal-simpan-mitra', [DashboardController::class, 'batalMitra'])->name('batal.mitra');

    // CRUD Kios
    Route::get('/tambah-kios', [DashboardController::class, 'createKios'])->name('tambahinkios');
    Route::post('/tambah-kios', [DashboardController::class, 'storeKios'])->name('simpankios');
    Route::get('/edit-kios/{id}', [DashboardController::class, 'editKios'])->name('editkios');
    Route::post('/edit-kios/{id}', [DashboardController::class, 'updateKios'])->name('updatekios');

    Route::get('/batal-kios', [DashboardController::class, 'batalKios'])->name('batal.kios');

    // --- 2. STAF LAPANG SECTION ---
    Route::get('/dashboard-lapang', function () {
        return view('dashboard-lapang'); 
    })->name('dashboard.lapang');
    
    Route::get('/staf-lapang/data-mitra', [ControllerStaf::class, 'dataMitraLapang'])->name('mitra.lapang');

    Route::get('/dashboard-gudang', [DashboardController::class, 'indexGudang'])->name('dashboard.gudang');
    
    Route::get('/staf-gudang/data-kios', [ControllerStaf::class, 'dataKiosGudang'])->name('kios.gudang');

    Route::get('/dashboard', function () {
        return view('dashboard-admin');
    })->name('dashboard');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});