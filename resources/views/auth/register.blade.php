<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - BrailleKita</title>
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

        .password-wrapper {
            position: relative;
        }
        .password-wrapper .form-control {
            padding-right: 48px;
        }
        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
            color: var(--muted-foreground);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .toggle-password:hover {
            color: var(--foreground);
        }
        .toggle-password svg {
            width: 22px;
            height: 22px;
        }

        .password-error {
            color: var(--primary);
            font-size: 14px;
            margin-top: 6px;
            display: none;
        }

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
            transition: background-color 0.2s, opacity 0.2s;
            margin-top: 16px;
            font-family: inherit;
        }
        .btn-primary:hover:not(:disabled) {
            background-color: var(--primary-hover);
        }
        .btn-primary:disabled {
            opacity: 0.55;
            cursor: not-allowed;
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

        <form method="POST" action="/register" enctype="multipart/form-data" id="registerForm">
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

            <!-- Kata Sandi -->
            <div class="form-group">
                <label class="form-label" for="kata_sandi">Kata Sandi <span class="text-danger">*</span></label>
                <span class="form-hint">Minimal 8 karakter</span>
                <div class="password-wrapper">
                    <input type="text" id="kata_sandi" name="kata_sandi" class="form-control" placeholder="Buat kata sandi" required minlength="8" autocomplete="new-password">
                    <button type="button" class="toggle-password" data-target="kata_sandi" aria-label="Tampilkan kata sandi">
                        <svg class="eye-open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg class="eye-closed" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display:none;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Konfirmasi Kata Sandi -->
            <div class="form-group">
                <label class="form-label" for="kata_sandi_confirmation">Konfirmasi Kata Sandi <span class="text-danger">*</span></label>
                <div class="password-wrapper">
                    <input type="text" id="kata_sandi_confirmation" name="kata_sandi_confirmation" class="form-control" placeholder="Ulangi kata sandi" required autocomplete="new-password">
                    <button type="button" class="toggle-password" data-target="kata_sandi_confirmation" aria-label="Tampilkan kata sandi">
                        <svg class="eye-open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg class="eye-closed" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display:none;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    </button>
                </div>
                <div class="password-error" id="passwordError">
                    Kata sandi dan konfirmasi tidak sama
                </div>
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
           
            <button type="submit" class="btn-primary" id="btnDaftar">Daftar Sekarang</button>
        </form>
        <div class="divider"></div>
        <div class="footer-text">
            Sudah punya akun? <a href="/login">Masuk</a>
        </div>
    </div>

    <script>
        function setupPasswordField(inputId) {
            const input = document.getElementById(inputId);
            let realValue = '';
            let isVisible = false;
            let maskTimeout = null;
            let previousLength = 0;

            function updateDisplay(showLastChar = false) {
                if (isVisible) {
                    input.value = realValue;
                    return;
                }

                if (realValue.length === 0) {
                    input.value = '';
                    return;
                }

                if (showLastChar) {
                    input.value = '•'.repeat(realValue.length - 1) + realValue.slice(-1);
                } else {
                    input.value = '•'.repeat(realValue.length);
                }
            }

            input.addEventListener('input', function () {
                const currentDisplay = this.value;
                const currentLength = currentDisplay.length;
                const isDeleting = currentLength < previousLength;

                if (isDeleting) {
                    // User menghapus → potong realValue & tetap bulat
                    realValue = realValue.slice(0, currentLength);
                    updateDisplay(false);
                } else {
                    // User mengetik
                    if (currentLength > realValue.length) {
                        const added = currentDisplay.slice(realValue.length);
                        realValue += added;
                    } else {
                        realValue = realValue.slice(0, -1) + currentDisplay.slice(-1);
                    }

                    updateDisplay(true);
                    clearTimeout(maskTimeout);

                    if (!isVisible) {
                        maskTimeout = setTimeout(() => {
                            updateDisplay(false);
                        }, 800);
                    }
                }

                previousLength = currentLength;
            });

            input.form.addEventListener('submit', function () {
                input.value = realValue;
            });

            const toggleBtn = input.closest('.password-wrapper').querySelector('.toggle-password');
            const eyeOpen = toggleBtn.querySelector('.eye-open');
            const eyeClosed = toggleBtn.querySelector('.eye-closed');

            toggleBtn.addEventListener('click', function () {
                isVisible = !isVisible;
                clearTimeout(maskTimeout);

                if (isVisible) {
                    input.value = realValue;
                    eyeOpen.style.display = 'none';
                    eyeClosed.style.display = 'block';
                } else {
                    updateDisplay(false);
                    eyeOpen.style.display = 'block';
                    eyeClosed.style.display = 'none';
                }
            });

            input._getRealValue = () => realValue;
        }

        // Inisialisasi kedua field
        setupPasswordField('kata_sandi');
        setupPasswordField('kata_sandi_confirmation');

        // ===== Validasi Konfirmasi Password =====
        const passwordInput = document.getElementById('kata_sandi');
        const confirmInput = document.getElementById('kata_sandi_confirmation');
        const passwordError = document.getElementById('passwordError');
        const btnDaftar = document.getElementById('btnDaftar');

        function validatePasswordMatch() {
            const password = passwordInput._getRealValue ? passwordInput._getRealValue() : passwordInput.value;
            const confirm = confirmInput._getRealValue ? confirmInput._getRealValue() : confirmInput.value;

            if (confirm === '') {
                passwordError.style.display = 'none';
                btnDaftar.disabled = false;
                return;
            }

            if (password !== confirm) {
                passwordError.style.display = 'block';
                btnDaftar.disabled = true;
            } else {
                passwordError.style.display = 'none';
                btnDaftar.disabled = false;
            }
        }

        passwordInput.addEventListener('input', validatePasswordMatch);
        confirmInput.addEventListener('input', validatePasswordMatch);

        // ===== Preview Foto KTP =====
        document.getElementById('foto_ktp').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const uploadArea = document.querySelector('.upload-area');
            if (file) {
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