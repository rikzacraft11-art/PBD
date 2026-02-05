@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">

        @include('partials.peserta_header')

        {{-- Page Header --}}
        <div class="page-header mb-4 animate-slideUp">
            <div class="header-content">
                <h3 class="fw-bold mb-1">Temukan Seminar 🎯</h3>
                <p class="text-muted mb-0">Daftar seminar untuk meningkatkan prestasi Anda</p>
            </div>
        </div>

        {{-- Filter Pills --}}
        <div class="filter-pills mb-4 animate-slideUp" style="animation-delay: 0.1s;">
            @foreach(['Semua', 'Aktif', 'Selesai'] as $f)
                <a href="{{ route('portal.index', ['filter' => $f]) }}"
                    class="filter-pill {{ request('filter', 'Semua') == $f ? 'active' : '' }}">
                    @if($f == 'Semua')
                        <i class="bi bi-grid-fill"></i>
                    @elseif($f == 'Aktif')
                        <i class="bi bi-lightning-charge-fill"></i>
                    @else
                        <i class="bi bi-check-all"></i>
                    @endif
                    <span>{{ $f }}</span>
                </a>
            @endforeach
        </div>

        {{-- Seminar Cards Grid --}}
        <div class="row g-4 stagger-children">
            @forelse($seminars as $index => $s)
                @php
                    $now = \Carbon\Carbon::now();
                    $tglSeminar = \Carbon\Carbon::parse($s->tgl_seminar);
                    $tglBuka = \Carbon\Carbon::parse($s->tgl_dibuka)->startOfDay();
                    $tglTutup = \Carbon\Carbon::parse($s->tgl_ditutup)->endOfDay();

                    $isSelesai = $tglSeminar->isPast() && !$tglSeminar->isToday();
                    $isBelumBuka = $now->lt($tglBuka);
                    $isSudahTutup = $now->gt($tglTutup);
                    $isPenuh = $s->pendaftarans_count >= $s->kapasitas;

                    $pendaftaran = $s->pendaftarans->where('nim_peserta', Auth::user()->nim_peserta)->first();
                    $status = $pendaftaran->status_pendaftaran ?? null;

                    $gradients = [
                        'Internasional' => 'gradient-purple',
                        'Nasional' => 'gradient-blue',
                        'Regional/Daerah' => 'gradient-green',
                    ];
                    $gradient = $gradients[$s->kategori_seminar] ?? 'gradient-slate';
                @endphp

                <div class="col-12 col-md-6 col-xl-3">
                    <div class="seminar-card {{ $gradient }}" data-tilt>
                        {{-- Card Header --}}
                        <div class="card-header-custom">
                            <span class="category-badge">{{ $s->kategori_seminar }}</span>
                            <span class="poin-badge">
                                <i class="bi bi-star-fill"></i> {{ $s->poin_seminar }}
                            </span>
                        </div>

                        {{-- Card Body --}}
                        <div class="card-body-custom">
                            <h5 class="seminar-title">{{ $s->nama_seminar }}</h5>

                            <div class="seminar-meta">
                                <div class="meta-item">
                                    <i class="bi bi-calendar3"></i>
                                    <span>{{ $tglSeminar->format('d M Y') }}</span>
                                </div>
                                <div class="meta-item">
                                    <i class="bi bi-geo-alt"></i>
                                    <span>{{ Str::limit($s->lokasi, 20) }}</span>
                                </div>
                                <div class="meta-item">
                                    <i class="bi bi-people"></i>
                                    <span>{{ $s->pendaftarans_count }}/{{ $s->kapasitas }}</span>
                                </div>
                            </div>

                            <div class="organizer">
                                <i class="bi bi-building"></i>
                                <span>{{ Str::limit($s->penyelenggara, 25) }}</span>
                            </div>
                        </div>

                        {{-- Card Footer with Action Button --}}
                        <div class="card-footer-custom">
                            @if($isSelesai)
                                @if($status == 'Hadir')
                                    <button class="btn-status btn-hadir" disabled>
                                        <i class="bi bi-check-circle-fill"></i> Sudah Absen
                                    </button>
                                @else
                                    <button class="btn-status btn-selesai" disabled>
                                        <i class="bi bi-slash-circle"></i> Selesai
                                    </button>
                                @endif

                            @elseif($status)
                                @if($status == 'Hadir')
                                    <button class="btn-status btn-hadir" disabled>
                                        <i class="bi bi-patch-check-fill"></i> Sudah Absen
                                    </button>
                                @elseif($status == 'Menunggu')
                                    <div class="btn-status btn-menunggu">
                                        <i class="bi bi-hourglass-split"></i> Menunggu Approval
                                    </div>
                                @else
                                    <div class="status-wrapper">
                                        <div class="status-terdaftar">
                                            <i class="bi bi-check-circle-fill"></i> Terdaftar
                                        </div>
                                        <button class="btn-qr" onclick="showQR('{{ $pendaftaran->kode_pendaftaran }}')">
                                            <i class="bi bi-qr-code-scan"></i> Lihat QR
                                        </button>
                                    </div>
                                @endif

                            @elseif($isBelumBuka)
                                <button class="btn-status btn-disabled" disabled>
                                    <i class="bi bi-clock"></i> Belum Dibuka
                                </button>

                            @elseif($isSudahTutup)
                                <button class="btn-status btn-disabled" disabled>
                                    <i class="bi bi-lock-fill"></i> Pendaftaran Ditutup
                                </button>

                            @elseif($isPenuh)
                                <button class="btn-status btn-penuh" disabled>
                                    <i class="bi bi-x-circle-fill"></i> Kuota Penuh
                                </button>

                            @else
                                <form id="form-daftar-{{ $s->kode_seminar }}" action="{{ route('pendaftaran.store') }}"
                                    method="POST">
                                    @csrf
                                    <input type="hidden" name="kode_seminar" value="{{ $s->kode_seminar }}">
                                    <button type="button" class="btn-daftar"
                                        onclick="konfirmasiDaftar('{{ $s->kode_seminar }}', '{{ $s->nama_seminar }}')">
                                        <span>Daftar Sekarang</span>
                                        <i class="bi bi-arrow-right"></i>
                                    </button>
                                </form>
                            @endif
                        </div>

                        {{-- Decorative Elements --}}
                        <div class="card-glow"></div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-state animate-fadeIn">
                        <div class="empty-icon">
                            <i class="bi bi-calendar-x"></i>
                        </div>
                        <h5>Tidak Ada Seminar</h5>
                        <p>Belum ada seminar yang tersedia untuk filter ini</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    {{-- QR Modal --}}
    <div class="modal fade" id="modalQR" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content qr-modal">
                <div class="modal-body text-center p-5">
                    <div class="qr-title">
                        <i class="bi bi-qr-code"></i>
                        <h5>QR Code Absensi</h5>
                    </div>
                    <div id="qrcode" class="qr-container"></div>
                    <div class="qr-code-manual">
                        <span class="label">Kode Pendaftaran</span>
                        <h3 id="textCode">-</h3>
                    </div>
                    <p class="qr-hint">Tunjukkan QR atau sebutkan kode ini ke panitia</p>
                    <button type="button" class="btn-close-modal" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Scripts --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        function konfirmasiDaftar(id, nama) {
            Swal.fire({
                title: 'Konfirmasi Pendaftaran',
                html: `<p style="color:#64748b">Daftar seminar "<strong>${nama}</strong>"?</p>`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#6366f1',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: '<i class="bi bi-check-lg me-1"></i> Ya, Daftar!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'swal-custom',
                    title: 'swal-title-custom'
                }
            }).then((result) => {
                if (result.isConfirmed) document.getElementById('form-daftar-' + id).submit();
            });
        }

        function showQR(kode) {
            const qrContainer = document.getElementById("qrcode");
            qrContainer.innerHTML = "";
            new QRCode(qrContainer, {
                text: kode,
                width: 200,
                height: 200,
                colorDark: "#1e293b",
                colorLight: "#ffffff"
            });
            document.getElementById("textCode").innerText = kode;
            new bootstrap.Modal(document.getElementById('modalQR')).show();
        }

        @if(session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonColor: '#6366f1',
                customClass: { popup: 'swal-custom' }
            });
        @endif

        @if(session('error'))
            Swal.fire({
                title: 'Gagal!',
                text: "{{ session('error') }}",
                icon: 'error',
                confirmButtonColor: '#ef4444',
                customClass: { popup: 'swal-custom' }
            });
        @endif
    </script>

    <style>
        /* Page Header */
        .page-header {
            padding: 1rem 0;
        }

        /* Filter Pills */
        .filter-pills {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .filter-pill {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 50px;
            color: #64748b;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .filter-pill:hover {
            border-color: #6366f1;
            color: #6366f1;
            transform: translateY(-2px);
        }

        .filter-pill.active {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-color: transparent;
            color: white;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.4);
        }

        /* Seminar Card */
        .seminar-card {
            border-radius: 20px;
            padding: 1.5rem;
            height: 100%;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: default;
        }

        .seminar-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        .gradient-purple {
            background: linear-gradient(135deg, #a855f7 0%, #6366f1 100%);
        }

        .gradient-blue {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        }

        .gradient-green {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }

        .gradient-slate {
            background: linear-gradient(135deg, #64748b 0%, #475569 100%);
        }

        .card-glow {
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
        }

        .seminar-card:hover .card-glow {
            opacity: 1;
        }

        .card-header-custom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .category-badge {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            color: white;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .poin-badge {
            background: white;
            color: #1e293b;
            font-size: 0.8rem;
            font-weight: 700;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .poin-badge i {
            color: #f59e0b;
        }

        .card-body-custom {
            flex: 1;
            color: white;
        }

        .seminar-title {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 1rem;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 3rem;
        }

        .seminar-meta {
            margin-bottom: 0.75rem;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
            opacity: 0.9;
            margin-bottom: 0.4rem;
        }

        .meta-item i {
            font-size: 0.9rem;
            opacity: 0.8;
        }

        .organizer {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.8rem;
            opacity: 0.8;
            padding-top: 0.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
        }

        .card-footer-custom {
            margin-top: 1rem;
        }

        /* Buttons */
        .btn-daftar {
            width: 100%;
            padding: 0.875rem;
            background: white;
            color: #1e293b;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.9rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-daftar:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .btn-status {
            width: 100%;
            padding: 0.75rem;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-hadir {
            background: rgba(255, 255, 255, 0.95);
            color: #059669;
        }

        .btn-selesai,
        .btn-disabled {
            background: rgba(255, 255, 255, 0.3);
            color: white;
        }

        .btn-menunggu {
            background: rgba(255, 255, 255, 0.9);
            color: #d97706;
        }

        .btn-penuh {
            background: rgba(255, 255, 255, 0.9);
            color: #dc2626;
        }

        .status-wrapper {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .status-terdaftar {
            background: rgba(255, 255, 255, 0.95);
            color: #059669;
            padding: 0.5rem;
            border-radius: 10px;
            font-size: 0.8rem;
            font-weight: 600;
            text-align: center;
        }

        .btn-qr {
            width: 100%;
            padding: 0.75rem;
            background: white;
            color: #6366f1;
            border: none;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-qr:hover {
            background: #6366f1;
            color: white;
        }

        /* Empty State */
        .empty-state {
            background: white;
            border-radius: 20px;
            padding: 4rem 2rem;
            text-align: center;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05);
        }

        .empty-icon {
            width: 100px;
            height: 100px;
            background: #f1f5f9;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2.5rem;
            color: #94a3b8;
        }

        .empty-state h5 {
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            color: #64748b;
        }

        /* QR Modal */
        .qr-modal {
            border: none;
            border-radius: 24px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
        }

        .qr-title {
            margin-bottom: 1.5rem;
        }

        .qr-title i {
            font-size: 2rem;
            color: #6366f1;
            margin-bottom: 0.5rem;
            display: block;
        }

        .qr-title h5 {
            font-weight: 700;
            color: #1e293b;
            margin: 0;
        }

        .qr-container {
            display: flex;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .qr-code-manual {
            background: #f8fafc;
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1rem;
        }

        .qr-code-manual .label {
            font-size: 0.75rem;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .qr-code-manual h3 {
            font-weight: 800;
            color: #6366f1;
            margin: 0.5rem 0 0;
            letter-spacing: 2px;
        }

        .qr-hint {
            font-size: 0.85rem;
            color: #64748b;
            margin-bottom: 1.5rem;
        }

        .btn-close-modal {
            padding: 0.75rem 2rem;
            background: #1e293b;
            color: white;
            border: none;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-close-modal:hover {
            background: #0f172a;
            transform: translateY(-2px);
        }

        /* SweetAlert Custom */
        .swal-custom {
            border-radius: 20px !important;
            font-family: 'Plus Jakarta Sans', sans-serif !important;
        }

        .swal-title-custom {
            font-weight: 700 !important;
        }

        /* Responsive */
        @media (max-width: 576px) {
            .filter-pill span {
                display: none;
            }

            .filter-pill {
                padding: 0.75rem 1rem;
            }
        }
    </style>
@endsection