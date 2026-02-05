@extends('layouts.app')

@section('content')
<div class="container-fluid py-4" style="font-family: 'Plus Jakarta Sans', sans-serif;">
    
    @include('partials.peserta_header')

    <div class="mb-4 d-flex justify-content-between align-items-end">
        <div>
            <h3 class="fw-bold mb-1 text-dark">Daftar Seminar</h3>
            <p class="text-muted small mb-0">Temukan seminar untuk meningkatkan prestasi Anda.</p>
        </div>
    </div>

    {{-- FILTER DINAMIS --}}
    <div class="mb-4 d-flex gap-2">
        @foreach(['Semua', 'Aktif', 'Selesai'] as $f)
            <a href="{{ route('portal.index', ['filter' => $f]) }}" 
               class="btn {{ request('filter', 'Semua') == $f ? 'btn-primary' : 'btn-outline-primary' }} rounded-pill px-4 shadow-sm border-0 fw-bold small">
               {{ $f }}
            </a>
        @endforeach
    </div>

    <div class="row g-3"> {{-- g-3 agar jarak antar kotak lebih rapat --}}
        @forelse($seminars as $s)
            @php
                // LOGIKA PHP (TETAP SAMA)
                $now        = \Carbon\Carbon::now();
                $tglSeminar = \Carbon\Carbon::parse($s->tgl_seminar);
                $tglBuka    = \Carbon\Carbon::parse($s->tgl_dibuka)->startOfDay(); 
                $tglTutup   = \Carbon\Carbon::parse($s->tgl_ditutup)->endOfDay();

                $isSelesai   = $tglSeminar->isPast() && !$tglSeminar->isToday(); 
                $isBelumBuka = $now->lt($tglBuka);
                $isSudahTutup= $now->gt($tglTutup);
                $isPenuh     = $s->pendaftarans_count >= $s->kapasitas;

                $pendaftaran = $s->pendaftarans->where('nim_peserta', Auth::user()->nim_peserta)->first();
                $status      = $pendaftaran->status_pendaftaran ?? null;

                $cardClass = match($s->kategori_seminar) {
                    'Internasional' => 'bg-purple',
                    'Nasional' => 'bg-blue',
                    'Regional/Daerah' => 'bg-green',
                    default => 'bg-generic'
                };
            @endphp

            {{-- UPDATE GRID: col-lg-3 (4 kotak per baris) & col-md-6 (2 kotak per baris di tablet) --}}
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card border-0 shadow-lg h-100 {{ $cardClass }} card-hover" style="border-radius: 16px;">
                    
                    {{-- UPDATE PADDING: p-3 (lebih rapat) --}}
                    <div class="card-body p-3 d-flex flex-column">
                        
                        {{-- Header Card --}}
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge bg-white bg-opacity-25 text-white rounded-pill px-2 py-1 small border border-white border-opacity-25" style="font-size: 0.7rem;">
                                {{ $s->kategori_seminar }}
                            </span>
                            <span class="badge bg-white text-dark rounded-pill px-2 py-1 shadow-sm fw-bold" style="font-size: 0.7rem;">
                                <i class="bi bi-star-fill text-warning me-1"></i> {{ $s->poin_seminar }} Poin
                            </span>
                        </div>

                        {{-- Judul Seminar (Ukuran font disesuaikan) --}}
                        <h6 class="card-title fw-bold mb-2 text-white lh-base text-truncate-2" style="height: 2.6em; overflow: hidden;">
                            {{ $s->nama_seminar }}
                        </h6>

                        <div class="mt-2 text-white-50 small" style="font-size: 0.85rem;">
                            <div class="mb-1"><i class="bi bi-calendar3 me-2"></i> {{ $tglSeminar->format('d M Y') }}</div>
                            <div class="mb-1"><i class="bi bi-geo-alt me-2"></i> {{ Str::limit($s->lokasi, 20) }}</div>
                            <div class="mb-2"><i class="bi bi-people me-2"></i> {{ $s->pendaftarans_count }}/{{ $s->kapasitas }}</div>
                        </div>
                        
                        <p class="text-white small mb-3 opacity-75 text-truncate">
                            <i class="bi bi-building me-1"></i> {{ $s->penyelenggara }}
                        </p>

                        <div class="mt-auto pt-1">
                            {{-- LOGIKA TOMBOL (Ukuran tombol diperkecil sedikit: btn-sm) --}}
                            
                            @if($isSelesai)
                                @if($status == 'Hadir') 
                                    <button class="btn btn-sm btn-success w-100 fw-bold py-2 rounded-pill shadow-sm" disabled style="background-color: #059669; border:none; opacity: 1;">
                                        <i class="bi bi-check-circle-fill me-1"></i> Sudah Absen
                                    </button>
                                @else
                                    <button class="btn btn-sm btn-secondary w-100 fw-bold py-2 rounded-pill shadow-sm" disabled>
                                        <i class="bi bi-slash-circle me-1"></i> Selesai
                                    </button>
                                @endif

                            @elseif($status)
                                @if($status == 'Hadir')
                                    <button class="btn btn-sm btn-success w-100 fw-bold py-2 rounded-pill shadow-sm" disabled style="background-color: #059669; border:none; opacity: 1;">
                                        <i class="bi bi-patch-check-fill me-1"></i> Sudah Absen
                                    </button>
                                @elseif($status == 'Menunggu')
                                    <div class="bg-warning text-dark text-center py-2 rounded-pill fw-bold small shadow-sm" style="font-size: 0.8rem;">
                                        <i class="bi bi-hourglass-split me-1"></i> Menunggu Approval
                                    </div>
                                @else
                                    <div class="bg-white text-success text-center py-1 rounded-pill fw-bold small mb-2 shadow-sm" style="font-size: 0.8rem; background-color: #f0fdf4 !important; color: #10b981 !important;">
                                        <i class="bi bi-check-circle-fill me-1"></i> Terdaftar
                                    </div>
                                    <button class="btn btn-sm btn-primary w-100 fw-bold py-2 rounded-pill shadow-lg border-0" 
                                            style="background: #4f46e5;"
                                            onclick="showQR('{{ $pendaftaran->kode_pendaftaran }}')">
                                        <i class="bi bi-qr-code-scan me-1"></i> QR Code
                                    </button>
                                @endif

                            @elseif($isBelumBuka)
                                <button class="btn btn-sm btn-secondary w-100 fw-bold py-2 rounded-pill shadow-sm" disabled>
                                    <i class="bi bi-clock me-1"></i> Belum Buka
                                </button>

                            @elseif($isSudahTutup)
                                <button class="btn btn-sm btn-secondary w-100 fw-bold py-2 rounded-pill shadow-sm" disabled>
                                    <i class="bi bi-lock-fill me-1"></i> Ditutup
                                </button>

                            @elseif($isPenuh)
                                <button class="btn btn-sm btn-danger w-100 fw-bold py-2 rounded-pill shadow-sm" disabled>
                                    <i class="bi bi-x-circle-fill me-1"></i> Penuh
                                </button>

                            @else
                                <form id="form-daftar-{{ $s->kode_seminar }}" action="{{ route('pendaftaran.store') }}" method="POST">
                                    @csrf 
                                    <input type="hidden" name="kode_seminar" value="{{ $s->kode_seminar }}">
                                    <button type="button" class="btn btn-sm btn-light w-100 fw-bold py-2 rounded-pill shadow-sm text-primary" 
                                            onclick="konfirmasiDaftar('{{ $s->kode_seminar }}', '{{ $s->nama_seminar }}')">
                                        Daftar
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="bi bi-journal-x fs-1 text-muted d-block mb-3"></i>
                <p class="text-muted">Tidak ada seminar yang tersedia saat ini.</p>
            </div>
        @endforelse
    </div>
