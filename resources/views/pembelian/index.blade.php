@extends('layouts.app')
@section('title', 'Data Faktur Pembelian | PharmaPOS')

@section('content')
<header class="mb-4 d-flex justify-content-between align-items-center" data-aos="fade-down">
    <div>
        <h2 class="fw-bold m-0 animate__animated animate__fadeInLeft">Data Faktur Pembelian</h2>
        <p class="text-muted">Kelola dan pantau riwayat barang masuk dari supplier.</p>
    </div>
    <a href="{{ url('/pembelian/tambah') }}" class="btn btn-primary fw-bold rounded-pill px-4 shadow btn-animate py-2 animate__animated animate__fadeInRight">
        <i class="fa-solid fa-plus me-2"></i> Tambah Faktur
    </a>
</header>

<div class="card card-custom border-0 shadow-sm overflow-hidden" data-aos="fade-up" data-aos-delay="200">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light text-muted small uppercase">
                <tr>
                    <th width="5%" class="ps-4 py-3">No</th>
                    <th width="15%" class="py-3">No. Faktur</th>
                    <th width="15%" class="py-3">Tanggal</th>
                    <th width="20%" class="py-3">Nama Supplier</th>
                    <th width="15%" class="py-3 text-center">Metode</th>
                    <th width="15%" class="py-3 text-end">Total Bayar</th>
                    <th width="15%" class="text-center py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pembelian as $d)
                <tr class="animate__animated animate__fadeInUp" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                    <td class="ps-4 text-muted fw-bold">{{ $loop->iteration }}</td>
                    <td>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill fw-bold">
                            {{ $d->no_faktur }}
                        </span>
                    </td>
                    <td>
                        <div class="fw-semibold">{{ \Carbon\Carbon::parse($d->tanggal)->format('d M Y') }}</div>
                    </td>
                    
                    <td class="fw-bold text-dark">
                        {{ $d->supplier->nama_supplier ?? 'Tidak Ada Supplier' }}
                    </td>
                    
                    <td class="text-center">
                        @php
                            $isCash = strtolower($d->metode_pembayaran) == 'cash';
                            $colorClass = $isCash ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning';
                            $icon = $isCash ? 'fa-money-bill-1' : 'fa-clock';
                        @endphp
                        <span class="badge {{ $colorClass }} px-3 py-2 rounded-pill fw-bold border">
                            <i class="fa-solid {{ $icon }} me-1"></i> {{ strtoupper($d->metode_pembayaran) }}
                        </span>
                    </td>
                    <td class="text-end fw-bold text-dark pe-4">
                        Rp {{ number_format($d->total_bayar, 0, ',', '.') }}
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ url('/pembelian/edit/'.$d->id_pembelian) }}" class="btn btn-sm btn-white border shadow-sm text-primary rounded-circle p-2 btn-animate" title="Edit Faktur" style="width: 35px; height: 35px; display: inline-flex; align-items: center; justify-content: center;">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>

                            @if(Auth::user()->role === 'admin')
                            <form action="{{ url('/pembelian/hapus/'.$d->id_pembelian) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus faktur ini? Ketahuilah stok obat yang bertambah dari faktur ini mungkin akan ikut disesuaikan.')" class="m-0">
                                @csrf
                                @method('DELETE') {{-- Ganti ke @method('GET') atau hapus jika route kamu di web.php menggunakan Route::get --}}
                                <button type="submit" class="btn btn-sm btn-white border shadow-sm text-danger rounded-circle p-2 btn-animate" title="Hapus Faktur" style="width: 35px; height: 35px; display: inline-flex; align-items: center; justify-content: center;">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                            @else
                            <button type="button" class="btn btn-sm btn-white border shadow-sm text-secondary rounded-circle p-2" title="Hanya Admin yang dapat menghapus" disabled style="width: 35px; height: 35px; display: inline-flex; align-items: center; justify-content: center; opacity: 0.5;">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr data-aos="zoom-in">
                    <td colspan="7" class="text-center py-5 text-muted">
                        <div class="animate__animated animate__pulse animate__infinite">
                            <i class="fa-solid fa-box-open fs-1 mb-3 opacity-25"></i>
                        </div>
                        <br>
                        Belum ada data faktur pembelian.<br>
                        <a href="{{ url('/pembelian/tambah') }}" class="text-primary fw-bold text-decoration-none">Buat Faktur Baru</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
    /* Tambahan styling lokal agar lebih manis */
    .table-hover tbody tr:hover {
        background-color: #f8fafc !important;
    }
    .btn-white {
        background-color: #fff;
        transition: all 0.2s;
    }
    .btn-white:hover {
        background-color: #f1f5f9;
        transform: scale(1.1); /* Mengubah rotasi jadi scale lembut agar seragam saat di-hover */
    }
</style>
@endsection