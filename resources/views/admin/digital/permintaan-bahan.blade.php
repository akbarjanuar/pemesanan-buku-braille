<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permintaan Bahan - Admin Literasi Digital</title>
    <!-- Font Awesome -->
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
            --warning-text: #d4a017;
            --danger-text: #c62828;
            --success-text: #2e7d32;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; }
        body { background: var(--background); color: var(--text-dark); display: flex; min-height: 100vh; }
        .main-wrapper { flex: 1; min-width: 0; display: flex; flex-direction: column; height: 100vh; overflow: hidden; }

        /* TOPBAR */
        .topbar { height: 70px; min-height: 70px; background: #ffffff; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; padding: 0 28px; z-index: 100; }
        .topbar-left { display: flex; align-items: center; gap: 14px; }
        .menu-toggle { width: 38px; height: 38px; display: inline-flex; align-items: center; justify-content: center; border: none; background: transparent; color: #757575; font-size: 21px; cursor: pointer; border-radius: 6px; }
        .topbar-title { font-size: 20px; font-weight: 700; color: #111111; }
        
        .topbar-right { display: flex; align-items: center; gap: 20px; }
        
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
        
        .content-area { flex: 1; overflow-y: auto; padding: 28px 40px 40px; background: #ffffff;}

        /* Header Page */
        .page-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 20px; }
        .page-header h1 { font-size: 20px; font-weight: 700; margin-bottom: 4px; }
        .page-header p { color: var(--text-muted); font-size: 13px; }
        .btn-add { background: var(--primary); color: white; padding: 10px 16px; border-radius: 6px; text-decoration: none; font-size: 13px; font-weight: 600; border: none; cursor: pointer; }
        
        /* Filters */
        .filter-container { display: flex; gap: 15px; margin-bottom: 25px; align-items: center; }
        .search-box { flex: 1; position: relative; }
        .search-box i { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #999; }
        .search-box input { width: 100%; padding: 12px 14px 12px 38px; border: 1px solid var(--border); border-radius: 6px; font-size: 13px; outline: none; }
        .filter-select, .filter-date { padding: 12px 14px; border: 1px solid var(--border); border-radius: 6px; font-size: 13px; outline: none; background: white; min-width: 180px; }

        /* Table */
        .table-wrapper { width: 100%; overflow-x: auto; border: 1px solid var(--border); border-radius: 8px; }
        .request-table { width: 100%; border-collapse: collapse; min-width: 1100px; }
        .request-table thead { background: #f5f5f5; border-bottom: 2px solid var(--border); }
        .request-table th { padding: 14px; text-align: left; color: #555; font-size: 12px; font-weight: 700; }
        .request-table td { padding: 16px 14px; border-bottom: 1px solid #eeeeee; font-size: 13px; font-weight: 600; vertical-align: middle; }
        .request-table tbody tr:hover { background: #fafafa; }
        
        /* Status text colors */
        .status-menunggu-pemeriksaan { color: var(--warning-text); font-weight: 700; }
        .status-perlu-perbaikan { color: var(--danger-text); font-weight: 700; }
        .status-default { color: #333; font-weight: 700; }

        .btn-detail { background: var(--primary); color: white; border: none; padding: 6px 16px; border-radius: 4px; font-size: 12px; font-weight: 700; cursor: pointer; text-decoration: none; }
    </style>
</head>
<body>

    @include('partials.admin-digital-nav', ['activeMenu' => $activeMenu ?? 'permintaan-bahan'])

    <div class="main-wrapper">
        <div class="topbar">
            <div class="topbar-left">
                <button type="button" class="menu-toggle"><i class="fas fa-bars"></i></button>
                <div class="topbar-title">Permintaan Bahan</div>
            </div>
            <div class="topbar-right">
                <!-- Ikon Notifikasi dengan Titik Merah -->
                <div class="notification-button">
                    <i class="far fa-bell"></i>
                    <span class="notification-dot"></span>
                </div>

                <!-- Profil Pengguna -->
                <a href="{{ route('admin.digital.profile') }}" style="display: flex; align-items: center; gap: 12px; text-decoration: none; color: var(--text-dark); cursor: pointer;">
                    <span style="font-weight: 700; font-size: 15px;">
                        {{ auth()->user()->nama ?? 'Admin Digital' }}
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
        </div>

        <main class="content-area">
            <div class="page-header">
                <div>
                    <h1>Permintaan Bahan</h1>
                    <p>Ajukan dan pantau status pengajuan bahan untuk mendukung proses pencetakan.</p>
                </div>
                <button class="btn-add">+ Ajukan Permintaan Bahan</button>
            </div>

            <form method="GET" action="{{ route('admin.digital.permintaan-bahan') }}" class="filter-container">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" placeholder="Cari Id Permintaan, Id Pencetakan atau Nama Buku...." value="{{ $search ?? '' }}">
                </div>
                <select name="status" class="filter-select" onchange="this.form.submit()">
                    <option value="semua" {{ ($statusFilter ?? 'semua') === 'semua' ? 'selected' : '' }}>Semua</option>
                    <option value="menunggu pemeriksaan" {{ ($statusFilter ?? '') === 'menunggu pemeriksaan' ? 'selected' : '' }}>Menunggu pemeriksaan</option>
                    <option value="perlu diperbaiki" {{ ($statusFilter ?? '') === 'perlu diperbaiki' ? 'selected' : '' }}>Perlu diperbaiki</option>
                    <option value="disetujui" {{ ($statusFilter ?? '') === 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="menunggu tanda tangan" {{ ($statusFilter ?? '') === 'menunggu tanda tangan' ? 'selected' : '' }}>Menunggu tanda tangan</option>
                    <option value="selesai" {{ ($statusFilter ?? '') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
                <input type="date" name="date" class="filter-date" value="{{ $dateFilter ?? '' }}" onchange="this.form.submit()">
            </form>

            <div class="table-wrapper">
                <table class="request-table">
                    <thead>
                        <tr>
                            <th>Id Permintaan</th>
                            <th>Id Pencetakan</th>
                            <th>Nama Buku</th>
                            <th>Bahan</th>
                            <th>Jumlah</th>
                            <th>Tanggal</th>
                            <th>PIC</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($permintaanBahan as $item)
                        @php
                            $status = strtolower(trim($item->status ?? ''));
                            $statusClass = 'status-default';
                            if(str_contains($status, 'menunggu')) $statusClass = 'status-menunggu-pemeriksaan';
                            if(str_contains($status, 'perbaikan') || str_contains($status, 'kendala')) $statusClass = 'status-perlu-perbaikan';

                            // Mengambil Id Pencetakan (prioritaskan kode_cetak, jika kosong tampilkan ID angka atau Pencetakan #ID)
                            $idPencetakan = '-';
                            if ($item->pencetakan) {
                                $idPencetakan = $item->pencetakan->kode_cetak ?? ('PRNT-' . $item->pencetakan->id);
                            } elseif ($item->pencetakan_id) {
                                $idPencetakan = 'PRNT-' . $item->pencetakan_id;
                            }
                            
                            // Cek nama buku dari relasi pencetakan -> buku, atau langsung ke relasi buku
                            $namaBuku = '-';
                            if ($item->pencetakan && $item->pencetakan->buku) {
                                $namaBuku = $item->pencetakan->buku->judul;
                            } elseif ($item->buku) {
                                $namaBuku = $item->buku->judul;
                            }

                            $namaBahan = $item->nama_bahan ?? '-';
                            
                            // Mengambil PIC dari relasi pencetakan->pic atau fallback ke kolom pengaju
                            $picTampil = '-';
                            if ($item->pencetakan && !empty($item->pencetakan->pic)) {
                                $picTampil = $item->pencetakan->pic;
                            } elseif (!empty($item->pengaju)) {
                                $picTampil = $item->pengaju;
                            }
                            
                            // Format jumlah dan satuan
                            $jumlahTampil = ($item->jumlah ?? '0') . ' ' . ($item->satuan ?? '');
                        @endphp
                            <tr>
                                <td>{{ $item->id_permintaan ?? $item->id }}</td>
                                <td>{{ $idPencetakan }}</td>
                                <td>{{ $namaBuku }}</td>
                                <td>{{ $namaBahan }}</td>
                                <td>{{ $jumlahTampil }}</td>
                                <td>{{ optional($item->created_at)->format('d F Y') }}</td>
                                <td>{{ $picTampil }}</td>
                                <td>
                                    <div class="{{ $statusClass }}">
                                        {{ ucwords($item->status ?? 'Menunggu Diproses') }}
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('admin.digital.permintaan-bahan.detail', $item->id) }}" class="btn-detail">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" style="text-align: center; color: #999; padding: 40px;">Belum ada data permintaan bahan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>