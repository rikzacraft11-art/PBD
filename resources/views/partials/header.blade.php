{{-- resources/views/partials/header.blade.php --}}
<header class="admin-header d-flex justify-content-between align-items-center mb-0" style="background: white; border-bottom: 1px solid #e2e8f0; padding: 1rem 2rem;">
    <div>
        <h4 class="fw-bold mb-0 text-primary">Admin Dashboard</h4>
        <small class="text-muted">Sistem Pendaftaran Seminar</small>
    </div>
    <div class="d-flex align-items-center gap-3">
        {{-- Nama Admin dari Guard --}}
        <span class="fw-bold text-primary">
            <i class="bi bi-person-circle"></i> {{ Auth::guard('admin')->user()->nama_admin }}
        </span>
        {{-- Tombol Logout --}}
        <form action="{{ route('admin.logout') }}" method="POST" class="m-0">
            @csrf
            <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    </div>
</header>