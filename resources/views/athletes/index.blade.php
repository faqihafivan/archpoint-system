<x-app-layout>
    @section('title', 'Kelola Atlet')

    <div class="card custom-card p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold text-dark mb-1"><i class="bi bi-people-fill me-2 text-danger"></i>Data Atlet BULAVA</h4>
                <p class="text-muted mb-0" style="font-size: 0.9rem;">Kelola akun dan biodata seluruh atlet panahan klub</p>
            </div>
        </div>

        <div class="table-responsive">
            <table id="athletesTable" class="table table-hover align-middle" style="width: 100%;">
                <thead>
                    <tr class="text-muted" style="font-size: 0.875rem;">
                        <th>ID Atlet</th>
                        <th>Foto</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>Divisi</th>
                        <th>Kategori</th>
                        <th>Tahun Gabung</th>
                        <th class="text-center" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($athletes as $athlete)
                        <tr>
                            <td class="fw-bold text-danger">{{ $athlete->nomor_id }}</td>
                            <td>
                                <img src="{{ $athlete->foto_profil ? asset('storage/' . $athlete->foto_profil) : 'https://via.placeholder.com/150?text=Avatar' }}" alt="{{ $athlete->nama_lengkap }}" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover; border: 1px solid #ddd;">
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $athlete->nama_lengkap }}</div>
                                <small class="text-muted">Username: {{ $athlete->user->username }}</small>
                            </td>
                            <td>{{ $athlete->user->email }}</td>
                            <td>
                                <span class="badge bg-light text-dark border px-2.5 py-1.5" style="font-size: 0.8rem;">
                                    {{ $athlete->divisi }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-light text-danger border px-2.5 py-1.5" style="font-size: 0.8rem;">
                                    {{ $athlete->kategori }}
                                </span>
                            </td>
                            <td class="fw-semibold text-dark">{{ $athlete->tahun_bergabung }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <!-- Edit Button -->
                                    <a href="{{ route('athletes.edit', $athlete->id) }}" class="btn btn-sm btn-outline-primary px-3 py-1.5 rounded-2">
                                        <i class="bi bi-pencil-square me-1"></i> Edit
                                    </a>
                                    <!-- Delete Button -->
                                    <form action="{{ route('athletes.destroy', $athlete->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger px-3 py-1.5 rounded-2 delete-btn">
                                            <i class="bi bi-trash3-fill me-1"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @section('scripts')
        <script>
            $(document).ready(function() {
                // Initialize DataTable
                $('#athletesTable').DataTable({
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json' // Indonesian localization
                    },
                    responsive: true,
                    pageLength: 10,
                    columnDefs: [
                        { orderable: false, targets: [1, 7] }
                    ]
                });

                // SweetAlert Delete confirmation
                $('#athletesTable').on('click', '.delete-btn', function(e) {
                    e.preventDefault();
                    const form = $(this).closest('form');
                    
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data biodata, akun, dan semua hasil pertandingan atlet ini akan dihapus permanen!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#C62828',
                        cancelButtonColor: '#6B7280',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal',
                        customClass: {
                            confirmButton: 'btn btn-primary px-4 py-2 me-2',
                            cancelButton: 'btn btn-secondary px-4 py-2'
                        },
                        buttonsStyling: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        </script>
    @endsection
</x-app-layout>
