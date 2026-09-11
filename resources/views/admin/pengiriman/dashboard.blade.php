<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - BrailleKita</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- PENTING: Karena font, icon, dan styling root sudah ada di admin-nav, kita hanya perlu menaruh CSS khusus konten dashboard di sini -->
    <style>
        :root { --primary: #c62828; --primary-hover: #b71c1c; --surface: #ffffff; --text-dark: #111111; --text-muted: #757575; --border: #e0e0e0; --background: #f4f6f9; }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: sans-serif; background: var(--background); color: var(--text-dark); }

        .menu-toggle { display: inline-flex; align-items: center; justify-content: center; width: 24px; height: 24px; color: var(--text-muted); background: none; border: none; cursor: pointer; font-size: 20px; }
        .topbar-title { font-size: 20px; font-weight: 900; font-family: 'Georgia', serif; color: var(--text-dark); margin-left: 10px; }
        .content-area { padding: 32px; flex-grow: 1; overflow-y: auto; }

        /* ===== FITUR GLOBAL SEARCH TOPBAR ===== */
        .global-search-container {
            position: relative;
            width: 320px;
        }
        .search-box {
            display: flex;
            align-items: center;
            background: #f5f5f5;
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 9px 16px;
            gap: 10px;
            transition: all 0.2s ease;
        }
        .search-box:focus-within {
            border-color: var(--primary);
            background: var(--surface);
            box-shadow: 0 0 0 3px rgba(198, 40, 40, 0.1);
        }
        .search-box input {
            border: none !important;
            background: transparent !important;
            outline: none !important;
            box-shadow: none !important;
            width: 100%;
            font-size: 13px;
            font-family: inherit;
            color: var(--text-dark);
        }

        /* Tambahkan baris ini khusus untuk memastikan tidak ada garis saat di-klik */
        .search-box input:focus {
            border: none !important;
            outline: none !important;
            box-shadow: none !important;
        }
        
        /* Dropdown Hasil Pencarian */
        .search-dropdown {
            display: none;
            position: absolute;
            top: calc(100% + 8px);
            left: 0;
            width: 100%;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.12);
            z-index: 999;
            overflow: hidden;
        }
        .search-dropdown.active {
            display: block;
        }
        .search-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 16px;
            text-decoration: none;
            color: var(--text-dark);
            border-bottom: 1px solid #f0f0f0;
            transition: background 0.2s;
            cursor: pointer;
        }
        .search-item:last-child { border-bottom: none; }
        .search-item:hover { background: #f9f9f9; }
        .search-item-icon {
            width: 32px; height: 32px; border-radius: 8px;
            background: #f0f0f0; display: flex; align-items: center; justify-content: center;
            color: var(--text-muted); flex-shrink: 0;
        }
        .search-item:hover .search-item-icon { background: var(--primary); color: white; }
        .search-item-text { display: flex; flex-direction: column; }
        .search-item-title { font-size: 13px; font-weight: 700; margin-bottom: 2px; }
        .search-item-desc { font-size: 11px; color: var(--text-muted); }
        .search-empty { padding: 20px; text-align: center; font-size: 13px; color: var(--text-muted); }

        /* ===== DASHBOARD CONTENT ===== */
        .page-header { margin-bottom: 24px; }
        .page-header h2 { font-size: 22px; font-weight: 700; margin-bottom: 4px; }
        .page-header p { color: var(--text-muted); font-size: 14px; }

        /* Stats Grid */
        .stats-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 16px; margin-bottom: 32px; }
        .stat-card { background-color: var(--surface); border: 1px solid var(--border); border-radius: 8px; padding: 16px; display: flex; align-items: center; gap: 16px; }
        .stat-icon { width: 44px; height: 44px; background-color: var(--primary); color: white; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; }
        .stat-info { display: flex; flex-direction: column; }
        .stat-number { font-size: 24px; font-weight: 700; line-height: 1.1; }
        .stat-label { font-size: 11px; color: var(--text-muted); margin-top: 2px; line-height: 1.2; }

        /* Table Section */
        .table-card { background-color: var(--surface); border: 1px solid var(--border); border-radius: 12px; overflow: hidden; }
        .table-header { padding: 20px 24px; display: flex; justify-content: space-between; align-items: center; }
        .table-header h3 { font-size: 16px; font-weight: 700; }
        .table-header a { font-size: 14px; color: var(--primary); font-weight: 700; text-decoration: none; }
        .table-header a:hover { text-decoration: underline; }
        .table-wrapper { width: 100%; overflow-x: auto; }
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th { background-color: #f1f1f1; padding: 14px 24px; text-align: left; font-size: 13px; color: var(--text-muted); font-weight: 700; }
        .data-table td { padding: 16px 24px; border-bottom: 1px solid var(--border); font-size: 14px; font-weight: 700; color: var(--text-dark); }
        .data-table tr:last-child td { border-bottom: none; }
        
        .data-table tbody tr:hover { background-color: #fafafa; }

        /* Status Colors */
        .status-dikirim { color: #0097a7; }
        .status-dicetak { color: #fbc02d; }
        .status-selesai { color: #2e7d32; }
        .status-diproses { color: #e65100; }
        .status-batal { color: #c62828; }

        .btn-detail { background-color: var(--primary); color: white; padding: 6px 16px; border-radius: 6px; font-size: 13px; font-weight: 700; border: none; cursor: pointer; font-family: inherit; display: inline-block; text-decoration: none; }
        .btn-detail:hover { background-color: var(--primary-hover); }

        /* Responsive Layout */
        @media (max-width: 1200px) { .stats-grid { grid-template-columns: repeat(3, 1fr); } }
        @media (max-width: 768px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } .global-search-container { width: 200px; } }
        @media (max-width: 480px) { .stats-grid { grid-template-columns: 1fr; } .global-search-container { display: none; /* Sembunyikan search di HP agar tidak menumpuk, bisa diganti icon klik */ } }
    </style>
</head>
<body>

    @include('partials.admin-nav', ['activeMenu' => 'dashboard'])

    <!-- MAIN CONTENT -->
    <div class="main-wrapper">
        
        <!-- TOPBAR -->
        <header class="topbar">
            <div class="topbar-left">
                <button type="button" class="menu-toggle">
                    <i class="fas fa-bars"></i>
                </button>
                <span class="topbar-title">Dashboard</span>
            </div>
            
            <div class="topbar-right" style="display: flex; align-items: center; gap: 24px;">
                
                <!-- FITUR GLOBAL SEARCH BOX -->
                <div class="global-search-container" id="globalSearchContainer">
                    <!-- Gunakan form agar admin bisa menekan 'Enter' untuk melakukan pencarian full -->
                    <form action="{{ route('admin.permintaan-buku') }}" method="GET" class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" name="search" id="globalSearchInput" placeholder="Cari No. Pesanan atau Judul Buku..." autocomplete="off">
                    </form>

                    <!-- Dropdown Hasil (Ditampilkan via JS) -->
                    <div class="search-dropdown" id="searchDropdown">
                        <!-- Konten akan di-generate via JavaScript -->
                    </div>
                </div>
                
                <!-- Ikon Notifikasi -->
                <i class="far fa-bell notification-bell" style="font-size: 20px; cursor: pointer;"></i>
                
                <!-- Profil Pengguna -->
                <a href="{{ route('admin.profile') }}" style="display: flex; align-items: center; gap: 12px; text-decoration: none; color: var(--text-dark); cursor: pointer;">
                    <span style="font-weight: 700; font-size: 15px;">
                        {{ auth()->user()->nama ?? 'Admin Pengiriman' }}
                    </span>
                    
                    <div style="width: 36px; height: 36px; border-radius: 50%; overflow: hidden; background: #111; display: flex; align-items: center; justify-content: center; color: white;">
                        @if(auth()->user()->foto_profil)
                            <img src="{{ auth()->user()->foto_profil }}" alt="Foto Profile" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <i class="fas fa-user" style="font-size: 16px;"></i>
                        @endif
                    </div>
                </a>
            </div>
        </header>

        <!-- DASHBOARD CONTENT -->
        <main class="content-area">
            
            <div class="page-header">
                <h2>Dashboard Admin Pengiriman</h2>
                <p>Ringkasan seluruh aktivitas platform.</p>
            </div>

            <!-- STATS GRID (Dinamis dari Database) -->
            <div class="stats-grid">
                <!-- Baris 1 -->
                <div class="stat-card">
                    <div class="stat-icon"><i class="far fa-file-alt"></i></div>
                    <div class="stat-info">
                        <span class="stat-number">{{ $stats['baru'] ?? 0 }}</span>
                        <span class="stat-label">Permintaan Baru</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-sync-alt"></i></div>
                    <div class="stat-info">
                        <span class="stat-number">{{ $stats['diproses'] ?? 0 }}</span>
                        <span class="stat-label">Sedang Diproses</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="far fa-clock"></i></div>
                    <div class="stat-info">
                        <span class="stat-number">{{ $stats['menunggu_pencetakan'] ?? 0 }}</span>
                        <span class="stat-label">Menunggu Pencetakan</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-print"></i></div>
                    <div class="stat-info">
                        <span class="stat-number">{{ $stats['dicetak'] ?? 0 }}</span>
                        <span class="stat-label">Sedang Dicetak</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <div class="stat-info">
                        <span class="stat-number">{{ $stats['siap_dikirim'] ?? 0 }}</span>
                        <span class="stat-label">Siap Dikirim</span>
                    </div>
                </div>
                
                <!-- Baris 2 -->
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-truck"></i></div>
                    <div class="stat-info">
                        <span class="stat-number">{{ $stats['dikirim'] ?? 0 }}</span>
                        <span class="stat-label">Sedang Dikirim</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-check-square"></i></div>
                    <div class="stat-info">
                        <span class="stat-number">{{ $stats['selesai'] ?? 0 }}</span>
                        <span class="stat-label">Selesai</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="far fa-times-circle"></i></div>
                    <div class="stat-info">
                        <span class="stat-number">{{ $stats['dibatalkan'] ?? 0 }}</span>
                        <span class="stat-label">Pesanan Dibatalkan</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-exclamation-triangle"></i></div>
                    <div class="stat-info">
                        <span class="stat-number">{{ $stats['kendala'] ?? 0 }}</span>
                        <span class="stat-label">Kendala</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-notes-medical"></i></div>
                    <div class="stat-info">
                        <span class="stat-number">{{ $stats['bahan_baru'] ?? 0 }}</span>
                        <span class="stat-label">Perm. Bahan Baru</span>
                    </div>
                </div>
            </div>

            <!-- TABEL PERMINTAAN (Dinamis dari Database) -->
            <div class="table-card">
                <div class="table-header">
                    <h3>Permintaan Terbaru</h3>
                    <a href="{{ route('admin.permintaan-buku') }}">Lihat Semua</a>
                </div>
                
                <div class="table-wrapper">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Nomor</th>
                                <th>Pelanggan</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pesananTerbaru as $pesanan)
                                @php
                                    $statusClass = '';
                                    if(in_array($pesanan->status, ['Sedang Dikirim', 'Siap Dikirim'])) $statusClass = 'status-dikirim';
                                    elseif(in_array($pesanan->status, ['Sedang Dicetak', 'Menunggu Pencetakan'])) $statusClass = 'status-dicetak';
                                    elseif($pesanan->status == 'Selesai') $statusClass = 'status-selesai';
                                    elseif(in_array($pesanan->status, ['Sedang Diproses', 'Permintaan Baru'])) $statusClass = 'status-diproses';
                                    elseif(in_array($pesanan->status, ['Dibatalkan', 'Kendala'])) $statusClass = 'status-batal';
                                @endphp
                                
                                <tr>
                                    <td>WYG-{{ date('Y') }}-{{ str_pad($pesanan->id, 4, '0', STR_PAD_LEFT) }}</td>
                                    <td>{{ $pesanan->user->nama ?? 'Pengguna Tidak Diketahui' }}</td>
                                    <td class="{{ $statusClass }}">{{ $pesanan->status }}</td>
                                    <td>{{ \Carbon\Carbon::parse($pesanan->created_at)->translatedFormat('j F Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.detail-pesanan', $pesanan->id) }}" class="btn-detail">Detail</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align: center; color: var(--text-muted); font-weight: normal; padding: 24px;">Belum ada data permintaan terbaru.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>

    <!-- JS untuk Fungsionalitas Live Search UI -->
    <script>
        (function() {
            const searchInput = document.getElementById('globalSearchInput');
            const searchDropdown = document.getElementById('searchDropdown');
            const searchContainer = document.getElementById('globalSearchContainer');

            // Ketika user mengetik di search bar
            searchInput.addEventListener('input', function() {
                const query = this.value.trim();

                if (query.length > 1) {
                    searchDropdown.classList.add('active');
                    
                    /* 
                       Note untuk Backend: 
                       Di sini Anda bisa menggunakan fetch API (AJAX) ke route Laravel.
                       Contoh simulasi UI statis saat mencari:
                    */
                    searchDropdown.innerHTML = `
                        <a href="{{ route('admin.permintaan-buku') }}?search=${encodeURIComponent(query)}" class="search-item">
                            <div class="search-item-icon"><i class="fas fa-file-alt"></i></div>
                            <div class="search-item-text">
                                <span class="search-item-title">Cari "${query}" di Data Pesanan</span>
                                <span class="search-item-desc">Tekan Enter untuk melihat semua hasil</span>
                            </div>
                        </a>
                        <a href="{{ route('admin.kelola-buku') }}?search=${encodeURIComponent(query)}" class="search-item">
                            <div class="search-item-icon"><i class="fas fa-book"></i></div>
                            <div class="search-item-text">
                                <span class="search-item-title">Cari Buku "${query}"</span>
                                <span class="search-item-desc">Cari ketersediaan buku di kelola buku</span>
                            </div>
                        </a>
                    `;
                } else {
                    searchDropdown.classList.remove('active');
                    searchDropdown.innerHTML = '';
                }
            });

            // Tutup dropdown jika user klik di luar kotak pencarian
            document.addEventListener('click', function(e) {
                if (!searchContainer.contains(e.target)) {
                    searchDropdown.classList.remove('active');
                }
            });
        })();
    </script>

</body>
</html>