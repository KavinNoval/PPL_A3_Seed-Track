<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ControllerLupaPW;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ControllerStaf;
use App\Http\Controllers\Monitoring;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\PengeluaranController;

Route::get('/', [LandingPageController::class, 'index'])->name('landing.publik');

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

    // --- DASHBOARD PENGATUR LALU LINTAS (SMART REDIRECT) ---
    Route::get('/dashboard', function () {
        $role = Illuminate\Support\Facades\Auth::user()->role;

        if ($role == 'Admin') {
            return redirect()->route('dashboard.admin');
        } elseif ($role == 'Staff Gudang' || $role == 'Staf Gudang') {
            return redirect()->route('dashboard.gudang');
        } elseif ($role == 'Staff Lapang' || $role == 'Staf Lapang') {
            return redirect()->route('dashboard.lapang');
        }

        // Jaga-jaga kalau role-nya aneh
        return redirect('/');
    })->name('dashboard');

    // --- DASHBOARD ADMIN ---
    Route::get('/dashboard-admin', [DashboardController::class, 'indexAdmin'])->name('dashboard.admin');

    // List Data (Read)
    Route::get('/data-staf', [DashboardController::class, 'dataStaf'])->name('data.staf');
    Route::get('/data-mitra', [DashboardController::class, 'dataMitra'])->name('data.mitra');
    Route::get('/data-kios', [DashboardController::class, 'dataKios'])->name('data.kios');

    // CRUD Staf
    Route::get('/tambah-staf', [DashboardController::class, 'createStaf'])->name('tambahinstaf');
    Route::post('/tambah-staf', [DashboardController::class, 'storeStaf'])->name('rubahstaf');
    Route::get('/edit-staf/{id}', [DashboardController::class, 'editStaf'])->name('editstaf');
    Route::post('/edit-staf/{id}', [DashboardController::class, 'updateStaf'])->name('updatestaf');

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

    // =========================================================================
    // ROUTE SAKTI AJAX DROPDOWN WILAYAH (KABUPATEN - KECAMATAN - KELURAHAN)
    // =========================================================================
    Route::get('/get-kecamatan/{id_kabupaten}', [DashboardController::class, 'getKecamatan']);
    Route::get('/get-kelurahan/{id_kecamatan}', [DashboardController::class, 'getKelurahan']);
    // =========================================================================

    // --- TRANSAKSI SECTION ---
    Route::get('/transaksi', [TransaksiController::class, 'tampilTransaksiAdmin'])->name('transaksi.index'); // Buat Admin
    Route::get('/tambah-transaksi', [TransaksiController::class, 'create'])->name('tambah-transaksi');
    Route::post('/tambah-transaksi', [TransaksiController::class, 'store'])->name('simpan-transaksi');
    Route::delete('/transaksi/hapus/{id}', [TransaksiController::class, 'destroy'])->name('hapus-transaksi');

    // INI DIA TAMBAHAN RUTE EDIT TRANSAKSI-NYA
    Route::get('/edit-transaksi/{id}', [TransaksiController::class, 'edit'])->name('transaksi.edit');
    Route::post('/edit-transaksi/{id}', [TransaksiController::class, 'update'])->name('transaksi.update');

    // --- MONITORING LAHAN SECTION ---
    Route::get('/monitoring-lahan', [Monitoring::class, 'tampilMonitoring'])->name('monitoring.admin');
    Route::get('/monitoring-lahan/riwayat/{id}', [Monitoring::class, 'detail'])->name('monitoring.detail');
    Route::get('/staf/monitoring', [Monitoring::class, 'tampilMonitoringStaf'])->name('monitoring.staf');

    // CRUD Monitoring
    Route::get('/tambah-monitoring/{id}', [Monitoring::class, 'create'])->name('tambahinmonitoring');
    Route::post('/tambah-monitoring', [Monitoring::class, 'store'])->name('simpanmonitoring');
    Route::get('/edit-monitoring/{id}', [Monitoring::class, 'edit'])->name('editmonitoring');
    Route::post('/edit-monitoring', [Monitoring::class, 'update'])->name('updatemonitoring');

    // --- DATA PRODUK SECTION ---
    Route::get('/data-produk', [ProdukController::class, 'index'])->name('produk.admin');
    Route::get('/tambah-produk', [ProdukController::class, 'create'])->name('produk.tambah');
    Route::post('/tambah-produk', [ProdukController::class, 'store'])->name('produk.store');
    Route::get('/detail-produk/{id}', [ProdukController::class, 'detail'])->name('produk.detail');

    // Rute Ubah & Update Produk (Udah pinter, dipake berdua sama Gudang)
    Route::get('/ubah-produk/{id}', [ProdukController::class, 'edit'])->name('produk.edit');
    Route::put('/ubah-produk/{id}', [ProdukController::class, 'update'])->name('produk.update');

    Route::get('/produk/cancel/{konteks}', [ProdukController::class, 'cancel'])->name('produk.cancel');

    // --- STAF LAPANG SECTION ---
    Route::get('/dashboard-lapang', function () {
        return view('dashboard-lapang');
    })->name('dashboard.lapang');

    Route::get('/staf-lapang/data-mitra', [ControllerStaf::class, 'dataMitraLapang'])->name('mitra.lapang');

    // --- STAF GUDANG SECTION ---
    Route::get('/dashboard-gudang', [DashboardController::class, 'indexGudang'])->name('dashboard.gudang');
    Route::get('/staf-gudang/data-kios', [DashboardController::class, 'kiosGudang'])->name('kios.gudang');
    Route::get('/staf-gudang/transaksi', [TransaksiController::class, 'tampilTransaksiStaf'])->name('transaksi.staf'); // Buat Staf
    Route::get('/staf-gudang/produk', [ProdukController::class, 'index'])->name('produk.staf');
    Route::get('/staf-gudang/pengeluaran', [PengeluaranController::class, 'indexGudang'])->name('pengeluaran.gudang');

    // --- LOGOUT ---
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // --- PROFIL PERUSAHAAN (ADMIN) ---
    Route::get('/admin/profil-perusahaan', [LandingPageController::class, 'profilAdmin'])->name('profil.perusahaan');
    Route::get('/admin/profil-perusahaan/edit', [LandingPageController::class, 'editProfil'])->name('profil.edit');
    Route::post('/admin/profil-perusahaan/update', [LandingPageController::class, 'updateProfil'])->name('profil.update');

    // --- PENGELUARAN SECTION (ADMIN) ---
    Route::get('/pengeluaran', [PengeluaranController::class, 'index'])->name('pengeluaran.index');
    Route::get('/pengeluaran/detail/{id}', [PengeluaranController::class, 'show'])->name('pengeluaran.detail');
    Route::get('/tambah-pengeluaran', [PengeluaranController::class, 'create'])->name('pengeluaran.tambah');
    Route::post('/tambah-pengeluaran', [PengeluaranController::class, 'store'])->name('pengeluaran.store');
    Route::delete('/pengeluaran/hapus/{id}', [PengeluaranController::class, 'destroy'])->name('pengeluaran.hapus');
    Route::get('/pengeluaran/edit/{id}', [PengeluaranController::class, 'edit'])->name('pengeluaran.edit');
    Route::put('/pengeluaran/update/{id}', [PengeluaranController::class, 'update'])->name('pengeluaran.update');

});
