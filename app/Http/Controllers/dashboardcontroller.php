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
    public function indexAdmin()
    {
        $bulanIni = date('m');
        $tahunIni = date('Y');
        $bulanLalu = date('m', strtotime('-1 month'));
        $tahunLalu = date('Y', strtotime('-1 month'));

        // ==========================================
        // 1. TOTAL PENJUALAN & TREN
        // ==========================================
        $total_penjualan = DB::table('data_transaksi')
            ->whereMonth('tgl_transaksi', $bulanIni)->whereYear('tgl_transaksi', $tahunIni)
            ->sum('total_tagihan') ?? 0;

        $penjualan_lalu = DB::table('data_transaksi')
            ->whereMonth('tgl_transaksi', $bulanLalu)->whereYear('tgl_transaksi', $tahunLalu)
            ->sum('total_tagihan') ?? 0;

        $trend_penjualan = $penjualan_lalu > 0 ? (($total_penjualan - $penjualan_lalu) / $penjualan_lalu) * 100 : 0;

        // ==========================================
        // 2. TOTAL PIUTANG & TREN
        // ==========================================
        $total_piutang = DB::table('data_transaksi')
            ->whereMonth('tgl_transaksi', $bulanIni)->whereYear('tgl_transaksi', $tahunIni)
            ->sum('jumlah_hutang') ?? 0;

        $piutang_lalu = DB::table('data_transaksi')
            ->whereMonth('tgl_transaksi', $bulanLalu)->whereYear('tgl_transaksi', $tahunLalu)
            ->sum('jumlah_hutang') ?? 0;

        $trend_piutang = $piutang_lalu > 0 ? (($total_piutang - $piutang_lalu) / $piutang_lalu) * 100 : 0;

        // ==========================================
        // 3. SISA STOK
        // ==========================================
        $stok_kg = DB::table('data_produk')->sum('stok') ?? 0;
        $total_stok = $stok_kg / 1000; // Konversi ke Ton
        $trend_stok = 0;

        // ==========================================
        // 4. ESTIMASI BERAT GABAH
        // ==========================================
        $estimasi_gabah_1_bulan = DB::table('data_mitra')->sum('est_jmlh_panen') ?? 0;
        $estimasi_gabah_2_minggu = $estimasi_gabah_1_bulan * 0.5;

        // ==========================================
        // 5. STOK MENIPIS (Fitur Baru)
        // ==========================================
        $jumlah_stok_menipis = DB::table('data_produk')->where('stok', '<', 100)->count();
        $produkKritis = \App\Models\Produk::where('stok', '<', 100)->get();

        // ==========================================
        // 6. REKAP PENGELUARAN
        // ==========================================
        $total_pengeluaran = DB::table('data_pengeluaran')
            ->whereMonth('tgl_pengeluaran', $bulanIni)
            ->whereYear('tgl_pengeluaran', $tahunIni)
            ->sum('nominal') ?? 0;

        $totalSemuaPengeluaran = DB::table('data_pengeluaran')->sum('nominal') ?? 0;
        $pembagiPengeluaran = $totalSemuaPengeluaran > 0 ? $totalSemuaPengeluaran : 1;

        // Ambil nominal masing-masing kategori
        $totalDistribusi = DB::table('data_pengeluaran')->where('id_akun', 2)->sum('nominal') ?? 0;
        $totalOperasional = DB::table('data_pengeluaran')->where('id_akun', 1)->sum('nominal') ?? 0;
        $totalAset = DB::table('data_pengeluaran')->where('id_akun', 3)->sum('nominal') ?? 0;

        // Hitung persentase
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

    // 2. Data Staf
    public function dataStaf()
    {
        $staf = User::all();
        return view('datastaf', compact('staf'));
    }

    // 3. Data Mitra
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

    public function createStaf() { return view('tambahstaf'); }

    public function storeStaf(Request $request)
    {
        // Validasi inputan Staf
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
        // Validasi edit Staf
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

    // =======================================================
    // BAGIAN DATA MITRA & DROPDOWN WILAYAH (UPDATE)
    // =======================================================

    public function createMitra() {
        $pelanggan = DB::table('data_pelanggan')->get();
        // Tarik data kabupaten dari database biar muncul di dropdown
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
        // Tarik data kabupaten buat halaman edit
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
    // =======================================================


    // ==========================================
    // 4. DATA KIOS
    // ==========================================
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

    public function indexGudang() { return view('dashboard-gudang'); }

    // ==========================================
    // 👇👇👇 TAMBAHAN FUNGSI KIOS GUDANG 👇👇👇
    // ==========================================
    public function kiosGudang()
    {
        // Query ini pakai leftJoin biar wilayahnya ikut keambil, persis kayak Admin
        $kios = DB::table('data_kios')
            ->leftJoin('kabupaten', 'data_kios.id_kabupaten', '=', 'kabupaten.id_kabupaten')
            ->leftJoin('kecamatan', 'data_kios.id_kecamatan', '=', 'kecamatan.id_kecamatan')
            ->leftJoin('kelurahan', 'data_kios.id_kelurahan', '=', 'kelurahan.id_kelurahan')
            ->select('data_kios.*', 'kabupaten.kabupaten', 'kecamatan.kecamatan', 'kelurahan.kelurahan')
            ->get();

        // Asumsi nama view file blade kios lu buat gudang adalah 'kiosgudang'
        return view('kiosgudang', compact('kios'));
    }
}
