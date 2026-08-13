<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Saya - BrailleKita</title>
    <link href="https://fonts.googleapis.com/css2?family=Atkinson+Hyperlegible:ital,wght@0,700;1,400;1,700&display=swap" rel="stylesheet">
    
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
            --warning: #e65100;
        }

        *, ::after, ::before { box-sizing: border-box; margin: 0; padding: 0; }
        body { background-color: var(--background); color: var(--foreground); font-family: 'Atkinson Hyperlegible', sans-serif; line-height: 1.6; }
        a { text-decoration: none; color: inherit; }

        .navbar { background: var(--primary); color: white; position: sticky; top: 0; z-index: 100; }
        .navbar-container { max-width: 1200px; margin: 0 auto; padding: 0 20px; display: flex; align-items: center; gap: 12px; min-height: 64px; }
        .nav-logo { background: white; color: var(--primary); font-weight: 700; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 6px; font-size: 18px; }
        .nav-brand { font-size: 20px; font-weight: 700; }
        .nav-spacer { flex-grow: 1; }
        .nav-link { padding: 8px 16px; border-radius: 6px; font-weight: 700; font-size: 15px; transition: 0.2s; border: 1px solid transparent; }
        .nav-link.active { background-color: white; color: var(--primary); }
        .nav-link.outline { border-color: rgba(255, 255, 255, 0.4); }
        .nav-link.outline:hover { background-color: rgba(255, 255, 255, 0.1); }

        .main-container { max-width: 1200px; margin: 0 auto; padding: 24px 20px 60px 20px; }
        
        .header-flex { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
        .page-title { font-size: 28px; font-weight: 700; }
        .btn-outline-primary { border: 2px solid var(--primary); color: var(--primary); padding: 8px 16px; border-radius: 6px; font-weight: 700; background: white; cursor: pointer; font-family: inherit; font-size: 14px; }
        .btn-outline-primary:hover { background: var(--primary); color: white; }

        .empty-state {
            text-align: center;
            padding: 80px 20px;
            border: 2px dashed var(--border);
            border-radius: 12px;
            background: rgb(255, 255, 255);
        }
        .empty-state h3 { font-size: 24px; font-weight: 700; margin: 16px 0 8px; }
        .empty-state p { color: var(--muted-foreground); margin-bottom: 24px; max-width: 500px; margin-left: auto; margin-right: auto; }
        .btn-primary { background: var(--primary); color: white; padding: 12px 24px; border-radius: 6px; font-weight: 700; display: inline-block; border: none; cursor: pointer; }

        .filter-tabs { display: flex; gap: 10px; margin-bottom: 24px; flex-wrap: wrap; }
        .tab-btn { padding: 8px 16px; border-radius: 20px; font-weight: 700; font-size: 13px; border: 1px solid var(--border); background: white; cursor: pointer; font-family: inherit; white-space: nowrap; }
        .tab-btn.active { background: var(--primary); color: white; border-color: var(--primary); }

        .order-list { display: flex; flex-direction: column; gap: 16px; }
        
        .order-card {
            background: rgb(255, 255, 255);
            border: 2px solid var(--primary);
            border-radius: 10px;
            padding: 20px 24px;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .order-header { display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 8px; }
        .order-id { font-weight: 700; font-size: 16px; margin-right: 12px; }
        
        .badge { padding: 4px 10px; border-radius: 4px; font-size: 12px; font-weight: 700; margin-right: 8px; border: 1px solid; display: inline-block; }
        .badge-gray { background: #f5f5f5; color: #616161; border-color: #e0e0e0; }

        .status-diproses        { background: #fff3e0; color: #e65100; border-color: #ffb74d; }
        .status-menunggu-diproses { background: #fff3e0; color: #e65100; border-color: #ffb74d; }
        .status-dikirim         { background: #e3f2fd; color: #1565c0; border-color: #64b5f6; }
        .status-pesanan-sampai  { background: #e8f5e9; color: #2e7d32; border-color: #81c784; }
        .status-dibatalkan      { background: #ffebee; color: #c62828; border-color: #ef9a9a; }

        .order-date { font-size: 14px; color: var(--muted-foreground); margin-top: -6px; }
        
        .total-box { text-align: right; }
        .total-label { font-size: 13px; color: var(--muted-foreground); }
        .total-value { font-size: 18px; font-weight: 700; color: var(--success); }

        .status-tracker { padding: 20px 8px 8px 8px; overflow-x: auto; }
        .tracker-row { display: flex; align-items: flex-start; min-width: 320px; max-width: 420px; }
        .tracker-step { flex: 1; display: flex; flex-direction: column; align-items: center; position: relative; text-align: center; }
        .tracker-dot {
            width: 30px; height: 30px; border-radius: 50%;
            background: var(--muted); border: 2px solid var(--border);
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; font-weight: 700; color: var(--muted-foreground);
            z-index: 2; flex-shrink: 0;
        }
        .tracker-step.done .tracker-dot { background: var(--success); border-color: var(--success); color: white; }
        .tracker-step.active .tracker-dot { background: var(--primary); border-color: var(--primary); color: white; }

        .tracker-line { position: absolute; top: 15px; left: -50%; width: 100%; height: 3px; background: var(--border); z-index: 1; }
        .tracker-step:first-child .tracker-line { display: none; }
        .tracker-step.done .tracker-line, .tracker-step.active .tracker-line { background: var(--success); }

        .tracker-label { font-size: 12px; font-weight: 700; margin-top: 8px; color: var(--muted-foreground); max-width: 100px; line-height: 1.3; }
        .tracker-step.done .tracker-label, .tracker-step.active .tracker-label { color: var(--foreground); }

        .cancelled-note { background: #ffebee; color: #c62828; border: 1px solid #ef9a9a; border-radius: 6px; padding: 10px 14px; font-size: 14px; font-weight: 700; }

        .order-items { border-top: 1px solid var(--border); border-bottom: 1px solid var(--border); padding: 16px 0; }
        
        .order-actions { display: flex; gap: 12px; }
        .btn-outline-gray { border: 1px solid var(--border); background: white; padding: 8px 16px; border-radius: 6px; font-weight: 700; cursor: pointer; font-family: inherit; font-size: 14px; }
    </style>
</head>
<body>

    @php
        $tahapanStatus = [
            'Diproses',
            'Dikirim',
            'Pesanan Sampai',
        ];

        $slugStatus = function ($status) {
            return 'status-' . \Illuminate\Support\Str::slug($status);
        };
    @endphp

    <header class="navbar">
        <div class="navbar-container">
            <div class="nav-logo">B</div>
            <a href="/" class="nav-brand">BrailleKita</a>
            <div class="nav-spacer"></div>
            
            <a href="/" class="nav-link {{ request()->is('/') ? 'active' : 'outline' }}">Katalog</a>
            <a href="/pesanan-saya" class="nav-link {{ request()->is('pesanan-saya') ? 'active' : 'outline' }}">Pesanan Saya</a>
            <a href="/keranjang" class="nav-link {{ request()->is('keranjang') ? 'active' : 'outline' }}">Keranjang</a>
            
            <span style="margin: 0 8px; font-size: 15px;">Halo, {{ auth()->user()->nama ?? 'Pengguna' }}</span>
            <form action="/logout" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="nav-link outline" style="background:transparent; cursor:pointer; font-family: inherit; color: white;">Keluar</button>
            </form>
        </div>
    </header>

    <main class="main-container">
        
        <div class="header-flex">
            <h1 class="page-title">Pesanan Saya</h1>
            @if($daftarPesanan->isNotEmpty())
                <a href="/" class="btn-outline-primary">Pesan Lagi</a>
            @endif
        </div>

        @if($daftarPesanan->isEmpty())
            <div class="empty-state">
                <div style="font-size: 64px;">📦</div>
                <h3>Belum Ada Pesanan</h3>
                <p>Anda belum melakukan pemesanan buku. Silakan jelajahi katalog dan pilih buku yang Anda butuhkan.</p>
                <a href="/" class="btn-primary">Lihat Katalog Buku</a>
            </div>
        @else
            <div class="filter-tabs">
                <button class="tab-btn active" data-filter="semua">Semua ({{ $daftarPesanan->count() }})</button>
                @foreach($tahapanStatus as $status)
                    <button class="tab-btn" data-filter="{{ $slugStatus($status) }}">
                        {{ $status }} ({{ $daftarPesanan->where('status', $status)->count() }})
                    </button>
                @endforeach
                <button class="tab-btn" data-filter="status-dibatalkan">
                    Dibatalkan ({{ $daftarPesanan->where('status', 'Dibatalkan')->count() }})
                </button>
            </div>

            <div class="order-list">
                @foreach($daftarPesanan as $pesanan)
                    @php
                        $isDibatalkan = $pesanan->status === 'Dibatalkan';
                        $indexSaatIni = array_search($pesanan->status, $tahapanStatus);
                        if ($indexSaatIni === false) { $indexSaatIni = 0; }
                    @endphp

                    <div class="order-card" data-status="{{ $isDibatalkan ? 'status-dibatalkan' : $slugStatus($pesanan->status) }}">
                        <div class="order-header">
                            <div>
                                <span class="order-id">{{ $pesanan->nomor_pesanan }}</span>
                                <span class="badge {{ $isDibatalkan ? 'status-dibatalkan' : $slugStatus($pesanan->status) }}">{{ $pesanan->status }}</span>
                                <span class="badge badge-gray">{{ $pesanan->jenis_pesanan }}</span>
                            </div>
                            <div class="total-box">
                                <div class="total-label">Total Biaya</div>
                                <div class="total-value">Gratis (Rp0)</div>
                            </div>
                        </div>
                        
                        <div class="order-date">Tanggal Pemesanan: {{ $pesanan->tanggal_pemesanan }}</div>

                        @if($isDibatalkan)
                            <div class="cancelled-note">
                                ✕ Pesanan ini telah dibatalkan.
                                @if($pesanan->alasan_pembatalan)
                                    <br>Alasan: {{ $pesanan->alasan_pembatalan }}
                                @endif
                            </div>
                        @else
                            <div class="status-tracker">
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
                        @endif
                        
                        <div class="order-items">
                            @foreach($pesanan->details as $detail)
                                <div><strong>{{ $detail->buku->judul }}</strong> — {{ $detail->jumlah }} eksemplar</div>
                            @endforeach
                        </div>
                        
                        <div class="order-actions">
                            <button class="btn-outline-primary">Lihat Detail</button>
                            @if(!$isDibatalkan && in_array($pesanan->status, ['Diproses', 'Menunggu Diproses']))
                                <a href="/pesanan/{{ $pesanan->id }}/batalkan" class="btn-outline-gray" style="display:flex; align-items:center; text-decoration:none;">Batalkan Pesanan</a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </main>

    <script>
        const tabButtons = document.querySelectorAll('.tab-btn');
        const orderCards = document.querySelectorAll('.order-card');

        tabButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                tabButtons.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');

                const filter = btn.dataset.filter;

                orderCards.forEach(card => {
                    if (filter === 'semua' || card.dataset.status === filter) {
                        card.style.display = 'flex';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    </script>

</body>
</html>