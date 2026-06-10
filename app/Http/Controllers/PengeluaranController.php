<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengeluaran;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PengeluaranController extends Controller
{
    // ==========================================
    // 1. HALAMAN PENGELUARAN ADMIN (DAFTAR)
    // ==========================================
    public function index()
    {
        // Ambil data dengan Pagination
        $pengeluarans = Pengeluaran::query()
            ->orderBy('tgl_pengeluaran', 'desc')
            ->paginate(10);

        // Mapping Kategori
        foreach ($pengeluarans as $p) {
            $kategoriMap = [1 => 'Operasional Kantor', 2 => 'Distribusi', 3 => 'Pembelian Aset'];
            $p->kategori = $kategoriMap[$p->id_akun] ?? 'Lainnya';
        }

        return view('pengeluaranadmin', compact('pengeluarans'));
    }

    // ==========================================
    // 2. HALAMAN PENGELUARAN STAF GUDANG
    // ==========================================
    public function indexGudang()
    {
        // Ambil data dengan Pagination buat Staf
        $pengeluarans = Pengeluaran::query()
            ->orderBy('tgl_pengeluaran', 'desc')
            ->paginate(10);

        // Mapping Kategori
        foreach ($pengeluarans as $p) {
            $kategoriMap = [1 => 'Operasional Kantor', 2 => 'Distribusi', 3 => 'Pembelian Aset'];
            $p->kategori = $kategoriMap[$p->id_akun] ?? 'Lainnya';
        }

        return view('pengeluarangudang', compact('pengeluarans'));
    }

    // ==========================================
    // 3. PROSES SIMPAN PENGELUARAN
    // ==========================================
    public function store(Request $request)
    {
        $request->validate([
            'tgl_pengeluaran'  => 'required|date',
            'nama_pengeluaran' => 'required|string|max:255',
            'id_akun'          => 'required|integer',
            'nominal'          => 'required|numeric',
            'bukti_nota'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('bukti_nota')) {
            $file = $request->file('bukti_nota');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('foto_pengeluaran'), $namaFile);
            $data['bukti_nota'] = $namaFile;
        }

        Pengeluaran::create($data);

        // Logika Redirect: Staf balik ke staf, Admin balik ke admin
        if (Auth::check() && (Auth::user()->role == 'Staff Gudang' || Auth::user()->role == 'Staf Gudang')) {
            return redirect()->route('pengeluaran.gudang')->with('success', 'Data pengeluaran berhasil ditambahkan!');
        }

        return redirect()->route('pengeluaran.index')->with('success', 'Data pengeluaran berhasil ditambahkan!');
    }

    // ==========================================
    // 4. BUKA HALAMAN EDIT
    // ==========================================
    public function edit($id)
    {
        $pengeluaran = Pengeluaran::findOrFail($id);
        return view('editpengeluaran', compact('pengeluaran'));
    }

    // ==========================================
    // 5. PROSES UPDATE (ADMIN ONLY)
    // ==========================================
    public function update(Request $request, $id)
    {
        $request->validate([
            'tgl_pengeluaran'  => 'required|date',
            'nama_pengeluaran' => 'required|string|max:255',
            'id_akun'          => 'required|integer',
            'nominal'          => 'required|numeric',
            'bukti_nota'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $p = Pengeluaran::findOrFail($id);
        $data = $request->except(['bukti_nota']);

        // Kalau ada file baru, hapus yang lama dulu
        if ($request->hasFile('bukti_nota')) {
            if ($p->bukti_nota && file_exists(public_path('foto_pengeluaran/' . $p->bukti_nota))) {
                unlink(public_path('foto_pengeluaran/' . $p->bukti_nota));
            }

            $file = $request->file('bukti_nota');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('foto_pengeluaran'), $namaFile);
            $data['bukti_nota'] = $namaFile;
        }

        $p->update($data);

        return redirect()->route('pengeluaran.index')->with('success', 'Data pengeluaran berhasil diubah!');
    }
}
