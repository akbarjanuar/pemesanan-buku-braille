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
        <div class="logo">B</div>
        <h1 class="title">BrailleKita</h1>
        <p class="subtitle">Platform Buku Braille Sentra Wyata Guna Bandung</p>
    </div>
    <div class="card">
        <h2 class="card-title">Masuk ke Akun</h2>
       
        @if (session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="/login">
            @csrf
           
            <div class="form-group">
                <label class="form-label" for="email">Alamat Email <span class="text-danger">*</span></label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Masukkan alamat email" value="{{ old('email') }}" required autofocus>
            </div>
           
            <div class="form-group">
                <label class="form-label" for="kata_sandi">Kata Sandi <span class="text-danger">*</span></label>
                <div class="password-wrapper">
                    <input type="text" id="kata_sandi" name="kata_sandi" class="form-control" placeholder="Masukkan kata sandi" required autocomplete="current-password">
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
           
            <button type="submit" class="btn-primary">Masuk</button>
        </form>
        <div class="divider"></div>
        <div class="footer-text">
            Belum punya akun? <a href="/register">Daftar Sekarang</a>
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

        setupPasswordField('kata_sandi');
    </script>
</body>
</html>