<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Literasi Manual - BrailleKita</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root { 
            --primary: #c62828; 
            --primary-hover: #b71c1c; 
            --surface: #ffffff; 
            --text-dark: #111111; 
            --text-muted: #757575; 
            --border: #e0e0e0; 
            --background: #f4f6f9; 
            --success: #2e7d32;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: sans-serif; background: var(--background); color: var(--text-dark); display: flex; height: 100vh; overflow: hidden; }

        .main-wrapper {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }

        /* ===== TOPBAR YANG DISEMPURNAKAN AGAR SEJAJAR & TIDAK MEPET ===== */
        .topbar {
            background-color: var(--surface);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 32px;
            width: 100%;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .menu-toggle { 
            display: inline-flex; 
            align-items: center; 
            justify-content: center; 
            width: 24px; 
            height: 24px; 
            color: var(--text-muted); 
            background: none; 
            border: none; 
            cursor: pointer; 
            font-size: 20px; 
        }
        
        .topbar-title { 
            font-size: 20px; 
            font-weight: 900; 
            font-family: 'Georgia', serif; 
            color: var(--text-dark); 
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        /* Styling Ikon Notifikasi dengan Titik Merah */
        .notification-button {
            position: relative;
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #111111;
            font-size: 19px;
            cursor: pointer;
            border-radius: 6px;
        }
        .notification-button:hover { background: #f5f5f5; }
        .notification-dot {
            position: absolute;
            top: 7px;
            right: 7px;
            width: 7px;
            height: 7px;
            background: var(--primary);
            border-radius: 50%;
        }

        .content-area { padding: 32px; flex-grow: 1; }

        /* ===== FITUR GLOBAL SEARCH TOPBAR ===== */
        .global-search-container {
            position: relative;
            width: 300px;
        }
        .search-box {
            display: flex;
            align-items: center;
            background: #f5f5f5;
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 8px 16px;
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
        .search-dropdown.active { display: block; }
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

        /* ===== DASHBOARD CONTENT ===== */
        .page-header { margin-bottom: 24px; }
        .page-header h2 { font-size: 22px; font-weight: 700; margin-bottom: 4px; }
        .page-header p { color: var(--text-muted); font-size: 14px; }

        /* Stats Grid (3 Kolom untuk Literasi Manual) */
        .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 32px; }
        .stat-card { background-color: var(--surface); border: 1px solid var(--border); border-radius: 12px; padding: 24px; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; box-shadow: 0 2px 6px rgba(0,0,0,0.02); color: var(--primary); }
        .stat-card i { font-size: 24px; margin-bottom: 12px; }
        .stat-card .stat-number { font-size: 24px; font-weight: 900; margin-bottom: 4px; color: var(--text-dark); }
        .stat-card .stat-label { font-size: 13px; font-weight: 700; color: var(--text-muted); }

        /* Permintaan Section / List Card */
        .permintaan-section {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0,0,0,0.02);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 24px;
            border-bottom: 1px solid var(--border);
        }

        .section-header h3 {
            font-size: 16px;
            font-weight: 700;
        }

        .btn-lihat-semua {
            background-color: #f1f1f1;
            color: var(--text-dark);
            border: none;
            padding: 6px 16px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
        }
        .btn-lihat-semua:hover { background-color: #e4e4e4; }

        .list-item {
            padding: 24px;
            border-bottom: 1px solid var(--border);
            position: relative;
        }
        .list-item:last-child { border-bottom: none; }

        .status-badge {
            position: absolute;
            top: 24px;
            right: 24px;
            font-size: 11px;
            font-weight: 800;
        }
        .status-menunggu { color: var(--primary); }
        .status-selesai { color: var(--success); }

        .item-id { font-size: 14px; font-weight: 800; margin-bottom: 4px; }
        .item-title { font-size: 13px; color: var(--text-muted); margin-bottom: 4px; }
        .item-subtitle { font-size: 12px; color: #aaaaaa; margin-bottom: 20px; }

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
            font-size: 13px;
            color: var(--text-dark);
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
            height: 10px;
            background-color: #eeeeee;
            border-radius: 5px;
            overflow: hidden;
        }
        .progress-fill {
            height: 100%;
            border-radius: 5px;
        }
        .progress-fill.red { background-color: var(--primary); }
        .progress-fill.green { background-color: var(--success); }

        @media (max-width: 900px) { 
            .stats-grid { grid-template-columns: 1fr; } 
            .global-search-container { width: 180px; } 
        }
    </style>
</head>
<body>

    @include('partials.admin-manual-nav', ['activeMenu' => 'dashboard'])

    <!-- MAIN CONTENT -->
    <div class="main-wrapper">
        
        <!-- TOPBAR -->
        <header class="topbar">
            <div class="topbar-left">
                <button type="button" class="menu-toggle">
                    <i class="fas fa-bars"></i>
                </button>
                <span class="topbar-title">Dashboard Literasi Manual</span>
            </div>
            
            <div class="topbar-right">
                <!-- FITUR GLOBAL SEARCH BOX -->
                <div class="global-search-container" id="globalSearchContainer">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" id="globalSearchInput" placeholder="Cari data pencetakan..." autocomplete="off">
                    </div>

                    <!-- Dropdown Hasil (Ditampilkan via JS) -->
                    <div class="search-dropdown" id="searchDropdown">
                        <!-- Konten akan di-generate via JavaScript -->
                    </div>
                </div>
                
                <!-- Ikon Notifikasi dengan Titik Merah -->
                <div class="notification-button">
                    <i class="far fa-bell"></i>
                    <span class="notification-dot"></span>
                </div>
                
                <!-- Profil Pengguna -->
                <a href="{{ route('admin.manual.profile') }}" style="display: flex; align-items: center; gap: 12px; text-decoration: none; color: var(--text-dark); cursor: pointer;">
                    <span style="font-weight: 700; font-size: 15px;">
                        {{ auth()->user()->nama ?? 'Admin Manual' }}
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
                <h2>Dashboard Admin Literasi Manual</h2>
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
                    <button type="button" onclick="bukaModalSemua()" class="btn-lihat-semua">Lihat semua</button>
                </div>

                @forelse($daftarPencetakan ?? [] as $cetak)
                    @php
                        $selesai =$cetak->buku_selesai ?? 0;
                        $target =$cetak->target_buku ?? 1;
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
                            <span>{{ $selesai }} dari {{$target }} buku selesai</span>
                            <span style="color: #111;">{{ $persen }}%</span>
                        </div>
                        <div class="progress-track">
                            <div class="progress-fill {{ $isSelesai ? 'green' : 'red' }}" style="width: {{ $persen }}%;"></div>
                        </div>
                    </div>
                @empty
                    <div style="padding: 32px; text-align: center; color: var(--text-muted); font-size: 14px;">
                        Belum ada data permintaan pencetakan untuk divisi Literasi Manual.
                    </div>
                @endforelse
            </div>

        </main>
    </div>

    <!-- ================================================= -->
    <!-- ===== MODAL POP-UP SEMUA PERMINTAAN PENCETAKAN === -->
    <!-- ================================================= -->
    <div id="modalSemua" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center;">
        <div style="background: #fff; width: 85%; max-height: 85vh; border-radius: 12px; display: flex; flex-direction: column; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.15);">
            
            <div style="padding: 20px 24px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
                <h3 style="font-size: 16px; font-weight: 800;">Semua Permintaan Pencetakan - Literasi Manual</h3>
                <button type="button" onclick="tutupModalSemua()" style="background: none; border: none; font-size: 18px; cursor: pointer; color: var(--text-muted);"><i class="fas fa-times"></i></button>
            </div>

            <div style="padding: 24px; overflow-y: auto; flex-grow: 1;">
                
                <input type="text" id="inputCariModal" onkeyup="cariDataModal()" placeholder="Cari berdasarkan kode, judul buku, atau PIC..." style="width: 100%; padding: 10px 16px; border: 1px solid var(--border); border-radius: 6px; font-size: 13px; margin-bottom: 20px; outline: none;">

                <div style="border: 1px solid var(--border); border-radius: 8px; overflow: hidden;">
                    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px;">
                        <thead>
                            <tr style="background: #f9f9f9;">
                                <th style="padding: 14px; border-bottom: 1px solid var(--border); color: var(--text-muted);">Kode Cetak</th>
                                <th style="padding: 14px; border-bottom: 1px solid var(--border); color: var(--text-muted);">Judul Buku</th>
                                <th style="padding: 14px; border-bottom: 1px solid var(--border); color: var(--text-muted);">PIC</th>
                                <th style="padding: 14px; border-bottom: 1px solid var(--border); color: var(--text-muted);">Target</th>
                                <th style="padding: 14px; border-bottom: 1px solid var(--border); color: var(--text-muted);">Selesai</th>
                                <th style="padding: 14px; border-bottom: 1px solid var(--border); color: var(--text-muted);">Deadline</th>
                                <th style="padding: 14px; border-bottom: 1px solid var(--border); color: var(--text-muted);">Status</th>
                            </tr>
                        </thead>
                        <tbody id="tabelBodyModal">
                            @forelse($semuaPencetakan ?? [] as $cetak)
                            <tr class="baris-data">
                                <td style="padding: 14px; border-bottom: 1px solid var(--border); font-weight: 700;">{{ $cetak->kode_cetak }}</td>
                                <td style="padding: 14px; border-bottom: 1px solid var(--border); font-weight: 700;">{{ $cetak->buku->judul ?? 'Judul Buku' }}</td>
                                <td style="padding: 14px; border-bottom: 1px solid var(--border); font-weight: 700;">{{ $cetak->pic }}</td>
                                <td style="padding: 14px; border-bottom: 1px solid var(--border); font-weight: 700;">{{ $cetak->target_buku }} buku</td>
                                <td style="padding: 14px; border-bottom: 1px solid var(--border); font-weight: 700;">{{ $cetak->buku_selesai ?? 0 }} buku</td>
                                <td style="padding: 14px; border-bottom: 1px solid var(--border); font-weight: 700;">{{ \Carbon\Carbon::parse($cetak->deadline)->translatedFormat('j M Y') }}</td>
                                <td style="padding: 14px; border-bottom: 1px solid var(--border);">
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

            <div style="padding: 16px 24px; border-top: 1px solid var(--border); text-align: right; background: #f9f9f9;">
                <button type="button" onclick="tutupModalSemua()" style="padding: 8px 16px; background: #e0e0e0; border: none; border-radius: 6px; font-weight: 700; cursor: pointer;">Tutup</button>
            </div>

        </div>
    </div>

    <!-- JS untuk Modal & Search -->
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

        // Live Search Topbar sederhana
        (function() {
            const searchInput = document.getElementById('globalSearchInput');
            const searchDropdown = document.getElementById('searchDropdown');
            const searchContainer = document.getElementById('globalSearchContainer');

            if(searchInput) {
                searchInput.addEventListener('input', function() {
                    const query = this.value.trim();
                    if (query.length > 1) {
                        searchDropdown.classList.add('active');
                        searchDropdown.innerHTML = `
                            <div class="search-item" onclick="alert('Mencari: ${query}')">
                                <div class="search-item-icon"><i class="fas fa-search"></i></div>
                                <div class="search-item-text">
                                    <span class="search-item-title">Cari "${query}"</span>
                                    <span class="search-item-desc">Tekan untuk melihat hasil pencarian</span>
                                </div>
                            </div>
                        `;
                    } else {
                        searchDropdown.classList.remove('active');
                        searchDropdown.innerHTML = '';
                    }
                });

                document.addEventListener('click', function(e) {
                    if (!searchContainer.contains(e.target)) {
                        searchDropdown.classList.remove('active');
                    }
                });
            }
        })();
    </script>

</body>
</html>