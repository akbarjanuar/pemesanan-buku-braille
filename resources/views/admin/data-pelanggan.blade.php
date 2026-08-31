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

            <form method="GET" class="search-section">
                <label for="cariPelanggan">Cari data pelanggan</label>
                <input type="text" id="cariPelanggan" name="cari" class="search-input" placeholder="Nama atau email pelanggan..." value="{{ request('cari') }}">
            </form>

            {{-- DATA DUMMY SEMENTARA — nanti diganti data asli dari database --}}
            @php
                $daftarPelanggan = [
                    ['id' => 'PWG-0001', 'nama' => 'Budi Santoso', 'telepon' => '081234567890', 'tanggal' => '1 April 2024', 'pesanan' => 4, 'status' => 'Aktif'],
                    ['id' => 'PWG-0002', 'nama' => 'Yayasan Tunas Bangsa', 'telepon' => '083456789012', 'tanggal' => '14 April 2024', 'pesanan' => 1, 'status' => 'Aktif'],
                    ['id' => 'PWG-0003', 'nama' => 'SLB Negeri 1 Bandung', 'telepon' => '022-1234567', 'tanggal' => '5 Agustus 2024', 'pesanan' => 1, 'status' => 'Aktif'],
                    ['id' => 'PWG-0004', 'nama' => 'Pertuni Kota Surabaya', 'telepon' => '08567891234', 'tanggal' => '7 Agustus 2024', 'pesanan' => 1, 'status' => 'Aktif'],
                    ['id' => 'PWG-0005', 'nama' => 'Siti Rahayu', 'telepon' => '082956760016', 'tanggal' => '9 September 2024', 'pesanan' => 2, 'status' => 'Aktif'],
                ];
            @endphp

            <p class="result-count">Menampilkan <strong>{{ count($daftarPelanggan) }}</strong> pelanggan</p>

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
                            @foreach($daftarPelanggan as $pelanggan)
                                <tr>
                                    <td>{{ $pelanggan['id'] }}</td>
                                    <td>{{ $pelanggan['nama'] }}</td>
                                    <td>{{ $pelanggan['telepon'] }}</td>
                                    <td>{{ $pelanggan['tanggal'] }}</td>
                                    <td>{{ $pelanggan['pesanan'] }}</td>
                                    <td class="status-{{ strtolower($pelanggan['status']) }}">{{ $pelanggan['status'] }}</td>
                                    <td><a href="/admin/data-pelanggan/{{ $pelanggan['id'] }}" class="btn-detail">Detail</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>

</body>
</html>