@extends('layouts.admin_app')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            {{-- Alert Notifikasi --}}
            @if(session('success'))
                <div class="alert alert-success rounded-4 border-0 shadow-sm mb-4">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger rounded-4 border-0 shadow-sm mb-4">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                </div>
            @endif

            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h4 class="fw-bold text-center mb-4">Presensi Kehadiran Peserta</h4>
                
                {{-- Step 1: Pilih Seminar --}}
                <div class="mb-4">
                    <label class="form-label fw-bold small">1. Pilih Seminar yang Berlangsung</label>
                    <select class="form-select rounded-pill border-primary" id="seminar_selector" required>
                        <option value="" selected disabled>-- Pilih Seminar --</option>
                        @foreach($seminars as $s)
                            <option value="{{ $s->id }}">{{ $s->nama_seminar }} ({{ $s->kode_seminar }})</option>
                        @endforeach
                    </select>
                </div>

                {{-- Step 2: Scan atau Input Manual --}}
                <div class="text-center p-4 bg-light rounded-4 border">
                    <div class="mb-3">
                        <i class="bi bi-qr-code-scan display-4 text-primary"></i>
                    </div>
                    <p class="text-muted small">Masukkan kode pendaftaran secara manual atau gunakan scanner kamera di bawah ini.</p>
                    
                    <div id="reader" class="mb-3" style="width: 100%;"></div>

                    {{-- Form Input Manual --}}
                    <form action="{{ route('admin.absensi.checkin') }}" method="POST">
                        @csrf
                        <input type="hidden" name="seminar_id" id="hidden_seminar_id">
                        <div class="input-group mb-3 px-md-5">
                            <input type="text" name="kode_pendaftaran" class="form-control rounded-start-pill" placeholder="Masukkan Kode (Contoh: PD001)" required>
                            <button type="submit" class="btn btn-primary rounded-end-pill px-4 fw-bold">Input</button>
                        </div>
                    </form>
                    
                    <button class="btn btn-outline-primary rounded-pill px-4" onclick="startScanner()">
                        <i class="bi bi-camera"></i> Buka Scanner Kamera
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Sinkronisasi pilihan seminar ke form hidden input
    document.getElementById('seminar_selector').addEventListener('change', function() {
        document.getElementById('hidden_seminar_id').value = this.value;
    });

    function startScanner() {
        alert("Integrasikan library html5-qrcode untuk mengaktifkan scanner kamera nyata.");
    }
</script>

<style>
    /* Style untuk navigasi tab agar konsisten */
    .nav-pills .nav-link.active {
        background-color: transparent !important;
        border-bottom: 3px solid #0d6efd !important;
        color: #0d6efd !important;
    }
    .rounded-4 { border-radius: 1rem !important; }
</style>
@endsection