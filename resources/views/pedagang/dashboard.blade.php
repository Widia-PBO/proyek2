@extends('layouts.pedagang')

@section('content')
<div class="pedagang-container">
    {{-- Hero Section (Gaya Petugas Tuan Muda) --}}
    <div class="container-fluid px-0 mt-0 mb-4 position-relative"> 
        <div class="hero-bg d-flex flex-column align-items-center justify-content-center text-center" 
             style="background: linear-gradient(rgba(255, 255, 255, 0.56), rgba(86, 173, 255, 0.85)), url('https://images.unsplash.com/photo-1542838132-92c53300491e?q=80&w=1974&auto=format&fit=crop') center/cover; min-height: 380px;">
            <div class="d-flex flex-column flex-md-row align-items-center justify-content-center gap-4">
                <img src="{{ asset('assets/img/icon_pasar.png') }}" width="200" class="hero-logo" style="filter: drop-shadow(0 10px 15px rgba(0,0,0,0.1));">
                <div class="text-md-start text-center">
                    <h2 class="fw-bold text-white mb-0" style="text-shadow: 2px 2px 5px rgba(0,0,0,0.4);">
                        <span style="color: #ffffff; font-weight: 500; font-size: 1.5rem;">Halo, {{ $pedagang->nama_pemilik }}</span><br>
                        <span class="display-6 fw-bold">Selamat Datang di<br>Dashboard Kios Anda</span>
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="container position-relative" style="margin-top: -80px; z-index: 10;">
        <div class="row justify-content-center">
            <div class="col-md-11 col-lg-10">
                
                {{-- Banner Status --}}
                @if($status_bayar)
                    <div class="card status-banner bg-success border-0 rounded-5 shadow-lg p-4 mb-3 text-center">
                        <h1 class="display-2 fw-900 text-white mb-0"><i class="bi bi-patch-check-fill me-2"></i>LUNAS</h1>
                        <p class="text-white opacity-75">Terimakasih telah membayar iuran hari ini <br> {{ date('l, d F Y') }}</p>
                    </div>
                @else
                    <div class="card status-banner bg-danger border-0 rounded-5 shadow-lg p-4 mb-3 text-center">
                        <h1 class="display-2 fw-900 text-white mb-0">BELUM LUNAS</h1>
                        <p class="text-white opacity-75">Segera membayar iuran hari ini <br> {{ date('l, d F Y') }}</p>
                    </div>

                    {{-- TOMBOL BAYAR SEKARANG (Hanya muncul jika belum lunas) --}}
                    <div class="d-grid mb-5">
                        <a href="{{ route('pedagang.pembayaran') }}" class="btn btn-success-figma btn-lg rounded-pill fw-bold py-3 shadow">
                            Bayar Sekarang
                        </a>
                    </div>
                @endif

                {{-- INFORMASI KIOS (Menyamping) --}}
                <div class="row g-4 mb-5">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm rounded-4 p-4 h-100 shadow-hover">
                            <h6 class="fw-bold text-muted small mb-4 text-uppercase">Status Kios Anda</h6>
                            <p class="mb-1 text-muted">No. Kios: <span class="text-dark fw-bold">{{ $kios->no_kios ?? '-' }}</span></p>
                            <p class="mb-3 text-muted">Blok / Lokasi: <span class="text-dark fw-bold">{{ $kios->blok ?? '-' }}</span></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-success-light text-success px-3">AKTIF</span>
                                <button class="btn btn-link text-primary p-0 fw-bold text-decoration-none small" data-bs-toggle="modal" data-bs-target="#modalDetailKios">Lihat Detail →</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm rounded-4 p-4 h-100 shadow-hover">
                            <h6 class="fw-bold text-muted small mb-4 text-uppercase">Riwayat Iuran Anda</h6>
                            <p class="mb-1 text-muted">Penagih: <span class="text-dark fw-bold">Petugas Pasar</span></p>
                            <p class="mb-3 text-muted">Jumlah Terakhir: <span class="text-dark fw-bold">Rp {{ number_format($tarif, 0, ',', '.') }}</span></p>
                            <button class="btn btn-primary-soft btn-sm rounded-pill px-4 fw-bold" data-bs-toggle="modal" data-bs-target="#modalDetailRiwayat">Cek Detail</button>
                        </div>
                    </div>
                </div>

                {{-- GRAFIK REAL-TIME --}}
                <div class="row g-4 pb-5">
                    <div class="col-md-6 text-center">
                        <div class="card border-0 shadow-sm rounded-4 p-4">
                            <p class="text-muted small fw-bold mb-3">Grafik Iuran 7 Hari Terakhir</p>
                            <canvas id="chart7Hari" height="150"></canvas>
                        </div>
                    </div>
                    <div class="col-md-6 text-center">
                        <div class="card border-0 shadow-sm rounded-4 p-4">
                            <p class="text-muted small fw-bold mb-3">Grafik Iuran Anda 1 Bulan Terakhir</p>
                            <canvas id="chart1Bulan" height="150"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-success-figma { background-color: #28a745; color: white; border: none; }
    .btn-success-figma:hover { background-color: #218838; color: white; transform: translateY(-3px); }
    .fw-900 { font-weight: 900; letter-spacing: -2px; }
    .shadow-hover { transition: 0.3s; }
    .shadow-hover:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(30,99,255,0.1) !important; }
</style>
<div class="modal fade" id="modalDetailKios" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header border-0 pb-0 mt-2">
                <h5 class="modal-title fw-bold"><i class="bi bi-shop me-2 text-primary"></i>Informasi Lengkap Kios</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="bg-light rounded-4 p-3 mb-3 d-flex align-items-center gap-3">
                    <img src="{{ $pedagang->foto ? asset('storage/'.$pedagang->foto) : asset('assets/img/user_icon.png') }}" width="60" height="60" class="rounded-circle border" style="object-fit: cover;">
                    <div>
                        <h6 class="fw-bold mb-0">{{ $pedagang->nama_pemilik }}</h6>
                        <small class="text-muted">Username: {{ $pedagang->username }}</small>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-6"><label class="small text-muted d-block">No. Kios</label><span class="fw-bold text-dark">{{ $kios->no_kios }}</span></div>
                    <div class="col-6"><label class="small text-muted d-block">Blok</label><span class="fw-bold text-dark">{{ $kios->blok }}</span></div>
                    <div class="col-6"><label class="small text-muted d-block">Jenis Usaha</label><span class="fw-bold text-dark text-capitalize">{{ $kios->jenis_usaha ?? 'Sembako' }}</span></div>
                    <div class="col-6"><label class="small text-muted d-block">Tarif Iuran</label><span class="fw-bold text-primary">Rp {{ number_format($tarif, 0, ',', '.') }}</span></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDetailRiwayat" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header border-0 pb-0 mt-2">
                <h5 class="modal-title fw-bold"><i class="bi bi-receipt me-2 text-primary"></i>5 Transaksi Terakhir</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                @forelse($riwayat_pribadi as $log)
                    <div class="card border-0 bg-light rounded-3 mb-3 p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="text-muted small d-block">{{ \Carbon\Carbon::parse($log->tanggal_bayar)->translatedFormat('d M Y') }}</span>
                                <h6 class="fw-bold mb-0">Pembayaran Iuran</h6>
                            </div>
                            <div class="text-end">
                                <h6 class="fw-bold text-primary mb-0">Rp {{ number_format($log->total_bayar, 0, ',', '.') }}</h6>
                                <span class="badge bg-success rounded-pill px-2 small">LUNAS</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-muted py-3">Belum ada riwayat transaksi.</p>
                @endforelse
                <div class="d-grid mt-3">
                    <a href="{{ route('pedagang.riwayat') }}" class="btn btn-primary-soft rounded-pill fw-bold">Lihat Semua Riwayat</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script>
        const commonOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { display: false } 
            },
            scales: { 
                y: { 
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }, 
                x: { 
                    grid: { display: false } 
                } 
            }
        };

        // Grafik 7 Hari Terakhir - Real-time dari Petugas
        new Chart(document.getElementById('chart7Hari'), {
            type: 'bar',
            data: {
                // Mengambil urutan label hari dinamis dari Controller
                labels: {!! json_encode($label_hari) !!},
                datasets: [{
                    data: {!! json_encode($data_pemasukan) !!},
                    backgroundColor: '#56ADFF',
                    borderRadius: 8
                }]
            },
            options: commonOptions
        });

        // Grafik 1 Bulan Terakhir
        new Chart(document.getElementById('chart1Bulan'), {
            type: 'bar',
            data: {
                labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'],
                datasets: [{
                    data: {!! json_encode($data_bulan) !!},
                    backgroundColor: '#4ade80', // Menggunakan warna hijau cerah kesukaan Tuan Muda
                    borderRadius: 8
                }]
            },
            options: commonOptions
        });
    </script>
@endpush            