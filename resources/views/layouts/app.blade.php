<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Peserta - Sistem Seminar</title>
    
    {{-- Stylesheets & Fonts --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    {{-- Font Plus Jakarta Sans (Sama seperti Admin) --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #f8f9fa; 
            color: #334155; 
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        .rounded-4 { border-radius: 1rem !important; }
        
        /* Sticky Footer */
        .main-content { flex: 1; }
    </style>
</head>
<body>

    {{-- Konten Utama --}}
    <main class="main-content">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="py-4 bg-white border-top mt-auto">
        <div class="container-fluid text-center">
            <p class="text-muted mb-0 small">
                &copy; {{ date('Y') }} Sistem Informasi Seminar - UNIKOM. All rights reserved.
            </p>
        </div>
    </footer>

    {{-- Scripts (Lengkap) --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('scripts')
</body>
</html>