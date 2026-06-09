@extends('layouts.pedagang')

@section('content')
<div class="riwayat-container" style="min-height: 100vh; background-color: #FDFDFD; padding-bottom: 80px;">
    
    {{-- Header Sederhana --}}
    <div class="bg-primary text-white pt-5 pb-4" style="background: linear-gradient(135deg, #1E63FF 0%, #56ADFF 100%); border-radius: 0 0 30px 30px;">
        <div class="container mt-4">
            <h3 class="fw-bold mb-1">Riwayat Iuran Anda</h3>
            <p class="opacity-75 small mb-0">Pantau detail pembayaran offline yang ditagih petugas</p>
        </div>
    </div>

    <div class="container mt-4">
        {{-- Form Pencarian --}}
        <form action="{{ route('pedagang.riwayat') }}" method="GET" class="mb-4">
            <div class="input-group shadow-sm rounded-pill overflow-hidden border">
                <span class="input-group-text bg-white border-0 ps-4"><i class="bi bi-search text-muted"></i></span>
                <input type="date" name="search" class="form-control border-0 py-3 shadow-none" value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary px-4 fw-bold" style="background-color: #1E63FF; border: none;">Cari</button>
            </div>
        </form>

        {{-- Daftar Transaksi --}}
        <div class="row g-3">
            @forelse($riwayat as $log)
                <div class="col-12">
                    {{-- Kartu Riwayat (Klik untuk buka modal) --}}
                    <div class="card border-0 shadow-sm rounded-4 p-3 cursor-pointer transaction-card" data-bs-toggle="modal" data-bs-target="#detailModal{{ $log->id }}">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon-box bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 55px; height: 55px;">
                                    <i class="bi bi-receipt fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1 text-dark">Pembayaran Offline</h6>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($log->tanggal_bayar)->translatedFormat('d F Y') }}</small>
                                </div>
                            </div>
                            <div class="text-end">
                                <h6 class="fw-bold text-success mb-1">Rp {{ number_format($log->total_bayar, 0, ',', '.') }}</h6>
                                <span class="badge badge-lunas-muda rounded-pill px-3 py-1 fw-bold">LUNAS</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- MODAL DETAIL STRUK OFFLINE --}}
                <div class="modal fade" id="detailModal{{ $log->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 rounded-4 shadow-lg">
                            <div class="modal-header border-0 pb-0 mt-2">
                                <h5 class="fw-bold"><i class="bi bi-info-circle-fill me-2 text-primary"></i>Detail Tagihan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-4">
                                {{-- Nominal --}}
                                <div class="text-center mb-4">
                                    <p class="text-muted small mb-1 text-uppercase fw-bold">Total Pembayaran</p>
                                    <h2 class="fw-bold text-success mb-2">Rp {{ number_format($log->total_bayar, 0, ',', '.') }}</h2>
                                    <span class="badge bg-success rounded-pill px-3 py-2 fw-bold"><i class="bi bi-check-circle-fill me-1"></i> BERHASIL LUNAS</span>
                                </div>
                                
                                {{-- Rincian Struk --}}
                                <div class="bg-light rounded-4 p-4 mb-3 border">
                                    <div class="d-flex justify-content-between mb-3">
                                        <span class="text-muted small fw-semibold">Metode Bayar</span>
                                        <span class="fw-bold small text-dark">Offline (Di Tempat)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-3">
                                        <span class="text-muted small fw-semibold">Tanggal</span>
                                        <span class="fw-bold small text-dark">{{ \Carbon\Carbon::parse($log->tanggal_bayar)->translatedFormat('l, d F Y') }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-3">
                                        <span class="text-muted small fw-semibold">Jam / Waktu</span>
                                        {{-- Mengambil waktu spesifik dari kolom created_at --}}
                                        <span class="fw-bold small text-dark">{{ \Carbon\Carbon::parse($log->created_at)->format('H:i') }} WIB</span>
                                    </div>
                                    
                                    <hr class="text-muted opacity-25">
                                    
                                  <div class="d-flex justify-content-between align-items-center">
    <span class="text-muted small fw-semibold">Petugas Penagih</span>
    <span class="fw-bold small text-primary bg-primary-subtle px-3 py-1 rounded-pill">
        <i class="bi bi-person-badge-fill me-1"></i> 
        {{-- DIPERBAIKI: Menggunakan 'nama_petugas' sesuai struktur tabel database Tuan Muda --}}
        {{ $log->petugas->nama_petugas ?? 'Petugas Lapangan' }}
    </span>
</div>
                                </div>
                            </div>
                            <div class="modal-footer border-0 pt-0 pb-4 justify-content-center">
                                <button type="button" class="btn btn-light border rounded-pill px-5 fw-bold shadow-sm" data-bs-dismiss="modal">Tutup Detail</button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                {{-- Tampilan Kosong jika belum ada riwayat --}}
                <div class="col-12 text-center py-5 mt-4">
                    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="bi bi-receipt text-muted fs-1"></i>
                    </div>
                    <h5 class="text-muted fw-bold">Belum Ada Riwayat</h5>
                    <p class="text-muted small">Anda belum memiliki riwayat pembayaran iuran dari petugas.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<style>
    /* Styling khusus riwayat agar terlihat profesional */
    .transaction-card { transit ion: 0.3s; border: 1px solid transparent !important; }
    .transaction-card:hover { transform: translateY(-5px); border-color: #1E63FF !important; box-shadow: 0 10px 20px rgba(30, 99, 255, 0.1) !important; }
    .cursor-pointer { cursor: pointer; }
    
    .bg-primary-subtle { background-color: #eef3ff !important; }
    
    /* Warna Hijau Segar kesukaan Tuan Muda */
    .badge-lunas-muda { background-color: #dcfce7 !important; color: #166534 !important; border: 1px solid #bbf7d0; }
</style>
@endsection 