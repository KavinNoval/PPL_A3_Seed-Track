<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // ==========================================
    // 1. DASHBOARD INDEX ADMIN
    // ==========================================
    public function indexAdmin(Request $request)
    {
        // 1. Tangkap Request Filter
        $bulanIni = $request->has('bulan') ? $request->bulan : date('m');
        $tahunIni = $request->has('tahun') ? $request->tahun : date('Y');

        // 2. Siapin Query Dasar
        $qPenjualan = DB::table('data_transaksi');
        $qPiutang = DB::table('data_transaksi');
        $qPengeluaran = DB::table('data_pengeluaran');

        // 3. Terapin Filter SECARA DINAMIS
        if (!empty($bulanIni)) {
            $qPenjualan->whereMonth('tgl_transaksi', $bulanIni);
            $qPiutang->whereMonth('tgl_transaksi', $bulanIni);
            $qPengeluaran->whereMonth('tgl_pengeluaran', $bulanIni);
        }

        if (!empty($tahunIni)) {
            $qPenjualan->whereYear('tgl_transaksi', $tahunIni);
            $qPiutang->whereYear('tgl_transaksi', $tahunIni);
            $qPengeluaran->whereYear('tgl_pengeluaran', $tahunIni);
        }

        // 4. Eksekusi Total Berdasarkan Filter
        $total_penjualan = $qPenjualan->sum('total_tagihan') ?? 0;
        $total_piutang = $qPiutang->sum('jumlah_hutang') ?? 0;
        $total_pengeluaran = $qPengeluaran->sum('nominal') ?? 0;

        // 5. Hitung Tren (Hanya kalau Bulan & Tahun spesifik dipilih)
        $trend_penjualan = 0;
        $trend_piutang = 0;

        if (!empty($bulanIni) && !empty($tahunIni)) {
            $tanggalPilihan = $tahunIni . '-' . $bulanIni . '-01';
            $bulanLalu = date('m', strtotime('-1 month', strtotime($tanggalPilihan)));
            $tahunLalu = date('Y', strtotime('-1 month', strtotime($tanggalPilihan)));

            $penjualan_lalu = DB::table('data_transaksi')->whereMonth('tgl_transaksi', $bulanLalu)->whereYear('tgl_transaksi', $tahunLalu)->sum('total_tagihan') ?? 0;
            $piutang_lalu = DB::table('data_transaksi')->whereMonth('tgl_transaksi', $bulanLalu)->whereYear('tgl_transaksi', $tahunLalu)->sum('jumlah_hutang') ?? 0;

            $trend_penjualan = $penjualan_lalu > 0 ? (($total_penjualan - $penjualan_lalu) / $penjualan_lalu) * 100 : 0;
            $trend_piutang = $piutang_lalu > 0 ? (($total_piutang - $piutang_lalu) / $piutang_lalu) * 100 : 0;
        }

        // 6. SISANYA (Stok, Gabah, Kategori Pengeluaran)
        $stok_kg = DB::table('data_produk')->sum('stok') ?? 0;
        $total_stok = $stok_kg / 1000; // Konversi ke Ton
        $trend_stok = 0;

        $estimasi_gabah_1_bulan = DB::table('data_mitra')->sum('est_jmlh_panen') ?? 0;
        $estimasi_gabah_2_minggu = $estimasi_gabah_1_bulan * 0.5;

        $jumlah_stok_menipis = DB::table('data_produk')->where('stok', '<', 100)->count();
        $produkKritis = \App\Models\Produk::where('stok', '<', 100)->get();

        // Hitung persentase pengeluaran yang udah difilter
        $pembagiPengeluaran = $total_pengeluaran > 0 ? $total_pengeluaran : 1;

        $totalDistribusi = (clone $qPengeluaran)->where('id_akun', 2)->sum('nominal') ?? 0;
        $totalOperasional = (clone $qPengeluaran)->where('id_akun', 1)->sum('nominal') ?? 0;
        $totalAset = (clone $qPengeluaran)->where('id_akun', 3)->sum('nominal') ?? 0;

        $persenDistribusi = round(($totalDistribusi / $pembagiPengeluaran) * 100);
        $persenOperasional = round(($totalOperasional / $pembagiPengeluaran) * 100);
        $persenAset = round(($totalAset / $pembagiPengeluaran) * 100);

        return view('dashboard-admin', compact(
            'total_penjualan', 'trend_penjualan',
            'total_piutang', 'trend_piutang',
            'total_stok', 'trend_stok',
            'estimasi_gabah_1_bulan', 'estimasi_gabah_2_minggu',
            'jumlah_stok_menipis',
            'produkKritis',
            'total_pengeluaran',
            'totalDistribusi', 'persenDistribusi',
            'totalOperasional', 'persenOperasional',
            'totalAset', 'persenAset'
        ));
    }


    // ==========================================
    // 2. DATA STAF
    // ==========================================
    public function dataStaf()
    {
        $staf = User::all();
        return view('datastaf', compact('staf'));
    }

    public function createStaf() { return view('tambahstaf'); }

    public function storeStaf(Request $request)
    {
        $request->validate([
            'username'     => 'required',
            'password'     => 'required',
            'nama_lengkap' => 'required',
            'no_telp'      => 'required|numeric|digits_between:10,15',
            'role'         => 'required',
            'status'       => 'required',
        ], [
            'no_telp.numeric'        => 'Nomor telepon hanya boleh berisi angka.',
            'no_telp.digits_between' => 'Nomor telepon harus antara 10 hingga 15 digit.'
        ]);

        $user = new User();
        $user->username = $request->username;
        $user->password = $request->password;
        $user->nama_lengkap = $request->nama_lengkap;
        $user->no_telp = $request->no_telp;
        $user->role = $request->role;
        $user->status = $request->status;
        $user->save();

        return redirect()->route('data.staf')->with('success', 'Data Staf berhasil ditambahkan');
    }

    public function editStaf($id)
    {
        $staf = User::find($id);
        return view('editstaf', compact('staf'));
    }

    public function updateStaf(Request $request, $id)
    {
        $request->validate([
            'username'     => 'required',
            'nama_lengkap' => 'required',
            'no_telp'      => 'required|numeric|digits_between:10,15',
            'role'         => 'required',
            'status'       => 'required',
        ], [
            'no_telp.numeric'        => 'Nomor telepon hanya boleh berisi angka.',
            'no_telp.digits_between' => 'Nomor telepon harus antara 10 hingga 15 digit.'
        ]);

        $user = User::find($id);
        $user->username = $request->username;
        if($request->password) {
            $user->password = $request->password;
        }
        $user->nama_lengkap = $request->nama_lengkap;
        $user->no_telp = $request->no_telp;
        $user->role = $request->role;
        $user->status = $request->status;
        $user->save();

        return redirect()->route('data.staf')->with('success', 'Data staf telah berhasil diubah!');
    }


    // ==========================================
    // 3. DATA MITRA
    // ==========================================
    public function dataMitra()
    {
        $mitra = DB::table('data_mitra')
            ->leftJoin('kabupaten', 'data_mitra.id_kabupaten', '=', 'kabupaten.id_kabupaten')
            ->leftJoin('kecamatan', 'data_mitra.id_kecamatan', '=', 'kecamatan.id_kecamatan')
            ->leftJoin('kelurahan', 'data_mitra.id_kelurahan', '=', 'kelurahan.id_kelurahan')
            ->select('data_mitra.*', 'kabupaten.kabupaten', 'kecamatan.kecamatan', 'kelurahan.kelurahan')
            ->get();

        return view('datamitra', compact('mitra'));
    }

    public function createMitra() {
        $pelanggan = DB::table('data_pelanggan')->get();
        $kabupatens = DB::table('kabupaten')->get();
        return view('tambahmitra', compact('pelanggan', 'kabupatens'));
    }

    public function storeMitra(Request $request)
    {
        $request->validate([
            'nama_mitra'     => 'required',
            'no_telp'        => 'required|numeric|digits_between:10,15',
            'id_kabupaten'   => 'required',
            'id_kecamatan'   => 'required',
            'id_kelurahan'   => 'required',
            'jalan_lahan'    => 'required',
            'blok_sawah'     => 'required',
            'est_benih'      => 'required|numeric',
            'est_jmlh_panen' => 'required|numeric',
            'luas_lahan'     => 'required|numeric',
            'tgl_bergabung'  => 'required|date',
        ], [
            'no_telp.numeric'        => 'Nomor telepon hanya boleh berisi angka.',
            'no_telp.digits_between' => 'Nomor telepon harus antara 10 hingga 15 digit.'
        ]);

        DB::table('data_mitra')->insert([
            'nama_mitra'     => $request->nama_mitra,
            'no_telp'        => $request->no_telp,
            'id_kabupaten'   => $request->id_kabupaten,
            'id_kecamatan'   => $request->id_kecamatan,
            'id_kelurahan'   => $request->id_kelurahan,
            'jalan_lahan'    => $request->jalan_lahan,
            'blok_sawah'     => $request->blok_sawah,
            'est_benih'      => $request->est_benih,
            'est_jmlh_panen' => $request->est_jmlh_panen,
            'luas_lahan'     => $request->luas_lahan,
            'tgl_bergabung'  => $request->tgl_bergabung,
        ]);

        if (Auth::user()->role == 'Staff Lapang') {
            return redirect()->route('mitra.lapang')->with('success', 'Data Mitra berhasil ditambahkan');
        }
        return redirect()->route('data.mitra')->with('success', 'Data Mitra berhasil ditambahkan');
    }

    public function editMitra($id)
    {
        $mitra = DB::table('data_mitra')->where('id_mitra', $id)->first();
        $kabupatens = DB::table('kabupaten')->get();
        return view('editmitra', compact('mitra', 'kabupatens'));
    }

    public function updateMitra(Request $request, $id)
    {
        $request->validate([
            'nama_mitra'     => 'required',
            'no_telp'        => 'required|numeric|digits_between:10,15',
            'id_kabupaten'   => 'required',
            'id_kecamatan'   => 'required',
            'id_kelurahan'   => 'required',
            'jalan_lahan'    => 'required',
            'blok_sawah'     => 'required',
            'est_benih'      => 'required|numeric',
            'est_jmlh_panen' => 'required|numeric',
            'luas_lahan'     => 'required|numeric',
            'tgl_bergabung'  => 'required|date',
        ], [
            'no_telp.numeric'        => 'Nomor telepon hanya boleh berisi angka.',
            'no_telp.digits_between' => 'Nomor telepon harus antara 10 hingga 15 digit.'
        ]);

        DB::table('data_mitra')->where('id_mitra', $id)->update([
            'nama_mitra'     => $request->nama_mitra,
            'no_telp'        => $request->no_telp,
            'id_kabupaten'   => $request->id_kabupaten,
            'id_kecamatan'   => $request->id_kecamatan,
            'id_kelurahan'   => $request->id_kelurahan,
            'jalan_lahan'    => $request->jalan_lahan,
            'blok_sawah'     => $request->blok_sawah,
            'est_benih'      => $request->est_benih,
            'est_jmlh_panen' => $request->est_jmlh_panen,
            'luas_lahan'     => $request->luas_lahan,
            'tgl_bergabung'  => $request->tgl_bergabung,
        ]);

        if (Auth::user()->role == 'Staff Lapang') {
            return redirect()->route('mitra.lapang')->with('success', 'Data Mitra telah berhasil diubah');
        }
        return redirect()->route('data.mitra')->with('success', 'Data Mitra telah berhasil diubah');
    }

    public function batalMitra(Request $request)
    {
        $role = Auth::user()->role;
        $status = $request->query('status', 'batal');

        if ($role == 'Admin') {
            return redirect()->route('data.mitra', ['status' => $status]);
        } elseif ($role == 'Staff Lapang') {
            return redirect()->route('mitra.lapang', ['status' => $status]);
        }
        return redirect()->back();
    }


    // =======================================================
    // API KHUSUS WILAYAH (AJAX) - JANGAN DIHAPUS
    // =======================================================
    public function getKecamatan($id_kabupaten)
    {
        $kecamatans = DB::table('kecamatan')->where('id_kabupaten', $id_kabupaten)->get();
        return response()->json($kecamatans);
    }

    public function getKelurahan($id_kecamatan)
    {
        $kelurahans = DB::table('kelurahan')->where('id_kecamatan', $id_kecamatan)->get();
        return response()->json($kelurahans);
    }


    // ==========================================
    // 4. DATA KIOS
    // ==========================================
    public function dataKios()
    {
        $kios = DB::table('data_kios')
            ->leftJoin('kabupaten', 'data_kios.id_kabupaten', '=', 'kabupaten.id_kabupaten')
            ->leftJoin('kecamatan', 'data_kios.id_kecamatan', '=', 'kecamatan.id_kecamatan')
            ->leftJoin('kelurahan', 'data_kios.id_kelurahan', '=', 'kelurahan.id_kelurahan')
            ->select('data_kios.*', 'kabupaten.kabupaten', 'kecamatan.kecamatan', 'kelurahan.kelurahan')
            ->get();

        return view('datakios', compact('kios'));
    }

    public function createKios()
    {
        $kabupatens = DB::table('kabupaten')->get();
        return view('tambahkios', compact('kabupatens'));
    }

    public function storeKios(Request $request)
    {
        $request->validate([
            'nama_kios'    => 'required',
            'nama_pemilik' => 'required',
            'no_telp'      => 'required|numeric|digits_between:10,15',
            'id_kabupaten' => 'required',
            'id_kecamatan' => 'required',
            'id_kelurahan' => 'required',
            'alamat_kios'  => 'required',
            'NIB'          => 'required',
        ], [
            'no_telp.numeric'        => 'Nomor telepon hanya boleh berisi angka.',
            'no_telp.digits_between' => 'Nomor telepon harus antara 10 hingga 15 digit.'
        ]);

        DB::table('data_kios')->insert([
            'nama_kios'    => $request->nama_kios,
            'nama_pemilik' => $request->nama_pemilik,
            'no_telp'      => $request->no_telp,
            'id_kabupaten' => $request->id_kabupaten,
            'id_kecamatan' => $request->id_kecamatan,
            'id_kelurahan' => $request->id_kelurahan,
            'alamat_kios'  => $request->alamat_kios,
            'NIB'          => $request->NIB,
        ]);

        if (Auth::user()->role == 'Staff Gudang') {
            return redirect()->route('kios.gudang')->with('success', 'Data kios berhasil ditambahkan');
        }

        return redirect()->route('data.kios')->with('success', 'Data kios berhasil ditambahkan');
    }

    public function editKios($id)
    {
        $kios = DB::table('data_kios')->where('id_kios', $id)->first();
        $kabupatens = DB::table('kabupaten')->get();
        return view('editkios', compact('kios', 'kabupatens'));
    }

    public function updateKios(Request $request, $id)
    {
        $request->validate([
            'nama_kios'    => 'required',
            'nama_pemilik' => 'required',
            'no_telp'      => 'required|numeric|digits_between:10,15',
            'id_kabupaten' => 'required',
            'id_kecamatan' => 'required',
            'id_kelurahan' => 'required',
            'alamat_kios'  => 'required',
            'NIB'          => 'required',
        ], [
            'no_telp.numeric'        => 'Nomor telepon hanya boleh berisi angka.',
            'no_telp.digits_between' => 'Nomor telepon harus antara 10 hingga 15 digit.'
        ]);

        DB::table('data_kios')->where('id_kios', $id)->update([
            'nama_kios'    => $request->nama_kios,
            'nama_pemilik' => $request->nama_pemilik,
            'no_telp'      => $request->no_telp,
            'id_kabupaten' => $request->id_kabupaten,
            'id_kecamatan' => $request->id_kecamatan,
            'id_kelurahan' => $request->id_kelurahan,
            'alamat_kios'  => $request->alamat_kios,
            'NIB'          => $request->NIB,
        ]);

        if (Auth::user()->role == 'Staff Gudang') {
            return redirect()->route('kios.gudang')->with('success', 'Data Kios berhasil diubah');
        }

        return redirect()->route('data.kios')->with('success', 'Data Kios berhasil diubah');
    }

    public function batalKios(Request $request)
    {
        $role = Auth::user()->role;
        $status = $request->query('status', 'batal');

        if ($role == 'Admin') {
            return redirect()->route('data.kios', ['status' => $status]);
        } elseif ($role == 'Staff Gudang') {
            return redirect()->route('kios.gudang', ['status' => $status]);
        }

        return redirect()->back();
    }


    // ==========================================
    // 5. DASHBOARD GUDANG
    // ==========================================
    public function indexGudang(Request $request)
    {
        // 1. Tangkap Request Filter
        $bulanIni = $request->has('bulan') ? $request->bulan : date('m');
        $tahunIni = $request->has('tahun') ? $request->tahun : date('Y');

        // 2. Siapin Query Dasar
        $qPenjualan = DB::table('data_transaksi');
        $qPiutang = DB::table('data_transaksi');
        $qPengeluaran = DB::table('data_pengeluaran');

        // 3. Terapin Filter SECARA DINAMIS
        if (!empty($bulanIni)) {
            $qPenjualan->whereMonth('tgl_transaksi', $bulanIni);
            $qPiutang->whereMonth('tgl_transaksi', $bulanIni);
            $qPengeluaran->whereMonth('tgl_pengeluaran', $bulanIni);
        }

        if (!empty($tahunIni)) {
            $qPenjualan->whereYear('tgl_transaksi', $tahunIni);
            $qPiutang->whereYear('tgl_transaksi', $tahunIni);
            $qPengeluaran->whereYear('tgl_pengeluaran', $tahunIni);
        }

        // 4. Eksekusi Total Berdasarkan Filter
        $total_penjualan = $qPenjualan->sum('total_tagihan') ?? 0;
        $total_piutang = $qPiutang->sum('jumlah_hutang') ?? 0;
        $total_pengeluaran = $qPengeluaran->sum('nominal') ?? 0;

        // 5. Hitung Tren (Hanya kalau Bulan & Tahun spesifik dipilih)
        $trend_penjualan = 0;
        $trend_piutang = 0;

        if (!empty($bulanIni) && !empty($tahunIni)) {
            $tanggalPilihan = $tahunIni . '-' . $bulanIni . '-01';
            $bulanLalu = date('m', strtotime('-1 month', strtotime($tanggalPilihan)));
            $tahunLalu = date('Y', strtotime('-1 month', strtotime($tanggalPilihan)));

            $penjualan_lalu = DB::table('data_transaksi')->whereMonth('tgl_transaksi', $bulanLalu)->whereYear('tgl_transaksi', $tahunLalu)->sum('total_tagihan') ?? 0;
            $piutang_lalu = DB::table('data_transaksi')->whereMonth('tgl_transaksi', $bulanLalu)->whereYear('tgl_transaksi', $tahunLalu)->sum('jumlah_hutang') ?? 0;

            $trend_penjualan = $penjualan_lalu > 0 ? (($total_penjualan - $penjualan_lalu) / $penjualan_lalu) * 100 : 0;
            $trend_piutang = $piutang_lalu > 0 ? (($total_piutang - $piutang_lalu) / $piutang_lalu) * 100 : 0;
        }

        // 6. SISANYA (Stok, Gabah, Kategori Pengeluaran)
        $stok_kg = DB::table('data_produk')->sum('stok') ?? 0;
        $total_stok = $stok_kg / 1000; // Konversi ke Ton
        $trend_stok = 0;

        $estimasi_gabah_1_bulan = DB::table('data_mitra')->sum('est_jmlh_panen') ?? 0;
        $estimasi_gabah_2_minggu = $estimasi_gabah_1_bulan * 0.5;

        $jumlah_stok_menipis = DB::table('data_produk')->where('stok', '<', 100)->count();
        $produkKritis = \App\Models\Produk::where('stok', '<', 100)->get();

        // Hitung persentase pengeluaran yang udah difilter
        $pembagiPengeluaran = $total_pengeluaran > 0 ? $total_pengeluaran : 1;

        $totalDistribusi = (clone $qPengeluaran)->where('id_akun', 2)->sum('nominal') ?? 0;
        $totalOperasional = (clone $qPengeluaran)->where('id_akun', 1)->sum('nominal') ?? 0;
        $totalAset = (clone $qPengeluaran)->where('id_akun', 3)->sum('nominal') ?? 0;

        $persenDistribusi = round(($totalDistribusi / $pembagiPengeluaran) * 100);
        $persenOperasional = round(($totalOperasional / $pembagiPengeluaran) * 100);
        $persenAset = round(($totalAset / $pembagiPengeluaran) * 100);

        return view('dashboard-gudang', compact(
            'total_penjualan', 'trend_penjualan',
            'total_piutang', 'trend_piutang',
            'total_stok', 'trend_stok',
            'estimasi_gabah_1_bulan', 'estimasi_gabah_2_minggu',
            'jumlah_stok_menipis',
            'produkKritis',
            'total_pengeluaran',
            'totalDistribusi', 'persenDistribusi',
            'totalOperasional', 'persenOperasional',
            'totalAset', 'persenAset'
        ));
    }

    public function kiosGudang()
    {
        $kios = DB::table('data_kios')
            ->leftJoin('kabupaten', 'data_kios.id_kabupaten', '=', 'kabupaten.id_kabupaten')
            ->leftJoin('kecamatan', 'data_kios.id_kecamatan', '=', 'kecamatan.id_kecamatan')
            ->leftJoin('kelurahan', 'data_kios.id_kelurahan', '=', 'kelurahan.id_kelurahan')
            ->select('data_kios.*', 'kabupaten.kabupaten', 'kecamatan.kecamatan', 'kelurahan.kelurahan')
            ->get();

        return view('datakios-gudang', compact('kios'));
    }
}
