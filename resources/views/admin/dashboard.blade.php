@extends('layouts.main')

@section('content')
    {{-- 1. Hero Section --}}
    <div class="hero-section">
        <div class="hero-gradient-overlay"></div>
        <div class="hero-content">
            {{-- Ukuran logo ditingkatkan ke 400px --}}
            <img src="{{ asset('assets/img/logo_pasar.png') }}" class="hero-logo-large" alt="Logo Pasar Baru Indramayu">
            <p class="hero-welcome-text">
                SELAMAT DATANG DI DASHBOARD PASAR TRADISIONAL INDRAMAYU
            </p>
        </div>
    </div>

    {{-- 2. Content Container --}}
    <div class="content-container">
        <div class="section-header mb-5">
            <h3 class="fw-bold mb-1">Dashboard Overview</h3>
            <p class="text-muted">Pantau aktivitas pencatatan pasar dalam satu halaman.</p>
        </div>

        {{-- 3. Card Statistik --}}
        <div class="row g-4 text-center">
            <div class="col-md-3">
                <div class="card card-stat border-0 h-100 p-4">
                    <p class="text-muted small fw-semibold text-uppercase mb-3">Total Kios Aktif</p>
                    <div class="d-flex justify-content-center align-items-center">
                        <i class="bi bi-shop fs-1 me-3 text-primary"></i>
                        <h2 class="fw-bold mb-0">{{ $kios_aktif ?? 0 }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-stat border-0 h-100 p-4">
                    <p class="text-muted small fw-semibold text-uppercase mb-3">Pembayaran Hari Ini</p>
                    <div class="d-flex justify-content-center align-items-center">
                        <i class="bi bi-person-check fs-1 me-3 text-success"></i>
                        <div class="text-start">
                            <h2 class="fw-bold mb-0">-</h2>
                            <small class="text-muted">dari {{ $total_kios ?? 0 }} kios</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-stat border-0 h-100 p-4">
                    <p class="text-muted small fw-semibold text-uppercase mb-3">Pemasukan Hari Ini</p>
                    <div class="d-flex justify-content-center align-items-center">
                        <i class="bi bi-cash-stack fs-1 me-3 text-warning"></i>
                        <h2 class="fw-bold mb-0" style="font-size: 22px;">Rp {{ number_format($pemasukan_hari_ini ?? 0, 0, ',', '.') }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-stat border-0 h-100 p-4">
                    <p class="text-muted small fw-semibold text-uppercase mb-3">Total Bulan Ini</p>
                    <div class="d-flex justify-content-center align-items-center">
                        <i class="bi bi-graph-up-arrow fs-1 me-3 text-info"></i>
                        <h2 class="fw-bold mb-0" style="font-size: 22px;">Rp -</h2>
                    </div>
                </div>
            </div>
        </div>

        {{-- 4. Grafik Section --}}
        <div class="row mt-5 g-4">
            <div class="col-md-6">
                <div class="card card-stat border-0 p-4">
                    <h6 class="fw-bold text-muted mb-4"><i class="bi bi-bar-chart-fill me-2"></i>Grafik Iuran 7 Hari Terakhir</h6>
                    <canvas id="chartIuran"></canvas>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-stat border-0 p-4">
                    <h6 class="fw-bold text-muted mb-4"><i class="bi bi-people-fill me-2"></i>Jumlah Kios Bayar</h6>
                    <canvas id="chartKios"></canvas>
                </div>
            </div>
        </div>
    </div>

    <style>
        .content-container { padding: 60px 50px; max-width: 1400px; margin: 0 auto; }
        .hero-section { height: 450px; position: relative; background-image: url('https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=1350&q=80'); background-size: cover; background-position: center; }
        .hero-gradient-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(135deg, rgba(255, 255, 255, 0.85) 0%, rgba(30, 99, 255, 0.75) 100%); z-index: 1; }
        .hero-content { position: relative; z-index: 10; display: flex; flex-direction: column; justify-content: center; align-items: center; height: 100%; text-align: center; }
        
        /* Logo diperbesar menjadi 400px sesuai permintaan */
        .hero-logo-large { width: 400px; height: auto; margin-bottom: 25px; filter: drop-shadow(0 10px 15px rgba(0, 0, 0, 0.1)); }
        
        .hero-welcome-text { font-size: 14px; color: #ffffff; font-weight: 500; letter-spacing: 2px; text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.2); }
        .card-stat { background: #ffffff; border-radius: 16px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03); transition: all 0.3s ease; }
        .card-stat:hover { transform: translateY(-8px); box-shadow: 0 15px 35px rgba(30, 99, 255, 0.1); }
    </style>
@endsection

@push('scripts')
    <script>
        const labelHariDinamis = {!! json_encode($label_hari ?? ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min']) !!};
        const dataIuranDinamis = {!! json_encode($data_pemasukan ?? [0, 0, 0, 0, 0, 0, 0]) !!};

        const ctxIuran = document.getElementById('chartIuran').getContext('2d');
        new Chart(ctxIuran, {
            type: 'bar',
            data: {
                labels: labelHariDinamis,
                datasets: [{
                    label: 'Total Iuran',
                    data: dataIuranDinamis,
                    backgroundColor: '#1E63FF',
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { callback: (value) => 'Rp ' + value.toLocaleString('id-ID') } }
                }
            }
        });

        const ctxKios = document.getElementById('chartKios').getContext('2d');
        new Chart(ctxKios, {
            type: 'line',
            data: {
                labels: labelHariDinamis,
                datasets: [{
                    label: 'Kios Bayar',
                    data: [0, 0, 0, 0, 0, 0, 0],
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } }
            }
        });
    </script>
@endpush