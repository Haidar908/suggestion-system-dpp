@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Detail Suggestion #{{ $suggestion->id }}</h1>
        <div>
            <a href="{{ route('admin.suggestions.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Kartu Informasi Pengusul --}}
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            Informasi Pengusul
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Nama:</strong> {{ $suggestion->nama }}</p>
                    <p><strong>NPK:</strong> {{ $suggestion->npk }}</p>
                </div>
                <div class="col-md-6">
                    {{-- [BARU] Menampilkan nama departemen dari relasi --}}
                    <p><strong>Departemen:</strong> {{ $suggestion->department->nama_departemen ?? '-' }}</p>
                    <p><strong>Line/Bag:</strong> {{ $suggestion->line_bag ?? '-' }}</p>
                </div>
            </div>
            <p><strong>Diajukan Pada:</strong> {{ $suggestion->created_at->format('d M Y H:i') }}</p>
        </div>
    </div>

    {{-- Kartu Detail Suggestion --}}
    <div class="card mb-4">
        <div class="card-header bg-info text-white">
            Detail Suggestion
        </div>
        <div class="card-body">
            {{-- [BARU] Menampilkan Kriteria dan Status Ide di bagian atas --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Kriteria Tema:</strong><br>{{ $suggestion->kriteria ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Status Ide:</strong><br>
                        @if($suggestion->is_new_idea)
                            <span class="badge bg-success">Ya (Ide Baru)</span>
                        @else
                            <span class="badge bg-warning text-dark">Tidak (Ide Lama/Mencontoh)</span>
                        @endif
                    </p>
                </div>
            </div>
            <hr>

            <h5 class="mt-4">Tema SS / Ide Perbaikan:</h5>
            <p>{{ $suggestion->tema ?? '-' }}</p>
            
            <h5 class="mt-4">Kondisi Semula:</h5>
            <p>{{ $suggestion->kondisi_semula_text ?? '-' }}</p>
            @if ($suggestion->kondisi_semula_gambar)
                <a href="{{ asset('storage/' . $suggestion->kondisi_semula_gambar) }}" target="_blank">
                    <img src="{{ asset('storage/' . $suggestion->kondisi_semula_gambar) }}" class="img-fluid rounded mb-3" alt="Kondisi Semula" style="max-height: 300px;">
                </a>
            @else
                <p class="text-muted"><em>Tidak ada gambar kondisi semula.</em></p>
            @endif

            <h5 class="mt-4">Perbaikan:</h5>
            <p>{{ $suggestion->perbaikan_text ?? '-' }}</p>
            @if ($suggestion->perbaikan_gambar)
                <a href="{{ asset('storage/' . $suggestion->perbaikan_gambar) }}" target="_blank">
                    <img src="{{ asset('storage/' . $suggestion->perbaikan_gambar) }}" class="img-fluid rounded mb-3" alt="Perbaikan" style="max-height: 300px;">
                </a>
            @else
                <p class="text-muted"><em>Tidak ada gambar perbaikan.</em></p>
            @endif

            <h5 class="mt-4">Tujuan Perbaikan:</h5>
            <p>{{ $suggestion->tujuan_perbaikan ?? '-' }}</p>

            <h5 class="mt-4">Hasil Perbaikan (Dampak dari Pengusul):</h5>
            @if ($suggestion->hasil_perbaikan_gambar)
                <a href="{{ asset('storage/' . $suggestion->hasil_perbaikan_gambar) }}" target="_blank">
                    <img src="{{ asset('storage/' . $suggestion->hasil_perbaikan_gambar) }}" class="img-fluid rounded mb-3" alt="Hasil Perbaikan (Dampak)" style="max-height: 300px;">
                </a>
            @else
                <p class="text-muted"><em>Tidak ada gambar hasil perbaikan dari pengusul.</em></p>
            @endif
        </div>
    </div>

    {{-- Kartu Form Penilaian Admin --}}
    <div class="card mb-4">
        <div class="card-header bg-success text-white">
            Form Penilaian & Persetujuan (Diisi Admin)
        </div>
        <div class="card-body">
            <form action="{{ route('admin.suggestions.update', $suggestion->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nilai_ss" class="form-label">Nilai SS (0-100)</label>
                    <input type="number" class="form-control" id="nilai_ss" name="nilai_ss" value="{{ old('nilai_ss', $suggestion->nilai_ss) }}" min="0" max="100">
                </div>

                <div class="mb-3">
                    <label for="hasil_perbaikan_gambar_file" class="form-label">Upload Gambar Hasil Perbaikan (Admin)</label>
                    @if ($suggestion->hasil_perbaikan_gambar)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $suggestion->hasil_perbaikan_gambar) }}" class="img-fluid rounded" alt="Gambar Hasil Perbaikan Admin" style="max-height: 200px;">
                            <small class="d-block text-muted">Gambar saat ini. Unggah baru untuk mengganti.</small>
                        </div>
                    @endif
                    <input type="file" class="form-control" id="hasil_perbaikan_gambar_file" name="hasil_perbaikan_gambar_file" accept="image/*">
                </div>

                <div class="mb-3">
                    <label for="diperiksa_oleh" class="form-label">Diperiksa Oleh</label>
                    <input type="text" class="form-control" id="diperiksa_oleh" name="diperiksa_oleh" value="{{ old('diperiksa_oleh', $suggestion->diperiksa_oleh) }}">
                </div>

                <div class="mb-3">
                    <label for="disetujui_oleh" class="form-label">Disetujui Oleh</label>
                    <input type="text" class="form-control" id="disetujui_oleh" name="disetujui_oleh" value="{{ old('disetujui_oleh', $suggestion->disetujui_oleh) }}">
                </div>

                 <div class="mb-3">
                    <label for="dibuat_oleh" class="form-label">Dibuat Oleh</label>
                    <input type="text" class="form-control" id="dibuat_oleh" name="dibuat_oleh" value="{{ old('dibuat_oleh', $suggestion->dibuat_oleh) }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="tanggal_pelaksanaan" class="form-label">Tanggal Pelaksanaan</label>
                    <input type="date" class="form-control" id="tanggal_pelaksanaan" name="tanggal_pelaksanaan" value="{{ old('tanggal_pelaksanaan', $suggestion->tanggal_pelaksanaan) }}" readonly>
                </div>

                <button type="submit" class="btn btn-success w-100"><i class="fas fa-save me-2"></i> Simpan Perubahan Admin</button>
            </form>
        </div>
    </div>

    {{-- Tombol Hapus --}}
    <div class="text-center mt-4">
        <form action="{{ route('admin.suggestions.destroy', $suggestion->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus suggestion ini? Data dan gambar yang dihapus tidak dapat dikembalikan!');">
                <i class="fas fa-trash-alt me-2"></i> Hapus Suggestion Ini
            </button>
        </form>
    </div>
@endsection