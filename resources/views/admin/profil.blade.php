@extends('layouts.main')

@section('content')
<div class="content-container mt-4" style="padding: 0 50px;">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Profil Pengguna</h4>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert" style="border-radius: 10px;">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm text-center py-5" style="border-radius: 15px;">
                <div class="mx-auto mb-3 d-flex justify-content-center align-items-center bg-primary text-white" style="width: 120px; height: 120px; border-radius: 50%; font-size: 50px;">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h4 class="fw-bold mb-1">{{ $user->name }}</h4>
                <p class="text-primary mb-3 fw-semibold">{{ $user->jabatan }}</p>
                
                <div class="d-flex justify-content-center gap-2 mb-3">
                    <span class="badge bg-light text-dark border"><i class="bi bi-geo-alt-fill me-1 text-danger"></i> {{ $user->wilayah }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4 border-bottom pb-3">Informasi Personal</h5>
                    
                    <form action="{{ url('/admin/profil/update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label text-muted" style="font-size: 13px;">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                             </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted" style="font-size: 13px;">Username (Untuk Login)</label>
                                <input type="text" name="username" class="form-control" value="{{ $user->username }}" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label text-muted" style="font-size: 13px;">NIP / ID Pegawai</label>
                                <input type="text" name="nip" class="form-control" value="{{ $user->nip }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted" style="font-size: 13px;">WhatsApp</label>
                                <input type="text" name="whatsapp" class="form-control" value="{{ $user->whatsapp }}">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label class="form-label text-muted" style="font-size: 13px;">Alamat Email</label>
                                <input type="email" name="email" class="form-control" value="{{ $user->email }}">
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary px-4 py-2 fw-bold" style="border-radius: 8px;">
                                <i class="bi bi-save me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<style>
    .form-control {
        background-color: #f8f9fa;
        border: 1px solid #eaeaea;
        border-radius: 8px;
        padding: 10px 15px;
    }
    .form-control:focus {
        background-color: #fff;
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
    }
</style>
@endsection