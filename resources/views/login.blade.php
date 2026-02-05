<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Peserta - SeminarApp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f0f4f8; font-family: 'sans-serif'; }
        .login-card { border-radius: 15px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
        .btn-login { background-color: #0d6efd; border-radius: 10px; padding: 12px; font-weight: bold; }
    </style>
</head>
<body class="d-flex align-items-center vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card login-card p-4">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold text-primary">SeminarApp</h3>
                        <p class="text-muted">Login Peserta</p>
                    </div>

                    {{-- Pesan Error --}}
                    @if(session('error'))
                        <div class="alert alert-danger py-2 small">{{ session('error') }}</div>
                    @endif

                    {{-- Pesan Sukses setelah Registrasi --}}
                    @if(session('success'))
                        <div class="alert alert-success py-2 small">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('login.post') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold">NIM Peserta</label>
                            <input type="text" name="nim" class="form-control" placeholder="Contoh: 10123010" required>
                        </div>
                        
                        {{-- Perubahan dari Nama menjadi Password --}}
                        <div class="mb-4">
                            <label class="form-label small fw-bold">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Masukkan password Anda" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 btn-login">Masuk ke Portal</button>
                    </form>
                    
                    <div class="text-center mt-4">
                        <p class="small text-muted mb-1">Belum punya akun? 
                            <a href="{{ route('register') }}" class="text-primary fw-bold text-decoration-none">Daftar Sekarang</a>
                        </p>
                        <small class="text-muted">Universitas Komputer Indonesia</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>