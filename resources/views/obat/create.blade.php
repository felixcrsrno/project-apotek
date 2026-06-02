@extends('layouts.app')
@section('title', 'Tambah Obat | PharmaPOS')

@section('content')
<header class="mb-4">
    <a href="{{ url('/obat') }}" class="text-muted text-decoration-none fw-bold mb-3 d-inline-block">
        <i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Daftar Obat
    </a>
    <h3 class="fw-bold m-0">Tambah Data Obat</h3>
    <p class="text-muted">Lengkapi formulir di bawah untuk menambah stok baru.</p>
</header>

<div class="card card-custom shadow-sm">
    <form action="{{ url('/obat/simpan') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-6 mb-4">
                <label class="form-label fw-bold text-muted small">Nama Obat</label>
                <input type="text" name="nama_obat" class="form-control" placeholder="Contoh: Paracetamol 500mg" required>
            </div>
            <div class="col-md-6 mb-4">
                <label class="form-label fw-bold text-muted small">Kategori</label>
                <select name="kategori" class="form-select" required>
                    <option value="" disabled selected>Pilih Kategori</option>
                    <option value="Analgesik">Analgesik</option>
                    <option value="Antibiotik">Antibiotik</option>
                    <option value="Vitamin">Vitamin</option>
                    <option value="Obat Bebas">Obat Bebas</option>
                    <option value="Suplemen">Suplemen</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>
            <div class="col-md-4 mb-4">
                <label class="form-label fw-bold text-muted small">Harga Jual (Rp)</label>
                <div class="input-group">
                    <span class="input-group-text border-0 bg-light">Rp</span>
                    <input type="number" name="harga" class="form-control" placeholder="0" required>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <label class="form-label fw-bold text-muted small">Jumlah Stok</label>
                <input type="number" name="stok" class="form-control" placeholder="0" required>
            </div>
            <div class="col-md-4 mb-4">
                <label class="form-label fw-bold text-muted small">Tanggal Kedaluwarsa</label>
                <input type="date" name="expired" class="form-control" required>
            </div>
            <div class="col-12 mt-3">
                <hr class="text-muted opacity-25">
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="reset" class="btn btn-light px-4 rounded-3 fw-bold text-muted">Reset</button>
                    <button type="submit" class="btn btn-primary px-4 rounded-3 fw-bold shadow-sm">
                        <i class="fa-solid fa-floppy-disk me-2"></i> Simpan Data Obat
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection