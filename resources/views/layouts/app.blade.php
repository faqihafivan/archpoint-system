<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'BACMS') - BULAVA Archery Club</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- DataTables CSS (Bootstrap 5 theme) -->
    <link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    
    @yield('styles')
</head>
<body>
    @php
        $authUser = auth()->user();
        $profilePhoto = 'https://via.placeholder.com/150?text=Avatar';
        if ($authUser->role === 'atlet' && $authUser->athlete && $authUser->athlete->foto_profil) {
            $profilePhoto = asset('storage/' . $authUser->athlete->foto_profil);
        }
    @endphp

    <div class="app-wrapper">
        <!-- SIDEBAR DESKTOP -->
        <aside id="sidebar" class="d-none d-lg-flex">
            <div class="sidebar-brand">
                <img src="{{ asset('images/logo.png') }}" alt="Logo BULAVA">
                <span>BACMS</span>
            </div>
            
            <ul class="sidebar-menu">
                <!-- Dashboard (Admin & Athlete) -->
                <li class="{{ Route::is('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}">
                        <i class="bi bi-grid-1x2-fill"></i> Dashboard
                    </a>
                </li>
                
                @if ($authUser->role === 'admin')
                    <!-- Data Atlet (Admin Only) -->
                    <li class="{{ Route::is('athletes.*') ? 'active' : '' }}">
                        <a href="{{ route('athletes.index') }}">
                            <i class="bi bi-people-fill"></i> Data Atlet
                        </a>
                    </li>
                @else
                    <!-- Riwayat Pertandingan (Athlete Only) -->
                    <li class="{{ Route::is('results.index') ? 'active' : '' }}">
                        <a href="{{ route('results.index') }}">
                            <i class="bi bi-award-fill"></i> Riwayat Lomba
                        </a>
                    </li>
                @endif
                
                <!-- Leaderboard (Shared) -->
                <li class="{{ Route::is('leaderboard.index') ? 'active' : '' }}">
                    <a href="{{ route('leaderboard.index') }}">
                        <i class="bi bi-trophy-fill"></i> Leaderboard
                    </a>
                </li>
                
                <!-- Profil (Shared) -->
                <li class="{{ Route::is('profile.edit') ? 'active' : '' }}">
                    <a href="{{ route('profile.edit') }}">
                        <i class="bi bi-person-fill-gear"></i> Profil
                    </a>
                </li>
            </ul>

            <!-- Logout Bottom -->
            <div class="p-3 border-top border-secondary">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger w-100 py-2 border-0">
                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- OFFCANVAS SIDEBAR FOR MOBILE -->
        <div class="offcanvas offcanvas-start bg-dark text-white d-lg-none" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel" style="width: 280px;">
            <div class="offcanvas-header border-bottom border-secondary">
                <div class="d-flex align-items-center gap-2">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo BULAVA" style="height: 35px;">
                    <h5 class="offcanvas-title fw-bold text-white" id="mobileSidebarLabel">BULAVA BACMS</h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body p-0 d-flex flex-column">
                <ul class="sidebar-menu flex-grow-1">
                    <li class="{{ Route::is('dashboard') ? 'active' : '' }}">
                        <a href="{{ route('dashboard') }}">
                            <i class="bi bi-grid-1x2-fill"></i> Dashboard
                        </a>
                    </li>
                    
                    @if ($authUser->role === 'admin')
                        <li class="{{ Route::is('athletes.*') ? 'active' : '' }}">
                            <a href="{{ route('athletes.index') }}">
                                <i class="bi bi-people-fill"></i> Data Atlet
                            </a>
                        </li>
                    @else
                        <li class="{{ Route::is('results.index') ? 'active' : '' }}">
                            <a href="{{ route('results.index') }}">
                                <i class="bi bi-award-fill"></i> Riwayat Lomba
                            </a>
                        </li>
                    @endif
                    
                    <li class="{{ Route::is('leaderboard.index') ? 'active' : '' }}">
                        <a href="{{ route('leaderboard.index') }}">
                            <i class="bi bi-trophy-fill"></i> Leaderboard
                        </a>
                    </li>
                    
                    <li class="{{ Route::is('profile.edit') ? 'active' : '' }}">
                        <a href="{{ route('profile.edit') }}">
                            <i class="bi bi-person-fill-gear"></i> Profil
                        </a>
                    </li>
                </ul>

                <div class="p-3 border-top border-secondary">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger w-100 py-2 border-0">
                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- MAIN CONTENT AREA -->
        <div class="main-content">
            <!-- NAVBAR -->
            <header class="navbar-custom shadow-sm">
                <!-- Left: Hamburger toggle (mobile) & Brand Title -->
                <div class="d-flex align-items-center gap-3">
                    <button class="btn btn-light d-lg-none shadow-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar" aria-controls="mobileSidebar">
                        <i class="bi bi-list fs-4"></i>
                    </button>
                    <div class="d-flex align-items-center gap-2">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="d-none d-sm-block" style="height: 30px;">
                        <h5 class="mb-0 fw-bold d-none d-sm-block text-dark">BULAVA Archery Club</h5>
                    </div>
                </div>

                <!-- Right: Profile Dropdown -->
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center gap-2 text-decoration-none dropdown-toggle profile-dropdown text-dark" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ $profilePhoto }}" alt="{{ $authUser->name }}">
                        <div class="d-none d-md-block text-start">
                            <div class="fw-bold" style="font-size: 0.9rem; line-height: 1.2;">{{ $authUser->name }}</div>
                            <small class="text-muted" style="font-size: 0.75rem;">{{ ucfirst($authUser->role) }}</small>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4 mt-2" aria-labelledby="userMenu" style="min-width: 200px;">
                        <li class="px-3 py-2 border-bottom d-md-none">
                            <div class="fw-bold">{{ $authUser->name }}</div>
                            <small class="text-muted">{{ ucfirst($authUser->role) }}</small>
                        </li>
                        <li>
                            <a class="dropdown-menu-item dropdown-item py-2 px-3 rounded-2" href="{{ route('profile.edit') }}">
                                <i class="bi bi-person-fill me-2 text-muted"></i> Detail Profil
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item py-2 px-3 text-danger rounded-2">
                                    <i class="bi bi-box-arrow-right me-2"></i> Keluar
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </header>

            <!-- MAIN CONTENT SLOT -->
            <main class="p-4 flex-grow-1">
                {{ $slot }}
            </main>

            <!-- FOOTER -->
            <footer class="bg-white py-3 border-top text-center text-muted" style="font-size: 0.85rem;">
                &copy; {{ date('Y') }} BULAVA Archery Club Management System (BACMS). All rights reserved.
            </footer>
        </div>
    </div>

    <!-- JAVASCRIPT LIBS -->
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

    <!-- Global SweetAlert Toast notifications -->
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        @if(session('success'))
            Toast.fire({
                icon: 'success',
                title: '{{ session('success') }}'
            });
        @endif

        @if(session('error'))
            Toast.fire({
                icon: 'error',
                title: '{{ session('error') }}'
            });
        @endif
    </script>

    @yield('scripts')
</body>
</html>
