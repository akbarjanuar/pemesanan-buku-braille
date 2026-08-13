<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Batalkan Pesanan - BrailleKita</title>
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
        }

        *, ::after, ::before { box-sizing: border-box; margin: 0; padding: 0; }
        body { background-color: var(--background); color: var(--foreground); font-family: 'Atkinson Hyperlegible', sans-serif; line-height: 1.6; }
        a { text-decoration: none; color: inherit; }

        .navbar { background: var(--primary); color: white; position: sticky; top: 0; z-index: 100; }
        .navbar-container { max-width: 1200px; margin: 0 auto; padding: 0 20px; display: flex; align-items: center; gap: 12px; min-height: 64px; }
        .nav-logo { background: white; color: var(--primary); font-weight: 700; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 6px; font-size: 18px; }
        .nav-brand { font-size: 20px; font-weight: 700; }
        .nav-spacer { flex-grow: 1; }
        .nav-link { padding: 8px 16px; border-radius: 6px; font-weight: 700; font-size: 15px; border: 1px solid transparent; }
        .nav-link.active { background-color: white; color: var(--primary); }
        .nav-link.outline { border-color: rgba(255, 255, 255, 0.4); }

        .main-container { max-width: 560px; margin: 0 auto; padding: 32px 20px 60px 20px; }
        .back-link { color: var(--primary); font-weight: 700; font-size: 15px; display: inline-block; margin-bottom: 20px; }

        .confirm-card { background: white; border: 1px solid var(--border); border-radius: 12px; padding: 32px; }

        .warning-icon {
            width: 56px; height: 56px; border-radius: 50%;
            background: #fde8e8; color: var(--primary);
            display: flex; align-items: center; justify-content: center;
            font-size: 26px; font-weight: 700; margin: 0 auto 20px auto;
        }

        .confirm-text { text-align: center; font-size: 15px; margin-bottom: 24px; }
        .confirm-text strong { font-weight: 700; }

        .reason-list { display: flex; flex-direction: column; gap: 10px; margin-bottom: 20px; }
        .reason-item {
            display: flex; align-items: center; gap: 12px;
            border: 1px solid var(--border); border-radius: 8px;
            padding: 14px 16px; cursor: pointer; font-size: 15px;
            transition: border-color .15s, background-color .15s;
        }
        .reason-item:hover { border-color: var(--primary); }
        .reason-item.selected { border-color: var(--primary); background: #fdecea; font-weight: 700; }
        .reason-item input[type="radio"] { accent-color: var(--primary); width: 18px; height: 18px; flex-shrink: 0; }

        .textarea-group { margin-bottom: 24px; }
        .textarea-group label { font-weight: 700; font-size: 14px; margin-bottom: 8px; display: block; }
        .textarea-group .required { color: var(--primary); }
        .textarea-group textarea {
            width: 100%; border: 1px solid var(--border); border-radius: 8px;
            padding: 12px 14px; font-size: 14px; font-family: inherit; resize: vertical;
        }
        .textarea-group textarea:focus { outline: none; border-color: var(--primary); }
        .error-text { color: var(--primary); font-size: 13px; margin-top: 4px; }

        .confirm-actions { display: flex; gap: 12px; }
        .btn-cancel-action { flex: 1; background: white; color: var(--foreground); border: 1px solid var(--border); padding: 12px; border-radius: 8px; font-weight: 700; font-size: 15px; cursor: pointer; font-family: inherit; }
        .btn-cancel-action:hover { background: var(--muted); }
        .btn-confirm-cancel { flex: 1; background: var(--primary); color: white; border: none; padding: 12px; border-radius: 8px; font-weight: 700; font-size: 15px; cursor: pointer; font-family: inherit; }
        .btn-confirm-cancel:hover { background: var(--primary-hover); }
    </style>
</head>
<body>

    <header class="navbar">
        <div class="navbar-container">
            <div class="nav-logo">B</div>
            <a href="/" class="nav-brand">BrailleKita</a>
            <div class="nav-spacer"></div>
            <a href="/" class="nav-link outline">Katalog</a>
            <a href="/pesanan-saya" class="nav-link active">Pesanan Saya</a>
            <a href="/keranjang" class="nav-link outline">Keranjang</a>
        </div>
    </header>

    <main class="main-container">
        <a href="/pesanan-saya" class="back-link">&larr; Kembali</a>

        <div class="confirm-card">
            <div class="warning-icon">&#9888;</div>

            <div class="confirm-text">
                Apakah Anda yakin ingin membatalkan pesanan
                <strong>{{ $pesanan->nomor_pesanan }}</strong>?
                Tindakan ini tidak dapat diurungkan.
            </div>

            <form action="/pesanan/{{ $pesanan->id }}/batalkan" method="POST" id="formBatalkan">
                @csrf

                <div class="reason-list" id="reasonList">
                    @php
                        $daftarAlasan = [
                            'Salah memilih buku',
                            'Salah jumlah buku',
                            'Salah alamat atau ingin mengubah alamat',
                            'Data penerima salah',
                            'Tidak jadi melakukan pesanan',
                            'Alasan lainnya',
                        ];
                    @endphp

                    @foreach($daftarAlasan as $alasan)
                        <label class="reason-item">
                            <input type="radio" name="alasan" value="{{ $alasan }}" {{ old('alasan') === $alasan ? 'checked' : '' }} required>
                            {{ $alasan }}
                        </label>
                    @endforeach
                </div>
                @error('alasan') <div class="error-text" style="margin-bottom: 16px;">{{ $message }}</div> @enderror

                <div class="textarea-group" id="alasanLainnyaGroup" style="display:none;">
                    <label>Tuliskan alasan Anda <span class="required">*</span></label>
                    <textarea name="alasan_lainnya" rows="3" placeholder="Ceritakan alasan pembatalan Anda...">{{ old('alasan_lainnya') }}</textarea>
                    @error('alasan_lainnya') <div class="error-text">{{ $message }}</div> @enderror
                </div>

                <div class="confirm-actions">
                    <a href="/pesanan-saya" class="btn-cancel-action" style="display:flex; align-items:center; justify-content:center;">Jangan Batalkan</a>
                    <button type="submit" class="btn-confirm-cancel">Ya, Batalkan Pesanan</button>
                </div>
            </form>
        </div>
    </main>

    <script>
        const radios = document.querySelectorAll('input[name="alasan"]');
        const reasonItems = document.querySelectorAll('.reason-item');
        const alasanLainnyaGroup = document.getElementById('alasanLainnyaGroup');
        const textareaLainnya = alasanLainnyaGroup.querySelector('textarea');

        function updateUI() {
            reasonItems.forEach(item => {
                const radio = item.querySelector('input[type="radio"]');
                item.classList.toggle('selected', radio.checked);
            });

            const dipilih = document.querySelector('input[name="alasan"]:checked');
            const isLainnya = dipilih && dipilih.value === 'Alasan lainnya';

            alasanLainnyaGroup.style.display = isLainnya ? 'block' : 'none';
            textareaLainnya.required = isLainnya;
        }

        radios.forEach(radio => radio.addEventListener('change', updateUI));
        updateUI();
    </script>

</body>
</html>