@extends('layouts.main')

@section('content')
<div class="content-container mt-4" style="padding: 0 50px;">
    
    @php
        // Target pemasukan harian (misal: 1 Juta)
        $target_harian = 1000000; 
        
        // Total kios aktif untuk pembanding (minimal 1 agar tidak error dibagi nol)
        $total_kios_pembanding = \App\Models\Kios::where('status', 'Aktif')->count() ?: 1;

        // Hitung Persentase (Maksimal mentok di 100%)
        $pct_pemasukan = min(($total_iuran / $target_harian) * 100, 100);
        $pct_sudah_bayar = min(($sudah_bayar / $total_kios_pembanding) * 100, 100);
        $pct_belum_bayar = min(($belum_bayar / $total_kios_pembanding) * 100, 100);
    @endphp

    <div class="row text-center mb-4 d-flex justify-content-center">
        <div class="col-md-4">
            <div class="card card-wave-fill fill-success border-0 shadow-sm py-3" style="--water-height: {{ $pct_pemasukan }}%; border-radius: 10px;">
                <div class="card-content">
                    <p class="text-muted mb-1" style="font-size: 14px;">Pemasukan Hari Ini</p>
                    <h2 class="fw-bold mb-0 text-success">Rp {{ number_format($total_iuran, 0, ',', '.') }}</h2>
                    <small class="text-muted mt-1 d-block" style="font-size: 11px;">Target: Rp {{ number_format($target_harian, 0, ',', '.') }}</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-wave-fill fill-primary border-0 shadow-sm py-3" style="--water-height: {{ $pct_sudah_bayar }}%; border-radius: 10px;">
                <div class="card-content">
                    <p class="text-muted mb-1" style="font-size: 14px;">Kios Sudah Bayar</p>
                    <h2 class="fw-bold mb-0 text-primary">{{ $sudah_bayar }} Kios</h2>
                    <small class="text-muted mt-1 d-block" style="font-size: 11px;">Dari total {{ $total_kios_pembanding }} kios aktif</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-wave-fill fill-danger border-0 shadow-sm py-3" style="--water-height: {{ $pct_belum_bayar }}%; border-radius: 10px;">
                <div class="card-content">
                    <p class="text-muted mb-1" style="font-size: 14px;">Kios Belum Bayar</p>
                    <h2 class="fw-bold mb-0 text-danger">{{ $belum_bayar }} Kios</h2>
                    <small class="text-muted mt-1 d-block" style="font-size: 11px;">Perlu segera ditindaklanjuti</small>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Riwayat Pembayaran Hari Ini</h4>
            
    </div>
{{-- Tombol Atur Nominal (Letakkan di samping tombol Export) --}}
<button class="btn btn-dark shadow-sm px-4 fw-bold me-2" data-bs-toggle="modal" data-bs-target="#modalAturNominal">
    <i class="bi bi-gear-fill me-2"></i> Atur Nominal (Rp {{ number_format($tarif, 0, ',', '.') }})
</button>

{{-- Tabel yang sudah diperbaiki --}}
<table class="table table-hover align-middle mb-0">
    <thead class="bg-light">
        <tr>
            <th>Waktu</th>
            <th>No. Kios</th>
            <th>Nama Usaha</th>
            <th>Petugas Penagih</th>
            <th>Metode</th>
            <th>Nominal</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($iuran as $i)
        <tr>
            <td>{{ \Carbon\Carbon::parse($i->created_at)->format('H:i') }} WIB</td>
            <td><span class="fw-bold">{{ $i->kios->no_kios }}</span></td>
            <td>{{ $i->kios->nama_usaha }}</td>
            <td>{{ $i->petugas ? $i->petugas->nama_petugas : 'Mandiri (Sistem)' }}</td>
            <td>
                <span class="badge {{ $i->metode_pembayaran == 'Tunai' ? 'bg-info text-dark' : 'bg-primary' }}">
                    {{ $i->metode_pembayaran }}
                </span>
            </td>
            <td class="fw-bold text-success">Rp {{ number_format($i->total_bayar, 0, ',', '.') }}</td>
            <td><span class="badge bg-success">Lunas</span></td>
        </tr>
        @empty
        {{-- ... kode empty tetap sama ... --}}
        @endforelse
    </tbody>
