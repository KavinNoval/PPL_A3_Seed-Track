<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\ProfilPerusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; // Buat ngurusin hapus file logo lama

class LandingPageController extends Controller
{
    // ==========================================
    // 1. TAMPILAN LANDING PAGE PUBLIK (Pelanggan)
    // ==========================================
    public function index()
    {
        $profil = ProfilPerusahaan::query()->first();
        $produks = Produk::all();

        return view('landing', compact('profil', 'produks'));
    }

    // ==========================================
    // 2. TAMPILAN PROFIL ADMIN (Yang Kartu Ijo-Putih)
    // ==========================================
    public function profilAdmin()
    {
        $profil = ProfilPerusahaan::query()->first();
        return view('profil-admin', compact('profil'));
    }

    // ==========================================
    // 3. TAMPILAN FORM EDIT PROFIL (Halaman Baru)
    // ==========================================
    public function editProfil()
    {
        $profil = ProfilPerusahaan::query()->first();
        return view('edit-profil-admin', compact('profil'));
    }

    // ==========================================
    // 4. FUNGSI SIMPAN EDIT PROFIL
    // ==========================================
    public function updateProfil(Request $request)
    {
        $profil = ProfilPerusahaan::query()->first() ?? new ProfilPerusahaan();

        // Menyimpan data dasar (Disesuaikan sama nama kolom di tabel lu)
        $profil->nama_perusahaan = $request->nama_perusahaan;
        $profil->deskripsi       = $request->deskripsi_singkat;
        $profil->visi            = $request->visi;
        $profil->misi            = $request->misi;
        $profil->no_telp         = $request->telepon;
        $profil->email_resmi     = $request->email;
        $profil->alamat_kantor   = $request->alamat;

        // Menyimpan link sosmed
        $profil->url_instagram   = $request->url_instagram;
        $profil->url_youtube     = $request->url_youtube;
        $profil->url_tiktok      = $request->url_tiktok;

        // Logika upload logo baru
        if ($request->hasFile('logo_perusahaan')) {
            // Hapus logo lama
            if ($profil->logo && File::exists(public_path('images/' . $profil->logo))) {
                File::delete(public_path('images/' . $profil->logo));
            }

            // Simpan logo baru
            $file = $request->file('logo_perusahaan');
            $nama_file = time() . "_" . $file->getClientOriginalName();
            $file->move(public_path('images'), $nama_file);

            $profil->logo = $nama_file;
        }

        // Kalau misalnya tabel lu butuh id_akun (karena di phpMyAdmin ga boleh NULL), isi default aja sementara:
        if(!$profil->id_akun) {
             $profil->id_akun = 1;
        }

        $profil->save();

        return redirect()->route('profil.perusahaan')->with('success', 'Data profil berhasil diperbarui!');
    }
}
