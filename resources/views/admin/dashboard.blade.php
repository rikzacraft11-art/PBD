@extends('layouts.admin_app')

@section('header_title', 'Dashboard Overview')
@section('header_subtitle', 'Welcome back, Admin. Here\'s what\'s happening today.')

@section('content')
    {{-- Stats Grid --}}
    <div class="row g-4 mb-5 stagger-animate">
        {{-- Total Seminar --}}
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="stat-label">TOTAL SEMINAR</p>
                        <h2 class="stat-value">{{ $stats['total_seminar'] }}</h2>
                        <div class="stat-badge">
                            <span class="badge-dot active"></span>
                            <span>{{ $stats['seminar_aktif'] }} Aktif</span>
                        </div>
                    </div>
                    <div class="icon-box color-indigo">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Pendaftar --}}
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="stat-label">TOTAL PESERTA</p>
                        <h2 class="stat-value">{{ $stats['total_pendaftar'] }}</h2>
                        <div class="stat-badge muted">
                            <span>Terdaftar di sistem</span>
                        </div>
                    </div>
                    <div class="icon-box color-blue">
                        <i class="bi bi-people"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kehadiran --}}
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="stat-label">KEHADIRAN</p>
                        <h2 class="stat-value">{{ $stats['persen_hadir'] }}%</h2>
                        <div class="stat-badge success">
                            <i class="bi bi-arrow-up-short"></i>
                            <span>{{ $stats['peserta_hadir'] }} hadir</span>
                        </div>
                    </div>
                    <div class="icon-box color-emerald">
                        <i class="bi bi-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Poin --}}
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="stat-label">POIN DISTRIBUSI</p>
                        <h2 class="stat-value">{{ number_format($stats['total_poin']) }}</h2>
                        <div class="stat-badge muted">
                            <span>Total poin diberikan</span>
                        </div>
                    </div>
                    <div class="icon-box color-amber">
                        <i class="bi bi-star"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts Area --}}
    <div class="row g-4 mb-5">
        <div class="col-lg-8">
            <div class="card border-0 rounded-4 p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">Statistik Kategori Seminar</h5>
                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3">
                        Chart
                    </span>
                </div>
                <div class="chart-container">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 rounded-4 p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">Status Seminar</h5>
                </div>
                <div class="chart-container">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent & Popular --}}
    <div class="row g-4">
        {{-- Seminar Akan Datang --}}
        <div class="col-lg-6">
            <div class="card border-0 rounded-4 p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-calendar2-week me-2 text-primary"></i>Seminar Akan Datang
                    </h5>
                    <a href="{{ route('admin.seminar') }}" class="btn btn-sm btn-light rounded-pill px-3">
                        Lihat Semua
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table custom-table">
                        <thead>
                            <tr>
                                <th>NAMA SEMINAR</th>
                                <th>TANGGAL</th>
                                <th>KUOTA</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($upcoming as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="seminar-icon">
                                                <i class="bi bi-mortarboard"></i>
                                            </div>
                                            <div>
                                                <span class="fw-semibold d-block text-truncate" style="max-width: 180px;">
                                                    {{ $item->nama_seminar }}
                                                </span>
                                                <span class="badge bg-indigo-soft text-indigo rounded-pill"
                                                    style="font-size: 10px;">
                                                    {{ $item->kategori_seminar }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-muted">{{ date('d M Y', strtotime($item->tgl_seminar)) }}</td>
                                    <td>
                                        @php $persen = $item->kapasitas > 0 ? ($item->pendaftarans_count / $item->kapasitas) * 100 : 0; @endphp
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="progress flex-grow-1" style="height: 6px; width: 60px;">
                                                <div class="progress-bar bg-indigo" role="progressbar"
                                                    style="width: {{ $persen }}%"></div>
                                            </div>
                                            <small
                                                class="text-muted">{{ $item->pendaftarans_count }}/{{ $item->kapasitas }}</small>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">
                                        <i class="bi bi-calendar-x fs-3 d-block mb-2 opacity-50"></i>
                                        Belum ada seminar akan datang
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Seminar Terpopuler --}}
        <div class="col-lg-6">
            <div class="card border-0 rounded-4 p-4 h-100">
                <h5 class="fw-bold mb-4">
                    <i class="bi bi-fire me-2 text-danger"></i>Seminar Terpopuler
                </h5>

                @forelse($popular as $index => $item)
                    <div class="popular-item">
                        <div class="rank-badge">
                            #{{ $index + 1 }}
                        </div>
                        <div class="popular-content">
                            <h6 class="fw-bold mb-1 text-truncate" style="max-width: 200px;">{{ $item->nama_seminar }}</h6>
                            <span class="text-muted small">
                                <i class="bi bi-people-fill me-1"></i>{{ $item->pendaftarans_count }} Pendaftar
                            </span>
                        </div>
                        <span class="poin-badge">{{ $item->poin_seminar }} Poin</span>
                    </div>
                @empty
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-trophy fs-3 d-block mb-2 opacity-50"></i>
                        Belum ada data
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <style>
        /* Stat Card Enhancements */
        .stat-label {
            font-size: 0.7rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 800;
            color: var(--text-dark);
            margin: 0;
            line-height: 1;
        }

        .stat-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-top: 0.75rem;
        }

        .stat-badge.success {
            color: #10b981;
        }

        .badge-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--text-muted);
        }

        .badge-dot.active {
            background: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
        }

        /* Chart Container */
        .chart-container {
            position: relative;
            height: 280px;
            width: 100%;
        }

        /* Seminar Icon */
        .seminar-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #6366f1, #a855f7);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1rem;
            flex-shrink: 0;
        }

        /* Popular Item */
        .popular-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: #f8fafc;
            border-radius: 14px;
            margin-bottom: 0.75rem;
            transition: all 0.2s ease;
        }

        .popular-item:hover {
            background: #f1f5f9;
            transform: translateX(4px);
        }

        .rank-badge {
            width: 40px;
            height: 40px;
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 0.85rem;
            color: var(--text-dark);
            flex-shrink: 0;
        }

        .popular-content {
            flex: 1;
            min-width: 0;
        }

        .poin-badge {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 0.4rem 0.75rem;
            border-radius: 20px;
        }
    </style>

    {{-- Chart.js --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const categoryCanvas = document.getElementById('categoryChart');
            if (categoryCanvas) {
                const ctxCategory = categoryCanvas.getContext('2d');
                const kategoriData = JSON.parse('{!! json_encode($chartKategori ?? []) !!}');

                new Chart(ctxCategory, {
                    type: 'bar',
                    data: {
                        labels: Object.keys(kategoriData),
                        datasets: [{
                            label: 'Jumlah Seminar',
                            data: Object.values(kategoriData),
                            backgroundColor: ['#6366f1', '#3b82f6', '#10b981', '#f59e0b', '#ec4899'],
                            borderRadius: 8,
                            barThickness: 35
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            y: { beginAtZero: true, grid: { borderDash: [5, 5], drawBorder: false } },
                            x: { grid: { display: false } }
                        }
                    }
                });
            }

            const statusCanvas = document.getElementById('statusChart');
            if (statusCanvas) {
                const ctxStatus = statusCanvas.getContext('2d');
                const statusData = JSON.parse('{!! json_encode($chartStatus ?? []) !!}');

                new Chart(ctxStatus, {
                    type: 'doughnut',
                    data: {
                        labels: ['Aktif', 'Selesai'],
                        datasets: [{
                            data: [statusData.Aktif ?? 0, statusData.Selesai ?? 0],
                            backgroundColor: ['#10b981', '#94a3b8'],
                            borderWidth: 0,
                            hoverOffset: 8
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    usePointStyle: true,
                                    boxWidth: 8,
                                    padding: 20
                                }
                            }
                        },
                        cutout: '75%'
                    }
                });
            }
        });
    </script>
@endsection