<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - SeminarApp</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --indigo-primary: #8b5cf6;
            --indigo-hover: #7c3aed;
            --indigo-light: #f5f3ff;
        }

        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #f8f9fa; 
        }

        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-card { 
            width: 100%; 
            max-width: 420px; 
            border: none; 
            border-radius: 28px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.03); 
        }

        .icon-shield { 
            width: 72px; 
            height: 72px; 
            background: var(--indigo-light); 
            color: var(--indigo-primary); 
            border-radius: 22px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            margin: 0 auto 24px; 
            font-size: 2.2rem; 
        }

        .btn-admin { 
            background-color: var(--indigo-primary); 
            border: none; 
            padding: 14px; 
            border-radius: 14px; 
            font-weight: 700; 
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); 
        }

        .btn-admin:hover { 
            background-color: var(--indigo-hover); 
            transform: translateY(-3px); 
            box-shadow: 0 8px 20px rgba(139, 92, 246, 0.25);
        }

        /* Elemen Tambahan untuk kemiripan 100% */
        .demo-mode { 
            background-color: var(--indigo-light); 
            border: 1px dashed #ddd6fe;
            color: #6d28d9; 
            border-radius: 18px; 
            font-size: 0.85rem; 
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="card login-card p-4">
        <div class="card-body">
            <div class="icon-shield shadow-sm">
                <i class="bi bi-shield-lock-fill"></i>
            </div>

            <div class="text-center mb-4">
                <h3 class="fw-bold mb-1">Login Admin</h3>
                <p class="text-muted small">Masuk ke panel administrator</p>
            </div>

            @if(session('error'))
                <div class="alert alert-danger border-0 small rounded-4 mb-4 text-center">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('admin.login') }}" method="POST">
                @csrf {{-- FIX untuk error 419 --}}
                <div class="mb-3">
                    <label class="form-label small fw-bold text-secondary">Username</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 text-muted">
                            <i class="bi bi-person"></i>
                        </span>
                        <input type="text" name="username" class="form-control border-start-0 ps-1" placeholder="Masukkan username" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-bold text-secondary">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 text-muted">
                            <i class="bi bi-lock"></i>
                        </span>
                        <input type="password" name="password" class="form-control border-start-0 ps-1" placeholder="Masukkan password" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-admin w-100 mb-4 text-white shadow-sm">
                    <i class="bi bi-shield-fill-check me-2"></i> Login sebagai Admin
                </button>
            </form>
        </div>
    </div>
</div>

</body>
</html>