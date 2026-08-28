<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permintaan Buku - BrailleKita</title>
    
    <!-- Ikon FontAwesome (Jika tidak di-load di layout utama) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* ===== HAMBURGER MENU ===== */
        .menu-toggle { display: inline-flex !important; align-items: center; justify-content: center; width: 24px; height: 24px; padding: 0; color: var(--text-muted); background: none; border: none; cursor: pointer; font-size: 20px; flex-shrink: 0; }
        .menu-toggle:hover { color: var(--primary); }

        /* ===== PAGE HEADER ===== */
        .page-header { margin-bottom: 20px; }
        .page-header h2 { font-size: 22px; font-weight: 700; margin-bottom: 4px; }
        .page-header p { color: var(--text-muted); font-size: 14px; }

        /* ===== FILTER ===== */
        .filter-bar { margin-bottom: 20px; }
        .status-dropdown { position: relative; display: inline-block; }
        .status-dropdown-btn { background: var(--surface); border: 1px solid var(--border); border-radius: 8px; padding: 10px 16px; font-family: inherit; font-size: 14px; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 10px; color: var(--text-dark); }
        .status-dropdown-btn:hover { border-color: var(--primary); }
        .status-dropdown-menu { display: none; position: absolute; top: calc(100% + 6px); left: 0; background: var(--surface); border: 1px solid var(--border); border-radius: 8px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); min-width: 200px; z-index: 10; overflow: hidden; }
        .status-dropdown-menu.open { display: block; }
        .status-dropdown-menu a { display: block; padding: 10px 16px; font-size: 14px; font-weight: 700; color: var(--text-dark); text-decoration: none;}
        .status-dropdown-menu a:hover { background: #f5f5f5; }
        .status-dropdown-menu a.active { background: var(--primary); color: white; }

        /* ===== TABLE ===== */
        .table-card { background-color: var(--surface); border: 1px solid var(--border); border-radius: 12px; overflow: hidden; }
        .table-wrapper { width: 100%; overflow-x: auto; }
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th { background-color: #f1f1f1; padding: 14px 24px; text-align: left; font-size: 13px; color: var(--text-muted); font-weight: 700; white-space: nowrap; }
        .data-table td { padding: 16px 24px; border-bottom: 1px solid var(--border); font-size: 14px; font-weight: 700; color: var(--text-dark); white-space: nowrap; }
        .data-table tr:last-child td { border-bottom: none; }

        /* ===== STATUS ===== */
        .status-dikirim { color: #0097a7; }
        .status-dicetak { color: #fbc02d; }
        .status-selesai { color: #2e7d32; }
        .status-diproses { color: #e65100; }
        .status-batal { color: #c62828; }

        /* ===== BUTTON DETAIL ===== */
        .btn-detail { background-color: var(--primary); color: white; padding: 6px 16px; border-radius: 6px; font-size: 13px; font-weight: 700; border: none; cursor: pointer; font-family: inherit; display: inline-block; text-decoration: none;}
        .btn-detail:hover { background-color: var(--primary-hover); }

        /* ===== MOBILE ===== */
        @media (max-width: 640px) {
            .status-dropdown-btn { width: 100%; justify-content: space-between; }
            .status-dropdown { display: block; }
        }
    </style>
</head>

<body>

    {{-- SIDEBAR ADMIN --}}
    @include('partials.admin-nav', ['activeMenu' => 'permintaan-buku'])

    {{-- MAIN WRAPPER --}}
    <div class="main-wrapper">

        {{-- TOPBAR --}}
        <header class="topbar">
            <div class="topbar-left">
                <button type="button" class="menu-toggle" aria-label="Buka atau tutup sidebar">
                    <i class="fas fa-bars"></i>
                </button>
                <span>Permintaan Buku</span>
            </div>

            <div class="topbar-right">
                <i class="far fa-bell notification-bell"></i>
                <div class="user-profile">
                    <span>
                        {{ auth()->user()->nama ?? 'Admin' }}
                    </span>
                    <i class="fas fa-user-circle"></i>
                </div>
            </div>
        </header>

        {{-- CONTENT --}}
        <main class="content-area">

            {{-- HEADER --}}
            <div class="page-header">
                <h2>Permintaan Buku</h2>
                <p>Semua permintaan buku dari pelanggan.</p>
            </div>

            {{-- FILTER --}}
            <div class="filter-bar">
                <div class="status-dropdown" id="statusDropdown">
                    <button type="button" class="status-dropdown-btn" id="statusDropdownBtn">
                        <span id="statusDropdownLabel">Semua Status</span>
                        <i class="fas fa-chevron-down" style="font-size: 12px;"></i>
                    </button>

                    <div class="status-dropdown-menu" id="statusDropdownMenu">
                        <a href="#" class="status-filter-item active" data-status="semua">Semua Status</a>
                        <a href="#" class="status-filter-item" data-status="menunggu-diproses">Menunggu Diproses</a>
                        <a href="#" class="status-filter-item" data-status="sedang-dicetak">Sedang Dicetak</a>
                        <a href="#" class="status-filter-item" data-status="sedang-dikirim">Sedang Dikirim</a>
                        <a href="#" class="status-filter-item" data-status="selesai">Selesai</a>
                        <a href="#" class="status-filter-item" data-status="dibatalkan">Dibatalkan</a>
                    </div>
                </div>
            </div>

            {{-- TABLE --}}
            <div class="table-card">
                <div class="table-wrapper">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Nomor</th>
                                <th>Tanggal</th>
                                <th>Pelanggan</th>
                                <th>Jenis</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            {{-- DATA DINAMIS DARI DATABASE --}}
                            @forelse($daftarPesanan as $pesanan)
                                @php
                                    // Mapping status database ke Class CSS dan Data atribut Javascript
                                    $dbStatus = $pesanan->status;
                                    $cssClass = '';
                                    $dataStatus = '';

                                    if(in_array($dbStatus, ['Sedang Dikirim', 'Siap Dikirim'])) {
                                        $cssClass = 'status-dikirim';
                                        $dataStatus = 'sedang-dikirim';
                                    } elseif(in_array($dbStatus, ['Sedang Dicetak', 'Menunggu Pencetakan'])) {
                                        $cssClass = 'status-dicetak';
                                        $dataStatus = 'sedang-dicetak';
                                    } elseif($dbStatus == 'Selesai') {
                                        $cssClass = 'status-selesai';
                                        $dataStatus = 'selesai';
                                    } elseif(in_array($dbStatus, ['Permintaan Baru', 'Sedang Diproses', 'Menunggu Diproses'])) {
                                        $cssClass = 'status-diproses';
                                        $dataStatus = 'menunggu-diproses';
                                    } elseif(in_array($dbStatus, ['Dibatalkan', 'Kendala'])) {
                                        $cssClass = 'status-batal';
                                        $dataStatus = 'dibatalkan';
                                    }
                                @endphp
                                
                                <tr data-status="{{ $dataStatus }}">
                                    <td>WYG-{{ date('Y', strtotime($pesanan->created_at)) }}-{{ str_pad($pesanan->id, 4, '0', STR_PAD_LEFT) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($pesanan->created_at)->translatedFormat('j F Y') }}</td>
                                    <td>{{ $pesanan->user->nama ?? 'Pengguna Tidak Diketahui' }}</td>
                                    <td>{{ $pesanan->jenis_pesanan ?? 'Pribadi' }}</td>
                                    <td class="{{ $cssClass }}">{{ $pesanan->status }}</td>
                                    <td>
                                        <a href="/admin/pesanan/{{ $pesanan->id }}" class="btn-detail">Detail</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="text-align: center; color: var(--text-muted); font-weight: normal; padding: 24px;">Belum ada data permintaan buku.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>

    {{-- FILTER JAVASCRIPT --}}
    <script>
        (function () {
            var btn = document.getElementById('statusDropdownBtn');
            var menu = document.getElementById('statusDropdownMenu');
            var label = document.getElementById('statusDropdownLabel');
            var dropdown = document.getElementById('statusDropdown');
            var items = document.querySelectorAll('.status-filter-item');
            var rows = document.querySelectorAll('.data-table tbody tr[data-status]');

            /* Buka / tutup dropdown */
            btn.addEventListener('click', function () {
                menu.classList.toggle('open');
            });

            /* Klik di luar dropdown */
            document.addEventListener('click', function (e) {
                if (!dropdown.contains(e.target)) {
                    menu.classList.remove('open');
                }
            });

            /* Filter status */
            items.forEach(function (item) {
                item.addEventListener('click', function (e) {
                    e.preventDefault();

                    var status = this.dataset.status;

                    items.forEach(function (i) {
                        i.classList.remove('active');
                    });

                    this.classList.add('active');
                    label.textContent = this.textContent;
                    menu.classList.remove('open');

                    rows.forEach(function (row) {
                        if (status === 'semua' || row.dataset.status === status) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            });
        })();
    </script>
</body>
</html>