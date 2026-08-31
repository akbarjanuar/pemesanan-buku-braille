<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pencetakan - BrailleKita</title>

    <style>

        /* =========================================
           HALAMAN PENCAKETAN
        ========================================= */

        .page-header {
            margin-bottom: 16px;
        }

        .page-header h2 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .page-header p {
            color: var(--text-muted);
            font-size: 13px;
        }


        /* =========================================
           FILTER STATUS
        ========================================= */

        .filter-bar {
            margin-bottom: 16px;
        }

        .status-dropdown {
            position: relative;
            display: inline-block;
        }

        .status-dropdown-btn {
            min-width: 150px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 9px 14px;

            font-family: inherit;
            font-size: 14px;
            font-weight: 700;

            cursor: pointer;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 16px;

            color: var(--text-dark);
        }

        .status-dropdown-btn:hover {
            border-color: var(--primary);
        }

        .status-dropdown-menu {
            display: none;

            position: absolute;

            top: calc(100% + 6px);
            left: 0;

            width: 200px;

            background: var(--surface);

            border: 1px solid var(--border);

            border-radius: 8px;

            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.12);

            overflow: hidden;

            z-index: 100;
        }

        .status-dropdown-menu.open {
            display: block;
        }

        .status-filter-item {
            display: block;

            padding: 11px 14px;

            font-size: 13px;

            font-weight: 700;

            color: var(--text-dark);
        }

        .status-filter-item:hover {
            background: #f5f5f5;
        }

        .status-filter-item.active {
            background: var(--primary);
            color: white;
        }


        /* =========================================
           PRINT LIST
        ========================================= */

        .printing-list {
            display: flex;
            flex-direction: column;

            gap: 14px;
        }


        /* =========================================
           PRINT CARD
        ========================================= */

        .printing-card {
            background: var(--surface);

            border: 1px solid var(--border);

            border-radius: 10px;

            padding: 12px;

            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        }


        /* =========================================
           CARD TOP
        ========================================= */

        .card-top {
            display: flex;

            align-items: flex-start;

            justify-content: space-between;

            margin-bottom: 8px;
        }

        .book-type {
            display: inline-block;

            padding: 4px 9px;

            border-radius: 5px;

            border: 1px solid var(--border);

            color: var(--text-muted);

            font-size: 9px;

            font-weight: 700;
        }

        .status-area {
            text-align: right;
        }

        .print-status {
            font-size: 9px;

            font-weight: 700;

            margin-bottom: 6px;
        }

        .status-menunggu {
            color: #d35400;
        }

        .status-selesai {
            color: #2e7d32;
        }

        .btn-detail {
            display: inline-block;

            background: var(--primary);

            color: white;

            border: none;

            border-radius: 4px;

            padding: 5px 9px;

            font-family: inherit;

            font-size: 9px;

            font-weight: 700;

            cursor: pointer;
        }

        .btn-detail:hover {
            background: var(--primary-hover);
        }


        /* =========================================
           BOOK INFO
        ========================================= */

        .book-code {
            font-size: 14px;

            font-weight: 700;

            margin-bottom: 4px;
        }

        .book-title {
            color: var(--text-muted);

            font-size: 12px;

            margin-bottom: 10px;
        }

        .order-number {
            color: var(--text-muted);

            font-size: 10px;

            margin-bottom: 14px;
        }


        /* =========================================
           INFO GRID
        ========================================= */

        .printing-info {
            display: grid;

            grid-template-columns: repeat(3, 1fr);

            gap: 20px;

            margin-bottom: 14px;
        }

        .info-item {
            display: flex;

            flex-direction: column;

            gap: 5px;
        }

        .info-label {
            font-size: 10px;

            color: var(--text-muted);
        }

        .info-value {
            font-size: 11px;

            font-weight: 700;
        }


        /* =========================================
           PROGRESS
        ========================================= */

        .progress-info {
            display: flex;

            justify-content: space-between;

            align-items: center;

            margin-bottom: 5px;

            font-size: 9px;

            color: var(--text-muted);
        }

        .progress-percent {
            color: var(--text-dark);

            font-weight: 700;
        }

        .progress-bar {
            width: 100%;

            height: 13px;

            background: #e8e8e8;

            border-radius: 20px;

            overflow: hidden;
        }

        .progress-fill {
            height: 100%;

            border-radius: 20px;

            background: var(--primary);

            transition: width 0.3s ease;
        }

        .progress-fill.completed {
            background: #2e7d32;
        }


        /* =========================================
           RESPONSIVE
        ========================================= */

        @media (max-width: 700px) {

            .printing-info {
                grid-template-columns: 1fr;

                gap: 12px;
            }

            .card-top {
                gap: 10px;
            }

            .content-area {
                padding: 20px 16px;
            }

        }

    </style>
