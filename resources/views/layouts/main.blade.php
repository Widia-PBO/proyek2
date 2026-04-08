<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Pasar Baru Indramayu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-ic  ons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #ffffff; margin: 0; }
        
        /* Navbar Styling */
        .navbar { background: white !important; border-bottom: 1px solid #eee; padding: 15px 50px; }
        .nav-link { color: #333 !important; font-weight: 400; margin: 0 15px; font-size: 14px; }
        .nav-link.active { font-weight: 600; color: #000 !important; }
        .logo-nav { height: 40px; }
        .user-avatar { width: 35px; height: 35px; border-radius: 50%; border: 2px solid #333; }

        /* Hero Section */
        .hero-section {
            height: 400px;
            background: linear-gradient(rgba(255, 255, 255, 0.2), rgba(255, 255, 255, 0.2)), 
                        url('https://images.unsplash.com/photo-1542838132-92c53300491e?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: #2c3e50;
        }
        .hero-logo { width: 250px; margin-bottom: 10px; }
        .hero-text { font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; }

        /* Dashboard Content */
        .content-container { padding: 40px 100px; }
        .card-stat { border: none; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); transition: 0.3s; }
        .card-stat:hover { transform: translateY(-5px); }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container-fluid">
        <img src="{{ asset('assets/img/logo_pasar.png') }}" class="logo-nav" alt="Logo">
        <div class="collapse navbar-collapse justify-content-center">
        <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link {{ request()->is('admin/dashboard') ? 'active fw-bold' : '' }}" href="{{ url('/admin/dashboard') }}">Dashboard</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('admin/data-kios') ? 'active fw-bold' : '' }}" href="{{ url('/admin/data-kios') }}">Data Kios</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('admin/iuran-kios') ? 'active fw-bold' : '' }}" href="#">Iuran Kios</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('admin/laporan') ? 'active fw-bold' : '' }}" href="#">Laporan</a>
        </li>
    </ul>
</div>

        <div class="dropdown d-flex align-items-center">
            <div class="text-end me-3 d-none d-md-block">
                <p class="mb-0 fw-bold" style="font-size: 14px; color: #333; line-height: 1.2;">
                    {{ Auth::user()->username }}
                </p>
                <p class="mb-0 text-muted text-capitalize" style="font-size: 11px; letter-spacing: 0.5px;">
                    {{ Auth::user()->role }}
                </p>
            </div>
            
            <a href="#" class="d-block link-dark text-decoration-none shadow-sm rounded-circle" data-bs-toggle="dropdown">
                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->username }}&background=009dff&color=fff&bold=true" 
                     class="user-avatar" 
                     style="width: 40px; height: 40px; border-radius: 50%; border: 2px solid #009dff;" 
                     alt="Avatar">
            </a>
            

        </div>
    </div>
</nav>

    @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('scripts')
</body>
</html>