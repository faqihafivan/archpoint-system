<x-app-layout>
    @section('title', 'Dashboard Pelatih')

    <div class="row g-4 mb-4">
        <!-- Card Total Atlet -->
        <div class="col-md-6 col-lg-3">
            <div class="card custom-card metric-card h-100 p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="metric-title">Total Atlet</div>
                        <div class="metric-value mt-1">{{ $totalAthletes }}</div>
                    </div>
                    <div class="bg-light p-3 rounded-4">
                        <i class="bi bi-people text-danger fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Total Pertandingan -->
        <div class="col-md-6 col-lg-3">
            <div class="card custom-card metric-card success-border h-100 p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="metric-title">Total Pertandingan</div>
                        <div class="metric-value mt-1">{{ $totalMatches }}</div>
                    </div>
                    <div class="bg-light p-3 rounded-4">
                        <i class="bi bi-calendar-event text-success fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Best Score Klub -->
        <div class="col-md-6 col-lg-3">
            <div class="card custom-card metric-card warning-border h-100 p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="metric-title">Best Score Klub</div>
                        <div class="metric-value mt-1">{{ $bestScore }}</div>
                    </div>
                    <div class="bg-light p-3 rounded-4">
                        <i class="bi bi-lightning-fill text-warning fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Total Juara -->
        <div class="col-md-6 col-lg-3">
            <div class="card custom-card metric-card danger-border h-100 p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="metric-title">Total Juara</div>
                        <div class="metric-value mt-1">{{ $totalJuara }}</div>
                    </div>
                    <div class="bg-light p-3 rounded-4">
                        <i class="bi bi-trophy text-primary fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- Grafik Perkembangan Score Seluruh Atlet -->
        <div class="col-xl-7">
            <div class="card custom-card p-4 h-100">
                <h5 class="fw-bold mb-3 text-dark"><i class="bi bi-graph-up me-2 text-danger"></i>Perkembangan Score Klub (Rata-rata)</h5>
                <div style="position: relative; height: 320px; width: 100%;">
                    <canvas id="clubProgressChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Leaderboard Top 10 -->
        <div class="col-xl-5">
            <div class="card custom-card p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-list-ol me-2 text-warning"></i>Leaderboard Top 10</h5>
                    <a href="{{ route('leaderboard.index') }}" class="btn btn-sm btn-outline-danger border-0 fw-bold">Lihat Semua</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover leaderboard-table align-middle">
                        <thead>
                            <tr class="text-muted" style="font-size: 0.85rem;">
                                <th style="width: 60px;">Rank</th>
                                <th>Nama</th>
                                <th>Divisi</th>
                                <th class="text-end">Best Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topAthletes as $index => $item)
                                <tr>
                                    <td>
                                        @if($index + 1 === 1)
                                            <i class="bi bi-award-fill fs-4 text-warning" title="Juara 1 (Emas)" style="filter: drop-shadow(0 2px 4px rgba(245, 158, 11, 0.3));"></i>
                                        @elseif($index + 1 === 2)
                                            <i class="bi bi-award-fill fs-4 text-secondary" title="Juara 2 (Perak)" style="filter: drop-shadow(0 2px 4px rgba(148, 163, 184, 0.3));"></i>
                                        @elseif($index + 1 === 3)
                                            <i class="bi bi-award-fill fs-4 text-danger" title="Juara 3 (Perunggu)" style="filter: drop-shadow(0 2px 4px rgba(180, 83, 9, 0.3)); color: #B45309 !important;"></i>
                                        @else
                                            <span class="rank-badge rank-other">
                                                {{ $index + 1 }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <img src="{{ $item->foto_profil ? asset('storage/' . $item->foto_profil) : 'https://via.placeholder.com/150?text=Avatar' }}" alt="{{ $item->nama_lengkap }}" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
                                            <span class="fw-bold" style="font-size: 0.9rem;">{{ $item->nama_lengkap }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark px-2.5 py-1.5 border" style="font-size: 0.75rem;">
                                            {{ $item->divisi }}
                                        </span>
                                    </td>
                                    <td class="text-end fw-bold text-danger">
                                        {{ $item->results_max_score ?? 0 }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">Belum ada data atlet/pertandingan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const ctx = document.getElementById('clubProgressChart').getContext('2d');
                
                const labels = {!! json_encode($scoreProgress->pluck('date_label')) !!};
                const data = {!! json_encode($scoreProgress->pluck('avg_score')) !!};

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Rata-rata Score Klub',
                            data: data,
                            borderColor: '#C62828',
                            backgroundColor: 'rgba(198, 40, 40, 0.05)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.3,
                            pointBackgroundColor: '#F59E0B',
                            pointBorderColor: '#fff',
                            pointHoverRadius: 7,
                            pointRadius: 5
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: false,
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.03)'
                                },
                                ticks: {
                                    font: {
                                        family: 'Outfit'
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        family: 'Outfit'
                                    }
                                }
                            }
                        }
                    }
                });
            });
        </script>
    @endsection
</x-app-layout>
