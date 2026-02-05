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
                <div class="text-center p-5 bg-light-subtle rounded-4 border border-dashed mb-4 scanner-area">
                    <div class="mb-3">
                        <div class="scanner-icon-bg">
                            <i class="bi bi-qr-code-scan display-4 text-indigo"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold mb-2">Scanner Camera</h5>
                    <p class="text-muted small mb-4">Arahkan kamera ke QR Code peserta</p>

                    <button class="btn btn-indigo rounded-pill px-4 btn-hover-scale" onclick="startScanner()">
                        <i class="bi bi-camera-fill me-2"></i>Buka Kamera
                    </button>

                    <div id="reader" class="mt-3 rounded-3 overflow-hidden"></div>
                </div>

                {{-- Manual Input --}}
                <div>
                    <div class="d-flex align-items-center mb-2">
                        <div class="flex-grow-1 border-bottom"></div>
                        <span class="px-3 text-muted small fw-bold">ATAU INPUT MANUAL</span>
                        <div class="flex-grow-1 border-bottom"></div>
                    </div>

                    <form action="{{ route('admin.absensi.checkin') }}" method="POST">
                        @csrf
                        <input type="hidden" name="kode_seminar" id="hidden_seminar_id">

                        <div class="form-group position-relative">
                            <input type="text" name="kode_pendaftaran"
                                class="form-control form-control-lg rounded-pill ps-5 border-2"
                                placeholder="Masukkan Kode (Contoh: PD001)" required>
                            <i
                                class="bi bi-keyboard position-absolute top-50 start-0 translate-middle-y ms-3 text-muted fs-5"></i>
                            <button type="submit"
                                class="btn btn-primary rounded-pill position-absolute top-0 end-0 h-100 px-4 fw-bold m-0">
                                Check-In
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('seminar_selector').addEventListener('change', function () {
            document.getElementById('hidden_seminar_id').value = this.value;
        });

        function startScanner() {
            alert("Scanner feature requires HTTPS and camera permission.");
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
    </style>
@endsection