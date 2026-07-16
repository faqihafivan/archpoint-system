<x-guest-layout>
    <div class="col-md-6 col-lg-5 col-xl-4">
        <div class="auth-card">
            <!-- Logo -->
            <img src="{{ asset('images/logo.png') }}" alt="Logo BULAVA" class="auth-logo">
            
            <h3 class="text-center fw-bold mb-1 text-dark">Masuk BACMS</h3>
            <p class="text-center text-muted mb-4" style="font-size: 0.9rem;">Kelola data atlet & pantau setiap anak panah</p>
            
            <!-- Session Status Alert -->
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- General Error Alert -->
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold" style="font-size: 0.9rem;">Alamat Email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope text-muted"></i></span>
                        <input id="email" class="form-control border-start-0 bg-light @error('email') is-invalid @enderror" type="email" name="email" :value="old('email')" required autofocus placeholder="nama@email.com">
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label for="password" class="form-label fw-semibold mb-0" style="font-size: 0.9rem;">Password</label>
                        @if (Route::has('password.request'))
                            <a class="text-decoration-none text-muted" href="{{ route('password.request') }}" style="font-size: 0.8rem;">
                                Lupa Password?
                            </a>
                        @endif
                    </div>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock text-muted"></i></span>
                        <input id="password" class="form-control border-start-0 bg-light @error('password') is-invalid @enderror" type="password" name="password" required placeholder="••••••••">
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="mb-4 form-check">
                    <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                    <label for="remember_me" class="form-check-label text-muted" style="font-size: 0.85rem;">Ingat Saya</label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary w-100 py-2.5 mb-3 shadow">
                    Masuk ke Dashboard <i class="bi bi-arrow-right ms-1"></i>
                </button>

                <!-- Register Link -->
                <div class="text-center mt-3">
                    <p class="text-muted mb-0" style="font-size: 0.9rem;">
                        Belum punya akun? <a href="{{ route('register') }}" class="text-decoration-none fw-bold" style="color: var(--primary-color);">Daftar Sekarang</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
