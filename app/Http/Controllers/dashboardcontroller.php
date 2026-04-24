<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User; 
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // 1. Fungsi Dashboard Admin Utama
    public function indexAdmin()
    {
        $stok_kg = DB::table('data_monitoring')->sum('berat_gabah');
        $total_stok = $stok_kg / 1000;
        $estimasi_gabah = DB::table('data_monitoring')->where('status', 'proses')->sum('berat_gabah');
        $total_penjualan = DB::table('transaksi')->where('jenis', 'penjualan')->sum('total_harga') ?? 0;
        $total_piutang = DB::table('transaksi')->where('status_bayar', 'belum_lunas')->sum('sisa_bayar') ?? 0;

        return view('dashboard-admin', [
            'total_penjualan' => $total_penjualan,
            'total_piutang' => $total_piutang,
            'total_stok' => $total_stok,
            'estimasi_gabah' => $estimasi_gabah
        ]);
    }

    // 2. Fungsi Data Staf
    public function dataStaf()
    {
        $staf = User::all();
        return view('datastaf', compact('staf'));
    }

    // 3. Fungsi Data Mitra
    public function dataMitra()
    {
        $mitra = DB::table('data_mitra')->get(); 
        return view('datamitra', compact('mitra'));
    }

    // 4. Fungsi Data Kios
    public function dataKios()
    {
        $kios = DB::table('data_kios')->get(); 
        return view('datakios', compact('kios'));
    }

    // 5. Fungsi Tambah dan Edit Staf
    public function createStaf()
    {
        return view('tambahstaf');
    }

    public function storeStaf(Request $request)
    {
        $user = new User();
        $user->username = $request->username;
        $user->password = $request->password;
        $user->nama_lengkap = $request->nama_lengkap;
        $user->no_telp = $request->no_telp;
        $user->role = $request->role; 
        $user->status = $request->status;
        $user->save();

        return redirect()->route('data.staf');
    }

    public function editStaf($id)
    {
        $staf = User::find($id);
        return view('editstaf', compact('staf'));
    }

    public function updateStaf(Request $request, $id)
    {
        $user = User::find($id);
        $user->username = $request->username;
        $user->password = $request->password;
        $user->nama_lengkap = $request->nama_lengkap;
        $user->no_telp = $request->no_telp;
        $user->role = $request->role;
        $user->status = $request->status;
        $user->save();

        return redirect()->route('data.staf');
    }

    // 6. Fungsi Tambah dan Edit Mitra
    public function createMitra()
    {
        return view('tambahmitra');
    }

    public function storeMitra(Request $request)
    {
        DB::table('data_mitra')->insert([
            'id_kelurahan' => $request->id_kelurahan,
            'nama_mitra' => $request->nama_mitra,
            'no_telp' => $request->no_telp,
            'jalan_lahan' => $request->jalan_lahan,
            'blok_sawah' => $request->blok_sawah,
            'est_benih' => $request->est_benih,
            'est_jmlh_panen' => $request->est_jmlh_panen,
            'luas_lahan' => $request->luas_lahan,
            'tgl_bergabung' => $request->tgl_bergabung,
        ]);
        if (Auth::user()->role == 'Staff Lapang' || Auth::user()->role == 'Staff Lapang') {
            return redirect()->route('mitra.lapang');
        }
        return redirect()->route('data.mitra');
    }

    public function editMitra($id)
    {
        $mitra = DB::table('data_mitra')->where('id_pelanggan', $id)->first();
        return view('editmitra', compact('mitra'));
    }

    public function updateMitra(Request $request, $id)
    {
        DB::table('data_mitra')->where('id_pelanggan', $id)->update([
            'id_kelurahan' => $request->id_kelurahan,
            'nama_mitra' => $request->nama_mitra,
            'no_telp' => $request->no_telp,
            'jalan_lahan' => $request->jalan_lahan,
            'blok_sawah' => $request->blok_sawah,
            'est_benih' => $request->est_benih,
            'est_jmlh_panen' => $request->est_jmlh_panen,
            'luas_lahan' => $request->luas_lahan,
            'tgl_bergabung' => $request->tgl_bergabung,
        ]);
        if (Auth::user()->role == 'Staff Lapang' || Auth::user()->role == 'Staff Lapang') {
            return redirect()->route('mitra.lapang');
        }
        return redirect()->route('data.mitra');
    }

    public function createKios()
    {
        return view('tambahkios');
    }

    public function storeKios(Request $request)
    {
        DB::table('data_kios')->insert([
            'id_kelurahan' => $request->id_kelurahan,
            'nama_kios' => $request->nama_kios,
            'nama_pemilik' => $request->nama_pemilik,
            'no_telp' => $request->no_telp,
            'alamat_kios' => $request->alamat_kios,
            'NIB' => $request->NIB,
        ]);

        if (Auth::user()->role == 'Staf Gudang' || Auth::user()->role == 'Staff Gudang') {
            return redirect()->route('kios.gudang');
        }

        return redirect()->route('data.kios');
    }

    public function editKios($id)
    {
        $kios = DB::table('data_kios')->where('id_pelanggan', $id)->first();
        return view('editkios', compact('kios'));
    }

    public function updateKios(Request $request, $id)
    {
        DB::table('data_kios')->where('id_pelanggan', $id)->update([
            'id_kelurahan' => $request->id_kelurahan,
            'nama_kios' => $request->nama_kios,
            'nama_pemilik' => $request->nama_pemilik,
            'no_telp' => $request->no_telp,
            'alamat_kios' => $request->alamat_kios,
            'NIB' => $request->NIB,
        ]);

        if (Auth::user()->role == 'Staf Gudang' || Auth::user()->role == 'Staff Gudang') {
            return redirect()->route('kios.gudang');
        }

        return redirect()->route('data.kios');
    }
    public function indexGudang()
    {
        return view('dashboard-gudang');
    }
}