<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Menampilkan halaman form login.
     */
    public function showLoginForm()
    {
        return view('login');
    }

    /**
     * Memproses data login dan cek role.
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required'],
        ]);

        $user = User::where('username', $request->username)->first();

        // Pengecekan tanpa hashing
        if ($user && $user->password === $request->password) {
            Auth::login($user);
            $request->session()->regenerate();

            // Pengecekan Role 
            $role = strtolower($user->role); // Jadikan huruf kecil untuk pencocokan

            if ($role === 'admin') {
                return redirect()->intended('/dashboard-admin');
            } elseif ($role === 'staf lapang') {
                return redirect()->intended('/dashboard-lapang');
            } elseif ($role === 'staf gudang') {
                return redirect()->intended('/dashboard-gudang');
            } else {
                // Default kalau role tidak ada/tidak cocok
                return redirect()->intended('/dashboard');
            }
        }

        return back()->withErrors([
            'username' => 'Username atau password yang Anda masukkan salah.',
        ])->onlyInput('username');
    }

    // logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}