@extends('layouts.petugas')

@section('content')
<div class="container-fluid px-0 mb-4 position-relative">
    <div class="hero-bg d-flex flex-column align-items-center justify-content-center text-center" 
         style="background: linear-gradient(rgba(255, 255, 255, 0.6), rgba(174, 203, 255, 0.8)), url('https://images.unsplash.com/photo-1542838132-92c53300491e?q=80&w=1974&auto=format&fit=crop') center/cover; height: 220px;">
        <h2 class="fw-bold text-dark mt-2">PENAGIHAN PETUGAS</h2>
        <p class="text-dark fw-medium">Semua penagihan untuk <span class="text-primary fw-bold">{{ $petugas->nama_petugas }}</span></p>
    </div>
</div>

<div class="container mb-5" style="max-width: 1100px; margin-top: -40px; position: relative; z-index: 5;">
    <div class="card border-0 shadow-lg" style="border-radius: 20px;">
        <div class="card-body p-4 p-md-5">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
                @forelse($semuaKios as $kios)
                @php $isLunas = in_array($kios->id, $kiosSudahBayar); @endphp
                <div class="col">
                    <div class="card border-0 shadow h-100 card-kios" style="border-radius: 15px; cursor: pointer;"
                         onclick="showDetail('{{ $kios->no_kios }}', '{{ $kios->nama_pedagang }}', '{{ $kios->nama_usaha }}', '{{ $kios->blok }}', '{{ $isLunas }}', '{{ $kios->id }}')">
                        <div class="card-body p-3 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-3">
                                <i class="bi bi-shop fs-1 text-primary"></i>
                                <div style="line-height: 1.2;">
                                    <div class="fw-bold text-dark fs-5">{{ $kios->no_kios }}</div>
                                    <div class="fw-semibold text-dark" style="font-size: 0.9rem;">{{ $kios->nama_pedagang }}</div>
                                    <div class="text-muted" style="font-size: 0.75rem;">{{ $kios->nama_usaha }}</div>
                                </div>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold text-dark mb-1">Rp10.000</div>
                                @if($isLunas)
                                    <span class="badge bg-success px-3 py-2">LUNAS</span>
                                @else
                                    <span class="badge bg-danger px-3 py-2">BELUM</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-4">Data kios aktif tidak ditemukan.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="fw-bold">Detail Data Kios</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center p-4">
                <div class="p-3 bg-light rounded-4 mb-3">
                    <h4 class="fw-bold mb-1" id="detNoKios"></h4>
                    <p class="text-muted mb-0" id="detNamaUsaha"></p>
                </div>
                <ul class="list-group list-group-flush text-start mb-4">
                    <li class="list-group-item d-flex justify-content-between border-0 px-0">
                        <span class="text-muted">Nama Pedagang</span>
                        <span class="fw-bold" id="detNamaPedagang"></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between border-0 px-0">
                        <span class="text-muted">Blok</span>
                        <span class="fw-bold" id="detBlok"></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between border-0 px-0">
                        <span class="text-muted">Status</span>
                        <span id="detStatus"></span>
                    </li>
                </ul>
                <div id="containerAksi"></div>
            </div>
        </div>
    </div>
</div>

<script>
function showDetail(noKios, namaPedagang, namaUsaha, blok, isLunas, idKios) {
    document.getElementById('detNoKios').innerText = noKios;
    document.getElementById('detNamaUsaha').innerText = namaUsaha;
    document.getElementById('detNamaPedagang').innerText = namaPedagang;
    document.getElementById('detBlok').innerText = blok;
    document.getElementById('detStatus').innerHTML = isLunas == '1' ? '<span class="text-success fw-bold">Lunas</span>' : '<span class="text-danger fw-bold">Belum Bayar</span>';

    let container = document.getElementById('containerAksi');
    if (isLunas == '1') {
        container.innerHTML = `
            <form action="{{ url('/petugas/penagihan/batal') }}" method="POST">
                @csrf <input type="hidden" name="kios_id" value="${idKios}">
                <button type="submit" class="btn btn-danger w-100 fw-bold mb-2 py-2">Batalkan Pembayaran</button>
            </form>`;
    } else {
        container.innerHTML = `
            <form action="{{ url('/petugas/penagihan/bayar') }}" method="POST">
                @csrf <input type="hidden" name="kios_id" value="${idKios}">
                <button type="submit" class="btn btn-primary w-100 fw-bold mb-2 py-2">Bayar Sekarang</button>
            </form>`;
    }
    new bootstrap.Modal(document.getElementById('modalDetail')).show();
}
</script>
@endsection