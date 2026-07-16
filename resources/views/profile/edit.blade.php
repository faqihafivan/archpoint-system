<x-app-layout>
    @section('title', 'Profil Saya')

    <div class="row justify-content-center g-4">
        <!-- Section 1: Update Profile Details -->
        <div class="col-lg-7">
            <div class="card custom-card p-4 h-100">
                <h5 class="fw-bold mb-3 pb-2 border-bottom text-dark">
                    <i class="bi bi-person-fill-gear me-2 text-danger"></i>Detail Profil
                </h5>

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    @if ($user->role === 'atlet')
                        <!-- Profile Photo Picker -->
                        <div class="mb-4 text-center">
                            <div class="profile-upload-container mb-2">
                                <img id="preview-image" src="{{ $athlete->foto_profil ? asset('storage/' . $athlete->foto_profil) : 'https://via.placeholder.com/150?text=Avatar' }}" alt="Foto Profil" class="profile-upload-preview">
                                <label for="foto_profil" class="profile-upload-btn">
                                    <i class="bi bi-camera-fill"></i>
                                </label>
                            </div>
                            <input type="file" id="foto_profil" name="foto_profil" class="d-none" accept="image/*">
                            <small class="text-muted">Klik ikon kamera untuk mengubah foto profil (JPG/PNG, Max 2MB)</small>
                        </div>

                        <!-- Read-only Athlete ID & Full Name -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted" style="font-size: 0.85rem;">Nomor ID Atlet</label>
                                <input class="form-control bg-light border-0 fw-bold text-danger" type="text" value="{{ $athlete->nomor_id }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted" style="font-size: 0.85rem;">Nama Lengkap</label>
                                <input class="form-control bg-light border-0 fw-semibold" type="text" value="{{ $athlete->nama_lengkap }}" readonly>
                            </div>
                        </div>

                        <!-- Editable Phone & Email -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nomor_hp" class="form-label fw-semibold" style="font-size: 0.85rem;">Nomor HP (WhatsApp)</label>
                                <input id="nomor_hp" class="form-control bg-light @error('nomor_hp') is-invalid @enderror" type="text" name="nomor_hp" value="{{ old('nomor_hp', $athlete->nomor_hp) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold" style="font-size: 0.85rem;">Alamat Email</label>
                                <input id="email" class="form-control bg-light @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email', $user->email) }}" required>
                            </div>
                        </div>

                        <!-- Read-only Division, Category & Year -->
                        <div class="row mb-3">
                            <div class="col-4">
                                <label class="form-label fw-semibold text-muted" style="font-size: 0.85rem;">Divisi</label>
                                <input class="form-control bg-light border-0" type="text" value="{{ $athlete->divisi }}" readonly>
                            </div>
                            <div class="col-4">
                                <label class="form-label fw-semibold text-muted" style="font-size: 0.85rem;">Kategori</label>
                                <input class="form-control bg-light border-0" type="text" value="{{ $athlete->kategori }}" readonly>
                            </div>
                            <div class="col-4">
                                <label class="form-label fw-semibold text-muted" style="font-size: 0.85rem;">Tahun Bergabung</label>
                                <input class="form-control bg-light border-0" type="text" value="{{ $athlete->tahun_bergabung }}" readonly>
                            </div>
                        </div>

                        <!-- Read-only Birth Info & Address -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted" style="font-size: 0.85rem;">Tempat, Tanggal Lahir</label>
                                <input class="form-control bg-light border-0" type="text" value="{{ $athlete->tempat_lahir }}, {{ \Carbon\Carbon::parse($athlete->tanggal_lahir)->translatedFormat('d M Y') }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted" style="font-size: 0.85rem;">Username Akun</label>
                                <input class="form-control bg-light border-0" type="text" value="{{ $user->username }}" readonly>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted" style="font-size: 0.85rem;">Alamat Lengkap</label>
                            <textarea class="form-control bg-light border-0" rows="2" readonly>{{ $athlete->alamat }}</textarea>
                            <small class="text-muted">Data biodata lain hanya dapat diubah oleh Pelatih.</small>
                        </div>
                    @else
                        <!-- ADMIN PROFILE FIELDS -->
                        <!-- Nama Lengkap / Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold" style="font-size: 0.85rem;">Nama Lengkap</label>
                            <input id="name" class="form-control bg-light @error('name') is-invalid @enderror" type="text" name="name" value="{{ old('name', $user->name) }}" required>
                        </div>

                        <!-- Username -->
                        <div class="mb-3">
                            <label for="username" class="form-label fw-semibold" style="font-size: 0.85rem;">Username</label>
                            <input id="username" class="form-control bg-light @error('username') is-invalid @enderror" type="text" name="username" value="{{ old('username', $user->username) }}" required>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold" style="font-size: 0.85rem;">Alamat Email</label>
                            <input id="email" class="form-control bg-light @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email', $user->email) }}" required>
                        </div>
                    @endif

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary px-5 py-2 shadow">
                            Simpan Perubahan <i class="bi bi-save ms-1"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Section 2: Update Password -->
        <div class="col-lg-5">
            <div class="card custom-card p-4 h-100">
                <h5 class="fw-bold mb-3 pb-2 border-bottom text-dark">
                    <i class="bi bi-key-fill me-2 text-danger"></i>Ubah Password
                </h5>

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    @method('PUT')

                    <!-- Current Password -->
                    <div class="mb-3">
                        <label for="current_password" class="form-label fw-semibold" style="font-size: 0.85rem;">Password Saat Ini</label>
                        <input id="current_password" name="current_password" type="password" class="form-control bg-light @error('current_password', 'updatePassword') is-invalid @enderror" required placeholder="Masukkan password lama">
                        @error('current_password', 'updatePassword')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- New Password -->
                    <div class="mb-3">
                        <label for="update_password_password" class="form-label fw-semibold" style="font-size: 0.85rem;">Password Baru</label>
                        <input id="update_password_password" name="password" type="password" class="form-control bg-light @error('password', 'updatePassword') is-invalid @enderror" required placeholder="Minimal 8 karakter">
                        @error('password', 'updatePassword')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-4">
                        <label for="update_password_password_confirmation" class="form-label fw-semibold" style="font-size: 0.85rem;">Konfirmasi Password Baru</label>
                        <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control bg-light" required placeholder="Ulangi password baru">
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary w-100 py-2 shadow">
                            Perbarui Password <i class="bi bi-shield-lock ms-1"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            // Photo upload preview (for Athlete role)
            const fileInput = document.getElementById('foto_profil');
            if (fileInput) {
                fileInput.addEventListener('change', function(event) {
                    const reader = new FileReader();
                    reader.onload = function() {
                        const output = document.getElementById('preview-image');
                        output.src = reader.result;
                    };
                    if (event.target.files[0]) {
                        reader.readAsDataURL(event.target.files[0]);
                    }
                });
            }

            // Handle password change session feedback using SweetAlert
            @if (session('status') === 'password-updated')
                Toast.fire({
                    icon: 'success',
                    title: 'Password berhasil diubah!'
                });
            @endif
        </script>
    @endsection
</x-app-layout>
