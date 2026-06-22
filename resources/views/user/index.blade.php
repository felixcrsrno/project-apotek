@extends('layouts.app')
@section('title', 'Manajemen Pengguna | PharmaPOS')

@section('content')
<header class="mb-5">
    <h2 class="fw-bold m-0 text-dark">Manajemen Pengguna</h2>
    <p class="text-muted">Kelola hak akses dan akun karyawan apotek.</p>
</header>

{{-- ALERT SUKSES --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-4" role="alert">
        <strong>Sukses!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- ALERT GAGAL / NOT FOUND (TAMBAHAN BARU) --}}
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show rounded-4" role="alert">
        <strong>Gagal!</strong> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- ALERT ERROR VALIDASI --}}
@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show rounded-4" role="alert">
        <strong>Gagal Menyimpan!</strong>
        <ul class="mb-0 mt-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row g-4">
    <div class="col-lg-12">
        <div class="card card-custom p-4">
            <h5 class="fw-bold mb-4"><i class="fa-solid fa-user-plus text-primary me-2"></i> Tambah User Baru</h5>
            <form method="POST" action="{{ url('/user/simpan') }}" class="row g-3 align-items-end">
                @csrf
                <div class="col-md-4">
                    <label class="small fw-bold text-muted mb-2">Username</label>
                    <input name="username" class="form-control bg-light border-0" placeholder="Masukkan username..." required>
                </div>
                <div class="col-md-4">
                    <label class="small fw-bold text-muted mb-2">Password</label>
                    <input name="password" type="password" class="form-control bg-light border-0" placeholder="••••••••" required>
                </div>
                <div class="col-md-3">
                    <label class="small fw-bold text-muted mb-2">Hak Akses / Role</label>
                    <select name="role" class="form-select bg-light border-0" required>
                        <option value="kasir">Kasir (Staff)</option>
                        <option value="admin">Administrator</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary w-100 fw-bold rounded-3 py-2">
                        <i class="fa-solid fa-check"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="card card-custom px-0 py-0 overflow-hidden">
            <div class="px-4 pt-4 pb-3 bg-light border-bottom">
                <h5 class="fw-bold m-0"><i class="fa-solid fa-users text-primary me-2"></i> Daftar Pengguna Aktif</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="text-muted small text-uppercase">
                        <tr>
                            <th class="py-3 px-4 border-bottom-0">Informasi User</th>
                            <th class="py-3 border-bottom-0">Hak Akses</th>
                            <th class="text-center py-3 border-bottom-0">Status</th>
                            <th class="text-center py-3 px-4 border-bottom-0">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $d)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3 border" style="width: 40px; height: 40px;">
                                        <i class="fa-solid fa-user text-muted"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $d->username }}</div>
                                        <small class="text-muted">Akses Sistem</small>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3">
                                <span class="badge {{ $d->role == 'admin' ? 'bg-danger-subtle text-danger' : 'bg-primary-subtle text-primary' }} px-3 py-2 rounded-pill">
                                    <i class="fa-solid {{ $d->role == 'admin' ? 'fa-user-shield' : 'fa-user-tag' }} me-1"></i>
                                    {{ strtoupper($d->role) }}
                                </span>
                            </td>
                            <td class="text-center py-3">
                                <span class="text-success small fw-bold"><i class="fa-solid fa-circle fa-2xs me-1"></i> Aktif</span>
                            </td>
                            <td class="text-center px-4 py-3">
                                @if(Auth::check() && $d->username != Auth::user()->username)
                                    {{-- Menggunakan $d->getKey() agar otomatis mendeteksi nama primary key apapun di database --}}
                                    <form action="{{ url('/user/hapus/'.$d->getKey()) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light text-danger rounded-pill px-3" onclick="return confirm('Yakin ingin menghapus user {{ $d->username }}?')">
                                            <i class="fa-solid fa-trash-can"></i> Hapus
                                        </button>
                                    </form>
                                @else
                                    <span class="badge bg-light text-muted small border px-3 py-2 rounded-pill">Akun Anda</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection