@extends('layouts.app')
@section('title', 'Transaksi Kasir | PharmaPOS')

@section('content')
<header class="mb-4 d-flex justify-content-between align-items-center" data-aos="fade-down">
    <div>
        <h3 class="fw-bold m-0 animate__animated animate__fadeInLeft">Terminal Kasir</h3>
        <p class="text-muted">Pilih produk untuk memulai transaksi.</p>
    </div>
    <div class="position-relative w-25 animate__animated animate__fadeInRight">
        <i class="fa-solid fa-magnifying-glass position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
        <input type="text" id="searchObat" class="form-control shadow-sm border-0 rounded-pill ps-5" placeholder="Cari nama obat...">
    </div>
</header>

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm" role="alert">
        <i class="fa-solid fa-triangle-exclamation me-2"></i><strong>Gagal!</strong> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm" role="alert">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row g-4">
    <div class="col-lg-7">
        <div class="row g-3" style="max-height: 700px; overflow-y: auto; padding-right: 5px;" id="daftarObat">
            @foreach($obat as $index => $d)
            <div class="col-md-6 obat-item" data-nama="{{ strtolower($d->nama_obat) }}" data-aos="zoom-in" data-aos-delay="{{ ($index % 6) * 50 }}">
                <div class="card card-custom border-0 shadow-sm p-3 h-100">
                    @php
                        // FIX: Stok di bawah atau sama dengan 15 akan berwarna merah dan berkedip
                        $stokClass = $d->stok <= 15 ? 'bg-danger' : 'bg-success';
                        $animClass = $d->stok <= 15 ? 'animate__animated animate__flash animate__infinite animate__slow' : '';
                    @endphp
                    <span class="badge mb-2 align-self-start {{ $stokClass }} {{ $animClass }}">Stok: {{ $d->stok }}</span>
                    <h6 class="fw-bold mb-1 text-truncate">{{ $d->nama_obat }}</h6>
                    <p class="text-primary fw-bold mb-3">Rp {{ number_format($d->harga, 0, ',', '.') }}</p>
                    
                    <form action="{{ url('/transaksi/tambah') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id_obat" value="{{ $d->id_obat }}">
                        <input type="hidden" name="qty" value="1">
                        
                        {{-- FIX: Mengunci tombol agar tidak bisa diklik jika stok kurang dari 15 atau batas minimal --}}
                        @if($d->stok < 15)
                            <button type="button" class="btn btn-secondary btn-sm rounded-pill w-100" disabled>
                                <i class="fa-solid fa-ban me-1"></i> Stok Menipis (Min. 15)
                            </button>
                        @else
                            <button type="submit" class="btn btn-outline-primary btn-sm rounded-pill w-100 btn-animate">
                                <i class="fa-solid fa-plus me-1"></i> Tambah
                            </button>
                        @endif
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="col-lg-5" data-aos="fade-left">
        <div class="card card-custom border-0 shadow-sm p-4 rounded-4 {{ session('success') ? 'animate__animated animate__headShake' : '' }}" id="box-ringkasan" style="position: sticky; top: 20px;">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold m-0"><i class="fa-solid fa-receipt me-2 text-primary"></i> Ringkasan</h5>
                <button type="button" onclick="confirmClearCart()" class="btn btn-link text-danger small fw-bold text-decoration-none p-0">Bersihkan</button>
            </div>

            <div class="mb-4 custom-scrollbar" style="max-height: 250px; overflow-y: auto;">
                @php $subtotal_cart = 0; @endphp
                @forelse($cart as $id => $item)
                    @php 
                        $item_total = $item['harga'] * $item['qty']; 
                        $subtotal_cart += $item_total;
                    @endphp
                    <div class='d-flex justify-content-between align-items-center mb-3 border-bottom pb-2 animate__animated animate__fadeInRight'>
                        <div>
                            <div class='fw-bold small text-dark'>{{ $item['nama'] }}</div>
                            <small class='text-muted'>
                                {{ $item['qty'] }} x {{ number_format($item['harga']) }}
                                <a href="{{ url('/transaksi/hapus-item/'.$id) }}" class="text-danger ms-2 btn-animate"><i class="fa-solid fa-circle-xmark"></i></a>
                            </small>
                        </div>
                        <div class='fw-bold text-primary'>Rp {{ number_format($item_total) }}</div>
                    </div>
                @empty
                    <div class='text-center py-4 animate__animated animate__fadeIn'>
                        <i class="fa-solid fa-cart-shopping fs-1 text-light mb-2"></i>
                        <p class='text-muted small mb-0'>Keranjang masih kosong</p>
                    </div>
                @endforelse
            </div>

            <form method="POST" action="{{ url('/transaksi/checkout') }}" id="formTransaksi">
                @csrf
                <div class="bg-primary bg-opacity-10 rounded-4 p-3 text-center border border-primary border-opacity-10 mb-3 animate__animated animate__pulse animate__infinite animate__slow">
                    <span class="text-muted small fw-bold d-block mb-1">TOTAL AKHIR</span>
                    <h3 class="fw-bold text-primary m-0">Rp <span id="display_total">{{ number_format($subtotal_cart) }}</span></h3>
                    <input type="hidden" name="total_akhir" id="total_akhir_val" value="{{ $subtotal_cart }}">
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label class="small fw-bold text-muted mb-1">Metode</label>
                        <select name="metode" id="metodePembayaran" class="form-select border-0 bg-light fw-bold rounded-3" required onchange="ubahMetodeBayar()">
                            <option value="Tunai">Tunai</option>
                            <option value="QRIS">QRIS</option>
                            <option value="Transfer">Transfer</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="small fw-bold text-muted mb-1">Bayar (Rp)</label>
                        <input type="number" name="bayar" id="bayar" class="form-control border-0 bg-light fw-bold text-primary rounded-3" required oninput="hitungKembalian()">
                    </div>
                </div>

                <div id="qris-widget" class="d-none text-center bg-light rounded-4 p-3 mb-3 border animate__animated animate__zoomIn">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/d/d0/QR_code_for_mobile_English_Wikipedia.svg" alt="QRIS" width="100" class="img-thumbnail rounded mb-2 shadow-sm">
                    <p class="small fw-bold text-dark m-0">Scan QRIS a/n PharmaPOS</p>
                    <span class="badge bg-success-subtle text-success small">Sistem Midtrans</span>
                </div>

                <div id="transfer-widget" class="d-none text-center bg-light rounded-4 p-3 mb-3 border animate__animated animate__zoomIn">
                    <i class="fa-solid fa-building-columns fs-1 text-primary mb-2"></i>
                    <p class="small fw-bold text-dark m-0">Virtual Account Tersedia</p>
                    <span class="badge bg-success-subtle text-success small">Sistem Midtrans</span>
                </div>

                <div class="d-flex justify-content-between mb-4 px-1" id="box-kembalian">
                    <span class="small fw-bold text-muted">Kembalian:</span>
                    <span class="fw-bold text-success fs-5">Rp <span id="display_kembalian">0</span></span>
                    <input type="hidden" name="kembalian" id="kembalian_val" value="0">
                </div>

                <button type="submit" class="btn btn-primary w-100 py-3 fw-bold rounded-pill shadow-lg btn-animate" {{ empty($cart) ? 'disabled' : '' }}>
                    SIMPAN TRANSAKSI <i class="fa-solid fa-check-circle ms-2"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    .obat-item { transition: all 0.3s ease; }
