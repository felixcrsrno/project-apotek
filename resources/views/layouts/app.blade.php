<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PharmaPOS')</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary: #10b981; --primary-dark: #059669; --bg-body: #f8fafc;
            --sidebar-bg: #1e293b; --text-main: #1e293b; --text-muted: #64748b;
        }
        body { background-color: var(--bg-body); font-family: 'Plus Jakarta Sans', sans-serif; color: var(--text-main); }

        /* --- SIDEBAR --- */
        .sidebar { width: 260px; background: var(--sidebar-bg); min-height: 100vh; position: fixed; color: white; padding: 24px; z-index: 100; transition: all 0.3s ease; }
        .brand h4 { font-weight: 800; color: var(--primary); margin-bottom: 4px; letter-spacing: -0.5px; }
        .nav-label { display: block; color: #64748b; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; font-weight: 700; margin: 25px 0 10px 10px; }
        .nav-menu { list-style: none; padding: 0; margin: 0; }
        .nav-menu a { color: #cbd5e1; text-decoration: none; display: flex; align-items: center; padding: 12px 16px; border-radius: 12px; transition: 0.2s; font-weight: 500; margin-bottom: 5px; }
        .nav-menu a i { width: 24px; font-size: 18px; margin-right: 12px; }
        .nav-menu a:hover { background: rgba(255, 255, 255, 0.05); color: white; }
        .nav-menu a.active { background: var(--primary); color: white; box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.3); }
        .badge-notif { background: #ef4444; color: white; font-size: 10px; padding: 2px 8px; border-radius: 50px; margin-left: auto; font-weight: 700; }

        .main-content { margin-left: 260px; padding: 40px; width: calc(100% - 260px); }
        .card-custom { border: none; border-radius: 20px; background: white; padding: 30px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02), 0 10px 15px -3px rgba(0,0,0,0.03); }

        @media (max-width: 992px) {
            .sidebar { width: 85px; padding: 25px 15px; text-align: center; }
            .sidebar h4, .sidebar small, .nav-menu span, .nav-label, .badge-notif { display: none; }
            .main-content { margin-left: 85px; width: calc(100% - 85px); padding: 25px; }
            .nav-menu a i { margin-right: 0 !important; width: 100%; }
        }
    </style>
    @stack('styles')
</head>
<body>

<div class="d-flex">
    <aside class="sidebar shadow-lg">
        <div class="brand">
            <h4><i class="fa-solid fa-staff-snake"></i> <span>PHARMAPOS</span></h4>
            <small class="text-white-50">Apotek Al-Fatih v2.0</small>
        </div>

        <span class="nav-label">Menu Utama</span>
        <ul class="nav-menu">
            <li><a href="{{ url('/dashboard') }}" class="{{ Request::is('dashboard') ? 'active' : '' }}"><i class="fa-solid fa-chart-pie me-3"></i> <span>Dashboard</span></a></li>
            <li><a href="{{ url('/transaksi') }}" class="{{ Request::is('transaksi*') ? 'active' : '' }}"><i class="fa-solid fa-cart-shopping me-3"></i> <span>Transaksi</span></a></li>
            <li>
                <a href="{{ url('/obat') }}" class="{{ Request::is('obat*') ? 'active' : '' }}">
                    <i class="fa-solid fa-pills me-3"></i> <span>Data Obat</span>
                </a>
            </li>
            <li><a href="{{ url('/pembelian') }}" class="{{ Request::is('pembelian*') ? 'active' : '' }}"><i class="fa-solid fa-boxes-packing me-3"></i> <span>Faktur Pembelian</span></a></li>
            <li><a href="{{ url('/laporan') }}" class="{{ Request::is('laporan*') ? 'active' : '' }}"><i class="fa-solid fa-file-invoice-dollar me-3"></i> <span>Laporan</span></a></li>
        </ul>

        <span class="nav-label">Sistem</span>
        <ul class="nav-menu">
            {{-- LOGIKA PEMBATASAN ROLE: Hanya tampil jika user adalah admin --}}
            @if(Auth::check() && Auth::user()->role == 'admin')
            <li><a href="{{ url('/user') }}" class="{{ Request::is('user*') ? 'active' : '' }}"><i class="fa-solid fa-user-gear me-3"></i> <span>Manajemen User</span></a></li>
            @endif
            
            <li>
                <form action="{{ url('/logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-link text-danger nav-menu w-100 text-start text-decoration-none px-3 mt-4" style="font-weight: 500;">
                        <i class="fa-solid fa-arrow-right-from-bracket me-3"></i> <span>Keluar</span>
                    </button>
                </form>
            </li>
        </ul>
    </aside>

    <main class="main-content">
        @yield('content')
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>