</table>

{{-- MODAL ATUR NOMINAL --}}
<div class="modal fade" id="modalAturNominal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
            <form action="{{ url('/admin/iuran/update-tarif') }}" method="POST">
                @csrf
                <div class="modal-body p-4 text-center">
                    <i class="bi bi-cash-coin text-primary mb-3" style="font-size: 3rem;"></i>
                    <h5 class="fw-bold">Atur Nominal Iuran</h5>
                    <p class="text-muted small">Ubah tarif iuran harian untuk seluruh kios.</p>
                    <input type="number" name="nominal" class="form-control text-center fs-4 fw-bold mb-3 border-bottom-only" value="{{ $tarif }}" required>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100 fw-bold py-2">Simpan Perubahan</button>
                        <button type="button" class="btn btn-light border w-100 fw-bold" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
   

<style>
    /* Styling Tabel Bawaan */
    .table th { font-weight: 600; color: #555; border-bottom: 2px solid #eaeaea; }
    .table td { border-bottom: 1px solid #eaeaea; color: #444; }

    /* =========================================================
       CSS SIHIR: EFEK GELOMBANG PANTAI (WAVE EFFECT)
       ========================================================= */
    .card-wave-fill {
        position: relative;
        overflow: hidden; 
        background-color: #fff;
        cursor: pointer;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        z-index: 1;
    }

    .card-wave-fill:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important;
    }

    /* Memastikan teks tetap berada di atas air */
    .card-content {
        position: relative;
        z-index: 5; 
        pointer-events: none; /* Agar tidak mengganggu efek hover */
    }

    /* Membuat 2 lapis gelombang menggunakan ::before dan ::after */
    .card-wave-fill::before,
    .card-wave-fill::after {
        content: "";
        position: absolute;
        width: 200%; /* Dibuat raksasa 2x lipat dari kartu */
        height: 200%;
        left: -50%;
        
        /* Rumus Matematika: Agar naik tepat di titik persen (--water-height) */
        bottom: -200%; /* Awalnya sembunyi di bawah */
        transition: bottom 1s cubic-bezier(0.2, 0.8, 0.2, 1);
        z-index: 0;
    }

    /* Lapisan Gelombang 1 (Belakang, sedikit lebih cepat) */
    .card-wave-fill::before {
        border-radius: 40%;
        animation: spinWave 6s linear infinite;
    }

    /* Lapisan Gelombang 2 (Depan, sedikit lebih lambat) */
    .card-wave-fill::after {
        border-radius: 60%;
        animation: spinWave 60s linear infinite;
    }

    /* Memicu air naik saat kursor diarahkan */
    .card-wave-fill:hover::before,
    .card-wave-fill:hover::after {
        /* Naik sesuai persentase yang disuntikkan Laravel */
        bottom: calc(var(--water-height) - 200%); 
    }

    /* Konfigurasi Warna Gelombang (Pastel Transparan) */
    /* 1. Hijau (Pemasukan) */
    .fill-success::before { background-color: rgba(25, 135, 84, 0.15); }
    .fill-success::after { background-color: rgba(25, 135, 84, 0.08); }
    
    /* 2. Biru (Sudah Bayar) */
    .fill-primary::before { background-color: rgba(13, 110, 253, 0.15); }
    .fill-primary::after { background-color: rgba(13, 110, 253, 0.08); }
    
    /* 3. Merah (Belum Bayar) */
    .fill-danger::before { background-color: rgba(220, 53, 69, 0.15); }
    .fill-danger::after { background-color: rgba(220, 53, 69, 0.08); }

    /* Animasi Perputaran Raksasa (Yang menciptakan ilusi riak air) */
    @keyframes spinWave {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
@endsection 