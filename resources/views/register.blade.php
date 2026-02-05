<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Peserta - SeminarKu</title>

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
            --accent-pink: #ec4899;
            --bg-dark: #0f172a;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
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
            background: linear-gradient(135deg, var(--accent) 0%, var(--primary) 50%, #3b82f6 100%);
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
            right: -100px;
            animation: float 8s ease-in-out infinite;
        }

        .split-left::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.08) 0%, transparent 70%);
            bottom: -100px;
            left: -50px;
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

        .steps-indicator {
            display: flex;
            gap: 0.5rem;
            margin-top: 3rem;
        }

        .step-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
        }

        .step-dot.active {
            width: 40px;
            border-radius: 6px;
            background: white;
        }

        /* ==========================================
           RIGHT SIDE - REGISTER FORM
        ========================================== */
        .split-right {
            width: 560px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            background: #f8fafc;
            overflow-y: auto;
        }

        .register-container {
            width: 100%;
            max-width: 480px;
            animation: fadeUp 0.8s ease;
            padding: 1rem 0;
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

        .register-header {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .register-header h2 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .register-header p {
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
           FORM ROW
        ========================================== */
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        /* ==========================================
           FLOATING LABEL INPUTS
        ========================================== */
        .form-floating {
            position: relative;
            margin-bottom: 1rem;
        }

        .form-floating input,
        .form-floating select,
        .form-floating textarea {
            width: 100%;
            padding: 1.1rem 1rem 0.6rem;
            font-size: 0.95rem;
            font-family: inherit;
            border: 2px solid var(--border-color);
            border-radius: var(--radius-md);
            background: #f8fafc;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-floating textarea {
            resize: none;
            min-height: 80px;
        }

        .form-floating input:focus,
        .form-floating select:focus,
        .form-floating textarea:focus {
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
            font-size: 0.9rem;
            font-weight: 500;
            pointer-events: none;
            transition: all 0.2s ease;
            background: transparent;
            padding: 0 0.25rem;
        }

        .form-floating textarea~label {
            top: 1.1rem;
            transform: none;
        }

        .form-floating input:focus~label,
        .form-floating input:not(:placeholder-shown)~label,
        .form-floating select:focus~label,
        .form-floating select:not([value=""])~label,
        .form-floating textarea:focus~label,
        .form-floating textarea:not(:placeholder-shown)~label {
            top: 0;
            transform: none;
            font-size: 0.7rem;
            color: var(--primary);
            background: white;
        }

        /* Select always shows label on top */
        .form-floating select~label {
            top: 0;
            transform: none;
            font-size: 0.7rem;
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
            background: linear-gradient(135deg, var(--accent) 0%, var(--primary) 100%);
            border: none;
            border-radius: var(--radius-md);
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            margin-top: 0.5rem;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(168, 85, 247, 0.4);
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
            width: 400px;
            height: 400px;
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
            font-size: 0.85rem;
            font-weight: 500;
        }

        .alert-danger {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        .alert-danger ul {
            margin: 0;
            padding-left: 1.25rem;
        }

        /* ==========================================
           FOOTER LINKS
        ========================================== */
        .register-footer {
            text-align: center;
            margin-top: 1.5rem;
        }

        .register-footer p {
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .register-footer a {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s;
        }

        .register-footer a:hover {
            color: var(--primary-dark);
        }

        /* ==========================================
           RESPONSIVE
        ========================================== */
        @media (max-width: 992px) {
            body {
                flex-direction: column;
            }

            .split-left {
                min-height: 35vh;
                padding: 2rem;
            }

            .brand-title {
                font-size: 1.75rem;
            }

            .steps-indicator {
                display: none;
            }

            .split-right {
                width: 100%;
                min-height: auto;
                flex: 1;
            }
        }

        @media (max-width: 576px) {
            .form-row {
                grid-template-columns: 1fr;
            }

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
                <i class="bi bi-person-plus-fill"></i>
            </div>
            <h1 class="brand-title">Daftar Akun</h1>
            <p class="brand-subtitle">Bergabung dengan komunitas seminar UNIKOM</p>

            <div class="steps-indicator">
                <div class="step-dot active"></div>
                <div class="step-dot"></div>
                <div class="step-dot"></div>
            </div>
        </div>
    </div>

    {{-- RIGHT SIDE - REGISTER FORM --}}
    <div class="split-right">
        <div class="register-container">
            <div class="register-header">
                <h2>Registrasi Peserta 🎓</h2>
                <p>Lengkapi data diri Anda untuk mendaftar seminar</p>
            </div>

            <div class="glass-card">
                {{-- Error Alert --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('register.post') }}" method="POST" id="registerForm">
                    @csrf

                    <div class="form-row">
                        <div class="form-floating">
                            <input type="text" name="nim_peserta" id="nim_peserta" placeholder=" " required
                                value="{{ old('nim_peserta') }}">
                            <label for="nim_peserta">NIM</label>
                        </div>
                        <div class="form-floating">
                            <input type="text" name="nama_peserta" id="nama_peserta" placeholder=" " required
                                value="{{ old('nama_peserta') }}">
                            <label for="nama_peserta">Nama Lengkap</label>
                        </div>
                    </div>

                    <div class="form-floating">
                        <input type="email" name="email" id="email" placeholder=" " required value="{{ old('email') }}">
                        <label for="email"><i class="bi bi-envelope me-1"></i> Email</label>
                    </div>

                    <div class="form-row">
                        <div class="form-floating">
                            <select name="jurusan" id="jurusan" required>
                                <option value="Teknik Informatika" {{ old('jurusan') == 'Teknik Informatika' ? 'selected' : '' }}>Teknik Informatika</option>
                                <option value="Sistem Informasi" {{ old('jurusan') == 'Sistem Informasi' ? 'selected' : '' }}>Sistem Informasi</option>
                                <option value="Teknik Komputer" {{ old('jurusan') == 'Teknik Komputer' ? 'selected' : '' }}>Teknik Komputer</option>
                            </select>
                            <label for="jurusan">Jurusan</label>
                        </div>
                        <div class="form-floating">
                            <input type="number" name="angkatan" id="angkatan" placeholder=" " required
                                value="{{ old('angkatan') }}">
                            <label for="angkatan">Angkatan</label>
                        </div>
                    </div>

                    <div class="form-floating">
                        <textarea name="alamat" id="alamat" placeholder=" " required>{{ old('alamat') }}</textarea>
                        <label for="alamat"><i class="bi bi-geo-alt me-1"></i> Alamat Domisili</label>
                    </div>

                    <div class="form-row">
                        <div class="form-floating">
                            <input type="password" name="password" id="password" placeholder=" " required>
                            <label for="password"><i class="bi bi-lock me-1"></i> Password</label>
                        </div>
                        <div class="form-floating">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                placeholder=" " required>
                            <label for="password_confirmation"><i class="bi bi-lock-fill me-1"></i> Konfirmasi</label>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit" id="btnSubmit">
                        <span>
                            Daftar Sekarang
                            <i class="bi bi-arrow-right"></i>
                        </span>
                    </button>
                </form>
            </div>

            <div class="register-footer">
                <p>Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></p>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('registerForm').addEventListener('submit', function () {
            document.getElementById('btnSubmit').classList.add('loading');
        });
    </script>
</body>

</html>