<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - BrailleKita</title>
    
    <!-- Font Atkinson Hyperlegible -->
    <link href="https://fonts.googleapis.com/css2?family=Atkinson+Hyperlegible:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    
    <!-- Ikon FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #c62828;
            --primary-hover: #b71c1c;
            --background: #f4f6f9;
            --surface: #ffffff;
            --text-dark: #111111;
            --text-muted: #757575;
            --border: #e0e0e0;
            --sidebar-width: 260px;
        }

        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Atkinson Hyperlegible', sans-serif;
            background-color: var(--background);
            color: var(--text-dark);
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        a { text-decoration: none; color: inherit; }
        ul { list-style: none; }

        /* ===== SIDEBAR ===== */
        .sidebar {
        width: var(--sidebar-width);
        background-color: var(--surface);
        border-right: 1px solid var(--border);
        display: flex;
        flex-direction: column;
        flex-shrink: 0;
        transition: width 0.25s ease, transform 0.25s ease;
        overflow: hidden;
        }

        .sidebar.collapsed {
         width: 0;
         border-right: none;
        }

        .sidebar-brand {
            padding: 24px;
            text-align: center;
            border-bottom: 1px solid var(--border);
        }

        .sidebar-brand h1 {
            color: var(--primary);
            font-size: 24px;
            font-weight: 700;
            font-family: Georgia, serif; 
        }

        .sidebar-menu {
            padding: 20px 16px;
            flex-grow: 1;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 14px 16px;
            border-radius: 8px;
            color: var(--text-dark);
            font-weight: 700;
            font-size: 15px;
            transition: all 0.2s ease;
        }

        .nav-item i {
            font-size: 18px;
            width: 20px;
            text-align: center;
        }

        .nav-item:hover:not(.active) {
            background-color: #f5f5f5;
        }

        .nav-item.active {
            background-color: var(--primary);
            color: white;
        }

        .sidebar-footer {
            padding: 16px 24px;
            border-top: 1px solid var(--border);
        }

        .btn-logout {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--primary);
            font-weight: 700;
            font-size: 15px;
            background: none;
            border: none;
            cursor: pointer;
            width: 100%;
            font-family: inherit;
        }

        .btn-logout:hover {
            color: var(--primary-hover);
        }

        /* ===== MAIN CONTENT AREA ===== */
        .main-wrapper {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            transition: all 0.25s ease;
        }

        /* ===== TOPBAR ===== */
        .topbar {
            height: 70px;
            background-color: var(--surface);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
            flex-shrink: 0;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 16px;
            font-size: 20px;
            font-weight: 700;
        }

        .menu-toggle {
            color: var(--text-muted);
            cursor: pointer;
            font-size: 20px;
            background: none;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 24px;
        }

        .search-box {
            position: relative;
        }

        .search-box i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 14px;
        }

        .search-box input {
            padding: 8px 16px 8px 36px;
            border: 1px solid var(--border);
            border-radius: 20px;
            font-family: inherit;
            font-size: 14px;
            outline: none;
            width: 250px;
            transition: border-color 0.2s;
        }

        .search-box input:focus {
            border-color: var(--primary);
        }

        .notification-bell {
            font-size: 20px;
            color: var(--text-dark);
            cursor: pointer;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            font-size: 15px;
            cursor: pointer;
        }

        .user-profile i {
            font-size: 24px;
        }

        /* ===== DASHBOARD CONTENT ===== */
        .content-area {
            padding: 32px;
            overflow-y: auto;
            flex-grow: 1;
        }

        .page-header {
            margin-bottom: 24px;
        }

        .page-header h2 {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .page-header p {
            color: var(--text-muted);
            font-size: 14px;
        }

        /* Stats Grid (10 items) */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 16px;
            margin-bottom: 32px;
        }

        .stat-card {
            background-color: var(--surface);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 16px;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .stat-icon {
            width: 44px;
            height: 44px;
            background-color: var(--primary);
            color: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .stat-info {
            display: flex;
            flex-direction: column;
        }

        .stat-number {
            font-size: 24px;
            font-weight: 700;
            line-height: 1.1;
        }

        .stat-label {
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 2px;
            line-height: 1.2;
        }

        /* Table Section */
        .table-card {
            background-color: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
        }

        .table-header {
            padding: 20px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table-header h3 {
            font-size: 16px;
            font-weight: 700;
        }

        .table-header a {
            font-size: 14px;
            color: var(--text-muted);
            font-weight: 700;
        }

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th {
            background-color: #f1f1f1;
            padding: 14px 24px;
            text-align: left;
            font-size: 13px;
            color: var(--text-muted);
            font-weight: 700;
        }

        .data-table td {
            padding: 16px 24px;
            border-bottom: 1px solid var(--border);
            font-size: 14px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .data-table tr:last-child td {
            border-bottom: none;
        }

        /* Status Colors */
        .status-dikirim { color: #0097a7; }
        .status-dicetak { color: #fbc02d; }
        .status-selesai { color: #2e7d32; }
        .status-diproses { color: #e65100; }
        .status-batal { color: #c62828; }

        .btn-detail {
            background-color: var(--primary);
            color: white;
            padding: 6px 16px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            font-family: inherit;
            display: inline-block;
        }

        .btn-detail:hover {
            background-color: var(--primary-hover);
        }

        /* Responsive Layout */
        @media (max-width: 1200px) {
            .stats-grid { grid-template-columns: repeat(3, 1fr); }
        }
        @media (max-width: 768px) {
            .sidebar { display: none; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .search-box input { width: 180px; }
        }
        @media (max-width: 480px) {
            .stats-grid { grid-template-columns: 1fr; }
        }

        /* ===== TAMBAHAN: Sidebar Mobile Bisa Dibuka/Tutup ===== */
.sidebar-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.4);
    z-index: 199;
}
.sidebar-overlay.open { display: block; }

@media (max-width: 768px) {
    .sidebar {
        display: flex !important; /* override aturan lama "display: none" */
        position: fixed;
        top: 0; left: 0; bottom: 0;
        z-index: 200;
        transform: translateX(-100%);
        transition: transform 0.25s ease;
        box-shadow: 4px 0 16px rgba(0,0,0,0.15);
    }
    .sidebar.collapsed {
        width: var(--sidebar-width);
    }
    .sidebar.open {
        transform: translateX(0);
    }
    .menu-toggle {
        cursor: pointer;
    }
}
    </style>
</head>
<body>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <h1>BrailleKita</h1>
        </div>
        
        <nav class="sidebar-menu">
            <a href="/admin/dashboard" class="nav-item active">
                <i class="fas fa-th-large"></i> Dashboard
            </a>
            <a href="/admin/permintaan-buku" class="nav-item">
                <i class="far fa-file-alt"></i> Permintaan Buku
            </a>
            <a href="#" class="nav-item">
                <i class="fas fa-book"></i> Kelola Buku
            </a>
            <a href="#" class="nav-item">
                <i class="fas fa-print"></i> Pencetakan
            </a>
            <a href="/admin/data-pelanggan" class="nav-item">
                <i class="fas fa-users"></i> Data Pelanggan
            </a>
            <a href="#" class="nav-item">
                <i class="fas fa-layer-group"></i> Permintaan Bahan
            </a>
            <a href="#" class="nav-item">
                <i class="fas fa-chart-line"></i> Laporan
            </a>
            <a href="#" class="nav-item">
                <i class="far fa-user"></i> Profile
            </a>
        </nav>

        <div class="sidebar-footer">
            <form action="/logout" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <div class="main-wrapper">
        
        <!-- TOPBAR -->
        <header class="topbar">
            <div class="topbar-left">
                <i class="fas fa-bars menu-toggle" id="menuToggle"></i>
                <span>Dashboard</span>
            </div>
            
            <div class="topbar-right">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search">
                </div>
                
                <i class="far fa-bell notification-bell"></i>
                
                <div class="user-profile">
                    <span>{{ auth()->user()->nama ?? 'Admin' }}</span>
                    <i class="fas fa-user-circle"></i>
                </div>
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
                    <a href="#">Lihat Semua</a>
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
                                        <a href="/admin/pesanan/{{ $pesanan->id }}" class="btn-detail">Detail</a>
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

    </main>
</div>

<script>
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.querySelector('.sidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    menuToggle.addEventListener('click', function () {

        // PC / Laptop
        if (window.innerWidth > 768) {
            sidebar.classList.toggle('collapsed');
            return;
        }

        // HP / Mobile
        sidebar.classList.toggle('open');
        sidebarOverlay.classList.toggle('open');
    });

    sidebarOverlay.addEventListener('click', function () {
        sidebar.classList.remove('open');
        sidebarOverlay.classList.remove('open');
    });
</script>

</body>
</html>