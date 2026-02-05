@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">

        @include('partials.peserta_header')

        {{-- Welcome Banner with Glassmorphism --}}
        <div class="welcome-banner mb-4 animate-slideUp">
            <div class="banner-content">
                <div class="banner-icon">
                    <i class="bi bi-stars"></i>
                </div>
                <div class="banner-text">
                    <h3>Selamat Datang, {{ $peserta->nama_peserta }}! 👋</h3>
                    <p>Pantau progres poin dan kehadiran seminar Anda di sini.</p>
                </div>
            </div>
            <div class="banner-decoration"></div>
        </div>

        {{-- Stats Grid --}}
        <div class="row g-3 mb-4 stagger-children">
            {{-- Total Poin --}}
            <div class="col-6 col-lg-3">
                <div class="stat-card stat-primary">
                    <div class="stat-icon">
                        <i class="bi bi-trophy-fill"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-label">Total Poin</span>
                        <h3 class="stat-value" data-count="{{ $totalPoin }}">{{ $totalPoin }}</h3>
                    </div>
                    <div class="stat-ring"></div>
                </div>
            </div>

            {{-- Seminar Berhasil --}}
            <div class="col-6 col-lg-3">
                <div class="stat-card stat-success">
                    <div class="stat-icon">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-label">Kehadiran</span>
                        <h3 class="stat-value">{{ $seminarBerhasil }}</h3>
                    </div>
                    <div class="stat-ring"></div>
                </div>
            </div>

            {{-- Tidak Hadir --}}
            <div class="col-6 col-lg-3">
                <div class="stat-card stat-warning">
                    <div class="stat-icon">
                        <i class="bi bi-hourglass-split"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-label">Menunggu</span>
                        <h3 class="stat-value">{{ $tidakHadir }}</h3>
                    </div>
                    <div class="stat-ring"></div>
                </div>
            </div>

            {{-- Total Terdaftar --}}
            <div class="col-6 col-lg-3">
                <div class="stat-card stat-info">
                    <div class="stat-icon">
                        <i class="bi bi-calendar-event-fill"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-label">Total Terdaftar</span>
                        <h3 class="stat-value">{{ $totalTerdaftar }}</h3>
                    </div>
                    <div class="stat-ring"></div>
                </div>
            </div>
        </div>

        {{-- History Table --}}
        <div class="card border-0 shadow-lg rounded-4 animate-slideUp" style="animation-delay: 0.3s;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-clock-history text-primary me-2"></i>Riwayat Kehadiran
                    </h5>
                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2">
                        {{ count($riwayat) }} Seminar
                    </span>
                </div>

                <div class="table-responsive">
                    <table class="table table-modern align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="ps-3">SEMINAR</th>
                                <th>TANGGAL</th>
                                <th>POIN</th>
                                <th class="text-end pe-3">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayat as $r)
                                <tr class="table-row-hover">
                                    <td class="ps-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="seminar-icon">
                                                <i class="bi bi-mortarboard"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark">{{ Str::limit($r->seminar->nama_seminar, 35) }}
                                                </div>
                                                <span class="badge badge-category">{{ $r->seminar->kategori_seminar }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-muted">
                                            <i class="bi bi-calendar2 me-1"></i>
                                            {{ \Carbon\Carbon::parse($r->tanggal_pendaftaran)->format('d M Y') }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="poin-badge">+{{ $r->poin_perolehan }}</span>
                                    </td>
                                    <td class="text-end pe-3">
                                        <a href="{{ route('sertifikat.download', $r->kode_pendaftaran) }}"
                                            class="btn-action text-decoration-none" target="_blank" title="Unduh Sertifikat">
                                            <i class="bi bi-download"></i>
                                            <span>Unduh</span>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <div class="empty-state">
                                            <div class="empty-icon">
                                                <i class="bi bi-inbox"></i>
                                            </div>
                                            <h6>Belum Ada Riwayat</h6>
                                            <p>Anda belum menghadiri seminar apapun</p>
                                            <a href="{{ route('portal.index') }}"
                                                class="btn btn-primary btn-sm rounded-pill px-4">
                                                Cari Seminar
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Welcome Banner */
        .welcome-banner {
            background: linear-gradient(135deg, #6366f1 0%, #a855f7 50%, #ec4899 100%);
            border-radius: 20px;
            padding: 2rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(99, 102, 241, 0.3);
        }

        .banner-content {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            position: relative;
            z-index: 2;
            color: white;
        }

        .banner-icon {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
        }

        .banner-text h3 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .banner-text p {
            margin: 0;
            opacity: 0.9;
            font-size: 0.95rem;
        }

        .banner-decoration {
            position: absolute;
            top: -50%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(5deg);
            }
        }

        /* Stat Cards */
        .stat-card {
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            flex-shrink: 0;
        }

        .stat-primary .stat-icon {
            background: rgba(99, 102, 241, 0.1);
            color: #6366f1;
        }

        .stat-success .stat-icon {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
        }

        .stat-warning .stat-icon {
            background: rgba(245, 158, 11, 0.1);
            color: #f59e0b;
        }

        .stat-info .stat-icon {
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
        }

        .stat-label {
            font-size: 0.8rem;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-value {
            font-size: 1.75rem;
            font-weight: 800;
            margin: 0;
            line-height: 1;
        }

        .stat-primary .stat-value {
            color: #6366f1;
        }

        .stat-success .stat-value {
            color: #10b981;
        }

        .stat-warning .stat-value {
            color: #f59e0b;
        }

        .stat-info .stat-value {
            color: #3b82f6;
        }

        .stat-ring {
            position: absolute;
            top: -30px;
            right: -30px;
            width: 100px;
            height: 100px;
            border: 20px solid rgba(0, 0, 0, 0.03);
            border-radius: 50%;
        }

        /* Table Styling */
        .table-modern {
            border-collapse: separate;
            border-spacing: 0;
        }

        .table-modern thead tr {
            background: #f8fafc;
        }

        .table-modern thead th {
            border: none;
            padding: 1rem;
            font-size: 0.75rem;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table-modern tbody td {
            padding: 1rem;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        .table-row-hover {
            transition: all 0.2s ease;
        }

        .table-row-hover:hover {
            background: rgba(99, 102, 241, 0.02);
        }

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
        }

        .badge-category {
            background: rgba(99, 102, 241, 0.1);
            color: #6366f1;
            font-size: 0.7rem;
            font-weight: 600;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
        }

        .poin-badge {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            font-weight: 700;
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: rgba(99, 102, 241, 0.1);
            color: #6366f1;
            border: none;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.8rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-action:hover {
            background: #6366f1;
            color: white;
            transform: translateY(-2px);
        }

        /* Empty State */
        .empty-state {
            padding: 2rem;
        }

        .empty-icon {
            width: 80px;
            height: 80px;
            background: #f1f5f9;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 2rem;
            color: #94a3b8;
        }

        .empty-state h6 {
            font-weight: 700;
            color: #334155;
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            color: #64748b;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .welcome-banner {
                padding: 1.5rem;
            }

            .banner-content {
                flex-direction: column;
                text-align: center;
            }

            .banner-text h3 {
                font-size: 1.25rem;
            }

            .stat-card {
                padding: 1rem;
            }

            .stat-value {
                font-size: 1.5rem;
            }
        }
    </style>
@endsection