</div>

{{-- MODAL QR CODE & SCRIPTS (TIDAK BERUBAH) --}}
<div class="modal fade" id="modalQR" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-body text-center p-5">
                <h5 class="fw-bold mb-3">QR Code Absensi</h5>
                <div id="qrcode" class="mb-4 d-flex justify-content-center"></div>
                <div class="p-3 bg-light rounded-4 mb-4 border border-secondary border-opacity-10">
                    <p class="text-muted small mb-1">Kode Pendaftaran Manual</p>
                    <h2 class="fw-bold text-primary mb-0" id="textCode" style="letter-spacing: 1px;">-</h2>
                </div>
                <p class="small text-muted mb-4">Tunjukkan QR atau sebutkan Kode ini ke panitia saat kehadiran.</p>
                <button type="button" class="btn btn-dark rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
    function konfirmasiDaftar(id, nama) {
        Swal.fire({
            title: 'Konfirmasi Pendaftaran',
            text: `Daftar seminar "${nama}"?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#4f46e5',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Daftar!'
        }).then((result) => {
            if (result.isConfirmed) document.getElementById('form-daftar-' + id).submit();
        });
    }
    function showQR(kode) {
        const qrContainer = document.getElementById("qrcode");
        qrContainer.innerHTML = "";
        new QRCode(qrContainer, { text: kode, width: 200, height: 200 });
        document.getElementById("textCode").innerText = kode;
        new bootstrap.Modal(document.getElementById('modalQR')).show();
    }
    @if(session('success')) Swal.fire({ title: 'Berhasil!', text: "{{ session('success') }}", icon: 'success', confirmButtonColor: '#4f46e5' }); @endif
    @if(session('error')) Swal.fire({ title: 'Gagal!', text: "{{ session('error') }}", icon: 'error', confirmButtonColor: '#ef4444' }); @endif
</script>

<style>
    .bg-purple { background: linear-gradient(135deg, #a855f7 0%, #6366f1 100%); }
    .bg-blue { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); }
    .bg-green { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
    .bg-generic { background: linear-gradient(135deg, #94a3b8 0%, #475569 100%); }
    .card-hover { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    .card-hover:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.15) !important; }
    
    /* CSS Helper untuk membatasi teks judul jadi 2 baris */
    .text-truncate-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection