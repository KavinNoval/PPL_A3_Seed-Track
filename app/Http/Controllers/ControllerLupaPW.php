<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
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
    $request->validate([
        'username' => ['required', 'string', 'exists:data_akun,username'],
        'current_password' => ['required', 'string'],
        'password' => ['required', 'string', 'confirmed'],
    ], [
        'username.exists' => 'Username tidak terdaftar!',
        'password.confirmed' => 'Konfirmasi password baru tidak cocok.'
    ]);

    $user = \DB::table('data_akun')->where('username', $request->username)->first();

    if ($request->current_password != $user->password) {
        return back()->withErrors(['current_password' => 'Password lama salah!']);
    }

    \DB::table('data_akun')
        ->where('username', $request->username)
        ->update(['password' => $request->password]);

    return redirect()->route('login')->with('success', 'Password berhasil diubah');
}
}
