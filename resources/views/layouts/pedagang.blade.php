<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedagang - Pasar Baru Indramayu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>
        body { background-color: #FDFDFD; font-family: 'Inter', sans-serif; }
        
        /* =============================================================
           NAVBAR IDENTIK ADMIN/PETUGAS (UNIFIED DESIGN)
           ============================================================= */
        .navbar-pedagang { 
            background: white; 
            height: 80px; 
            border-bottom: 1px solid #f0f0f0; 
            display: flex;
            align-items: center;
        }

        .nav-link-pedagang { 
            font-weight: 600; 
            color: #666 !important; 
            transition: 0.3s; 
            position: relative; 
            padding: 10px 0 !important;
            font-size: 15px;
        }

        /* Hover & Ac   tive State */
        .nav-link-pedagang:hover { color: #1E63FF !important; }
        .nav-link-pedagang.active { color: #1E63FF !important; }

        /* Garis Biru Indikator (Tepat menimpa garis dasar navbar) */


        /* Profile Dropdown Section (Identik dengan Admin) */
        .profile-btn { 
            cursor: pointer; 
            border: none; 
            background: transparent; 
            padding: 0; 
            outline: none !important;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .dropdown-menu { 
            border-radius: 15px; 
            border: none; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important; 
            padding: 10px; 
            margin-top: 15px !important; 
            min-width: 210px;
        }

        .dropdown-item { 
            border-radius: 10px; 
            padding: 10px 15px; 
            font-weight: 500; 
            color: #444;
            transition: 0.2s;
        }

        .dropdown-item:hover { 
            background-color: #f8faff; 
            color: #1E63FF; 
        }

        .dropdown-item i { font-size: 1.1rem; }

        /* Avatar Styling */
        .nav-avatar {
            width: 42px;
            height: 42px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-pedagang sticky-top">
        <div class="container">
            {{-- Branding Logo --}}
            <a class="navbar-brand" href="{{ route('pedagang.dashboard') }}">
                <img src="{{ asset('assets/img/logo_pasar.png') }}" height="45" alt="Logo">
            </a>

            {{-- Navigasi Tengah (Hanya Dashboard & Riwayat) --}}
            <div class="collapse navbar-collapse justify-content-center">
                <ul class="navbar-nav gap-5">
                    <li class="nav-item">
                        <a class="nav-link-pedagang {{ Request::is('pedagang/dashboard') ? 'active' : '' }}" 
                           href="{{ route('pedagang.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-pedagang {{ Request::is('pedagang/riwayat*') ? 'active' : '' }}" 
                           href="{{ route('pedagang.riwayat') }}">Riwayat iuran</a>
                    </li>
                </ul>
            </div>

            {{-- Profile Section Kanan (Identik Admin) --}}
            <div class="dropdown">
                <button class="profile-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="text-end d-none d-md-block">
                        <p class="mb-0 fw-bold small text-dark" style="line-height: 1.2;">
                            {{ Auth::guard('pedagang')->user()->nama_pemilik }}
                        </p>
                        <p class="mb-0 text-muted" style="font-size: 11px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">
                            Pedagang
                        </p>
                    </div>
                    <img src="{{ Auth::guard('pedagang')->user()->foto ? asset('storage/'.Auth::guard('pedagang')->user()->foto) : asset('assets/img/user_icon.png') }}" 
                         class="nav-avatar">
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="{{ route('pedagang.profil') }}">
                            <i class="bi bi-person-circle me-2"></i> Kelola Akun
                        </a>
                    </li>
                    <li><hr class="dropdown-divider" style="opacity: 0.05;"></li>
                    <li>
                        <form action="/logout" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="bi bi-box-arrow-right me-2"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- Konten Dinamis --}}
    @yield('content')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>