{{-- resources/views/partials/peserta_header.blade.php --}}
<div class="header-wrapper mb-4 animate-slideDown">
    {{-- MAIN HEADER BAR --}}
    <div class="card border-0 shadow-lg rounded-4 overflow-hidden glass">
        {{-- Top Section: Logo & User Actions --}}
        <div class="card-body p-3 border-bottom" style="border-color: rgba(0,0,0,0.05) !important;">
            <div class="d-flex justify-content-between align-items-center">
                {{-- Brand --}}
                <div class="d-flex align-items-center">
                    <div class="brand-icon me-3">
                        <i class="bi bi-mortarboard-fill"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0" style="color: var(--primary);">SeminarKu</h4>
                        <p class="text-muted small mb-0">Selamat datang,
                            <strong>{{ Auth::user()->nama_peserta }}</strong></p>
                    </div>
                </div>

                {{-- User Actions --}}
                <div class="d-flex align-items-center gap-3">
                    {{-- User Badge --}}
                    <div class="user-badge d-none d-md-flex">
                        <div class="avatar">
                            {{ strtoupper(substr(Auth::user()->nama_peserta, 0, 1)) }}
                        </div>
                        <div class="user-info">
                            <span class="user-name">{{ Auth::user()->nama_peserta }}</span>
                            <span class="user-nim">{{ Auth::user()->nim_peserta }}</span>
                        </div>
                    </div>

                    {{-- Logout Button --}}
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="btn-logout">
                            <i class="bi bi-box-arrow-right"></i>
                            <span class="d-none d-sm-inline">Keluar</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Navigation Tabs --}}
        <div class="card-body p-0">
            <nav class="nav-tabs-custom">
                <a class="nav-tab {{ Route::is('portal.dashboard') ? 'active' : '' }}"
                    href="{{ route('portal.dashboard') }}">
                    <i class="bi bi-house-fill"></i>
                    <span>Dashboard</span>
                    <div class="tab-indicator"></div>
                </a>
                <a class="nav-tab {{ Route::is('portal.index') ? 'active' : '' }}" href="{{ route('portal.index') }}">
                    <i class="bi bi-calendar-check"></i>
                    <span>Cari Seminar</span>
                    <div class="tab-indicator"></div>
                </a>
            </nav>
        </div>
    </div>
</div>

<style>
    /* Brand Icon */
    .brand-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, var(--primary) 0%, var(--accent, #a855f7) 100%);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
    }

    /* User Badge */
    .user-badge {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.5rem 1rem;
        background: rgba(99, 102, 241, 0.08);
        border-radius: 50px;
    }

    .avatar {
        width: 36px;
        height: 36px;
        background: linear-gradient(135deg, var(--primary) 0%, var(--accent, #a855f7) 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 0.9rem;
    }

    .user-info {
        display: flex;
        flex-direction: column;
    }

    .user-name {
        font-weight: 600;
        font-size: 0.85rem;
        color: var(--text-dark);
        line-height: 1.2;
    }

    .user-nim {
        font-size: 0.75rem;
        color: var(--text-muted);
    }

    /* Logout Button */
    .btn-logout {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.6rem 1.25rem;
        background: transparent;
        border: 2px solid #fee2e2;
        color: #ef4444;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.85rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-logout:hover {
        background: #ef4444;
        border-color: #ef4444;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    /* Navigation Tabs */
    .nav-tabs-custom {
        display: flex;
        gap: 0;
    }

    .nav-tab {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 1rem 1.5rem;
        color: var(--text-muted);
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9rem;
        position: relative;
        transition: all 0.3s ease;
    }

    .nav-tab:hover {
        color: var(--primary);
        background: rgba(99, 102, 241, 0.05);
    }

    .nav-tab.active {
        color: var(--primary);
    }

    .tab-indicator {
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--primary), var(--accent, #a855f7));
        border-radius: 3px 3px 0 0;
        transition: width 0.3s ease;
    }

    .nav-tab.active .tab-indicator,
    .nav-tab:hover .tab-indicator {
        width: 80%;
    }

    .nav-tab i {
        font-size: 1.1rem;
    }

    /* Responsive */
    @media (max-width: 576px) {
        .nav-tab {
            padding: 0.875rem 1rem;
            font-size: 0.85rem;
        }

        .nav-tab span {
            display: none;
        }

        .nav-tab i {
            font-size: 1.25rem;
        }
    }
</style>