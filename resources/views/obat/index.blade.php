@extends('layouts.app')
@section('title', 'Inventori Obat | PharmaPOS')

@section('content')
<header class="mb-5 d-flex justify-content-between align-items-center" data-aos="fade-down">
    <div>
        <h2 class="fw-bold m-0 animate__animated animate__fadeInLeft">Inventori Obat</h2>
        <p class="text-muted mb-0">Kelola ketersediaan stok dan pembaruan harga obat.</p>
    </div>
    <a href="{{ url('/obat/tambah') }}" class="btn btn-primary shadow rounded-pill px-4 py-2 fw-bold btn-animate animate__animated animate__fadeInRight">
        <i class="fa-solid fa-plus-circle me-2"></i> Tambah Obat Baru
    </a>
</header>

<div class="card card-custom border-0 shadow-sm p-0 overflow-hidden" data-aos="fade-up" data-aos-delay="200">
    <div class="p-4 border-bottom d-flex justify-content-between align-items-center bg-white">
        <h5 class="fw-bold m-0"><i class="fa-solid fa-list me-2 text-primary"></i> Daftar Stok</h5>
        <div class="position-relative w-25">
            <i class="fa-solid fa-magnifying-glass position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
            <input type="text" id="search" class="form-control rounded-pill ps-5" placeholder="Cari nama obat...">
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="bg-light text-muted small uppercase">
                <tr>
                    <th class="p-3 px-4">Informasi Obat</th>
                    <th class="p-3">Harga Satuan</th>
                    <th class="text-center p-3">Status Stok</th>
                    <th class="text-center p-3">Kelola</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                @foreach($obat as $index => $d)
                @php
                    if($d->stok <= 5) { $badge = 'bg-danger-subtle text-danger'; $status = 'Kritis'; }
                    elseif($d->stok <= 15) { $badge = 'bg-warning-subtle text-warning'; $status = 'Menipis'; }
                    else { $badge = 'bg-success-subtle text-success'; $status = 'Aman'; }
                @endphp
                <tr class="animate__animated animate__fadeInUp" style="animation-delay: {{ $index * 0.05 }}s">
                    <td class="p-3 px-4">
                        <div class="fw-bold text-dark fs-6">{{ $d->nama_obat }}</div>
                        <div class="mt-1">
                            <span class="badge bg-light text-muted border">#{{ $d->id_obat }}</span>
                            <span class="badge bg-primary-subtle text-primary border-primary-subtle">{{ $d->kategori }}</span>
                        </div>
                    </td>
                    <td class="p-3 align-middle">
                        <span class="fw-bold text-dark">Rp {{ number_format($d->harga, 0, ',', '.') }}</span>
                    </td>
                    <td class="text-center p-3 align-middle">
                        <span class="badge rounded-pill {{ $badge }} px-3 py-2 fw-bold" style="min-width: 120px;">
                            <i class="fa-solid fa-box-archive me-1"></i> {{ $d->stok }} Unit ({{ $status }})
                        </span>
                    </td>
                    <td class="text-center p-3 align-middle">
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ url('/obat/edit/'.$d->id_obat) }}" class="btn btn-sm btn-white border shadow-sm text-primary rounded-pill px-3 btn-animate">
                                <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                            </a>
                            
                            <button type="button" class="btn btn-sm btn-white border shadow-sm text-danger rounded-pill px-3 btn-animate" 
                                    onclick="confirmDelete('{{ $d->id_obat }}', 'Obat {{ $d->nama_obat }} akan dihapus secara permanen!')">
                                <i class="fa-solid fa-trash-can me-1"></i> Hapus
                            </button>

                            <form id="delete-form-{{ $d->id_obat }}" action="{{ url('/obat/hapus/'.$d->id_obat) }}" method="POST" style="display: none;">
                                @csrf @method('DELETE')
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
    // Fitur Search Interaktif
    document.getElementById('search').addEventListener('keyup', function() {
        let value = this.value.toLowerCase();
        let rows = document.querySelectorAll('#tableBody tr');

        rows.forEach(row => {
            let text = row.querySelector('td:first-child').textContent.toLowerCase();
            if(text.includes(value)) {
                row.style.display = "";
                row.classList.add('animate__animated', 'animate__fadeIn');
            } else {
                row.style.display = "none";
                row.classList.remove('animate__animated', 'animate__fadeIn');
            }
        });
    });

    // Fitur Konfirmasi Hapus
    function confirmDelete(id, message) {
        if (confirm(message)) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
</script>
@endpush
@endsection