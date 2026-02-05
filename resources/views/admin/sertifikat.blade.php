@extends('layouts.admin_app')

@section('content')
@section('header_title', 'Sertifikat Seminar')
@section('header_subtitle', 'Daftar peserta yang telah menyelesaikan seminar dan berhak mendapatkan sertifikat')

    <div class="container-fluid py-4" style="font-family: 'Plus Jakarta Sans', sans-serif;">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4 text-dark">

                {{-- Header Card --}}
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h5 class="fw-bold mb-1 text-dark">Data Sertifikat</h5>
                        <p class="text-muted small mb-0">Peserta dengan status "Hadir"</p>
                    </div>
                    <div>
                        <button class="btn btn-outline-primary rounded-pill px-4 btn-sm" onclick="window.print()">
                            <i class="bi bi-printer me-2"></i>Cetak Laporan
                        </button>
                    </div>
                </div>

                {{-- Table --}}
                <div class="table-responsive">
                    <table class="table align-middle table-hover-custom">
                        <thead class="bg-light text-muted small text-uppercase">
                            <tr>
                                <th class="ps-3">No</th>
                                <th>Nama Peserta</th>
                                <th>Seminar</th>
                                <th>Tanggal</th>
                                <th>Poin</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pendaftarans as $index => $p)
                                <tr>
                                    <td class="ps-3 fw-bold text-muted">{{ $index + 1 }}</td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $p->peserta->nama_peserta ?? '-' }}</div>
                                        <small class="text-muted">{{ $p->peserta->nim_peserta ?? '-' }}</small>
                                    </td>
                                    <td>
                                        <div class="text-dark fw-semibold text-truncate" style="max-width: 250px;">
                                            {{ $p->seminar->nama_seminar ?? '-' }}
                                        </div>
                                        <span class="badge bg-indigo-soft text-indigo rounded-pill small mt-1">
                                            {{ $p->seminar->kategori_seminar ?? 'Umum' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="text-muted small">
                                            <i class="bi bi-calendar-event me-1"></i>
                                            {{ \Carbon\Carbon::parse($p->seminar->tgl_seminar)->format('d M Y') }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-emerald">+{{ $p->poin_perolehan }}</span>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm"
                                            title="Download Sertifikat">
                                            <i class="bi bi-download me-1"></i> Unduh
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <img src="https://cdni.iconscout.com/illustration/premium/thumb/empty-state-2130362-1800926.png"
                                            alt="Empty" style="width: 150px; opacity: 0.5;">
                                        <p class="text-muted small mt-2">Belum ada data sertifikat yang diterbitkan.</p>
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
        .bg-indigo-soft {
            background: #e0e7ff;
        }

        .text-indigo {
            color: #4f46e5;
        }

        .text-emerald {
            color: #10b981;
        }

        .table-hover-custom tbody tr:hover {
            background-color: rgba(241, 245, 249, 0.6) !important;
        }
    </style>
@endsection