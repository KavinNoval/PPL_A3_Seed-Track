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

        $user = User::where('username', $request->username)
                    ->where('password', $request->password)
                    ->first();

        if ($user) {
            Auth::login($user);
            if ($user->role == 'Admin') {
                return redirect()->route('dashboard.admin');
            } elseif ($user->role == 'Staff Gudang' || $user->role == 'Staf Gudang') {
                return redirect()->route('dashboard.gudang');
            } elseif ($user->role == 'Staff Lapang' || $user->role == 'Staf Lapang') {
                return redirect()->route('dashboard.lapang');
            }

            // Default
            return redirect()->route('dashboard.admin');
        }

        return back()->with('error', 'Username atau Password salah brok!');
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login');
    }
}