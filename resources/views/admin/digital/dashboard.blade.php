<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tambahan Tag Meta CSRF Token untuk mencegah 419 -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Literasi Digital - BrailleKita</title>
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #c62828; 
            --bg-color: #fcfcfc;
            --border-color: #eaeaea;
            --text-main: #111111;
            --text-muted: #888888;
            --success: #2e7d32;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }

        body {
            display: flex;
            height: 100vh;
            background-color: var(--bg-color);
            color: var(--text-main);
            overflow: hidden;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: 260px;
            background-color: #ffffff;
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            padding: 24px 16px;
        }

        .brand-logo {
            font-family: 'Georgia', serif;
            font-size: 26px;
            font-weight: 900;
            color: var(--primary);
            text-align: center;
            margin-bottom: 40px;
            letter-spacing: 0.5px;
        }

        .nav-menu {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 8px;
            flex-grow: 1;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 12px 16px;
            border-radius: 6px;
            color: var(--text-main);
            text-decoration: none;
            font-weight: 700;
            font-size: 14px;
            transition: 0.2s;
        }

        .nav-item i {
            font-size: 18px;
            width: 24px;
            text-align: center;
        }

        .nav-item.active {
            background-color: var(--primary);
            color: #ffffff;
        }

        .nav-item:hover:not(.active) {
            background-color: #f5f5f5;
        }
        
        .form-logout {
            margin-top: auto;
        }

        .logout-btn {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
            color: var(--primary);
            text-decoration: none;
            font-weight: 700;
            font-size: 14px;
            padding: 16px;
            border-top: 1px solid var(--border-color);
            border-left: none;
            border-right: none;
            border-bottom: none;
            background: transparent;
            width: 100%;
            cursor: pointer;
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }

        /* ===== TOPBAR ===== */
        .topbar {
            height: 70px;
            background-color: #ffffff;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .menu-toggle {
            font-size: 20px;
            color: var(--text-muted);
            cursor: pointer;
        }

        .topbar-title {
            font-size: 18px;
            font-weight: 900;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 24px;
        }

        .search-box {
            position: relative;
        }

        .search-box input {
            padding: 8px 16px 8px 36px;
            border: 1px solid var(--border-color);
            border-radius: 20px;
            font-size: 13px;
            width: 250px;
            outline: none;
        }

        .search-box i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 14px;
        }

        .profile-area {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 700;
            font-size: 14px;
        }

        .profile-area i.fa-bell {
            font-size: 18px;
            margin-right: 10px;
        }

        .profile-icon {
            font-size: 24px;
        }

        /* ===== DASHBOARD BODY ===== */
        .dashboard-body {
            padding: 32px;
        }

        .page-header h2 {
            font-size: 20px;
            font-weight: 800;
            margin-bottom: 4px;
        }

        .page-header p {
            font-size: 13px;
            color: var(--text-muted);
            margin-bottom: 32px;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 24px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 6px rgba(0,0,0,0.02);
            color: var(--primary);
        }

        .stat-card i {
            font-size: 24px;
            margin-bottom: 12px;
        }

        .stat-card .stat-number {
            font-size: 22px;
            font-weight: 900;
            margin-bottom: 4px;
        }

        .stat-card .stat-label {
            font-size: 12px;
            font-weight: 800;
        }

        /* Permintaan Section */
        .permintaan-section {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 12px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 24px;
            border-bottom: 1px solid var(--border-color);
        }

        .section-header h3 {
            font-size: 15px;
            font-weight: 800;
        }

        .btn-lihat-semua {
            background-color: #f1f1f1;
            color: var(--text-main);
            border: none;
            padding: 6px 16px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
        }

        /* Card List */
        .list-item {
            padding: 24px;
            border-bottom: 1px solid var(--border-color);
            position: relative;
        }

        .list-item:last-child {
            border-bottom: none;
        }

        .status-badge {
            position: absolute;
            top: 24px;
            right: 24px;
            font-size: 10px;
            font-weight: 800;
        }

        .status-menunggu { color: var(--primary); }
        .status-selesai { color: var(--success); }

        .item-id {
            font-size: 14px;
            font-weight: 800;
            margin-bottom: 4px;
        }

        .item-title {
            font-size: 13px;
            color: var(--text-muted);
            margin-bottom: 4px;
        }

        .item-subtitle {
            font-size: 12px;
            color: #aaaaaa;
            margin-bottom: 20px;
        }

        .item-details {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            margin-bottom: 16px;
        }

        .detail-group span {
            display: block;
            font-size: 11px;
            color: var(--text-muted);
            margin-bottom: 4px;
        }

        .detail-group strong {
            font-size: 12px;
            color: var(--text-main);
            font-weight: 800;
        }

        /* Progress Bar */
        .progress-info {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            font-weight: 700;
            color: var(--text-muted);
            margin-bottom: 6px;
        }

        .progress-track {
            width: 100%;
            height: 12px;
            background-color: #eeeeee;
            border-radius: 6px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            border-radius: 6px;
        }

        .progress-fill.red { background-color: var(--primary); }
        .progress-fill.green { background-color: var(--success); }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="brand-logo">BrailleKita</div>
        <ul class="nav-menu">
            <a href="{{ route('admin.digital.dashboard') }}" class="nav-item {{ ($activeMenu ?? '') == 'dashboard-digital' ? 'active' : '' }}">
                <i class="fas fa-list-alt"></i> Dashboard
            </a>
            <a href="#" class="nav-item">
                <i class="fas fa-print"></i> Permintaan Pecetakan
            </a>
            <a href="#" class="nav-item">
                <i class="fas fa-users"></i> PIC
            </a>
            <a href="#" class="nav-item">
                <i class="fas fa-layer-group"></i> Permintaan Bahan
            </a>
            <a href="{{ route('admin.profile') }}" class="nav-item">
                <i class="far fa-user"></i> Profile
            </a>
        </ul>

        <form action="{{ url('/logout') }}" method="POST" class="form-logout">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Keluar
            </button>
        </form>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="main-content">
        <!-- TOPBAR -->
        <header class="topbar">
            <div class="topbar-left">
                <i class="fas fa-bars menu-toggle"></i>
                <span class="topbar-title">Dashboard</span>
            </div>
            <div class="topbar-right">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search">
                </div>
                <div class="profile-area">
                    <i class="far fa-bell"></i>
                    <span>{{ auth()->user()->nama ?? 'H.Kokom' }}</span>
                    <i class="fas fa-user-circle profile-icon"></i>
                </div>
            </div>
        </header>

        <!-- DASHBOARD BODY -->
        <div class="dashboard-body">
            
            <div class="page-header">
                <h2>Dashboard Admin Literasi Digital</h2>
                <p>Ringkasan seluruh aktivitas platform.</p>
            </div>

            <!-- STATS GRID -->
            <div class="stats-grid">
                <div class="stat-card">
                    <i class="far fa-file-alt"></i>
                    <div class="stat-number">{{ $totalPencetakan ?? 0 }}</div>
                    <div class="stat-label">Permintaan Pencetakan</div>
                </div>
                <div class="stat-card">
                    <i class="fas fa-clipboard-check"></i>
                    <div class="stat-number">{{ $totalPermintaanBahan ?? 0 }}</div>
                    <div class="stat-label">Permintaan Bahan</div>
                </div>
                <div class="stat-card">
                    <i class="fas fa-print"></i>
                    <div class="stat-number">{{ $totalPencetakan ?? 0 }}</div>
                    <div class="stat-label">Permintaan Bahan</div>
                </div>
            </div>

            <!-- PERMINTAAN LIST -->
            <div class="permintaan-section">
                <div class="section-header">
                    <h3>Permintaan Pencetakan</h3>
                    <!-- Tombol untuk memicu Modal Pop-up Lihat Semua -->
                    <button type="button" onclick="bukaModalSemua()" class="btn-lihat-semua">Lihat semua</button>
                </div>

                @forelse($daftarPencetakan as $cetak)
                    @php
                        $selesai = $cetak->buku_selesai ?? 0;
                        $target = $cetak->target_buku ?? 1;
                        $persen = ($target > 0) ? round(($selesai / $target) * 100) : 0;
                        $isSelesai = strtolower($cetak->status) == 'selesai';
                    @endphp
                    <div class="list-item">
                        <div class="status-badge {{ $isSelesai ? 'status-selesai' : 'status-menunggu' }}">
                            {{ $cetak->status }}
                        </div>
                        
                        <div class="item-id">{{ $cetak->kode_cetak }}</div>
                        <div class="item-title">{{ $cetak->buku->judul ?? 'Judul Buku' }} - {{ $target }} eksemplar</div>
                        <div class="item-subtitle">Pesanan: WYG-{{ $cetak->pesanan_id }}</div>

                        <div class="item-details">
                            <div class="detail-group">
                                <span>PIC</span>
                                <strong>{{ $cetak->pic }}</strong>
                            </div>
                            <div class="detail-group">
                                <span>Target</span>
                                <strong>{{ $target }} buku</strong>
                            </div>
                            <div class="detail-group" style="text-align: right;">
                                <span>Deadline</span>
                                <strong>{{ \Carbon\Carbon::parse($cetak->deadline)->translatedFormat('j F Y') }}</strong>
                            </div>
                        </div>

                        <div class="progress-info">
                            <span>{{ $selesai }} dari {{ $target }} buku selesai</span>
                            <span style="color: #111;">{{ $persen }}%</span>
                        </div>
                        <div class="progress-track">
                            <div class="progress-fill {{ $isSelesai ? 'green' : 'red' }}" style="width: {{ $persen }}%;"></div>
                        </div>
                    </div>
                @empty
                    <div style="padding: 32px; text-align: center; color: var(--text-muted); font-size: 14px;">
                        Belum ada data permintaan pencetakan untuk divisi Literasi Digital.
                    </div>
                @endforelse

            </div>
        </div>
    </main>

    <!-- ================================================= -->
    <!-- ===== MODAL POP-UP SEMUA PERMINTAAN PENCETAKAN === -->
    <!-- ================================================= -->
    <div id="modalSemua" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center;">
        <div style="background: #fff; width: 85%; max-height: 85vh; border-radius: 12px; display: flex; flex-direction: column; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.15);">
            
            <!-- Header Modal -->
            <div style="padding: 20px 24px; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center;">
                <h3 style="font-size: 16px; font-weight: 800;">Semua Permintaan Pencetakan - Literasi Digital</h3>
                <button type="button" onclick="tutupModalSemua()" style="background: none; border: none; font-size: 18px; cursor: pointer; color: var(--text-muted);"><i class="fas fa-times"></i></button>
            </div>

            <!-- Body Modal (Tabel Data Lengkap + Live Search) -->
            <div style="padding: 24px; overflow-y: auto; flex-grow: 1;">
                
                <input type="text" id="inputCariModal" onkeyup="cariDataModal()" placeholder="Cari berdasarkan kode, judul buku, atau PIC..." style="width: 100%; padding: 10px 16px; border: 1px solid var(--border-color); border-radius: 6px; font-size: 13px; margin-bottom: 20px; outline: none;">

                <div style="border: 1px solid var(--border-color); border-radius: 8px; overflow: hidden;">
                    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px;">
                        <thead>
                            <tr style="background: #f9f9f9;">
                                <th style="padding: 14px; border-bottom: 1px solid var(--border-color);">Kode Cetak</th>
                                <th style="padding: 14px; border-bottom: 1px solid var(--border-color);">Judul Buku</th>
                                <th style="padding: 14px; border-bottom: 1px solid var(--border-color);">PIC</th>
                                <th style="padding: 14px; border-bottom: 1px solid var(--border-color);">Target</th>
                                <th style="padding: 14px; border-bottom: 1px solid var(--border-color);">Selesai</th>
                                <th style="padding: 14px; border-bottom: 1px solid var(--border-color);">Deadline</th>
                                <th style="padding: 14px; border-bottom: 1px solid var(--border-color);">Status</th>
                            </tr>
                        </thead>
                        <tbody id="tabelBodyModal">
                            @forelse($semuaPencetakan ?? [] as $cetak)
                            <tr class="baris-data">
                                <td style="padding: 14px; border-bottom: 1px solid var(--border-color);"><strong>{{ $cetak->kode_cetak }}</strong></td>
                                <td style="padding: 14px; border-bottom: 1px solid var(--border-color);">{{ $cetak->buku->judul ?? 'Judul Buku' }}</td>
                                <td style="padding: 14px; border-bottom: 1px solid var(--border-color);">{{ $cetak->pic }}</td>
                                <td style="padding: 14px; border-bottom: 1px solid var(--border-color);">{{ $cetak->target_buku }} buku</td>
                                <td style="padding: 14px; border-bottom: 1px solid var(--border-color);">{{ $cetak->buku_selesai ?? 0 }} buku</td>
                                <td style="padding: 14px; border-bottom: 1px solid var(--border-color);">{{ \Carbon\Carbon::parse($cetak->deadline)->translatedFormat('j M Y') }}</td>
                                <td style="padding: 14px; border-bottom: 1px solid var(--border-color);">
                                    <span style="font-weight: 800; color: {{ strtolower($cetak->status) == 'selesai' ? 'var(--success)' : 'var(--primary)' }}">
                                        {{ $cetak->status }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 24px; color: var(--text-muted);">Belum ada data pencetakan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Footer Modal -->
            <div style="padding: 16px 24px; border-top: 1px solid var(--border-color); text-align: right; background: #f9f9f9;">
                <button type="button" onclick="tutupModalSemua()" style="padding: 8px 16px; background: #e0e0e0; border: none; border-radius: 6px; font-weight: 700; cursor: pointer;">Tutup</button>
            </div>

        </div>
    </div>

    <!-- Script JavaScript untuk Modal & Live Search -->
    <script>
        function bukaModalSemua() {
            document.getElementById('modalSemua').style.display = 'flex';
        }

        function tutupModalSemua() {
            document.getElementById('modalSemua').style.display = 'none';
        }

        function cariDataModal() {
            let input = document.getElementById('inputCariModal').value.toLowerCase();
            let rows = document.getElementsByClassName('baris-data');

            for (let i = 0; i < rows.length; i++) {
                let text = rows[i].innerText.toLowerCase();
                if (text.includes(input)) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none";
                }
            }
        }
    </script>

</body>
</html>