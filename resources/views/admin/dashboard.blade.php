@extends('layouts.admin_app')

@section('header_title', 'Dashboard Overview')
@section('header_subtitle', 'Welcome back, Admin. Here\'s what\'s happening today.')

@section('content')
    {{-- Top Header is now in Layout --}}

    <style>
        .stat-card {
            background: #fff;
            border: 1px solid var(--border-color);
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -1px rgba(0, 0, 0, 0.02);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.025);
        }

        .icon-box {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .color-indigo {
            color: #4f46e5;
            background: #e0e7ff;
        }

        .color-emerald {
            color: #10b981;
            background: #dcfce7;
        }

        .color-amber {
            color: #f59e0b;
            background: #fef3c7;
        }

        .color-rose {
            color: #f43f5e;
            background: #ffe4e6;
        }

        .color-blue {
            color: #3b82f6;
            background: #dbeafe;
        }

        .custom-table {
            border-collapse: separate;
            border-spacing: 0 0.5rem;
        }

        .custom-table th {
            border: none;
            color: var(--text-muted);
            font-weight: 600;
            font-size: 0.875rem;
            padding: 1rem;
            background: transparent;
        }

        .custom-table td {
            background: #fff;
            border-top: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
            padding: 1rem;
            vertical-align: middle;
        }

        .custom-table tr td:first-child {
            border-left: 1px solid var(--border-color);
            border-top-left-radius: 0.75rem;
            border-bottom-left-radius: 0.75rem;
        }

        .custom-table tr td:last-child {
            border-right: 1px solid var(--border-color);
            border-top-right-radius: 0.75rem;
            border-bottom-right-radius: 0.75rem;
        }
    </style>

    {{-- Stats Grid --}}
    <div class="row g-4 mb-5">
        {{-- Total Seminar --}}
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="text-muted small fw-bold mb-1">TOTAL SEMINAR</p>
                        <h2 class="fw-bold mb-0">{{ $stats['total_seminar'] }}</h2>
                    </div>
                    <div class="icon-box color-indigo">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <span class="badge bg-indigo-soft text-indigo rounded-pill px-2 py-1 small">
                        <i class="bi bi-circle-fill" style="font-size: 6px; vertical-align: middle;"></i> Active:
                        {{ $stats['seminar_aktif'] }}
                    </span>
                    <span class="text-muted small ms-2">events</span>
                </div>
            </div>
        </div>

        {{-- Total Pendaftar --}}
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="text-muted small fw-bold mb-1">TOTAL PESERTA</p>
                        <h2 class="fw-bold mb-0">{{ $stats['total_pendaftar'] }}</h2>
                    </div>
                    <div class="icon-box color-blue">
                        <i class="bi bi-people"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <span class="text-muted small">Registered in system</span>
                </div>
            </div>
        </div>

        {{-- Kehadiran --}}
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="text-muted small fw-bold mb-1">KEHADIRAN</p>
                        <h2 class="fw-bold mb-0">{{ $stats['persen_hadir'] }}%</h2>
                    </div>
                    <div class="icon-box color-emerald">
                        <i class="bi bi-check-circle"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2 py-1 small">
                        {{ $stats['peserta_hadir'] }} Hadir
                    </span>
                    <span class="text-muted small ms-2">rate</span>
                </div>
            </div>
        </div>

        {{-- Total Poin --}}
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="text-muted small fw-bold mb-1">POIN DISTRIBUSI</p>
                        <h2 class="fw-bold mb-0">{{ number_format($stats['total_poin']) }}</h2>
                    </div>
                    <div class="icon-box color-amber">
                        <i class="bi bi-star"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <span class="text-muted small">Total points earned</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts Area --}}
    <div class="row g-4 mb-5">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                <h5 class="fw-bold mb-4">Statistik Kategori Seminar</h5>
                <div style="position: relative; height: 300px; width: 100%;">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                <h5 class="fw-bold mb-4">Status Seminar</h5>
                <div style="position: relative; height: 300px; width: 100%;">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent & Popular --}}
    <div class="row g-4">
        {{-- Seminar Akan Datang --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">Seminar Akan Datang</h5>
                    <a href="{{ route('admin.seminar') }}" class="btn btn-sm btn-light rounded-pill px-3">View All</a>
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
                                        <span class="fw-semibold d-block text-truncate"
                                            style="max-width: 200px;">{{ $item->nama_seminar }}</span>
                                        <span class="badge bg-indigo-soft text-indigo rounded-pill small"
                                            style="font-size: 10px;">{{ $item->kategori_seminar }}</span>
                                    </td>
                                    <td class="text-muted">{{ date('d M Y', strtotime($item->tgl_seminar)) }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="progress flex-grow-1" style="height: 6px; width: 60px;">
                                                @php $persen = $item->kapasitas > 0 ? ($item->pendaftarans_count / $item->kapasitas) * 100 : 0; @endphp
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
                                    <td colspan="3" class="text-center text-muted py-4">Belum ada seminar akan datang</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Seminar Terpopuler --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                <h5 class="fw-bold mb-4">Seminar Terpopuler</h5>
                @foreach($popular as $index => $item)
                    <div class="d-flex align-items-center mb-3 p-3 border rounded-3 bg-light">
                        <div class="rounded-circle bg-white text-dark border d-flex align-items-center justify-content-center fw-bold me-3"
                            style="width: 40px; height: 40px; font-family: 'Plus Jakarta Sans';">
                            #{{ $index + 1 }}
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold mb-1 text-truncate" style="max-width: 250px;">{{ $item->nama_seminar }}</h6>
                            <small class="text-muted"><i class="bi bi-people-fill me-1"></i> {{ $item->pendaftarans_count }}
                                Pendaftar</small>
                        </div>
                        <div>
                            <span class="badge bg-emerald-light text-success rounded-pill">{{ $item->poin_seminar }} Poin</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Script Chart.js (Tetap sama seperti logika sebelumnya, hanya styling canvas yang berubah) --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // ... (Logic Chart tetap sama) ...
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
                            borderRadius: 6,
                            barThickness: 30
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
                    type: 'doughnut', // Doughnut terlihat lebih modern dari Pie
                    data: {
                        labels: ['Aktif', 'Selesai'],
                        datasets: [{
                            data: [statusData.Aktif, statusData.Selesai],
                            backgroundColor: ['#10b981', '#94a3b8'],
                            borderWidth: 0,
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { position: 'right', labels: { usePointStyle: true, boxWidth: 8 } }
                        },
                        cutout: '70%' // Membuat efek donut lebih tipis/elegan
                    }
                });
            }
        });
    </script>
@endsection