<x-guest-layout>
    <div class="col-md-6 col-lg-5 col-xl-4">
        <div class="auth-card">
            <!-- Logo -->
            <img src="{{ asset('images/logo.png') }}" alt="Logo BULAVA" class="auth-logo">
            
            <h4 class="text-center fw-bold mb-2 text-dark">Ubah Password</h4>
            <p class="text-center text-muted mb-4" style="font-size: 0.85rem;">Masukkan password baru Anda di bawah ini.</p>

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

            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold" style="font-size: 0.875rem;">Alamat Email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope text-muted"></i></span>
                        <input id="email" class="form-control border-start-0 bg-light" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username">
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold" style="font-size: 0.875rem;">Password Baru</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock text-muted"></i></span>
                        <input id="password" class="form-control border-start-0 bg-light" type="password" name="password" required placeholder="Minimal 8 karakter" autocomplete="new-password">
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="mb-4">
                    <label for="password_confirmation" class="form-label fw-semibold" style="font-size: 0.875rem;">Konfirmasi Password Baru</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock-fill text-muted"></i></span>
                        <input id="password_confirmation" class="form-control border-start-0 bg-light" type="password" name="password_confirmation" required placeholder="Ulangi password baru" autocomplete="new-password">
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary w-100 py-2.5 shadow">
                    Perbarui Password <i class="bi bi-shield-lock-fill ms-1" style="font-size: 0.85rem;"></i>
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
