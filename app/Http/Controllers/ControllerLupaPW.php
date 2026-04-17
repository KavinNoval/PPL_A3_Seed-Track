<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ControllerLupaPW extends Controller
{
    public function showResetForm()
    {
        // Pastikan file view kamu ada di folder resources/views/auth/lupapw.blade.php
        return view('lupapw'); 
    }

    public function update(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'username' => ['required', 'string', 'exists:data_akun,username'],
            'password' => ['required', 'string', 'confirmed'],
        ], [
            'username.exists' => 'Username tidak ditemukan di dalam sistem.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.'
        ]);

        // 2. Cari user berdasarkan username
        $user = User::where('username', $request->username)->first();

        // 3. Update password (tanpa hashing)
        $user->password = $request->password;
        $user->save();

        // 4. Balikkan ke halaman login dengan pesan sukses
        return redirect()->route('login')->with('status', 'Password berhasil diubah! Silakan login.');
    }
}