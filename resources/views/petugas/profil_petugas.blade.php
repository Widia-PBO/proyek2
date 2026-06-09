@extends('layouts.petugas') {{-- Pastikan layout mengarah ke petugas --}}

@section('content')
<div class="profil-container bg-white" style="min-height: 100vh;">
    {{-- Header Banner --}}
    <div class="hero-profil d-flex align-items-center justify-content-center text-center py-5" 
         style="background: linear-gradient(rgba(255,255,255,0.7), rgba(255,255,255,0.7)), url('https://images.unsplash.com/photo-1556742044-3c52d6e88c62?q=80&w=1200') center/cover;">
        <div class="text-dark mt-5">
            <h1 class="fw-bold mb-0 text-uppercase">Profile Petugas</h1>
            <p class="fs-5">Kelola identitas petugas lapangan anda</p>
        </div>
    </div>

    <div class="container pb-5">
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 p-3">{{ session('success') }}</div>
        @endif

        <form action="{{ route('petugas.update_profil') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row align-items-center">
                {{-- Bagian Kiri: Foto & Kamera --}}
                <div class="col-lg-5 text-center mb-4">
                    <div class="position-relative d-inline-block">
                        {{-- Klik foto untuk perbesar --}}
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modalPreviewLarge">
                            <img src="{{ $user->foto ? asset('storage/'.$user->foto) : asset('assets/img/user_icon.png') }}" 
                                 class="rounded-circle border border-5 border-white shadow-lg cursor-pointer" 
                                 width="250" height="250" style="object-fit: cover;" id="previewFoto">
                        </a>

                        {{-- Dropdown Opsi Upload --}}
                        <div class="dropdown position-absolute bottom-0 end-0">
                            <button type="button" class="btn btn-primary rounded-circle p-2 shadow dropdown-toggle hide-arrow d-flex align-items-center justify-content-center" data-bs-toggle="dropdown" style="width: 45px; height: 45px; background-color: #1E63FF; border: none;">
                                <i class="bi bi-camera-fill fs-5"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3">
                                <li>
                                    <button type="button" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modalKamera">
                                        <i class="bi bi-camera-video me-2 text-muted"></i> Ambil Kamera Live
                                    </button>
                                </li>
                                <li>
                                    <label class="dropdown-item d-flex align-items-center mb-0 cursor-pointer" for="inputFoto">
                                        <i class="bi bi-file-earmark-image me-2 text-muted"></i> Unggah dari File
                                    </label>
                                </li>
                            </ul>
                        </div>
                        <input type="file" name="foto" id="inputFoto" class="d-none" accept="image/*" onchange="previewImage(this)">
                    </div>
                    <h3 class="fw-bold mt-4 mb-0">{{ $user->nama_petugas }}</h3>
                    <p class="text-muted">ID Petugas: {{ $user->id_petugas }}</p>
                </div>

                {{-- Bagian Kanan: Form --}}
                <div class="col-lg-7">
                    <div class="profile-info-list">
                        <div class="info-row d-flex justify-content-between align-items-center p-2 mb-2 shadow-sm rounded-pill border bg-white">
                            <div class="d-flex align-items-center w-100">
                                <span class="ms-3 fw-bold text-primary small me-2" style="min-width: 70px;">NAMA:</span>
                                <input type="text" name="nama_petugas" class="form-control border-0 bg-transparent fw-semibold" value="{{ $user->nama_petugas }}">
                            </div>
                            <i class="bi bi-pencil-fill me-3 text-primary"></i>
                        </div>
                        <div class="info-row d-flex justify-content-between align-items-center p-2 mb-2 shadow-sm rounded-pill border bg-white">
                            <div class="d-flex align-items-center w-100">
                                <span class="ms-3 fw-bold text-primary small me-2" style="min-width: 70px;">WILAYAH:</span>
                                <input type="text" name="wilayah_tugas" class="form-control border-0 bg-transparent fw-semibold" value="{{ $user->wilayah_tugas }}">
                            </div>
                            <i class="bi bi-pencil-fill me-3 text-primary"></i>
                        </div>
                        <div class="info-row d-flex justify-content-between align-items-center p-2 mb-2 shadow-sm rounded-pill border bg-white">
                            <div class="d-flex align-items-center w-100">
                                <span class="ms-3 fw-bold text-primary small me-2" style="min-width: 70px;">KONTAK:</span>
                                <input type="text" name="kontak" class="form-control border-0 bg-transparent fw-semibold" value="{{ $user->kontak }}">
                            </div>
                            <i class="bi bi-pencil-fill me-3 text-primary"></i>
                        </div>
                        <div class="info-row d-flex justify-content-between align-items-center p-3 mb-2 shadow-sm rounded-pill border bg-light">
                            <span class="ms-3 fw-semibold text-muted">Username Login : {{ $user->username }}</span>
                            <i class="bi bi-lock-fill me-3 text-muted"></i>
                        </div>
                    </div>

                    <div class="d-flex gap-3 mt-4 justify-content-center">
                        <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold shadow" style="background-color: #1E63FF; border: none;">
                            SIMPAN PERUBAHAN
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- MODAL KAMERA LIVE --}}
<div class="modal fade" id="modalKamera" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header border-0 pb-0 mt-2">
                <h5 class="modal-title fw-bold">Ambil Foto Petugas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center p-4">
                <video id="videoKamera" class="w-100 rounded-3 bg-dark mb-3" autoplay playsinline style="height: 300px; object-fit: cover;"></video>
                <canvas id="canvasKamera" class="d-none"></canvas>
                <button type="button" id="btnJepret" class="btn btn-primary rounded-pill px-5 fw-bold shadow">
                    <i class="bi bi-camera-fill me-2"></i> JEPET SEKARANG
                </button>
            </div>
        </div>
    </div>
