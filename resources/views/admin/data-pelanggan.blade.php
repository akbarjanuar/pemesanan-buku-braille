<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pelanggan - BrailleKita</title>

    <style>
        .page-header { margin-bottom: 20px; }
        .page-header h2 { font-size: 22px; font-weight: 700; margin-bottom: 4px; }
        .page-header p { color: var(--text-muted); font-size: 14px; }

        .search-section { margin-bottom: 20px; }
        .search-section label { display: block; font-weight: 700; font-size: 15px; margin-bottom: 8px; }
        .search-input {
            width: 100%;
            max-width: 420px;
            padding: 10px 16px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-family: inherit;
            font-size: 14px;
            outline: none;
        }
        .search-input:focus { border-color: var(--primary); }

        .result-count { margin-bottom: 16px; font-size: 14px; color: var(--text-dark); }
        .result-count strong { font-weight: 700; }

        .table-card { background-color: var(--surface); border: 1px solid var(--border); border-radius: 12px; overflow: hidden; }
        .table-wrapper { width: 100%; overflow-x: auto; }
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th { background-color: #f1f1f1; padding: 14px 24px; text-align: left; font-size: 13px; color: var(--text-muted); font-weight: 700; white-space: nowrap; }
        .data-table td { padding: 16px 24px; border-bottom: 1px solid var(--border); font-size: 14px; font-weight: 700; color: var(--text-dark); white-space: nowrap; }
        .data-table tr:last-child td { border-bottom: none; }

        .status-aktif { color: #2e7d32; }
        .status-nonaktif { color: #c62828; }

        .btn-detail {
            background-color: var(--primary); color: white; padding: 6px 16px; border-radius: 6px;
            font-size: 13px; font-weight: 700; border: none; cursor: pointer; font-family: inherit;
            display: inline-block; text-decoration: none;
        }
        .btn-detail:hover { background-color: var(--primary-hover); }
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

            <div class="page-header">
                <h2>Data Pelanggan</h2>
                <p>Monitoring data pelanggan untuk memantau dan mengelola data pelanggan.</p>
            </div>

            <form method="GET" action="{{ route('admin.data-pelanggan') }}" class="search-section">
                <label for="cariPelanggan">Cari data pelanggan</label>
                {{-- name diubah menjadi "search" agar sesuai dengan controller --}}
                <input type="text" id="cariPelanggan" name="search" class="search-input" placeholder="Nama atau email pelanggan..." value="{{ request('search') }}">
            </form>

            <p class="result-count">Menampilkan <strong>{{ $daftarPelanggan->count() }}</strong> pelanggan</p>

            <div class="table-card">
                <div class="table-wrapper">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Id Pelanggan</th>
                                <th>Nama Pelanggan</th>
                                <th>No Telepon</th>
                                <th>Tanggal Daftar</th>
                                <th>Pesanan</th>
                                <th>Status Akun</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Menggunakan data dari database --}}
                            @forelse($daftarPelanggan as $pelanggan)
                                <tr>
                                    <td>PWG-{{ str_pad($pelanggan->id, 4, '0', STR_PAD_LEFT) }}</td>
                                    <td>{{ $pelanggan->nama }}</td>
                                    <td>{{ $pelanggan->nomor_telepon ?? '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($pelanggan->created_at)->translatedFormat('j F Y') }}</td>
                                    <td>{{ $pelanggan->pesanan_count ?? 0 }}</td>
                                    <td class="status-aktif">Aktif</td>
                                    <td><a href="{{ route('admin.detail-pelanggan', $pelanggan->id) }}" class="btn-detail">Detail</a></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" style="text-align: center; color: var(--text-muted); font-weight: normal;">
                                        Tidak ada data pelanggan ditemukan.
                                    </td>
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