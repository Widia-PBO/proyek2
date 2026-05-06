@extends('layouts.petugas')

@section('content')
<div class="container mt-5 px-4">
    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-7">
            
            <div class="card border-0 shadow-sm p-4" style="border-radius: 20px;">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h4 class="fw-bold mb-1">Profil Saya</h4>
                        <p class="text-muted small">Kelola informasi pribadi Tuan Muda di sini</p>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success border-0 shadow-sm mb-4" style="border-radius: 10px;">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('petugas.update_profil') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row align-items-center">
                            <div class="col-md-4 text-center mb-4 mb-md-0 border-end">
                                <div class="position-relative d-inline-block">
                                    <div class="bg-primary text-white d-flex justify-content-center align-items-center shadow-sm mx-auto"
                                        style="width: 130px; height: 130px; border-radius: 50%; font-size: 48px; font-weight: bold;">
                                        {{ strtoupper(substr($user->nama_petugas, 0, 1)) }}
                                    </div>
                                    <label for="foto" class="btn btn-sm btn-light border shadow-sm position-absolute bottom-0 end-0 rounded-circle p-2">
                                        <i class="bi bi-camera-fill text-primary"></i>
                                    </label>
                                    <input type="file" name="foto" id="foto" class="d-none">
                                </div>
                                <h6 class="mt-3 fw-bold mb-0">{{ $user->id_petugas }}</h6>
                                <span class="badge bg-primary-light text-primary px-3 py-2 mt-2">Petugas Aktif</span>
                            </div>

                            <div class="col-md-8 ps-md-4">
                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-muted text-uppercase mb-1">Nama Lengkap</label>
                                    <input type="text" name="nama_petugas" class="form-control bg-light border-0 py-2 px-3" 
                                           value="{{ $user->nama_petugas }}" style="border-radius: 10px;" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-muted text-uppercase mb-1">Username</label>
                                    <input type="text" class="form-control bg-light border-0 py-2 px-3" 
                                           value="{{ $user->username }}" style="border-radius: 10px;" readonly>
                                    <small class="text-muted" style="font-size: 11px;">*Username tidak dapat diubah</small>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label small fw-bold text-muted text-uppercase mb-1">Wilayah Tugas</label>
                                        <input type="text" class="form-control bg-light border-0 py-2 px-3" 
                                               value="Blok {{ $user->wilayah_tugas }}" style="border-radius: 10px;" readonly>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label small fw-bold text-muted text-uppercase mb-1">Kontak/WA</label>
                                        <input type="text" name="kontak" class="form-control bg-light border-0 py-2 px-3" 
                                               value="{{ $user->kontak }}" style="border-radius: 10px;" required>
                                    </div>
                                </div>

                                <div class="mt-4 pt-2">
                                    <button type="submit" class="btn btn-primary w-100 fw-bold py-2 shadow-sm" style="border-radius: 12px;">
                                        Update Profil
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .bg-primary-light { background-color: #e7f1ff; }
    .form-control:focus {
        background-color: #f8f9fa;
        box-shadow: none;
        border: 1px solid #0d6efd !important;
    }
</style>
@endsection