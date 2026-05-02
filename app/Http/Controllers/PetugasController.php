<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pembayaran; 
use App\Models\Kios;
use App\Models\Petugas;
use Carbon\Carbon;

class PetugasController extends Controller
{
    public function dashboard()
    {
        // 1. Ambil data petugas login
        $petugas = Auth::guard('petugas')->user();

        // 2. Data Uang: Total penagihan hari ini
        $total_penagihan_hari_ini = Pembayaran::where('petugas_id', $petugas->id)
            ->whereDate('tanggal_bayar', Carbon::today())
            ->sum('total_bayar');

        // 3. Data Ringkasan: Hitung kios aktif & lunas
        $total_kios_aktif = Kios::where('status', 'Aktif')->count();
        $kios_sudah_bayar = Pembayaran::whereDate('tanggal_bayar', Carbon::today())
            ->distinct('kios_id')
            ->count();
        
        // 4. Data Sisa: Kios belum ditagih
        $kios_belum_ditagih = max(0, $total_kios_aktif - $kios_sudah_bayar);

        // 5. Data Tabel: 5 Aktivitas terakhir
        $aktivitas_terakhir = Pembayaran::with('kios')
            ->where('petugas_id', $petugas->id)
            ->latest()
            ->take(5)
            ->get();

        // Kirim 6 data ke Blade
return view('petugas.dashboard', compact(
    'petugas', 
    'total_penagihan_hari_ini', 
    'total_kios_aktif', // <-- Pastikan ini tertulis benar
    'kios_sudah_bayar', 
    'kios_belum_ditagih', 
    'aktivitas_terakhir'
));
    }

    public function penagihan()
    {
        $petugas = Auth::guard('petugas')->user();
        $semuaKios = Kios::where('status', 'Aktif')->get();
        $tanggalHariIni = date('Y-m-d');
        $kiosSudahBayar = Pembayaran::where('tanggal_bayar', $tanggalHariIni)
            ->pluck('kios_id')->toArray();

        return view('petugas.penagihan', compact('petugas', 'semuaKios', 'kiosSudahBayar'));
    }

    public function prosesBayar(Request $request)
    {
        $petugas = Auth::guard('petugas')->user();

        Pembayaran::create([
            'kios_id' => $request->kios_id,
            'petugas_id' => $petugas->id,
            'tanggal_bayar' => date('Y-m-d'),
            'total_bayar' => 10000,
            'metode_pembayaran' => 'Tunai',
            'status' => 'Lunas'
        ]);

        return redirect()->back()->with('success', 'Iuran kios berhasil dicatat!');
    }

    public function batalkanBayar(Request $request)
    {
        $pembayaran = Pembayaran::where('kios_id', $request->kios_id)
            ->where('tanggal_bayar', date('Y-m-d'))
            ->first();

        if ($pembayaran) {
            $pembayaran->delete();
            return redirect()->back()->with('success', 'Pembayaran berhasil dibatalkan.');
        }

        return redirect()->back()->with('error', 'Data pembayaran tidak ditemukan.');
    }
}