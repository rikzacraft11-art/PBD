<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Hardened UI Mockup</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-color: #4f46e5;
            /* Indigo 600 */
            --primary-hover: #4338ca;
            /* Indigo 700 */
            --bg-body: #f1f5f9;
            /* Slate 100 */
            --bg-sidebar: #ffffff;
            --text-main: #0f172a;
            /* Slate 900 */
            --text-muted: #64748b;
            /* Slate 500 */
            --border-color: #e2e8f0;
            /* Slate 200 */
            --sidebar-width: 280px;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            overflow-x: hidden;
        }

        /* HARDENED SIDEBAR */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: var(--bg-sidebar);
            border-right: 1px solid var(--border-color);
            z-index: 1000;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: rgba(79, 70, 229, 0.1);
            color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            font-size: 1.25rem;
        }

        .sidebar-menu {
            padding: 1.5rem;
            flex-grow: 1;
            overflow-y: auto;
        }

        .menu-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-muted);
            font-weight: 600;
            margin-bottom: 0.75rem;
            padding-left: 0.75rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: var(--text-muted);
            font-weight: 500;
            border-radius: 0.5rem;
            margin-bottom: 0.25rem;
            transition: all 0.2s;
        }

        .nav-link:hover {
            color: var(--primary-color);
            background: rgba(79, 70, 229, 0.05);
        }

        .nav-link.active {
            color: var(--primary-color);
            background: rgba(79, 70, 229, 0.1);
            font-weight: 600;
        }

        .nav-link i {
            font-size: 1.1rem;
            margin-right: 0.75rem;
        }

        /* HARDENED MAIN CONTENT */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 2rem;
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        /* TOP NAVBAR */
        .top-navbar {
            background: transparent;
            padding-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .search-bar {
            background: #fff;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            display: flex;
            align-items: center;
            width: 300px;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }

        .search-bar input {
            border: none;
            outline: none;
            width: 100%;
            margin-left: 0.5rem;
            color: var(--text-main);
        }

        .profile-menu {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .btn-icon-notify {
            position: relative;
            font-size: 1.25rem;
            color: var(--text-muted);
            cursor: pointer;
        }

        .notification-dot {
            position: absolute;
            top: -2px;
            right: -2px;
            width: 8px;
            height: 8px;
            background: #ef4444;
            border-radius: 50%;
            border: 2px solid var(--bg-body);
        }

        /* DASHBOARD CARDS */
        .stat-card {
            background: #fff;
            border: 1px solid var(--border-color);
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -1px rgba(0, 0, 0, 0.02);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.025);
        }

        .icon-box {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        /* Utility Classes for Colors */
        .color-indigo {
            color: #4f46e5;
            background: #e0e7ff;
        }

        .color-emerald {
            color: #10b981;
            background: #dcfce7;
        }

        .color-amber {
            color: #f59e0b;
            background: #fef3c7;
        }

        .color-rose {
            color: #f43f5e;
            background: #ffe4e6;
        }

        .text-indigo {
            color: #4f46e5 !important;
        }

        .bg-indigo-soft {
            background: #e0e7ff !important;
        }

        /* TABLE STYLES */
        .custom-table {
            border-collapse: separate;
            border-spacing: 0 0.5rem;
        }

        .custom-table th {
            border: none;
            color: var(--text-muted);
            font-weight: 600;
            font-size: 0.875rem;
            padding: 1rem;
            background: transparent;
        }

        .custom-table td {
            background: #fff;
            border-top: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
            padding: 1rem;
            vertical-align: middle;
        }

        .custom-table tr td:first-child {
            border-left: 1px solid var(--border-color);
            border-top-left-radius: 0.75rem;
            border-bottom-left-radius: 0.75rem;
        }

        .custom-table tr td:last-child {
            border-right: 1px solid var(--border-color);
            border-top-right-radius: 0.75rem;
            border-bottom-right-radius: 0.75rem;
        }

        /* RESPONSIVE */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .main-content {
                margin-left: 0;
            }

            .sidebar.active {
                transform: translateX(0);
            }
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
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
            <a href="#" class="nav-link active">
                <i class="bi bi-grid-fill"></i> Dashboard
            </a>
            <a href="#" class="nav-link">
                <i class="bi bi-calendar-event"></i> Manajemen Seminar
            </a>
            <a href="#" class="nav-link">
                <i class="bi bi-qr-code-scan"></i> Absensi
            </a>
            <a href="#" class="nav-link">
                <i class="bi bi-book"></i> Sertifikat
            </a>

            <div class="menu-label mt-4">Settings</div>
            <a href="#" class="nav-link">
                <i class="bi bi-person-gear"></i> Profile
            </a>
            <a href="#" class="nav-link text-danger">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </nav>

        <div class="p-3 border-top">
            <div class="d-flex align-items-center gap-2 px-2">
                <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center"
                    style="width: 32px; height: 32px;">
                    <i class="bi bi-person"></i>
                </div>
                <div>
                    <small class="d-block fw-bold text-dark">Admin User</small>
                    <small class="d-block text-muted" style="font-size: 10px;">admin@example.com</small>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Top Navbar -->
        <div class="top-navbar">
            <div>
                <h4 class="fw-bold mb-0">Dashboard Overview</h4>
                <p class="text-muted mb-0 small">Welcome back, here's what's happening today.</p>
            </div>

            <div class="profile-menu">
                <div class="search-bar d-none d-md-flex">
                    <i class="bi bi-search text-muted"></i>
                    <input type="text" placeholder="Search...">
                </div>
                <div class="btn-icon-notify">
                    <i class="bi bi-bell"></i>
                    <div class="notification-dot"></div>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="row g-4 mb-5">
            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="text-muted small fw-bold mb-1">TOTAL SEMINAR</p>
                            <h2 class="fw-bold mb-0">12</h2>
                        </div>
                        <div class="icon-box color-indigo">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-indigo-soft text-indigo rounded-pill px-2 py-1 small">
                            <i class="bi bi-arrow-up-short"></i> +2 New
                        </span>
                        <span class="text-muted small ms-2">this month</span>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="text-muted small fw-bold mb-1">TOTAL PESERTA</p>
                            <h2 class="fw-bold mb-0">854</h2>
                        </div>
                        <div class="icon-box color-emerald">
                            <i class="bi bi-people"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2 py-1 small">
                            <i class="bi bi-arrow-up-short"></i> +12%
                        </span>
                        <span class="text-muted small ms-2">vs last month</span>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="text-muted small fw-bold mb-1">KEHADIRAN</p>
                            <h2 class="fw-bold mb-0">92%</h2>
                        </div>
                        <div class="icon-box color-amber">
                            <i class="bi bi-check-circle"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="text-muted small">Average attendance rate</span>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="text-muted small fw-bold mb-1">SERTIFIKAT</p>
                            <h2 class="fw-bold mb-0">430</h2>
                        </div>
                        <div class="icon-box color-rose">
                            <i class="bi bi-award"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="text-muted small">Issued this year</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity & Charts Area -->
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold mb-0">Recent Registrations</h5>
                        <button class="btn btn-sm btn-light">View All</button>
                    </div>

                    <div class="table-responsive">
                        <table class="table custom-table">
                            <thead>
                                <tr>
                                    <th>NAME</th>
                                    <th>SEMINAR</th>
                                    <th>DATE</th>
                                    <th>STATUS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center fw-bold text-primary"
                                                style="width: 32px; height: 32px;">JD</div>
                                            <span class="fw-semibold">John Doe</span>
                                        </div>
                                    </td>
                                    <td>Web Development 101</td>
                                    <td class="text-muted">Oct 24, 2023</td>
                                    <td><span
                                            class="badge bg-success bg-opacity-10 text-success px-3 rounded-pill">Paid</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center fw-bold text-warning"
                                                style="width: 32px; height: 32px;">AS</div>
                                            <span class="fw-semibold">Alice Smith</span>
                                        </div>
                                    </td>
                                    <td>Data Science Intro</td>
                                    <td class="text-muted">Oct 23, 2023</td>
                                    <td><span
                                            class="badge bg-warning bg-opacity-10 text-warning px-3 rounded-pill">Pending</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center fw-bold text-danger"
                                                style="width: 32px; height: 32px;">RJ</div>
                                            <span class="fw-semibold">Robert Junior</span>
                                        </div>
                                    </td>
                                    <td>Cyber Security Basics</td>
                                    <td class="text-muted">Oct 22, 2023</td>
                                    <td><span
                                            class="badge bg-success bg-opacity-10 text-success px-3 rounded-pill">Paid</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div
                    class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-indigo-soft text-center position-relative overflow-hidden">
                    <div style="position: relative; z-index: 2;">
                        <h4 class="fw-bold text-primary mb-3">Upgrade Pro</h4>
                        <p class="text-muted mb-4 small">Unlock more features and get unlimited access to seminar
                            resources.</p>
                        <button class="btn btn-primary w-100 rounded-pill py-2 shadow-sm">View Seminar Details</button>
                    </div>
                    <!-- Decor element -->
                    <div
                        style="position: absolute; bottom: -20px; right: -20px; width: 150px; height: 150px; background: rgba(79, 70, 229, 0.1); border-radius: 50%;">
                    </div>
                    <div
                        style="position: absolute; top: -20px; left: -20px; width: 100px; height: 100px; background: rgba(79, 70, 229, 0.05); border-radius: 50%;">
                    </div>
                </div>
            </div>
        </div>

    </main>
</body>

</html>