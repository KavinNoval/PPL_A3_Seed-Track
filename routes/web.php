<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ControllerLupaPW;
use App\Http\Controllers\DashboardController; // Wajib ditambahin biar controllernya kebaca
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControllerStaf;

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

    // FITUR BARU: Data Staf (Akses Database)
    Route::get('/data-staf', [DashboardController::class, 'dataStaf'])->name('data.staf');
    Route::get('/data-mitra', [DashboardController::class, 'dataMitra'])->name('data.mitra');
    Route::get('/data-kios', [DashboardController::class, 'dataKios'])->name('data.kios');

    // tambah edit staf
    Route::get('/tambah-staf', [DashboardController::class, 'createStaf'])->name('tambahinstaf');
    Route::post('/tambah-staf', [DashboardController::class, 'storeStaf'])->name('rubahstaf');
    Route::get('/edit-staf/{id}', [DashboardController::class, 'editStaf'])->name('editstaf');
    Route::post('/edit-staf/{id}', [DashboardController::class, 'updateStaf'])->name('update');

    // tambah edit mitra
    Route::get('/tambah-mitra', [DashboardController::class, 'createMitra'])->name('tambahinmitra');
    Route::post('/tambah-mitra', [DashboardController::class, 'storeMitra'])->name('simpanmitra');
    Route::get('/edit-mitra/{id}', [DashboardController::class, 'editMitra'])->name('editmitra');
    Route::post('/edit-mitra/{id}', [DashboardController::class, 'updateMitra'])->name('updatemitra');

    // tambah edit kios
    Route::get('/tambah-kios', [DashboardController::class, 'createKios'])->name('tambahinkios');
    Route::post('/tambah-kios', [DashboardController::class, 'storeKios'])->name('simpankios');
    Route::get('/edit-kios/{id}', [DashboardController::class, 'editKios'])->name('editkios');
    Route::post('/edit-kios/{id}', [DashboardController::class, 'updateKios'])->name('updatekios');
    
    // 2. Dashboard Staf Lapang
    Route::get('/dashboard-lapang', function () {
        return view('dashboard-lapang'); 
    })->name('dashboard.lapang');
    Route::get('/staf-lapang/data-mitra', [ControllerStaf::class, 'dataMitraLapang'])->name('mitra.lapang');

    // 3. Dashboard Staf Gudang
    Route::get('/dashboard-gudang', [DashboardController::class, 'indexGudang'])->name('dashboard.gudang');
    Route::get('/staf-gudang/data-kios', [ControllerStaf::class, 'dataKiosGudang'])->name('kios.gudang');
    Route::get('/staf-lapang/data-mitra', [ControllerStaf::class, 'dataMitraLapang'])->name('mitra.lapang');

    // 4. Dashboard Default (Jaga-jaga)
    Route::get('/dashboard', function () {
        return view('dashboard-admin');
    })->name('dashboard');

    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});