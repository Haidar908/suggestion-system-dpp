@extends('layouts.admin')

@section('content')
    <h1 class="mb-4">Tambah Kode Akses Baru</h1>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('admin.access_codes.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="code" class="form-label">Kode Akses</label>
                    <div class="input-group">
                        <input type="password" class="form-control @error('code') is-invalid @enderror" id="code" name="code" value="{{ old('code') }}" required>
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                            <i class="fas fa-eye" id="togglePasswordIcon"></i>
                        </button>
                    </div>
                    <small class="form-text text-muted">Minimal 6 karakter. Kode ini yang akan dibagikan ke karyawan.</small>
                    @error('code')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi (Opsional)</label>
                    <input type="text" class="form-control" id="description" name="description" value="{{ old('description') }}" placeholder="Contoh: Kode akses untuk tim produksi">
                </div>

                <div class="form-check form-switch mb-4">
                    <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active">
                    <label class="form-check-label" for="is_active">Aktifkan Kode Akses Ini</label>
                </div>

                <a href="{{ route('admin.access_codes.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Kode Akses</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
{{-- Script JavaScript untuk tombol mata --}}
<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        const passwordInput = document.getElementById('code');
        const icon = document.getElementById('togglePasswordIcon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
</script>
@endpush