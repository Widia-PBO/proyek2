@extends('layouts.pedagang')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-white border-0 pt-4 pb-0 text-center">
                    <h4 class="fw-bold text-dark">PEMBAYARAN IURAN</h4>
                    <p class="text-muted small">Selesaikan pembayaran untuk Kios {{ Auth::guard('pedagang')->user()->kios->no_kios ?? 'A-01' }}</p>
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="p-3 bg-light rounded-3 mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Iuran Keamanan:</span>
                            <span class="fw-semibold">Rp 3.000</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Iuran Kebersihan:</span>
                            <span class="fw-semibold">Rp 3.000</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Iuran Kios:</span>
                            <span class="fw-semibold">Rp 4.000</span>
                        </div>
                        <hr class="my-3 border-dashed">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold mb-0 text-dark">Total Pembayaran:</h5>
                            {{-- Variabel $tarif sekarang sudah aman digunakan --}}
                            <h4 class="fw-bold text-primary mb-0">Rp {{ number_format($tarif, 0, ',', '.') }}</h4>
                        </div>
                    </div>

                    <div class="text-center mb-4">
                        <p class="small text-muted mb-1">ID Transaksi: #TRX-{{ date('Ymd') }}-{{ Auth::id() }}</p>
                        <p class="small text-muted">Batas Waktu: {{ date('d M Y', strtotime('+1 day')) }} | 23.59 WIB</p>
                    </div>

                    <div class="d-grid">
                        <button id="pay-button" class="btn btn-primary btn-lg fw-bold rounded-pill py-3 shadow-sm">
                            Bayar Sekarang
                        </button>
                        <a href="{{ route('pedagang.dashboard') }}" class="btn btn-link text-muted mt-2 text-decoration-none small">Kembali ke Dashboard</a>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4 opacity-50">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a2/Logo_Midtrans.png/640px-Logo_Midtrans.png" width="80">
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="Mid-client-qNngxskjpLSjPkw4"></script>
<script type="text/javascript">
    document.getElementById('pay-button').onclick = function(){
        // Meminta token ke backend Laravel
        fetch("{{ route('pedagang.proses_pembayaran') }}", {
            method: 'POST',
            headers: { 
                'X-CSRF-TOKEN': '{{ csrf_token() }}', 
                'Content-Type': 'application/json' 
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.snap_token) {
                // Eksekusi popup Midtrans Snap
                window.snap.pay(data.snap_token, {
                    onSuccess: function(result){ 
                        alert("Pembayaran Berhasil!"); 
                        window.location.href="{{ route('pedagang.dashboard') }}"; 
                    },
                    onPending: function(result){ alert("Segera selesaikan transfer Anda."); },
                    onError: function(result){ alert("Pembayaran Gagal!"); }
                });
            } else {
                alert("Error: " + data.error);
            }
        });
    };
</script>
@endpush
@endsection