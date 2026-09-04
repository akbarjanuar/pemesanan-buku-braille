<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - BrailleKita</title>
    
    <!-- PENTING: Karena font, icon, dan styling root sudah ada di admin-nav, kita hanya perlu menaruh CSS khusus konten dashboard di sini -->
    <style>
        /* ===== DASHBOARD CONTENT ===== */
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

        /* Stats Grid */
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
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 480px) {
            .stats-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    {{-- KITA MEMANGGIL SIDEBAR DARI FILE PARTIAL AGAR SINKRON DENGAN HALAMAN LAIN --}}
    @include('partials.admin-nav', ['activeMenu' => 'dashboard'])

    <!-- MAIN CONTENT -->
    <div class="main-wrapper">
        
        <!-- TOPBAR -->
        <header class="topbar">
            <div class="topbar-left">
                <!-- Tambahkan type="button" agar tidak dianggap submit dan class menu-toggle untuk trigger JS sidebar -->
                <button type="button" class="menu-toggle">
                    <i class="fas fa-bars"></i>
                </button>
                <span style="margin-left: 10px;">Dashboard</span>
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

</body>
</html>