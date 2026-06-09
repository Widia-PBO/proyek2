@extends('layouts.pedagang')

@section('content')
<div class="profil-container bg-white" style="min-height: 100vh;">
    {{-- Header Banner --}}
    <div class="hero-profil d-flex align-items-center justify-content-center text-center py-5" 
         style="background: linear-gradient(rgba(255,255,255,0.7), rgba(255,255,255,0.7)), url('https://images.unsplash.com/photo-1610348725531-843dff563e2c?q=80&w=1200') center/cover;">
        <div class="text-dark mt-5">
            <h1 class="fw-bold mb-0 text-uppercase">Profile Akun</h1>
            <p class="fs-5">Kelola informasi kios dan keamanan akun anda</p>
        </div>
    </div>

    <div class="container pb-5">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('pedagang.update_profil') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row align-items-center">
                {{-- Bagian Kiri: Foto & Preview --}}
                <div class="col-lg-5 text-center mb-4">
                    <div class="position-relative d-inline-block">
                        {{-- Klik foto untuk perbesar --}}
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modalPreviewLarge">
                            <img src="{{ $pedagang->foto ? asset('storage/'.$pedagang->foto) : asset('assets/img/user_icon.png') }}" 
                                 class="rounded-circle border border-5 border-white shadow-lg cursor-pointer" 
                                 width="250" height="250" style="object-fit: cover;" id="previewFoto">
                        </a>

                        {{-- Dropdown Opsi Upload (Kamera Live / File) --}}
                        <div class="dropdown position-absolute bottom-0 end-0">
                            <button type="button" class="btn btn-primary rounded-circle p-2 shadow dropdown-toggle hide-arrow d-flex align-items-center justify-content-center" data-bs-toggle="dropdown" aria-expanded="false" style="width: 45px; height: 45px; background-color: #1E63FF; border: none;">
                                <i class="bi bi-camera-fill fs-5"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3">
                                <li>
                                    {{-- Buka Modal Kamera WebRTC --}}
                                    <button type="button" class="dropdown-item d-flex align-items-center cursor-pointer" data-bs-toggle="modal" data-bs-target="#modalKamera">
                                        <i class="bi bi-camera-video me-2 text-muted"></i> Gunakan Kamera
                                    </button>
                                </li>
                                <li>
                                    {{-- Buka File Explorer --}}
                                    <label class="dropdown-item d-flex align-items-center cursor-pointer mb-0" for="inputFoto">
                                        <i class="bi bi-file-earmark-image me-2 text-muted"></i> Ambil dari File
                                    </label>
                                </li>
                            </ul>
                        </div>

                        {{-- Input file utama (Backend akan membaca ini) --}}
                        <input type="file" name="foto" id="inputFoto" class="d-none" accept="image/*" onchange="previewImage(this)">
                    </div>
                    <h3 class="fw-bold mt-4 mb-0">{{ $pedagang->nama_pemilik }}</h3>
                    <p class="text-muted small">Kios: {{ $kios->no_kios }} - {{ $kios->nama_usaha }}</p>
                </div>

                {{-- Bagian Kanan: Formulir --}}
                <div class="col-lg-7">
                    <div class="profile-info-list">
                        <div class="info-row d-flex justify-content-between align-items-center p-2 mb-2 shadow-sm rounded-pill border bg-white">
                            <div class="d-flex align-items-center w-100">
                                <span class="ms-3 fw-bold text-primary small me-2" style="min-width: 60px;">NAMA:</span>
                                <input type="text" name="nama_pemilik" class="form-control border-0 bg-transparent fw-semibold" value="{{ $pedagang->nama_pemilik }}" placeholder="Nama Pemilik">
                            </div>
                            <i class="bi bi-pencil-fill me-3 text-primary"></i>
                        </div>
                        <div class="info-row d-flex justify-content-between align-items-center p-2 mb-2 shadow-sm rounded-pill border bg-white">
                            <div class="d-flex align-items-center w-100">
                                <span class="ms-3 fw-bold text-primary small me-2" style="min-width: 60px;">TOKO:</span>
                                <input type="text" name="nama_usaha" class="form-control border-0 bg-transparent fw-semibold" value="{{ $kios->nama_usaha }}" placeholder="Nama Toko">
                            </div>
                            <i class="bi bi-pencil-fill me-3 text-primary"></i>
                        </div>
                        <div class="info-row d-flex justify-content-between align-items-center p-2 mb-2 shadow-sm rounded-pill border bg-white">
                            <div class="d-flex align-items-center w-100">
                                <span class="ms-3 fw-bold text-primary small me-2" style="min-width: 60px;">USAHA:</span>
                                <input type="text" name="jenis_usaha" class="form-control border-0 bg-transparent fw-semibold" value="{{ $kios->jenis_usaha }}" placeholder="Jenis Usaha">
                            </div>
                            <i class="bi bi-pencil-fill me-3 text-primary"></i>
                        </div>
                        <div class="info-row d-flex justify-content-between align-items-center p-2 mb-2 shadow-sm rounded-pill border bg-white">
                            <div class="d-flex align-items-center w-100">
                                <span class="ms-3 fw-bold text-primary small me-2" style="min-width: 60px;">WA:</span>
                                <input type="text" name="whatsapp" class="form-control border-0 bg-transparent fw-semibold" value="{{ $pedagang->whatsapp }}" placeholder="Nomor WhatsApp">
                            </div>
                            <i class="bi bi-pencil-fill me-3 text-primary"></i>
                        </div>
                        <div class="info-row d-flex justify-content-between align-items-center p-3 mb-2 shadow-sm rounded-pill border bg-light">
                            <span class="ms-3 fw-semibold text-muted">Lokasi Blok : {{ $kios->blok ?? '-' }}</span>
                            <i class="bi bi-lock-fill me-3 text-muted"></i>
                        </div>
                    </div>

                    <div class="d-flex gap-3 mt-4 justify-content-center">
                        <button type="button" class="btn btn-outline-primary rounded-pill px-4 fw-bold" data-bs-toggle="modal" data-bs-target="#modalPassword">
                            Ganti Password
                        </button>
                        <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold shadow" style="background-color: #1E63FF; border: none;">
                            SIMPAN PERUBAHAN
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Modal Ganti Password (Tetap) --}}
<div class="modal fade" id="modalPassword" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('pedagang.change_password') }}" method="POST" class="modal-content border-0 rounded-4 shadow">
            @csrf
            @method('PUT')
            <div class="modal-header border-0 pb-0 mt-2">
                <h5 class="fw-bold"><i class="bi bi-shield-lock me-2 text-primary"></i>Ganti Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3"><label class="small fw-bold">Password Sekarang</label><input type="password" name="current_password" class="form-control rounded-3" required></div>
                <div class="mb-3"><label class="small fw-bold">Password Baru</label><input type="password" name="new_password" class="form-control rounded-3" required></div>
                <div class="mb-0"><label class="small fw-bold">Konfirmasi Password</label><input type="password" name="new_password_confirmation" class="form-control rounded-3" required></div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary rounded-pill px-4 shadow">Update Password</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Preview Foto Besar --}}
