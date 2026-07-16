<x-app-layout>
    @section('title', 'Edit Atlet')

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card custom-card p-4">
                <!-- Header -->
                <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom">
                    <div>
                        <h4 class="fw-bold text-dark mb-1"><i class="bi bi-pencil-square me-2 text-danger"></i>Edit Biodata Atlet</h4>
                        <p class="text-muted mb-0" style="font-size: 0.9rem;">Perbarui informasi akun dan biodata atlet <strong>{{ $athlete->nama_lengkap }}</strong></p>
                    </div>
                    <a href="{{ route('athletes.index') }}" class="btn btn-light border px-3 py-2 rounded-3 text-muted">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
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

                <form method="POST" action="{{ route('athletes.update', $athlete->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        <!-- Column 1: Account Info -->
                        <div class="col-md-5 border-end-md">
                            <h5 class="fw-bold mb-3 pb-2 border-bottom text-dark">
                                <i class="bi bi-person-badge-fill me-2 text-primary"></i>Informasi Akun
                            </h5>
                            
                            <!-- Nomor ID (Read-only) -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-muted" style="font-size: 0.85rem;">Nomor ID Atlet</label>
                                <input class="form-control bg-light border-0 fw-bold text-danger" type="text" value="{{ $athlete->nomor_id }}" readonly>
                                <small class="text-muted">Nomor ID atlet digenerate otomatis oleh sistem.</small>
                            </div>

                            <!-- Username -->
                            <div class="mb-3">
                                <label for="username" class="form-label fw-semibold" style="font-size: 0.85rem;">Username</label>
                                <input id="username" class="form-control bg-light @error('username') is-invalid @enderror" type="text" name="username" value="{{ old('username', $athlete->user->username) }}" required>
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold" style="font-size: 0.85rem;">Email</label>
                                <input id="email" class="form-control bg-light @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email', $athlete->user->email) }}" required>
                            </div>

                            <!-- Reset Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold" style="font-size: 0.85rem;">Reset Password (Opsional)</label>
                                <input id="password" class="form-control bg-light @error('password') is-invalid @enderror" type="password" name="password" placeholder="Isi untuk ganti password">
                                <small class="text-muted" style="font-size: 0.75rem;">Biarkan kosong jika atlet tidak ingin mengubah password.</small>
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
                                    <img id="preview-image" src="{{ $athlete->foto_profil ? asset('storage/' . $athlete->foto_profil) : 'https://via.placeholder.com/150?text=Avatar' }}" alt="Foto Profil" class="profile-upload-preview">
                                    <label for="foto_profil" class="profile-upload-btn">
                                        <i class="bi bi-camera-fill"></i>
                                    </label>
                                </div>
                                <input type="file" id="foto_profil" name="foto_profil" class="d-none" accept="image/*">
                                <small class="text-muted">Klik ikon kamera untuk mengubah foto profil (JPG/PNG, Max 2MB)</small>
                            </div>

                            <!-- Full Name -->
                            <div class="mb-3">
                                <label for="nama_lengkap" class="form-label fw-semibold" style="font-size: 0.85rem;">Nama Lengkap</label>
                                <input id="nama_lengkap" class="form-control bg-light @error('nama_lengkap') is-invalid @enderror" type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $athlete->nama_lengkap) }}" required>
                            </div>

                            <!-- Birth Place & Date -->
                            <div class="row mb-3">
                                <div class="col-6">
                                    <label for="tempat_lahir" class="form-label fw-semibold" style="font-size: 0.85rem;">Tempat Lahir</label>
                                    <input id="tempat_lahir" class="form-control bg-light @error('tempat_lahir') is-invalid @enderror" type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $athlete->tempat_lahir) }}" required>
                                </div>
                                <div class="col-6">
                                    <label for="tanggal_lahir" class="form-label fw-semibold" style="font-size: 0.85rem;">Tanggal Lahir</label>
                                    <input id="tanggal_lahir" class="form-control bg-light @error('tanggal_lahir') is-invalid @enderror" type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $athlete->tanggal_lahir) }}" required>
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="mb-3">
                                <label for="alamat" class="form-label fw-semibold" style="font-size: 0.85rem;">Alamat Lengkap</label>
                                <textarea id="alamat" class="form-control bg-light @error('alamat') is-invalid @enderror" name="alamat" rows="2" required>{{ old('alamat', $athlete->alamat) }}</textarea>
                            </div>

                            <!-- Phone & Join Year -->
                            <div class="row mb-3">
                                <div class="col-6">
                                    <label for="nomor_hp" class="form-label fw-semibold" style="font-size: 0.85rem;">Nomor HP (WhatsApp)</label>
                                    <input id="nomor_hp" class="form-control bg-light @error('nomor_hp') is-invalid @enderror" type="text" name="nomor_hp" value="{{ old('nomor_hp', $athlete->nomor_hp) }}" required>
                                </div>
                                <div class="col-6">
                                    <label for="tahun_bergabung" class="form-label fw-semibold" style="font-size: 0.85rem;">Tahun Bergabung</label>
                                    <input id="tahun_bergabung" class="form-control bg-light @error('tahun_bergabung') is-invalid @enderror" type="number" name="tahun_bergabung" value="{{ old('tahun_bergabung', $athlete->tahun_bergabung) }}" required min="2000" max="{{ date('Y') }}">
                                </div>
                            </div>

                            <!-- Division & Category -->
                            <div class="row mb-4">
                                <div class="col-6">
                                    <label for="divisi" class="form-label fw-semibold" style="font-size: 0.85rem;">Divisi</label>
                                    <select id="divisi" class="form-select bg-light @error('divisi') is-invalid @enderror" name="divisi" required>
                                        <option value="Recurve" {{ old('divisi', $athlete->divisi) == 'Recurve' ? 'selected' : '' }}>Recurve</option>
                                        <option value="Compound" {{ old('divisi', $athlete->divisi) == 'Compound' ? 'selected' : '' }}>Compound</option>
                                        <option value="Standard Bow" {{ old('divisi', $athlete->divisi) == 'Standard Bow' ? 'selected' : '' }}>Standard Bow</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label for="kategori" class="form-label fw-semibold" style="font-size: 0.85rem;">Kategori</label>
                                    <select id="kategori" class="form-select bg-light @error('kategori') is-invalid @enderror" name="kategori" required>
                                        <option value="U-5" {{ old('kategori', $athlete->kategori) == 'U-5' ? 'selected' : '' }}>U-5</option>
                                        <option value="U-10" {{ old('kategori', $athlete->kategori) == 'U-10' ? 'selected' : '' }}>U-10</option>
                                        <option value="U-15" {{ old('kategori', $athlete->kategori) == 'U-15' ? 'selected' : '' }}>U-15</option>
                                        <option value="U-18" {{ old('kategori', $athlete->kategori) == 'U-18' ? 'selected' : '' }}>U-18</option>
                                        <option value="U-20" {{ old('kategori', $athlete->kategori) == 'U-20' ? 'selected' : '' }}>U-20</option>
                                        <option value="Senior" {{ old('kategori', $athlete->kategori) == 'Senior' ? 'selected' : '' }}>Senior</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit and Back -->
                    <div class="d-flex justify-content-end gap-2 mt-3 pt-3 border-top">
                        <a href="{{ route('athletes.index') }}" class="btn btn-light px-4 py-2 border">Batal</a>
                        <button type="submit" class="btn btn-primary px-5 py-2 shadow">
                            Simpan Perubahan <i class="bi bi-save ms-1"></i>
                        </button>
                    </div>
                </form>
            </div>
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
        const initialKategori = '{{ old('kategori', $athlete->kategori) }}';
        if (initialDivisi) {
            updateCategories(initialDivisi, initialKategori);
        } else {
            updateCategories('');
        }
    </script>
</x-app-layout>
