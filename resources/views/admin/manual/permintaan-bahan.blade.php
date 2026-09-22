```blade
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Permintaan Bahan - Admin Literasi Manual</title>

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary: #c62828;
            --primary-hover: #b71c1c;
            --background: #f4f6f9;
            --surface: #ffffff;
            --text-dark: #111111;
            --text-muted: #757575;
            --border: #e0e0e0;

            --warning-bg: #fff8e1;
            --warning-text: #d4a017;

            --danger-bg: #ffebee;
            --danger-text: #c62828;

            --success-bg: #e8f5e9;
            --success-text: #2e7d32;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            min-height: 100%;
            font-family: Arial, Helvetica, sans-serif;
            background: var(--background);
            color: var(--text-dark);
        }

        body {
            display: flex;
            min-height: 100vh;
            overflow: hidden;
        }

        /* =========================================
           MAIN WRAPPER
        ========================================= */

        .main-wrapper {
            flex: 1;
            min-width: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* =========================================
           TOPBAR
        ========================================= */

        .topbar {
            height: 70px;
            min-height: 70px;
            background: var(--surface);
            border-bottom: 1px solid var(--border);

            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 0 28px;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 16px;
            min-width: 0;
        }

        .menu-toggle {
            width: 38px;
            height: 38px;

            border: none;
            background: transparent;
            color: #333;

            border-radius: 8px;

            display: flex;
            align-items: center;
            justify-content: center;

            cursor: pointer;
            font-size: 18px;

            transition: 0.2s ease;
        }

        .menu-toggle:hover {
            background: #f5f5f5;
            color: var(--primary);
        }

        .topbar-title {
            font-size: 20px;
            font-weight: 600;
            white-space: nowrap;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        /* =========================================
           NOTIFICATION
        ========================================= */

        .notification-btn {
            position: relative;

            width: 38px;
            height: 38px;

            display: flex;
            align-items: center;
            justify-content: center;

            color: #555;
            text-decoration: none;

            border-radius: 50%;

            transition: 0.2s ease;
        }

        .notification-btn:hover {
            background: #f5f5f5;
            color: var(--primary);
        }

        .notification-btn i {
            font-size: 18px;
        }

        .notification-dot {
            position: absolute;
            top: 6px;
            right: 7px;

            width: 8px;
            height: 8px;

            background: var(--primary);
            border-radius: 50%;

            border: 2px solid white;
        }

        /* =========================================
           PROFILE
        ========================================= */

        .profile-link {
            display: flex;
            align-items: center;
            gap: 10px;

            color: var(--text-dark);
            text-decoration: none;

            font-size: 14px;
            font-weight: 500;
        }

        .profile-link:hover {
            color: var(--primary);
        }

        .profile-avatar {
            width: 38px;
            height: 38px;

            border-radius: 50%;

            object-fit: cover;

            background: #eeeeee;

            display: flex;
            align-items: center;
            justify-content: center;

            color: #777;
        }

        .profile-avatar i {
            font-size: 17px;
        }

        /* =========================================
           CONTENT
        ========================================= */

        .content-area {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;

            background: var(--background);

            padding: 28px 40px 40px;
        }

        /* =========================================
           PAGE HEADER
        ========================================= */

        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;

            gap: 20px;

            margin-bottom: 24px;
        }

        .page-header h1 {
            margin: 0 0 8px;

            font-size: 26px;
            font-weight: 700;

            color: var(--text-dark);
        }

        .page-header p {
            margin: 0;

            color: var(--text-muted);

            font-size: 14px;
            line-height: 1.5;
        }

        .btn-add {
            border: none;

            background: var(--primary);
            color: white;

            padding: 12px 18px;

            border-radius: 7px;

            font-size: 14px;
            font-weight: 600;

            cursor: pointer;

            white-space: nowrap;

            transition: 0.2s ease;
        }

        .btn-add:hover {
            background: var(--primary-hover);
        }

        /* =========================================
           FILTER
        ========================================= */

        .filter-container {
            width: 100%;

            display: flex;
            align-items: center;

            gap: 15px;

            margin-bottom: 20px;
        }

        .search-box {
            position: relative;
            flex: 1;
            min-width: 220px;
        }

        .search-box i {
            position: absolute;

            left: 14px;
            top: 50%;

            transform: translateY(-50%);

            color: #999;

            font-size: 14px;
        }

        .search-box input {
            width: 100%;
            height: 42px;

            border: 1px solid var(--border);
            border-radius: 7px;

            background: white;

            padding: 0 14px 0 40px;

            font-size: 14px;

            outline: none;

            transition: 0.2s ease;
        }

        .search-box input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(198, 40, 40, 0.08);
        }

        .filter-container select,
        .filter-container input[type="date"] {
            height: 42px;

            border: 1px solid var(--border);
            border-radius: 7px;

            background: white;

            padding: 0 12px;

            font-size: 14px;

            color: #333;

            outline: none;
        }

        .filter-container select {
            min-width: 220px;
        }

        .filter-container input[type="date"] {
            min-width: 165px;
        }

        .filter-container select:focus,
        .filter-container input[type="date"]:focus {
            border-color: var(--primary);
        }

        /* =========================================
           TABLE
        ========================================= */

        .table-wrapper {
            width: 100%;

            overflow-x: auto;
            overflow-y: hidden;

            background: white;

            border: 1px solid var(--border);
            border-radius: 8px;

            -webkit-overflow-scrolling: touch;
        }

        /*
         * Sengaja menggunakan min-width.
         * Di HP tabel tetap utuh dan dapat digeser
         * ke kiri/kanan agar kolom Aksi tidak terpotong.
         */
        .request-table {
            width: 100%;
            min-width: 1100px;

            border-collapse: collapse;
        }

        .request-table th {
            background: #fafafa;

            color: #555;

            font-size: 13px;
            font-weight: 600;

            text-align: left;

            padding: 15px 16px;

            border-bottom: 1px solid var(--border);

            white-space: nowrap;
        }

        .request-table td {
            padding: 15px 16px;

            font-size: 13px;

            color: #333;

            border-bottom: 1px solid #eeeeee;

            vertical-align: middle;
        }

        .request-table tbody tr:last-child td {
            border-bottom: none;
        }

        .request-table tbody tr:hover {
            background: #fcfcfc;
        }

        .empty-row {
            text-align: center !important;

            padding: 40px 20px !important;

            color: var(--text-muted) !important;
        }

        /* =========================================
           STATUS
        ========================================= */

        .status-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            min-width: 145px;

            padding: 7px 11px;

            border-radius: 20px;

            font-size: 12px;
            font-weight: 600;

            line-height: 1.3;

            text-align: center;
        }

        .status-menunggu-pemeriksaan {
            background: var(--warning-bg);
            color: var(--warning-text);
        }

        .status-perlu-perbaikan {
            background: var(--danger-bg);
            color: var(--danger-text);
        }

        .status-disetujui {
            background: var(--success-bg);
            color: var(--success-text);
        }

        .status-menunggu-tanda-tangan {
            background: #fff3e0;
            color: #ef6c00;
        }

        .status-selesai {
            background: var(--success-bg);
            color: var(--success-text);
        }

        .status-default {
            background: #eeeeee;
            color: #616161;
        }

        /* =========================================
           DETAIL BUTTON
        ========================================= */

        .btn-detail {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 7px;

            min-width: 78px;

            padding: 8px 12px;

            background: var(--primary);
            color: white;

            border-radius: 6px;

            text-decoration: none;

            font-size: 12px;
            font-weight: 600;

            white-space: nowrap;

            transition: 0.2s ease;
        }

        .btn-detail:hover {
            background: var(--primary-hover);
        }

        /* =========================================
           SCROLLBAR TABLE
        ========================================= */

        .table-wrapper::-webkit-scrollbar {
            height: 8px;
        }

        .table-wrapper::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .table-wrapper::-webkit-scrollbar-thumb {
            background: #c7c7c7;
            border-radius: 10px;
        }

        .table-wrapper::-webkit-scrollbar-thumb:hover {
            background: #999;
        }

        /* =========================================
           RESPONSIVE TABLET
        ========================================= */

        @media (max-width: 900px) {

            .content-area {
                padding: 24px 22px 30px;
            }

            .page-header {
                flex-direction: column;
            }

            .btn-add {
                align-self: flex-start;
            }

            .filter-container {
                flex-wrap: wrap;
            }

            .search-box {
                flex: 1 1 100%;
            }

            .filter-container select,
            .filter-container input[type="date"] {
                flex: 1;
            }
        }

        /* =========================================
           RESPONSIVE MOBILE
        ========================================= */

        @media (max-width: 600px) {

            .topbar {
                height: 62px;
                min-height: 62px;

                padding: 0 14px;
            }

            .topbar-left {
                gap: 8px;
            }

            .topbar-title {
                font-size: 17px;

                max-width: 170px;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .topbar-right {
                gap: 5px;
            }

            .profile-link > span {
                display: none;
            }

            .profile-avatar {
                width: 35px;
                height: 35px;
            }

            .notification-btn {
                width: 35px;
                height: 35px;
            }

            .content-area {
                padding: 20px 14px 28px;
            }

            .page-header {
                margin-bottom: 18px;
                gap: 14px;
            }

            .page-header h1 {
                font-size: 22px;
            }

            .page-header p {
                font-size: 13px;
            }

            .btn-add {
                width: 100%;
                padding: 11px 15px;
            }

            .filter-container {
                display: flex;
                flex-direction: column;
                align-items: stretch;

                gap: 10px;

                margin-bottom: 16px;
            }

            .search-box {
                width: 100%;
                min-width: 0;
            }

            .filter-container select,
            .filter-container input[type="date"] {
                width: 100%;
                min-width: 0;
                flex: none;
            }

            .table-wrapper {
                border-radius: 7px;
            }

            .request-table {
                min-width: 1100px;
            }

            .request-table th,
            .request-table td {
                padding: 13px 14px;
            }
        }
    </style>
</head>

<body>

    {{-- SIDEBAR ADMIN LITERASI MANUAL --}}
    @include('partials.admin-nav', [
        'activeMenu' => $activeMenu ?? 'permintaan-bahan'
    ])

    <div class="main-wrapper">

        {{-- =========================================
             TOPBAR
        ========================================= --}}
        <div class="topbar">

            <div class="topbar-left">

                <button
                    type="button"
                    class="menu-toggle"
                    aria-label="Buka atau tutup sidebar"
                >
                    <i class="fas fa-bars"></i>
                </button>

                <div class="topbar-title">
                    Permintaan Bahan
                </div>

            </div>

            <div class="topbar-right">

                {{-- NOTIFICATION --}}
                <a href="#" class="notification-btn" aria-label="Notifikasi">
                    <i class="fas fa-bell"></i>
                    <span class="notification-dot"></span>
                </a>

                {{-- PROFILE ADMIN MANUAL --}}
                <a
                    href="{{ route('admin.manual.profile') }}"
                    class="profile-link"
                >
                    <span>
                        {{ auth()->user()->nama ?? 'Admin Manual' }}
                    </span>

                    @if(auth()->user()->foto_profil ?? false)
                        <img
                            src="{{ asset('storage/' . auth()->user()->foto_profil) }}"
                            alt="Foto Profil"
                            class="profile-avatar"
                        >
                    @else
                        <div class="profile-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                    @endif
                </a>

            </div>
        </div>


        {{-- =========================================
             CONTENT
        ========================================= --}}
        <main class="content-area">

            {{-- PAGE HEADER --}}
            <div class="page-header">

                <div>
                    <h1>Permintaan Bahan</h1>

                    <p>
                        Ajukan dan pantau status pengajuan bahan
                        untuk mendukung proses pencetakan.
                    </p>
                </div>

                <button
                    type="button"
                    class="btn-add"
                >
                    <i class="fas fa-plus"></i>
                    Ajukan Permintaan Bahan
                </button>

            </div>


            {{-- =========================================
                 FILTER
            ========================================= --}}
            <form
                method="GET"
                action="{{ route('admin.manual.permintaan-bahan') }}"
                class="filter-container"
            >

                {{-- SEARCH --}}
                <div class="search-box">

                    <i class="fas fa-search"></i>

                    <input
                        type="text"
                        name="search"
                        value="{{ $search ?? '' }}"
                        placeholder="Cari permintaan bahan..."
                    >

                </div>


                {{-- STATUS --}}
                <select
                    name="status"
                    onchange="this.form.submit()"
                >
                    <option value="">
                        Semua Status
                    </option>

                    <option
                        value="Menunggu Pemeriksaan"
                        {{ ($statusFilter ?? '') === 'Menunggu Pemeriksaan' ? 'selected' : '' }}
                    >
                        Menunggu Pemeriksaan
                    </option>

                    <option
                        value="Perlu Diperbaiki"
                        {{ ($statusFilter ?? '') === 'Perlu Diperbaiki' ? 'selected' : '' }}
                    >
                        Perlu Diperbaiki
                    </option>

                    <option
                        value="Disetujui"
                        {{ ($statusFilter ?? '') === 'Disetujui' ? 'selected' : '' }}
                    >
                        Disetujui
                    </option>

                    <option
                        value="Menunggu Tanda Tangan"
                        {{ ($statusFilter ?? '') === 'Menunggu Tanda Tangan' ? 'selected' : '' }}
                    >
                        Menunggu Tanda Tangan
                    </option>

                    <option
                        value="Selesai"
                        {{ ($statusFilter ?? '') === 'Selesai' ? 'selected' : '' }}
                    >
                        Selesai
                    </option>
                </select>


                {{-- DATE --}}
                <input
                    type="date"
                    name="date"
                    value="{{ $dateFilter ?? '' }}"
                    onchange="this.form.submit()"
                >

            </form>


            {{-- =========================================
                 TABLE
            ========================================= --}}
            <div class="table-wrapper">

                <table class="request-table">

                    <thead>
                        <tr>

                            <th>
                                ID Permintaan
                            </th>

                            <th>
                                ID Pencetakan
                            </th>

                            <th>
                                Nama Buku
                            </th>

                            <th>
                                Bahan
                            </th>

                            <th>
                                Jumlah
                            </th>

                            <th>
                                Tanggal
                            </th>

                            <th>
                                PIC
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Aksi
                            </th>

                        </tr>
                    </thead>


                    <tbody>

                        @forelse($permintaanBahan as $item)

                            @php

                                $status = strtolower(
                                    trim($item->status ?? '')
                                );

                                $statusClass = 'status-default';

                                if (
                                    str_contains(
                                        $status,
                                        'menunggu pemeriksaan'
                                    )
                                    ||
                                    (
                                        str_contains($status, 'menunggu')
                                        &&
                                        !str_contains($status, 'tanda tangan')
                                    )
                                ) {
                                    $statusClass =
                                        'status-menunggu-pemeriksaan';
                                }

                                if (
                                    str_contains($status, 'perbaikan')
                                    ||
                                    str_contains($status, 'diperbaiki')
                                    ||
                                    str_contains($status, 'kendala')
                                ) {
                                    $statusClass =
                                        'status-perlu-perbaikan';
                                }

                                if (
                                    str_contains($status, 'disetujui')
                                ) {
                                    $statusClass =
                                        'status-disetujui';
                                }

                                if (
                                    str_contains($status, 'tanda tangan')
                                ) {
                                    $statusClass =
                                        'status-menunggu-tanda-tangan';
                                }

                                if (
                                    str_contains($status, 'selesai')
                                ) {
                                    $statusClass =
                                        'status-selesai';
                                }


                                $idPencetakan =
                                    $item->pencetakan->kode_cetak
                                    ?? '-';


                                $namaBuku =
                                    $item->pencetakan->buku->judul
                                    ?? '-';


                                $namaBahan =
                                    $item->nama_bahan
                                    ?? $item->bahan
                                    ?? '-';


                                $picTampil =
                                    $item->pencetakan->pic
                                    ?? '-';


                                $jumlahTampil =
                                    ($item->jumlah ?? '-')
                                    . ' '
                                    . ($item->satuan ?? '');

                            @endphp


                            <tr>

                                {{-- ID PERMINTAAN --}}
                                <td>
                                    {{ $item->id_permintaan ?? $item->id }}
                                </td>


                                {{-- ID PENCETAKAN --}}
                                <td>
                                    {{ $idPencetakan }}
                                </td>


                                {{-- NAMA BUKU --}}
                                <td>
                                    {{ $namaBuku }}
                                </td>


                                {{-- BAHAN --}}
                                <td>
                                    {{ $namaBahan }}
                                </td>


                                {{-- JUMLAH --}}
                                <td>
                                    {{ trim($jumlahTampil) }}
                                </td>


                                {{-- TANGGAL --}}
                                <td>
                                    {{ optional($item->created_at)->format('d F Y') }}
                                </td>


                                {{-- PIC --}}
                                <td>
                                    {{ $picTampil }}
                                </td>


                                {{-- STATUS --}}
                                <td>

                                    <span class="status-badge {{ $statusClass }}">

                                        {!! nl2br(
                                            e(
                                                str_replace(
                                                    ' ',
                                                    "\n",
                                                    ucwords(
                                                        $item->status
                                                        ?? 'Menunggu Pemeriksaan'
                                                    )
                                                )
                                            )
                                        ) !!}

                                    </span>

                                </td>


                                {{-- AKSI --}}
                                <td>

                                    <a
                                        href="{{ route('admin.manual.permintaan-bahan.detail', $item->id) }}"
                                        class="btn-detail"
                                    >
                                        <i class="fas fa-eye"></i>
                                        Detail
                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="9"
                                    class="empty-row"
                                >
                                    <i
                                        class="fas fa-inbox"
                                        style="font-size: 28px; margin-bottom: 10px;"
                                    ></i>

                                    <br>

                                    Belum ada data permintaan bahan.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </main>

    </div>

</body>
</html>
```
