@extends('layouts.pedagang')

@section('content')
<div class="profil-container bg-white" style="min-height: 100vh;">
    <div class="hero-profil d-flex align-items-center justify-content-center text-center py-5" 
         style="background: linear-gradient(rgba(255,255,255,0.7), rgba(255,255,255,0.7)), url('https://images.unsplash.com/photo-1610348725531-843dff563e2c?q=80&w=1200') center/cover;">
        <div class="text-dark mt-5">
            <h1 class="fw-bold mb-0 text-uppercase">Profile Akun</h1>
            <p class="fs-5">Kelola informasi kios dan keamanan akun anda</p>
        </div>
    </div>

    <div class="container pb-5">
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('pedagang.update_profil') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row align-items-center">
                <div class="col-lg-5 text-center mb-4">
                    <div class="position-relative d-inline-block">
                        <img src="{{ $pedagang->foto ? asset('storage/'.$pedagang->foto) : asset('assets/img/user_icon.png') }}" 
                             class="rounded-circle border border-5 border-white shadow-lg" width="250" height="250" id="previewFoto" style="object-fit: cover;">
                        <label for="inputFoto" class="btn btn-primary rounded-circle position-absolute bottom-0 end-0 p-2 shadow" style="cursor:pointer;">
                            <i class="bi bi-camera-fill"></i>
                        </label>
                        <input type="file" name="foto" id="inputFoto" class="d-none" onchange="previewImage(this)">
                    </div>
                    <h3 class="fw-bold mt-4 mb-0">{{ $pedagang->nama_pemilik }}</h3>
                    <p class="text-muted">Kios Nomor: {{ $kios->no_kios }}</p>
                </div>

                <div class="col-lg-7">
                    <div class="profile-info-list">
                        <div class="info-row d-flex justify-content-between align-items-center p-3 mb-2 shadow-sm rounded-pill border bg-light">
                            <span class="ms-3 fw-semibold">Nama Pemilik : {{ $pedagang->nama_pemilik }}</span>
                            <i class="bi bi-lock-fill me-3 text-muted"></i>
                        </div>
{{-- Ganti bagian input Nama Toko menjadi Nama Usaha --}}
<div class="info-row d-flex justify-content-between align-items-center p-2 mb-2 shadow-sm rounded-pill border bg-white">
    <div class="d-flex align-items-center w-100">
        <span class="ms-3 fw-bold text-primary small me-2">Toko:</span>
        {{-- Name diubah menjadi nama_usaha --}}
        <input type="text" name="nama_usaha" class="form-control border-0 bg-transparent fw-semibold" value="{{ $kios->nama_usaha }}">
    </div>
    <i class="bi bi-pencil-fill me-3 text-primary"></i>
</div>

                        <div class="info-row d-flex justify-content-between align-items-center p-2 mb-2 shadow-sm rounded-pill border">
                            <div class="d-flex align-items-center w-100">
                                <span class="ms-3 fw-bold text-primary small me-2">USAHA:</span>
                                <input type="text" name="jenis_usaha" class="form-control border-0 bg-transparent fw-semibold" value="{{ $kios->jenis_usaha }}">
                            </div>
                            <i class="bi bi-pencil-fill me-3 text-primary"></i>
                        </div>
                        <div class="info-row d-flex justify-content-between align-items-center p-2 mb-2 shadow-sm rounded-pill border">
                            <div class="d-flex align-items-center w-100">
                                <span class="ms-3 fw-bold text-primary small me-2">WA:</span>
                                <input type="text" name="whatsapp" class="form-control border-0 bg-transparent fw-semibold" value="{{ $pedagang->whatsapp }}">
                            </div>
                            <i class="bi bi-pencil-fill me-3 text-primary"></i>
                        </div>
                        <div class="info-row d-flex justify-content-between align-items-center p-3 mb-2 shadow-sm rounded-pill border bg-light">
                            <span class="ms-3 fw-semibold">Lokasi : {{ $kios->blok }}</span>
                            <i class="bi bi-lock-fill me-3 text-muted"></i>
                        </div>
                    </div>

                    <div class="d-flex gap-3 mt-4 justify-content-center">
                        <button type="button" class="btn btn-outline-primary rounded-pill px-4 fw-bold" data-bs-toggle="modal" data-bs-target="#modalPassword">Ganti Password</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold shadow">SIMPAN PROFIL</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modalPassword" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('pedagang.change_password') }}" method="POST" class="modal-content border-0 rounded-4 shadow">
            @csrf @method('PUT')
            <div class="modal-header border-0 pb-0 mt-2"><h5 class="fw-bold">Ganti Password</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body p-4">
                <div class="mb-3"><label class="form-label small fw-bold">Password Sekarang</label><input type="password" name="current_password" class="form-control rounded-3" required></div>
                <div class="mb-3"><label class="form-label small fw-bold">Password Baru</label><input type="password" name="new_password" class="form-control rounded-3" required></div>
                <div class="mb-0"><label class="form-label small fw-bold">Konfirmasi Password Baru</label><input type="password" name="new_password_confirmation" class="form-control rounded-3" required></div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary rounded-pill px-4 shadow">Update Password</button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) { document.getElementById('previewFoto').src = e.target.result; }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection