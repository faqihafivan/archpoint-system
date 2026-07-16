<x-app-layout>
    @section('title', 'Leaderboard')

    <div class="card custom-card p-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <div>
                <h4 class="fw-bold text-dark mb-1"><i class="bi bi-trophy-fill me-2 text-warning"></i>Leaderboard Klub</h4>
                <p class="text-muted mb-0" style="font-size: 0.9rem;">Peringkat atlet berdasarkan Best Score tertinggi di semua event</p>
            </div>
        </div>

        <!-- Filter Tabs / Pills -->
        <div class="mb-4">
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('leaderboard.index') }}" class="btn btn-sm px-4 py-2 rounded-3 fw-semibold {{ is_null($divisi) ? 'btn-primary' : 'btn-light border text-muted' }}">
                    Semua Divisi
                </a>
                <a href="{{ route('leaderboard.index', ['divisi' => 'Recurve']) }}" class="btn btn-sm px-4 py-2 rounded-3 fw-semibold {{ $divisi === 'Recurve' ? 'btn-primary' : 'btn-light border text-muted' }}">
                    Recurve
                </a>
                <a href="{{ route('leaderboard.index', ['divisi' => 'Compound']) }}" class="btn btn-sm px-4 py-2 rounded-3 fw-semibold {{ $divisi === 'Compound' ? 'btn-primary' : 'btn-light border text-muted' }}">
                    Compound
                </a>
                <a href="{{ route('leaderboard.index', ['divisi' => 'Standard Bow']) }}" class="btn btn-sm px-4 py-2 rounded-3 fw-semibold {{ $divisi === 'Standard Bow' ? 'btn-primary' : 'btn-light border text-muted' }}">
                    Standard Bow
                </a>
            </div>
        </div>

        <!-- Leaderboard Table -->
        <div class="table-responsive">
            <table id="leaderboardTable" class="table table-hover leaderboard-table align-middle" style="width: 100%;">
                <thead>
                    <tr class="text-muted" style="font-size: 0.875rem;">
                        <th style="width: 80px;">Ranking</th>
                        <th>Foto</th>
                        <th>Nama Atlet</th>
                        <th>ID Atlet</th>
                        <th>Divisi</th>
                        <th>Kategori</th>
                        <th class="text-end" style="padding-right: 30px;">Best Score</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($athletes as $index => $athlete)
                        <tr>
                            <td>
                                @if($index + 1 === 1)
                                    <i class="bi bi-award-fill fs-3 text-warning" title="Juara 1 (Emas)" style="filter: drop-shadow(0 2px 4px rgba(245, 158, 11, 0.3));"></i>
                                @elseif($index + 1 === 2)
                                    <i class="bi bi-award-fill fs-3 text-secondary" title="Juara 2 (Perak)" style="filter: drop-shadow(0 2px 4px rgba(148, 163, 184, 0.3));"></i>
                                @elseif($index + 1 === 3)
                                    <i class="bi bi-award-fill fs-3 text-danger" title="Juara 3 (Perunggu)" style="filter: drop-shadow(0 2px 4px rgba(180, 83, 9, 0.3)); color: #B45309 !important;"></i>
                                @else
                                    <span class="rank-badge rank-other fs-6">
                                        {{ $index + 1 }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <img src="{{ $athlete->foto_profil ? asset('storage/' . $athlete->foto_profil) : 'https://via.placeholder.com/150?text=Avatar' }}" alt="{{ $athlete->nama_lengkap }}" class="rounded-circle border" style="width: 45px; height: 45px; object-fit: cover;">
                            </td>
                            <td>
                                <div class="fw-bold text-dark fs-6">{{ $athlete->nama_lengkap }}</div>
                                <small class="text-muted">Tahun Gabung: {{ $athlete->tahun_bergabung }}</small>
                            </td>
                            <td>
                                <span class="fw-semibold text-muted">{{ $athlete->nomor_id }}</span>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark px-2.5 py-1.5 border" style="font-size: 0.8rem;">
                                    {{ $athlete->divisi }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-light text-danger px-2.5 py-1.5 border" style="font-size: 0.8rem;">
                                    {{ $athlete->kategori }}
                                </span>
                            </td>
                            <td class="text-end fw-extrabold text-danger fs-5" style="padding-right: 30px;">
                                {{ $athlete->results_max_score ?? 0 }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-info-circle fs-3 d-block mb-2"></i>
                                Belum ada data atlet atau skor dalam divisi ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @section('scripts')
        <script>
            $(document).ready(function() {
                // Initialize DataTable
                $('#leaderboardTable').DataTable({
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
                    },
                    responsive: true,
                    pageLength: 15,
                    ordering: false, // Turn off sorting as rows are already pre-sorted by query
                    searching: true
                });
            });
        </script>
    @endsection
</x-app-layout>
