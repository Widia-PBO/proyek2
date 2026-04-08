    @extends('layouts.main')

    @section('content')
    <div class="content-container mt-4" style="padding: 0 50px;">
        
        <div class="row text-center mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm py-3" style="border-radius: 10px;">
                    <p class="text-muted mb-1" style="font-size: 14px;">Total Kios</p>
                    <h2 class="fw-bold mb-0">40</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm py-3" style="border-radius: 10px;">
                    <p class="text-muted mb-1" style="font-size: 14px;">Kios Aktif</p>
                    <h2 class="fw-bold mb-0">30</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm py-3" style="border-radius: 10px;">
                    <p class="text-muted mb-1" style="font-size: 14px;">Kios Tidak Aktif</p>
                    <h2 class="fw-bold mb-0">10</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm py-3" style="border-radius: 10px;">
                    <p class="text-muted mb-1" style="font-size: 14px;">Total Petugas</p>
                    <h2 class="fw-bold mb-0">5</h2>
                </div>
            </div>
        </div>

        <div class="d-flex flex-column align-items-center mb-4">
            <div class="input-group mb-3" style="max-width: 600px;">
                <span class="input-group-text bg-white border-end-0 rounded-start-pill" id="search-icon">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" class="form-control border-start-0 rounded-end-pill" placeholder="Cari data..." aria-describedby="search-icon">
            </div>

            <ul class="nav nav-pills custom-toggle-bg p-1 rounded-pill" id="pills-tab" role="tablist" style="background-color: #e9ecef;">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active rounded-pill px-4 text-dark" id="pills-kios-tab" data-bs-toggle="pill" data-bs-target="#pills-kios" type="button" role="tab" aria-selected="true">Data Kios</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-pill px-4 text-dark" id="pills-petugas-tab" data-bs-toggle="pill" data-bs-target="#pills-petugas" type="button" role="tab" aria-selected="false">Data Petugas</button>
                </li>
            </ul>
            
            <div class="w-100 text-end mt-2" style="max-width: 1000px;">
                <button class="btn btn-light shadow-sm px-4 py-2 fw-bold" style="border-radius: 8px; border: 1px solid #ddd;">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Data
                </button>
            </div>
        </div>  

        <div class="card border-0 shadow-sm" style="border-radius: 15px; overflow: hidden;">
            <div class="tab-content" id="pills-tabContent">
                
                <div class="tab-pane fade show active" id="pills-kios" role="tabpanel" aria-labelledby="pills-kios-tab">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>No. Kios</th>
                                    <th>Nama Usaha</th>
                                    <th>Jenis Usaha</th>
                                    <th>Nama Pemilik</th>
                                    <th>Blok</th>
                                    <th>Username</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                    <tbody>
    @forelse($kios as $k)
    <tr>
        <td>{{ $k->no_kios }}</td>
        <td>{{ $k->nama_usaha }}</td>
        <td>{{ $k->jenis_usaha }}</td>
        <td>{{ $k->nama_pemilik }}</td>
        <td>{{ $k->blok }}</td>
        <td>{{ $k->username }}</td>
        <td><span class="badge {{ $k->status == 'Aktif' ? 'bg-success' : 'bg-danger' }}">{{ $k->status }}</span></td>
        <td>
            <a href="#" class="text-primary me-2 fs-5" data-bs-toggle="modal" data-bs-target="#modalEditKios{{ $k->id }}"><i class="bi bi-pencil-fill"></i></a>
            <a href="#" class="text-danger fs-5" data-bs-toggle="modal" data-bs-target="#modalHapusKios{{ $k->id }}"><i class="bi bi-trash-fill"></i></a>
            <a href="#" class="text-warning me-2 fs-5" data-bs-toggle="modal" data-bs-target="#modalResetKios{{ $k->id }}">
    <i class="bi bi-arrow-counterclockwise"></i>
