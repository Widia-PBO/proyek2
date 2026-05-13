<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pedagang - Pasar Baru Indramayu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
<style>
    .navbar-pedagang { 
        background: white; 
        border-bottom: 1px solid #f0f0f0; /* Garis dasar tipis */
        height: 80px;
    }
    .nav-link-pedagang { 
        font-weight: 600; color: #666; position: relative; padding: 10px 0; transition: 0.3s;
    }   
    /* MENGHILANGKAN GARIS GANDA: Indikator biru menimpa garis dasar navbar */
    .nav-link-pedagang.active { color: #1E63FF; }
    .nav-link-pedagang.active::after { 
        content: ''; position: absolute; 
        bottom: -22px; /* Posisi presisi menimpa border-bottom navbar */
        left: 0; width: 100%; height: 3px; 
        background: #1E63FF; 
    }
</style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-pedagang sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('pedagang.dashboard') }}">
                <img src="{{ asset('assets/img/logo_pasar.png') }}" height="45" alt="Logo">
            </a>
            <div class="collapse navbar-collapse justify-content-center">
                <ul class="navbar-nav gap-5">
                    <li class="nav-item">
                        <a class="nav-link-pedagang {{ Request::is('pedagang/dashboard') ? 'active' : '' }}" href="{{ route('pedagang.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-pedagang {{ Request::is('pedagang/riwayat*') ? 'active' : '' }}" href="{{ route('pedagang.riwayat') }}">Riwayat Iuran</a>
                    </li>
                </ul>
            </div>

            {{-- DROPDOWN PROFILE (Seperti Petugas) --}}
            <div class="dropdown">
                <button class="profile-btn d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
                    <div class="text-end d-none d-md-block">
                        <p class="mb-0 fw-bold small text-dark">{{ Auth::guard('pedagang')->user()->nama_pemilik }}</p>
                        <p class="mb-0 text-muted small">Pedagang</p>
                    </div>
                    <img src="{{ Auth::guard('pedagang')->user()->foto ? asset('storage/'.Auth::guard('pedagang')->user()->foto) : asset('assets/img/user_icon.png') }}" 
                         width="40" height="40" class="rounded-circle border shadow-sm">
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow">
                    <li><a class="dropdown-item" href="{{ route('pedagang.profil') }}"><i class="bi bi-person-circle me-2"></i>Kelola Akun</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="/logout" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('scripts')
</body>
</html>