    @extends('layouts.main')

    @section('content')
    <div class="hero-section">
        <div class="hero-gradient-overlay"></div>

<div class="hero-content">
    <img src="{{ asset('assets/img/logo_pasar.png') }}" width="200" height="auto" class="hero-logo-large" alt="Logo Pasar Baru Indramayu">
    
    <p class="hero-welcome-text mt-0" style="margin-top: -30px !important;">
        SELAMAT DATANG DI DASHBOARD PASAR TRADISIONAL INDRAMAYU
    </p>
</div>
    </div>

    <div class="content-container">
        <div class="mb-4">
            <h3 class="fw-bold mb-0">Dashboard</h3>
            <p class="text-muted">Sistem Pencatatan Pasar Tradisional Indramayu</p>
        </div>  

        <div class="row text-center">
            <div class="col-md-3 mb-4">
                <div class="card card-stat p-3">
                    <p class="text-muted mb-2">Total Kios Aktif</p>
                    <div class="d-flex justify-content-center align-items-center">
                        <i class="bi bi-shop fs-1 me-3"></i>
                        <h2 class="fw-bold mb-0">37</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card card-stat p-3">
                    <p class="text-muted mb-2">Pembayaran /Hari</p>
                    <div class="d-flex justify-content-center align-items-center">
                        <i class="bi bi-person-check fs-1 me-3"></i>
                        <h2 class="fw-bold mb-0">6 <span class="fs-6 fw-normal text-muted">dari 37 Kios</span></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card card-stat p-3">
                    <p class="text-muted mb-2">Total Iuran /Hari</p>
                    <div class="d-flex justify-content-center align-items-center">
                        <i class="bi bi-cash-stack fs-1 me-3"></i>
                        <h2 class="fw-bold mb-0">Rp. 50.000</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card card-stat p-3">
                    <p class="text-muted mb-2">Total Bulan Ini</p>
                    <div class="d-flex justify-content-center align-items-center">
                        <i class="bi bi-graph-up-arrow fs-1 me-3"></i>
                        <h2 class="fw-bold mb-0 text-truncate">Rp 500.000</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6 mb-4">
                <div class="card card-stat p-4">
                    <h6 class="text-center text-muted mb-4">Grafik Iuran 7 Hari Terakhir</h6>
                    <canvas id="chartIuran"></canvas>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card card-stat p-4">
                    <h6 class="text-center text-muted mb-4">Jumlah Kios Bayar</h6>
                    <canvas id="chartKios"></canvas>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* --- CSS TAMBAHAN UNTUK REVISI HERO SECTION --- */
        
        .hero-section {
            height: 450px; /* Sedikit lebih tinggi agar muat logo besar & teks */
            position: relative;
            background-image: url('https://images.unsplash.com/photo-1542838132-92c53300491e?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            overflow: hidden;
        }

        /* Overlay Gradasi: Putih (Atas Kiri) ke Biru (Bawah Kanan) */
        .hero-gradient-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            /* REVISI: Efek gradasi yang kamu minta, transparan agar sayur tetap terlihat */
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.89) 0%, rgba(0, 157, 255, 0.77) 100%);
            z-index: 1;
        }

        /* Konten ditaruh di atas overlay */
        .hero-content {
            position: relative;
            z-index: 10;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100%;
            text-align: center;
        }

        /* REVISI: Logo Pasar (logo_pasar.png) Sedikit Lebih Besar */
        .hero-logo-large {
            width: 500px; /* Ukuran sebelumnya mungkin 150px, kita besarkan */
            height: auto;       
            /* Opsional: tambah bayangan agar logo putih menonjol */
            filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));
        }

        /* REVISI: Teks Selamat Datang Kecil Berwarna Putih */
        .hero-welcome-text {
            font-size: 15px; /* Ukuran kecil */
            color: white; /* Berwarna putih */
            font-weight: 300; /* Lebih tipis agar estetik */
            text-transform: uppercase;
            letter-spacing:     1.5px;
            /* Tambah bayangan tipis agar terbaca di background terang */
            text-shadow: 2px 1px 3px rgba(0,0,0,0.3);
        }
    </style>    
    @endsection

    @push('scripts')
    <script>
        // Logic untuk Grafik (Chart.js)
        const ctxIuran = document.getElementById('chartIuran').getContext('2d');
        new Chart(ctxIuran, {
            type: 'bar',
            data: {
                labels: ['9 Feb', '10 Feb', '11 Feb', '12 Feb', '13 Feb', '14 Feb', '15 Feb'],
                datasets: [{
                    label: 'Iuran',
                    data: [0, 0, 5, 12, 8, 18, 22],
                    backgroundColor: '#b3d1ff',
                    borderRadius: 5
                }]
            },
            options: { plugins: { legend: { display: false } } }
        });

        const ctxKios = document.getElementById('chartKios').getContext('2d');
        new Chart(ctxKios, {
            type: 'bar',
            data: {
                labels: ['9 Feb', '10 Feb', '11 Feb', '12 Feb', '13 Feb', '14 Feb', '15 Feb'],
                datasets: [{
                    label: 'Kios',
                    data: [0, 0, 0, 0, 10, 18, 22],
                    backgroundColor: '#b3d1ff',
                    borderRadius: 5
                }]
            },
            options: { plugins: { legend: { display: false } } }
        });
    </script>
    @endpush