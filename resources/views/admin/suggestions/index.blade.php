@extends('layouts.admin')

@section('content')
    {{-- Header Utama --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Daftar Suggestions</h1>
        <div>
            {{-- Tombol Hapus Terpilih akan tetap di sini --}}
            <button type="button" id="bulk-delete-btn" class="btn btn-danger" disabled>
                <i class="fas fa-trash-alt me-2"></i> Hapus Terpilih (<span id="selected-count">0</span>)
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

    {{-- Panel untuk Filter dan Export --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0 text-dark">
                <i class="fas fa-filter me-2"></i>Filter & Export
            </h5>
        </div>
        <div class="card-body">
            {{-- Form untuk Filter dan Export --}}
            <form action="{{ route('admin.suggestions.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="start_date" class="form-label fw-semibold">Tanggal Mulai</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-3">
                    <label for="end_date" class="form-label fw-semibold">Tanggal Selesai</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date') }}">
                </div>
                <div class="col-md-6">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-info flex-fill">
                            <i class="fas fa-filter me-1"></i> Filter Tampilan
                        </button>
                        <button type="submit" formaction="{{ route('admin.suggestions.export.excel') }}" class="btn btn-success flex-fill">
                            <i class="fas fa-file-excel me-1"></i> Download Excel
                        </button>
                        <a href="{{ route('admin.suggestions.index') }}" class="btn btn-secondary" title="Reset Filter">
                            <i class="fas fa-sync-alt"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Form tersembunyi untuk bulk delete --}}
    <form id="bulk-delete-form" action="{{ route('admin.suggestions.bulkDestroy') }}" method="POST" class="d-none">
        @csrf
    </form>

    {{-- Konten Tabel --}}
    @if ($suggestions->isEmpty() && request()->has('start_date'))
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle me-2"></i>
            Tidak ada suggestion yang ditemukan pada rentang tanggal yang dipilih.
        </div>
    @elseif ($suggestions->isEmpty())
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>
            Belum ada suggestion yang diajukan.
        </div>
    @else
        {{-- Info jumlah data --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <small class="text-muted">
                Menampilkan {{ $suggestions->firstItem() }} sampai {{ $suggestions->lastItem() }} 
                dari {{ $suggestions->total() }} total suggestion
            </small>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th width="3%" class="text-center">
                                    <input type="checkbox" id="select-all-checkbox" class="form-check-input">
                                </th>
                                <th>ID</th>
                                <th>Nama Pengusul</th>
                                <th>NPK</th>
                                <th>Line/Bag</th>
                                <th>Tema</th>
                                <th class="text-center">Nilai SS</th>
                                <th>Diajukan Pada</th>
                                <th class="text-center" width="120px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($suggestions as $suggestion)
                                <tr>
                                    <td class="text-center">
                                        <input type="checkbox" class="row-checkbox form-check-input" value="{{ $suggestion->id }}">
                                    </td>
                                    <td class="fw-semibold">#{{ $suggestion->id }}</td>
                                    <td>{{ $suggestion->nama }}</td>
                                    <td>{{ $suggestion->npk }}</td>
                                    <td>{{ $suggestion->line_bag }}</td>
                                    <td>
                                        <span class="text-truncate d-inline-block" style="max-width: 200px;" title="{{ $suggestion->tema }}">
                                            {{ $suggestion->tema }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if ($suggestion->nilai_ss !== null)
                                            <span class="badge bg-success fs-6">{{ $suggestion->nilai_ss }}</span>
                                        @else
                                            <span class="badge bg-warning text-dark fs-6">Belum Dinilai</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small>{{ $suggestion->created_at->format('d M Y') }}</small><br>
                                        <small class="text-muted">{{ $suggestion->created_at->format('H:i') }}</small>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.suggestions.show', $suggestion->id) }}" 
                                               class="btn btn-info btn-sm" title="Lihat Detail/Edit">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <form action="{{ route('admin.suggestions.destroy', $suggestion->id) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" 
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus suggestion ini? Data yang dihapus tidak dapat dikembalikan.');" 
                                                        title="Hapus Suggestion">
                                                    <i class="fas fa-trash-alt"></i>
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
        </div>

        {{-- Pagination yang diperbaiki --}}
        @if ($suggestions->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted small">
                    Halaman {{ $suggestions->currentPage() }} dari {{ $suggestions->lastPage() }}
                </div>
                <nav aria-label="Pagination Navigation">
                    {{ $suggestions->appends(request()->query())->onEachSide(1)->links('pagination::bootstrap-4') }}
                </nav>
            </div>
        @endif
    @endif
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectAllCheckbox = document.getElementById('select-all-checkbox');
        const rowCheckboxes = document.querySelectorAll('.row-checkbox');
        const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
        const bulkDeleteForm = document.getElementById('bulk-delete-form');
        const selectedCountSpan = document.getElementById('selected-count');

        function updateSelectedCount() {
            const checkedCount = document.querySelectorAll('.row-checkbox:checked').length;
            if (selectedCountSpan) {
                selectedCountSpan.textContent = checkedCount;
            }
        }

        function toggleBulkDeleteButton() {
            const checkedCount = document.querySelectorAll('.row-checkbox:checked').length;
            if (bulkDeleteBtn) {
                bulkDeleteBtn.disabled = checkedCount === 0;
            }
            updateSelectedCount();
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
                        // Clear form
                        bulkDeleteForm.innerHTML = '';
                        
                        // Add CSRF token
                        const csrfInput = document.createElement('input');
                        csrfInput.type = 'hidden';
                        csrfInput.name = '_token';
                        csrfInput.value = '{{ csrf_token() }}';
                        bulkDeleteForm.appendChild(csrfInput);
                        
                        // Add selected IDs
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

        // Initialize button state
        toggleBulkDeleteButton();
    });
</script>
@endpush
