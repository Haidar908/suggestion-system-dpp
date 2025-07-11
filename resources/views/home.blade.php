<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- [BARU] Menambahkan CSRF token untuk AJAX --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Suggestion System Online - PT. Dharma Poliplast</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('assets/images/1674638155928.png') }}" type="image/png">
    {{-- Style CSS tidak ada perubahan, saya persingkat di sini --}}
    <style>
        body{background-color:#f8f9fa;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif}.header{background-color:#fff;padding:1rem 2rem;border-bottom:1px solid #dee2e6}.logo{height:60px}.version{font-size:.9rem;color:#6c757d}.main-content{padding:4rem 2rem}.content-left h1{font-weight:700;color:#343a40;margin-bottom:1rem}.sub-heading{font-size:1.75rem;font-weight:400;color:#495057;margin-top:-.5rem;margin-bottom:1.5rem}.content-left p{color:#495057;font-size:1.1rem;line-height:1.6}.content-left .contact-person{margin-top:2rem;padding-left:1rem;border-left:3px solid #0d6efd}.content-left .closing-text{font-weight:600;text-transform:uppercase;color:#0d6efd;margin-top:2rem}.action-box{background-color:#fff;padding:2rem;border-radius:.5rem;box-shadow:0 .5rem 1rem rgba(0,0,0,.1);height:100%;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center}.action-box h3{font-weight:600;margin-bottom:1rem}.action-box .btn-primary{padding:.75rem 1.5rem;font-size:1.1rem;font-weight:500}
    </style>
</head>
<body>
    {{-- Header dan Konten Utama tidak ada perubahan --}}
    <header class="header d-flex justify-content-between align-items-center">
        <div><img src="{{ asset('images/logo-dharma.png') }}" alt="Logo Perusahaan" class="logo"></div>
        <div class="version">VERSION: 1.0.0</div>
    </header>
    <main class="container-fluid main-content">
        <div class="row align-items-center">
            <div class="col-lg-7 content-left">
                <h1>SUGGESTION SYSTEM ONLINE</h1>
                <h3 class="sub-heading">PT Dharma Poliplast</h3>
                <p>Selamat datang di layanan Suggestion System Online, ini adalah pengganti form SS (Form Biru) dan google form yang selama ini di gunakan. Secara garis besar tidak ada konten yang berubah, jadi anda dapat Membuat SS dimana saja dan kapan saja menggunakan PC atau Handphone.</p>
                <div class="contact-person">
                    <p class="mb-1">Jika ada yang belum jelas silahkan hubungi PIC Management Improvement dan IT Developer kami di bawah ini:</p>
                    <strong>Contact Person</strong><br>
                    (Yudi: mprayudi@dpplast.com / 0851 5746 2276)<br>
                    (Devi: devi.novianti@dpplast.com / 0856 1718 716)<br>
                </div>
                <p class="closing-text">TERIMA KASIH ATAS KONTRIBUSINYA & TINGKATKAN SEMANGAT AKAN BUDAYA BERIMPROVEMENT</p>
            </div>
            <div class="col-lg-5">
                <div class="action-box">
                    <h3>Punya Ide Perbaikan?</h3>
                    <p class="text-muted">Jangan ragu untuk mengusulkannya. Klik tombol di bawah untuk memulai pengisian formulir.</p>
                    {{-- [DIUBAH] Tombol ini sekarang memicu pop-up, bukan link biasa --}}
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#accessCodeModal">
                        Buat Suggestion Baru
                    </button>
                </div>
            </div>
        </div>
    </main>

    <div class="modal fade" id="accessCodeModal" tabindex="-1" aria-labelledby="accessCodeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="accessCodeModalLabel">Verifikasi Kode Akses</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted">Silakan masukkan kode akses yang valid untuk melanjutkan.</p>
                    {{-- Form di dalam pop-up --}}
                    <form id="accessCodeForm">
                        <div class="mb-3">
                            <input type="password" class="form-control" id="access_code_input" placeholder="Masukkan kode akses" required>
                            <div id="errorMessage" class="invalid-feedback d-block mt-2"></div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Lanjutkan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Script Bootstrap & JavaScript kustom --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('accessCodeForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Mencegah form submit biasa

            const code = document.getElementById('access_code_input').value;
            const errorMessageDiv = document.getElementById('errorMessage');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            errorMessageDiv.textContent = ''; // Kosongkan pesan error

            fetch("{{ route('suggestions.verifyAccessCode') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ access_code: code })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Jika berhasil, arahkan ke halaman create
                    window.location.href = "{{ route('suggestions.create') }}";
                } else {
                    // Jika gagal, tampilkan pesan error
                    errorMessageDiv.textContent = data.message || 'Kode akses tidak valid.';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                errorMessageDiv.textContent = 'Terjadi kesalahan. Silakan coba lagi.';
            });
        });
    </script>
</body>
</html>