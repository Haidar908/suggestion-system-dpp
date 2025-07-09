<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Suggestion Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('assets/images/1674638155928.png') }}" type="image/png">
    <style>
        body { padding: 20px; background-color: #f8f9fa; }
        .form-container { max-width: 800px; margin: auto; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); background-color: white; }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Suggestion System Online</h2>
                {{-- [BARU] Tombol Kembali --}}
                <a href="{{ route('home') }}" class="btn btn-secondary">Kembali ke Halaman Utama</a>
            </div>

            {{-- Menampilkan pesan sukses setelah pengiriman form --}}
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Menampilkan error validasi jika ada --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('suggestions.store') }}" method="POST" enctype="multipart/form-data">
                @csrf {{-- Token CSRF untuk keamanan form --}}

                <fieldset class="mb-4 p-3 border rounded">
                    <legend class="float-none w-auto px-2 fs-5">Informasi Pengusul</legend>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="npk" class="form-label">NPK <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('npk') is-invalid @enderror" id="npk" name="npk" value="{{ old('npk') }}" required>
                        {{-- [BARU] Teks bantuan untuk NPK --}}
                        <small class="form-text text-muted">NPK harus terdiri dari 8 angka.</small>
                        @error('npk')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    {{-- Dropdown Departemen (Wajib Diisi) --}}
                    <div class="mb-3">
                        <label for="department_id" class="form-label">Departemen <span class="text-danger">*</span></label>
                        <select class="form-select @error('department_id') is-invalid @enderror" id="department_id" name="department_id" required>
                            <option selected disabled value="">-- Pilih Departemen --</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                    {{ $department->nama_departemen }}
                                </option>
                            @endforeach
                        </select>
                        @error('department_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Input Teks Line/Bag --}}
                    <div class="mb-3">
                        <label for="line_bag" class="form-label">Line/Bag <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="line_bag" name="line_bag" value="{{ old('line_bag') }}" placeholder="Masukkan line atau bagian anda">
                    </div>
                </fieldset>

                <fieldset class="mb-4 p-3 border rounded">
                    <legend class="float-none w-auto px-2 fs-5">Detail Suggestion</legend>
                    
                    {{-- [PERUBAHAN POSISI] Blok Kriteria & Ide Baru dipindahkan ke sini agar lebih logis --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold">Kriteria Tema <span class="text-danger">*</span></label>
                        <div class="row">
                            @php
                                $kriteriaOptions = [
                                    'Quality (NG proses, Reject, Repair)',
                                    'Cost (Penghematan biaya, consumable dll)',
                                    'Delivery (Kesulitan kerja, Line stop)',
                                    'Safety (Potensi kecelakaan kerja)',
                                    'Moral (Kenyamanan proses)',
                                    'Productivity (Mempercepat proses, menghilangkan muda,mura,muri)',
                                    'Environment ( 5R )',
                                    'Technology ( Suggest )'
                                ];
                            @endphp
                            @foreach($kriteriaOptions as $index => $kriteria)
                                <div class="col-md-6">
                                    <div class="form-check">
                                        {{-- Ini adalah satu-satunya perubahan teknis: 'checkbox' menjadi 'radio' --}}
                                        <input class="form-check-input" type="radio" name="kriteria" value="{{ $kriteria }}" id="kriteria_{{ $index }}" required>
                                        <label class="form-check-label" for="kriteria_{{ $index }}">
                                            {{ $kriteria }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Apakah ide yang diajukan merupakan ide baru?</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="is_new_idea" id="ide_baru_ya" value="1">
                            <label class="form-check-label" for="ide_baru_ya">
                                Ya (Belum pernah saya ajukan sebelumnya)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="is_new_idea" id="ide_baru_tidak" value="0">
                            <label class="form-check-label" for="ide_baru_tidak">
                                Tidak (Sudah pernah diajukan ditempat lain / mencontoh)
                            </label>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="tema" class="form-label">Tema SS / Ide Perbaikan</label>
                        <textarea class="form-control" id="tema" name="tema" rows="2">{{ old('tema') }}</textarea>
                        <small class="text-muted">Isilah dengan kalimat memakai Subjek predikat objek & keterangan</small>
                    </div>

                    <div class="mb-3">
                        <label for="kondisi_semula_text" class="form-label">Kondisi Semula (Deskripsi)</label>
                        <textarea class="form-control" id="kondisi_semula_text" name="kondisi_semula_text" rows="3">{{ old('kondisi_semula_text') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="kondisi_semula_gambar_file" class="form-label">Kondisi Semula (Gambar)</label>
                        <input type="file" class="form-control" id="kondisi_semula_gambar_file" name="kondisi_semula_gambar_file" accept="image/*">
                    </div>

                    <div class="mb-3">
                        <label for="perbaikan_text" class="form-label">Perbaikan (Deskripsi)</label>
                        <textarea class="form-control" id="perbaikan_text" name="perbaikan_text" rows="3">{{ old('perbaikan_text') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="perbaikan_gambar_file" class="form-label">Perbaikan (Gambar)</label>
                        <input type="file" class="form-control" id="perbaikan_gambar_file" name="perbaikan_gambar_file" accept="image/*">
                    </div>

                    <div class="mb-3">
                        <label for="tujuan_perbaikan" class="form-label">Tujuan Perbaikan</label>
                        <textarea class="form-control" id="tujuan_perbaikan" name="tujuan_perbaikan" rows="3">{{ old('tujuan_perbaikan') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="hasil_perbaikan_gambar_file" class="form-label">Hasil Perbaikan (Gambar Dampak)</label>
                        <input type="file" class="form-control" id="hasil_perbaikan_gambar_file" name="hasil_perbaikan_gambar_file" accept="image/*">
                        <small class="text-muted">Unggah foto yang menunjukkan dampak atau hasil dari perbaikan yang telah Anda lakukan.</small>
                    </div>
                </fieldset>

                <button type="submit" class="btn btn-primary w-100">Kirim Suggestion</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>