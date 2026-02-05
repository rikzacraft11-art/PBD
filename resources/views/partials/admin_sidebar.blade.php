<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="logo-icon">
            <i class="bi bi-shield-lock-fill"></i>
        </div>
        <div>
            <h5 class="fw-bold mb-0 text-dark">Portal Admin</h5>
            <small class="text-muted">Seminar System</small>
        </div>
    </div>

    <nav class="sidebar-menu">
        <div class="menu-label">Main Menu</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-fill"></i> Dashboard
        </a>
        <a href="{{ route('admin.seminar') }}" class="nav-link {{ Route::is('admin.seminar*') ? 'active' : '' }}">
            <i class="bi bi-calendar-event"></i> Manajemen Seminar
        </a>
        <a href="{{ route('admin.absensi') }}" class="nav-link {{ Route::is('admin.absensi') ? 'active' : '' }}">
            <i class="bi bi-qr-code-scan"></i> Absensi
        </a>
        <a href="{{ route('admin.sertifikat') }}" class="nav-link {{ Route::is('admin.sertifikat') ? 'active' : '' }}">
            <i class="bi bi-book"></i> Sertifikat
        </a>

        <div class="menu-label mt-4">Account</div>
        <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="nav-link text-danger w-100 border-0 bg-transparent text-start">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    </nav>

    <div class="p-3 border-top">
        <div class="d-flex align-items-center gap-2 px-2">
            <div class="rounded-circle bg-indigo-soft text-indigo d-flex align-items-center justify-content-center"
                style="width: 32px; height: 32px;">
                <i class="bi bi-person-fill"></i>
            </div>
            <div>
                <small
                    class="d-block fw-bold text-dark">{{ Auth::guard('admin')->user()->nama_admin ?? 'Admin' }}</small>
                <small class="d-block text-muted" style="font-size: 10px;">Administrator</small>
            </div>
        </div>
    </div>
</aside>