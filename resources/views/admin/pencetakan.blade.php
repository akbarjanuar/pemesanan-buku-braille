<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencetakan - BrailleKita</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary: #c62828; --primary-hover: #b71c1c; --surface: #ffffff; --text-dark: #111111; --text-muted: #757575; --border: #e0e0e0; --background: #f4f6f9; --success: #2e7d32; --warning: #d35400; }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: sans-serif; background: var(--background); color: var(--text-dark); }

        .menu-toggle { display: inline-flex; align-items: center; justify-content: center; width: 24px; height: 24px; color: var(--text-muted); background: none; border: none; cursor: pointer; font-size: 20px; }
        .topbar-title { font-size: 20px; font-weight: 900; font-family: 'Georgia', serif; color: var(--text-dark); margin-left: 10px; }
        .content-area { padding: 32px; flex-grow: 1; overflow-y: auto; }

        /* =========================================
            HALAMAN PENCETAKAN
        ========================================= */
        .page-header { margin-bottom: 16px; }
        .page-header h2 { font-size: 20px; font-weight: 700; margin-bottom: 4px; }
        .page-header p { color: var(--text-muted); font-size: 13px; }

        /* =========================================
            FILTER STATUS
        ========================================= */
        .filter-bar { margin-bottom: 16px; }
        .status-dropdown { position: relative; display: inline-block; }
        .status-dropdown-btn {
            min-width: 150px; background: var(--surface); border: 1px solid var(--border);
            border-radius: 8px; padding: 9px 14px; font-family: inherit; font-size: 14px; font-weight: 700;
            cursor: pointer; display: flex; align-items: center; justify-content: space-between; gap: 16px; color: var(--text-dark);
        }
        .status-dropdown-btn:hover { border-color: var(--primary); }
        .status-dropdown-menu {
            display: none; position: absolute; top: calc(100% + 6px); left: 0; width: 220px;
            background: var(--surface); border: 1px solid var(--border); border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.12); overflow: hidden; z-index: 100;
        }
        .status-dropdown-menu.open { display: block; }
        .status-filter-item { display: block; padding: 11px 14px; font-size: 13px; font-weight: 700; color: var(--text-dark); text-decoration: none; }
        .status-filter-item:hover { background: #f5f5f5; }
        .status-filter-item.active { background: var(--primary); color: white; }

        /* =========================================
            PRINT LIST & CARD
        ========================================= */
        .printing-list { display: flex; flex-direction: column; gap: 14px; }
        .printing-card { background: var(--surface); border: 1px solid var(--border); border-radius: 10px; padding: 16px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04); }

        .card-top { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 8px; }
        .book-type { display: inline-block; padding: 4px 9px; border-radius: 5px; border: 1px solid var(--border); color: var(--text-muted); font-size: 10px; font-weight: 700; text-transform: uppercase; }
        
        .status-area { text-align: right; }
        .print-status { font-size: 11px; font-weight: 700; margin-bottom: 6px; }
        .status-menunggu { color: var(--warning); }
        .status-selesai { color: var(--success); }

        .btn-detail {
            display: inline-block; background: var(--primary); color: white; border: none;
            border-radius: 4px; padding: 5px 10px; font-family: inherit; font-size: 11px; font-weight: 700; cursor: pointer; text-decoration: none;
        }
        .btn-detail:hover { background: var(--primary-hover); }

        .book-code { font-size: 16px; font-weight: 800; margin-bottom: 4px; font-family: 'Georgia', serif; }
        .book-title { color: var(--text-muted); font-size: 13px; margin-bottom: 4px; }
        .order-number { color: var(--text-muted); font-size: 11px; margin-bottom: 14px; }

        /* =========================================
            INFO GRID
        ========================================= */
        .printing-info { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 14px; }
        .info-item { display: flex; flex-direction: column; gap: 4px; }
        .info-label { font-size: 11px; color: var(--text-muted); }
        .info-value { font-size: 13px; font-weight: 700; }

        /* =========================================
            PROGRESS
        ========================================= */
        .progress-info { display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px; font-size: 11px; color: var(--text-muted); }
        .progress-percent { color: var(--text-dark); font-weight: 700; }
        .progress-bar { width: 100%; height: 10px; background: #e8e8e8; border-radius: 20px; overflow: hidden; }
        .progress-fill { height: 100%; border-radius: 20px; background: var(--primary); transition: width 0.3s ease; }
        .progress-fill.completed { background: var(--success); }

        @media (max-width: 700px) {
            .printing-info { grid-template-columns: 1fr; gap: 12px; }
            .card-top { gap: 10px; }
            .content-area { padding: 20px 16px; }
        }
    </style>
</head>

<body>

    {{-- SIDEBAR --}}
    @include('partials.admin-nav', ['activeMenu' => 'pencetakan'])

    {{-- MAIN CONTENT --}}
    <div class="main-wrapper">

        {{-- TOPBAR --}}
        <header class="topbar">
            <div class="topbar-left">
                <button type="button" class="menu-toggle">
                    <i class="fas fa-bars"></i>
                </button>
                <span class="topbar-title">Pencetakan</span>
            </div>

            <div class="topbar-right">
                <i class="far fa-bell notification-bell"></i>
                <div class="user-profile">
                    <span>{{ auth()->user()->nama ?? 'Admin' }}</span>
                    <i class="fas fa-user-circle"></i>
                </div>
            </div>
        </header>

        {{-- CONTENT --}}
        <main class="content-area">

            {{-- PAGE HEADER --}}
            <div class="page-header">
                <h2>Monitoring Pencetakan</h2>
                <p>Pemantauan semua kegiatan pencetakan buku braille.</p>
            </div>

            {{-- FILTER --}}
            <div class="filter-bar">
                <div class="status-dropdown" id="statusDropdown">
                    <button type="button" class="status-dropdown-btn" id="statusDropdownBtn">
                        <span id="statusDropdownLabel">Semua Status</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>

                    <div class="status-dropdown-menu" id="statusDropdownMenu">
                        <a href="#" class="status-filter-item active" data-status="semua">Semua Status</a>
                        <a href="#" class="status-filter-item" data-status="Menunggu Bahan">Menunggu Bahan</a>
                        <a href="#" class="status-filter-item" data-status="Sedang Diproses">Sedang Diproses</a>
                        <a href="#" class="status-filter-item" data-status="Menunggu Pemeriksaan">Menunggu Pemeriksaan</a>
                        <a href="#" class="status-filter-item" data-status="Selesai">Selesai</a>
                    </div>
                </div>
            </div>

            {{-- LIST PENCAKETAN (DINAMIS DARI DATABASE) --}}
            <div class="printing-list">
                @forelse($daftarPencetakan as $cetak)
                    @php
                        $persentase = $cetak->target_buku > 0 ? round(($cetak->buku_selesai / $cetak->target_buku) * 100) : 0;
                        $bukuPesanan = $cetak->pesanan->details->first();
                        // Format status untuk pencocokan filter JavaScript
                        $statusRaw = $cetak->status; 
                    @endphp

                    <div class="printing-card" data-status="{{ $statusRaw }}">
                        <div class="card-top">
                            <span class="book-type">{{ $cetak->jenis_literasi }}</span>

                            <div class="status-area">
                                <div class="print-status {{ $cetak->status == 'Selesai' ? 'status-selesai' : 'status-menunggu' }}">
                                    {{ $cetak->status }}
                                </div>
                                <a href="{{ route('admin.detail-pesanan', $cetak->pesanan_id) }}" class="btn-detail">
                                    Lihat detail
                                </a>
                            </div>
                        </div>

                        <div class="book-code">
                            {{ $cetak->kode_cetak }}
                        </div>

                        <div class="book-title">
                            {{ $bukuPesanan->buku->judul ?? 'Judul Buku' }} &middot; {{ $bukuPesanan->jumlah ?? 1 }} eksemplar
                        </div>

                        <div class="order-number">
                            Pesanan: WYG-{{ date('Y', strtotime($cetak->pesanan->created_at)) }}-{{ str_pad($cetak->pesanan->id, 4, '0', STR_PAD_LEFT) }}
                        </div>

                        <div class="printing-info">
                            <div class="info-item">
                                <span class="info-label">PIC</span>
                                <span class="info-value">{{ $cetak->pic }}</span>
                            </div>

                            <div class="info-item">
                                <span class="info-label">Target</span>
                                <span class="info-value">{{ $cetak->target_buku }} buku</span>
                            </div>

                            <div class="info-item">
                                <span class="info-label">Deadline</span>
                                <span class="info-value">
                                    {{ $cetak->deadline ? \Carbon\Carbon::parse($cetak->deadline)->translatedFormat('j F Y') : '-' }}
                                </span>
                            </div>
                        </div>

                        <div class="progress-info">
                            <span>{{ $cetak->buku_selesai }} dari {{ $cetak->target_buku }} buku selesai</span>
                            <span class="progress-percent">{{ $persentase }}%</span>
                        </div>

                        <div class="progress-bar">
                            <div class="progress-fill {{ $persentase == 100 ? 'completed' : '' }}" style="width: {{ $persentase }}%;"></div>
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; padding: 40px; background: var(--surface); border: 1px solid var(--border); border-radius: 10px;">
                        <p style="color: var(--text-muted);">Belum ada data proses pencetakan buku di database.</p>
                    </div>
                @endforelse
            </div>

        </main>
    </div>

    {{-- JAVASCRIPT FILTER --}}
    <script>
        (function () {
            var btn = document.getElementById('statusDropdownBtn');
            var menu = document.getElementById('statusDropdownMenu');
            var label = document.getElementById('statusDropdownLabel');
            var items = document.querySelectorAll('.status-filter-item');
            var cards = document.querySelectorAll('.printing-card');

            btn.addEventListener('click', function () {
                menu.classList.toggle('open');
            });

            document.addEventListener('click', function (e) {
                var dropdown = document.getElementById('statusDropdown');
                if (!dropdown.contains(e.target)) {
                    menu.classList.remove('open');
                }
            });

            items.forEach(function (item) {
                item.addEventListener('click', function (e) {
                    e.preventDefault();
                    var status = this.dataset.status;

                    items.forEach(function (el) {
                        el.classList.remove('active');
                    });

                    this.classList.add('active');
                    label.textContent = this.textContent;
                    menu.classList.remove('open');

                    cards.forEach(function (card) {
                        if (status === 'semua' || card.dataset.status === status) {
                            card.style.display = '';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            });
        })();
    </script>

</body>

</html>