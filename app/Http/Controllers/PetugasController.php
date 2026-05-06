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
    
    // Ambil tarif iuran terbaru dari database (default 10000 jika belum ada)
    $tarif = \DB::table('settings')->where('key', 'tarif_iuran')->value('value') ?? 10000;

    Pembayaran::create([
        'kios_id' => $request->kios_id,
        'petugas_id' => $petugas->id,
        'tanggal_bayar' => date('Y-m-d'),
        'total_bayar' => $tarif, // Ambil dari pengaturan Admin
        'metode_pembayaran' => 'Tunai', // Karena ditagih petugas, pasti Tunai
        'status' => 'Lunas'
    ]);

    return redirect()->back()->with('success', 'Iuran kios berhasil dicatat!');
}
// app/Http/Controllers/PetugasController.php

public function riwayatSetoran()
{
    $petugas = Auth::guard('petugas')->user(); //
    $today = date('Y-m-d');

    // 1. Total Iuran Hari Ini (Nominal yang siap disetor)
    $total_setoran = Pembayaran::where('petugas_id', $petugas->id)
        ->where('tanggal_bayar', $today)
        ->sum('total_bayar');

    // 2. Ringkasan Tugas (Statistik)
    $total_kios_aktif = Kios::where('status', 'Aktif')->count();
    $kios_lunas = Pembayaran::where('tanggal_bayar', $today)
        ->where('petugas_id', $petugas->id)
        ->count();
    $kios_belum_ditagih = max(0, $total_kios_aktif - $kios_lunas);
    
    // Hitung persentase progres
    $persentase = ($total_kios_aktif > 0) ? round(($kios_lunas / $total_kios_aktif) * 100) : 0;

    // 3. Daftar Riwayat Penagihan Tunai Hari Ini
    $riwayat = Pembayaran::with('kios')
        ->where('petugas_id', $petugas->id)
        ->where('tanggal_bayar', $today)
        ->latest()
        ->get();

    return view('petugas.riwayat_setoran', compact(
        'petugas', 
        'total_setoran', 
        'total_kios_aktif', 
        'kios_lunas', 
        'kios_belum_ditagih', 
        'persentase',
        'riwayat'
    ));
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
    // Tambahkan di dalam class PetugasController
// ... kode fungsi lainnya ...

    public function profil() 
    {
        return view('petugas.profil_petugas', [
            'user' => Auth::guard('petugas')->user()
        ]);
    }

    public function updateProfil(Request $request)
    {
        $user = Auth::guard('petugas')->user();
        
        $request->validate([
            'nama_petugas' => 'required|string|max:255',
            'kontak' => 'required',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $data = $request->only(['nama_petugas', 'kontak']);

        if ($request->hasFile('foto')) {
            if ($user->foto && \Storage::disk('public')->exists($user->foto)) {
                \Storage::disk('public')->delete($user->foto);
            }
            $data['foto'] = $request->file('foto')->store('profil_petugas', 'public');
        }

        $user->update($data);
        return back()->with('success', 'Profil Anda berhasil diperbarui!');
    }
} 
