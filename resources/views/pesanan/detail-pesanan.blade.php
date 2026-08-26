<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan - BrailleKita</title>
    <link href="https://fonts.googleapis.com/css2?family=Atkinson+Hyperlegible:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
   
    <style>
        :root {
            --background: #f8f8f8;
            --foreground: #111111;
            --card: #ffffff;
            --primary: #c62828;
            --primary-hover: #b71c1c;
            --muted: #eeeeee;
            --muted-foreground: #5a5a5a;
            --border: #d4d4d4;
            --success: #2e7d32;
            --warning: #e65100;
        }
        *, ::after, ::before { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            background-color: var(--background);
            color: var(--foreground);
            font-family: 'Atkinson Hyperlegible', system-ui, sans-serif;
            line-height: 1.6;
        }
        a { text-decoration: none; color: inherit; }

        .main-container {
            max-width: 1100px; margin: 0 auto; padding: 28px 20px 60px;
        }

        .page-header {
            display: flex; align-items: center; gap: 16px;
            margin-bottom: 28px; flex-wrap: wrap;
        }
        .page-title { font-size: 26px; font-weight: 700; }

        .badge {
            padding: 5px 12px; border-radius: 6px; font-size: 13px;
            font-weight: 700; border: 1px solid; display: inline-block;
        }
        .status-menunggu-diproses, .status-diproses {
            background: #fff3e0; color: #e65100; border-color: #ffb74d;
        }
        .status-dikirim {
            background: #e3f2fd; color: #1565c0; border-color: #64b5f6;
        }
        .status-pesanan-sampai {
            background: #e8f5e9; color: #2e7d32; border-color: #81c784;
        }
        .status-dibatalkan {
            background: #ffebee; color: #c62828; border-color: #ef9a9a;
        }

        /* Timeline Status */
        .status-tracker {
            background: white; border: 1px solid var(--border);
            border-radius: 12px; padding: 28px 24px; margin-bottom: 24px;
            overflow-x: auto;
        }
        .tracker-title {
            font-size: 16px; font-weight: 700; margin-bottom: 20px;
        }
        .tracker-row {
            display: flex; align-items: flex-start; min-width: 300px; max-width: 480px;
        }
        .tracker-step {
            flex: 1; display: flex; flex-direction: column;
            align-items: center; position: relative; text-align: center;
        }
        .tracker-dot {
            width: 32px; height: 32px; border-radius: 50%;
            background: var(--muted); border: 2px solid var(--border);
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; font-weight: 700; color: var(--muted-foreground);
            z-index: 2; flex-shrink: 0;
        }
        .tracker-step.done .tracker-dot {
            background: var(--success); border-color: var(--success); color: white;
        }
        .tracker-step.active .tracker-dot {
            background: var(--primary); border-color: var(--primary); color: white;
        }
        .tracker-line {
            position: absolute; top: 15px; left: -50%; width: 100%;
            height: 3px; background: var(--border); z-index: 1;
        }
        .tracker-step:first-child .tracker-line { display: none; }
        .tracker-step.done .tracker-line,
        .tracker-step.active .tracker-line { background: var(--success); }
        .tracker-label {
            font-size: 13px; font-weight: 700; margin-top: 10px;
            color: var(--muted-foreground); max-width: 110px; line-height: 1.3;
        }
        .tracker-step.done .tracker-label,
        .tracker-step.active .tracker-label { color: var(--foreground); }

        /* Grid Info */
        .info-grid {
            display: grid; grid-template-columns: 1fr 1fr; gap: 20px;
            margin-bottom: 24px;
        }

        .info-card {
            background: white; border: 1px solid var(--border);
            border-radius: 12px; padding: 24px;
        }
        .info-card h3 {
            font-size: 17px; font-weight: 700; margin-bottom: 16px;
            padding-bottom: 12px; border-bottom: 1px solid var(--border);
        }
        .info-row {
            display: flex; justify-content: space-between;
            padding: 8px 0; font-size: 15px; gap: 12px;
        }
        .info-label { color: var(--muted-foreground); flex-shrink: 0; }
        .info-value { font-weight: 700; text-align: right; word-break: break-word; }

        /* Daftar Buku */
        .books-card {
            background: white; border: 1px solid var(--border);
            border-radius: 12px; padding: 24px; margin-bottom: 24px;
            overflow-x: auto;
        }
        .books-card h3 {
            font-size: 17px; font-weight: 700; margin-bottom: 16px;
            padding-bottom: 12px; border-bottom: 1px solid var(--border);
        }
        .books-table { width: 100%; border-collapse: collapse; min-width: 450px; }
        .books-table th {
            text-align: left; font-size: 13px; color: var(--muted-foreground);
            font-weight: 700; padding: 10px 12px; background: #f5f5f5;
        }
        .books-table td {
            padding: 14px 12px; border-bottom: 1px solid var(--border);
            font-size: 15px;
        }
        .books-table tr:last-child td { border-bottom: none; }
        .text-right { text-align: right; }
        .text-success { color: var(--success); font-weight: 700; }
        .total-row td {
            background: #f5f5f5; font-weight: 700; padding: 14px 12px;
        }

        .btn-back {
            display: inline-block; margin-top: 8px;
            border: 1px solid var(--border); background: white;
            padding: 10px 20px; border-radius: 6px; font-weight: 700;
            font-size: 14px; cursor: pointer; font-family: inherit;
        }
        .btn-back:hover { background: var(--muted); }

        /* Responsive HP */
        @media (max-width: 700px) {
            .info-grid { grid-template-columns: 1fr; }
            .info-row { flex-direction: column; gap: 2px; }
            .info-value { text-align: left; }
            .page-title { font-size: 22px; }
        }
    </style>
