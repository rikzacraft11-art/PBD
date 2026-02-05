<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Sistem Seminar</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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

        /* SIDEBAR STYLES */
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

        /* MAIN CONTENT WRAPPER */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 2rem;
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        /* UTILITIES */
        .text-indigo {
            color: #4f46e5 !important;
        }

        .bg-indigo-soft {
            background: #e0e7ff !important;
        }

        .rounded-4 {
            border-radius: 1rem !important;
        }

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

    {{-- SIDEBAR --}}
    @include('partials.admin_sidebar')

    {{-- MAIN CONTENT --}}
    <main class="main-content">

        {{-- TOP HEADER --}}
        @include('partials.admin_header')
        
        @yield('content')

    </main>

    {{-- SCRIPTS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>