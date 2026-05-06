<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kios;
use App\Models\Pedagang;
use App\Models\Petugas;
use App\Models\Pembayaran; // Pastikan menggunakan Pembayaran agar sinkron dengan Petugas[cite: 15, 16]
use Carbon\Carbon;     
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // 1. DASHBOARD
    public function dashboard()
    {
        $total_kios = Kios::count();
        $kios_aktif = Kios::where('status', 'Aktif')->count();
        $total_petugas = Petugas::count();
        
        // Mengambil data dari tabel yang sama dengan petugas
        $pemasukan_hari_ini = Pembayaran::whereDate('tanggal_bayar', Carbon::today())->sum('total_bayar');
        $sudah_bayar_hari_ini = Pembayaran::whereDate('tanggal_bayar', Carbon::today())->count();

        $label_hari = [];
        $data_pemasukan = [];
        for ($i = 6; $i >= 0; $i--) {
            $tanggal = Carbon::today()->subDays($i);
            $label_hari[] = $tanggal->translatedFormat('d M');
            $data_pemasukan[] = Pembayaran::whereDate('tanggal_bayar', $tanggal)->sum('total_bayar');
        }

        return view('admin.dashboard', compact(
            'total_kios', 'kios_aktif', 'pemasukan_hari_ini', 'sudah_bayar_hari_ini', 'label_hari', 'data_pemasukan'
        ));
    }

    // 2. KELOLA DATA KIOS & PEDAGANG
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

    public function storeKios(Request $request)
    {
        $request->validate([
            'no_kios' => 'required|unique:kios,no_kios',
            'username' => 'required|unique:pedagangs,username',
        ]);

        DB::beginTransaction();
        try {
            $kios = Kios::create([
                'no_kios' => $request->no_kios,
                'blok' => $request->blok,
                'nama_usaha' => $request->nama_usaha,
                'nama_pedagang' => $request->nama_pedagang,
                'jenis_usaha' => $request->jenis_usaha,
                'status' => 'Aktif',
            ]);

            Pedagang::create([
                'kios_id' => $kios->id,
                'username' => $request->username,
                'password' => Hash::make('pedagang123'),
                'nama_pemilik' => $request->nama_pedagang,
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Kios Berhasil Dibuat!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function updateKios(Request $request, $id)
    {
        Kios::findOrFail($id)->update($request->only(['no_kios', 'nama_usaha', 'nama_pedagang', 'jenis_usaha', 'status']));
        return back()->with('success', 'Data Kios Diperbarui!');
    }

    public function destroyKios($id)
    {
        Kios::findOrFail($id)->delete(); 
        return back()->with('success', 'Kios Dihapus!');
    }

    public function resetPasswordKios($id)
    {
        $kios = Kios::with('pedagang')->findOrFail($id);
        if ($kios->pedagang) {
            $kios->pedagang->update(['password' => Hash::make('pedagang123')]);
            return back()->with('success', 'Password Reset!');
        }
        return back()->with('error', 'Akun tidak ditemukan!');
    }

    // 3. KELOLA DATA PETUGAS
    public function storePetugas(Request $request)
    {
        Petugas::create([
            'id_petugas' => $request->id_petugas,
            'nama_petugas' => $request->nama_petugas,
            'username' => $request->username,
            'password' => Hash::make('petugas123'),
            'wilayah_tugas' => $request->wilayah_tugas,
            'kontak' => $request->kontak,
            'status' => 'Aktif',
        ]);
        return back()->with('success', 'Petugas Ditambahkan!');
    }

    public function updatePetugas(Request $request, $id) 
    {
        Petugas::findOrFail($id)->update($request->all());
        return back()->with('success', 'Data Petugas Diupdate!');
    }

    public function destroyPetugas($id) 
    {
        Petugas::findOrFail($id)->delete();
        return back()->with('success', 'Petugas Dihapus!');
    }

    public function resetPasswordPetugas($id) 
    {
        Petugas::findOrFail($id)->update(['password' => Hash::make('petugas123')]);
        return back()->with('success', 'Password Petugas Direset!');
    }

    // 4. IURAN & LAPORAN
   public function kelolaIuran()
{
    // Load relasi kios dan petugas agar nama muncul di tabel
    $iuran = Pembayaran::with(['kios', 'petugas'])->latest()->get(); 
    
    // Ambil tarif saat ini untuk ditampilkan di tombol
    $tarif = \DB::table('settings')->where('key', 'tarif_iuran')->value('value') ?? 10000;
    
    $total_iuran = $iuran->sum('total_bayar');
    $sudah_bayar = Pembayaran::whereDate('tanggal_bayar', Carbon::today())->count();
    $total_kios_aktif = Kios::where('status', 'Aktif')->count();
    $belum_bayar = max(0, $total_kios_aktif - $sudah_bayar);

    return view('admin.kelola_iuran', compact('iuran', 'total_iuran', 'sudah_bayar', 'belum_bayar', 'tarif'));
}

// Fungsi BARU untuk mengatur nominal iuran
public function updateTarif(Request $request)
{
    \DB::table('settings')->updateOrInsert(
        ['key' => 'tarif_iuran'],
        ['value' => $request->nominal, 'updated_at' => now()]
    );
    return back()->with('success', 'Tarif iuran berhasil diperbarui!');
}

 public function laporan(Request $request)
{
    $tgl_mulai = $request->tgl_mulai ?? Carbon::now()->startOfMonth()->format('Y-m-d');
    $tgl_selesai = $request->tgl_selesai ?? Carbon::now()->endOfMonth()->format('Y-m-d');

    // Ambil data iuran
    $iuran = Pembayaran::with(['kios', 'petugas'])
        ->whereBetween('tanggal_bayar', [$tgl_mulai, $tgl_selesai])
        ->orderBy('tanggal_bayar', 'desc')->get();

    // Data Ringkasan Laporan
    $total_kios = \App\Models\Kios::where('status', 'Aktif')->count();
    $sudah_bayar = $iuran->unique('kios_id')->count();
    $total_pemasukan = $iuran->sum('total_bayar');

    return view('admin.laporan', compact(
        'iuran', 'tgl_mulai', 'tgl_selesai', 'total_kios', 'sudah_bayar', 'total_pemasukan'
    ));
}

    // 5. PROFIL
    public function profil() 
    {
        return view('admin.profil', ['user' => Auth::user()]);
    }

    public function updateProfil(Request $request) 
    {
        $user = Auth::user();
        $data = $request->only(['name', 'username', 'email', 'whatsapp']);

        if ($request->hasFile('foto')) {
            if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }
            $data['foto'] = $request->file('foto')->store('profil', 'public');
        }

        $user->update($data);
        return back()->with('success', 'Profil Diperbarui!');
    }
}