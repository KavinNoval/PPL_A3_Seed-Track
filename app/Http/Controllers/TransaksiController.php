<?php

namespace App\Http\Controllers;

use App\Models\Kios;
use App\Models\Mitra;
use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    // ==========================================
    // TAMPILAN ADMIN
    // ==========================================
    public function tampilTransaksiAdmin(Request $request)
    {
        $query = Transaksi::with(['mitra', 'kios', 'detailTransaksi.produk']);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('tipe_pelanggan', 'like', '%'.$search.'%')
                ->orWhereHas('mitra', function ($q) use ($search) {
                    $q->where('nama_mitra', 'like', '%'.$search.'%');
                })
                ->orWhereHas('kios', function ($q) use ($search) {
                    $q->where('nama_kios', 'like', '%'.$search.'%')
                      ->orWhere('nama_pemilik', 'like', '%'.$search.'%'); // <-- Tambahan search
                });
        }

        $transaksis = $query->orderBy('tgl_transaksi', 'desc')->get();

        return view('transaksi-admin', compact('transaksis'));
    }

    // ==========================================
    // TAMPILAN STAF GUDANG
    // ==========================================
    public function tampilTransaksiStaf(Request $request)
    {
        $query = Transaksi::with(['mitra', 'kios', 'detailTransaksi.produk']);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('tipe_pelanggan', 'like', '%'.$search.'%')
                ->orWhereHas('mitra', function ($q) use ($search) {
                    $q->where('nama_mitra', 'like', '%'.$search.'%');
                })
                ->orWhereHas('kios', function ($q) use ($search) {
                    $q->where('nama_kios', 'like', '%'.$search.'%')
                      ->orWhere('nama_pemilik', 'like', '%'.$search.'%'); // <-- Tambahan search
                });
        }

        $transaksis = $query->orderBy('tgl_transaksi', 'desc')->get();

        return view('transaksi-gudang', compact('transaksis'));
    }

    // ==============================================
    // BUKA HALAMAN TAMBAH TRANSAKSI
    // ==============================================
    public function create()
    {
        $produks = Produk::all();
        return view('tambah-transaksi', compact('produks'));
    }

    // ==============================================
    // PROSES SIMPAN DATA TRANSAKSI
    // ==============================================
    public function store(Request $request)
    {
        $request->validate([
            'tgl_transaksi' => 'required|date',
            'tipe_pelanggan' => 'required',
            'nomor_telepon' => 'required',
            'total_tagihan' => 'required',
            'total_bayar' => 'required',
            'status_bayar' => 'required',
            'produk' => 'required|array',
            'jmlh_beli' => 'required|array',
        ]);

        $tipe = $request->tipe_pelanggan;
        $id_pembeli_fix = null;

        DB::beginTransaction();

        try {
            // JURUS DETEKTIF: Bersihin nomor telepon dari karakter aneh
            $no_telp_bersih = preg_replace('/[^0-9]/', '', $request->nomor_telepon);

            // Buang angka 0 atau 62 di depan biar sama kyak di database
            if (substr($no_telp_bersih, 0, 1) === '0') {
                $no_telp_bersih = substr($no_telp_bersih, 1);
            } elseif (substr($no_telp_bersih, 0, 2) === '62') {
                $no_telp_bersih = substr($no_telp_bersih, 2);
            }

            // Nyari ID Pelanggan (Bisa nemu pake Nama Toko ATAU Nama Pemilik ATAU Nomor Telepon)
            if ($tipe == 'Mitra') {
                $mitra = Mitra::where('nama_mitra', 'LIKE', '%' . $request->nama_pelanggan . '%')
                              ->orWhere('no_telp', 'LIKE', '%' . $no_telp_bersih . '%')
                              ->first();
                if (! $mitra) {
                    throw new \Exception('Data Mitra dengan nama/nomor tersebut tidak ditemukan di database');
                }
                $id_pembeli_fix = $mitra->id_mitra;
            } else {
                $kios = Kios::where('nama_kios', 'LIKE', '%' . $request->nama_pelanggan . '%')
                            ->orWhere('nama_pemilik', 'LIKE', '%' . $request->nama_pelanggan . '%') // <-- INI OBATNYA BOSKU!
                            ->orWhere('no_telp', 'LIKE', '%' . $no_telp_bersih . '%')
                            ->first();
                if (! $kios) {
                    throw new \Exception('Data Kios dengan nama/nomor tersebut tidak ditemukan di database');
                }
                $id_pembeli_fix = $kios->id_kios;
            }

            // Insert Transaksi Master
            $id_transaksi = DB::table('data_transaksi')->insertGetId([
                'id_akun' => Auth::id() ?? 1,
                'id_pelanggan' => $id_pembeli_fix,
                'tgl_transaksi' => $request->tgl_transaksi,
                'tipe_pelanggan' => $tipe,
                'total_tagihan' => $request->total_tagihan,
                'total_bayar' => $request->total_bayar,
                'jumlah_hutang' => $request->jumlah_hutang ?? 0,
                'status_bayar' => $request->status_bayar,
            ]);

            // Insert Detail Produk
            $detailData = [];
            foreach ($request->produk as $key => $id_produk) {
                if ($id_produk != null) {
                    $qty = $request->jmlh_beli[$key];

                    $detailData[] = [
                        'id_transaksi' => $id_transaksi,
                        'id_produk' => $id_produk,
                        'jmlh_beli' => $qty,
                        'harga_satuan' => $request->harga_satuan[$key],
                        'subtotal' => $request->subtotal[$key],
                    ];

                    // ==== INI JURUS NGURANGIN STOKNYA BROK ====
                    DB::table('data_produk')
                        ->where('id_produk', $id_produk)
                        ->decrement('stok', $qty);
                }
            }
            DB::table('detail_transaksi')->insert($detailData);

            DB::commit();

            // LOGIKA REDIRECT PINTAR
            $user = Auth::user();
            if ($user && ($user->role == 'Staff Gudang' || $user->role == 'Staf Gudang')) {
                return redirect()->route('transaksi.staf')->with('success', 'Data transaksi berhasil ditambahkan');
            } else {
                return redirect()->route('transaksi.index')->with('success', 'Data transaksi berhasil ditambahkan');
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    // ==============================================
    // HAPUS TRANSAKSI
    // ==============================================
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            // 1. Panggil transaksi pake Model (Biar Soft Delete jalan)
            $transaksi = Transaksi::findOrFail($id);

            // 2. Ambil detail belanjaan
            $detail_belanjaan = DB::table('detail_transaksi')->where('id_transaksi', $id)->get();

            // 3. Balikin stoknya ke gudang satu per satu
            foreach ($detail_belanjaan as $barang) {
                DB::table('data_produk')
                    ->where('id_produk', $barang->id_produk)
                    ->increment('stok', $barang->jmlh_beli);
            }

            $transaksi->delete();

            DB::commit();

            return redirect()->back()->with('success', 'Data transaksi berhasil dihapus');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Waduh gagal hapus boy: '.$e->getMessage());
        }
    }

    // ==============================================
    // BUKA HALAMAN EDIT TRANSAKSI
    // ==============================================
    public function edit($id)
    {
        $transaksi = Transaksi::with(['mitra', 'kios', 'detailTransaksi.produk'])->findOrFail($id);
        $produks = Produk::all();

        if ($transaksi->tipe_pelanggan == 'Mitra') {
            $transaksi->nama_pelanggan = $transaksi->mitra ? $transaksi->mitra->nama_mitra : '';
            $transaksi->no_telp = $transaksi->mitra ? $transaksi->mitra->no_telp : '';
        } else {
            // Coba ambil nama kios, kalau kosong ambil nama pemiliknya
            $transaksi->nama_pelanggan = $transaksi->kios ? ($transaksi->kios->nama_kios ?? $transaksi->kios->nama_pemilik) : '';
            $transaksi->no_telp = $transaksi->kios ? $transaksi->kios->no_telp : '';
        }

        return view('edittransaksi', compact('transaksi', 'produks'));
    }

    // ==============================================
    // PROSES UPDATE DATA TRANSAKSI & PRODUK
    // ==============================================
    public function update(Request $request, $id)
    {
        $request->validate([
            'tgl_transaksi'  => 'required|date',
            'tipe_pelanggan' => 'required',
            'nama_pelanggan' => 'required|string',
            'no_telp'        => 'required',
            'status_bayar'   => 'required|string',
            'produk'         => 'required|array',
            'jmlh_beli'      => 'required|array',
            'total_bayar_input' => 'required|numeric'
        ]);

        DB::beginTransaction();

        try {
            $transaksi = Transaksi::findOrFail($id);
            $tipe = $request->tipe_pelanggan;
            $id_pembeli_fix = null;

            // 1. KEMBALIKAN STOK LAMA KE GUDANG DULU (Jurus Sakti)
            $oldDetails = DB::table('detail_transaksi')->where('id_transaksi', $id)->get();
            foreach ($oldDetails as $old) {
                DB::table('data_produk')->where('id_produk', $old->id_produk)->increment('stok', $old->jmlh_beli);
            }
            DB::table('detail_transaksi')->where('id_transaksi', $id)->delete();

            // 2. BERSIHIN NOMOR TELEPON
            $no_telp_bersih = preg_replace('/[^0-9]/', '', $request->no_telp);
            if (substr($no_telp_bersih, 0, 1) === '0') {
                $no_telp_bersih = substr($no_telp_bersih, 1);
            } elseif (substr($no_telp_bersih, 0, 2) === '62') {
                $no_telp_bersih = substr($no_telp_bersih, 2);
            }

            // 3. CARI PELANGGAN
            if ($tipe == 'Mitra') {
                $mitra = Mitra::where('nama_mitra', 'LIKE', '%' . $request->nama_pelanggan . '%')
                              ->orWhere('no_telp', 'LIKE', '%' . $no_telp_bersih . '%')->first();
                if (! $mitra) throw new \Exception('Data Mitra tidak ditemukan');
                $id_pembeli_fix = $mitra->id_mitra;
            } else {
                $kios = Kios::where('nama_kios', 'LIKE', '%' . $request->nama_pelanggan . '%')
                            ->orWhere('nama_pemilik', 'LIKE', '%' . $request->nama_pelanggan . '%') // <-- INI OBATNYA BOSKU!
                            ->orWhere('no_telp', 'LIKE', '%' . $no_telp_bersih . '%')->first();
                if (! $kios) throw new \Exception('Data Kios tidak ditemukan');
                $id_pembeli_fix = $kios->id_kios;
            }

            // 4. UPDATE TRANSAKSI MASTER
            $transaksi->update([
                'tgl_transaksi'  => $request->tgl_transaksi,
                'total_tagihan'  => $request->total_bayar_input,
                'total_bayar'    => $request->total_bayar_input,
                'tipe_pelanggan' => $tipe,
                'id_pelanggan'   => $id_pembeli_fix,
                'status_bayar'   => $request->status_bayar,
            ]);

            // 5. INSERT BELANJAAN BARU & KURANGI STOK GUDANG
            $detailData = [];
            foreach ($request->produk as $key => $id_produk) {
                if ($id_produk != null) {
                    $qty = $request->jmlh_beli[$key];
                    $harga_satuan = $request->harga_satuan[$key];
                    $subtotal = $qty * $harga_satuan;

                    $detailData[] = [
                        'id_transaksi' => $id,
                        'id_produk'    => $id_produk,
                        'jmlh_beli'    => $qty,
                        'harga_satuan' => $harga_satuan,
                        'subtotal'     => $subtotal,
                    ];

                    DB::table('data_produk')->where('id_produk', $id_produk)->decrement('stok', $qty);
                }
            }
            DB::table('detail_transaksi')->insert($detailData);

            DB::commit();
            return redirect()->route('transaksi.index')->with('success', 'Data transaksi berhasil diubah');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
