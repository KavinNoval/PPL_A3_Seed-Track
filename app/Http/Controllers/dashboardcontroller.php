<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User; 
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function indexAdmin()
    {

        $stok_kg = 1200; 
        $total_stok = $stok_kg / 1000;

        $estimasi_gabah = 1860;
        
        $total_penjualan = 27450000; 
        $total_piutang = 5750000; 

        return view('dashboard-admin', [
            'total_stok' => $total_stok,
            'estimasi_gabah' => $estimasi_gabah,
            'total_penjualan' => $total_penjualan,
            'total_piutang' => $total_piutang,
        ]);
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
        $mitra = DB::table('data_mitra')->get(); 
        return view('datamitra', compact('mitra'));
    }

    public function dataKios()
    {
        $kios = DB::table('data_kios')->get(); 
        return view('datakios', compact('kios'));
    }

    public function createStaf() { return view('tambahstaf'); }

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
        return redirect()->route('data.staf')->with('success', 'Data Staf berhasil ditambahkan');
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
        return redirect()->route('data.staf')->with('success', 'Data staf telah berhasil diubah!');
    }

    public function createMitra() {
        $pelanggan = DB::table('data_pelanggan')->get(); 
        return view('tambahmitra', compact('pelanggan')); 
    }

    public function storeMitra(Request $request)
    {
        $request->validate([
            'nama_mitra'     => 'required',
            'no_telp'        => 'required',
            'jalan_lahan'    => 'required',
            'blok_sawah'     => 'required',
            'est_benih'      => 'required|numeric',
            'est_jmlh_panen' => 'required|numeric',
            'luas_lahan'     => 'required|numeric',
            'tgl_bergabung'  => 'required|date',
        ]);

        DB::table('data_mitra')->insert([
            'nama_mitra'     => $request->nama_mitra,
            'no_telp'        => $request->no_telp,
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
        return view('editmitra', compact('mitra'));
    }

    public function updateMitra(Request $request, $id)
    {
        DB::table('data_mitra')->where('id_mitra', $id)->update([
            'nama_mitra' => $request->nama_mitra,
            'no_telp' => $request->no_telp,
            'jalan_lahan' => $request->jalan_lahan,
            'blok_sawah' => $request->blok_sawah,
            'est_benih' => $request->est_benih,
            'est_jmlh_panen' => $request->est_jmlh_panen,
            'luas_lahan' => $request->luas_lahan,
            'tgl_bergabung' => $request->tgl_bergabung,
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

    public function createKios()
    {
        return view('tambahkios');
    }

    public function storeKios(Request $request)
    {
        DB::table('data_kios')->insert([
            'nama_kios' => $request->nama_kios,
            'nama_pemilik' => $request->nama_pemilik,
            'no_telp' => $request->no_telp,
            'alamat_kios' => $request->alamat_kios,
            'NIB' => $request->NIB,
        ]);

        if (Auth::user()->role == 'Staff Gudang') {
            return redirect()->route('kios.gudang')->with('success', 'Data kios berhasil ditambahkan');
        }

        return redirect()->route('data.kios')->with('success', 'Data kios berhasil ditambahkan');
    }

    public function editKios($id)
    {
        $kios = DB::table('data_kios')->where('id_kios', $id)->first();
        return view('editkios', compact('kios'));
    }

    public function updateKios(Request $request, $id)
    {
        DB::table('data_kios')->where('id_kios', $id)->update([
            'id_kelurahan' => $request->id_kelurahan,
            'nama_kios'    => $request->nama_kios,
            'nama_pemilik' => $request->nama_pemilik,
            'no_telp'      => $request->no_telp,
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
}

