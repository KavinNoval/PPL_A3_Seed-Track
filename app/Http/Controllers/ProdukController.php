<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProdukController extends Controller
{
    // ==========================================
    // 1. Tampil Data Produk (Smart View)
    // ==========================================
    public function index()
    {
        $produk = DB::table('data_produk')->orderBy('id_produk', 'desc')->get();

        $user = Auth::user();

        if ($user && ($user->role == 'Staff Gudang' || $user->role == 'Staf Gudang')) {
            return view('produk-gudang', compact('produk'));
        } else {
            return view('produk-admin', compact('produk'));
        }
    }

    // 2. Tampil Form Tambah
    public function create()
    {
        return view('tambah-produk');
    }

    // 3. Proses Simpan Produk Baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required',
            'stok'        => 'required|numeric',
            'deskripsi'   => 'required',
            'keunggulan'  => 'required',
            'harga_jual'  => 'required',
            'foto_produk' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $input = $request->except(['_token']);
        $input['id_akun'] = Auth::user()->id_akun ?? Auth::id();

        if ($request->hasFile('foto_produk')) {
            $file = $request->file('foto_produk');
            $nama_file = time() . "_" . $file->getClientOriginalName();
            $file->move(public_path('foto_produk'), $nama_file);
            $input['foto_produk'] = $nama_file;
        }

        DB::table('data_produk')->insert($input);

        $user = Auth::user();
        if ($user && ($user->role == 'Staff Gudang' || $user->role == 'Staf Gudang')) {
            return redirect()->route('produk.staf')->with('success', 'Data produk berhasil ditambahkan');
        } else {
            return redirect()->route('produk.admin')->with('success', 'Data produk berhasil ditambahkan');
        }
    }

    // ==========================================
    // 4. Tampil Form Edit (1 View Untuk Semua)
    // ==========================================
    public function edit($id)
    {
        $produk = DB::table('data_produk')->where('id_produk', $id)->first();

        if (!$produk) {
            $user = Auth::user();
            if ($user && ($user->role == 'Staff Gudang' || $user->role == 'Staf Gudang')) {
                return redirect()->route('produk.staf')->with('error', 'Data tidak ditemukan!');
            } else {
                return redirect()->route('produk.admin')->with('error', 'Data tidak ditemukan!');
            }
        }

        // KITA PAKE 1 VIEW AJA, KARENA DI HTML-NYA UDAH KITA ATUR PAKE BLADE @if
        return view('ubah-produk', compact('produk'));
    }

    // ==========================================
    // 5. Proses Update Data (Satpam Backend!)
    // ==========================================
    public function update(Request $request, $id)
    {
        $user = Auth::user();

        // JIKA YANG LOGIN STAFF GUDANG: Cuma terima STOK doang
        if ($user && ($user->role == 'Staff Gudang' || $user->role == 'Staf Gudang')) {
            $request->validate([
                'stok' => 'required|numeric',
            ]);

            DB::table('data_produk')->where('id_produk', $id)->update([
                'stok' => $request->stok,
            ]);

            return redirect()->route('produk.staf')->with('success', 'Stok produk berhasil diubah ');
        }

        // JIKA YANG LOGIN ADMIN: Terima dan update semua data
        else {
            $request->validate([
                'nama_produk' => 'required',
                'stok'        => 'required|numeric',
                'deskripsi'   => 'required',
                'keunggulan'  => 'required',
                'harga_jual'  => 'required',
                'foto_produk' => 'image|mimes:jpeg,png,jpg|max:2048',
            ]);

            $input = $request->except(['_token', '_method', 'foto_produk']);
            $input['id_akun'] = $user->id_akun ?? Auth::id();

            if ($request->hasFile('foto_produk')) {
                $file = $request->file('foto_produk');
                $nama_file = time() . "_" . $file->getClientOriginalName();
                $file->move(public_path('foto_produk'), $nama_file);
                $input['foto_produk'] = $nama_file;
            }

            DB::table('data_produk')->where('id_produk', $id)->update($input);

            return redirect()->route('produk.admin')->with('success', 'Data produk berhasil diubah');
        }
    }

    // ==========================================
    // 6. Fungsi Cancel (Batal)
    // ==========================================
    public function cancel($konteks)
    {
        $pesan = ($konteks == 'tambah') ? 'Data produk batal disimpan' : 'Data produk batal diubah';

        $user = Auth::user();
        if ($user && ($user->role == 'Staff Gudang' || $user->role == 'Staf Gudang')) {
            return redirect()->route('produk.staf')->with('cancel', $pesan);
        } else {
            return redirect()->route('produk.admin')->with('cancel', $pesan);
        }
    }
}