</head>

<body>

    {{-- SIDEBAR --}}
    @include('partials.admin-nav', ['activeMenu' => 'pencetakan'])


    {{-- MAIN CONTENT --}}
    <div class="main-wrapper">


        {{-- TOPBAR --}}
        <header class="topbar">

            <div class="topbar-left">

                <button type="button" class="menu-toggle">
                    <i class="fas fa-bars"></i>
                </button>

                <span>Pencetakan</span>

            </div>


            <div class="topbar-right">

                <i class="far fa-bell notification-bell"></i>

            </div>

        </header>


        {{-- CONTENT --}}
        <main class="content-area">


            {{-- PAGE HEADER --}}
            <div class="page-header">

                <h2>Monitoring Pencetakan</h2>

                <p>
                    Pemantauan semua kegiatan pencetakan buku braille.
                </p>

            </div>


            {{-- FILTER --}}
            <div class="filter-bar">

                <div class="status-dropdown" id="statusDropdown">

                    <button
                        type="button"
                        class="status-dropdown-btn"
                        id="statusDropdownBtn"
                    >

                        <span id="statusDropdownLabel">
                            Semua Status
                        </span>

                        <i class="fas fa-chevron-down"></i>

                    </button>


                    <div
                        class="status-dropdown-menu"
                        id="statusDropdownMenu"
                    >

                        <a
                            href="#"
                            class="status-filter-item active"
                            data-status="semua"
                        >
                            Semua Status
                        </a>

                        <a
                            href="#"
                            class="status-filter-item"
                            data-status="menunggu"
                        >
                            Menunggu
                        </a>

                        <a
                            href="#"
                            class="status-filter-item"
                            data-status="diproses"
                        >
                            Sedang Dicetak
                        </a>

                        <a
                            href="#"
                            class="status-filter-item"
                            data-status="selesai"
                        >
                            Selesai
                        </a>

                    </div>

                </div>

            </div>


            {{-- LIST PENCAKETAN --}}
            <div class="printing-list">


                {{-- CARD 1 --}}
                <div
                    class="printing-card"
                    data-status="menunggu"
                >

                    <div class="card-top">

                        <span class="book-type">
                            Literasi Digital
                        </span>


                        <div class="status-area">

                            <div class="print-status status-menunggu">
                                Menunggu QC
                            </div>

                            <button class="btn-detail">
                                Lihat detail
                            </button>

                        </div>

                    </div>


                    <div class="book-code">
                        CEK-2025-0001
                    </div>

                    <div class="book-title">
                        Petualangan untuk Semua · 1 eksemplar
                    </div>

                    <div class="order-number">
                        Pesanan: WYG-2025-0002
                    </div>


                    <div class="printing-info">

                        <div class="info-item">

                            <span class="info-label">
                                PIC
                            </span>

                            <span class="info-value">
                                Hendra Wijaya
                            </span>

                        </div>


                        <div class="info-item">

                            <span class="info-label">
                                Target
                            </span>

                            <span class="info-value">
                                1 buku
                            </span>

                        </div>


                        <div class="info-item">

                            <span class="info-label">
                                Deadline
                            </span>

                            <span class="info-value">
                                20 Januari 2025
                            </span>

                        </div>

                    </div>


                    <div class="progress-info">

                        <span>
                            1 buku selesai
                        </span>

                        <span class="progress-percent">
                            0%
                        </span>

                    </div>


                    <div class="progress-bar">

                        <div
                            class="progress-fill"
                            style="width: 0%;"
                        ></div>

                    </div>

                </div>


                {{-- CARD 2 --}}
                <div
                    class="printing-card"
                    data-status="menunggu"
                >

                    <div class="card-top">

                        <span class="book-type">
                            Literasi Manual
                        </span>


                        <div class="status-area">

                            <div class="print-status status-menunggu">
                                Menunggu Bahan
                            </div>

                            <button class="btn-detail">
                                Lihat detail
                            </button>

                        </div>

                    </div>


                    <div class="book-code">
                        CEK-2025-0002
                    </div>

                    <div class="book-title">
                        Matematika SMK Kelas X · 5 eksemplar
                    </div>

                    <div class="order-number">
                        Pesanan: WYG-2025-0004
                    </div>


                    <div class="printing-info">

                        <div class="info-item">

                            <span class="info-label">
                                PIC
                            </span>

                            <span class="info-value">
                                M. Iqbal F
                            </span>

                        </div>


                        <div class="info-item">

                            <span class="info-label">
                                Target
                            </span>

                            <span class="info-value">
                                5 buku
                            </span>

                        </div>


                        <div class="info-item">

                            <span class="info-label">
                                Deadline
                            </span>

                            <span class="info-value">
                                25 Januari 2025
                            </span>

                        </div>

                    </div>


                    <div class="progress-info">

                        <span>
                            0 buku selesai
                        </span>

                        <span class="progress-percent">
                            0%
                        </span>

                    </div>


                    <div class="progress-bar">

                        <div
                            class="progress-fill"
                            style="width: 0%;"
                        ></div>

                    </div>

                </div>


                {{-- CARD 3 --}}
                <div
                    class="printing-card"
                    data-status="selesai"
                >

                    <div class="card-top">

                        <span class="book-type">
                            Literasi Digital
                        </span>


                        <div class="status-area">

                            <div class="print-status status-selesai">
                                Selesai
                            </div>

                            <button class="btn-detail">
                                Lihat detail
                            </button>

                        </div>

                    </div>


                    <div class="book-code">
                        CEK-2024-0015
                    </div>

                    <div class="book-title">
                        Sejarah Indonesia Modern · 3 eksemplar
                    </div>

                    <div class="order-number">
                        Pesanan: WYG-2025-0003
                    </div>


                    <div class="printing-info">

                        <div class="info-item">

                            <span class="info-label">
                                PIC
                            </span>

                            <span class="info-value">
                                Yuda
                            </span>

                        </div>


                        <div class="info-item">

                            <span class="info-label">
                                Target
                            </span>

                            <span class="info-value">
                                3 buku
                            </span>

                        </div>


                        <div class="info-item">

                            <span class="info-label">
                                Deadline
                            </span>

                            <span class="info-value">
                                5 Desember 2024
                            </span>

                        </div>

                    </div>


                    <div class="progress-info">

                        <span>
                            3 dari 3 buku selesai
                        </span>

                        <span class="progress-percent">
                            100%
                        </span>

                    </div>


                    <div class="progress-bar">

                        <div
                            class="progress-fill completed"
                            style="width: 100%;"
                        ></div>

                    </div>

                </div>


            </div>

        </main>

    </div>


    {{-- JAVASCRIPT FILTER --}}
    <script>

        (function () {

            var btn =
                document.getElementById('statusDropdownBtn');

            var menu =
                document.getElementById('statusDropdownMenu');

            var label =
                document.getElementById('statusDropdownLabel');

            var items =
                document.querySelectorAll('.status-filter-item');

            var cards =
                document.querySelectorAll('.printing-card');


            btn.addEventListener('click', function () {

                menu.classList.toggle('open');

            });


            document.addEventListener('click', function (e) {

                var dropdown =
                    document.getElementById('statusDropdown');

                if (!dropdown.contains(e.target)) {

                    menu.classList.remove('open');

                }

            });


            items.forEach(function (item) {

                item.addEventListener('click', function (e) {

                    e.preventDefault();

                    var status =
                        this.dataset.status;


                    items.forEach(function (item) {

                        item.classList.remove('active');

                    });


                    this.classList.add('active');


                    label.textContent =
                        this.textContent;


                    menu.classList.remove('open');


                    cards.forEach(function (card) {

                        if (
                            status === 'semua' ||
                            card.dataset.status === status
                        ) {

                            card.style.display = '';

                        } else {

                            card.style.display = 'none';

                        }

                    });

                });

            });

        })();

    </script>

</body>

</html>