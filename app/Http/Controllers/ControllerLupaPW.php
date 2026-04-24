<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ControllerLupaPW extends Controller
{
    public function showResetForm()
    {
        return view('lupapw'); 
    }

    public function update(Request $request)
    {
        // validasi input
        $request->validate([
            'username' => ['required', 'string', 'exists:data_akun,username'],
            'password' => ['required', 'string', 'confirmed'],
        ], [
            'username.exists' => 'Username tidak ditemukan di dalam sistem.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.'
        ]);

        // cari user
        $user = User::where('username', $request->username)->first();

        // update
        $user->password = $request->password;
        $user->save();

        // balik ke login
        return redirect()->route('login')->with('status', 'Password berhasil diubah! Silakan login.');
    }
}