@extends('layouts.app')
@section('title', 'Dashboard | PharmaPOS')

@push('styles')
<style>
    .stat-bg {
        position: absolute;
        top: -2px;
        right: -10px;
        width: 100px;
        height: 100px;
        background: rgba(59, 130, 246, 0.05);
        border-radius: 50%;
        animation: float 6s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }

    .chart-container {
        position: relative;
        animation: slideIn 0.8s ease-out;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Mobile Responsive Styles */
    @media (max-width: 576px) {
        header {
            flex-direction: column;
            gap: 1rem !important;
        }
        
        header h2 {
            font-size: 1.5rem !important;
        }
        
        .filter-bar {
            width: 100% !important;
            flex-direction: column !important;
            gap: 1rem !important;
        }
        
        .filter-bar > div {
            width: 100%;
            flex-direction: column !important;
            gap: 0.5rem !important;
        }
        
        .filter-bar input {
            font-size: 14px;
        }
        
        .filter-bar button {
            width: 100%;
        }
        
        .card-custom {
            padding: 1rem !important;
        }
        
        .card-custom h5,
        .card-custom h6 {
            font-size: 0.95rem !important;
        }
        
        .stat-bg {
            width: 80px;
            height: 80px;
        }
    }
    
    @media (max-width: 768px) {
        .chart-height-harian {
            height: 250px !important;
        }
        
        .chart-height-metode {
            height: 180px !important;
        }
        
        .chart-height-terlaris {
            height: 250px !important;
        }
    }
    
    @media (min-width: 769px) {
        .chart-height-harian {
            height: 350px;
        }
        
        .chart-height-metode {
            height: 200px;
        }
        
        .chart-height-terlaris {
            height: 300px;
        }
    }
</style>
@endpush

@section('content')
<header class="d-flex justify-content-between align-items-start align-items-md-center mb-4 mb-md-5 flex-column flex-md-row" data-aos="fade-down">
    <div class="mb-3 mb-md-0">
        <h2 class="fw-bold mb-1 animate__animated animate__fadeInLeft">Ringkasan Performa</h2>
        <p class="text-muted mb-0">Pantau aktivitas apotek Anda secara real-time.</p>
    </div>
    <form action="{{ url('/dashboard') }}" method="GET" class="filter-bar d-flex align-items-center gap-2 gap-md-3 shadow-sm bg-white rounded-4 p-2 border animate__animated animate__fadeInRight flex-wrap w-100 w-md-auto">
        <div class="d-flex align-items-center gap-2 px-2 flex-grow-1 flex-md-grow-0">
            <input type="date" name="tgl_mulai" class="form-control form-control-sm border-0 bg-transparent fw-bold" value="{{ $tgl_mulai }}">
            <span class="text-muted d-none d-md-inline">-</span>
            <input type="date" name="tgl_selesai" class="form-control form-control-sm border-0 bg-transparent fw-bold" value="{{ $tgl_selesai }}">
        </div>
        <button type="submit" class="btn btn-primary btn-sm px-3 px-md-4 rounded-pill btn-animate shadow-sm flex-grow-1 flex-md-grow-0">Terapkan</button>
    </form>
</header>

<!-- Statistics Cards with Animation -->
<div class="row g-2 g-md-4 mb-4 mb-md-5">
    <div class="col-lg-3 col-md-6 col-sm-6 col-12" data-aos="zoom-in" data-aos-delay="100">
        <div class="card card-custom p-4 border-0 shadow-sm bg-white position-relative overflow-hidden">
            <div class="stat-bg"></div>
            <div class="position-relative">
                <span class="text-muted small fw-bold d-block mb-2">TOTAL PENDAPATAN</span>
                <h3 class="fw-bold mb-2 text-success animate__animated animate__fadeInUp">Rp {{ number_format($total, 0, ',', '.') }}</h3>
                <small class="text-success"><i class="fa-solid fa-arrow-up"></i> +12.5% dari periode lalu</small>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12" data-aos="zoom-in" data-aos-delay="150">
        <div class="card card-custom p-4 border-0 shadow-sm bg-white position-relative overflow-hidden">
            <div class="stat-bg"></div>
            <div class="position-relative">
                <span class="text-muted small fw-bold d-block mb-2">JUMLAH TRANSAKSI</span>
                <h3 class="fw-bold mb-2 text-primary animate__animated animate__fadeInUp" style="animation-delay: 0.1s;">{{ number_format($trx) }} <small class="fs-6 fw-normal text-muted">Nota</small></h3>
                <small class="text-info"><i class="fa-solid fa-arrow-up"></i> Rata-rata Rp {{ number_format($rata_rata_trx, 0, ',', '.') }}/nota</small>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12" data-aos="zoom-in" data-aos-delay="200">
        <div class="card card-custom p-4 border-0 shadow-sm bg-white position-relative overflow-hidden {{ $jml_kritis > 0 ? 'animate__animated animate__pulse animate__infinite' : '' }}">
            <div class="stat-bg"></div>
            <div class="position-relative">
                <span class="text-muted small fw-bold d-block mb-2">STOK KRITIS</span>
                <h3 class="fw-bold mb-2 text-danger animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">{{ $jml_kritis }} <small class="fs-6 fw-normal text-muted">Item</small></h3>
                <small class="text-danger"><i class="fa-solid fa-exclamation-circle"></i> Perlu segera restock</small>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12" data-aos="zoom-in" data-aos-delay="250">
        <div class="card card-custom p-4 border-0 shadow-sm bg-white position-relative overflow-hidden">
            <div class="stat-bg"></div>
            <div class="position-relative">
                <span class="text-muted small fw-bold d-block mb-2">TRANSAKSI/HARI</span>
                <h3 class="fw-bold mb-2 text-warning animate__animated animate__fadeInUp" style="animation-delay: 0.3s;">{{ $rata_rata_per_hari }} <small class="fs-6 fw-normal text-muted">Nota/hari</small></h3>
                <small class="text-warning"><i class="fa-solid fa-chart-line"></i> Rata-rata periode</small>
            </div>
        </div>
    </div>
</div>

<!-- Main Charts Row -->
<div class="row g-2 g-md-4 mb-4 mb-md-5">
    <div class="col-lg-8 col-12" data-aos="fade-right">
        <div class="card card-custom p-3 p-md-4 h-100 border-0 shadow-sm bg-white">
            <h5 class="fw-bold mb-3 mb-md-4"><i class="fa-solid fa-chart-line me-2 text-primary"></i>Tren Pendapatan Harian</h5>
            <div class="chart-height-harian chart-container">
                <canvas id="chartHarian"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 col-12" data-aos="fade-left">
        <div class="row g-2 g-md-4">
            <div class="col-12">
                <div class="card card-custom p-3 p-md-4 border-0 shadow-sm bg-white">
                    <h6 class="fw-bold mb-3"><i class="fa-solid fa-money-bill me-2 text-success"></i>Metode Pembayaran</h6>
                    <div class="chart-height-metode chart-container">
                        <canvas id="chartMetode"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card card-custom p-3 p-md-4 border-0 shadow-sm bg-white">
                    <h6 class="fw-bold mb-3 text-danger">
                        <i class="fa-solid fa-triangle-exclamation me-2 animate__animated animate__flash animate__infinite"></i>
                        Perlu Restock Segera
                    </h6>
                    <div class="list-group list-group-flush" style="max-height: 250px; overflow-y: auto;">
                        @forelse($list_kritis as $lk)
                            <div class="list-group-item px-0 py-2 d-flex justify-content-between align-items-center border-0 animate__animated animate__fadeInUp">
                                <div>
                                    <span class="small fw-bold text-dark d-block">{{ $lk->nama_obat }}</span>
                                    <small class="text-muted" style="font-size: 10px;">Stok saat ini: {{ $lk->stok }}</small>
                                </div>
                                <span class="badge rounded-pill {{ $lk->stok == 0 ? 'bg-dark' : 'bg-danger' }} px-3">
                                    {{ $lk->stok == 0 ? 'HABIS' : 'KRITIS' }}
                                </span>
                            </div>
                        @empty
                            <div class="text-center py-3">
                                <i class="fa-solid fa-check-circle text-success fs-3 mb-2"></i>
                                <p class="text-muted small m-0">Semua stok aman terjaga.</p>
                            </div>
                        @endforelse
                    </div>
                    <a href="{{ url('/obat') }}" class="btn btn-light btn-sm w-100 mt-3 rounded-pill fw-bold border btn-animate">Kelola Inventori</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Obat Terlaris Chart -->
<div class="row g-2 g-md-4" data-aos="fade-up">
    <div class="col-lg-12">
        <div class="card card-custom p-3 p-md-4 border-0 shadow-sm bg-white">
            <h5 class="fw-bold mb-3 mb-md-4"><i class="fa-solid fa-fire me-2 text-warning"></i>Top 5 Obat Terlaris</h5>
            <div class="chart-height-terlaris chart-container">
                <canvas id="chartObatTerlaris"></canvas>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation@3.0.0"></script>

<script>
    // Chart Animation Options
    const animationOptions = {
        duration: 1500,
        easing: 'easeInOutQuart'
    };

    Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
    Chart.defaults.color = '#9ca3af';

    // Line Chart - Tren Pendapatan
    const ctxHarian = document.getElementById('chartHarian');
    if (ctxHarian) {
        new Chart(ctxHarian, {
            type: 'line',
            data: {
                labels: {!! json_encode($tgl_labels, JSON_UNESCAPED_UNICODE) !!},
                datasets: [{
                    label: 'Pendapatan Harian',
                    data: {!! json_encode($total_harian, JSON_UNESCAPED_UNICODE) !!},
                    borderColor: 'rgb(16, 185, 129)',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 3,
                    pointRadius: 5,
                    pointBackgroundColor: 'rgb(16, 185, 129)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointHoverRadius: 7,
                    pointHoverBorderWidth: 3,
                    segment: {
                        borderDash: ctx => ctx.p1DataIndex === ctx.p2DataIndex - 1 ? [] : [5, 5]
                    }
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: animationOptions,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: { size: 12, weight: 'bold' }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        cornerRadius: 8,
                        titleFont: { size: 14, weight: 'bold' },
                        bodyFont: { size: 12 },
                        callbacks: {
                            label: function(context) {
                                return 'Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed.y);
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0, 0, 0, 0.05)' },
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + new Intl.NumberFormat('id-ID', { notation: 'compact' }).format(value);
                            }
                        }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    }

    // Doughnut Chart - Metode Pembayaran
    const ctxMetode = document.getElementById('chartMetode');
    if (ctxMetode) {
        new Chart(ctxMetode, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($labels_metode, JSON_UNESCAPED_UNICODE) !!},
                datasets: [{
                    data: {!! json_encode($data_metode, JSON_UNESCAPED_UNICODE) !!},
                    backgroundColor: [
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(245, 158, 11, 0.8)',
                        'rgba(239, 68, 68, 0.8)'
                    ],
                    borderColor: [
                        'rgb(16, 185, 129)',
                        'rgb(59, 130, 246)',
                        'rgb(245, 158, 11)',
                        'rgb(239, 68, 68)'
                    ],
                    borderWidth: 2,
                    cutout: '70%'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: animationOptions,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 12,
                            font: { size: 11, weight: '600' }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 10,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const rawValue = context.raw; // Diperbaiki dari context.parsed
                                const percentage = ((rawValue / total) * 100).toFixed(1);
                                return context.label + ': ' + rawValue + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });
    }

    // Bar Chart - Obat Terlaris
    const ctxObatTerlaris = document.getElementById('chartObatTerlaris');
    if (ctxObatTerlaris) {
        new Chart(ctxObatTerlaris, {
            type: 'bar',
            data: {
                labels: {!! json_encode($labels_obat, JSON_UNESCAPED_UNICODE) !!},
                datasets: [{
                    label: 'Jumlah Terjual',
                    data: {!! json_encode($data_obat, JSON_UNESCAPED_UNICODE) !!},
                    backgroundColor: [
                        'rgba(239, 68, 68, 0.8)',
                        'rgba(249, 115, 22, 0.8)',
                        'rgba(245, 158, 11, 0.8)',
                        'rgba(34, 197, 94, 0.8)',
                        'rgba(59, 130, 246, 0.8)'
                    ],
                    borderColor: [
                        'rgb(239, 68, 68)',
                        'rgb(249, 115, 22)',
                        'rgb(245, 158, 11)',
                        'rgb(34, 197, 94)',
                        'rgb(59, 130, 246)'
                    ],
                    borderWidth: 2,
                    borderRadius: 8,
                    borderSkipped: false,
                    hoverBackgroundColor: 'rgba(0, 0, 0, 0.1)'
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                animation: animationOptions,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(context) {
                                return 'Terjual: ' + context.parsed.x + ' unit';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0, 0, 0, 0.05)' },
                        ticks: {
                            callback: function(value) {
                                return value + ' unit';
                            }
                        }
                    },
                    y: {
                        grid: { display: false }
                    }
                }
            }
        });
    }
</script>
@endpush