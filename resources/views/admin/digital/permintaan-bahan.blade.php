<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Permintaan Bahan - Admin Literasi Digital</title>

    <!-- Font Awesome -->
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

            --success: #2e7d32;
            --warning: #f57c00;
            --danger: #c62828;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background: var(--background);
            color: var(--text-dark);
        }

        /* =====================================================
           MAIN WRAPPER
        ===================================================== */

        .main-wrapper {
            flex: 1;
            min-width: 0;

            display: flex;
            flex-direction: column;

            height: 100vh;
            overflow: hidden;
        }

        /* =====================================================
           TOPBAR
        ===================================================== */

        .topbar {
            height: 70px;
            min-height: 70px;

            background: #ffffff;
            border-bottom: 1px solid var(--border);

            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 0 28px;

            position: relative;
            z-index: 100;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 14px;

            min-width: 0;
        }

        .menu-toggle {
            width: 38px;
            height: 38px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border: none;
            background: transparent;

            color: #757575;

            font-size: 21px;

            cursor: pointer;

            border-radius: 6px;
        }

        .menu-toggle:hover {
            background: #f5f5f5;
        }

        .topbar-title {
            font-size: 20px;
            font-weight: 700;

            color: #111111;

            white-space: nowrap;
        }

        .topbar-right {
            display: flex;
            align-items: center;

            gap: 20px;

            flex-shrink: 0;
        }

        /* Notification */

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

        .notification-button:hover {
            background: #f5f5f5;
        }

        .notification-dot {
            position: absolute;

            top: 7px;
            right: 7px;

            width: 7px;
            height: 7px;

            background: var(--primary);

            border-radius: 50%;
        }

        /* User */

        .topbar-user {
            display: flex;
            align-items: center;

            gap: 10px;

            text-decoration: none;
            color: #111111;

            font-size: 14px;
            font-weight: 600;

            white-space: nowrap;
        }

        .topbar-user:hover {
            color: var(--primary);
        }

        .topbar-user img,
        .user-avatar {
            width: 38px;
            height: 38px;

            border-radius: 50%;

            object-fit: cover;
        }

        .user-avatar {
            display: flex;
            align-items: center;
            justify-content: center;

            background: var(--primary);
            color: white;

            font-weight: 700;
        }

        /* =====================================================
           CONTENT
        ===================================================== */

        .content-area {
            flex: 1;

            overflow-y: auto;

            padding: 28px 40px 40px;
        }

        /* Page Heading */

        .page-heading {
            margin-bottom: 28px;
        }

        .page-heading h1 {
            font-size: 28px;
            line-height: 1.2;

            font-weight: 700;

            color: #111111;
        }

        /* =====================================================
           REQUEST INFORMATION CARD
        ===================================================== */

        .request-card {
            background: #ffffff;

            border: 1px solid var(--border);

            border-radius: 16px;

            padding: 28px 30px;

            margin-bottom: 28px;
        }

        .request-card h2 {
            font-size: 20px;

            font-weight: 700;

            margin-bottom: 7px;
        }

        .request-card-description {
            color: var(--text-muted);

            font-size: 15px;

            line-height: 1.5;

            margin-bottom: 22px;
        }

        /* Filter */

        .filter-row {
            display: flex;
            align-items: center;

            gap: 12px;
        }

        .filter-select {
            width: 260px;

            height: 52px;

            padding: 0 16px;

            border: 1px solid var(--border);

            border-radius: 10px;

            background: #ffffff;

            color: #111111;

            font-size: 14px;

            font-weight: 600;

            outline: none;

            cursor: pointer;
        }

        .filter-select:focus {
            border-color: var(--primary);
        }

        /* =====================================================
           TABLE
        ===================================================== */

        .table-card {
            background: #ffffff;

            border: 1px solid var(--border);

            border-radius: 16px;

            overflow: hidden;
        }

        .table-wrapper {
            width: 100%;

            overflow-x: auto;
        }

        .request-table {
            width: 100%;

            border-collapse: collapse;

            min-width: 1050px;
        }

        .request-table thead {
            background: #f1f1f1;
        }

        .request-table th {
            padding: 17px 14px;

            text-align: left;

            color: #757575;

            font-size: 13px;

            font-weight: 700;

            white-space: nowrap;
        }

        .request-table td {
            padding: 18px 14px;

            border-top: 1px solid #eeeeee;

            font-size: 14px;

            vertical-align: middle;
        }

        .request-table tbody tr:hover {
            background: #fafafa;
        }

        .request-id {
            font-weight: 700;

            color: #111111;

            white-space: nowrap;
        }

        .request-date {
            font-weight: 600;

            white-space: nowrap;
        }

        .division {
            font-weight: 600;

            white-space: nowrap;
        }

        .material-name {
            font-weight: 600;
        }

        .purpose {
            color: #333333;

            min-width: 210px;
        }

        /* =====================================================
           STATUS
        ===================================================== */

        .status {
            font-size: 13px;

            font-weight: 700;

            white-space: nowrap;
        }

        .status-menunggu {
            color: #f57c00;
        }

        .status-proses {
            color: #f57c00;
        }

        .status-selesai {
            color: var(--success);
        }

        .status-kendala {
            color: var(--danger);
        }

        .status-default {
            color: #757575;
        }

        /* =====================================================
           DETAIL BUTTON
        ===================================================== */

        .detail-btn {
            display: inline-flex;

            align-items: center;
            justify-content: center;

            height: 38px;

            padding: 0 17px;

            border: none;

            border-radius: 7px;

            background: var(--primary);

            color: #ffffff;

            font-size: 13px;

            font-weight: 700;

            cursor: pointer;

            text-decoration: none;

            white-space: nowrap;

            transition: 0.2s;
        }

        .detail-btn:hover {
            background: var(--primary-hover);

            color: #ffffff;
        }

        /* =====================================================
           EMPTY DATA
        ===================================================== */

        .empty-data {
            padding: 55px 20px;

            text-align: center;

            color: var(--text-muted);
        }

        .empty-data i {
            font-size: 42px;

            margin-bottom: 15px;

            color: #bdbdbd;
        }

        .empty-data h3 {
            font-size: 17px;

            margin-bottom: 6px;

            color: #555555;
        }

        .empty-data p {
            font-size: 14px;
        }

        /* =====================================================
           MODAL DETAIL
        ===================================================== */

        .modal {
            display: none;

            position: fixed;

            inset: 0;

            background: rgba(0, 0, 0, 0.45);

            z-index: 500;

            align-items: center;
            justify-content: center;

            padding: 20px;
        }

        .modal.show {
            display: flex;
        }

        .modal-content {
            width: 100%;

            max-width: 720px;

            max-height: 90vh;

            overflow-y: auto;

            background: #ffffff;

            border-radius: 14px;

            box-shadow: 0 15px 45px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            display: flex;

            align-items: center;
            justify-content: space-between;

            padding: 20px 24px;

            border-bottom: 1px solid var(--border);
        }

        .modal-header h2 {
            font-size: 19px;

            font-weight: 700;
        }

        .modal-close {
            width: 34px;
            height: 34px;

            display: flex;
            align-items: center;
            justify-content: center;

            border: none;

            background: transparent;

            color: #757575;

            font-size: 20px;

            cursor: pointer;

            border-radius: 6px;
        }

        .modal-close:hover {
            background: #f5f5f5;
        }

        .modal-body {
            padding: 24px;
        }

        .detail-grid {
            display: grid;

            grid-template-columns: 1fr 1fr;

            gap: 18px;
        }

        .detail-item {
            display: flex;

            flex-direction: column;

            gap: 6px;
        }

        .detail-item.full {
            grid-column: 1 / -1;
        }

        .detail-label {
            color: var(--text-muted);

            font-size: 12px;

            font-weight: 700;

            text-transform: uppercase;
        }

        .detail-value {
            color: #111111;

            font-size: 14px;

            font-weight: 600;

            line-height: 1.5;
        }

        /* =====================================================
           MODAL FOOTER
        ===================================================== */

        .modal-footer {
            padding: 18px 24px;

            border-top: 1px solid var(--border);

            display: flex;

            justify-content: flex-end;

            gap: 10px;
        }

        .btn-secondary {
            height: 40px;

            padding: 0 18px;

            border: 1px solid var(--border);

            border-radius: 7px;

            background: #ffffff;

            color: #333333;

            font-weight: 600;

            cursor: pointer;
        }

        .btn-secondary:hover {
            background: #f5f5f5;
        }

        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media (max-width: 1100px) {

            .content-area {
                padding: 25px;
            }

            .topbar {
                padding: 0 22px;
            }
        }

        @media (max-width: 900px) {

            .content-area {
                padding: 22px 16px 30px;
            }

            .topbar {
                height: 64px;
                min-height: 64px;

                padding: 0 16px;
            }

            .topbar-title {
                font-size: 18px;
            }

            .topbar-right {
                gap: 8px;
            }

            .topbar-user span {
                display: none;
            }

            .page-heading {
                margin-bottom: 20px;
            }

            .page-heading h1 {
                font-size: 24px;
            }

            .request-card {
                padding: 22px 18px;
            }

            .request-card h2 {
                font-size: 18px;
            }

            .filter-row {
                width: 100%;
            }

            .filter-select {
                width: 100%;
            }

            .detail-grid {
                grid-template-columns: 1fr;
            }

            .detail-item.full {
                grid-column: auto;
            }
        }

        @media (max-width: 600px) {

            .topbar-left {
                gap: 8px;
            }

            .menu-toggle {
                width: 34px;
                height: 34px;
            }

            .topbar-title {
                font-size: 16px;
            }

            .notification-button {
                width: 34px;
                height: 34px;
            }

            .topbar-user img,
            .user-avatar {
                width: 34px;
                height: 34px;
            }

            .request-card {
                border-radius: 12px;
            }

            .table-card {
                border-radius: 12px;
            }

            .modal {
                padding: 10px;
            }

            .modal-header {
                padding: 17px;
            }

            .modal-body {
                padding: 17px;
            }

            .modal-footer {
                padding: 15px 17px;
            }
        }
    </style>
