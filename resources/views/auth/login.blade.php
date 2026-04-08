<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Pasar Baru Indramayu</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #f0f7ff 0%, #e0edff 100%);
            position: relative; /* Penting untuk posisi logo kios */
            overflow: hidden; /* Mencegah scrollbar muncul jika logo agak keluar */
        }

/* Posisi standar (kiri) */
        .logo-kios-bawah {
            position: absolute;
            bottom: -20px;
            left: -20px; /* Posisi awal di kiri */
            width: 350px;
            opacity: 0.8;
            z-index: 1;
            transform: rotate(-5deg);
            transition: all 0.8s cubic-bezier(0.68, -0.55, 0.27, 1.55); /* Animasi membal agar lebih hidup */
            cursor: pointer;
        }   

        /* Class baru untuk posisi kanan */
        .logo-kios-bawah.kanan {
            left: calc(100% - 330px); /* Pindah ke sisi kanan layar */
            transform: rotate(5deg); /* Putar arah sedikit agar beda */
        }

        /* --- CSS BARU UNTUK EFEK HOVER (KURSOR DIARAHKAN) --- */
        .logo-kios-bawah:hover {
            opacity: 1; /* Menjadi terang penuh saat diarahkan kursor */
            
            /* --- INI KUNCI EFEK BAYANGAN MENYALA (GLOW) --- */
            /* Kita pakai warna biru muda (#a0c4ff) yang sama dengan efek focus input agar seragam */
            filter: drop-shadow(0 0 15px rgba(160, 196, 255, 0.8)) 
                    drop-shadow(0 0 30px rgba(160, 196, 255, 0.5));
            
            /* Opsional: sedikit memperbesar gambar agar lebih hidup */
            /* transform: rotate(-5deg) scale(1.05); */
        }

        .login-container {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            width: 100%;
            max-width: 400px;
            text-align: center;
            position: relative; /* Agar di atas logo kios */
            z-index: 10; /* Di atas logo kios */
        }

        .logo-pasar {
            width: 150px;
            margin-bottom: 30px;
        }

        .form-group {
            text-align: left;
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
            margin-left: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            background-color: #fafafa;
            outline: none;
            transition: 0.3s;
        }

        .form-group input:focus {
            border-color: #a0c4ff;
            background-color: #fff;
            box-shadow: 0 0 8px rgba(160, 196, 255, 0.2);
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 25px;
            background: linear-gradient(to right, #9bbfff, #c2d9ff);
            color: #333;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
            box-shadow: 0 4px 15px rgba(155, 191, 255, 0.3);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(155, 191, 255, 0.4);
            background: linear-gradient(to right, #8aafff, #b3ceff);
        }

        .alert-error {
            background-color: #ffe0e0;
            color: #d8000c;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 13px;
        }
    </style>
</head>
<body>

    <img src="{{ asset('assets/img/icon_pasar.png       ') }}" alt="Dekorasi Kios Pasar" class="logo-kios-bawah">

    <div class="login-container">
        <img src="{{ asset('assets/img/logo_pasar.png') }}" alt="Logo Pasar Baru Indramayu" class="logo-pasar">

        @if(session()->has('loginError'))
            <div class="alert-error">
                {{ session('loginError') }}
            </div>
        @endif

        <form action="{{ url('/login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" value="{{ old('username') }}" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </div>

            <button type="submit" class="btn-login">LOGIN</button>
        </form>
    </div>
<script>
        const logoKios = document.querySelector('.logo-kios-bawah');

        logoKios.addEventListener('click', function() {
            // Fungsi toggle: jika sudah ada class 'kanan' maka dihapus, jika belum maka ditambah
            this.classList.toggle('kanan');
        });
</script>
</body>
</html>