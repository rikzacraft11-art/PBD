@extends('layouts.admin_app')

@section('header_title', 'Presensi Peserta')
@section('header_subtitle', 'Scan QR Code atau input manual kode pendaftaran')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0 shadow-sm mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            {{-- Audio for Scan Success --}}
            <audio id="scan-sound"
                src="https://cdn.pixabay.com/download/audio/2022/03/15/audio_c8c8a73467.mp3?filename=beep-6-96243.mp3"></audio>


            <div class="card border-0 shadow-sm p-4 animate-fadeInUp">
                {{-- Selector --}}
                <div class="mb-4">
                    <label class="form-label fw-bold small text-muted text-uppercase ls-1">1. Pilih Seminar Aktif</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 rounded-start-pill ps-3">
                            <i class="bi bi-calendar-event text-primary"></i>
                        </span>
                        <select class="form-select border-start-0 rounded-end-pill py-2 bg-light" id="seminar_selector"
                            required>
                            <option value="" selected disabled>-- Pilih Seminar --</option>
                            @foreach($seminars as $s)
                                <option value="{{ $s->kode_seminar }}">{{ $s->nama_seminar }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Scanner Area --}}
                <div class="text-center p-5 bg-light-subtle rounded-4 border border-dashed mb-4 scanner-area"
                    id="scanner-container">
                    <div class="mb-3" id="scanner-placeholder">
                        <div class="scanner-icon-bg">
                            <i class="bi bi-qr-code-scan display-4 text-indigo"></i>
                        </div>
                    </div>

                    <div id="scanner-ui-text">
                        <h5 class="fw-bold mb-2">Scanner Camera</h5>
                        <p class="text-muted small mb-4">Arahkan kamera ke QR Code peserta</p>
                    </div>

                    <div id="reader" class="d-none mt-3 rounded-3 overflow-hidden"></div>

                    <button class="btn btn-indigo rounded-pill px-4 btn-hover-scale" id="btn-start-scanner"
                        onclick="startScanner()">
                        <i class="bi bi-camera-fill me-2"></i>Buka Kamera
                    </button>
                    <button class="btn btn-outline-danger rounded-pill px-4 btn-hover-scale d-none" id="btn-stop-scanner"
                        onclick="stopScanner()">
                        <i class="bi bi-stop-circle-fill me-2"></i>Tutup Kamera
                    </button>
                </div>

                <div id="scan-result-container" class="d-none text-center mb-4">
                    <span class="badge bg-success-soft text-success px-3 py-2 rounded-pill">
                        <i class="bi bi-check-circle me-2"></i>QR Code Terdeteksi
                    </span>
                </div>

                {{-- Manual Input --}}
                <div>
                    <div class="d-flex align-items-center mb-2">
                        <div class="flex-grow-1 border-bottom"></div>
                        <span class="px-3 text-muted small fw-bold">ATAU INPUT MANUAL</span>
                        <div class="flex-grow-1 border-bottom"></div>
                    </div>

                    <form action="{{ route('admin.absensi.checkin') }}" method="POST" id="checkin-form">
                        @csrf
                        <input type="hidden" name="kode_seminar" id="hidden_seminar_id">

                        <div class="form-group position-relative">
                            <input type="text" name="kode_pendaftaran" id="kode_pendaftaran_input"
                                class="form-control form-control-lg rounded-pill ps-5 border-2"
                                placeholder="Masukkan Kode (Contoh: PD001)" required>
                            <i
                                class="bi bi-keyboard position-absolute top-50 start-0 translate-middle-y ms-3 text-muted fs-5"></i>
                            <button type="submit"
                                class="btn btn-primary rounded-pill position-absolute top-0 end-0 h-100 px-4 fw-bold m-0 z-1">
                                Check-In
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- HTML5-QRCode Library --}}
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <script>
        // Sync Seminar Selection
        document.getElementById('seminar_selector').addEventListener('change', function () {
            document.getElementById('hidden_seminar_id').value = this.value;
        });

        let html5QrcodeScanner = null;

        function startScanner() {
            // Check if seminar is selected first
            const seminarId = document.getElementById('seminar_selector').value;
            if (!seminarId) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Pilih Seminar',
                    text: 'Silakan pilih seminar terlebih dahulu sebelum membuka kamera.',
                    confirmButtonColor: '#6366f1'
                });
                return;
            }

            // Adjust UI
            document.getElementById('scanner-placeholder').classList.add('d-none');
            document.getElementById('scanner-ui-text').classList.add('d-none');
            document.getElementById('reader').classList.remove('d-none');
            document.getElementById('btn-start-scanner').classList.add('d-none');
            document.getElementById('btn-stop-scanner').classList.remove('d-none');

            // Initialize Scanner
            if (!html5QrcodeScanner) {
                html5QrcodeScanner = new Html5QrcodeScanner(
                    "reader",
                    {
                        fps: 10,
                        qrbox: { width: 250, height: 250 },
                        aspectRatio: 1.0,
                        showTorchButtonIfSupported: true
                    },
                        /* verbose= */ false
                );
            }

            html5QrcodeScanner.render(onScanSuccess, onScanFailure);
        }

        function stopScanner() {
            if (html5QrcodeScanner) {
                html5QrcodeScanner.clear().then(() => {
                    // Reset UI
                    document.getElementById('scanner-placeholder').classList.remove('d-none');
                    document.getElementById('scanner-ui-text').classList.remove('d-none');
                    document.getElementById('reader').classList.add('d-none');
                    document.getElementById('btn-start-scanner').classList.remove('d-none');
                    document.getElementById('btn-stop-scanner').classList.add('d-none');
                }).catch((error) => {
                    console.error("Failed to clear html5QrcodeScanner. ", error);
                });
            }
        }

        function onScanSuccess(decodedText, decodedResult) {
            // Handle valid scan...
            console.log(`Scan result: ${decodedText}`, decodedResult);

            // Play Beep Sound
            const audio = document.getElementById('scan-sound');
            if (audio) audio.play().catch(e => console.log("Audio play failed", e));

            // Stop scanning temporarily or fully? Let's stop fully to prevent double submission
            // But usually for bulk scanning we want it continuous. 
            // For now, let's just input and submit.
            // A better UX for bulk: Stop scanning -> Process -> Restart scanning or delay.

            // For this implementation: Pause scanning by clearing, then submit.
            html5QrcodeScanner.clear();

            // Fill Input
            document.getElementById('kode_pendaftaran_input').value = decodedText;

            // Show Feedback
            document.getElementById('scan-result-container').classList.remove('d-none');

            // Submit Form
            document.getElementById('checkin-form').submit();
        }

        function onScanFailure(error) {
            // handle scan failure, usually better to ignore and keep scanning.
            // for example:
            // console.warn(`Code scan error = ${error}`);
        }
    </script>

    <style>
        .ls-1 {
            letter-spacing: 1px;
        }

        .bg-light-subtle {
            background-color: #f8fafc;
        }

        .border-dashed {
            border-style: dashed !important;
            border-color: #cbd5e1 !important;
        }

        .scanner-icon-bg {
            width: 80px;
            height: 80px;
            background: rgba(99, 102, 241, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
        }

        .btn-indigo {
            background: #6366f1;
            color: white;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
            border: none;
        }

        .btn-indigo:hover {
            background: #4f46e5;
            color: white;
            transform: translateY(-2px);
        }

        .form-control-lg {
            min-height: 52px;
            font-size: 1rem;
        }

        .form-control:focus {
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
            border-color: #6366f1;
        }

        .bg-success-soft {
            background: rgba(16, 185, 129, 0.1);
        }

        /* Scanner specific tweaks */
        #reader button {
            margin-top: 10px;
            padding: 5px 15px;
            border-radius: 50px;
            border: 1px solid #e2e8f0;
            background: white;
            color: #333;
            font-size: 0.9rem;
        }

        #reader video {
            border-radius: 12px;
            object-fit: cover;
        }
    </style>
@endsection