@extends('layouts.app')

@section('content')
{{-- PERUBAHAN UTAMA: 'container-fluid' --}}
<div class="container-fluid py-4" style="font-family: 'Plus Jakarta Sans', sans-serif;">
    
    @include('partials.peserta_header')

    {{-- Banner Dashboard Ungu (Desain Tetap Sama) --}}
    <div class="card border-0 shadow-sm mb-4 text-white overflow-hidden rounded-4" 
         style="background: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%);">
        <div class="card-body p-4">
            <h3 class="fw-bold mb-1">Dashboard Saya</h3>
            <p class="mb-0 opacity-75">
                Selamat datang, {{ $peserta->nama_peserta }}! Pantau progres poin dan kehadiran seminar Anda di sini.
            </p>
        </div>
    </div>

    {{-- Statistik Card --}}
    <div class="row g-3 mb-4">
        {{-- 1. Total Poin --}}
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3 me-3 icon-box">
                        <i class="bi bi-trophy-fill fs-4"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block fw-bold">Total Poin</small>
                        <h3 class="fw-bold mb-0 text-primary">{{ $totalPoin }}</h3>
                    </div>
                </div>
            </div>
        </div>

        {{-- 2. Seminar Berhasil --}}
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 text-success p-3 rounded-3 me-3 icon-box">
                        <i class="bi bi-check-circle-fill fs-4"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block fw-bold">Seminar Berhasil</small>
                        <h3 class="fw-bold mb-0 text-success">{{ $seminarBerhasil }}</h3>
                    </div>
                </div>
            </div>
        </div>

        {{-- 3. Tidak Hadir --}}
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="bg-danger bg-opacity-10 text-danger p-3 rounded-3 me-3 icon-box">
                        <i class="bi bi-x-circle-fill fs-4"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block fw-bold">Tidak Hadir</small>
                        <h3 class="fw-bold mb-0 text-danger">{{ $tidakHadir }}</h3>
                    </div>
                </div>
            </div>
        </div>

        {{-- 4. Total Terdaftar --}}
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="bg-info bg-opacity-10 text-info p-3 rounded-3 me-3 icon-box">
                        <i class="bi bi-calendar-event-fill fs-4"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block fw-bold">Total Terdaftar</small>
                        <h3 class="fw-bold mb-0 text-info">{{ $totalTerdaftar }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Riwayat Kehadiran --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-4 text-dark"><i class="bi bi-clock-history me-2"></i>Riwayat Kehadiran</h5>
            
            <div class="table-responsive">
                <table class="table align-middle table-hover mb-0">
                    <thead class="bg-light text-muted small text-uppercase">
                        <tr>
                            <th class="ps-3">SEMINAR</th>
                            <th>TANGGAL HADIR</th>
                            <th>POIN</th>
                            <th class="text-end pe-3">SERTIFIKAT</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayat as $r)
                        <tr>
                            <td class="ps-3">
                                <div class="fw-bold text-dark">{{ $r->seminar->nama_seminar }}</div>
                                <small class="text-muted">{{ $r->seminar->kategori_seminar }}</small>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($r->tanggal_pendaftaran)->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">
                                    +{{ $r->poin_perolehan }}
                                </span>
                            </td>
                            <td class="text-end pe-3">
                                <button class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                    <i class="bi bi-download me-1"></i> Unduh
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="mb-3 opacity-50"><i class="bi bi-inbox fs-1"></i></div>
                                <p class="text-muted small mb-0">Belum ada seminar yang berhasil diikuti.</p>
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
    /* Styling Tambahan agar konsisten */
    .icon-box { 
        width: 50px; 
        height: 50px; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
    }
    
    .table thead th { 
        border-top: none; 
        border-bottom: 1px solid #f1f5f9;
        padding: 12px; 
    }
    
    .table tbody td { 
        padding: 16px 12px; 
        border-bottom: 1px solid #f8f9fa; 
    }
</style>
@endsection