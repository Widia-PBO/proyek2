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
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $role = Auth::user()->role;

            if ($role == 'admin') {
                return redirect()->intended('/admin/dashboard');
            } elseif ($role == 'petugas') {
                return redirect()->intended('/petugas/dashboard');
            } elseif ($role == 'pedagang') {
                return redirect()->intended('/pedagang/dashboard');
            }
        }

        return back()->with('loginError', 'Username atau Password salah!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}