</div>

{{-- MODAL PREVIEW BESAR --}}
<div class="modal fade" id="modalPreviewLarge" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 bg-transparent">
            <div class="modal-body p-0 d-flex justify-content-center">
                <img src="" class="rounded-4 img-fluid" style="max-height: 85vh;" id="largeFotoModalImage">
            </div>
        </div>
    </div>
</div>

<style>
    .cursor-pointer { cursor: pointer; }
    .dropdown-toggle.hide-arrow::after { display: none !important; }
</style>

@endsection

@push('scripts')
<script>
    // Preview Gambar File
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) { document.getElementById('previewFoto').src = e.target.result; }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Modal Besar
    document.getElementById('modalPreviewLarge').addEventListener('show.bs.modal', function () {
        document.getElementById('largeFotoModalImage').src = document.getElementById('previewFoto').src;
    });

    // Logika Kamera
    const modalKamera = document.getElementById('modalKamera');
    const video = document.getElementById('videoKamera');
    const canvas = document.getElementById('canvasKamera');
    const btnJepret = document.getElementById('btnJepret');
    let stream = null;

    modalKamera.addEventListener('show.bs.modal', function () {
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(s => { stream = s; video.srcObject = stream; })
            .catch(err => { alert("Kamera error: " + err); });
    });

    modalKamera.addEventListener('hide.bs.modal', function () {
        if (stream) stream.getTracks().forEach(t => t.stop());
    });

    btnJepret.addEventListener('click', function () {
        const context = canvas.getContext('2d');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        context.drawImage(video, 0, 0);
        
        canvas.toBlob(blob => {
            const file = new File([blob], "petugas.jpg", { type: "image/jpeg" });
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            document.getElementById('inputFoto').files = dataTransfer.files;
            document.getElementById('previewFoto').src = canvas.toDataURL('image/jpeg');
            bootstrap.Modal.getInstance(modalKamera).hide();
        }, 'image/jpeg');
    });
</script>
@endpush