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
</style>
@endpush

@section('content')
<header class="d-flex justify-content-between align-items-center mb-5" data-aos="fade-down">
    <div>
        <h2 class="fw-bold mb-1 animate__animated animate__fadeInLeft">Ringkasan Performa</h2>
        <p class="text-muted mb-0">Pantau aktivitas apotek Anda secara real-time.</p>
    </div>
    <form action="{{ url('/dashboard') }}" method="GET" class="filter-bar d-flex align-items-center gap-3 shadow-sm bg-white rounded-4 p-2 border animate__animated animate__fadeInRight">
        <div class="d-flex align-items-center gap-2 px-2">
            <input type="date" name="tgl_mulai" class="form-control form-control-sm border-0 bg-transparent fw-bold" value="{{ $tgl_mulai }}">
            <span class="text-muted">-</span>
            <input type="date" name="tgl_selesai" class="form-control form-control-sm border-0 bg-transparent fw-bold" value="{{ $tgl_selesai }}">
        </div>
        <button type="submit" class="btn btn-primary btn-sm px-4 rounded-pill btn-animate shadow-sm">Terapkan</button>
    </form>
</header>

<!-- Statistics Cards with Animation -->
<div class="row g-4 mb-5">
    <div class="col-md-3" data-aos="zoom-in" data-aos-delay="100">
        <div class="card card-custom p-4 border-0 shadow-sm bg-white position-relative overflow-hidden">
            <div class="stat-bg"></div>
            <div class="position-relative">
                <span class="text-muted small fw-bold d-block mb-2">TOTAL PENDAPATAN</span>
                <h3 class="fw-bold mb-2 text-success animate__animated animate__fadeInUp">Rp {{ number_format($total, 0, ',', '.') }}</h3>
                <small class="text-success"><i class="fa-solid fa-arrow-up"></i> +12.5% dari periode lalu</small>
            </div>
        </div>
    </div>
    <div class="col-md-3" data-aos="zoom-in" data-aos-delay="150">
        <div class="card card-custom p-4 border-0 shadow-sm bg-white position-relative overflow-hidden">
            <div class="stat-bg"></div>
            <div class="position-relative">
                <span class="text-muted small fw-bold d-block mb-2">JUMLAH TRANSAKSI</span>
                <h3 class="fw-bold mb-2 text-primary animate__animated animate__fadeInUp" style="animation-delay: 0.1s;">{{ number_format($trx) }} <small class="fs-6 fw-normal text-muted">Nota</small></h3>
                <small class="text-info"><i class="fa-solid fa-arrow-up"></i> Rata-rata Rp {{ number_format($rata_rata_trx, 0, ',', '.') }}/nota</small>
            </div>
        </div>
    </div>
    <div class="col-md-3" data-aos="zoom-in" data-aos-delay="200">
        <div class="card card-custom p-4 border-0 shadow-sm bg-white position-relative overflow-hidden {{ $jml_kritis > 0 ? 'animate__animated animate__pulse animate__infinite' : '' }}">
            <div class="stat-bg"></div>
            <div class="position-relative">
                <span class="text-muted small fw-bold d-block mb-2">STOK KRITIS</span>
                <h3 class="fw-bold mb-2 text-danger animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">{{ $jml_kritis }} <small class="fs-6 fw-normal text-muted">Item</small></h3>
                <small class="text-danger"><i class="fa-solid fa-exclamation-circle"></i> Perlu segera restock</small>
            </div>
        </div>
    </div>
    <div class="col-md-3" data-aos="zoom-in" data-aos-delay="250">
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
<div class="row g-4 mb-5">
    <div class="col-lg-8" data-aos="fade-right">
        <div class="card card-custom p-4 h-100 border-0 shadow-sm bg-white">
            <h5 class="fw-bold mb-4"><i class="fa-solid fa-chart-line me-2 text-primary"></i>Tren Pendapatan Harian</h5>
            <div style="height: 350px;" class="chart-container">
                <canvas id="chartHarian"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4" data-aos="fade-left">
        <div class="row g-4">
            <div class="col-12">
                <div class="card card-custom p-4 border-0 shadow-sm bg-white">
                    <h6 class="fw-bold mb-3"><i class="fa-solid fa-money-bill me-2 text-success"></i>Metode Pembayaran</h6>
                    <div style="height: 200px;" class="chart-container">
                        <canvas id="chartMetode"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card card-custom p-4 border-0 shadow-sm bg-white">
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
<div class="row g-4" data-aos="fade-up">
    <div class="col-lg-12">
        <div class="card card-custom p-4 border-0 shadow-sm bg-white">
            <h5 class="fw-bold mb-4"><i class="fa-solid fa-fire me-2 text-warning"></i>Top 5 Obat Terlaris</h5>
            <div style="height: 300px;" class="chart-container">
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
                labels: @json($tgl_labels),
                datasets: [{
                    label: 'Pendapatan Harian',
                    data: @json($total_harian),
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
                labels: @json($labels_metode),
                datasets: [{
                    data: @json($data_metode),
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
                labels: @json($labels_obat),
                datasets: [{
                    label: 'Jumlah Terjual',
                    data: @json($data_obat),
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