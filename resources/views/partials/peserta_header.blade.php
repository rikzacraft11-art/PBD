{{-- resources/views/partials/peserta_header.blade.php --}}
<div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
    {{-- BAGIAN ATAS: Portal Identity & Logout --}}
    <div class="card-body p-3 border-bottom bg-white">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-2 me-3">
                    <i class="bi bi-mortarboard-fill fs-4"></i>
                </div>
                <div>
                    <h4 class="fw-bold mb-0 text-dark">Portal Peserta</h4>
                    <p class="text-muted small mb-0">Selamat datang, {{ Auth::user()->nama_peserta }}</p>
                </div>
            </div>

            <div class="d-flex align-items-center">
                {{-- Menampilkan Nama Admin yang sedang login --}}
                <span class="me-3 fw-bold text-primary">
                    <i class="bi bi-person-circle"></i> {{ Auth::user()->nama_peserta }}
                </span>
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>

        </div>
    </div>

    {{-- BAGIAN BAWAH: Navigasi Tab (Daftar & Dashboard) --}}
    <div class="card-body p-0 bg-white">
        <ul class="nav nav-pills">
            <li class="nav-item">
                {{-- Link Dashboard Saya --}}
                <a class="nav-link {{ Route::is('portal.dashboard') ? 'active' : 'text-dark' }} px-4 py-3 fw-bold custom-tab"
                    href="{{ route('portal.dashboard') }}">
                    <i class="bi bi-house-fill me-2"></i> Dashboard Saya
                </a>
            </li>
            <li class="nav-item">
                {{-- Link Daftar Seminar --}}
                <a class="nav-link {{ Route::is('portal.index') ? 'active' : 'text-dark' }} px-4 py-3 fw-bold custom-tab"
                    href="{{ route('portal.index') }}">
                    <i class="bi bi-calendar-check me-2"></i> Daftar Seminar
                </a>
            </li>
        </ul>
    </div>
</div>

<style>
    /* Sinkronisasi Indigo Theme */
    .nav-pills .nav-link.active {
        background-color: transparent !important;
        color: #6366f1 !important;
        /* Indigo Color */
        border-bottom: 3px solid #6366f1 !important;
        border-radius: 0;
        margin-bottom: -1px;
        /* Menempel pada border bawah kartu */
    }

    .custom-tab:hover {
        color: #6366f1 !important;
        background-color: #f8fafc;
    }

    .rounded-4 {
        border-radius: 1rem !important;
    }

    .nav-link {
        transition: all 0.2s ease-in-out;
        border: none;
    }
</style>