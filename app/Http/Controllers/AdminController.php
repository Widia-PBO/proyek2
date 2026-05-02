<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kios;
use App\Models\Pedagang;
use App\Models\Petugas;
use App\Models\Iuran; 
use Carbon\Carbon;     
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // =================================================================
    // 1. DASHBOARD & STATISTIK
    // =================================================================
    public function dashboard()
    {
        $total_kios = Kios::count();
        $kios_aktif = Kios::where('status', 'Aktif')->count();
        $total_petugas = Petugas::count();
        
        $pemasukan_hari_ini = Iuran::whereDate('tgl_bayar', Carbon::today())->sum('nominal');
        $sudah_bayar_hari_ini = Iuran::whereDate('tgl_bayar', Carbon::today())->where('status', 'Lunas')->count();

        $label_hari = [];
        $data_pemasukan = [];
        for ($i = 6; $i >= 0; $i--) {
            $tanggal = Carbon::today()->subDays($i);
            $label_hari[] = $tanggal->translatedFormat('d M');
            $data_pemasukan[] = Iuran::whereDate('tgl_bayar', $tanggal)->sum('nominal');
        }

        return view('admin.dashboard', compact(
            'total_kios', 'kios_aktif', 'pemasukan_hari_ini', 'sudah_bayar_hari_ini', 'label_hari', 'data_pemasukan'
        ));
    }

    // =================================================================
    // 2. KELOLA DATA KIOS & PEDAGANG
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

 public function storeKios(Request $request)
{
    // 1. Validasi Data
    $request->validate([
        'no_kios'       => 'required|unique:kios,no_kios',
        'blok'          => 'required',
        'nama_usaha'    => 'required',
        'nama_pedagang' => 'required',
        'jenis_usaha'   => 'required',
        'username'      => 'required|unique:pedagangs,username',
    ]);

    // 2. Gunakan Transaction agar data tersimpan sepasang (Kios & Pedagang)
    \Illuminate\Support\Facades\DB::beginTransaction();

    try {
        // Simpan ke tabel kios
        $kios = \App\Models\Kios::create([
            'no_kios'       => $request->no_kios,
            'blok'          => $request->blok,
            'nama_usaha'    => $request->nama_usaha,
            'nama_pedagang' => $request->nama_pedagang,
            'jenis_usaha'   => $request->jenis_usaha,
            'status'        => 'Aktif',
        ]);

        // Simpan ke tabel pedagangs
        \App\Models\Pedagang::create([
            'kios_id'      => $kios->id,
            'username'     => $request->username,
            'password'     => \Illuminate\Support\Facades\Hash::make('pedagang123'),
            'nama_pemilik' => $request->nama_pedagang,
        ]);

        \Illuminate\Support\Facades\DB::commit(); // Kirim ke database jika semua oke
        return redirect()->back()->with('success', 'Kios dan Akun Pedagang Berhasil Dibuat!');

    } catch (\Exception $e) {
        \Illuminate\Support\Facades\DB::rollback(); // Batalkan semua jika ada yang error
        return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
    }
}
    public function updateKios(Request $request, $id)
    {
        $kios = Kios::findOrFail($id);
        $kios->update($request->only(['no_kios', 'nama_usaha', 'nama_pedagang', 'jenis_usaha', 'status']));

        return back()->with('success', 'Data Kios Berhasil Diperbarui!');
    }

    public function destroyKios($id)
    {
        Kios::findOrFail($id)->delete(); 
        return back()->with('success', 'Data Kios Berhasil Dihapus!');
    }

    public function resetPasswordKios($id)
    {
        $kios = Kios::with('pedagang')->findOrFail($id);
        
        if ($kios->pedagang) {
            $kios->pedagang->update([
                'password' => Hash::make('pedagang123')
            ]);
            return back()->with('success', 'Password usaha ' . $kios->nama_usaha . ' berhasil direset!');
        }

        return back()->with('error', 'Akun login untuk pedagang ini belum dibuat!');
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

        return back()->with('success', 'Petugas Berhasil Ditambahkan!');
    }

    public function updatePetugas(Request $request, $id) 
    {
        Petugas::findOrFail($id)->update($request->all());
        return back()->with('success', 'Data Petugas Berhasil Diupdate!');
    }

    public function destroyPetugas($id) 
    {
        Petugas::findOrFail($id)->delete();
        return back()->with('success', 'Data Petugas Berhasil Dihapus!');
    }

    public function resetPasswordPetugas($id) 
    {
        Petugas::findOrFail($id)->update(['password' => Hash::make('petugas123')]);
        return back()->with('success', 'Password Petugas Berhasil Direset!');
    }

    // =================================================================
    // 4. IURAN & LAPORAN
    // =================================================================
public function kelolaIuran()
{
    // Mengambil data iuran terbaru beserta relasi kiosnya
    $iuran = \App\Models\Iuran::with('kios')->latest()->get();
    
    $total_iuran = $iuran->sum('nominal');
    $sudah_bayar = $iuran->where('status', 'Lunas')->count();
    $total_kios_aktif = \App\Models\Kios::where('status', 'Aktif')->count();
    $belum_bayar = max(0, $total_kios_aktif - $sudah_bayar);

    return view('admin.kelola_iuran', compact('iuran', 'total_iuran', 'sudah_bayar', 'belum_bayar'));
}
    public function laporan(Request $request)
    {
        $tgl_mulai = $request->tgl_mulai ?? Carbon::now()->startOfMonth()->format('Y-m-d');
        $tgl_selesai = $request->tgl_selesai ?? Carbon::now()->endOfMonth()->format('Y-m-d');

        $iuran = Iuran::with(['kios'])
            ->whereBetween('tgl_bayar', [$tgl_mulai, $tgl_selesai])
            ->orderBy('tgl_bayar', 'desc')->get();

        $total_pemasukan = $iuran->sum('nominal');
        $total_transaksi = $iuran->count();

        return view('admin.laporan', compact('iuran', 'tgl_mulai', 'tgl_selesai', 'total_pemasukan', 'total_transaksi'));
    }

    // =================================================================
    // 5. PROFIL ADMIN
    // =================================================================
    public function profil() {
        return view('admin.profil', ['user' => Auth::user()]);
    }

    public function updateProfil(Request $request) {
        $user = Auth::user();
        $data = $request->only(['name', 'username', 'email', 'whatsapp']);

        if ($request->hasFile('foto')) {
            if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }
            $data['foto'] = $request->file('foto')->store('profil', 'public');
        }

        $user->update($data);
        return back()->with('success', 'Profil Berhasil Diperbarui!');
    }
    
}   