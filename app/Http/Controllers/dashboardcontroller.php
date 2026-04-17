<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
public function indexAdmin()
{
    // jumlahkan berat_gabah dibagi 1000 buat dapet satuan Ton
    $stok_kg = DB::table('data_monitoring')->sum('berat_gabah');
    $total_stok = $stok_kg / 1000;

    // Ambil Estimasi Gabah
    $estimasi_gabah = DB::table('data_monitoring')->where('status', 'proses')->sum('berat_gabah');

    // Ambil data penjualan dan piutang
    $total_penjualan = DB::table('transaksi')->where('jenis', 'penjualan')->sum('total_harga') ?? 0;
    $total_piutang = DB::table('transaksi')->where('status_bayar', 'belum_lunas')->sum('sisa_bayar') ?? 0;

    // Kirim semua variabel ke view dashboard-admin
    return view('dashboard-admin', [
        'total_penjualan' => $total_penjualan,
        'total_piutang' => $total_piutang,
        'total_stok' => $total_stok,
        'estimasi_gabah' => $estimasi_gabah
    ]);
}
}