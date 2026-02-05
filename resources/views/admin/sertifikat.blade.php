@extends('layouts.admin_app')

@section('header_title', 'Sertifikat Seminar')
@section('header_subtitle', 'Daftar peserta yang telah menyelesaikan seminar dan berhak mendapatkan sertifikat')

@section('content')
    <div class="card border-0 shadow-sm p-4 animate-fadeInUp">
        {{-- Toolbar --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="fw-bold mb-1">Data Penerima Sertifikat</h5>
                <p class="text-muted small mb-0">Total {{ $pendaftarans->count() }} sertifikat diterbitkan</p>
            </div>
            <button class="btn btn-outline-primary rounded-pill px-4 btn-hover-effect" onclick="window.print()">
                <i class="bi bi-printer me-2"></i>Cetak Laporan
            </button>
        </div>

        {{-- Table --}}
        <div class="table-responsive">
            <table class="table custom-table">
                <thead>
                    <tr>
                        <th class="ps-3">NO</th>
                        <th>PESERTA</th>
                        <th>SEMINAR</th>
                        <th>TANGGAL</th>
                        <th>POIN</th>
                        <th class="text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendaftarans as $index => $p)
                        <tr>
                            <td class="ps-3 text-muted fw-bold">{{ $index + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-sm">
                                        {{ substr($p->peserta->nama_peserta ?? 'X', 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $p->peserta->nama_peserta ?? 'Unknown' }}</div>
                                        <small class="text-muted">{{ $p->peserta->nim_peserta ?? '-' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark text-truncate" style="max-width: 200px;">
                                    {{ $p->seminar->nama_seminar ?? '-' }}
                                </div>
                                <span class="badge bg-indigo-soft text-indigo rounded-pill small mt-1">
                                    {{ $p->seminar->kategori_seminar ?? 'Umum' }}
                                </span>
                            </td>
                            <td>
                                <span class="text-muted small fw-medium">
                                    <i class="bi bi-calendar2 me-1"></i>
                                    {{ \Carbon\Carbon::parse($p->seminar->tgl_seminar)->format('d M Y') }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-success-subtle text-success rounded-pill px-3 py-1">
                                    +{{ $p->poin_perolehan }} Poin
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.sertifikat.download', $p->kode_pendaftaran) }}"
                                    class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm btn-hover-scale text-decoration-none"
                                    target="_blank" title="Download Sertifikat">
                                    <i class="bi bi-download me-1"></i> Unduh
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="empty-state">
                                    <div class="empty-icon-sm mb-3">
                                        <i class="bi bi-award fs-1 text-muted opacity-25"></i>
                                    </div>
                                    <h6 class="text-muted mb-0">Belum ada data sertifikat yang diterbitkan.</h6>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <style>
        /* Avatar for Table */
        .avatar-sm {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
            color: #4f46e5;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.8rem;
        }

        .btn-hover-scale:hover {
            transform: scale(1.05);
        }

        /* Print Hiding */
        @media print {

            .sidebar,
            .main-header,
            .btn,
            .d-flex.justify-content-between {
                display: none !important;
            }

            .main-wrapper {
                margin-left: 0;
            }

            .content {
                padding: 0;
            }

            .card {
                box-shadow: none !important;
                border: none !important;
            }
        }
    </style>
@endsection