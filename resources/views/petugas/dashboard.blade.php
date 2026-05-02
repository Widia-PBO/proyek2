@extends('layouts.petugas')

@section('content')
@php
    // Gunakan data dari controller, tapi jika kosong (undefined), ambil langsung dari model
    $total_kios_aktif = $total_kios_aktif ?? \App\Models\Kios::where('status', 'Aktif')->count();
    $kios_lunas = $kios_sudah_bayar ?? \App\Models\Pembayaran::whereDate('tanggal_bayar', \Carbon\Carbon::today())->distinct('kios_id')->count();
    $persentase = $total_kios_aktif > 0 ? round(($kios_lunas / $total_kios_aktif) * 100) : 0;
@endphp

<div class="container-fluid px-0 mt-4 mb-4 position-relative">   
    <div class="hero-bg d-flex flex-column align-items-center justify-content-center text-center" 
         style="background: linear-gradient(rgba(255, 255, 255, 0.56), rgba(86, 173, 255, 0.85)), url('https://images.unsplash.com/photo-1542838132-92c53300491e?q=80&w=1974&auto=format&fit=crop') center/cover; min-height: 350px; padding: 40px 20px;">
        
        <div class="d-flex flex-column flex-md-row align-items-center justify-content-center gap-4 mb-3">
            <img src="{{ asset('assets/img/icon_pasar.png') }}" width="199" height="auto" class="hero-logo-large" alt="Logo">
            <div class="text-md-start text-center">
                <h2 class="fw-bold text-white mb-0" style="text-shadow: 2px 2px 5px rgba(0,0,0,0.4);">
                    <span style="color: #ffffff; font-weight: 500; font-size: 1.5rem;">Halo, {{ $petugas->nama_petugas }}</span><br>
                    <span class="display-6 fw-bold">Selamat Datang di<br>Beranda Penagihan</span>
                </h2>
            </div>
        </div>
        <p class="text-white mt-4 fw-light text-uppercase" style="letter-spacing: 2px; font-size: 0.85rem; opacity: 0.9;">
            HALO {{ $petugas->username }}, SELAMAT DATANG DI DASHBOARD PASAR TRADISIONAL INDRAMAYU
        </p>
    </div>
</div>

<div class="container" style="max-width: 900px;">
    <div class="card border-0 shadow-lg mb-3" style="border-radius: 20px; background-color: #22A637;">
        <div class="card-body p-4 p-md-5 text-center text-white">
            <h5 class="text-start fw-normal mb-1">Status Iuran Hari Ini</h5>
            <h1 class="display-3 fw-bold my-2">Rp{{ number_format($total_penagihan_hari_ini, 0, ',', '.') }}</h1>
            <p class="mb-0 fs-5">Siap disetorkan ke admin</p>
        </div>
    </div>
    
    <div class="card border-0 shadow-sm mb-3" style="border-radius: 15px; overflow: hidden;">
        <div class="card-header border-0 text-center fw-bold py-2" style="background-color: #AECBFF; color: #1a1a1a;">
            RINGKASAN TUGAS HARI INI
        </div>
        <div class="card-body p-4 d-flex justify-content-between align-items-center bg-white">
            <div>
                <p class="mb-1 text-dark fs-5">Kios Belum Ditagih:<br>
                    <span class="fw-bold fs-3 text-danger">{{ $kios_belum_ditagih }}/{{ $total_kios_aktif }}</span>
                </p>
                <p class="mb-0 text-dark fs-5">Kios Lunas: <span class="fw-bold text-success">{{ $kios_sudah_bayar }}</span></p>
            </div>
            <div class="progress-circle shadow-sm" style="--value: {{ $persentase }};">
                <span>{{ $persentase }}%</span>
            </div>
        </div>
    </div>

    <a href="{{ url('/petugas/penagihan') }}" class="btn w-100 fw-bold shadow-sm mb-5 py-2" 
       style="background: linear-gradient(90deg, #8ba4f9, #AECBFF); color: #1a1a1a; border-radius: 10px;">
        MULAI PENAGIHAN
    </a>

    <h5 class="fw-bold mb-3 text-dark">AKTIVITAS TERAKHIR (TUNAI)</h5>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3 mb-5">
        @forelse($aktivitas_terakhir as $item)
        <div class="col">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body p-3">
                    <div class="text-dark fw-semibold mb-2" style="font-size: 0.75rem;">
                        {{ $item->created_at->translatedFormat('d F Y | H.i') }} WIB
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-wallet2 fs-2" style="color: #7DA0FA;"></i>
                            <div style="line-height: 1.2;">
                                <div class="fw-bold text-dark" style="font-size: 0.85rem;">IURAN HARIAN</div>
                                <div class="text-muted" style="font-size: 0.7rem;">Kios {{ $item->kios->no_kios }}<br>({{ $item->kios->nama_usaha }})</div>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="fw-bold text-dark mb-1" style="font-size: 0.9rem;">Rp{{ number_format($item->total_bayar, 0, ',', '.') }}</div>
                            <span class="badge rounded-pill bg-success" style="font-size: 0.65rem;">LUNAS</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 w-100 text-center py-4 text-muted">Belum ada aktivitas hari ini.</div>
        @endforelse
    </div>
</div>

<style>
    .progress-circle { position: relative; width: 80px; height: 80px; border-radius: 50%; background: conic-gradient(#1E63FF calc(var(--value) * 1%), #E2E8F0 0); display: flex; align-items: center; justify-content: center; }
    .progress-circle::before { content: ""; position: absolute; width: 60px; height: 60px; background-color: white; border-radius: 50%; }
    .progress-circle span { position: relative; font-weight: 700; color: #1a1a1a; }
</style>
@endsection