@extends('layouts.main')

@section('content')
    <div class="content-container mt-4" style="padding: 0 50px;">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0 glitch-text" data-text="Laporan Iuran Kios">Laporan Iuran Kios</h4>
        </div>

        <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
            <div class="card-body p-4">
                <form action="{{ url('/admin/laporan') }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label text-muted" style="font-size: 14px;">Dari Tanggal</label>
                        <input type="date" name="tgl_mulai" class="form-control" value="{{ $tgl_mulai }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label text-muted" style="font-size: 14px;">Sampai Tanggal</label>
                        <input type="date" name="tgl_selesai" class="form-control" value="{{ $tgl_selesai }}" required>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary px-4 fw-bold me-2" style="border-radius: 8px;">
                            <i class="bi bi-funnel-fill me-1"></i> Filter Data
                        </button>
                        <a href="{{ url('/admin/laporan') }}" class="btn btn-light fw-bold"
                            style="border-radius: 8px; border: 1px solid #ddd;">Reset</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="row text-center mb-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm py-4" style="border-radius: 15px; background-color: #f8f9fa;">
                    <p class="text-muted mb-1">Total Pemasukan (Sesuai Filter)</p>
                    <h1 class="fw-bold text-success mb-0">Rp {{ number_format($total_pemasukan, 0, ',', '.') }}</h1>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm py-4" style="border-radius: 15px; background-color: #f8f9fa;">
                    <p class="text-muted mb-1">Total Transaksi (Sesuai Filter)</p>
                    <h1 class="fw-bold text-primary mb-0">{{ $total_transaksi }} Transaksi</h1>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-5" style="border-radius: 15px; overflow: hidden;">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>Tanggal Bayar</th>
                            <th>No. Kios</th>
                            <th>Nama Usaha</th>
                            <th>Petugas</th>
                            <th>Metode</th>
                            <th>Nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($iuran as $i)
                            <tr>
                                <td class="text-muted fw-semibold">{{ \Carbon\Carbon::parse($i->tgl_bayar)->format('d M Y') }}
                                </td>
                                <td><span class="fw-bold">{{ $i->kios->no_kios }}</span></td>
                                <td>{{ $i->kios->nama_usaha }}</td>
                                <td>{{ $i->petugas ? $i->petugas->nama_petugas : 'Sistem' }}</td>
                                <td><span
                                        class="badge {{ $i->metode == 'Tunai' ? 'bg-info text-dark' : 'bg-primary' }}">{{ $i->metode }}</span>
                                </td>
                                <td class="fw-bold text-success">Rp {{ number_format($i->nominal, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <i class="bi bi-search fs-1 d-block mb-2 text-secondary"></i>
                                    Tidak ada data iuran pada rentang tanggal tersebut.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <style>
        .table th {
            font-weight: 600;
            color: #555;
            border-bottom: 2px solid #eaeaea;
        }

        .table td {
            border-bottom: 1px solid #eaeaea;
            color: #444;
        }

        /* CSS Bawaan Laporan Tuan Muda  */
        .table th {
            font-weight: 600;
            color: #555;
            border-bottom: 2px solid #eaeaea;
        }

        .table td {
            border-bottom: 1px solid #eaeaea;
            color: #444;
        }

        /* =========================================================
           CSS SIHIR: EFEK GLITCH CYBERPUNK
           ========================================================= */
        .glitch-text {
            position: relative;
            display: inline-block;
            color: #212529;
            /* Warna teks asli */
        }

        /* Membuat 2 bayangan kloningan teks */
        .glitch-text::before,
        .glitch-text::after {
            content: attr(data-text);
            /* Mengambil teks dari HTML */
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0.8;
        }

        /* Kloningan Kiri (Merah / Pink) */
        .glitch-text::before {
            color: #dc3545;
            /* Merah Bootstrap */
            z-index: -1;
            animation: glitch-anim-1 2.5s infinite linear alternate-reverse;
        }

        /* Kloningan Kanan (Biru / Cyan) */
        .glitch-text::after {
            color: #0dcaf0;
            /* Info/Cyan Bootstrap */
            z-index: -2;
            animation: glitch-anim-2 3s infinite linear alternate-reverse;
        }

        /* Animasi Mengiris dan Menggeser Kloningan 1 */
        @keyframes glitch-anim-1 {
            0% {
                clip-path: inset(20% 0 80% 0);
                transform: translate(-2px, 1px);
            }

            20% {
                clip-path: inset(60% 0 10% 0);
                transform: translate(2px, -1px);
            }

            40% {
                clip-path: inset(40% 0 50% 0);
                transform: translate(-2px, 2px);
            }

            60% {
                clip-path: inset(80% 0 5% 0);
                transform: translate(2px, -2px);
            }

            80% {
                clip-path: inset(10% 0 70% 0);
                transform: translate(-2px, 1px);
            }

            100% {
                clip-path: inset(30% 0 50% 0);
                transform: translate(2px, -1px);
            }
        }

        /* Animasi Mengiris dan Menggeser Kloningan 2 */
        @keyframes glitch-anim-2 {
            0% {
                clip-path: inset(10% 0 60% 0);
                transform: translate(2px, -1px);
            }

            20% {
                clip-path: inset(30% 0 20% 0);
                transform: translate(-2px, 2px);
            }

            40% {
                clip-path: inset(70% 0 10% 0);
                transform: translate(2px, -2px);
            }

            60% {
                clip-path: inset(20% 0 50% 0);
                transform: translate(-2px, 1px);
            }

            80% {
                clip-path: inset(50% 0 30% 0);
                transform: translate(2px, -1px);
            }

            100% {
                clip-path: inset(5% 0 80% 0);
                transform: translate(-2px, 2px);
            }
        }
    </style>

@endsection