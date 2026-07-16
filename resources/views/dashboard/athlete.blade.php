<x-app-layout>
    @section('title', 'Dashboard Atlet')

    <div class="row g-4 mb-4">
        <!-- Profile Card -->
        <div class="col-lg-4">
            <div class="card custom-card p-4 text-center h-100">
                <div class="position-relative d-inline-block mx-auto mb-3" style="width: 130px; height: 130px;">
                    <img src="{{ $athlete->foto_profil ? asset('storage/' . $athlete->foto_profil) : 'https://via.placeholder.com/150?text=Avatar' }}" alt="{{ $athlete->nama_lengkap }}" class="rounded-circle w-100 h-100 object-fit-cover border border-3 border-danger shadow-sm">
                </div>
                
                <h4 class="fw-bold mb-1 text-dark">{{ $athlete->nama_lengkap }}</h4>
                <div class="badge bg-danger mb-3 px-3 py-1.5 fs-7">{{ $athlete->nomor_id }}</div>
                
                <div class="text-start p-3 bg-light rounded-4">
                    <div class="row mb-2">
                        <div class="col-5 text-muted small">Divisi</div>
                        <div class="col-7 fw-semibold">{{ $athlete->divisi }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 text-muted small">Kategori</div>
                        <div class="col-7 fw-semibold">{{ $athlete->kategori }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 text-muted small">Tahun Gabung</div>
                        <div class="col-7 fw-semibold">{{ $athlete->tahun_bergabung }}</div>
                    </div>
                    <div class="row">
                        <div class="col-5 text-muted small">Tempat, Tgl Lahir</div>
                        <div class="col-7 fw-semibold" style="font-size: 0.85rem;">
                            {{ $athlete->tempat_lahir }}, {{ \Carbon\Carbon::parse($athlete->tanggal_lahir)->translatedFormat('d M Y') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Grid (5 Cards) -->
        <div class="col-lg-8">
            <div class="row g-3 h-100 align-content-between">
                <!-- Best Score -->
                <div class="col-sm-6 col-md-4">
                    <div class="card custom-card metric-card warning-border p-3">
                        <div class="text-muted metric-title">Best Score</div>
                        <div class="metric-value text-warning mt-1">{{ $bestScore }}</div>
                        <small class="text-muted">Skor tertinggi Anda</small>
                    </div>
                </div>

                <!-- Average Score -->
                <div class="col-sm-6 col-md-4">
                    <div class="card custom-card metric-card success-border p-3">
                        <div class="text-muted metric-title">Average Score</div>
                        <div class="metric-value text-success mt-1">{{ $avgScore }}</div>
                        <small class="text-muted">Skor rata-rata Anda</small>
                    </div>
                </div>

                <!-- Total Pertandingan -->
                <div class="col-sm-6 col-md-4">
                    <div class="card custom-card metric-card p-3">
                        <div class="text-muted metric-title">Total Lomba</div>
                        <div class="metric-value text-dark mt-1">{{ $totalMatches }}</div>
                        <small class="text-muted">Lomba diikuti</small>
                    </div>
                </div>

                <!-- Total Juara -->
                <div class="col-sm-6 col-md-6 col-xl-6">
                    <div class="card custom-card metric-card danger-border p-3">
                        <div class="text-muted metric-title">Total Juara</div>
                        <div class="metric-value text-danger mt-1">{{ $totalJuara }}</div>
                        <small class="text-muted">Medali terkumpul (Juara 1, 2, 3)</small>
                    </div>
                </div>

                <!-- Ranking Klub -->
                <div class="col-sm-12 col-md-6 col-xl-6">
                    <div class="card custom-card metric-card success-border p-3">
                        <div class="text-muted metric-title">Ranking Klub</div>
                        <div class="metric-value text-primary mt-1">#{{ $rankingKlub }}</div>
                        <small class="text-muted">Berdasarkan best score tertinggi</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Recent Match Logs -->
    <div class="row g-4 mb-4">
        <!-- Personal score progress -->
        <div class="col-xl-7">
            <div class="card custom-card p-4 h-100">
                <h5 class="fw-bold mb-3 text-dark"><i class="bi bi-graph-up me-2 text-danger"></i>Grafik Perkembangan Score Anda</h5>
                <div style="position: relative; height: 320px; width: 100%;">
                    <canvas id="personalProgressChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Latest 5 Match results -->
        <div class="col-xl-5">
            <div class="card custom-card p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-award me-2 text-primary"></i>Riwayat Lomba Terbaru</h5>
                    <a href="{{ route('results.index') }}" class="btn btn-sm btn-outline-danger border-0 fw-bold">Lihat Semua</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr class="text-muted" style="font-size: 0.85rem;">
                                <th>Event/Lomba</th>
                                <th>Score</th>
                                <th class="text-end">Hasil</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestResults as $res)
                                <tr>
                                    <td>
                                        <div class="fw-bold" style="font-size: 0.9rem;">{{ $res->event_name }}</div>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($res->tanggal)->translatedFormat('d M Y') }}</small>
                                    </td>
                                    <td class="fw-bold text-dark">{{ $res->score }}</td>
                                    <td class="text-end">
                                        @if($res->hasil_pertandingan === 'Juara 1')
                                            <span class="badge bg-warning text-dark px-2.5 py-1.5 border border-warning" style="font-size: 0.75rem;">Juara 1</span>
                                        @elseif($res->hasil_pertandingan === 'Juara 2')
                                            <span class="badge bg-light text-secondary px-2.5 py-1.5 border" style="font-size: 0.75rem;">Juara 2</span>
                                        @elseif($res->hasil_pertandingan === 'Juara 3')
                                            <span class="badge bg-amber px-2.5 py-1.5 border" style="font-size: 0.75rem; background-color: #fce8e6; color: #a94442;">Juara 3</span>
                                        @else
                                            <span class="badge bg-light text-muted px-2.5 py-1.5 border" style="font-size: 0.75rem;">Tidak Juara</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted">Belum ada hasil pertandingan yang dicatat.</td>
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
                const ctx = document.getElementById('personalProgressChart').getContext('2d');
                
                const labels = {!! json_encode($personalProgress->map(function($r) { 
                    return \Carbon\Carbon::parse($r->tanggal)->translatedFormat('d M y');
                })) !!};
                const data = {!! json_encode($personalProgress->pluck('score')) !!};
                const events = {!! json_encode($personalProgress->pluck('event_name')) !!};

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Score Anda',
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
                            },
                            tooltip: {
                                callbacks: {
                                    afterLabel: function(context) {
                                        return 'Event: ' + events[context.dataIndex];
                                    }
                                }
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
