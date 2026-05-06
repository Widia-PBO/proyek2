<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // 1. CEK SEBAGAI ADMIN (Tabel Users)[cite: 13]
        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/admin/dashboard');
        } 
        
        // 2. CEK SEBAGAI PETUGAS (Tabel Petugas)[cite: 13]
        // Menambahkan syarat status harus 'Aktif' agar bisa masuk[cite: 13]
        if (Auth::guard('petugas')->attempt(['username' => $request->username, 'password' => $request->password, 'status' => 'Aktif'])) {
            $request->session()->regenerate();
            return redirect()->intended('/petugas/dashboard');
        }

        // 3. CEK SEBAGAI PEDAGANG (Tabel Pedagangs)
        if (Auth::guard('pedagang')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/pedagang/dashboard');
        }

        // Jika tidak terdaftar di manapun[cite: 13]
        return back()->with('loginError', 'Username, Password salah, atau Akun Non Aktif!');
    }

    public function logout(Request $request)
    {
        // Keluar dari semua kemungkinan guard[cite: 13]
        Auth::guard('web')->logout();
        Auth::guard('petugas')->logout();
        Auth::guard('pedagang')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}