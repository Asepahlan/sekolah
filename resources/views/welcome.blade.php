<!-- Start of Selection -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Selamat Datang - SI Sekolah</title>
    <style>
        body {
            background-color: #e9ecef; /* Warna latar belakang yang lebih netral */
        }
        .hero {
            background: linear-gradient(to right, #007bff, #6c757d);
            color: white;
            padding: 80px 0; /* Mengurangi padding untuk tampilan yang lebih seimbang */
            text-align: center;
        }
        .card {
            margin: 20px;
            border-radius: 10px; /* Menambahkan sudut melengkung pada kartu */
        }
        footer {
            text-align: center;
            margin-top: 20px;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="hero">
        <h1>Selamat Datang di Sistem Informasi Sekolah</h1>
        <p>Platform manajemen sekolah yang memudahkan Anda dalam mengelola informasi dan kegiatan sekolah.</p>
        <a href="{{ route('login') }}" class="btn btn-light btn-lg">Masuk</a>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Dokumentasi</h5>
                        <p class="card-text">Akses dokumentasi lengkap untuk mempelajari cara menggunakan sistem ini.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Berita Sekolah</h5>
                        <p class="card-text">Dapatkan informasi terbaru tentang kegiatan dan pengumuman sekolah.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Kontak Kami</h5>
                        <p class="card-text">Hubungi kami untuk pertanyaan lebih lanjut mengenai sistem ini.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 SI Sekolah. Hak Cipta Dilindungi.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<!-- End of Selection -->
