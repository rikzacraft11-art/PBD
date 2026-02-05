<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Peserta - SeminarKu</title>

    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
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
            --bg-dark: #0f172a;
            --bg-card: rgba(255, 255, 255, 0.85);
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --border-color: rgba(255, 255, 255, 0.2);
            --shadow-lg: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            --radius-xl: 24px;
            --radius-lg: 16px;
            --radius-md: 12px;
        }

        /* ==========================================
           RESET & BASE
        ========================================== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            background: var(--bg-dark);
            overflow-x: hidden;
        }

        /* ==========================================
           SPLIT SCREEN LAYOUT
        ========================================== */
        .split-left {
            flex: 1;
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 50%, #ec4899 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem;
            position: relative;
            overflow: hidden;
        }

        .split-left::before {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            top: -200px;
            left: -100px;
            animation: float 8s ease-in-out infinite;
        }

        .split-left::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.08) 0%, transparent 70%);
            bottom: -100px;
            right: -50px;
            animation: float 6s ease-in-out infinite reverse;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0) rotate(0deg);
            }

            50% {
                transform: translateY(-30px) rotate(5deg);
            }
        }

        .brand-content {
            position: relative;
            z-index: 10;
            text-align: center;
            color: white;
        }

        .brand-icon {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2.5rem;
            border: 1px solid rgba(255, 255, 255, 0.3);
            animation: pulse-glow 3s ease-in-out infinite;
        }

        @keyframes pulse-glow {

            0%,
            100% {
                box-shadow: 0 0 30px rgba(255, 255, 255, 0.2);
            }

            50% {
                box-shadow: 0 0 50px rgba(255, 255, 255, 0.4);
            }
        }

        .brand-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        .brand-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
            font-weight: 400;
        }

        .features-list {
            margin-top: 3rem;
            text-align: left;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
            opacity: 0;
            animation: slideIn 0.5s ease forwards;
        }

        .feature-item:nth-child(1) {
            animation-delay: 0.2s;
        }

        .feature-item:nth-child(2) {
            animation-delay: 0.4s;
        }

        .feature-item:nth-child(3) {
            animation-delay: 0.6s;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .feature-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .feature-text {
            font-size: 0.95rem;
            font-weight: 500;
        }

        /* ==========================================
           RIGHT SIDE - LOGIN FORM
        ========================================== */
        .split-right {
            width: 480px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            background: #f8fafc;
        }

        .login-container {
            width: 100%;
            max-width: 380px;
            animation: fadeUp 0.8s ease;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-header h2 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .login-header p {
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        /* ==========================================
           GLASSMORPHISM CARD
        ========================================== */
        .glass-card {
            background: white;
            border-radius: var(--radius-xl);
            padding: 2rem;
            box-shadow: var(--shadow-lg);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        /* ==========================================
           FLOATING LABEL INPUTS
        ========================================== */
        .form-floating {
            position: relative;
            margin-bottom: 1.25rem;
        }

        .form-floating input {
            width: 100%;
            padding: 1.25rem 1rem 0.75rem;
            font-size: 1rem;
            font-family: inherit;
            border: 2px solid #e2e8f0;
            border-radius: var(--radius-md);
            background: #f8fafc;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-floating input:focus {
            border-color: var(--primary);
            background: white;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }

        .form-floating label {
            position: absolute;
            top: 50%;
            left: 1rem;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 0.95rem;
            font-weight: 500;
            pointer-events: none;
            transition: all 0.2s ease;
            background: transparent;
            padding: 0 0.25rem;
        }

        .form-floating input:focus~label,
        .form-floating input:not(:placeholder-shown)~label {
            top: 0;
            font-size: 0.75rem;
            color: var(--primary);
            background: white;
        }

        /* ==========================================
           SUBMIT BUTTON
        ========================================== */
        .btn-submit {
            width: 100%;
            padding: 1rem;
            font-size: 1rem;
            font-weight: 600;
            font-family: inherit;
            color: white;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border: none;
            border-radius: var(--radius-md);
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(99, 102, 241, 0.4);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .btn-submit::after {
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

        .btn-submit:hover::after {
            width: 300px;
            height: 300px;
        }

        .btn-submit span {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        /* Loading State */
        .btn-submit.loading span {
            opacity: 0;
        }

        .btn-submit.loading::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 24px;
            height: 24px;
            margin: -12px 0 0 -12px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* ==========================================
           ALERTS
        ========================================== */
        .alert {
            padding: 1rem;
            border-radius: var(--radius-md);
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            animation: shake 0.5s ease;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            20%,
            60% {
                transform: translateX(-5px);
            }

            40%,
            80% {
                transform: translateX(5px);
            }
        }

        .alert-danger {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        .alert-success {
            background: #f0fdf4;
            color: #16a34a;
            border: 1px solid #bbf7d0;
        }

        /* ==========================================
           FOOTER LINKS
        ========================================== */
        .login-footer {
            text-align: center;
            margin-top: 1.5rem;
        }

        .login-footer p {
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .login-footer a {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s;
        }

        .login-footer a:hover {
            color: var(--primary-dark);
        }

        .login-footer small {
            display: block;
            margin-top: 1rem;
            color: #94a3b8;
            font-size: 0.8rem;
        }

        /* ==========================================
           RESPONSIVE
        ========================================== */
        @media (max-width: 992px) {
            body {
                flex-direction: column;
            }

            .split-left {
                min-height: 40vh;
                padding: 2rem;
            }

            .brand-title {
                font-size: 2rem;
            }

            .features-list {
                display: none;
            }

            .split-right {
                width: 100%;
                min-height: auto;
                flex: 1;
            }
        }

        @media (max-width: 480px) {
            .split-right {
                padding: 1.5rem;
            }

            .glass-card {
                padding: 1.5rem;
            }
        }
    </style>
</head>

<body>

    {{-- LEFT SIDE - BRANDING --}}
    <div class="split-left">
        <div class="brand-content">
            <div class="brand-icon">
                <i class="bi bi-mortarboard-fill"></i>
            </div>
            <h1 class="brand-title">SeminarKu</h1>
            <p class="brand-subtitle">Sistem Pendaftaran Seminar UNIKOM</p>

            <div class="features-list">
                <div class="feature-item">
                    <div class="feature-icon"><i class="bi bi-lightning-charge-fill"></i></div>
                    <span class="feature-text">Pendaftaran Cepat & Mudah</span>
                </div>
                <div class="feature-item">
                    <div class="feature-icon"><i class="bi bi-qr-code"></i></div>
                    <span class="feature-text">QR Code untuk Absensi</span>
                </div>
                <div class="feature-item">
                    <div class="feature-icon"><i class="bi bi-award-fill"></i></div>
                    <span class="feature-text">Kumpulkan Poin & Sertifikat</span>
                </div>
            </div>
        </div>
    </div>

    {{-- RIGHT SIDE - LOGIN FORM --}}
    <div class="split-right">
        <div class="login-container">
            <div class="login-header">
                <h2>Selamat Datang! 👋</h2>
                <p>Masuk ke akun peserta Anda</p>
            </div>

            <div class="glass-card">
                {{-- Error Alert --}}
                @if(session('error'))
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-circle-fill"></i>
                        {{ session('error') }}
                    </div>
                @endif

                {{-- Success Alert --}}
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="bi bi-check-circle-fill"></i>
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST" id="loginForm">
                    @csrf

                    <div class="form-floating">
                        <input type="text" name="nim" id="nim" placeholder=" " required autocomplete="username">
                        <label for="nim"><i class="bi bi-person-badge me-2"></i>NIM Peserta</label>
                    </div>

                    <div class="form-floating">
                        <input type="password" name="password" id="password" placeholder=" " required
                            autocomplete="current-password">
                        <label for="password"><i class="bi bi-lock me-2"></i>Password</label>
                    </div>

                    <button type="submit" class="btn-submit" id="btnSubmit">
                        <span>
                            Masuk ke Portal
                            <i class="bi bi-arrow-right"></i>
                        </span>
                    </button>
                </form>
            </div>

            <div class="login-footer">
                <p>Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a></p>
                <small>Universitas Komputer Indonesia © {{ date('Y') }}</small>
            </div>
        </div>
    </div>

    <script>
        // Loading state on submit
        document.getElementById('loginForm').addEventListener('submit', function () {
            document.getElementById('btnSubmit').classList.add('loading');
        });
    </script>
</body>

</html>