<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BULAVA - Archery Club Management System</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Custom Style -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    
    <style>
        .landing-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            text-align: center;
            padding: 2rem;
            position: relative;
            z-index: 10;
        }
        .logo-large {
            max-width: 220px;
            height: auto;
            margin-bottom: 2rem;
            filter: drop-shadow(0 10px 15px rgba(0, 0, 0, 0.05));
            animation: bounceIn 1s ease-out;
        }
        .landing-title {
            font-size: 3rem;
            font-weight: 800;
            color: #111827;
            letter-spacing: -0.5px;
            margin-bottom: 0.5rem;
        }
        .landing-title span {
            color: var(--primary-color);
        }
        .landing-tagline {
            font-size: 1.25rem;
            color: var(--text-muted);
            font-weight: 400;
            margin-bottom: 2.5rem;
            font-style: italic;
        }
        .btn-group-custom {
            display: flex;
            gap: 1rem;
            justify-content: center;
            animation: fadeInUp 0.8s ease-out;
        }
        @keyframes bounceIn {
            0% { transform: scale(0.3); opacity: 0; }
            50% { transform: scale(1.05); }
            70% { transform: scale(0.9); }
            100% { transform: scale(1); opacity: 1; }
        }
    </style>
</head>
<body class="watermark-bg">
    <div class="landing-container fade-in-up">
        <!-- Logo BULAVA -->
        <img src="{{ asset('images/logo.png') }}" alt="Logo BULAVA" class="logo-large">
        
        <!-- Judul -->
        <h1 class="landing-title">
            <span>BULAVA</span><br>
            Archery Club Management System
        </h1>
        
        <!-- Tagline -->
        <p class="landing-tagline">"Track Every Arrow, Celebrate Every Achievement"</p>
        
        <!-- Tombol -->
        <div class="btn-group-custom">
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg px-4 shadow">
                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-5 shadow">
                    <i class="bi bi-box-arrow-in-right me-2"></i>LOGIN
                </a>
                <a href="{{ route('register') }}" class="btn btn-secondary btn-lg px-5 shadow">
                    <i class="bi bi-person-plus me-2"></i>DAFTAR
                </a>
            @endauth
        </div>
    </div>

    <!-- Footer -->
    <footer class="position-absolute bottom-0 w-100 text-center py-3 text-muted" style="font-size: 0.875rem;">
        &copy; {{ date('Y') }} BULAVA Archery Club. All rights reserved.
    </footer>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
