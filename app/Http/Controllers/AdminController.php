<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kios;
use App\Models\Petugas;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // =================================================================
    // 1. FUNGSI MENAMPILKAN HALAMAN (Yang tadi sempat hilang)
    // =================================================================
    public function dataKios()
    {
        $kios = Kios::all();
        $petugas = Petugas::all();

        $total_kios = Kios::count();
        $kios_aktif = Kios::where('status', 'Aktif')->count();
        $kios_nonaktif = Kios::where('status', 'Non Aktif')->count();
        $total_petugas = Petugas::count();

        return view('admin.data_kios', compact(
            'kios', 'petugas', 'total_kios', 'kios_aktif', 'kios_nonaktif', 'total_petugas'
        ));
    }

    // =================================================================
    // 2. FUNGSI TAMBAH DATA KIOS
    // =================================================================
    public function storeKios(Request $request)
    {
        Kios::create([
            'no_kios' => $request->no_kios,
            'nama_usaha' => $request->nama_usaha,
            'jenis_usaha' => $request->jenis_usaha,
            'nama_pemilik' => $request->nama_pemilik,
            'blok' => $request->blok,
            'username' => $request->username,
            'password' => Hash::make('toko123'), // Default password
            'status' => 'Aktif',
        ]);
        return back()->with('success', 'Data Kios berhasil ditambahkan!');
    }

    // =================================================================
    // 3. FUNGSI EDIT DATA KIOS
    // =================================================================
    public function updateKios(Request $request, $id)
    {
        $kios = Kios::findOrFail($id);
        $kios->update([
            'nama_usaha' => $request->nama_usaha,
            'jenis_usaha' => $request->jenis_usaha,
            'username' => $request->username,
            'status' => $request->status,
        ]);
        return back()->with('success', 'Data Kios berhasil diupdate!');
    }

    // =================================================================
    // 4. FUNGSI HAPUS DATA KIOS
    // =================================================================
    public function destroyKios($id)
    {
        $kios = Kios::findOrFail($id);
        $kios->delete();
        return back()->with('success', 'Data Kios berhasil dihapus!');
    }
    // =================================================================
    // 5. FUNGSI RESET PASSWORD KIOS
    // =================================================================
    public function resetPasswordKios($id)
    {
        $kios = Kios::findOrFail($id);
        
        // Timpa password lama dengan password default 'toko123'
        $kios->update([
            'password' => Hash::make('toko123')
        ]);

        return back()->with('success', 'Password ' . $kios->nama_usaha . ' berhasil direset ke default (toko123)!');
    }
}