</style>
@endsection

@push('scripts')
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="Mid-client-eJcJc-4nBnwd3zeg"></script>

<script>
    document.getElementById('searchObat').addEventListener('keyup', function() {
        let keyword = this.value.toLowerCase();
        document.querySelectorAll('.obat-item').forEach(item => {
            let nama = item.getAttribute('data-nama');
            if(nama.includes(keyword)) {
                item.style.display = 'block';
                item.classList.add('animate__animated', 'animate__zoomIn');
            } else {
                item.style.display = 'none';
                item.classList.remove('animate__animated', 'animate__zoomIn');
            }
        });
    });

    function ubahMetodeBayar() {
        const metode = document.getElementById('metodePembayaran').value;
        const total = document.getElementById('total_akhir_val').value;
        const inputBayar = document.getElementById('bayar');
        const qrisWidget = document.getElementById('qris-widget');
        const transferWidget = document.getElementById('transfer-widget');
        const boxKembalian = document.getElementById('box-kembalian');

        qrisWidget.classList.add('d-none');
        transferWidget.classList.add('d-none');
        boxKembalian.classList.remove('d-none');

        if (metode === 'QRIS' || metode === 'Transfer') {
            inputBayar.value = total;
            inputBayar.readOnly = true;
            inputBayar.classList.add('bg-secondary', 'text-white', 'bg-opacity-25');
            boxKembalian.classList.add('d-none');

            if(metode === 'QRIS') qrisWidget.classList.remove('d-none');
            if(metode === 'Transfer') transferWidget.classList.remove('d-none');
        } else {
            inputBayar.value = '';
            inputBayar.readOnly = false;
            inputBayar.classList.remove('bg-secondary', 'text-white', 'bg-opacity-25');
            inputBayar.focus();
        }
        
        hitungKembalian();
    }

    function hitungKembalian() {
        const total = parseInt(document.getElementById('total_akhir_val').value) || 0;
        const bayar = parseInt(document.getElementById('bayar').value) || 0;
        let kembalian = bayar - total;
        
        const display = document.getElementById('display_kembalian');
        
        if (kembalian < 0) {
            kembalian = 0;
            display.parentElement.classList.replace('text-success', 'text-danger');
        } else {
            display.parentElement.classList.replace('text-danger', 'text-success');
        }
        
        display.innerText = kembalian.toLocaleString('id-ID');
        document.getElementById('kembalian_val').value = kembalian;
    }

    function confirmClearCart() {
        if(confirm('Semua item yang sudah dipilih akan dihapus. Lanjutkan?')) {
            window.location.href = "{{ url('/transaksi/hapus-semua') }}";
        }
    }

    document.getElementById('formTransaksi').addEventListener('submit', async function(e) {
        const metode = document.getElementById('metodePembayaran').value;
        const btn = this.querySelector('button[type="submit"]');

        if (metode === 'Tunai') {
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i> Memproses...';
            btn.disabled = true;
            return true; 
        }

        e.preventDefault(); 
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i> Membuka Midtrans...';
        btn.disabled = true;

        try {
            const formData = new FormData(this);
            
            const response = await fetch("{{ url('/transaksi/checkout') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            });

            const result = await response.json();

            if (result.snap_token) {
                window.snap.pay(result.snap_token, {
                    onSuccess: function(response){
                        window.location.href = "{{ url('/transaksi/struk') }}/" + result.id_transaksi;
                    },
                    onPending: function(response){
                        alert("Menunggu pelanggan melakukan pembayaran!");
                        window.location.reload();
                    },
                    onError: function(response){
                        alert("Pembayaran gagal!");
                        btn.innerHTML = 'SIMPAN TRANSAKSI <i class="fa-solid fa-check-circle ms-2"></i>';
                        btn.disabled = false;
                    },
                    onClose: function(){
                        alert('Kamu menutup pop-up sebelum menyelesaikan pembayaran.');
                        btn.innerHTML = 'SIMPAN TRANSAKSI <i class="fa-solid fa-check-circle ms-2"></i>';
                        btn.disabled = false;
                    }
                });
            } else {
                alert(result.message || 'Gagal terhubung ke Midtrans');
                btn.innerHTML = 'SIMPAN TRANSAKSI <i class="fa-solid fa-check-circle ms-2"></i>';
                btn.disabled = false;
            }
        } catch (error) {
            console.error(error);
            alert('Terjadi kesalahan saat checkout.');
            btn.innerHTML = 'SIMPAN TRANSAKSI <i class="fa-solid fa-check-circle ms-2"></i>';
            btn.disabled = false;
        }
    });
</script>
@endpush