<div class="modal fade" id="modalPreviewLarge" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow-lg bg-transparent">
            <div class="modal-header border-0 pb-0 justify-content-end p-2">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0 d-flex justify-content-center">
                <img src="{{ $pedagang->foto ? asset('storage/'.$pedagang->foto) : asset('assets/img/user_icon.png') }}" class="rounded-4 img-fluid" style="object-fit: contain; max-height: 85vh;" id="largeFotoModalImage">
            </div>
        </div>
    </div>
</div>

{{-- Modal Kamera Live (Fitur Baru) --}}
<div class="modal fade" id="modalKamera" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header border-0 pb-0 mt-2">
                <h5 class="modal-title fw-bold"><i class="bi bi-camera me-2 text-primary"></i>Ambil Foto Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-4">
                {{-- Layar Kamera --}}
                <video id="videoKamera" class="w-100 rounded-3 bg-dark mb-3 shadow-sm" autoplay playsinline style="max-height: 350px; object-fit: cover;"></video>
                <canvas id="canvasKamera" class="d-none"></canvas>
                
                <button type="button" id="btnJepret" class="btn btn-primary rounded-pill px-5 py-2 fw-bold shadow">
                    <i class="bi bi-circle-fill me-2 text-danger"></i> Jepret Sekarang
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .cursor-pointer { cursor: pointer; }
    .dropdown-toggle.hide-arrow::after { display: none !important; }
    .info-row input:focus { box-shadow: none !important; outline: none !important; }
</style>

@endsection

@push('scripts')
{{-- Skrip Preview Gambar Biasa --}}
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewFoto').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Sinkronisasi modal besar
    document.addEventListener('DOMContentLoaded', function () {
        const modalElement = document.getElementById('modalPreviewLarge');
        if (modalElement) {
            modalElement.addEventListener('show.bs.modal', function () {
                document.getElementById('largeFotoModalImage').src = document.getElementById('previewFoto').src;
            });
        }
    });
</script>

{{-- Skrip Kamera WebRTC (Menyalakan Kamera secara Native di Browser) --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modalKamera = document.getElementById('modalKamera');
        const videoKamera = document.getElementById('videoKamera');
        const canvasKamera = document.getElementById('canvasKamera');
        const btnJepret = document.getElementById('btnJepret');
        const inputFoto = document.getElementById('inputFoto');
        const previewFoto = document.getElementById('previewFoto');
        let stream = null;

        // Nyalakan kamera saat modal dibuka
        modalKamera.addEventListener('show.bs.modal', function () {
            if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                navigator.mediaDevices.getUserMedia({ video: true })
                    .then(function (s) {
                        stream = s;
                        videoKamera.srcObject = stream;
                    })
                    .catch(function (err) {
                        alert("Gagal mengakses kamera: " + err.message);
                        bootstrap.Modal.getInstance(modalKamera).hide();
                    });
            } else {
                alert("Browser Anda tidak mendukung fitur kamera live.");
            }
        });

        // Matikan kamera saat modal ditutup
        modalKamera.addEventListener('hide.bs.modal', function () {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }
        });

        // Aksi Jepret Foto
        btnJepret.addEventListener('click', function () {
            const context = canvasKamera.getContext('2d');
            canvasKamera.width = videoKamera.videoWidth;
            canvasKamera.height = videoKamera.videoHeight;
            
            // Gambar frame video ke canvas
            context.drawImage(videoKamera, 0, 0, canvasKamera.width, canvasKamera.height);

            // Ubah canvas menjadi file dan masukkan ke dalam input form
            canvasKamera.toBlob(function(blob) {
                const file = new File([blob], "foto_kamera_" + Date.now() + ".jpg", { type: "image/jpeg" });
                
                // Manipulasi DataTransfer untuk mengelabui input type file
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                inputFoto.files = dataTransfer.files;

                // Tampilkan preview di halaman
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewFoto.src = e.target.result;
                }
                reader.readAsDataURL(file);

                // Tutup modal kamera otomatis
                bootstrap.Modal.getInstance(modalKamera).hide();
            }, 'image/jpeg', 0.9);
        });
    });
</script>
@endpush