@extends('layouts.admin')

@section('content')
    {{-- Header Halaman --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0 h2">Manajemen Kode Akses</h1>
        <a href="{{ route('admin.access_codes.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Tambah Kode Baru
        </a>
    </div>

    {{-- Notifikasi Sukses --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Tabel Data --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%;">#</th>
                            <th>Kode Akses</th>
                            <th>Deskripsi</th>
                            <th class="text-center">Status</th>
                            <th>Dibuat Pada</th>
                            <th style="width: 10%;" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($accessCodes as $index => $accessCode)
                            <tr>
                                <td>{{ $accessCodes->firstItem() + $index }}</td>
                                <td>
                                    {{-- [BARU] Tampilan kode dengan sensor dan tombol mata --}}
                                    <div class="d-flex align-items-center">
                                        <span class="code-display" data-code="{{ $accessCode->code }}">••••••••</span>
                                        <button class="btn btn-sm btn-outline-secondary ms-2 toggle-code-visibility" type="button" title="Tampilkan/Sembunyikan Kode">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </td>
                                <td>{{ $accessCode->description ?? '-' }}</td>
                                <td class="text-center">
                                    @if ($accessCode->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Tidak Aktif</span>
                                    @endif
                                </td>
                                <td>{{ $accessCode->created_at->format('d M Y') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.access_codes.edit', $accessCode->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.access_codes.destroy', $accessCode->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kode akses ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <p class="text-muted">Belum ada kode akses yang dibuat.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($accessCodes->hasPages())
            <div class="card-footer bg-white">
                {{ $accessCodes->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
@endsection

@push('scripts')
{{-- Script untuk tombol mata --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleButtons = document.querySelectorAll('.toggle-code-visibility');

        toggleButtons.forEach(button => {
            button.addEventListener('click', function () {
                const displaySpan = this.previousElementSibling;
                const icon = this.querySelector('i');
                const realCode = displaySpan.getAttribute('data-code');

                if (displaySpan.textContent === '••••••••') {
                    // Tampilkan kode asli
                    displaySpan.textContent = realCode;
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    // Sembunyikan lagi
                    displaySpan.textContent = '••••••••';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });
    });
</script>
@endpush