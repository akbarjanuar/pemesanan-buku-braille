<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - BrailleKita</title>
    <!-- Font Atkinson Hyperlegible -->
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
            --radius: 12px;
            --info-bg: #fffde7;
            --info-border: #fbc02d;
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
            padding: 40px 20px;
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
            max-width: 500px;
            padding: 32px;
            border-radius: var(--radius);
            border: 2px solid var(--border);
        }

        .card-title {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 24px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-weight: 700;
            margin-bottom: 4px;
            font-size: 16px;
        }

        .form-hint {
            display: block;
            font-size: 14px;
            color: var(--muted-foreground);
            margin-bottom: 8px;
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

        textarea.form-control {
            resize: vertical;
            min-height: 80px;
        }

        .form-control:focus {
            border-color: var(--primary);
        }

        .form-control::placeholder {
            color: #999;
        }

        /* Styling Kotak Info */
        .info-box {
            background-color: var(--info-bg);
            border: 2px solid var(--info-border);
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 16px;
            font-size: 14.5px;
            line-height: 1.6;
        }
        
        .info-box strong {
            color: #e65100;
        }

        /* Styling Area Upload File */
        .upload-area {
            border: 2px dashed #bdbdbd;
            border-radius: 8px;
            padding: 32px 16px;
            text-align: center;
            background-color: #fafafa;
            cursor: pointer;
            transition: background-color 0.2s;
            margin-bottom: 8px;
            display: block;
        }

        .upload-area:hover {
            background-color: #f0f0f0;
        }

        .upload-icon {
            font-size: 32px;
            margin-bottom: 12px;
            color: var(--foreground);
        }

        .upload-title {
            font-weight: 700;
            font-size: 16px;
            margin-bottom: 4px;
        }

        .upload-subtitle {
            font-size: 14px;
            color: var(--muted-foreground);
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
            margin-top: 16px;
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

        .alert-danger {
            background-color: #ffebee;
            border: 1px solid #ffcdd2;
            color: #b71c1c;
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-danger ul {
            margin-left: 20px;
        }
    </style>
</head>
<body>

    <div class="header-container">
        <div class="logo">B</div>
        <h1 class="title">BrailleKita</h1>
        <p class="subtitle">Platform Buku Braille Sentra Wyata Guna Bandung</p>
    </div>

    <div class="card">
        <h2 class="card-title">Buat Akun Baru</h2>
        
        <!-- Pesan Error Validasi Global (Jika Ada) -->
        @if ($errors->any())
            <div class="alert-danger">
                <strong>Terjadi kesalahan:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Register Laravel -->
        <form method="POST" action="/register" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label class="form-label" for="nama">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama lengkap Anda" value="{{ old('nama') }}" required autofocus>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="email">Alamat Email <span class="text-danger">*</span></label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Masukkan alamat email" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="nomor_telepon">Nomor Telepon <span class="text-danger">*</span></label>
                <span class="form-hint">Format: 08xxxxxxxxxx</span>
                <input type="tel" id="nomor_telepon" name="nomor_telepon" class="form-control" placeholder="081234567890" value="{{ old('nomor_telepon') }}" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="alamat">Alamat<span class="text-danger">*</span></label>
                <span class="form-hint">Alamat tempat tinggal Anda</span> 
                <textarea id="alamat" name="alamat" class="form-control" placeholder="Jl. Contoh No. 1, Kota...">{{ old('alamat') }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label" for="kata_sandi">Kata Sandi <span class="text-danger">*</span></label>
                <span class="form-hint">Minimal 8 karakter</span>
                <input type="password" id="kata_sandi" name="kata_sandi" class="form-control" placeholder="Buat kata sandi" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="kata_sandi_confirmation">Konfirmasi Kata Sandi <span class="text-danger">*</span></label>
                <input type="password" id="kata_sandi_confirmation" name="kata_sandi_confirmation" class="form-control" placeholder="Ulangi kata sandi" required>
            </div>

            <div class="form-group">
                <label class="form-label">Upload Foto KTP <span class="text-danger">*</span></label>
                
                <div class="info-box">
                    <strong>Informasi:</strong> Unggah foto KTP yang jelas dan dapat dibaca untuk keperluan verifikasi data. Foto hanya dapat dilihat oleh admin yang berwenang.
                </div>

                <label class="upload-area" for="foto_ktp">
                    <div class="upload-icon">📄</div>
                    <div class="upload-title">Pilih Foto KTP</div>
                    <div class="upload-subtitle">JPG, JPEG, atau PNG — maksimal 2 MB</div>
                </label>
                <input type="file" id="foto_ktp" name="foto_ktp" accept=".jpg,.jpeg,.png" style="display: none;" required>
                
                <span class="form-hint" style="margin-top: 8px;">Format yang diperbolehkan: JPG, JPEG, PNG. Ukuran maksimal: 2 MB.</span>
            </div>
            
            <button type="submit" class="btn-primary">Daftar Sekarang</button>
        </form>

        <div class="divider"></div>

        <div class="footer-text">
            Sudah punya akun? <a href="/login">Masuk</a>
        </div>
    </div>

    <!-- Kode JavaScript untuk Preview Foto KTP -->
    <script>
        document.getElementById('foto_ktp').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const uploadArea = document.querySelector('.upload-area');

            if (file) {
                // Buat URL sementara untuk preview gambar
                const reader = new FileReader();
                reader.onload = function(event) {
                    uploadArea.innerHTML = `
                        <img src="${event.target.result}" alt="Preview KTP" style="max-height: 150px; border-radius: 6px; margin-bottom: 8px;">
                        <div class="upload-title" style="color: #2e7d32;">✓ ${file.name}</div>
                        <div class="upload-subtitle">Klik untuk mengganti foto</div>
                    `;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>


</body>
</html>