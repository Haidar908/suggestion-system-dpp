<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suggestion System Online - PT. Dharma Poliplast</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('assets/images/1674638155928.png') }}" type="image/png">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }
        .header {
            background-color: #ffffff;
            padding: 1rem 2rem;
            border-bottom: 1px solid #dee2e6;
        }
        .logo {
            height: 60px;
        }
        .version {
            font-size: 0.9rem;
            color: #6c757d;
        }
        .main-content {
            padding: 4rem 2rem;
        }
        .content-left h1 {
            font-weight: 700;
            color: #343a40;
            margin-bottom: 1rem;
        }
        /* [BARU] Style untuk sub-judul nama perusahaan */
        .sub-heading {
            font-size: 1.75rem;
            font-weight: 400;
            color: #495057;
            margin-top: -0.5rem;
            margin-bottom: 1.5rem;
        }
        .content-left p {
            color: #495057;
            font-size: 1.1rem;
            line-height: 1.6;
        }
        .content-left .contact-person {
            margin-top: 2rem;
            padding-left: 1rem;
            border-left: 3px solid #0d6efd;
        }
        .content-left .closing-text {
            font-weight: 600;
            text-transform: uppercase;
            color: #0d6efd;
            margin-top: 2rem;
        }
        .action-box {
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        .action-box h3 {
            font-weight: 600;
            margin-bottom: 1rem;
        }
        .action-box .btn-primary {
            padding: 0.75rem 1.5rem;
            font-size: 1.1rem;
            font-weight: 500;
        }
    </style>
</head>
<body>

    <header class="header d-flex justify-content-between align-items-center">
        <div>
            {{-- Path logo Anda --}}
            <img src="{{ asset('assets/images/PT-Dharma-Poliplast-02(1)1.png') }}" alt="Logo Perusahaan" class="logo">
        </div>
        <div class="version">
            VERSION: 1.0.0
        </div>
    </header>

    <main class="container-fluid main-content">
        <div class="row align-items-center">
            {{-- Kolom Kiri: Informasi --}}
            <div class="col-lg-7 content-left">
                <h1>SUGGESTION SYSTEM ONLINE</h1>
                {{-- [BARU] Menambahkan nama perusahaan di bawah judul utama --}}
                <h3 class="sub-heading">PT Dharma Poliplast</h3>
                <p>
                    Selamat datang di layanan Suggestion System Online, ini adalah pengganti form SS (Form Biru) dan google form yang selama ini di gunakan. Secara garis besar tidak ada konten yang berubah, jadi anda dapat Membuat SS dimana saja dan kapan saja menggunakan PC atau Handphone.
                </p>
                <div class="contact-person">
                    <p class="mb-1">Jika ada yang belum jelas silahkan hubungi PIC Management Improvement dan IT Developer kami di bawah ini:</p>
                    <strong>Contact Person</strong><br>
                    (Yudi: mprayudi@dpplast.com / 0851 5746 2276)<br>
                    (Devi: devi.novianti@dpplast.com / 0856 1718 716)<br>
                </div>
                <p class="closing-text">
                    TERIMA KASIH ATAS KONTRIBUSINYA & TINGKATKAN SEMANGAT AKAN BUDAYA BERIMPROVEMENT
                </p>
            </div>

            {{-- Kolom Kanan: Tombol Aksi --}}
            <div class="col-lg-5">
                <div class="action-box">
                    <h3>Punya Ide Perbaikan?</h3>
                    <p class="text-muted">Jangan ragu untuk mengusulkannya. Klik tombol di bawah untuk memulai pengisian formulir.</p>
                    <a href="{{ route('suggestions.create') }}" class="btn btn-primary">
                        Buat Suggestion Baru
                    </a>
                </div>
            </div>
        </div>
    </main>

</body>
</html>