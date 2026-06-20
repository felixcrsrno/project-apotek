@extends('layouts.app')
@section('title', 'Tambah Faktur Pembelian | PharmaPOS')

@section('content')
<header class="mb-4 d-flex justify-content-between align-items-center">
    <div>
        <h2 class="fw-bold m-0">Tambah Faktur Pembelian</h2>
        <p class="text-muted">Catat barang masuk dari supplier untuk menambah stok.</p>
    </div>
    <a href="{{ url('/pembelian') }}" class="btn btn-light border fw-bold rounded-pill px-4"><i class="fa-solid fa-arrow-left me-2"></i> Kembali</a>
</header>

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show rounded-4 mb-4" role="alert">
        <div class="fw-bold mb-1"><i class="fa-solid fa-triangle-exclamation me-2"></i> Transaksi Dibatalkan!</div>
        <ul class="mb-0 ps-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show rounded-4 mb-4" role="alert">
        <i class="fa-solid fa-circle-xmark me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<form action="{{ url('/pembelian/simpan') }}" method="POST" id="formFaktur">
    @csrf 
    <div class="card card-custom mb-4">
        <div class="row g-4">
            <div class="col-md-3">
                <label class="form-label">No. Faktur Supplier</label>
                <input type="text" name="no_faktur" class="form-control fw-bold text-primary" placeholder="INV-2026..." value="{{ old('no_faktur') }}" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Tanggal Faktur</label>
                <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', date('Y-m-d')) }}" required>
            </div>
            
            <div class="col-md-4">
                <label class="form-label">Nama Supplier</label>
                <input type="text" name="nama_supplier" class="form-control" placeholder="Ketik nama supplier " value="{{ old('nama_supplier') }}" required>
            </div>
            
            <div class="col-md-2">
                <label class="form-label">Metode</label>
                <select name="metode_pembayaran" class="form-select">
                    <option value="Cash" {{ old('metode_pembayaran') == 'Cash' ? 'selected' : '' }}>Cash</option>
                    <option value="Kredit" {{ old('metode_pembayaran') == 'Kredit' ? 'selected' : '' }}>Tempo / Kredit</option>
                </select>
            </div>
        </div>
    </div>

    <div class="card card-custom p-0 overflow-hidden mb-4">
        <div class="p-4 border-bottom d-flex justify-content-between align-items-center">
            <h6 class="fw-bold m-0"><i class="fa-solid fa-list-check me-2 text-primary"></i> Detail Item</h6>
            <button type="button" class="btn btn-sm btn-success fw-bold rounded-pill" onclick="tambahBaris()">
                <i class="fa-solid fa-plus me-1"></i> Tambah Baris
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-borderless mb-0">
                <thead class="bg-light text-muted small">
                    <tr>
                        <th width="35%">Nama Obat</th>
                        <th width="15%">Qty</th>
                        <th width="20%">Harga Beli (Satuan)</th>
                        <th width="20%">Subtotal</th>
                        <th width="10%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tbodyItem">
                    <tr>
                        <td>
                            <select name="item_obat[]" class="form-select" required>
                                <option value="">Pilih Obat...</option>
                                @foreach($obat_array as $o)
                                    <option value="{{ $o->id_obat }}">{{ $o->nama_obat }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="number" name="qty[]" class="form-control qty-input" value="1" min="1" required oninput="hitungSubtotal(this)">
                        </td>
                        <td>
                            <input type="number" name="harga_beli[]" class="form-control harga-input" placeholder="0" required oninput="hitungSubtotal(this)">
                        </td>
                        <td>
                            <input type="text" class="form-control subtotal-input bg-light fw-bold text-primary border-0" value="0" readonly>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-light text-danger btn-remove" onclick="hapusBaris(this)" disabled>
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row justify-content-end">
        <div class="col-md-5">
            <div class="bg-light rounded-4 p-4 text-end mb-3 border">
                <span class="text-muted fw-bold d-block mb-1">TOTAL FAKTUR SUPPLIER</span>
                <h2 class="fw-bold text-success m-0">Rp <span id="displayTotal">0</span></h2>
                <input type="hidden" name="total_bayar" id="inputTotalFaktur" value="0">
            </div>
            <button type="submit" class="btn btn-primary w-100 py-3 fw-bold rounded-pill shadow">
                <i class="fa-solid fa-floppy-disk me-2"></i> SIMPAN & UPDATE STOK OBAT
            </button>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
    const opsiObat = `@foreach($obat_array as $o)<option value="{{ $o->id_obat }}">{{ $o->nama_obat }}</option>@endforeach`;

    function tambahBaris() {
        const tbody = document.getElementById('tbodyItem');
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td><select name="item_obat[]" class="form-select" required><option value="">Pilih Obat...</option>${opsiObat}</select></td>
            <td><input type="number" name="qty[]" class="form-control qty-input" value="1" min="1" required oninput="hitungSubtotal(this)"></td>
            <td><input type="number" name="harga_beli[]" class="form-control harga-input" placeholder="0" required oninput="hitungSubtotal(this)"></td>
            <td><input type="text" class="form-control subtotal-input bg-light fw-bold text-primary border-0" value="0" readonly></td>
            <td class="text-center"><button type="button" class="btn btn-light text-danger btn-remove" onclick="hapusBaris(this)"><i class="fa-solid fa-trash"></i></button></td>
        `;
        tbody.appendChild(tr);
        cekTombolHapus();
    }

    function hapusBaris(btn) { 
        btn.closest('tr').remove(); 
        hitungTotalAkhir(); 
        cekTombolHapus(); 
    }

    function cekTombolHapus() {
        const btns = document.querySelectorAll('.btn-remove');
        if (btns.length === 1 && btns[0]) {
            btns[0].disabled = true;
        } else {
            btns.forEach(btn => btn.disabled = false);
        }
    }

    function hitungSubtotal(element) {
        const row = element.closest('tr');
        const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
        const harga = parseFloat(row.querySelector('.harga-input').value) || 0;
        const subtotal = qty * harga;
        
        row.querySelector('.subtotal-input').value = subtotal.toLocaleString('id-ID');
        row.querySelector('.subtotal-input').setAttribute('data-nilai', subtotal);
        hitungTotalAkhir();
    }

    function hitungTotalAkhir() {
        let total = 0;
        document.querySelectorAll('.subtotal-input').forEach(input => { 
            total += parseFloat(input.getAttribute('data-nilai')) || 0; 
        });
        document.getElementById('displayTotal').innerText = total.toLocaleString('id-ID');
        document.getElementById('inputTotalFaktur').value = total;
    }
</script>
@endpush