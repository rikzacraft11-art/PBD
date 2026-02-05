{{-- resources/views/partials/admin_header.blade.php --}}
<div class="d-flex justify-content-between align-items-center mb-5">
    <div>
        <h4 class="fw-bold mb-0">@yield('header_title', 'Portal Admin')</h4>
        <p class="text-muted mb-0 small">@yield('header_subtitle', 'Sistem Informasi Seminar')</p>
    </div>

    <div class="d-flex align-items-center gap-4">
        <div class="bg-white border rounded-3 px-3 py-2 d-none d-md-flex align-items-center shadow-sm">
            <i class="bi bi-search text-muted me-2"></i>
            <input type="text" class="border-0 bg-transparent text-muted small" placeholder="Search..."
                style="outline: none;">
        </div>

        <div class="position-relative text-muted" role="button">
            <i class="bi bi-bell fs-5"></i>
            <span
                class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
                <span class="visually-hidden">New alerts</span>
            </span>
        </div>
    </div>
</div>