</head>

<body>

    {{-- =====================================================
         SIDEBAR ADMIN LITERASI DIGITAL
    ====================================================== --}}
    @include('partials.admin-digital-nav', [
        'activeMenu' => 'permintaan-bahan'
    ])


    {{-- =====================================================
         MAIN WRAPPER
    ====================================================== --}}
    <div class="main-wrapper">


        {{-- =================================================
             TOPBAR
        ================================================== --}}
        <div class="topbar">

            <div class="topbar-left">

                <button type="button" class="menu-toggle">
                    <i class="fas fa-bars"></i>
                </button>

                <div class="topbar-title">
                    Permintaan Bahan
                </div>

            </div>


            <div class="topbar-right">

                {{-- NOTIFICATION --}}
                <div class="notification-button">
                    <i class="far fa-bell"></i>
                    <span class="notification-dot"></span>
                </div>


                {{-- USER PROFILE --}}
                <a href="{{ route('admin.digital.profile') }}"
                   class="topbar-user">

                    @if(auth()->user()->foto_profil)

                        <img src="{{ auth()->user()->foto_profil }}"
                             alt="Profile">

                    @else

                        <div class="user-avatar">
                            {{ strtoupper(substr(auth()->user()->nama ?? 'A', 0, 1)) }}
                        </div>

                    @endif

                    <span>
                        {{ auth()->user()->nama ?? 'Admin Digital' }}
                    </span>

                </a>

            </div>

        </div>


        {{-- =================================================
             CONTENT
        ================================================== --}}
        <main class="content-area">


            {{-- PAGE TITLE --}}
            <div class="page-heading">

                <h1>
                    Permintaan Bahan
                </h1>

            </div>


            {{-- =================================================
                 REQUEST INFORMATION
            ================================================== --}}
            <section class="request-card">

                <h2>
                    Permohonan Bahan
                </h2>

                <p class="request-card-description">
                    Kelola dan pantau pengajuan kebutuhan bahan dari
                    Literasi Digital hingga proses permintaan selesai.
                </p>


                {{-- FILTER --}}
                <form method="GET"
                      action="{{ route('admin.digital.permintaan-bahan') }}">

                    <div class="filter-row">

                        <select name="status"
                                class="filter-select"
                                onchange="this.form.submit()">

                            <option value="semua"
                                {{ ($statusFilter ?? 'semua') === 'semua' ? 'selected' : '' }}>
                                Semua Status
                            </option>

                            <option value="menunggu"
                                {{ ($statusFilter ?? '') === 'menunggu' ? 'selected' : '' }}>
                                Menunggu Diproses
                            </option>

                            <option value="diproses"
                                {{ ($statusFilter ?? '') === 'diproses' ? 'selected' : '' }}>
                                Sedang Diproses
                            </option>

                            <option value="selesai"
                                {{ ($statusFilter ?? '') === 'selesai' ? 'selected' : '' }}>
                                Selesai
                            </option>

                            <option value="kendala"
                                {{ ($statusFilter ?? '') === 'kendala' ? 'selected' : '' }}>
                                Kendala
                            </option>

                        </select>

                    </div>

                </form>

            </section>


            {{-- =================================================
                 TABLE
            ================================================== --}}
            <section class="table-card">

                <div class="table-wrapper">

                    <table class="request-table">

                        <thead>
                            <tr>

                                <th>
                                    Id Permintaan
                                </th>

                                <th>
                                    Tanggal
                                </th>

                                <th>
                                    Divisi
                                </th>

                                <th>
                                    Nama Bahan
                                </th>

                                <th>
                                    Keperluan
                                </th>

                                <th>
                                    Status Surat
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

                                    if (
                                        str_contains($status, 'selesai')
                                    ) {

                                        $statusClass = 'status-selesai';

                                    } elseif (
                                        str_contains($status, 'kendala')
                                    ) {

                                        $statusClass = 'status-kendala';

                                    } elseif (
                                        str_contains($status, 'proses') ||
                                        str_contains($status, 'menunggu')
                                    ) {

                                        $statusClass = 'status-proses';

                                    } else {

                                        $statusClass = 'status-default';

                                    }

                                    /*
                                     * Menggunakan beberapa fallback
                                     * agar tetap aman apabila nama
                                     * kolom bahan/keperluan berbeda.
                                     */

                                    $namaBahan =
                                        $item->nama_bahan
                                        ?? $item->bahan
                                        ?? $item->jenis_bahan
                                        ?? '-';

                                    $keperluan =
                                        $item->keperluan
                                        ?? $item->keterangan
                                        ?? '-';

                                @endphp


                                <tr>

                                    {{-- ID --}}
                                    <td>

                                        <span class="request-id">
                                            {{ $item->id_permintaan ?? $item->id }}
                                        </span>

                                    </td>


                                    {{-- TANGGAL --}}
                                    <td>

                                        <span class="request-date">

                                            {{ optional($item->created_at)->format('d F Y') }}

                                        </span>

                                    </td>


                                    {{-- DIVISI --}}
                                    <td>

                                        <span class="division">

                                            {{ $item->divisi ?? 'Literasi Digital' }}

                                        </span>

                                    </td>


                                    {{-- NAMA BAHAN --}}
                                    <td>

                                        <span class="material-name">

                                            {{ $namaBahan }}

                                        </span>

                                    </td>


                                    {{-- KEPERLUAN --}}
                                    <td>

                                        <div class="purpose">

                                            {{ $keperluan }}

                                        </div>

                                    </td>


                                    {{-- STATUS --}}
                                    <td>

                                        <span class="status {{ $statusClass }}">

                                            {{ $item->status ?? 'Belum diproses' }}

                                        </span>

                                    </td>


                                    {{-- AKSI --}}
                                    <td>

                                        <button type="button"
                                                class="detail-btn"
                                                onclick="openDetailModal(
                                                    {{ $item->id }}
                                                )">

                                            Detail

                                        </button>

                                    </td>

                                </tr>


                            @empty

                                <tr>

                                    <td colspan="7">

                                        <div class="empty-data">

                                            <i class="fas fa-box-open"></i>

                                            <h3>
                                                Belum Ada Permintaan Bahan
                                            </h3>

                                            <p>
                                                Belum terdapat permintaan bahan
                                                dari Literasi Digital.
                                            </p>

                                        </div>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </section>


        </main>

    </div>


    {{-- =====================================================
         MODAL DETAIL
    ====================================================== --}}

    @foreach($permintaanBahan as $item)

        @php

            $namaBahan =
                $item->nama_bahan
                ?? $item->bahan
                ?? $item->jenis_bahan
                ?? '-';

            $keperluan =
                $item->keperluan
                ?? $item->keterangan
                ?? '-';

        @endphp


        <div class="modal"
             id="detailModal{{ $item->id }}">

            <div class="modal-content">


                {{-- MODAL HEADER --}}
                <div class="modal-header">

                    <h2>
                        Detail Permintaan Bahan
                    </h2>

                    <button type="button"
                            class="modal-close"
                            onclick="closeDetailModal(
                                {{ $item->id }}
                            )">

                        <i class="fas fa-times"></i>

                    </button>

                </div>


                {{-- MODAL BODY --}}
                <div class="modal-body">

                    <div class="detail-grid">


                        <div class="detail-item">

                            <span class="detail-label">
                                ID Permintaan
                            </span>

                            <span class="detail-value">

                                {{ $item->id_permintaan ?? $item->id }}

                            </span>

                        </div>


                        <div class="detail-item">

                            <span class="detail-label">
                                Tanggal
                            </span>

                            <span class="detail-value">

                                {{ optional($item->created_at)->format('d F Y, H:i') }}

                            </span>

                        </div>


                        <div class="detail-item">

                            <span class="detail-label">
                                Divisi
                            </span>

                            <span class="detail-value">

                                {{ $item->divisi ?? 'Literasi Digital' }}

                            </span>

                        </div>


                        <div class="detail-item">

                            <span class="detail-label">
                                Nama Bahan
                            </span>

                            <span class="detail-value">

                                {{ $namaBahan }}

                            </span>

                        </div>


                        @if(isset($item->jumlah))

                            <div class="detail-item">

                                <span class="detail-label">
                                    Jumlah
                                </span>

                                <span class="detail-value">

                                    {{ $item->jumlah }}

                                </span>

                            </div>

                        @endif


                        <div class="detail-item">

                            <span class="detail-label">
                                Status
                            </span>

                            <span class="detail-value">

                                {{ $item->status ?? 'Belum diproses' }}

                            </span>

                        </div>


                        <div class="detail-item full">

                            <span class="detail-label">
                                Keperluan
                            </span>

                            <span class="detail-value">

                                {{ $keperluan }}

                            </span>

                        </div>


                        @if(isset($item->catatan_kendala) &&
                            $item->catatan_kendala)

                            <div class="detail-item full">

                                <span class="detail-label">
                                    Catatan Kendala
                                </span>

                                <span class="detail-value">

                                    {{ $item->catatan_kendala }}

                                </span>

                            </div>

                        @endif


                    </div>

                </div>


                {{-- MODAL FOOTER --}}
                <div class="modal-footer">

                    <button type="button"
                            class="btn-secondary"
                            onclick="closeDetailModal(
                                {{ $item->id }}
                            )">

                        Tutup

                    </button>

                </div>


            </div>

        </div>

    @endforeach


    {{-- =====================================================
         JAVASCRIPT
    ====================================================== --}}

    <script>

        /*
        |--------------------------------------------------------------------------
        | DETAIL MODAL
        |--------------------------------------------------------------------------
        */

        function openDetailModal(id) {

            const modal = document.getElementById(
                'detailModal' + id
            );

            if (!modal) {
                return;
            }

            modal.classList.add('show');

            document.body.style.overflow = 'hidden';
        }


        function closeDetailModal(id) {

            const modal = document.getElementById(
                'detailModal' + id
            );

            if (!modal) {
                return;
            }

            modal.classList.remove('show');

            document.body.style.overflow = '';
        }


        /*
        |--------------------------------------------------------------------------
        | CLOSE MODAL WHEN CLICKING OUTSIDE
        |--------------------------------------------------------------------------
        */

        document.addEventListener('click', function (event) {

            if (
                event.target.classList.contains('modal')
            ) {

                event.target.classList.remove('show');

                document.body.style.overflow = '';
            }

        });


        /*
        |--------------------------------------------------------------------------
        | ESC TO CLOSE MODAL
        |--------------------------------------------------------------------------
        */

        document.addEventListener('keydown', function (event) {

            if (event.key !== 'Escape') {
                return;
            }

            document.querySelectorAll('.modal.show')
                .forEach(function (modal) {

                    modal.classList.remove('show');

                });

            document.body.style.overflow = '';

        });

    </script>

</body>
</html>