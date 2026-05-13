@extends('layouts.pedagang')

@section('content')
<div class="riwayat-section">
    {{-- Hero dengan Gradient Biru-Putih & Foto Sayur --}}
    <div class="container-fluid px-0 position-relative"> 
        <div class="hero-bg d-flex align-items-center justify-content-center text-center" 
             style="background: linear-gradient(rgba(255, 255, 255, 0.6), rgba(86, 173, 255, 0.85)), url('https://images.unsplash.com/photo-1542838132-92c53300491e?q=80&w=1974&auto=format&fit=crop') center/cover; min-height: 250px; border-radius: 0 0 40px 40px;">
            <div class="mt-4">
                <h1 class="display-5 fw-900 text-dark text-uppercase mb-0">Riwayat Transaksi</h1>
                <p class="text-dark fw-semibold mt-2">Semua catatan iuran untuk Kios {{ Auth::guard('pedagang')->user()->kios->no_kios ?? '-' }}</p>
            </div>
        </div>
    </div>

    <div class="container mt-n4 position-relative" style="z-index: 10;">
        {{-- Tabel/Grid Riwayat (Seperti yang Tuan Muda sukai sebelumnya) --}}
        <div class="row g-4 pb-5 mt-2">
            @forelse($riwayat as $item)
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 p-4 h-100 shadow-hover">
                        <span class="text-muted small fw-bold text-uppercase mb-3 d-block">{{ \Carbon\Carbon::parse($item->tanggal_bayar)->translatedFormat('d F Y') }}</span>
                        <div class="d-flex align-items-center mb-4">
                            <div class="icon-box bg-light text-primary p-3 rounded-3 me-3">
                                <i class="bi bi-receipt-cutoff fs-4"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0">IURAN HARIAN</h6>
                                <p class="text-muted small mb-0">{{ $item->metode_pembayaran }}</p>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center border-top pt-3">
                            <h5 class="fw-bold mb-0 text-primary">Rp {{ number_format($item->total_bayar, 0, ',', '.') }}</h5>
                            <span class="badge bg-success rounded-pill px-3">LUNAS</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">Belum ada transaksi.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<style>
    .mt-n4 { margin-top: -50px !important; }
    .fw-900 { font-weight: 900; }
    .shadow-hover { transition: 0.3s; }
    .shadow-hover:hover { transform: translateY(-10px); box-shadow: 0 15px 30px rgba(30, 99, 255, 0.1) !important; }
</style>
@endsection