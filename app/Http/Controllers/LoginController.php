<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        #cek udah terdaftar apa engga
        $user = User::where('username', $request->username)->first();

        if (!$user) {
            return back()->with('error', 'Akun belum terdaftar!');
        }

        if ($user->password !== $request->password) {
            return back()->with('error', 'Password salah!');
        }
        Auth::login($user);
        
        if ($user->role == 'Admin') {
            return redirect()->route('dashboard.admin');
        } elseif ($user->role == 'Staff Gudang' || $user->role == 'Staf Gudang') {
            return redirect()->route('dashboard.gudang');
        } elseif ($user->role == 'Staff Lapang' || $user->role == 'Staf Lapang') {
            return redirect()->route('dashboard.lapang');
        }
        return redirect()->route('dashboard.admin');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login');
    }
}