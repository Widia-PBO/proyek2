@extends('layouts.main')

@section('content')
    <div class="content-container mt-4" style="padding: 0 50px;">

        @php
            $max_kios = 50; 
            $max_petugas = 10;
            $pct_total = ($total_kios > 0) ? min(($total_kios / $max_kios) * 100, 100) : 0;
            $pct_aktif = ($total_kios > 0) ? ($kios_aktif / $total_kios) * 100 : 0;
            $pct_nonaktif = ($total_kios > 0) ? ($kios_nonaktif / $total_kios) * 100 : 0;
            $pct_petugas = ($total_petugas > 0) ? min(($total_petugas / $max_petugas) * 100, 100) : 0;
        @endphp

        <div class="row text-center mb-4">
            <div class="col-md-3">
                <div class="card card-water-fill fill-primary border-0 shadow-sm py-4" style="--water-height: {{ $pct_total }}%;">
                    <p class="mb-1 fw-semibold text-muted" style="font-size: 14px;">Total Kios</p>
                    <h2 class="fw-bold mb-0 text-primary">{{ $total_kios }}</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-water-fill fill-primary border-0 shadow-sm py-4" style="--water-height: {{ $pct_aktif }}%;">
                    <p class="mb-1 fw-semibold text-muted" style="font-size: 14px;">Kios Aktif</p>
                    <h2 class="fw-bold mb-0 text-primary">{{ $kios_aktif }}</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-water-fill fill-primary border-0 shadow-sm py-4" style="--water-height: {{ $pct_nonaktif }}%;">
                    <p class="mb-1 fw-semibold text-muted" style="font-size: 14px;">Kios Non-Aktif</p>
                    <h2 class="fw-bold mb-0 text-primary">{{ $kios_nonaktif }}</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-water-fill fill-primary border-0 shadow-sm py-4" style="--water-height: {{ $pct_petugas }}%;">
                    <p class="mb-1 fw-semibold text-muted" style="font-size: 14px;">Total Petugas</p>
                    <h2 class="fw-bold mb-0 text-primary">{{ $total_petugas }}</h2>
                </div>
            </div>
        </div>

        <div class="d-flex flex-column align-items-center mb-4">
            <div class="input-group mb-3" style="max-width: 600px;">
                <span class="input-group-text bg-white border-end-0 rounded-start-pill"><i class="bi bi-search"></i></span>
                <input type="text" class="form-control border-start-0 rounded-end-pill" placeholder="Cari data...">
            </div>

            <ul class="nav nav-pills custom-toggle-bg p-1 rounded-pill mb-3" style="background-color: #e9ecef;">
                <li class="nav-item">
                    <button class="nav-link active rounded-pill px-4 text-dark" id="pills-kios-tab" data-bs-toggle="pill" data-bs-target="#pills-kios">Data Kios & Pedagang</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link rounded-pill px-4 text-dark" id="pills-petugas-tab" data-bs-toggle="pill" data-bs-target="#pills-petugas">Data Petugas</button>
                </li>
            </ul>

            <div class="w-100 text-end mb-3" style="max-width: 1100px;">
                <button class="btn btn-light shadow-sm px-4 fw-bold me-2 border" data-bs-toggle="modal" data-bs-target="#modalTambahKios">
                    <i class="bi bi-plus-lg"></i> Tambah Kios
                </button>
                <button class="btn btn-light shadow-sm px-4 fw-bold border" data-bs-toggle="modal" data-bs-target="#modalTambahPetugas">
                    <i class="bi bi-plus-lg"></i> Tambah Petugas
                </button>
            </div>

            <div class="card border-0 shadow-sm w-100" style="border-radius: 15px; overflow: hidden; max-width: 1100px;">
                <div class="tab-content">
                    
                    <div class="tab-pane fade show active" id="pills-kios">
                        <table class="table table-hover align-middle mb-0 text-start">
                            <thead class="bg-light text-muted">
                                <tr>
                                    <th class="ps-4">No. Kios</th>
                                    <th>Nama Usaha</th>
                                    <th>Kategori</th>
                                    <th>Nama Pemilik</th>
                                    <th>Status</th>
                                    <th class="text-center pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kios as $k)
                                <tr>
                                    <td class="ps-4 fw-bold text-primary">{{ $k->no_kios }}</td>
                                    <td>{{ $k->nama_usaha }}</td>
                                    <td><span class="badge bg-info text-white opacity-75">{{ $k->jenis_usaha }}</span></td>
                                    <td>{{ $k->pedagang->nama_pemilik ?? '-' }}</td>
                                    <td><span class="badge {{ $k->status == 'Aktif' ? 'bg-success' : 'bg-secondary' }} opacity-75">{{ $k->status }}</span></td>
                                    <td class="text-center pe-4">
                                        <div class="d-flex justify-content-center gap-3">
                                            <a href="#" class="text-primary fs-5" data-bs-toggle="modal" data-bs-target="#modalEditKios{{ $k->id }}"><i class="bi bi-pencil-square"></i></a>
                                            <a href="#" class="text-info fs-5" data-bs-toggle="modal" data-bs-target="#modalResetKios{{ $k->id }}"><i class="bi bi-arrow-counterclockwise"></i></a>
                                            <a href="#" class="text-danger fs-5" data-bs-toggle="modal" data-bs-target="#modalHapusKios{{ $k->id }}"><i class="bi bi-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>

                                <div class="modal fade" id="modalEditKios{{ $k->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
                                            <form action="{{ url('/admin/data-kios/' . $k->id) }}" method="POST">
                                                @csrf @method('PUT')
                                                <div class="modal-header border-0 pb-0"><h5 class="modal-title w-100 text-center fw-bold mt-2 text-primary">Edit Data Kios</h5><button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button></div>
                                                <div class="modal-body px-4 pb-4">
                                                    <label class="small text-muted">Nama Pemilik :</label>
                                                    <input type="text" name="nama_pemilik" class="form-control border-bottom-only mb-3" value="{{ $k->pedagang->nama_pemilik ?? '' }}" required>
                                                    
                                                    <label class="small text-muted">Username Login :</label>
                                                    <input type="text" name="username" class="form-control border-bottom-only mb-3" value="{{ $k->pedagang->username ?? '' }}" required>
                                                    
                                                    <label class="small text-muted">Nama Usaha :</label>
                                                    <input type="text" name="nama_usaha" class="form-control border-bottom-only mb-3" value="{{ $k->nama_usaha }}" required>
                                                    
                                                    <label class="small text-muted">Kategori Usaha :</label>
                                                    <select name="jenis_usaha" class="form-select border-bottom-only mb-3" required>
                                                        <option value="Sembako" {{ $k->jenis_usaha == 'Sembako' ? 'selected' : '' }}>Sembako</option>
                                                        <option value="Buah-buahan" {{ $k->jenis_usaha == 'Buah-buahan' ? 'selected' : '' }}>Buah-buahan</option>
                                                        <option value="Sayuran" {{ $k->jenis_usaha == 'Sayuran' ? 'selected' : '' }}>Sayuran</option>
                                                    </select>

                                                    <label class="small text-muted">Status Akun :</label>
                                                    <select name="status" class="form-select border-bottom-only mb-3">
                                                        <option value="Aktif" {{ $k->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                                        <option value="Non Aktif" {{ $k->status == 'Non Aktif' ? 'selected' : '' }}>Non Aktif</option>
                                                    </select>

                                                    <div class="d-flex justify-content-center gap-3 mt-4">
                                                        <button type="submit" class="btn btn-primary shadow-sm px-4 fw-bold">Update Data</button>
                                                        <button type="button" class="btn btn-light px-4 fw-bold border" data-bs-dismiss="modal">Batal</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="modalResetKios{{ $k->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
                                            <form action="{{ url('/admin/data-kios/'.$k->id.'/reset-password') }}" method="POST">
                                                @csrf @method('PUT')
                                                <div class="modal-body text-center p-4">
                                                    <p class="fw-bold fs-5 mb-4">Reset password {{ $k->nama_usaha }}<br>ke default (pedagang123)?</p>
                                                    <div class="d-flex justify-content-center gap-3">
                                                        <button type="submit" class="btn btn-info text-white shadow-sm px-4 fw-bold">Ya, Reset</button>
                                                        <button type="button" class="btn btn-light px-4 fw-bold border" data-bs-dismiss="modal">Tidak</button>
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
                                                @csrf @method('DELETE')
                                                <div class="modal-body text-center p-4">
                                                    <p class="fw-bold fs-5 mb-4 text-danger">Hapus data {{ $k->nama_usaha }}?</p>
                                                    <div class="d-flex justify-content-center gap-3">
                                                        <button type="submit" class="btn btn-danger shadow-sm px-4 fw-bold">Ya, Hapus</button>
                                                        <button type="button" class="btn btn-light px-4 fw-bold border" data-bs-dismiss="modal">Tidak</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada data kios.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="tab-pane fade" id="pills-petugas">
                        <table class="table table-hover align-middle mb-0 text-start">
                            <thead class="bg-light text-muted">
                                <tr>
                                    <th class="ps-4">Nama Petugas</th>
                                    <th>Username</th>
                                    <th>Wilayah</th>
                                    <th>Kontak</th>
                                    <th class="text-center pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($petugas as $p)
                                <tr>
                                    <td class="ps-4 fw-bold text-primary">{{ $p->nama_petugas }}</td>
                                    <td>{{ $p->username }}</td>
                                    <td>{{ $p->wilayah_tugas }}</td>
                                    <td>{{ $p->kontak }}</td>
                                    <td class="text-center pe-4">
                                        <div class="d-flex justify-content-center gap-3">
                                            <a href="#" class="text-primary fs-5" data-bs-toggle="modal" data-bs-target="#modalEditPetugas{{ $p->id }}"><i class="bi bi-pencil-square"></i></a>
                                            <a href="#" class="text-info fs-5" data-bs-toggle="modal" data-bs-target="#modalResetPetugas{{ $p->id }}"><i class="bi bi-arrow-counterclockwise"></i></a>
                                            <a href="#" class="text-danger fs-5" data-bs-toggle="modal" data-bs-target="#modalHapusPetugas{{ $p->id }}"><i class="bi bi-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>

                                <div class="modal fade" id="modalEditPetugas{{ $p->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
                                            <form action="{{ url('/admin/data-petugas/'.$p->id) }}" method="POST">
                                                @csrf @method('PUT')
                                                <div class="modal-header border-0 pb-0"><h5 class="modal-title w-100 text-center fw-bold mt-2 text-primary">Edit Petugas</h5><button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button></div>
                                                <div class="modal-body px-4 pb-4">
                                                    <input type="text" name="nama_petugas" class="form-control border-bottom-only mb-3" value="{{ $p->nama_petugas }}" required>
                                                    <input type="text" name="username" class="form-control border-bottom-only mb-3" value="{{ $p->username }}" required>
                                                    <input type="text" name="kontak" class="form-control border-bottom-only mb-3" value="{{ $p->kontak }}" required>
                                                    <div class="d-flex justify-content-center gap-3 mt-3">
                                                        <button type="submit" class="btn btn-primary shadow-sm px-4 fw-bold">Update</button>
                                                        <button type="button" class="btn btn-light px-4 fw-bold border" data-bs-dismiss="modal">Batal</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="modalResetPetugas{{ $p->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
                                            <form action="{{ url('/admin/data-petugas/'.$p->id.'/reset-password') }}" method="POST">
                                                @csrf @method('PUT')
                                                <div class="modal-body text-center p-4">
                                                    <p class="fw-bold fs-5 mb-4">Reset password Petugas:<br><span class="text-primary">{{ $p->nama_petugas }}</span>?</p>
                                                    <div class="d-flex justify-content-center gap-3">
                                                        <button type="submit" class="btn btn-info text-white shadow-sm px-4 fw-bold">Ya, Reset</button>
                                                        <button type="button" class="btn btn-light px-4 fw-bold border" data-bs-dismiss="modal">Tidak</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="modalHapusPetugas{{ $p->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
                                            <form action="{{ url('/admin/data-petugas/'.$p->id) }}" method="POST">
                                                @csrf @method('DELETE')
                                                <div class="modal-body text-center p-4">
                                                    <p class="fw-bold fs-5 mb-4 text-danger">Hapus data Petugas:<br><span class="text-danger">{{ $p->nama_petugas }}</span>?</p>
                                                    <div class="d-flex justify-content-center gap-3">
                                                        <button type="submit" class="btn btn-danger shadow-sm px-4 fw-bold">Ya, Hapus</button>
                                                        <button type="button" class="btn btn-light px-4 fw-bold border" data-bs-dismiss="modal">Tidak</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <tr><td colspan="5" class="text-center py-4 text-muted">Belum ada data petugas.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalTambahKios" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
                <form action="{{ url('/admin/data-kios/store') }}" method="POST">
                    @csrf
                    <div class="modal-header border-0 pb-0"><h5 class="modal-title w-100 text-center fw-bold mt-2 text-primary">Tambah Kios Baru</h5><button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button></div>
                    <div class="modal-body px-4 pb-4">
                        <input type="text" name="no_kios" class="form-control border-bottom-only mb-3" placeholder="No. Kios (Contoh: A-01)" required>
                        <input type="text" name="nama_usaha" class="form-control border-bottom-only mb-3" placeholder="Nama Usaha" required>
                        <input type="text" name="nama_pemilik" class="form-control border-bottom-only mb-3" placeholder="Nama Pemilik" required>
                        <input type="text" name="username" class="form-control border-bottom-only mb-3" placeholder="Username Login" required>
                        <select name="jenis_usaha" class="form-select border-bottom-only mb-3" required>
                            <option value="" disabled selected>Pilih Kategori Usaha</option>
                            <option value="Sembako">Sembako</option>
                            <option value="Buah-buahan">Buah-buahan</option>
                            <option value="Sayuran">Sayuran</option>
                        </select>
                        <input type="text" name="blok" class="form-control border-bottom-only mb-3" placeholder="Blok" required>
                        <div class="d-flex justify-content-center gap-3 mt-3">
                            <button type="submit" class="btn btn-primary shadow-sm px-4 fw-bold">Simpan</button>
                            <button type="button" class="btn btn-light border px-4 fw-bold shadow-sm" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalTambahPetugas" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
                <form action="{{ url('/admin/data-petugas/store') }}" method="POST">
                    @csrf
                    <div class="modal-header border-0 pb-0"><h5 class="modal-title w-100 text-center fw-bold mt-2 text-primary">Tambah Petugas Baru</h5><button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button></div>
                    <div class="modal-body px-4 pb-4">
                        <input type="text" name="id_petugas" class="form-control border-bottom-only mb-3" placeholder="ID Petugas (Contoh: P01)" required>
                        <input type="text" name="nama_petugas" class="form-control border-bottom-only mb-3" placeholder="Nama Petugas" required>
                        <input type="text" name="username" class="form-control border-bottom-only mb-3" placeholder="Username Login" required>
                        <select name="wilayah_tugas" class="form-select border-bottom-only mb-3" required>
                            <option value="" disabled selected>Pilih Wilayah</option>
                            <option value="Blok A">Blok A</option>
                            <option value="Blok B">Blok B</option>
                            <option value="Semua Blok">Semua Blok</option>
                        </select>
                        <input type="text" name="kontak" class="form-control border-bottom-only mb-3" placeholder="Kontak (WA)" required>
                        <div class="d-flex justify-content-center gap-3 mt-3">
                            <button type="submit" class="btn btn-primary shadow-sm px-4 fw-bold">Simpan</button>
                            <button type="button" class="btn btn-light border px-4 fw-bold shadow-sm" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .border-bottom-only { border: none !important; border-bottom: 1px solid #ddd !important; border-radius: 0 !important; background: transparent !important; box-shadow: none !important; }
        .border-bottom-only:focus { border-bottom: 2px solid #3887ff !important; }
        .card-water-fill { position: relative; overflow: hidden; background-color: #fff; z-index: 1; transition: 0.3s; cursor: pointer; border-radius: 12px; }
        .card-water-fill::before { content: ""; position: absolute; bottom: 0; left: 0; width: 100%; height: 0%; z-index: -1; transition: height 0.6s ease; background-color: #3887ffd1; }
        .card-water-fill:hover::before { height: var(--water-height, 10%); }
        .nav-pills .nav-link.active { background-color: white !important; box-shadow: 0 2px 5px rgba(0,0,0,0.1); color: #3887ff !important; font-weight: 600; }
    </style>
@endsection