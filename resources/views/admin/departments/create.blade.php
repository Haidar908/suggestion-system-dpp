@extends('layouts.admin')

@section('content')
    <h1>Tambah Departemen Baru</h1>

    <div class="card mt-4">
        <div class="card-body">
            <form action="{{ route('admin.departments.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nama_departemen" class="form-label">Nama Departemen</label>
                    <input type="text" class="form-control @error('nama_departemen') is-invalid @enderror" id="nama_departemen" name="nama_departemen" value="{{ old('nama_departemen') }}" required>
                    @error('nama_departemen')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <a href="{{ route('admin.departments.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection