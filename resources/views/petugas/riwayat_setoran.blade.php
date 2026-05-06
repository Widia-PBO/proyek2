@extends('layouts.main')

@section('content')
<div class="container-fluid px-5 mt-4">
    <div class="text-center mb-5">
        <h3 class="fw-bold">RIWAYAT SETORAN</h3>
        <p class="text-muted">Petugas @ {{ $petugas->nama_petugas }} (BLOK {{ $petugas->wilayah_tugas }})</p>
    </div>

    <div class="row g-4 mb-4 justify-content-center">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center p-3" style="border-radius: 15px;">
                <span class="badge bg-primary-light text-primary mb-2 py-2">Total Iuran Hari Ini</span>
                <h3 class="fw-bold mb-1">Rp{{ number_format($total_setoran, 0, ',', '.') }}</h3>
                <small class="text-muted">Siap disetorkan ke Admin</small>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card border-0 shadow-sm p-3" style="border-radius: 15px;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="badge bg-light text-dark mb-3 py-2 px-3">RINGKASAN TUGAS HARI INI</span>
                        <p class="mb-1">Kios Belum Ditagih: <b>{{ $kios_belum_ditagih }}/{{ $total_kios_aktif }}</b></p>
                        <p class="mb-0">Kios Lunas: <b>{{ $kios_lunas }}</b></p>
                    </div>
                    <div class="position-relative" style="width: 80px; height: 80px;">
                        <div class="progress-circle" style="--value: {{ $persentase }};">
                            <span class="fw-bold">{{ $persentase }}%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center p-3" style="border-radius: 15px;">
                <span class="badge bg-primary-light text-primary mb-2 py-2">Status Setoran</span>
                <h4 class="fw-bold text-dark mt-2">Belum Disetor</h4>
            </div>
        </div>
    </div>

    <div class="text-center mb-5">
        <button onclick="window.print()" class="btn btn-primary px-5 py-2 fw-bold shadow" style="border-radius: 10px; width: 60%;">
            CETAK REKAP SETORAN
        </button>
    </div>

    <h5 class="fw-bold mb-4">Riwayat Penagihan Tunai</h5>
    <div class="row g-3">
        @forelse($riwayat as $r)
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3" style="border-radius: 12px; border-left: 5px solid #198754 !important;">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <small class="text-muted" style="font-size: 11px;">
                        {{ \Carbon\Carbon::parse($r->created_at)->format('d Maret Y | H.i') }} WIB
                    </small>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-light p-2 rounded">
                        <i class="bi bi-shop text-primary fs-4"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="fw-bold mb-0">{{ $r->kios->no_kios }}</h6>
                        <small class="text-muted d-block">Pedagang: {{ $r->kios->nama_pedagang }}</small>
                        <small class="text-muted">Kios: {{ $r->kios->nama_usaha }}</small>
                    </div>
                    <div class="text-end">
                        <p class="fw-bold text-success mb-0">Rp{{ number_format($r->total_bayar, 0, ',', '.') }}</p>
                        <span class="badge bg-success" style="font-size: 10px;">LUNAS</span>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <p class="text-muted">Belum ada penagihan tunai hari ini.</p>
        </div>
        @endforelse
    </div>
</div>

<style>
    .bg-primary-light { background-color: #e7f1ff; }
    .progress-circle {
        width: 80px; height: 80px; border-radius: 50%;
        background: radial-gradient(closest-side, white 79%, transparent 80% 100%),
                    conic-gradient(#0d6efd calc(var(--value) * 1%), #e9ecef 0);
        display: flex; align-items: center; justify-content: center;
    }
    @media print {
        .navbar, .btn, .sidebar { display: none !important; }
        .card { box-shadow: none !important; border: 1px solid #ddd !important; }
    }
</style>
@endsection