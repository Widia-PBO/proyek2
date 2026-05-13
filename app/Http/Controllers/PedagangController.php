<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Pembayaran;
use App\Models\Kios;
use Carbon\Carbon;
use Midtrans\Config;
use Midtrans\Snap;

class PedagangController extends Controller
{
    /**
     * Dashboard Pedagang dengan Grafik Real-time
     */
    public function index()
    {
        $pedagang = Auth::guard('pedagang')->user();
        $kios = Kios::where('id', $pedagang->kios_id)->first();
        $tarif = \DB::table('settings')->where('key', 'tarif_iuran')->value('value') ?? 10000;

        $status_bayar = Pembayaran::where('kios_id', $kios->id)
            ->whereDate('tanggal_bayar', Carbon::today())
            ->where('status', 'Lunas')
            ->first();

        // Grafik 7 Hari Terakhir
        $label_hari = [];
        $data_7hari = [];
        for ($i = 6; $i >= 0; $i--) {
            $tgl = Carbon::today()->subDays($i);
            $label_hari[] = $tgl->translatedFormat('D');
            $data_7hari[] = Pembayaran::where('kios_id', $kios->id)
                ->whereDate('tanggal_bayar', $tgl)
                ->where('status', 'Lunas')
                ->sum('total_bayar');
        }

        // Grafik 1 Bulan Terakhir (Per Minggu)
        $data_bulan = [];
        for ($i = 3; $i >= 0; $i--) {
            $start = Carbon::now()->subWeeks($i)->startOfWeek();
            $end = Carbon::now()->subWeeks($i)->endOfWeek();
            $data_bulan[] = Pembayaran::where('kios_id', $kios->id)
                ->whereBetween('tanggal_bayar', [$start, $end])
                ->where('status', 'Lunas')
                ->sum('total_bayar');
        }

        $riwayat_pribadi = Pembayaran::where('kios_id', $kios->id)
            ->orderBy('tanggal_bayar', 'desc')
            ->take(5)
            ->get();

        return view('pedagang.dashboard', compact(
            'pedagang', 'kios', 'tarif', 'status_bayar', 'label_hari', 'data_7hari', 'data_bulan', 'riwayat_pribadi'
        ));
    }

    /**
     * Halaman Riwayat Iuran
     */
    public function riwayat(Request $request)
    {
        $pedagang = Auth::guard('pedagang')->user();
        
        $query = Pembayaran::where('kios_id', $pedagang->kios_id)
                    ->orderBy('tanggal_bayar', 'desc');

        if ($request->has('search')) {
            $query->where('tanggal_bayar', 'like', '%' . $request->search . '%');
        }

        $riwayat = $query->get();

        return view('pedagang.riwayat', compact('pedagang', 'riwayat'));
    }

    /**
     * Halaman Pembayaran Midtrans
     */
    public function pembayaran()
    {
        $pedagang = Auth::guard('pedagang')->user();
        $tarif = \DB::table('settings')->where('key', 'tarif_iuran')->value('value') ?? 10000;

        return view('pedagang.pembayaran', compact('pedagang', 'tarif'));
    }

    /**
     * Proses Token Midtrans
     */
    public function prosesPembayaran(Request $request)
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $pedagang = Auth::guard('pedagang')->user();
        $tarif = \DB::table('settings')->where('key', 'tarif_iuran')->value('value') ?? 10000;

        $params = [
            'transaction_details' => [
                'order_id' => 'INV-' . time() . '-' . $pedagang->id,
                'gross_amount' => (int)$tarif,
            ],
            'customer_details' => [
                'first_name' => $pedagang->nama_pemilik,
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Halaman Profil
     */
    public function profil()
    {
        $pedagang = Auth::guard('pedagang')->user();
        $kios = Kios::where('id', $pedagang->kios_id)->first();
        return view('pedagang.profil_pedagang', compact('pedagang', 'kios'));
    }

    /**
     * Update Profil (Real-time ke Admin)
     */
 public function updateProfil(Request $request)
{
    $pedagang = Auth::guard('pedagang')->user();
    $kios = \App\Models\Kios::find($pedagang->kios_id);

    $request->validate([
        'nama_usaha'  => 'required|string|max:255', // Sesuaikan nama input
        'jenis_usaha' => 'required|string|max:255',
        'whatsapp'    => 'required|string|max:15',
        'foto'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // Update data di tabel Kios menggunakan nama kolom yang benar
    $kios->update([
        'nama_usaha'  => $request->nama_usaha, // Gunakan nama_usaha
        'jenis_usaha' => $request->jenis_usaha,
    ]);

    $pedagang->whatsapp = $request->whatsapp;

    if ($request->hasFile('foto')) {
        if ($pedagang->foto && file_exists(public_path('storage/' . $pedagang->foto))) {
            @unlink(public_path('storage/' . $pedagang->foto));
        }

        $file = $request->file('foto');
        $filename = time() . '_' . $pedagang->username . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('storage/foto_pedagang'), $filename);
        $pedagang->foto = 'foto_pedagang/' . $filename;
    }

    $pedagang->save();

    return back()->with('success', 'Profil dan data kios berhasil diperbarui!');
}
    /**
     * Ganti Password
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $pedagang = Auth::guard('pedagang')->user();

        if (!Hash::check($request->current_password, $pedagang->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
        }

        $pedagang->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with('success', 'Password berhasil diubah!');
    }
}   