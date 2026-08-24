<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemilihan Akun - BrailleKita</title>
    <link href="https://fonts.googleapis.com/css2?family=Atkinson+Hyperlegible:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #c62828;
            --muted-foreground: #5a5a5a;
            --border: #e0e0e0;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            background: #c62828;
            min-height: 100%;
            font-family: 'Atkinson Hyperlegible', sans-serif;
            line-height: 1.6;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        a { text-decoration: none; color: inherit; }

        /* ===== Hero ===== */
        .hero {
            background: #c62828;
            color: white;
            text-align: center;
            padding: 48px 20px 36px;
        }

        .logo-badge {
            width: 72px; height: 72px;
            background: white; color: #c62828;
            border-radius: 20px;
            display: flex; align-items: center; justify-content: center;
            font-size: 34px; font-weight: 700;
            margin: 0 auto 16px;
        }

        .hero h1 { font-size: 26px; font-weight: 700; margin-bottom: 6px; }
        .hero p { font-size: 14px; opacity: 0.9; max-width: 320px; margin: 0 auto; }

        /* ===== Area luar (merah full) ===== */
        .content-wrapper {
            flex: 1;
            background: #c62828;
            padding: 0 20px 48px;
            display: flex;
            justify-content: center;
        }

        /* Container tidak punya background putih lagi */
        .content {
            max-width: 960px;
            width: 100%;
            padding: 0;
        }

        .cards-wrapper {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* ===== Kartu putih saja ===== */
        .option-card {
            background: #ffffff;          /* Hanya ini yang putih */
            border: 1px solid #e0e0e0;
            border-radius: 16px;
            padding: 28px 20px 24px;
            text-align: center;
            display: block;
            transition: border-color .15s, transform .1s, box-shadow .15s;
            flex: 1;
        }
        .option-card:hover {
            border-color: #c62828;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.12);
        }

        .option-illustration {
            width: 160px; height: 160px;
            margin: 0 auto 16px;
            background: #fbdcdc;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            overflow: hidden;
        }
        .option-illustration img {
            width: 100%; height: 100%;
            object-fit: contain;
            padding: 12px;
        }

        .option-title {
            font-size: 19px; font-weight: 700;
            color: #c62828; margin-bottom: 4px;
        }
        .option-desc {
            font-size: 14px; color: var(--muted-foreground);
        }

        /* Desktop: sejajar */
        @media (min-width: 768px) {
            .cards-wrapper {
                flex-direction: row;
                gap: 28px;
            }
        }
    </style>
</head>
<body>

    <div class="hero">
        <div class="logo-badge">B</div>
        <h1>BrailleKita</h1>
        <p>Platform Buku Braille Sentra Wyata Guna Bandung</p>
    </div>

    <div class="content-wrapper">
        <div class="content">
            <div class="cards-wrapper">
                <a href="/login" class="option-card">
                    <div class="option-illustration">
                        <img src="{{ asset('images/pelanggan2.png') }}" alt="Ilustrasi Login Pelanggan">
                    </div>
                    <div class="option-title">Login Pelanggan</div>
                    <div class="option-desc">Klik untuk masuk ke halaman login customer</div>
                </a>

                <a href="/login-admin" class="option-card">
                    <div class="option-illustration">
                        <img src="{{ asset('images/Admin-bro.png') }}" alt="Ilustrasi Login Admin">
                    </div>
                    <div class="option-title">Login Admin</div>
                    <div class="option-desc">Klik untuk masuk ke halaman login admin</div>
                </a>
            </div>
        </div>
    </div>

</body>
</html>