</a>
        </td>
    </tr>
    <div class="modal fade" id="modalResetKios{{ $k->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
                <form action="{{ url('/admin/data-kios/'.$k->id.'/reset-password') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header border-0 pb-0">
                        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center px-4 pb-4">
                        <p class="fw-bold fs-5 mb-4 text-dark">Apakah anda yakin ingin mereset<br>password {{ $k->nama_usaha }} ke default (toko123)?</p>
                        <div class="d-flex justify-content-center gap-3">
                            <button type="submit" class="btn btn-warning shadow-sm px-4 fw-bold text-white" style="border-radius: 8px;">Ya, reset</button>
                            <button type="button" class="btn btn-light shadow-sm px-4 fw-bold" style="background-color: #e9ecef; border-radius: 8px;" data-bs-dismiss="modal">Tidak</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>  
    <div class="modal fade" id="modalEditKios{{ $k->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
                <form action="{{ url('/admin/data-kios/'.$k->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title w-100 text-center fw-bold mt-2">Edit Data Kios</h5>
                        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-4 pb-4">
                        <div class="mb-2 position-relative">
                            <label class="form-label text-muted mb-0" style="font-size: 11px;">Nomor Kios :</label>
                            <input type="text" class="form-control border-bottom-only bg-transparent shadow-none px-0" value="{{ $k->no_kios }}" disabled>
                            <i class="bi bi-lock-fill position-absolute text-muted" style="right: 5px; top: 25px;"></i>
                        </div>
                        <div class="mb-2 position-relative">
                            <label class="form-label text-muted mb-0" style="font-size: 11px;">Nama Usaha :</label>
                            <input type="text" name="nama_usaha" class="form-control border-bottom-only bg-transparent shadow-none px-0" value="{{ $k->nama_usaha }}">
                        </div>
                        <div class="mb-2 position-relative">
                            <label class="form-label text-muted mb-0" style="font-size: 11px;">Jenis Usaha :</label>
                            <select name="jenis_usaha" class="form-select border-bottom-only bg-transparent shadow-none px-0">
                                <option value="Sembako" {{ $k->jenis_usaha == 'Sembako' ? 'selected' : '' }}>Sembako</option>
                                <option value="Buah-buahan" {{ $k->jenis_usaha == 'Buah-buahan' ? 'selected' : '' }}>Buah-buahan</option>
                                <option value="Sayuran" {{ $k->jenis_usaha == 'Sayuran' ? 'selected' : '' }}>Sayuran</option>
                            </select>
                        </div>
                        <div class="mb-2 position-relative">
                            <label class="form-label text-muted mb-0" style="font-size: 11px;">Username :</label>
                            <input type="text" name="username" class="form-control border-bottom-only bg-transparent shadow-none px-0" value="{{ $k->username }}">
                        </div>
                        <div class="mb-4 position-relative">
                            <label class="form-label text-muted mb-0" style="font-size: 11px;">Status Akun :</label>
                            <select name="status" class="form-select border-bottom-only bg-transparent shadow-none px-0 text-primary fw-semibold">
                                <option value="Aktif" {{ $k->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Non Aktif" {{ $k->status == 'Non Aktif' ? 'selected' : '' }}>Non Aktif</option>
                            </select>
                        </div>
                        <div class="d-flex justify-content-center gap-3">
                            <button type="submit" class="btn btn-primary shadow-sm px-4 fw-bold" style="border-radius: 8px;">Simpan</button>
                            <button type="button" class="btn btn-light shadow-sm px-4 fw-bold" style="background-color: #e9ecef; border-radius: 8px;" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalHapusKios{{ $k->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
                <form action="{{ url('/admin/data-kios/'.$k->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header border-0 pb-0">
                        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center px-4 pb-4">
                        <p class="fw-bold fs-5 mb-4 text-dark">Apakah anda yakin menghapus data<br>{{ $k->nama_usaha }}?</p>
                        <div class="d-flex justify-content-center gap-3">
                            <button type="submit" class="btn btn-danger shadow-sm px-4 fw-bold" style="border-radius: 8px;">Ya, hapus</button>
                            <button type="button" class="btn btn-light shadow-sm px-4 fw-bold" style="background-color: #e9ecef; border-radius: 8px;" data-bs-dismiss="modal">Tidak</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @empty
    <tr>
        <td colspan="8" class="text-center text-muted py-4">Belum ada data kios.</td>
    </tr>
    @endforelse
</tbody>
                        </table>
                    </div>          
                </div>

                <div class="tab-pane fade" id="pills-petugas" role="tabpanel" aria-labelledby="pills-petugas-tab">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>ID Petugas</th>
                                    <th>Nama Petugas</th>
                                    <th>Username</th>
                                    <th>Wilayah Tugas</th>
                                    <th>Kontak</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>P001</td>
                                    <td>Budiman</td>
                                    <td>budi_pasar</td>
                                    <td>Blok A</td>
                                    <td>0812312380112</td>
                                    <td>Aktif</td>
    <td>
                                        <a href="#" class="text-primary me-2 fs-5" data-bs-toggle="modal" data-bs-target="#modalEdit"><i class="bi bi-pencil-fill"></i></a>
                                        <a href="#" class="text-danger me-2 fs-5" data-bs-toggle="modal" data-bs-target="#modalReset"><i class="bi bi-arrow-counterclockwise"></i></a>
                                        <a href="#" class="text-danger fs-5" data-bs-toggle="modal" data-bs-target="#modalHapus"><i class="bi bi-trash-fill"></i></a>
                                    </td>   
                                </tr>
                                <tr><td colspan="7">&nbsp;</td></tr>
                                <tr><td colspan="7">&nbsp;</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <style>
        .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
            background-color: white !important;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            font-weight: 600;
        }
        .table th {
            font-weight: 600;
            color: #555;
            border-bottom: 2px solid #eaeaea;
        }
        .table td {
            border-bottom: 1px solid #eaeaea;
            color: #444;
        }
    </style>
    <div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title w-100 text-center fw-bold mt-2">Edit Data</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4 pb-4">
                    <div class="mb-2 position-relative">
                        <label class="form-label text-muted mb-0" style="font-size: 11px;">Nomor Kios :</label>
                        <input type="text" class="form-control border-bottom-only bg-transparent shadow-none px-0" value="A-01" disabled>
                        <i class="bi bi-lock-fill position-absolute text-muted" style="right: 5px; top: 25px;"></i>
                    </div>
                    <div class="mb-2 position-relative">
                        <label class="form-label text-muted mb-0" style="font-size: 11px;">Nama Usaha :</label>
                        <input type="text" class="form-control border-bottom-only bg-transparent shadow-none px-0" value="Toko Supri">
                        <i class="bi bi-pencil-fill position-absolute text-dark" style="right: 5px; top: 25px;"></i>
                    </div>
                    <div class="mb-2 position-relative">
                        <label class="form-label text-muted mb-0" style="font-size: 11px;">Jenis Usaha :</label>
                        <select class="form-select border-bottom-only bg-transparent shadow-none px-0">
                            <option selected>Sembako</option>
                            <option>Buah-buahan</option>
                            <option>Sayuran</option>
                        </select>
                    </div>
                    <div class="mb-2 position-relative">
                        <label class="form-label text-muted mb-0" style="font-size: 11px;">Username :</label>
                        <input type="text" class="form-control border-bottom-only bg-transparent shadow-none px-0" value="Supri">
                        <i class="bi bi-pencil-fill position-absolute text-dark" style="right: 5px; top: 25px;"></i>
                    </div>
                    <div class="mb-4 position-relative">
                        <label class="form-label text-muted mb-0" style="font-size: 11px;">Status Akun :</label>
                        <select class="form-select border-bottom-only bg-transparent shadow-none px-0 text-primary fw-semibold">
                            <option selected>Aktif/Non Aktif</option>
                        </select>
                    </div>
                    
                    <div class="d-flex justify-content-center gap-3">
                        <button class="btn btn-light shadow-sm px-4 fw-bold" style="background-color: #e9ecef; border-radius: 8px;">Simpan</button>
                        <button class="btn btn-light shadow-sm px-4 fw-bold" style="background-color: #e9ecef; border-radius: 8px;" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalReset" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center px-4 pb-4">
                    <p class="fw-bold fs-5 mb-4 text-dark">Apakah anda yakin ingin mereset<br>password Toko Supri ke default (toko123)</p>
                    <div class="d-flex justify-content-center gap-3">
                        <button class="btn btn-light shadow-sm px-4 fw-bold" style="background-color: #e9ecef; border-radius: 8px;">Ya, reset</button>
                        <button class="btn btn-light shadow-sm px-4 fw-bold" style="background-color: #e9ecef; border-radius: 8px;" data-bs-dismiss="modal">Tidak</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalHapus" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center px-4 pb-4">
                    <p class="fw-bold fs-5 mb-4 text-dark">Apakah anda yakin menghapus data<br>tersebut?</p>
                    <div class="d-flex justify-content-center gap-3">
                        <button class="btn btn-light shadow-sm px-4 fw-bold" style="background-color: #e9ecef; border-radius: 8px;">Ya, hapus</button>
                        <button class="btn btn-light shadow-sm px-4 fw-bold" style="background-color: #e9ecef; border-radius: 8px;" data-bs-dismiss="modal">Tidak</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .border-bottom-only {
            border: none !important;
            border-bottom: 1px solid #ccc !important;
            border-radius: 0 !important;
        }           
        .border-bottom-only:focus {
            border-bottom: 2px solid #000 !important;
            box-shadow: none !important;
        }
    </style>
    @endsection