<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Permintaan Bahan - BrailleKita</title>

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary: #c62828;
            --primary-hover: #b71c1c;
            --surface: #ffffff;
            --text-dark: #111111;
            --text-muted: #757575;
            --border: #e0e0e0;
            --background: #f4f6f9;
            --green: #2e7d32;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background: var(--background);
            color: var(--text-dark);
        }

        .main-wrapper {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow: hidden;
            background: #ffffff;
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
            z-index: 100;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .menu-toggle {
            width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            background: transparent;
            color: var(--text-muted);
            cursor: pointer;
            font-size: 19px;
            border-radius: 6px;
        }

        .menu-toggle:hover {
            background: #f5f5f5;
        }

        .topbar-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 24px;
        }

        .notification-button {
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-dark);
            font-size: 19px;
            cursor: pointer;
            border-radius: 6px;
            position: relative;
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

        /* =====================================================
           CONTENT
        ===================================================== */

        .content-area {
            flex: 1;
            overflow-y: auto;
            padding: 32px;
            background: #ffffff;
        }

        /* =====================================================
           SUCCESS MESSAGE
        ===================================================== */

        .success-message {
            background: var(--green);
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            margin-bottom: 24px;
            font-size: 14px;
            font-weight: 700;
        }

        /* =====================================================
           LIST VIEW
        ===================================================== */

        #viewList {
            width: 100%;
        }

        .page-header-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 24px;
        }

        .page-header h2 {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        /* =====================================================
           FILTER
        ===================================================== */

        .filter-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 20px 24px;
            margin-bottom: 24px;
        }

        .filter-card-title {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .filter-card-desc {
            font-size: 13px;
            color: var(--text-muted);
            margin-bottom: 18px;
            line-height: 1.5;
        }

        .status-select {
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 10px 16px;
            font-family: inherit;
            font-size: 13px;
            font-weight: 700;
            color: var(--text-dark);
            background: white;
            cursor: pointer;
            outline: none;
            min-width: 170px;
        }

        .status-select:focus {
            border-color: var(--primary);
        }

        /* =====================================================
           REQUEST CARD
        ===================================================== */

        .request-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .request-card {
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 16px 20px;
            transition: 0.2s ease;
        }

        .request-card:hover {
            border-color: #cfcfcf;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .request-card-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
            margin-bottom: 12px;
        }

        .request-id {
            font-size: 13px;
            font-weight: 700;
            color: #333333;
            margin-bottom: 3px;
        }

        .request-material {
            font-size: 14px;
            font-weight: 700;
            color: #111111;
        }

        .request-quantity {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 3px;
        }

        .request-status {
            font-size: 11px;
            font-weight: 700;
            text-align: right;
            white-space: nowrap;
        }

        .status-dikirim {
            color: #0097a7;
        }

        .status-dicetak {
            color: #fbc02d;
        }

        .status-selesai,
        .status-tersedia,
        .status-aktif {
            color: var(--green);
        }

        .status-diproses,
        .status-menunggu {
            color: #e65100;
        }

        .status-batal {
            color: var(--primary);
        }

        .status-default {
            color: #555555;
        }

        .request-card-middle {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            padding-bottom: 12px;
        }

        .request-info-label {
            font-size: 11px;
            color: var(--text-muted);
            margin-bottom: 3px;
        }

        .request-info-value {
            font-size: 12px;
            font-weight: 600;
            color: #333333;
            line-height: 1.5;
        }

        .request-card-bottom {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            padding-top: 4px;
        }

        .btn-detail {
            background: var(--primary);
            color: white;
            border: none;
            padding: 6px 16px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .btn-detail:hover {
            background: var(--primary-hover);
        }

        .empty-state {
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 40px 20px;
            text-align: center;
            color: var(--text-muted);
            font-size: 14px;
        }

        /* =====================================================
           DETAIL VIEW
        ===================================================== */

        #viewDetail {
            display: none;
            max-width: 760px;
        }

        .btn-kembali {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: var(--primary);
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            margin-bottom: 20px;
            background: none;
            border: none;
            cursor: pointer;
            font-family: inherit;
            padding: 0;
        }

        .btn-kembali:hover {
            text-decoration: underline;
        }

        .section-block {
            margin-bottom: 24px;
        }

        .section-title-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
        }

        .step-number-badge {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .section-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .info-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 20px 24px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px 24px;
        }

        .info-item {
            display: flex;
            gap: 8px;
            font-size: 13px;
        }

        .info-label {
            color: var(--text-muted);
            min-width: 110px;
        }

        .info-value {
            font-weight: 700;
            color: var(--text-dark);
        }

        .info-item.keperluan-item {
            grid-column: 1 / -1;
        }

        /* =====================================================
           TIMELINE
        ===================================================== */

        .timeline {
            padding: 6px 4px;
        }

        .timeline-item {
            display: flex;
            gap: 14px;
            position: relative;
            padding-bottom: 22px;
        }

        .timeline-item:last-child {
            padding-bottom: 0;
        }

        .timeline-item:not(:last-child)::after {
            content: '';
            position: absolute;
            left: 13px;
            top: 28px;
            bottom: -22px;
            width: 2px;
            background: var(--border);
        }

        .timeline-icon {
            width: 27px;
            height: 27px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            z-index: 1;
            font-size: 12px;
            font-weight: 700;
        }

        .timeline-icon.done {
            background: var(--green);
            color: white;
        }

        .timeline-icon.current {
            background: var(--primary);
            color: white;
        }

        .timeline-icon.pending {
            background: #e0e0e0;
            color: #9e9e9e;
        }

        .timeline-body {
            padding-top: 2px;
        }

        .timeline-title {
            font-size: 13.5px;
            font-weight: 700;
        }

        .timeline-title.done {
            color: var(--green);
        }

        .timeline-title.current {
            color: var(--primary);
        }

        .timeline-title.pending {
            color: #9e9e9e;
        }

        .timeline-desc {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .timeline-desc.pending {
            color: #bdbdbd;
        }

        /* =====================================================
           INFO BOX
        ===================================================== */

        .info-box {
            border: 1px solid #90caf9;
            background: #e3f2fd;
            color: #1565c0;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 12.5px;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 18px;
        }

        .tindakan-label {
            font-size: 13px;
            font-weight: 700;
            color: var(--text-muted);
            margin: 20px 0 10px 0;
        }

        .btn-primary-action {
            background: var(--primary);
            color: white;
            border: none;
            padding: 11px 20px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-primary-action:hover {
            background: var(--primary-hover);
        }

        .kendala-textarea {
            width: 100%;
            min-height: 90px;
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 14px;
            font-family: inherit;
            font-size: 13px;
            resize: vertical;
            outline: none;
            margin-bottom: 16px;
        }

        .kendala-textarea:focus {
            border-color: var(--primary);
        }

        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media (max-width: 900px) {

            .topbar {
                padding: 0 18px;
            }

            .content-area {
                padding: 24px 20px 35px;
            }

            .request-card-middle {
                grid-template-columns: 1fr;
                gap: 10px;
            }
        }

        @media (max-width: 700px) {

            .content-area {
                padding: 20px 16px 30px;
            }

            .filter-card {
                padding: 16px;
            }

            .status-select {
                width: 100%;
            }

            .request-card {
                padding: 15px;
            }

            .request-card-top {
                gap: 10px;
            }

            .request-status {
                font-size: 10px;
            }

            #viewDetail {
                max-width: 100%;
            }

            .info-card {
                padding: 18px;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .info-item.keperluan-item {
                grid-column: auto;
            }
        }

        @media (max-width: 600px) {

            .topbar {
                height: 62px;
                min-height: 62px;
                padding: 0 14px;
            }

            .topbar-title {
                font-size: 17px;
            }

            .topbar-right {
                gap: 8px;
            }

            .topbar-user-name {
                display: none;
            }

            .page-header h2 {
                font-size: 20px;
            }

            .request-card-top {
                flex-direction: column;
            }

            .request-status {
                text-align: left;
            }

            .request-card-bottom {
                padding-top: 8px;
            }
        }
    </style>
</head>

<body>

    @include('partials.admin-nav', ['activeMenu' => 'permintaan-bahan'])

    <div class="main-wrapper">

        <!-- =====================================================
             TOPBAR
        ====================================================== -->
        <header class="topbar">

            <div class="topbar-left">

                <button type="button" class="menu-toggle">
                    <i class="fas fa-bars"></i>
                </button>

                <span class="topbar-title" id="topbarTitle">
                    Permintaan Bahan
                </span>

            </div>

            <div class="topbar-right">

                <div class="notification-button">
                    <i class="far fa-bell"></i>
                    <span class="notification-dot"></span>
                </div>

                <a href="{{ route('admin.profile') }}"
                   style="display:flex;align-items:center;gap:12px;text-decoration:none;color:var(--text-dark);">

                    <span class="topbar-user-name"
                          style="font-weight:700;font-size:15px;">
                        {{ auth()->user()->nama ?? 'Admin Pengiriman' }}
                    </span>

                    <div style="
                        width:36px;
                        height:36px;
                        border-radius:50%;
                        overflow:hidden;
                        background:#111;
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        color:white;
                    ">

                        @if(auth()->user()->foto_profil)

                            <img src="{{ auth()->user()->foto_profil }}"
                                 alt="Foto Profile"
                                 style="width:100%;height:100%;object-fit:cover;">

                        @else

                            <i class="fas fa-user" style="font-size:16px;"></i>

                        @endif

                    </div>

                </a>

            </div>

        </header>


        <!-- =====================================================
             CONTENT
        ====================================================== -->

        <main class="content-area">

            @if(session('success'))

                <div class="success-message">
                    <i class="fas fa-check-circle" style="margin-right:6px;"></i>
                    {{ session('success') }}
                </div>

            @endif


            <!-- =================================================
                 VIEW LIST
            ================================================== -->

            <div id="viewList">

                <div class="page-header-row">

                    <div class="page-header">

                        <h2>
                            Permintaan Bahan
                        </h2>

                    </div>

                </div>


                <!-- FILTER -->

                <div class="filter-card">

                    <div class="filter-card-title">
                        Permohonan Bahan
                    </div>

                    <div class="filter-card-desc">
                        Kelola dan pantau pengajuan kebutuhan bahan dari Literasi Manual dan Literasi Digital hingga proses permintaan selesai.
                    </div>

                    <select
                        class="status-select"
                        id="filterStatus"
                        onchange="window.location.href='{{ route('admin.permintaan-bahan') }}?status=' + this.value"
                    >

                        <option value="semua"
                            {{ ($statusFilter ?? 'semua') == 'semua' ? 'selected' : '' }}>
                            Semua Status
                        </option>

                        <option value="menunggu"
                            {{ ($statusFilter ?? '') == 'menunggu' ? 'selected' : '' }}>
                            Menunggu Pemeriksaan
                        </option>

                        <option value="diperbaiki"
                            {{ ($statusFilter ?? '') == 'diperbaiki' ? 'selected' : '' }}>
                            Perlu diperbaiki
                        </option>

                        <option value="disetujui"
                            {{ ($statusFilter ?? '') == 'disetujui' ? 'selected' : '' }}>
                            Disetujui
                        </option>

                        <option value="tanda tangan"
                            {{ ($statusFilter ?? '') == 'tanda tangan' ? 'selected' : '' }}>
                            Menunggu Tanda Tangan
                        </option>

                        <option value="sudah ttd"
                            {{ ($statusFilter ?? '') == 'sudah ttd' ? 'selected' : '' }}>
                            Sudah ditandatangani
                        </option>

                        <option value="selesai"
                            {{ ($statusFilter ?? '') == 'selesai' ? 'selected' : '' }}>
                            Selesai
                        </option>

                    </select>

                </div>


                <!-- =================================================
                     REQUEST LIST
                ================================================== -->

                <div class="request-list">

                    @forelse ($permintaanBahan as $item)

                        @php

                            $statusClass = 'status-diproses';

                            if ($item->status == 'Selesai') {

                                $statusClass = 'status-selesai';

                            } elseif (
                                in_array(
                                    $item->status,
                                    [
                                        'Menunggu Tanda Tangan',
                                        'Menunggu diproses'
                                    ]
                                )
                            ) {

                                $statusClass = 'status-menunggu';

                            } elseif ($item->status == 'Kendala') {

                                $statusClass = 'status-batal';

                            }

                        @endphp


                        <div class="request-card">

                            <!-- BAGIAN ATAS -->

                            <div class="request-card-top">

                                <div>

                                    <div class="request-id">
                                        {{ $item->id_permintaan ?? 'BHN-'.$item->id }}
                                    </div>

                                    <div class="request-material">
                                        {{ $item->nama_bahan }}
                                    </div>

                                    <div class="request-quantity">
                                        {{ $item->jumlah ?? '-' }}
                                        {{ $item->satuan ?? '' }}
                                    </div>

                                </div>


                                <div class="request-status {{ $statusClass }}">
                                    {{ $item->status }}
                                </div>

                            </div>


                            <!-- BAGIAN INFORMASI -->

                            <div class="request-card-middle">

                                <div>

                                    <div class="request-info-label">
                                        Tanggal Pengajuan
                                    </div>

                                    <div class="request-info-value">
                                        {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('j F Y') }}
                                    </div>

                                </div>


                                <div>

                                    <div class="request-info-label">
                                        Divisi
                                    </div>

                                    <div class="request-info-value">
                                        {{ $item->divisi }}
                                    </div>

                                </div>


                                <div>

                                    <div class="request-info-label">
                                        Keperluan
                                    </div>

                                    <div class="request-info-value">
                                        {{ $item->keperluan }}
                                    </div>

                                </div>


                                <div>

                                    <div class="request-info-label">
                                        Pengaju
                                    </div>

                                    <div class="request-info-value">
                                        {{ $item->pengaju ?? 'Anonim' }}
                                    </div>

                                </div>

                            </div>


                            <!-- BAGIAN BAWAH -->

                            <div class="request-card-bottom">

                                <button
                                    type="button"
                                    class="btn-detail btn-lihat-detail"

                                    data-id="{{ $item->id }}"
                                    data-id_tampil="{{ $item->id_permintaan ?? 'BHN-'.$item->id }}"
                                    data-tanggal="{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('j F Y') }}"
                                    data-divisi="{{ $item->divisi }}"
                                    data-bahan="{{ $item->nama_bahan }}"
                                    data-jumlah="{{ $item->jumlah }}"
                                    data-satuan="{{ $item->satuan }}"
                                    data-keperluan="{{ $item->keperluan }}"
                                    data-pengaju="{{ $item->pengaju ?? 'Anonim' }}"
                                    data-prioritas="{{ $item->prioritas ?? 'Normal' }}"
                                    data-status="{{ $item->status }}"
                                >
                                    Detail
                                </button>

                            </div>

                        </div>

                    @empty

                        <div class="empty-state">
                            Belum ada data permintaan bahan.
                        </div>

                    @endforelse

                </div>

            </div>


            <!-- =================================================
                 VIEW DETAIL
            ================================================== -->

            <div id="viewDetail">

                <button type="button"
                        class="btn-kembali"
                        id="btnKembali">

                    <i class="fas fa-arrow-left"></i>
                    Kembali

                </button>


                <!-- 1. INFORMASI PERMINTAAN -->

                <div class="section-block">

                    <div class="section-title-row">

                        <span class="step-number-badge">
                            1
                        </span>

                        <span class="section-title">
                            Informasi Permintaan
                        </span>

                    </div>


                    <div class="info-card">

                        <div class="info-grid">

                            <div class="info-item">
                                <span class="info-label">
                                    Id Permintaan
                                </span>

                                <span class="info-value">
                                    :
                                    <span id="dId"></span>
                                </span>
                            </div>


                            <div class="info-item">
                                <span class="info-label">
                                    Nama Pengaju
                                </span>

                                <span class="info-value">
                                    :
                                    <span id="dPengaju"></span>
                                </span>
                            </div>


                            <div class="info-item">
                                <span class="info-label">
                                    Divisi
                                </span>

                                <span class="info-value">
                                    :
                                    <span id="dDivisi"></span>
                                </span>
                            </div>


                            <div class="info-item">
                                <span class="info-label">
                                    Prioritas
                                </span>

                                <span class="info-value">
                                    :
                                    <span id="dPrioritas"></span>
                                </span>
                            </div>


                            <div class="info-item">
                                <span class="info-label">
                                    Tanggal Pengajuan
                                </span>

                                <span class="info-value">
                                    :
                                    <span id="dTanggal"></span>
                                </span>
                            </div>

                        </div>

                    </div>

                </div>


                <!-- 2. DETAIL BAHAN -->

                <div class="section-block">

                    <div class="section-title-row">

                        <span class="step-number-badge">
                            2
                        </span>

                        <span class="section-title">
                            Detail Bahan
                        </span>

                    </div>


                    <div class="info-card">

                        <div class="info-grid">

                            <div class="info-item">

                                <span class="info-label">
                                    Nama Bahan
                                </span>

                                <span class="info-value">
                                    :
                                    <span id="dBahan"></span>
                                </span>

                            </div>


                            <div class="info-item">

                                <span class="info-label">
                                    Jumlah
                                </span>

                                <span class="info-value">
                                    :
                                    <span id="dJumlah"></span>
                                </span>

                            </div>


                            <div class="info-item">

                                <span class="info-label">
                                    Satuan
                                </span>

                                <span class="info-value">
                                    :
                                    <span id="dSatuan"></span>
                                </span>

                            </div>


                            <div class="info-item keperluan-item">

                                <span class="info-label">
                                    Keperluan
                                </span>

                                <span class="info-value">
                                    :
                                    <span id="dKeperluan"></span>
                                </span>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- 3. PROSES PERMINTAAN -->

                <div class="section-block">

                    <div class="section-title-row">

                        <span class="step-number-badge">
                            3
                        </span>

                        <span class="section-title">
                            Proses Permintaan
                        </span>

                    </div>


                    <div class="info-card">

                        <div class="timeline"
                             id="timelineContainer">
                        </div>


                        <div class="info-box"
                             id="infoBoxMessage">

                            <i class="fas fa-info-circle"></i>

                            <span>
                                Memuat status...
                            </span>

                        </div>


                        <div id="actionArea"
                             style="display:none;">

                            <div class="tindakan-label">
                                Tindakan Selanjutnya
                            </div>


                            <form
                                action="{{ route('admin.permintaan-bahan.update-status') }}"
                                method="POST"
                            >

                                @csrf

                                <input
                                    type="hidden"
                                    name="id"
                                    id="updateIdNormal"
                                >

                                <input
                                    type="hidden"
                                    name="status"
                                    id="nextStatusInput"
                                >


                                <button
                                    type="submit"
                                    class="btn-primary-action"
                                    id="btnActionStatus"
                                >

                                    <i class="fas fa-chevron-right"></i>

                                    <span id="btnActionText">
                                        Proses
                                    </span>

                                </button>

                            </form>

                        </div>

                    </div>

                </div>


                <!-- 4. TINDAKAN TAMBAHAN -->

                <div class="section-block"
                     id="kendalaArea">

                    <div class="section-title-row">

                        <span class="step-number-badge">
                            4
                        </span>

                        <span class="section-title">
                            Tindakan Tambahan
                        </span>

                    </div>


                    <div class="info-card">

                        <form
                            action="{{ route('admin.permintaan-bahan.update-status') }}"
                            method="POST"
                        >

                            @csrf

                            <input
                                type="hidden"
                                name="id"
                                id="updateIdKendala"
                            >

                            <input
                                type="hidden"
                                name="status"
                                value="Kendala"
                            >


                            <textarea
                                name="kendala"
                                class="kendala-textarea"
                                placeholder="Jelaskan kendala yang dialami terkait permintaan ini (opsional)..."
                                required
                            ></textarea>


                            <button
                                type="submit"
                                class="btn-primary-action"
                            >

                                <i class="fas fa-triangle-exclamation"></i>

                                Laporkan Kendala

                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </main>

    </div>


    <!-- =========================================================
         JAVASCRIPT
    ========================================================== -->

    <script>

        (function () {

            var viewList =
                document.getElementById('viewList');

            var viewDetail =
                document.getElementById('viewDetail');

            var topbarTitle =
                document.getElementById('topbarTitle');

            var btnKembali =
                document.getElementById('btnKembali');

            var tombolDetail =
                document.querySelectorAll('.btn-lihat-detail');


            /* =====================================================
               TIMELINE
            ===================================================== */

            const timelineStages = [

                {
                    status: "Menunggu diproses",
                    title: "Menunggu diproses",
                    desc: "Permintaan telah diajukan oleh divisi terkait."
                },

                {
                    status: "Diproses",
                    title: "Diproses",
                    desc: "Admin Pengiriman mulai menangani permintaan."
                },

                {
                    status: "Surat Dibuat",
                    title: "Surat Dibuat",
                    desc: "Surat permohonan kebutuhan bahan telah dibuat."
                },

                {
                    status: "Menunggu Tanda Tangan",
                    title: "Menunggu Tanda Tangan",
                    desc: "Surat menunggu proses tanda tangan."
                },

                {
                    status: "Sudah Ditandatangani",
                    title: "Sudah Ditandatangani",
                    desc: "Surat telah selesai ditandatangani."
                },

                {
                    status: "Selesai",
                    title: "Selesai",
                    desc: "Permintaan bahan telah selesai diproses."
                }

            ];


            /* =====================================================
               RENDER TIMELINE
            ===================================================== */

            function renderTimeline(currentDbStatus) {

                const container =
                    document.getElementById('timelineContainer');

                container.innerHTML = '';


                let currentIndex =
                    timelineStages.findIndex(
                        stage => stage.status === currentDbStatus
                    );


                if (currentIndex === -1) {
                    currentIndex = 0;
                }


                timelineStages.forEach(function (stage, index) {

                    let stateClass = '';
                    let iconHtml = '';


                    if (
                        index < currentIndex ||
                        currentDbStatus === 'Selesai'
                    ) {

                        stateClass = 'done';

                        iconHtml =
                            '<i class="fas fa-check"></i>';

                    }

                    else if (index === currentIndex) {

                        stateClass = 'current';

                        iconHtml =
                            (index + 1);

                    }

                    else {

                        stateClass = 'pending';

                        iconHtml =
                            (index + 1);

                    }


                    if (
                        currentDbStatus === 'Selesai' &&
                        index === timelineStages.length - 1
                    ) {

                        stateClass = 'done';

                    }


                    container.innerHTML += `

                        <div class="timeline-item">

                            <div class="timeline-icon ${stateClass}">
                                ${iconHtml}
                            </div>

                            <div class="timeline-body">

                                <div class="timeline-title ${stateClass}">
                                    ${stage.title}
                                </div>

                                <div class="timeline-desc ${stateClass}">
                                    ${stage.desc}
                                </div>

                            </div>

                        </div>

                    `;

                });


                updateActionsAndInfo(
                    currentDbStatus,
                    currentIndex
                );

            }


            /* =====================================================
               ACTION & INFO
            ===================================================== */

            function updateActionsAndInfo(status, index) {

                const infoBox =
                    document.querySelector(
                        '#infoBoxMessage span'
                    );

                const actionArea =
                    document.getElementById(
                        'actionArea'
                    );

                const kendalaArea =
                    document.getElementById(
                        'kendalaArea'
                    );

                const nextStatusInput =
                    document.getElementById(
                        'nextStatusInput'
                    );

                const btnActionText =
                    document.getElementById(
                        'btnActionText'
                    );


                if (
                    status === 'Selesai' ||
                    status === 'Kendala'
                ) {

                    actionArea.style.display = 'none';

                    kendalaArea.style.display = 'none';


                    infoBox.innerHTML =
                        status === 'Selesai'
                            ? 'Permintaan ini telah selesai diproses.'
                            : 'Permintaan ini sedang mengalami kendala.';

                    return;

                }


                actionArea.style.display = 'block';

                kendalaArea.style.display = 'block';


                if (
                    index < timelineStages.length - 1
                ) {

                    let nextStage =
                        timelineStages[index + 1].status;


                    nextStatusInput.value =
                        nextStage;


                    if (nextStage === 'Diproses') {

                        infoBox.innerHTML =
                            "Permintaan baru masuk. Silakan diproses.";

                        btnActionText.innerHTML =
                            "Tandai Sedang Diproses";

                    }

                    else if (nextStage === 'Surat Dibuat') {

                        infoBox.innerHTML =
                            "Permintaan sedang ditangani.";

                        btnActionText.innerHTML =
                            "Tandai Surat Dibuat";

                    }

                    else if (
                        nextStage === 'Menunggu Tanda Tangan'
                    ) {

                        infoBox.innerHTML =
                            "Surat telah dibuat, lanjutkan ke pengajuan TTD.";

                        btnActionText.innerHTML =
                            "Ajukan Tanda Tangan";

                    }

                    else if (
                        nextStage === 'Sudah Ditandatangani'
                    ) {

                        infoBox.innerHTML =
                            "Surat sedang menunggu tanda tangan pimpinan.";

                        btnActionText.innerHTML =
                            "Tandai Sudah Ditandatangani";

                    }

                    else if (
                        nextStage === 'Selesai'
                    ) {

                        infoBox.innerHTML =
                            "Surat telah ditandatangani. Siap diselesaikan.";

                        btnActionText.innerHTML =
                            "Selesaikan Permintaan";

                    }

                }

            }


            /* =====================================================
               TAMPILKAN DETAIL
            ===================================================== */

            function tampilkanDetail(data) {

                document.getElementById('dId').textContent =
                    data.id_tampil;

                document.getElementById('dPengaju').textContent =
                    data.pengaju;

                document.getElementById('dDivisi').textContent =
                    data.divisi;

                document.getElementById('dPrioritas').textContent =
                    data.prioritas;

                document.getElementById('dTanggal').textContent =
                    data.tanggal;

                document.getElementById('dBahan').textContent =
                    data.bahan;

                document.getElementById('dJumlah').textContent =
                    data.jumlah;

                document.getElementById('dSatuan').textContent =
                    data.satuan;

                document.getElementById('dKeperluan').textContent =
                    data.keperluan;


                document.getElementById('updateIdNormal').value =
                    data.id;

                document.getElementById('updateIdKendala').value =
                    data.id;


                renderTimeline(data.status);


                viewList.style.display =
                    'none';

                viewDetail.style.display =
                    'block';

                topbarTitle.textContent =
                    'Detail Permintaan Bahan';

                window.scrollTo(0, 0);

            }


            /* =====================================================
               KEMBALI KE LIST
            ===================================================== */

            function kembaliKeList() {

                viewDetail.style.display =
                    'none';

                viewList.style.display =
                    'block';

                topbarTitle.textContent =
                    'Permintaan Bahan';

                window.scrollTo(0, 0);

            }


            /* =====================================================
               BUTTON DETAIL
            ===================================================== */

            tombolDetail.forEach(function (btn) {

                btn.addEventListener(
                    'click',
                    function () {

                        tampilkanDetail(
                            this.dataset
                        );

                    }
                );

            });


            /* =====================================================
               BUTTON KEMBALI
            ===================================================== */

            btnKembali.addEventListener(
                'click',
                kembaliKeList
            );

        })();

    </script>

</body>
</html>