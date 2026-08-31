<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pelanggan - BrailleKita</title>

    <style>
        .back-link { color: var(--primary); font-weight: 700; font-size: 15px; display: inline-block; margin-bottom: 20px; text-decoration: none; }
        .back-link:hover { text-decoration: underline; }

        .page-header { margin-bottom: 20px; }
        .page-header h2 { font-size: 22px; font-weight: 700; }

        .detail-layout { display: grid; grid-template-columns: 340px minmax(0, 1fr); gap: 24px; align-items: start; }

        .profile-card { background: var(--surface); border: 1px solid var(--border); border-radius: 12px; padding: 24px; }

        .profile-avatar {
            width: 48px; height: 48px; border-radius: 50%;
            background: var(--primary); color: white;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 20px; margin-bottom: 20px;
        }

        .profile-field { margin-bottom: 16px; }
        .profile-field:last-child { margin-bottom: 0; }
        .profile-field .field-label { font-size: 13px; color: var(--text-muted); margin-bottom: 2px; }
        .profile-field .field-value { font-size: 14px; font-weight: 700; color: var(--text-dark); line-height: 1.4; }
        .profile-field .field-value.status-aktif { color: #2e7d32; }

        .profile-divider { border-top: 1px solid var(--border); margin: 20px 0; }

        .ktp-label { font-size: 13px; color: var(--text-muted); margin-bottom: 10px; font-weight: 700; }
        .ktp-thumbnail {
            width: 100%; max-width: 200px; aspect-ratio: 16/10;
            background: #64b5f6; border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 6px;
        }
        .ktp-thumbnail .ktp-icon-box {
            width: 40px; height: 40px; background: white; border-radius: 8px;
            display: flex; align-items: center; justify-content: center; margin-right: 10px;
        }
        .ktp-thumbnail i { color: #64b5f6; font-size: 20px; }
        .ktp-filename { font-size: 12px; color: var(--text-muted); }

        .stats-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 24px; }
        .mini-stat-card {
            background: var(--surface); border: 2px solid var(--border); border-radius: 10px;
            padding: 20px; text-align: center;
        }
        .mini-stat-card.yellow { border-color: #fbc02d; }
        .mini-stat-card.red { border-color: #c62828; }
        .mini-stat-card.green { border-color: #2e7d32; }
        .mini-stat-card .mini-stat-icon { font-size: 14px; margin-bottom: 6px; font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 6px; }
        .mini-stat-card.yellow .mini-stat-icon { color: #f9a825; }
        .mini-stat-card.red .mini-stat-icon { color: #c62828; }
        .mini-stat-card.green .mini-stat-icon { color: #2e7d32; }
        .mini-stat-card .mini-stat-number { font-size: 28px; font-weight: 700; }
        .mini-stat-card.yellow .mini-stat-number { color: #f9a825; }
        .mini-stat-card.red .mini-stat-number { color: #c62828; }
        .mini-stat-card.green .mini-stat-number { color: #2e7d32; }

        .orders-section { background: var(--surface); border: 1px solid var(--border); border-radius: 12px; padding: 20px 24px; }
        .orders-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 10px; }
        .orders-header h3 { font-size: 16px; font-weight: 700; }

        .status-dropdown { position: relative; display: inline-block; }
        .status-dropdown-btn {
            background: var(--surface); border: 1px solid var(--border); border-radius: 8px;
            padding: 8px 14px; font-family: inherit; font-size: 13px; font-weight: 700;
            cursor: pointer; display: flex; align-items: center; gap: 8px; color: var(--text-dark);
        }
        .status-dropdown-btn:hover { border-color: var(--primary); }
        .status-dropdown-menu {
            display: none; position: absolute; top: calc(100% + 6px); right: 0;
            background: var(--surface); border: 1px solid var(--border); border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08); min-width: 180px; z-index: 10; overflow: hidden;
        }
        .status-dropdown-menu.open { display: block; }
        .status-dropdown-menu a { display: block; padding: 10px 16px; font-size: 13px; font-weight: 700; color: var(--text-dark); text-decoration: none; }
        .status-dropdown-menu a:hover { background: #f5f5f5; }
        .status-dropdown-menu a.active { background: var(--primary); color: white; }

        .table-wrapper { width: 100%; overflow-x: auto; border: 1px solid var(--border); border-radius: 8px; }
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th { background-color: #f1f1f1; padding: 12px 20px; text-align: left; font-size: 13px; color: var(--text-muted); font-weight: 700; white-space: nowrap; }
        .data-table td { padding: 14px 20px; border-bottom: 1px solid var(--border); font-size: 14px; font-weight: 700; color: var(--text-dark); white-space: nowrap; }
        .data-table tr:last-child td { border-bottom: none; }

        .status-dikirim { color: #0097a7; }
        .status-dicetak { color: #fbc02d; }
        .status-selesai { color: #2e7d32; }
        .status-diproses { color: #e65100; }
        .status-batal { color: #c62828; }

        @media (max-width: 900px) {
            .detail-layout { grid-template-columns: 1fr; }
            .stats-row { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    @include('partials.admin-nav', ['activeMenu' => 'data-pelanggan'])

    <div class="main-wrapper">

        <header class="topbar">
            <div class="topbar-left">
                <button type="button" class="menu-toggle"><i class="fas fa-bars"></i></button>
                <span>Data Pelanggan</span>
            </div>

            <div class="topbar-right">
                <i class="far fa-bell notification-bell"></i>
            </div>
        </header>

        <main class="content-area">

            <a href="{{ route('admin.data-pelanggan') }}" class="back-link">&larr; Kembali</a>

            @php
                $statusClassMap = [
                    'Sedang Dikirim' => 'status-dikirim',
                    'Sedang Dicetak' => 'status-dicetak',
                    'Selesai' => 'status-selesai',
                    'Menunggu Diproses' => 'status-diproses',
                    'Dibatalkan' => 'status-batal',
                ];
            @endphp

            <div class="page-header">
                <h2>Data Pelanggan</h2>
            </div>

            <div class="detail-layout">

                <div class="profile-card">
                    <div class="profile-avatar">{{ strtoupper(substr($pelanggan->nama, 0, 1)) }}</div>

                    <div class="profile-field">
                        <div class="field-label">Id Pelanggan</div>
                        <div class="field-value">PWG-{{ str_pad($pelanggan->id, 4, '0', STR_PAD_LEFT) }}</div>
                    </div>
                    <div class="profile-field">
                        <div class="field-label">Nama Pelanggan</div>
                        <div class="field-value">{{ $pelanggan->nama }}</div>
                    </div>
                    <div class="profile-field">
                        <div class="field-label">Email</div>
                        <div class="field-value">{{ $pelanggan->email }}</div>
                    </div>
                    <div class="profile-field">
                        <div class="field-label">Nomor Telepon</div>
                        <div class="field-value">{{ $pelanggan->nomor_telepon ?? '-' }}</div>
                    </div>
                    <div class="profile-field">
                        <div class="field-label">Alamat</div>
                        <div class="field-value">{{ $pelanggan->alamat ?? '-' }}</div>
                    </div>
                    <div class="profile-field">
                        <div class="field-label">Tanggal Daftar</div>
                        <div class="field-value">{{ \Carbon\Carbon::parse($pelanggan->created_at)->translatedFormat('j F Y') }}</div>
                    </div>
                    <div class="profile-field">
                        <div class="field-label">Status Akun</div>
                        <div class="field-value status-aktif">Aktif</div>
                    </div>

                    <div class="profile-divider"></div>

                    <div class="ktp-label">Dokumen Identitas (KTP)</div>
                    
                    @if($pelanggan->foto_ktp)
                        @php
                            if (str_starts_with($pelanggan->foto_ktp, 'http')) {
                                $urlKtp = $pelanggan->foto_ktp;
                            } else {
                                $urlKtp = env('SUPABASE_URL') . '/storage/v1/object/public/ktp/' . $pelanggan->ktp;
                            }
                        @endphp

                        <a href="{{ $urlKtp }}" target="_blank">
                            <img src="{{ $urlKtp }}" alt="KTP {{ $pelanggan->nama }}" style="width: 100%; max-width: 100%; border-radius: 8px; object-fit: cover; border: 1px solid var(--border); margin-bottom: 6px;">
                        </a>
                        <div class="ktp-filename" style="font-size: 11px; text-decoration: underline; cursor: pointer;">(Klik gambar untuk memperbesar)</div>
                    @else
                        <div class="ktp-thumbnail" style="background: #e0e0e0;">
                            <div class="ktp-icon-box" style="color: #999;"><i class="fas fa-image"></i></div>
                        </div>
                        <div class="ktp-filename">Belum ada KTP yang diunggah</div>
                    @endif
                </div>

                <div>
                    <div class="stats-row">
                        <div class="mini-stat-card yellow">
                            <div class="mini-stat-icon"><i class="far fa-file-alt"></i> Total Pesanan</div>
                            <div class="mini-stat-number">{{ $daftarPesanan->count() }}</div>
                        </div>
                        <div class="mini-stat-card red">
                            <div class="mini-stat-icon"><i class="far fa-times-circle"></i> Total Dibatalkan</div>
                            <div class="mini-stat-number">{{ $daftarPesanan->where('status', 'Dibatalkan')->count() }}</div>
                        </div>
                        <div class="mini-stat-card green">
                            <div class="mini-stat-icon"><i class="fas fa-sync-alt"></i> Total Diterima</div>
                            <div class="mini-stat-number">{{ $daftarPesanan->where('status', 'Selesai')->count() }}</div>
                        </div>
                    </div>

                    <div class="orders-section">
                        <div class="orders-header">
                            <h3>Semua Pesanan</h3>
                            <div class="status-dropdown" id="statusDropdown">
                                <button type="button" class="status-dropdown-btn" id="statusDropdownBtn">
                                    <span id="statusDropdownLabel">Semua Status</span>
                                    <i class="fas fa-chevron-down" style="font-size: 11px;"></i>
                                </button>
                                <div class="status-dropdown-menu" id="statusDropdownMenu">
                                    <a href="#" class="status-filter-item active" data-status="semua">Semua Status</a>
                                    <a href="#" class="status-filter-item" data-status="Menunggu Diproses">Menunggu Diproses</a>
                                    <a href="#" class="status-filter-item" data-status="Sedang Dicetak">Sedang Dicetak</a>
                                    <a href="#" class="status-filter-item" data-status="Sedang Dikirim">Sedang Dikirim</a>
                                    <a href="#" class="status-filter-item" data-status="Selesai">Selesai</a>
                                    <a href="#" class="status-filter-item" data-status="Dibatalkan">Dibatalkan</a>
                                </div>
                            </div>
                        </div>

                        <div class="table-wrapper">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Tanggal</th>
                                        <th>Jenis</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($daftarPesanan as $pesanan)
                                        <tr data-status="{{ $pesanan->status }}">
                                            <td>{{ $pesanan->nomor_pesanan }}</td>
                                            <td>{{ \Carbon\Carbon::parse($pesanan->tanggal_pemesanan)->translatedFormat('j F Y') }}</td>
                                            <td>{{ $pesanan->jenis_pesanan }}</td>
                                            <td class="{{ $statusClassMap[$pesanan->status] ?? '' }}">{{ $pesanan->status }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" style="text-align: center; color: var(--text-muted); font-weight: normal;">Belum ada pesanan</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

        </main>
    </div>

    <script>
        (function () {
            var btn = document.getElementById('statusDropdownBtn');
            var menu = document.getElementById('statusDropdownMenu');
            var label = document.getElementById('statusDropdownLabel');
            var items = document.querySelectorAll('.status-filter-item');
            var rows = document.querySelectorAll('.data-table tbody tr[data-status]');

            btn.addEventListener('click', function () {
                menu.classList.toggle('open');
            });

            document.addEventListener('click', function (e) {
                if (!document.getElementById('statusDropdown').contains(e.target)) {
                    menu.classList.remove('open');
                }
            });

            items.forEach(function (item) {
                item.addEventListener('click', function (e) {
                    e.preventDefault();
                    var status = this.dataset.status;

                    items.forEach(function (i) { i.classList.remove('active'); });
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