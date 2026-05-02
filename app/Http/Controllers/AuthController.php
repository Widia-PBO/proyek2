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
        // Validasi Input
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // 1. CEK KAMAR ADMIN (Tabel users via Guard web default)
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/admin/dashboard');
        } 
        
        // 2. CEK KAMAR PETUGAS (Tabel petugas via Guard petugas)
        // Kita juga tambahkan syarat bahwa statusnya harus 'Aktif' agar bisa login
        elseif (Auth::guard('petugas')->attempt(['username' => $request->username, 'password' => $request->password, 'status' => 'Aktif'])) {
            $request->session()->regenerate();
            return redirect()->intended('/petugas/dashboard');
        }

        // Jika salah semua atau status tidak aktif
        return back()->with('loginError', 'Username, Password salah, atau Akun Non Aktif!');
    }

    public function logout(Request $request)
    {
        // Logout dari semua guard
        if(Auth::guard('petugas')->check()){
            Auth::guard('petugas')->logout();
        } else {
            Auth::logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}