<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan Buku - BrailleKita</title>
    <link href="https://fonts.googleapis.com/css2?family=Atkinson+Hyperlegible:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

    <style>
        :root {
            --background: #f8f8f8;
            --foreground: #111111;
            --primary: #c62828;
            --primary-hover: #b71c1c;
            --muted: #eeeeee;
            --muted-foreground: #5a5a5a;
            --border: #d4d4d4;
            --success: #2e7d32;
        }

        *, ::after, ::before { box-sizing: border-box; margin: 0; padding: 0; }
        body { background-color: var(--background); color: var(--foreground); font-family: 'Atkinson Hyperlegible', sans-serif; line-height: 1.6; }
        a { text-decoration: none; color: inherit; }

        .navbar { background: var(--primary); color: white; position: sticky; top: 0; z-index: 100; }
        .navbar-container { max-width: 1200px; margin: 0 auto; padding: 0 20px; display: flex; align-items: center; gap: 12px; min-height: 64px; }
        .nav-logo { background: white; color: var(--primary); font-weight: 700; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 6px; font-size: 18px; }
        .nav-brand { font-size: 20px; font-weight: 700; }
        .nav-spacer { flex-grow: 1; }
        .nav-link { padding: 8px 16px; border-radius: 6px; font-weight: 700; font-size: 15px; border: 1px solid transparent; display: flex; align-items: center; gap: 6px; }
        .nav-link.active { background-color: white; color: var(--primary); }
        .nav-link.outline { border-color: rgba(255, 255, 255, 0.4); }
        .nav-link.outline:hover { background-color: rgba(255, 255, 255, 0.1); }

        .main-container { max-width: 1200px; margin: 0 auto; padding: 40px 20px 60px 20px; }
        .page-title { font-size: 26px; font-weight: 700; margin-bottom: 24px; }

        /* Stepper */
        .stepper { display: flex; align-items: center; gap: 12px; margin-bottom: 28px; }
        .step-circle { width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px; flex-shrink: 0; }
        .step-circle.active { background: var(--primary); color: white; }
        .step-circle.inactive { background: var(--muted); color: var(--muted-foreground); }
        .step-label { font-weight: 700; font-size: 15px; }
        .step-label.inactive { color: var(--muted-foreground); font-weight: 400; }
        .step-line { flex-grow: 1; height: 2px; background: var(--border); max-width: 200px; }

        .order-layout { display: grid; grid-template-columns: 1fr 320px; gap: 28px; align-items: start; }

        .form-card { background: white; border: 1px solid var(--border); border-radius: 8px; padding: 28px; }
        .form-card h3 { font-size: 18px; font-weight: 700; margin-bottom: 4px; }
        .form-card p.desc { color: var(--muted-foreground); font-size: 14px; margin-bottom: 20px; }

        .form-label { font-weight: 700; font-size: 15px; margin-bottom: 12px; display: block; }
        .form-label .required { color: var(--primary); }

        .option-card { display: flex; gap: 12px; align-items: flex-start; border: 1px solid var(--border); border-radius: 8px; padding: 16px; margin-bottom: 12px; cursor: pointer; transition: border-color .15s, background-color .15s; }
        .option-card:hover { border-color: var(--primary); }
        .option-card.selected { border-color: var(--primary); background: #fdecea; }
        .option-card input[type="radio"] { margin-top: 3px; accent-color: var(--primary); width: 18px; height: 18px; flex-shrink: 0; }
        .option-title { font-weight: 700; font-size: 16px; margin-bottom: 2px; }
        .option-desc { color: var(--muted-foreground); font-size: 14px; }

        .form-actions { display: flex; justify-content: space-between; align-items: center; margin-top: 24px; }
        .btn-back { background: white; color: var(--foreground); border: 1px solid var(--border); padding: 12px 20px; border-radius: 6px; font-weight: 700; font-size: 15px; cursor: pointer; font-family: inherit; }
        .btn-back:hover { background: var(--muted); }
        .btn-next { background: var(--primary); color: white; border: none; padding: 12px 24px; border-radius: 6px; font-weight: 700; font-size: 15px; cursor: pointer; font-family: inherit; }
        .btn-next:hover { background: var(--primary-hover); }

        .summary-card { background: white; border: 1px solid var(--border); border-radius: 8px; padding: 24px; position: sticky; top: 88px; }
        .summary-title { font-size: 18px; font-weight: 700; margin-bottom: 20px; }
        .summary-item { display: flex; justify-content: space-between; font-size: 15px; margin-bottom: 12px; color: var(--muted-foreground); }
        .summary-item strong { color: var(--success); font-weight: 700; }
        .summary-divider { border-bottom: 1px solid var(--border); margin: 16px 0; }
        .summary-total { display: flex; justify-content: space-between; font-size: 15px; margin-bottom: 8px; }
        .summary-total strong { color: var(--success); }
        .summary-note { background: var(--muted); border-radius: 6px; padding: 12px; font-size: 14px; font-weight: 700; margin-top: 8px; }

        @media (max-width: 768px) {
            .order-layout { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <header class="navbar">
        <div class="navbar-container">
            <div class="nav-logo">B</div>
            <a href="/" class="nav-brand">BrailleKita</a>
            <div class="nav-spacer"></div>
            <a href="/" class="nav-link outline">Katalog</a>
            <a href="/pesanan-saya" class="nav-link outline">Pesanan Saya</a>
            <a href="/keranjang" class="nav-link active">Keranjang</a>
        </div>
    </header>

    <main class="main-container">
        <h1 class="page-title">Pemesanan Buku</h1>

        <div class="stepper">
            <div class="step-circle active">1</div>
            <span class="step-label">Jenis Pemesanan</span>
            <div class="step-line"></div>
            <div class="step-circle inactive">2</div>
            <span class="step-label inactive">Alamat Pengiriman</span>
        </div>

        <form action="/pemesanan/jenis" method="POST">
            @csrf
            <div class="order-layout">
                <div class="form-card">
                    <h3>Pilih jenis Pemesanan</h3>
                    <p class="desc">Pilih jenis yang sesuai dengan kebutuhan Anda.</p>

                    <label class="form-label">Jenis Pemesanan <span class="required">*</span></label>

                    <label class="option-card {{ $jenisTerpilih === 'Pribadi' ? 'selected' : '' }}">
                        <input type="radio" name="jenis_pesanan" value="Pribadi" {{ $jenisTerpilih === 'Pribadi' ? 'checked' : '' }}>
                        <div>
                            <div class="option-title">Pribadi</div>
                            <div class="option-desc">Pemesanan untuk kebutuhan pribadi.</div>
                        </div>
                    </label>

                    <label class="option-card {{ $jenisTerpilih === 'Lembaga' ? 'selected' : '' }}">
                        <input type="radio" name="jenis_pesanan" value="Lembaga" {{ $jenisTerpilih === 'Lembaga' ? 'checked' : '' }}>
                        <div>
                            <div class="option-title">Lembaga</div>
                            <div class="option-desc">Sekolah, yayasan atau lembaga pendidikan.</div>
                        </div>
                    </label>

                    <label class="option-card {{ $jenisTerpilih === 'Organisasi' ? 'selected' : '' }}">
                        <input type="radio" name="jenis_pesanan" value="Organisasi" {{ $jenisTerpilih === 'Organisasi' ? 'checked' : '' }}>
                        <div>
                            <div class="option-title">Organisasi</div>
                            <div class="option-desc">Organisasi disabilitas atau komunitas resmi.</div>
                        </div>
                    </label>

                    <div class="form-actions">
                        <a href="/keranjang" class="btn-back">&larr; Kembali ke keranjang</a>
                        <button type="submit" class="btn-next">Lanjutkan &rarr;</button>
                    </div>
                </div>

                <div class="summary-card">
                    <h3 class="summary-title">Ringkasan Pesanan</h3>
                    @foreach($daftarKeranjang as $item)
                        <div class="summary-item">
                            <span>{{ $item->buku->judul }}</span>
                            <strong>Gratis</strong>
                        </div>
                    @endforeach
                    <div class="summary-divider"></div>
                    <div class="summary-total">
                        <span>Total Buku</span>
                        <span>{{ $daftarKeranjang->sum('jumlah') }} eksemplar</span>
                    </div>
                    <div class="summary-total">
                        <span>Total Biaya</span>
                        <strong>Rp0</strong>
                    </div>
                    <div class="summary-note">Jenis: {{ $jenisTerpilih }}</div>
                </div>
            </div>
        </form>
    </main>

    <script>
        // Highlight kartu radio yang dipilih secara live
        document.querySelectorAll('.option-card input[type="radio"]').forEach(function (radio) {
            radio.addEventListener('change', function () {
                document.querySelectorAll('.option-card').forEach(function (card) {
                    card.classList.remove('selected');
                });
                this.closest('.option-card').classList.add('selected');
            });
        });
    </script>
</body>
</html>
