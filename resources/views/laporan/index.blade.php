@extends('layouts.app')
@section('title', 'Laporan Penjualan')

@section('content')
<header class="mb-4 d-flex justify-content-between align-items-end" data-aos="fade-down">
    <div>
        <h2 class="fw-bold m-0 animate__animated animate__fadeInLeft">Laporan Penjualan</h2>
        <p class="text-muted mb-0">Analisis histori transaksi dan pendapatan.</p>
    </div>
    <div class="d-print-none">
        <a href="{{ url('/laporan/export?tgl='.request('tgl')) }}" class="btn btn-success fw-bold px-4 rounded-3 shadow-sm btn-animate">
            <i class="fa-solid fa-file-excel me-2"></i> Export Excel
        </a>
    </div>
</header>

<div class="row g-4 mb-4">
    <div class="col-md-6" data-aos="zoom-in" data-aos-delay="100">
        <div class="card card-custom p-4 border-0 shadow-sm bg-white">
            <p class="text-muted small fw-bold mb-1">TOTAL TRANSAKSI</p>
            <h3 class="fw-bold mb-0 text-primary">{{ number_format($summary['total_transaksi']) }} Nota</h3>
        </div>
    </div>
    <div class="col-md-6" data-aos="zoom-in" data-aos-delay="300">
        <div class="card card-custom p-4 border-0 shadow-sm bg-white">
            <p class="text-muted small fw-bold mb-1">TOTAL PENDAPATAN</p>
            <h3 class="fw-bold mb-0 text-success">Rp {{ number_format($summary['total_pendapatan']) }}</h3>
        </div>
    </div>
</div>

<div class="card card-custom p-0 overflow-hidden border-0 shadow-sm" data-aos="fade-up" data-aos-delay="500">
    <div class="p-4 border-bottom bg-light d-flex justify-content-between align-items-center">
        <h6 class="fw-bold m-0">Riwayat Transaksi</h6>
        <form class="d-flex gap-2" method="GET" action="{{ url('/laporan') }}">
            <input type="date" name="tgl" class="form-control form-control-sm rounded-pill px-3" value="{{ request('tgl') }}">
            <button type="submit" class="btn btn-sm btn-primary rounded-pill px-3">Filter</button>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="bg-white text-muted small">
                <tr>
                    <th class="py-3 px-4">ID Transaksi</th>
                    <th class="py-3">Tanggal</th>
                    <th class="py-3">Metode</th>
                    <th class="text-end py-3 px-4">Total Akhir</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksi as $d)
                <tr class="animate__animated animate__fadeInUp">
                    <td class="px-4 py-3 fw-bold">#TRX-{{ $d->id_transaksi }}</td>
                    <td class="py-3">{{ \Carbon\Carbon::parse($d->tanggal)->format('d/m/Y') }}</td>
                    <td class="py-3"><span class="badge bg-primary-subtle text-primary rounded-pill">{{ $d->metode }}</span></td>
                    <td class="text-end px-4 py-3 fw-bold text-success">Rp {{ number_format($d->total_akhir) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection