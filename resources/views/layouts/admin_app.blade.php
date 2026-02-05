<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - SeminarKu</title>

    {{-- Fonts & Icons --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        /* ==========================================
           CSS VARIABLES - DESIGN TOKENS
        ========================================== */
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --primary-light: #818cf8;
            --accent: #a855f7;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #3b82f6;

            --bg-body: #f1f5f9;
            --bg-sidebar: #0f172a;
            --bg-card: #ffffff;
            --bg-glass: rgba(255, 255, 255, 0.85);

            --text-dark: #0f172a;
            --text-muted: #64748b;
            --text-light: #94a3b8;
            --text-sidebar: rgba(255, 255, 255, 0.7);

            --border-color: #e2e8f0;
            --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
            --shadow-lg: 0 10px 40px rgba(0, 0, 0, 0.1);

            --radius-md: 12px;
            --radius-lg: 16px;
            --radius-xl: 24px;

            --sidebar-width: 280px;
            --sidebar-collapsed: 80px;
            --header-height: 80px;

            --transition-fast: 0.2s ease;
            --transition-normal: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* ==========================================
           RESET & BASE
        ========================================== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg-body);
            color: var(--text-dark);
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ==========================================
           SIDEBAR
        ========================================== */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--bg-sidebar);
            min-height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            transition: transform var(--transition-normal);
        }

        .sidebar-brand {
            padding: 1.5rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .brand-icon {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .brand-text h5 {
            color: white;
            font-weight: 700;
            font-size: 1.1rem;
            margin: 0;
        }

        .brand-text small {
            color: var(--text-sidebar);
            font-size: 0.75rem;
        }

        /* Navigation */
        .sidebar-nav {
            flex: 1;
            padding: 1rem 0;
            overflow-y: auto;
        }

        .nav-section {
            padding: 0.5rem 1.5rem;
            margin-top: 1rem;
        }

        .nav-section-title {
            font-size: 0.7rem;
            font-weight: 600;
            color: var(--text-light);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .nav-item {
            margin: 0.25rem 0.75rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.875rem;
            padding: 0.875rem 1rem;
            color: var(--text-sidebar);
            text-decoration: none;
            border-radius: var(--radius-md);
            font-weight: 500;
            font-size: 0.9rem;
            transition: all var(--transition-fast);
            position: relative;
        }

        .nav-link i {
            font-size: 1.15rem;
            width: 24px;
            text-align: center;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.08);
            color: white;
            transform: translateX(4px);
        }

        .nav-link.active {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: white;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.4);
        }

        .nav-link.active::before {
            content: '';
            position: absolute;
            left: -0.75rem;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 24px;
            background: var(--primary-light);
            border-radius: 0 4px 4px 0;
        }

        /* Sidebar Footer */
        .sidebar-footer {
            padding: 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .admin-badge {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem;
            background: rgba(255, 255, 255, 0.05);
            border-radius: var(--radius-md);
        }

        .admin-avatar {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, var(--success), #059669);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 0.9rem;
        }

        .admin-info {
            flex: 1;
        }

        .admin-name {
            color: white;
            font-weight: 600;
            font-size: 0.85rem;
            display: block;
        }

        .admin-role {
            color: var(--text-sidebar);
            font-size: 0.75rem;
        }

        /* ==========================================
           MAIN CONTENT AREA
        ========================================== */
        .main-wrapper {
            flex: 1;
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Header */
        .main-header {
            background: var(--bg-glass);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 2rem;
            position: sticky;
            top: 0;
            z-index: 100;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-left h4 {
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
            font-size: 1.25rem;
        }

        .header-left p {
            color: var(--text-muted);
            font-size: 0.85rem;
            margin: 0;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .btn-logout {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1.25rem;
            background: transparent;
            border: 2px solid #fee2e2;
            color: var(--danger);
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all var(--transition-fast);
            text-decoration: none;
        }

        .btn-logout:hover {
            background: var(--danger);
            border-color: var(--danger);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        /* Content Area */
        .main-content {
            flex: 1;
            padding: 2rem;
        }

        /* ==========================================
           CARD COMPONENTS (for child views)
        ========================================== */
        .card {
            border-radius: var(--radius-xl) !important;
            border: none !important;
            box-shadow: var(--shadow-lg);
            transition: transform var(--transition-normal), box-shadow var(--transition-normal);
        }

        .card:hover {
            transform: translateY(-2px);
        }

        .rounded-4 {
            border-radius: var(--radius-xl) !important;
        }

        /* Stat Card Enhancements */
        .stat-card {
            background: white;
            border-radius: var(--radius-xl);
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            transition: all var(--transition-normal);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 100px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.1), transparent);
            border-radius: 50%;
            transform: translate(30%, -30%);
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
        }

        /* Icon Box */
        .icon-box {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .color-indigo {
            color: #6366f1;
            background: rgba(99, 102, 241, 0.1);
        }

        .color-emerald {
            color: #10b981;
            background: rgba(16, 185, 129, 0.1);
        }

        .color-amber {
            color: #f59e0b;
            background: rgba(245, 158, 11, 0.1);
        }

        .color-rose {
            color: #ef4444;
            background: rgba(239, 68, 68, 0.1);
        }

        .color-blue {
            color: #3b82f6;
            background: rgba(59, 130, 246, 0.1);
        }

        /* Badge Enhancements */
        .bg-indigo-soft {
            background: rgba(99, 102, 241, 0.1) !important;
        }

        .text-indigo {
            color: #6366f1 !important;
        }

        .bg-emerald-light {
            background: rgba(16, 185, 129, 0.1) !important;
        }

        .bg-indigo {
            background: #6366f1 !important;
        }

        /* Table Enhancements */
        .custom-table {
            border-collapse: separate;
            border-spacing: 0 0.5rem;
        }

        .custom-table th {
            border: none;
            color: var(--text-muted);
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 1rem;
            background: transparent;
        }

        .custom-table td {
            background: #fff;
            border-top: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
            padding: 1rem;
            vertical-align: middle;
            transition: all var(--transition-fast);
        }

        .custom-table tr:hover td {
            background: #f8fafc;
        }

        .custom-table tr td:first-child {
            border-left: 1px solid var(--border-color);
            border-radius: var(--radius-md) 0 0 var(--radius-md);
        }

        .custom-table tr td:last-child {
            border-right: 1px solid var(--border-color);
            border-radius: 0 var(--radius-md) var(--radius-md) 0;
        }

        /* ==========================================
           ANIMATIONS
        ========================================== */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.5s ease forwards;
        }

        .stagger-animate>* {
            opacity: 0;
            animation: fadeInUp 0.5s ease forwards;
        }

        .stagger-animate>*:nth-child(1) {
            animation-delay: 0.1s;
        }

        .stagger-animate>*:nth-child(2) {
            animation-delay: 0.2s;
        }

        .stagger-animate>*:nth-child(3) {
            animation-delay: 0.3s;
        }

        .stagger-animate>*:nth-child(4) {
            animation-delay: 0.4s;
        }

        /* ==========================================
           MOBILE RESPONSIVE
        ========================================== */
        .sidebar-toggle {
            display: none;
            background: var(--primary);
            color: white;
            border: none;
            padding: 0.75rem;
            border-radius: 10px;
            cursor: pointer;
        }

        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-wrapper {
                margin-left: 0;
            }

            .sidebar-toggle {
                display: flex;
            }

            .main-content {
                padding: 1rem;
            }
        }

        /* ==========================================
           SCROLLBAR
        ========================================== */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--text-light);
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--text-muted);
        }
    </style>
