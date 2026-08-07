<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BrailleKita</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Atkinson+Hyperlegible:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --background: #f5f5f5;
            --foreground: #111111;
            --card: #ffffff;
            --primary: #c62828;
            --primary-hover: #b71c1c;
            --muted-foreground: #5a5a5a;
            --border: #d4d4d4;
            --radius: 8px;
            --success-bg: #e8f5e9;
            --success-border: #a5d6a7;
            --success-text: #1b5e20;
        }
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Atkinson Hyperlegible', system-ui, sans-serif;
            background-color: var(--background);
            color: var(--foreground);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
            line-height: 1.5;
        }

        .header-container {
            text-align: center;
            margin-bottom: 24px;
        }

        .logo {
            background-color: var(--primary);
            color: white;
            font-size: 32px;
            font-weight: 700;
            width: 64px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            margin: 0 auto 16px auto;
        }

        .title {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
            color: #000;
        }

        .subtitle {
            color: var(--muted-foreground);
            font-size: 16px;
        }

        .card {
            background-color: var(--card);
            width: 100%;
            max-width: 450px;
            padding: 32px;
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        }

        .card-title {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 24px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-weight: 700;
            margin-bottom: 8px;
            font-size: 15px;
        }

        .text-danger {
            color: var(--primary);
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            font-size: 16px;
            font-family: inherit;
            border: 1px solid var(--border);
            border-radius: 6px;
            outline: none;
            transition: border-color 0.2s;
        }

        .form-control:focus {
            border-color: var(--primary);
        }

        .form-control::placeholder {
            color: #999;
        }

        .btn-primary {
            width: 100%;
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 14px;
            font-size: 16px;
            font-weight: 700;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.2s;
            margin-top: 10px;
            font-family: inherit;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
        }

        .divider {
            height: 1px;
            background-color: var(--border);
            margin: 24px 0;
        }

        .footer-text {
            text-align: center;
            font-size: 15px;
            color: var(--muted-foreground);
        }

        .footer-text a {
            color: var(--primary);
            font-weight: 700;
            text-decoration: none;
        }

        .footer-text a:hover {
            text-decoration: underline;
        }

        /* Alert Styling */
        .alert-danger {
            background-color: #ffebee;
            border: 1px solid #ffcdd2;
            color: #b71c1c;
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-success {
            background-color: var(--success-bg);
            border: 1px solid var(--success-border);
            color: var(--success-text);
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <div class="header-container">
        <!-- Logo B -->
        <div class="logo">B</div>
        <h1 class="title">BrailleKita</h1>
        <p class="subtitle">Platform Buku Braille Sentra Wyata Guna Bandung</p>
    </div>

    <div class="card">
        <h2 class="card-title">Masuk ke Akun</h2>
        
        <!-- Notifikasi Berhasil (misal: setelah berhasil daftar) -->
        @if (session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Pesan Error Validasi / Login Gagal -->
        @if ($errors->any())
            <div class="alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <!-- Form Login (Laravel) -->
        <form method="POST" action="/login">
            @csrf
            
            <div class="form-group">
                <label class="form-label" for="email">Alamat Email <span class="text-danger">*</span></label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Masukkan alamat email" value="{{ old('email') }}" required autofocus>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="kata_sandi">Kata Sandi <span class="text-danger">*</span></label>
                <input type="password" id="kata_sandi" name="kata_sandi" class="form-control" placeholder="Masukkan kata sandi" required>
            </div>
            
            <button type="submit" class="btn-primary">Masuk</button>
        </form>

        <div class="divider"></div>

        <div class="footer-text">
            Belum punya akun? <a href="/register">Daftar Sekarang</a>
        </div>
    </div>

</body>
</html>