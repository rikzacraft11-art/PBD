<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Peserta - SeminarKu</title>

    {{-- Stylesheets & Fonts --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

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
            --bg-card: #ffffff;
            --bg-glass: rgba(255, 255, 255, 0.8);

            --text-dark: #0f172a;
            --text-muted: #64748b;
            --text-light: #94a3b8;

            --border-color: #e2e8f0;
            --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            --shadow-xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);

            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --radius-xl: 24px;

            --transition-fast: 0.15s ease;
            --transition-normal: 0.3s ease;
            --transition-slow: 0.5s ease;
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
            background-color: var(--bg-body);
            color: var(--text-dark);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            line-height: 1.6;
        }

        /* ==========================================
           UTILITY CLASSES
        ========================================== */
        .rounded-4 {
            border-radius: var(--radius-xl) !important;
        }

        .rounded-3 {
            border-radius: var(--radius-lg) !important;
        }

        /* Glassmorphism */
        .glass {
            background: var(--bg-glass);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        /* ==========================================
           ANIMATIONS
        ========================================== */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
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

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.5s ease forwards;
        }

        .animate-slideUp {
            animation: slideUp 0.5s ease forwards;
        }

        .animate-slideDown {
            animation: slideDown 0.5s ease forwards;
        }

        .animate-scaleIn {
            animation: scaleIn 0.3s ease forwards;
        }

        /* Staggered animations for children */
        .stagger-children>* {
            opacity: 0;
            animation: slideUp 0.5s ease forwards;
        }

        .stagger-children>*:nth-child(1) {
            animation-delay: 0.1s;
        }

        .stagger-children>*:nth-child(2) {
            animation-delay: 0.2s;
        }

        .stagger-children>*:nth-child(3) {
            animation-delay: 0.3s;
        }

        .stagger-children>*:nth-child(4) {
            animation-delay: 0.4s;
        }

        .stagger-children>*:nth-child(5) {
            animation-delay: 0.5s;
        }

        .stagger-children>*:nth-child(6) {
            animation-delay: 0.6s;
        }

        /* ==========================================
           CARD ENHANCEMENTS
        ========================================== */
        .card {
            transition: transform var(--transition-normal), box-shadow var(--transition-normal);
        }

        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-xl);
        }

        .card-3d {
            transform-style: preserve-3d;
            perspective: 1000px;
        }

        .card-3d:hover {
            transform: perspective(1000px) rotateX(2deg) rotateY(-2deg);
        }

        /* ==========================================
           BUTTON ENHANCEMENTS
        ========================================== */
        .btn {
            transition: all var(--transition-normal);
            position: relative;
            overflow: hidden;
        }

        .btn::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn:hover::after {
            width: 300px;
            height: 300px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary) 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.4);
        }

        /* ==========================================
           MAIN CONTENT
        ========================================== */
        .main-content {
            flex: 1;
        }

        /* ==========================================
           FOOTER
        ========================================== */
        footer {
            background: var(--bg-card);
            border-top: 1px solid var(--border-color);
            animation: slideUp 0.5s ease 0.3s forwards;
            opacity: 0;
        }

        /* ==========================================
           CUSTOM SCROLLBAR
        ========================================== */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-body);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--text-light);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--text-muted);
        }

        /* ==========================================
           FOCUS STATES (Accessibility)
        ========================================== */
        :focus-visible {
            outline: 2px solid var(--primary);
            outline-offset: 2px;
        }

        /* ==========================================
           RESPONSIVE
        ========================================== */
        @media (max-width: 768px) {
            .container-fluid {
                padding-left: 1rem;
                padding-right: 1rem;
            }
        }
    </style>
</head>

<body>

    {{-- Main Content --}}
    <main class="main-content">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="py-4 mt-auto">
        <div class="container-fluid text-center">
            <p class="text-muted mb-0 small">
                &copy; {{ date('Y') }} <strong>SeminarKu</strong> - Sistem Informasi Seminar UNIKOM. All rights
                reserved.
            </p>
        </div>
    </footer>

    {{-- Scripts --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Add intersection observer for scroll animations
        document.addEventListener('DOMContentLoaded', function () {
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-slideUp');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.observe-scroll').forEach(el => observer.observe(el));
        });
    </script>

    @stack('scripts')
</body>

</html>