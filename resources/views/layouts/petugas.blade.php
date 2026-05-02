<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Petugas - Pasar Baru Indramayu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #ffffff;
            margin: 0;
            overflow-y: scroll;
        }

        /* Navbar Styling (Persis main.blade.php) */
        .navbar {
            background: white !important;
            border-bottom: 1px solid #eee;
            padding: 15px 50px;
        }

        .nav-link {
            color: #333 !important;
            font-weight: 400;
            margin: 0 15px;
            font-size: 14px;
        }

        .nav-link.active {
            font-weight: 600;
            color: #000 !important;
        }

        .logo-nav {
            height: 40px;
        }

        /* Mengunci menu utama agar 100% di tengah layar (Khusus PC/Laptop) */
        @media (min-width: 992px) {
            .navbar-center-absolute {
                position: absolute !important;
                left: 50%;
                transform: translateX(-50%);
            }
        }

        /* Kustomisasi Dropdown Profil Tambahan */
        .dropdown-menu {
            border: none;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
        }

        .dropdown-item {
            font-weight: 500;
            color: #444;
            padding: 10px 20px;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
            color: #1E63FF;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container-fluid position-relative"> 
            <img src="{{ asset('assets/img/logo_pasar.png') }}" class="logo-nav me-4" alt="Logo">

            <button class="navbar-toggler shadow-none border-0" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">

               <ul class="navbar-nav navbar-center-absolute mb-2 mb-lg-0">
    <li class="nav-item">
        <a class="nav-link {{ request()->is('petugas/dashboard') ? 'active fw-bold' : '' }}"
            href="{{ url('/petugas/dashboard') }}">Beranda</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->is('petugas/penagihan*') ? 'active fw-bold' : '' }}"
            href="{{ url('/petugas/penagihan') }}">Penagihan</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->is('petugas/riwayat*') ? 'active fw-bold' : '' }}"
            href="#">Riwayat Setoran</a>
    </li>
</ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center pe-0" href="#" id="navbarDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">

                            <div class="bg-primary text-white d-flex justify-content-center align-items-center shadow-sm"
                                style="width: 40px; height: 40px; border-radius: 50%; font-size: 18px; font-weight: bold;">
                                {{ strtoupper(substr(Auth::guard('petugas')->user()->nama_petugas ?? 'P', 0, 1)) }}
                            </div>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow mt-2"
                            aria-labelledby="navbarDropdown" style="border-radius: 12px; min-width: 200px;">
                            <li class="px-3 py-2 text-center border-bottom mb-2 d-block">
                                <span class="fw-bold text-dark">{{ Auth::guard('petugas')->user()->nama_petugas }}</span><br>
                                <small class="text-muted">Petugas - {{ Auth::guard('petugas')->user()->wilayah_tugas }}</small>
                            </li>
                            <li>
                                <a class="dropdown-item py-2 fw-semibold text-secondary" href="#">
                                    <i class="bi bi-person-fill me-2 text-primary fs-5 align-middle"></i> Profil Saya
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="{{ url('/logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2 fw-semibold text-danger">
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

    <main class="py-0">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>