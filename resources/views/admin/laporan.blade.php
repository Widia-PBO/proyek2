@extends('layouts.main')

@section('content')
<div class="content-container mt-4 px-5">
    
    <div class="d-print-none mb-4">
        <h4 class="fw-bold mb-3">Laporan & Rekap Iuran</h4>
        <div class="card border-0 shadow-sm p-4" style="border-radius: 15px;">
            <form action="{{ url('/admin/laporan') }}" method="GET" class="row align-items-end">
                <div class="col-md-4">
                    <label class="small text-muted fw-bold">Dari Tanggal</label>
                    <input type="date" name="tgl_mulai" class="form-control" value="{{ $tgl_mulai }}">
                </div>
                <div class="col-md-4">
                    <label class="small text-muted fw-bold">Sampai Tanggal</label>
                    <input type="date" name="tgl_selesai" class="form-control" value="{{ $tgl_selesai }}">
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100 fw-bold">Filter Data</button>
                    <button type="button" onclick="window.print()" class="btn btn-warning w-100 fw-bold">
                        <i class="bi bi-printer me-2"></i> Cetak Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="printable-area bg-white p-4 shadow-sm" style="border-radius: 10px;">
        
        <div class="text-center mb-4">
            <h3 class="fw-bold mb-0">LAPORAN IURAN HARIAN / BULANAN</h3>
            <h4 class="fw-bold">PASAR BARU INDRAMAYU</h4>
            <p class="text-muted small">Periode: {{ \Carbon\Carbon::parse($tgl_mulai)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($tgl_selesai)->format('d M Y') }}</p>
            <hr style="border: 2px solid #000; opacity: 1;">
        </div>

        <div class="row text-center mb-4 fw-bold">
            <div class="col-4 border-end">
                <p class="mb-0 text-muted small">Total Kios</p>
                <h4 class="mb-0">{{ $total_kios }}</h4>
            </div>
            <div class="col-4 border-end">
                <p class="mb-0 text-muted small">Sudah Bayar</p>
                <h4 class="mb-0 text-primary">{{ $sudah_bayar }}</h4>
            </div>
            <div class="col-4">
                <p class="mb-0 text-muted small">Total Iuran</p>
                <h4 class="mb-0 text-success">Rp {{ number_format($total_pemasukan, 0, ',', '.') }}</h4>
            </div>
        </div>

        <table class="table table-bordered align-middle">
            <thead class="bg-light text-center">
                <tr>
                    <th width="50">No</th>
                    <th>No. Kios</th>
                    <th>Nama Pemilik</th>
                    <th>Nama Usaha</th>
                    <th>Jumlah</th>
                    <th>Metode</th>
                    <th>Petugas</th>
                </tr>
            </thead>
            <tbody>
                @foreach($iuran as $index => $i)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center fw-bold">{{ $i->kios->no_kios }}</td>
                    <td>{{ $i->kios->nama_pedagang }}</td>
                    <td>{{ $i->kios->nama_usaha }}</td>
                    <td class="text-end">Rp {{ number_format($i->total_bayar, 0, ',', '.') }}</td>
                    <td class="text-center">{{ $i->metode_pembayaran }}</td>
                    <td>{{ $i->petugas->nama_petugas ?? 'Sistem' }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-dark text-white">
                <tr>
                    <td colspan="4" class="text-center fw-bold">TOTAL PEMASUKAN</td>
                    <td colspan="3" class="text-center fw-bold fs-5">Rp {{ number_format($total_pemasukan, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>

        <div class="row mt-5 text-center">
            <div class="col-6">
                <p class="mb-5">Mengetahui,<br>Kepala Pasar</p>
                <p class="mt-5 fw-bold text-decoration-underline">( ........................................ )</p>
            </div>
            <div class="col-6">
                <p class="mb-5">Indramayu, {{ date('d F Y') }}<br>Bendahara Pasar</p>
                <p class="mt-5 fw-bold text-decoration-underline">( ........................................ )</p>
            </div>
        </div>
    </div>
</div>

<style>
    /* Hilangkan sidebar dan tombol saat print */
    @media print {
        .d-print-none, .sidebar, .navbar, .btn { display: none !important; }
        .content-container { margin: 0 !important; padding: 0 !important; width: 100% !important; }
        .printable-area { box-shadow: none !important; border: none !important; }
        body { background-color: white !important; }
    }
    
    .table-bordered th, .table-bordered td { border: 1px solid #333 !important; }
</style>
@endsection