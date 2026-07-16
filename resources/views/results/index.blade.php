<x-app-layout>
    @section('title', 'Riwayat Pertandingan')

    <div class="card custom-card p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <div>
                <h4 class="fw-bold text-dark mb-1"><i class="bi bi-award-fill me-2 text-danger"></i>Riwayat Pertandingan</h4>
                <p class="text-muted mb-0" style="font-size: 0.9rem;">Daftar seluruh kejuaraan dan kompetisi yang telah Anda ikuti</p>
            </div>
            <!-- Trigger button for Modal -->
            <button type="button" class="btn btn-primary shadow px-4 py-2.5" data-bs-toggle="modal" data-bs-target="#addResultModal">
                <i class="bi bi-plus-circle me-2"></i> Tambah Hasil Pertandingan
            </button>
        </div>

        <div class="table-responsive">
            <table id="resultsTable" class="table table-hover align-middle" style="width: 100%;">
                <thead>
                    <tr class="text-muted" style="font-size: 0.875rem;">
                        <th>Tanggal</th>
                        <th>Event / Lomba</th>
                        <th>Lokasi</th>
                        <th class="text-center">Score</th>
                        <th class="text-end" style="padding-right: 20px;">Hasil Pertandingan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($results as $res)
                        <tr>
                            <td>
                                <div class="fw-bold text-dark">{{ \Carbon\Carbon::parse($res->tanggal)->translatedFormat('d F Y') }}</div>
                            </td>
                            <td>
                                <span class="fw-bold text-dark" style="font-size: 0.95rem;">{{ $res->event_name }}</span>
                            </td>
                            <td>
                                <span class="text-muted"><i class="bi bi-geo-alt-fill me-1"></i> {{ $res->lokasi }}</span>
                            </td>
                            <td class="text-center fw-extrabold text-danger fs-5">{{ $res->score }}</td>
                            <td class="text-end" style="padding-right: 20px;">
                                @if($res->hasil_pertandingan === 'Juara 1')
                                    <span class="badge bg-warning text-dark px-3 py-2 border border-warning" style="font-size: 0.8rem; font-weight: 600;">
                                        <i class="bi bi-trophy-fill me-1"></i> Juara 1 (Emas)
                                    </span>
                                @elseif($res->hasil_pertandingan === 'Juara 2')
                                    <span class="badge bg-light text-secondary px-3 py-2 border" style="font-size: 0.8rem; font-weight: 600;">
                                        <i class="bi bi-trophy-fill me-1"></i> Juara 2 (Perak)
                                    </span>
                                @elseif($res->hasil_pertandingan === 'Juara 3')
                                    <span class="badge px-3 py-2 border" style="font-size: 0.8rem; font-weight: 600; background-color: #fce8e6; color: #a94442;">
                                        <i class="bi bi-trophy-fill me-1"></i> Juara 3 (Perunggu)
                                    </span>
                                @else
                                    <span class="badge bg-light text-muted px-3 py-2 border" style="font-size: 0.8rem; font-weight: 500;">
                                        Tidak Juara
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- BOOTSTRAP MODAL FOR ADDING RESULT -->
    <div class="modal fade" id="addResultModal" tabindex="-1" aria-labelledby="addResultModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header border-bottom p-3">
                    <h5 class="modal-title fw-bold text-dark" id="addResultModalLabel">
                        <i class="bi bi-trophy me-2 text-danger"></i> Catat Hasil Pertandingan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <form action="{{ route('results.store') }}" method="POST">
                    @csrf
                    
                    <div class="modal-body p-3">
                        <!-- Event Name -->
                        <div class="mb-3">
                            <label for="event_name" class="form-label fw-semibold" style="font-size: 0.9rem;">Nama Event / Lomba</label>
                            <input type="text" class="form-control bg-light @error('event_name') is-invalid @enderror" id="event_name" name="event_name" required placeholder="Contoh: Kejuaraan Bandung Open 2026" value="{{ old('event_name') }}">
                        </div>

                        <!-- Location -->
                        <div class="mb-3">
                            <label for="lokasi" class="form-label fw-semibold" style="font-size: 0.9rem;">Lokasi</label>
                            <input type="text" class="form-control bg-light @error('lokasi') is-invalid @enderror" id="lokasi" name="lokasi" required placeholder="Contoh: GOR Pajajaran, Bandung" value="{{ old('lokasi') }}">
                        </div>

                        <div class="row mb-3">
                            <!-- Date -->
                            <div class="col-6">
                                <label for="tanggal" class="form-label fw-semibold" style="font-size: 0.9rem;">Tanggal</label>
                                <input type="date" class="form-control bg-light @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" required value="{{ old('tanggal', date('Y-m-d')) }}">
                            </div>
                            <!-- Score -->
                            <div class="col-6">
                                <label for="score" class="form-label fw-semibold" style="font-size: 0.9rem;">Score</label>
                                <input type="number" class="form-control bg-light @error('score') is-invalid @enderror" id="score" name="score" required min="0" max="1000" placeholder="Skor Anda" value="{{ old('score') }}">
                            </div>
                        </div>

                        <!-- Hasil Pertandingan -->
                        <div class="mb-2">
                            <label for="hasil_pertandingan" class="form-label fw-semibold" style="font-size: 0.9rem;">Hasil Pertandingan</label>
                            <select class="form-select bg-light @error('hasil_pertandingan') is-invalid @enderror" id="hasil_pertandingan" name="hasil_pertandingan" required>
                                <option value="" disabled selected>Pilih Hasil</option>
                                <option value="Tidak Juara" {{ old('hasil_pertandingan') == 'Tidak Juara' ? 'selected' : '' }}>Tidak Juara</option>
                                <option value="Juara 1" {{ old('hasil_pertandingan') == 'Juara 1' ? 'selected' : '' }}>Juara 1 (Emas)</option>
                                <option value="Juara 2" {{ old('hasil_pertandingan') == 'Juara 2' ? 'selected' : '' }}>Juara 2 (Perak)</option>
                                <option value="Juara 3" {{ old('hasil_pertandingan') == 'Juara 3' ? 'selected' : '' }}>Juara 3 (Perunggu)</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="modal-footer border-top p-3 d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-light px-4 py-2 border" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary px-5 py-2 shadow">
                            Simpan Hasil <i class="bi bi-save ms-1"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            $(document).ready(function() {
                // Initialize DataTable
                $('#resultsTable').DataTable({
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
                    },
                    responsive: true,
                    pageLength: 10,
                    order: [[0, 'desc']] // Order by Date descending
                });

                // Show modal automatically if validation errors occurred
                @if($errors->any())
                    var myModal = new bootstrap.Modal(document.getElementById('addResultModal'));
                    myModal.show();
                @endif
            });
        </script>
    @endsection
</x-app-layout>