</head>

<body>

    {{-- Sidebar --}}
    <aside class="sidebar" id="sidebar">
        {{-- Brand --}}
        <div class="sidebar-brand">
            <div class="brand-icon">
                <i class="bi bi-mortarboard-fill"></i>
            </div>
            <div class="brand-text">
                <h5>SeminarKu</h5>
                <small>Admin Panel</small>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="sidebar-nav">
            <div class="nav-section">
                <span class="nav-section-title">Menu Utama</span>
            </div>

            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }}"
                        href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-grid-1x2-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('admin.seminar*') ? 'active' : '' }}"
                        href="{{ route('admin.seminar') }}">
                        <i class="bi bi-calendar-event-fill"></i>
                        <span>Kelola Seminar</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('admin.absensi*') ? 'active' : '' }}"
                        href="{{ route('admin.absensi') }}">
                        <i class="bi bi-qr-code-scan"></i>
                        <span>Absensi Peserta</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('admin.sertifikat*') ? 'active' : '' }}"
                        href="{{ route('admin.sertifikat') }}">
                        <i class="bi bi-award-fill"></i>
                        <span>Data Sertifikat</span>
                    </a>
                </li>
            </ul>
        </nav>

        {{-- Footer --}}
        <div class="sidebar-footer">
            <div class="admin-badge">
                <div class="admin-avatar">
                    {{ strtoupper(substr(Auth::guard('admin')->user()->nama ?? 'A', 0, 1)) }}
                </div>
                <div class="admin-info">
                    <span class="admin-name">{{ Auth::guard('admin')->user()->nama ?? 'Administrator' }}</span>
                    <span class="admin-role">Super Admin</span>
                </div>
            </div>
        </div>
    </aside>

    {{-- Main Content Wrapper --}}
    <div class="main-wrapper">
        {{-- Header --}}
        <header class="main-header">
            <div class="d-flex align-items-center gap-3">
                <button class="sidebar-toggle" id="sidebarToggle">
                    <i class="bi bi-list fs-5"></i>
                </button>
                <div class="header-left">
                    <h4>@yield('header_title', 'Dashboard')</h4>
                    <p>@yield('header_subtitle', 'Welcome to admin panel')</p>
                </div>
            </div>
            <div class="header-right">
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-logout">
                        <i class="bi bi-box-arrow-right"></i>
                        <span class="d-none d-sm-inline">Logout</span>
                    </button>
                </form>
            </div>
        </header>

        {{-- Content --}}
        <main class="main-content">
            @yield('content')
        </main>
    </div>

    {{-- Scripts --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Mobile sidebar toggle
        document.getElementById('sidebarToggle')?.addEventListener('click', function () {
            document.getElementById('sidebar').classList.toggle('show');
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function (e) {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.getElementById('sidebarToggle');
            if (window.innerWidth < 992 && sidebar.classList.contains('show')) {
                if (!sidebar.contains(e.target) && !toggle.contains(e.target)) {
                    sidebar.classList.remove('show');
                }
            }
        });
    </script>

    @stack('scripts')
</body>

</html>