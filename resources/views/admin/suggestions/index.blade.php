@extends('layouts.admin')

@section('content')
    {{-- Header Utama --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Daftar Suggestions</h1>
        <div>
            {{-- Tombol Hapus Terpilih akan tetap di sini --}}
            <button type="button" id="bulk-delete-btn" class="btn btn-danger" disabled>
                <i class="fas fa-trash-alt me-2"></i> Hapus Terpilih
            </button>
        </div>
    </div>

    {{-- Notifikasi Sukses --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- [BARU] Panel untuk Filter dan Export --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header">
            <h5 class="mb-0">Filter & Export</h5>
        </div>
        <div class="card-body">
            {{-- Satu form untuk dua aksi: Filter dan Export --}}
            <form action="{{ route('admin.suggestions.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="start_date" class="form-label">Tanggal Mulai</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-4">
                    <label for="end_date" class="form-label">Tanggal Selesai</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date') }}">
                </div>
                <div class="col-md-4 d-flex">
                    <button type="submit" class="btn btn-info w-100 me-2">
                        <i class="fas fa-filter me-1"></i> Filter Tampilan
                    </button>
                    {{-- Tombol ini akan meng-override action dari form --}}
                    <button type="submit" formaction="{{ route('admin.suggestions.export.excel') }}" class="btn btn-success w-100">
                        <i class="fas fa-file-excel me-1"></i> Download Excel
                    </button>
                    <a href="{{ route('admin.suggestions.index') }}" class="btn btn-secondary ms-2" title="Reset Filter">
                        <i class="fas fa-sync-alt"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>


    {{-- Form tersembunyi untuk bulk delete --}}
    <form id="bulk-delete-form" action="{{ route('admin.suggestions.bulkDestroy') }}" method="POST" class="d-none">
        @csrf
    </form>


    @if ($suggestions->isEmpty() && request()->has('start_date'))
        <div class="alert alert-warning">Tidak ada suggestion yang ditemukan pada rentang tanggal yang dipilih.</div>
    @elseif ($suggestions->isEmpty())
        <div class="alert alert-info">Belum ada suggestion yang diajukan.</div>
    @else
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th width="3%"><input type="checkbox" id="select-all-checkbox"></th>
                        <th>ID</th>
                        <th>Nama Pengusul</th>
                        <th>NPK</th>
                        <th>Line/Bag</th>
                        <th>Tema</th>
                        <th>Nilai SS</th>
                        <th>Diajukan Pada</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($suggestions as $suggestion)
                        <tr>
                            <td><input type="checkbox" class="row-checkbox" value="{{ $suggestion->id }}"></td>
                            <td>{{ $suggestion->id }}</td>
                            <td>{{ $suggestion->nama }}</td>
                            <td>{{ $suggestion->npk }}</td>
                            <td>{{ $suggestion->line_bag }}</td>
                            <td>{{ $suggestion->tema }}</td>
                            <td>
                                @if ($suggestion->nilai_ss !== null)
                                    <span class="badge bg-success">{{ $suggestion->nilai_ss }}</span>
                                @else
                                    <span class="badge bg-warning text-dark">Belum Dinilai</span>
                                @endif
                            </td>
                            <td>{{ $suggestion->created_at->format('d M Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.suggestions.show', $suggestion->id) }}" class="btn btn-info btn-sm me-1" title="Lihat Detail/Edit"><i class="fas fa-eye"></i></a>
                                <form action="{{ route('admin.suggestions.destroy', $suggestion->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus suggestion ini? Data yang dihapus tidak dapat dikembalikan.');" title="Hapus Suggestion"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{-- [DIUBAH] Menambahkan appends() agar filter tetap aktif saat pindah halaman --}}
            {{ $suggestions->appends(request()->query())->links() }}
        </div>
    @endif
@endsection

@push('scripts')
{{-- Script untuk bulk delete tidak perlu diubah, jadi saya sertakan lagi di sini --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectAllCheckbox = document.getElementById('select-all-checkbox');
        const rowCheckboxes = document.querySelectorAll('.row-checkbox');
        const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
        const bulkDeleteForm = document.getElementById('bulk-delete-form');

        function toggleBulkDeleteButton() {
            const checkedCount = document.querySelectorAll('.row-checkbox:checked').length;
            if (bulkDeleteBtn) {
                bulkDeleteBtn.disabled = checkedCount === 0;
            }
        }

        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('click', function () {
                rowCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                toggleBulkDeleteButton();
            });
        }

        rowCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('click', function () {
                if (!this.checked) {
                    if(selectAllCheckbox) selectAllCheckbox.checked = false;
                } else {
                    const allChecked = Array.from(rowCheckboxes).every(cb => cb.checked);
                    if(selectAllCheckbox) selectAllCheckbox.checked = allChecked;
                }
                toggleBulkDeleteButton();
            });
        });

        if (bulkDeleteBtn) {
            bulkDeleteBtn.addEventListener('click', function () {
                const selectedIds = Array.from(document.querySelectorAll('.row-checkbox:checked')).map(cb => cb.value);
                if (selectedIds.length > 0) {
                    if (confirm('Apakah Anda yakin ingin menghapus ' + selectedIds.length + ' suggestion yang dipilih?')) {
                        bulkDeleteForm.innerHTML = '';
                        const csrfInput = document.createElement('input');
                        csrfInput.type = 'hidden';
                        csrfInput.name = '_token';
                        csrfInput.value = '{{ csrf_token() }}';
                        bulkDeleteForm.appendChild(csrfInput);
                        selectedIds.forEach(id => {
                            const input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = 'ids[]';
                            input.value = id;
                            bulkDeleteForm.appendChild(input);
                        });
                        bulkDeleteForm.submit();
                    }
                }
            });
        }

        toggleBulkDeleteButton();
    });
</script>
@endpush