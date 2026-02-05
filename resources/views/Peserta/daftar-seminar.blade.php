@extends('layouts.app')

@section('content')
<div class="container py-4" style="font-family: 'Plus Jakarta Sans', sans-serif;">
    {{-- Memanggil Header Seragam --}}
    @include('partials.peserta_header')

    <div class="mb-4">
        <h3 class="fw-bold mb-1 text-dark">Daftar Seminar</h3>
        <p class="text-muted small">Temukan seminar yang sesuai untuk meningkatkan poin prestasi Anda.</p>
    </div>

    {{-- FILTER DINAMIS --}}
    <div class="mb-4 d-flex gap-2">
        <a href="{{ route('portal.index', ['filter' => 'Semua']) }}" 
           class="btn {{ request('filter', 'Semua') == 'Semua' ? 'btn-primary' : 'btn-outline-primary' }} rounded-pill px-4 shadow-sm border-0 fw-bold">
           Semua
        </a>
        <a href="{{ route('portal.index', ['filter' => 'Aktif']) }}" 
           class="btn {{ request('filter') == 'Aktif' ? 'btn-primary' : 'btn-outline-primary' }} rounded-pill px-4 shadow-sm border-0 fw-bold">
           Aktif
        </a>
        <a href="{{ route('portal.index', ['filter' => 'Selesai']) }}" 
           class="btn {{ request('filter') == 'Selesai' ? 'btn-primary' : 'btn-outline-primary' }} rounded-pill px-4 shadow-sm border-0 fw-bold">
           Selesai
        </a>
    </div>

    <div class="row g-4">
        @forelse($seminars as $s)
            @php
                $today = \Carbon\Carbon::now();
                $tglSeminar = \Carbon\Carbon::parse($s->tgl_seminar);
                $isSelesai = $tglSeminar->isPast() && !$tglSeminar->isToday();

                $cardClass = match($s->kategori_seminar) {
                    'Internasional' => 'bg-purple',
                    'Nasional' => 'bg-blue',
                    'Regional/Daerah' => 'bg-green',
                    default => 'bg-generic'
                };
                
                $pendaftaran = $s->pendaftarans->first();
                $status = $pendaftaran->status_pendaftaran ?? null;
            @endphp

            <div class="col-md-4">
                <div class="card border-0 shadow-lg h-100 {{ $cardClass }} card-hover" style="border-radius: 24px;">
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge bg-white bg-opacity-25 text-white rounded-pill px-3 py-2 small border border-white border-opacity-25">
                                {{ $s->kategori_seminar }}
                            </span>
                            <span class="badge bg-white text-dark rounded-pill px-3 py-2 shadow-sm fw-bold">
                                <i class="bi bi-star-fill text-warning me-1"></i> {{ $s->poin_seminar }} Poin
                            </span>
                        </div>

                        <h5 class="card-title fw-bold mb-3 text-white lh-base">{{ $s->nama_seminar }}</h5>

                        <div class="mt-2 text-white-50">
                            <div class="small mb-2"><i class="bi bi-calendar3 me-2"></i> {{ $tglSeminar->format('d F Y') }}</div>
                            <div class="small mb-2"><i class="bi bi-geo-alt me-2"></i> {{ $s->lokasi }}</div>
                            <div class="small mb-3"><i class="bi bi-people me-2"></i> {{ $s->pendaftarans_count }}/{{ $s->kapasitas }} Peserta</div>
                        </div>
                        
                        <p class="text-white small mb-4"><strong>Penyelenggara:</strong> {{ $s->penyelenggara }}</p>

                        <div class="mt-auto">
                            @if($isSelesai)
                                <button class="btn btn-secondary w-100 fw-bold py-2 rounded-pill shadow-sm" disabled>
                                    <i class="bi bi-slash-circle me-1"></i> Seminar Selesai
                                </button>
                            @elseif($status)
                                @if($status == 'Menunggu')
                                    <div class="bg-warning text-dark text-center py-2 rounded-pill fw-bold small shadow-sm">
                                        <i class="bi bi-hourglass-split me-1"></i> Menunggu Approval
                                    </div>
                                @else
                                    <div class="bg-white text-success text-center py-2 rounded-pill fw-bold small mb-2 shadow-sm">
                                        <i class="bi bi-patch-check-fill me-1"></i> Anda Terdaftar
                                    </div>
                                    {{-- Tombol QR Absensi yang memicu Modal --}}
                                    <button class="btn btn-primary w-100 fw-bold py-2 rounded-pill shadow-lg border-0" 
                                            style="background: #4f46e5;"
                                            onclick="showQR('{{ $pendaftaran->kode_pendaftaran }}')">
                                        <i class="bi bi-qr-code-scan me-1"></i> Tampilkan QR Absensi
                                    </button>
                                @endif
                            @else
                                {{-- Tombol Daftar dengan Konfirmasi SweetAlert --}}
                                <form id="form-daftar-{{ $s->kode_seminar }}" action="{{ route('pendaftaran.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="kode_seminar" value="{{ $s->kode_seminar }}">
                                    <button type="button" 
                                            onclick="konfirmasiDaftar('{{ $s->kode_seminar }}', '{{ $s->nama_seminar }}')"
                                            class="btn btn-light w-100 fw-bold py-2 text-primary rounded-pill shadow-sm">
                                        <i class="bi bi-pencil-square me-1"></i> Daftar Sekarang
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
                <p class="text-muted">Tidak ada seminar yang tersedia.</p>
            </div>
        @endforelse
    </div>
</div>

{{-- MODAL QR CODE --}}
<div class="modal fade" id="modalQR" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-body text-center p-5">
                <h5 class="fw-bold mb-4">QR Code Absensi</h5>
                <div id="qrcode" class="mb-4 d-flex justify-content-center"></div>
                <p class="small text-muted mb-4">Tunjukkan QR ini saat menghadiri seminar untuk proses absensi.</p>
                <button type="button" class="btn btn-dark rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<script>
    // 1. Notifikasi Konfirmasi
    function konfirmasiDaftar(id, nama) {
        Swal.fire({
            title: 'Konfirmasi Pendaftaran',
            text: `Apakah anda yakin ingin mendaftar seminar "${nama}"?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#4f46e5',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Daftar!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-daftar-' + id).submit();
            }
        });
    }

    // 2. Tampilkan QR Code
    function showQR(kode) {
        const qrContainer = document.getElementById("qrcode");
        qrContainer.innerHTML = "";
        new QRCode(qrContainer, { text: kode, width: 200, height: 200 });
        var myModal = new bootstrap.Modal(document.getElementById('modalQR'));
        myModal.show();
    }

    // 3. Notifikasi Berhasil
    @if(session('success_pendaftaran'))
        Swal.fire({ title: 'Berhasil!', text: "{{ session('success_pendaftaran') }}", icon: 'success' });
    @endif
</script>

<style>
    /* CSS Tambahan agar Gradien Halus */
    .bg-purple { background: linear-gradient(135deg, #a855f7 0%, #6366f1 100%); }
    .bg-blue { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); }
    .bg-green { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
    .bg-generic { background: linear-gradient(135deg, #94a3b8 0%, #475569 100%); }
    .card-hover { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    .card-hover:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(0,0,0,0.15) !important; }
</style>
@endsection