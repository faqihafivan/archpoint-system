<x-guest-layout>
    <div class="col-md-6 col-lg-5 col-xl-4">
        <div class="auth-card">
            <!-- Logo -->
            <img src="{{ asset('images/logo.png') }}" alt="Logo BULAVA" class="auth-logo">
            
            <h4 class="text-center fw-bold mb-2 text-dark">Lupa Password</h4>
            <p class="text-center text-muted mb-4" style="font-size: 0.85rem; line-height: 1.4;">
                Masukkan email Anda, dan kami akan mengirimkan link reset password untuk membuat password baru.
            </p>

            <!-- Session Status Alert -->
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="font-size: 0.85rem;">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Errors Alert -->
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="font-size: 0.85rem;">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-4">
                    <label for="email" class="form-label fw-semibold" style="font-size: 0.875rem;">Alamat Email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope text-muted"></i></span>
                        <input id="email" class="form-control border-start-0 bg-light" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="nama@email.com">
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary w-100 py-2.5 mb-3 shadow">
                    Kirim Link Reset <i class="bi bi-send-fill ms-1" style="font-size: 0.85rem;"></i>
                </button>

                <!-- Back to Login Link -->
                <div class="text-center mt-2">
                    <a href="{{ route('login') }}" class="text-decoration-none text-muted fw-semibold" style="font-size: 0.875rem;">
                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Login
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
