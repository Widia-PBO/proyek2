<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pasar Baru Indramayu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #ffffff; margin: 0; overflow-y: scroll; }
        .navbar { background: white !important; border-bottom: 1px solid #eee; padding: 15px 50px; }
        .nav-link { color: #333 !important; font-weight: 400; margin: 0 15px; font-size: 14px; }
        .nav-link.active { font-weight: 600; color: #000 !important; }
        .logo-nav { height: 40px; }
        
        @media (min-width: 992px) {
            .navbar-center-absolute { position: absolute !important; left: 50%; transform: translateX(-50%); }
        }
    </style>
</head>

<body>

{{-- PINDAHKAN LOGIKA KE SINI (Atas Body) AGAR SEMUA MENU BISA PAKAI --}}
@php
    $nama_tampil = "";
    $role_tampil = "";
    $link_profil = "";
    $is_petugas_area = Request::is('petugas/*'); // Cek apakah sedang di halaman petugas

    if ($is_petugas_area && Auth::guard('petugas')->check()) {
        $u = Auth::guard('petugas')->user();
        $nama_tampil = $u->nama_petugas;
        $role_tampil = 'Petugas - ' . ($u->wilayah_tugas ?? 'A');
        $link_profil = url('/petugas/profil');
    } elseif (Auth::guard('web')->check()) {
        $u = Auth::guard('web')->user();
        $nama_tampil = $u->name;
        $role_tampil = $u->jabatan ?? 'Super Admin';
        $link_profil = url('/admin/profil');
    }
@endphp

    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container-fluid position-relative"> 
            <img src="{{ asset('assets/img/logo_pasar.png') }}" class="logo-nav me-4" alt="Logo">

            <button class="navbar-toggler shadow-none border-0" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">

                {{-- MENU TENGAH DINAMIS BERDASARKAN AREA --}}
                <ul class="navbar-nav navbar-center-absolute mb-2 mb-lg-0">
                    @if($is_petugas_area)
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('petugas/dashboard') ? 'active' : '' }}" href="{{ url('/petugas/dashboard') }}">Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('petugas/penagihan') ? 'active' : '' }}" href="{{ url('/petugas/penagihan') }}">Penagihan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('petugas/riwayat-setoran') ? 'active' : '' }}" href="{{ url('/petugas/riwayat-setoran') }}">Riwayat Setoran</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}" href="{{ url('/admin/dashboard') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin/data-kios') ? 'active' : '' }}" href="{{ url('/admin/data-kios') }}">Data Kios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin/kelola-iuran') ? 'active' : '' }}" href="{{ url('/admin/kelola-iuran') }}">Iuran Kios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin/laporan') ? 'active' : '' }}" href="{{ url('/admin/laporan') }}">Laporan</a>
                        </li>
                    @endif
                </ul>   

                {{-- DROPDOWN PROFIL DINAMIS --}}
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center pe-0" href="#" id="navbarDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="bg-primary text-white d-flex justify-content-center align-items-center shadow-sm"
                                style="width: 40px; height: 40px; border-radius: 50%; font-size: 18px; font-weight: bold;">
                                {{ strtoupper(substr($nama_tampil ?? 'U', 0, 1)) }}
                            </div>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow mt-2"
                            aria-labelledby="navbarDropdown" style="border-radius: 12px; min-width: 200px;">
                            <li class="px-3 py-2 text-center border-bottom mb-2 d-block">
                                <span class="fw-bold text-dark">{{ $nama_tampil }}</span><br>
                                <small class="text-muted">{{ $role_tampil }}</small>
                            </li>
                            <li>
                                <a class="dropdown-item py-2 fw-semibold text-secondary" href="{{ $link_profil }}">
                                    <i class="bi bi-person-fill me-2 text-primary fs-5 align-middle"></i> Profil Saya
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ url('/logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2 fw-semibold text-danger border-0 bg-transparent">
                                        <i class="bi bi-box-arrow-right me-2 fs-5 align-middle"></i> Keluar
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>

            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('scripts')
</body>

</html>