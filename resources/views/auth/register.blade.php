<x-guest-layout>
    <div class="col-md-10 col-lg-8">
        <div class="auth-card">
            <!-- Header -->
            <div class="text-center mb-4">
                <img src="{{ asset('images/logo.png') }}" alt="Logo BULAVA" class="auth-logo mb-2">
                <h3 class="fw-bold text-dark">Registrasi Atlet Baru</h3>
                <p class="text-muted" style="font-size: 0.9rem;">Gabung bersama BULAVA Archery Club dan catat prestasi Anda</p>
            </div>

            <!-- Errors Alert -->
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

            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                @csrf

                <div class="row g-4">
                    <!-- Column 1: Account Info -->
                    <div class="col-md-5 border-end-md">
                        <h5 class="fw-bold mb-3 pb-2 border-bottom text-dark">
                            <i class="bi bi-person-badge-fill me-2 text-primary"></i>Informasi Akun
                        </h5>
                        
                        <!-- Username -->
                        <div class="mb-3">
                            <label for="username" class="form-label fw-semibold" style="font-size: 0.85rem;">Username</label>
                            <input id="username" class="form-control bg-light @error('username') is-invalid @enderror" type="text" name="username" value="{{ old('username') }}" required placeholder="Contoh: rian12">
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold" style="font-size: 0.85rem;">Email</label>
                            <input id="email" class="form-control bg-light @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" required placeholder="Contoh: rian@email.com">
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold" style="font-size: 0.85rem;">Password</label>
                            <input id="password" class="form-control bg-light @error('password') is-invalid @enderror" type="password" name="password" required placeholder="Minimal 8 karakter">
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label fw-semibold" style="font-size: 0.85rem;">Konfirmasi Password</label>
                            <input id="password_confirmation" class="form-control bg-light" type="password" name="password_confirmation" required placeholder="Ulangi password">
                        </div>
                    </div>

                    <!-- Column 2: Athlete Biodata -->
                    <div class="col-md-7">
                        <h5 class="fw-bold mb-3 pb-2 border-bottom text-dark">
                            <i class="bi bi-journal-text me-2 text-primary"></i>Biodata Atlet
                        </h5>

                        <!-- Profile Photo Picker -->
                        <div class="mb-3 text-center">
                            <div class="profile-upload-container mb-2">
                                <img id="preview-image" src="https://via.placeholder.com/150?text=Avatar" alt="Foto Profil" class="profile-upload-preview">
                                <label for="foto_profil" class="profile-upload-btn">
                                    <i class="bi bi-camera-fill"></i>
                                </label>
                            </div>
                            <input type="file" id="foto_profil" name="foto_profil" class="d-none" accept="image/*">
                            <small class="text-muted">Klik ikon kamera untuk mengunggah foto profil (JPG/PNG, Max 2MB)</small>
                        </div>

                        <!-- Full Name -->
                        <div class="mb-3">
                            <label for="nama_lengkap" class="form-label fw-semibold" style="font-size: 0.85rem;">Nama Lengkap</label>
                            <input id="nama_lengkap" class="form-control bg-light @error('nama_lengkap') is-invalid @enderror" type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required placeholder="Contoh: Rian Adi Wijaya">
                        </div>

                        <!-- Birth Place & Date -->
                        <div class="row mb-3">
                            <div class="col-6">
                                <label for="tempat_lahir" class="form-label fw-semibold" style="font-size: 0.85rem;">Tempat Lahir</label>
                                <input id="tempat_lahir" class="form-control bg-light @error('tempat_lahir') is-invalid @enderror" type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required placeholder="Contoh: Bandung">
                            </div>
                            <div class="col-6">
                                <label for="tanggal_lahir" class="form-label fw-semibold" style="font-size: 0.85rem;">Tanggal Lahir</label>
                                <input id="tanggal_lahir" class="form-control bg-light @error('tanggal_lahir') is-invalid @enderror" type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="mb-3">
                            <label for="alamat" class="form-label fw-semibold" style="font-size: 0.85rem;">Alamat Lengkap</label>
                            <textarea id="alamat" class="form-control bg-light @error('alamat') is-invalid @enderror" name="alamat" rows="2" required placeholder="Contoh: Jalan Kenari No. 5, Arcamanik, Bandung">{{ old('alamat') }}</textarea>
                        </div>

                        <!-- Phone & Join Year -->
                        <div class="row mb-3">
                            <div class="col-6">
                                <label for="nomor_hp" class="form-label fw-semibold" style="font-size: 0.85rem;">Nomor HP (WhatsApp)</label>
                                <input id="nomor_hp" class="form-control bg-light @error('nomor_hp') is-invalid @enderror" type="text" name="nomor_hp" value="{{ old('nomor_hp') }}" required placeholder="Contoh: 08123456789">
                            </div>
                            <div class="col-6">
                                <label for="tahun_bergabung" class="form-label fw-semibold" style="font-size: 0.85rem;">Tahun Bergabung</label>
                                <input id="tahun_bergabung" class="form-control bg-light @error('tahun_bergabung') is-invalid @enderror" type="number" name="tahun_bergabung" value="{{ old('tahun_bergabung', date('Y')) }}" required min="2000" max="{{ date('Y') }}">
                            </div>
                        </div>

                        <!-- Division & Category -->
                        <div class="row mb-4">
                            <div class="col-6">
                                <label for="divisi" class="form-label fw-semibold" style="font-size: 0.85rem;">Divisi</label>
                                <select id="divisi" class="form-select bg-light @error('divisi') is-invalid @enderror" name="divisi" required>
                                    <option value="" disabled selected>Pilih Divisi</option>
                                    <option value="Recurve" {{ old('divisi') == 'Recurve' ? 'selected' : '' }}>Recurve</option>
                                    <option value="Compound" {{ old('divisi') == 'Compound' ? 'selected' : '' }}>Compound</option>
                                    <option value="Standard Bow" {{ old('divisi') == 'Standard Bow' ? 'selected' : '' }}>Standard Bow</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="kategori" class="form-label fw-semibold" style="font-size: 0.85rem;">Kategori</label>
                                <select id="kategori" class="form-select bg-light @error('kategori') is-invalid @enderror" name="kategori" required>
                                    <option value="" disabled selected>Pilih Kategori</option>
                                    <option value="U-5" {{ old('kategori') == 'U-5' ? 'selected' : '' }}>U-5</option>
                                    <option value="U-10" {{ old('kategori') == 'U-10' ? 'selected' : '' }}>U-10</option>
                                    <option value="U-15" {{ old('kategori') == 'U-15' ? 'selected' : '' }}>U-15</option>
                                    <option value="U-18" {{ old('kategori') == 'U-18' ? 'selected' : '' }}>U-18</option>
                                    <option value="U-20" {{ old('kategori') == 'U-20' ? 'selected' : '' }}>U-20</option>
                                    <option value="Senior" {{ old('kategori') == 'Senior' ? 'selected' : '' }}>Senior</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit and Back -->
                <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                    <a href="{{ route('login') }}" class="text-decoration-none text-muted" style="font-size: 0.9rem;">
                        Sudah punya akun? Masuk
                    </a>
                    <button type="submit" class="btn btn-primary px-5 py-2 shadow">
                        Daftar Sekarang <i class="bi bi-check2-circle ms-1"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Image Preview and Dynamic Category Script -->
    <script>
        document.getElementById('foto_profil').addEventListener('change', function(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('preview-image');
                output.src = reader.result;
            };
            if (event.target.files[0]) {
                reader.readAsDataURL(event.target.files[0]);
            }
        });

        // Dynamic Division & Category
        const divisiSelect = document.getElementById('divisi');
        const kategoriSelect = document.getElementById('kategori');

        const standardBowCategories = [
            { value: 'U-5', text: 'U-5' },
            { value: 'U-10', text: 'U-10' },
            { value: 'U-15', text: 'U-15' },
            { value: 'U-18', text: 'U-18' },
            { value: 'U-20', text: 'U-20' },
            { value: 'Senior', text: 'Senior' }
        ];

        const generalCategories = [
            { value: 'Umum', text: 'Umum' }
        ];

        function updateCategories(selectedDivisi, selectedKategori = '') {
            kategoriSelect.innerHTML = '';
            
            let categories = [];
            if (selectedDivisi === 'Standard Bow') {
                categories = standardBowCategories;
                const placeholder = document.createElement('option');
                placeholder.value = '';
                placeholder.text = 'Pilih Kategori';
                placeholder.disabled = true;
                placeholder.selected = !selectedKategori;
                kategoriSelect.appendChild(placeholder);
            } else if (selectedDivisi === 'Recurve' || selectedDivisi === 'Compound') {
                categories = generalCategories;
            } else {
                const placeholder = document.createElement('option');
                placeholder.value = '';
                placeholder.text = 'Pilih Divisi Terlebih Dahulu';
                placeholder.disabled = true;
                placeholder.selected = true;
                kategoriSelect.appendChild(placeholder);
                return;
            }
            
            categories.forEach(cat => {
                const opt = document.createElement('option');
                opt.value = cat.value;
                opt.text = cat.text;
                if (cat.value === selectedKategori || (categories.length === 1 && cat.value === 'Umum')) {
                    opt.selected = true;
                }
                kategoriSelect.appendChild(opt);
            });
        }

        divisiSelect.addEventListener('change', function() {
            updateCategories(this.value);
        });

        // Run initial configuration
        const initialDivisi = divisiSelect.value;
        const initialKategori = '{{ old('kategori') }}';
        if (initialDivisi) {
            updateCategories(initialDivisi, initialKategori);
        } else {
            updateCategories('');
        }
    </script>
</x-guest-layout>
