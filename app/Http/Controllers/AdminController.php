<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kios;
use App\Models\Petugas;
use App\Models\Pedagang; 
use App\Models\Iuran; 
use Carbon\Carbon;     
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // =================================================================
    // 1. HALAMAN UTAMA KELOLA DATA
    // =================================================================
    public function dataKios()
    {
        $kios = Kios::with('pedagang')->get(); 
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
    // 2. KELOLA KIOS & PEDAGANG (RELASIONAL)
    // =================================================================
    public function storeKios(Request $request)
    {
        // 1. Buat/Update akun pedagang
        $pedagang = Pedagang::updateOrCreate(
            ['username' => $request->username], 
            [
                'nama_pemilik' => $request->nama_pemilik,
                'password' => Hash::make('pedagang123'), 
                'whatsapp' => $request->whatsapp,
            ]
        );

        // 2. Buat data kios yang tersambung ke pedagang_id
        Kios::create([
            'pedagang_id' => $pedagang->id, 
            'no_kios' => $request->no_kios,
            'nama_usaha' => $request->nama_usaha,
            'jenis_usaha' => $request->jenis_usaha,
            'blok' => $request->blok,
            'status' => 'Aktif',
        ]);

        return back()->with('success', 'Data Kios & Pedagang berhasil disinkronkan!');
    }

    public function updateKios(Request $request, $id)
    {
        $kios = Kios::with('pedagang')->findOrFail($id);
        
        // Update data Kios
        $kios->update([
            'nama_usaha' => $request->nama_usaha,
            'jenis_usaha' => $request->jenis_usaha,
            'status' => $request->status,
        ]);

        // Update data Pedagang melalui relasi
        if ($kios->pedagang) {
            $kios->pedagang->update([
                'nama_pemilik' => $request->nama_pemilik,
                'username' => $request->username,
            ]);
        }

        return back()->with('success', 'Data Kios & Pemilik berhasil diperbarui!');
    }

    public function destroyKios($id)
    {
        $kios = Kios::findOrFail($id);
        $kios->delete(); 
        return back()->with('success', 'Data Kios berhasil dihapus!');
    }

    public function resetPasswordKios($id)
    {
        $kios = Kios::with('pedagang')->findOrFail($id);
        
        if ($kios->pedagang) {
            $kios->pedagang->update([
                'password' => Hash::make('pedagang123')
            ]);
            return back()->with('success', 'Password ' . $kios->pedagang->nama_pemilik . ' direset ke pedagang123!');
        }

        return back()->with('error', 'Data pedagang tidak ditemukan!');
    }

    // =================================================================
    // 3. KELOLA DATA PETUGAS
    // =================================================================
    public function storePetugas(Request $request)
    {
        $request->validate([
            'id_petugas' => 'required|unique:petugas,id_petugas',
            'username' => 'required|unique:petugas,username',
        ]);

        Petugas::create([
            'id_petugas' => $request->id_petugas,
            'nama_petugas' => $request->nama_petugas,
            'username' => $request->username,
            'password' => Hash::make('petugas123'),
            'wilayah_tugas' => $request->wilayah_tugas,
            'kontak' => $request->kontak,
            'status' => 'Aktif',
        ]);

        return back()->with('success', 'Petugas ' . $request->nama_petugas . ' berhasil ditambahkan!');
    }

    public function updatePetugas(Request $request, $id) 
    {
        $petugas = Petugas::findOrFail($id);
        $petugas->update($request->all());
        return back()->with('success', 'Data Petugas berhasil diupdate!');
    }

    public function destroyPetugas($id) 
    {
        Petugas::findOrFail($id)->delete();
        return back()->with('success', 'Data Petugas berhasil dihapus!');
    }

    public function resetPasswordPetugas($id) 
    {
        Petugas::findOrFail($id)->update(['password' => Hash::make('petugas123')]);
        return back()->with('success', 'Password Petugas berhasil direset ke petugas123!');
    }

    // =================================================================
    // 4. IURAN, LAPORAN & DASHBOARD
    // =================================================================
    public function kelolaIuran()
    {
        $hari_ini = Carbon::today();
        $iuran = Iuran::with(['kios.pedagang', 'petugas'])->whereDate('tgl_bayar', $hari_ini)->get();
        
        $total_iuran = $iuran->sum('nominal');
        $sudah_bayar = $iuran->where('status', 'Lunas')->count();
        $total_kios_aktif = Kios::where('status', 'Aktif')->count();
        $belum_bayar = max(0, $total_kios_aktif - $sudah_bayar);

        return view('admin.kelola_iuran', compact('iuran', 'total_iuran', 'sudah_bayar', 'belum_bayar'));
    }

    public function dashboard()
    {
        $total_kios = Kios::count();
        $kios_aktif = Kios::where('status', 'Aktif')->count();
        $pemasukan_hari_ini = Iuran::whereDate('tgl_bayar', Carbon::today())->sum('nominal');
        $sudah_bayar_hari_ini = Iuran::whereDate('tgl_bayar', Carbon::today())->where('status', 'Lunas')->count();
        
        $pemasukan_bulan_ini = Iuran::whereMonth('tgl_bayar', Carbon::now()->month)
            ->whereYear('tgl_bayar', Carbon::now()->year)->sum('nominal');

        $label_hari = [];
        $data_pemasukan = [];
        for ($i = 6; $i >= 0; $i--) {
            $tanggal = Carbon::today()->subDays($i);
            $label_hari[] = $tanggal->translatedFormat('d M');
            $data_pemasukan[] = Iuran::whereDate('tgl_bayar', $tanggal)->sum('nominal');
        }

        return view('admin.dashboard', compact(
            'total_kios', 'kios_aktif', 'pemasukan_hari_ini', 'sudah_bayar_hari_ini', 'pemasukan_bulan_ini', 'label_hari', 'data_pemasukan'
        ));
    }

    public function laporan(Request $request)
    {
        $tgl_mulai = $request->tgl_mulai ?? Carbon::now()->startOfMonth()->format('Y-m-d');
        $tgl_selesai = $request->tgl_selesai ?? Carbon::now()->endOfMonth()->format('Y-m-d');

        $iuran = Iuran::with(['kios.pedagang', 'petugas'])
            ->whereBetween('tgl_bayar', [$tgl_mulai, $tgl_selesai])
            ->orderBy('tgl_bayar', 'desc')->get();

        $total_pemasukan = $iuran->sum('nominal');
        $total_transaksi = $iuran->count();

        return view('admin.laporan', compact('iuran', 'tgl_mulai', 'tgl_selesai', 'total_pemasukan', 'total_transaksi'));
    }

    public function profil() {
        return view('admin.profil', ['user' => Auth::user()]);
    }

    public function updateProfil(Request $request) {
        $user = Auth::user();
        $data = $request->only(['name', 'username', 'nip', 'email', 'whatsapp']);

        if ($request->hasFile('foto')) {
            if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }
            $data['foto'] = $request->file('foto')->store('profil', 'public');
        }

        $user->update($data);
        return back()->with('success', 'Profil diperbarui!');
    }
}