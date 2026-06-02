@extends('layouts.app')
@section('title', 'Edit Obat | PharmaPOS')

@section('content')
<header class="mb-4">
    <a href="{{ url('/obat') }}" class="text-muted text-decoration-none fw-bold mb-3 d-inline-block">
        <i class="fa-solid fa-arrow-left me-2"></i> Kembali
    </a>
    <h3 class="fw-bold m-0">Edit Data Obat</h3>
    <p class="text-muted">ID Obat: <strong>#{{ $obat->id_obat }}</strong></p>
</header>

<div class="card card-custom shadow-sm">
    <form action="{{ url('/obat/update/'.$obat->id_obat) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="row">
            <div class="col-md-6 mb-4">
                <label class="form-label fw-bold text-muted small">Nama Obat</label>
                <input type="text" name="nama_obat" class="form-control" value="{{ $obat->nama_obat }}" required>
            </div>
            <div class="col-md-6 mb-4">
                <label class="form-label fw-bold text-muted small">Kategori</label>
                <select name="kategori" class="form-select" required>
                    @php $categories = ["Analgesik", "Antibiotik", "Vitamin", "Obat Bebas", "Suplemen", "Herbal", "Lainnya"]; @endphp
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ $obat->kategori == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 mb-4">
                <label class="form-label fw-bold text-muted small">Harga (Rp)</label>
                <div class="input-group">
                    <span class="input-group-text border-0 bg-light">Rp</span>
                    <input type="number" name="harga" class="form-control" value="{{ $obat->harga }}" required>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <label class="form-label fw-bold text-muted small">Jumlah Stok</label>
                <input type="number" name="stok" class="form-control" value="{{ $obat->stok }}" required>
            </div>
            <div class="col-md-4 mb-4">
                <label class="form-label fw-bold text-muted small">Tanggal Kedaluwarsa</label>
                <input type="date" name="expired" class="form-control" value="{{ $obat->expired }}" required>
            </div>
            <div class="col-12 mt-3 text-end">
                <hr class="text-muted opacity-25">
                <a href="{{ url('/obat') }}" class="btn btn-light px-4 fw-bold text-muted text-decoration-none me-2">Batal</a>
                <button type="submit" class="btn btn-primary px-4 rounded-3 fw-bold shadow-sm">
                    <i class="fa-solid fa-save me-2"></i> Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
</div>
@endsection