</head>
<body>
    @php
        $tahapanStatus = ['Diproses', 'Dikirim', 'Pesanan Sampai'];
        $isDibatalkan = $pesanan->status === 'Dibatalkan';
        $indexSaatIni = array_search($pesanan->status, $tahapanStatus);
        if ($indexSaatIni === false) {
            $indexSaatIni = 0;
        }
        $slugStatus = 'status-' . \Illuminate\Support\Str::slug($pesanan->status);
    @endphp

    {{-- Memanggil Partial Navbar Universal --}}
    @include('partials.navbar')

    <main class="main-container">
        <div class="page-header">
            <h1 class="page-title">Detail Pesanan</h1>
            <span class="badge {{ $slugStatus }}">{{ $pesanan->status }}</span>
        </div>

        {{-- Timeline Status --}}
        @if(!$isDibatalkan)
            <div class="status-tracker">
                <div class="tracker-title">Status Pengiriman</div>
                <div class="tracker-row">
                    @foreach($tahapanStatus as $i => $tahap)
                        @php
                            $state = $i < $indexSaatIni ? 'done' : ($i === $indexSaatIni ? 'active' : '');
                        @endphp
                        <div class="tracker-step {{ $state }}">
                            <div class="tracker-line"></div>
                            <div class="tracker-dot">{{ $i < $indexSaatIni ? '✓' : $i + 1 }}</div>
                            <div class="tracker-label">{{ $tahap }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="status-tracker" style="background:#ffebee; border-color:#ef9a9a;">
                <div style="color:#c62828; font-weight:700;">
                    ✕ Pesanan ini telah dibatalkan.
                    @if($pesanan->alasan_pembatalan)
                        <br><span style="font-weight:400;">Alasan: {{ $pesanan->alasan_pembatalan }}</span>
                    @endif
                </div>
            </div>
        @endif

        {{-- Informasi + Alamat --}}
        <div class="info-grid">
            <div class="info-card">
                <h3>Informasi Pesanan</h3>
                <div class="info-row">
                    <span class="info-label">Nomor Pesanan</span>
                    <span class="info-value">{{ $pesanan->nomor_pesanan }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tanggal Pemesanan</span>
                    <span class="info-value">{{ $pesanan->tanggal_pemesanan }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Jenis Pemesanan</span>
                    <span class="info-value">{{ $pesanan->jenis_pesanan }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Status</span>
                    <span class="info-value">
                        <span class="badge {{ $slugStatus }}">{{ $pesanan->status }}</span>
                    </span>
                </div>
            </div>

            <div class="info-card">
                <h3>Alamat Pengiriman</h3>
                <div class="info-row">
                    <span class="info-label">Nama Penerima</span>
                    <span class="info-value">{{ $pesanan->nama_penerima ?? auth()->user()->nama }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Telepon</span>
                    <span class="info-value">{{ $pesanan->telepon ?? auth()->user()->nomor_telepon }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Alamat</span>
                    <span class="info-value">{{ $pesanan->alamat ?? auth()->user()->alamat }}</span>
                </div>
            </div>
        </div>

        {{-- Daftar Buku --}}
        <div class="books-card">
            <h3>Daftar Buku Dipesan</h3>
            <table class="books-table">
                <thead>
                    <tr>
                        <th>Judul Buku</th>
                        <th style="text-align:center;">Jumlah</th>
                        <th class="text-right">Biaya</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pesanan->details as $detail)
                        <tr>
                            <td>{{ $detail->buku->judul }}</td>
                            <td style="text-align:center;">{{ $detail->jumlah }} eksemplar</td>
                            <td class="text-right text-success">Gratis</td>
                        </tr>
                    @endforeach
                    <tr class="total-row">
                        <td colspan="2" class="text-right">Total Biaya</td>
                        <td class="text-right text-success">Rp0 (Gratis)</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <a href="/pesanan-saya" class="btn-back">← Kembali ke Pesanan Saya</a>
    </main>
</body>
</html>