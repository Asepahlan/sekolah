<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Login - SI Sekolah</title>
    <style>
        body {
            background-image: url('https://example.com/background.jpg'); /* Ganti dengan URL gambar latar belakang */
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            max-width: 400px;
            width: 100%;
            padding: 30px;
            background: rgba(255, 255, 255, 0.9); /* Latar belakang putih dengan transparansi */
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333; /* Warna teks */
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        footer {
            position: absolute;
            bottom: 10px;
            width: 100%;
            text-align: center;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
            <a href="{{ route('welcome') }}" class="btn btn-secondary btn-block">Kembali</a> <!-- Mengubah link kembali ke tampilan awal -->
            <a href="{{ route('password.request') }}" class="btn btn-link">Lupa Password?</a> <!-- Tambahkan link untuk lupa password -->
        </form>
    </div>

    <footer>
        <p>&copy; 2024 SI Sekolah. All rights reserved.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
