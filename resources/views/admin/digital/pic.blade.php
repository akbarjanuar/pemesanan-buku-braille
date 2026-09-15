<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>PIC - Admin Literasi Digital</title>

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

    @include('partials.admin-digital-nav')

    <div class="main-wrapper">

        <!-- TOPBAR -->
        <header class="topbar">

            <div class="topbar-left">
                <button type="button" class="menu-toggle">
                    <i class="fas fa-bars"></i>
                </button>

                <span class="page-title">PIC</span>
            </div>

            <div class="topbar-right">
                <i class="far fa-bell"></i>
            </div>

        </header>


        <!-- CONTENT -->
        <main class="content">

            <div class="content-header">

                <div class="page-heading">
                    <h1>Daftar PIC</h1>
                    <p>Penanggung jawab setiap pekerjaan pencetakan.</p>
                </div>

                <a href="#" class="btn-add">
                    <i class="fas fa-plus"></i>
                    Tambah PIC
                </a>

            </div>


            <!-- TABLE -->
            <div class="table-container">

                <table class="pic-table">

                    <thead>
                        <tr>
                            <th>Nama PIC</th>
                            <th>Nomor Telepon</th>
                            <th>Pekerjaan Aktif</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        <tr>
                            <td>Keenan Ardana</td>
                            <td>081234567890</td>
                            <td>1</td>
                            <td>
                                <a href="#" class="btn-detail">
                                    Detail
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td>Ezra Adinata</td>
                            <td>081345678901</td>
                            <td>1</td>
                            <td>
                                <a href="#" class="btn-detail">
                                    Detail
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td>Zayn Ardhana</td>
                            <td>082156789012</td>
                            <td>1</td>
                            <td>
                                <a href="#" class="btn-detail">
                                    Detail
                                </a>
                            </td>
                        </tr>

                    </tbody>

                </table>

            </div>

        </main>

    </div>


    <style>

        :root {
            --primary: #c62828;
            --primary-hover: #b71c1c;
            --bg-color: #fcfcfc;
            --border-color: #eaeaea;
            --text-main: #111111;
            --text-muted: #888888;
        }


        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }


        body {
            display: flex;
            width: 100%;
            min-height: 100vh;
            background-color: var(--bg-color);
            color: var(--text-main);
            overflow: hidden;
        }


        /* =========================
           MAIN WRAPPER
        ========================= */

        .main-wrapper {
            flex: 1;
            min-width: 0;
            width: calc(100% - 260px);
            display: flex;
            flex-direction: column;
            background-color: #ffffff;
            transition: width 0.25s ease;
        }


        /* =========================
           TOPBAR
        ========================= */

        .topbar {
            width: 100%;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            background-color: #ffffff;
            border-bottom: 1px solid var(--border-color);
            flex-shrink: 0;
        }


        .topbar-left {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }


        .menu-toggle {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border: none;
            background: transparent;
            color: var(--text-main);
            font-size: 17px;
            cursor: pointer;
            padding: 0;
        }


        .page-title {
            font-size: 16px;
            font-weight: 700;
            white-space: nowrap;
        }


        .topbar-right {
            display: flex;
            align-items: center;
            color: var(--text-main);
            font-size: 17px;
            flex-shrink: 0;
        }


        /* =========================
           CONTENT
        ========================= */

        .content {
            flex: 1;
            width: 100%;
            padding: 18px 24px;
            overflow-y: auto;
            overflow-x: hidden;
        }


        .content-header {
            width: 100%;
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 16px;
        }


        .page-heading {
            min-width: 0;
        }


        .page-heading h1 {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 5px;
        }


        .page-heading p {
            font-size: 9px;
            color: var(--text-muted);
        }


        /* =========================
           BUTTON TAMBAH
        ========================= */

        .btn-add {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            padding: 8px 13px;
            background-color: var(--primary);
            color: #ffffff;
            border-radius: 5px;
            text-decoration: none;
            font-size: 10px;
            font-weight: 700;
            white-space: nowrap;
            flex-shrink: 0;
        }


        .btn-add:hover {
            background-color: var(--primary-hover);
        }


        /* =========================
           TABLE
        ========================= */

        .table-container {
            width: 100%;
            background-color: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            overflow-x: auto;
            overflow-y: hidden;
        }


        .pic-table {
            width: 100%;
            min-width: 560px;
            border-collapse: collapse;
            table-layout: fixed;
        }


        .pic-table th {
            height: 24px;
            padding: 8px 14px;
            background-color: #f0eeee;
            color: #666666;
            font-size: 8px;
            font-weight: 700;
            text-align: left;
            white-space: nowrap;
        }


        .pic-table th:nth-child(1) {
            width: 24%;
        }


        .pic-table th:nth-child(2) {
            width: 25%;
        }


        .pic-table th:nth-child(3) {
            width: 25%;
            text-align: center;
        }


        .pic-table th:nth-child(4) {
            width: 26%;
            text-align: center;
        }


        .pic-table td {
            height: 27px;
            padding: 7px 14px;
            border-top: 1px solid #eeeeee;
            color: #222222;
            font-size: 8px;
            white-space: nowrap;
        }


        .pic-table td:nth-child(3),
        .pic-table td:nth-child(4) {
            text-align: center;
        }


        /* =========================
           DETAIL BUTTON
        ========================= */

        .btn-detail {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 38px;
            padding: 3px 8px;
            background-color: var(--primary);
            color: #ffffff;
            border-radius: 3px;
            text-decoration: none;
            font-size: 7px;
            font-weight: 700;
        }


        .btn-detail:hover {
            background-color: var(--primary-hover);
        }


        /* =====================================================
           TABLET
        ===================================================== */

        @media (max-width: 900px) {

            body {
                overflow: visible;
                min-height: 100vh;
            }


            .main-wrapper {
                width: 100%;
                min-width: 0;
            }


            .topbar {
                height: 60px;
                padding: 0 16px;
            }


            .content {
                padding: 18px 16px;
            }


            .content-header {
                gap: 12px;
            }


            .page-heading h1 {
                font-size: 15px;
            }


            .page-heading p {
                font-size: 9px;
            }


            .btn-add {
                padding: 8px 11px;
                font-size: 9px;
            }
        }


        /* =====================================================
           HP
        ===================================================== */

        @media (max-width: 600px) {

            .topbar {
                height: 58px;
                padding: 0 14px;
            }


            .page-title {
                font-size: 15px;
            }


            .topbar-right {
                font-size: 16px;
            }


            .content {
                padding: 16px 12px 24px;
            }


            .content-header {
                align-items: flex-start;
                flex-direction: column;
                gap: 12px;
                margin-bottom: 14px;
            }


            .page-heading h1 {
                font-size: 15px;
                margin-bottom: 4px;
            }


            .page-heading p {
                font-size: 8px;
            }


            .btn-add {
                align-self: flex-end;
                padding: 7px 11px;
                font-size: 9px;
            }


            .table-container {
                width: 100%;
                border-radius: 7px;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }


            .pic-table {
                min-width: 560px;
            }


            .pic-table th {
                padding: 8px 12px;
                font-size: 8px;
            }


            .pic-table td {
                padding: 8px 12px;
                font-size: 8px;
            }


            .btn-detail {
                min-width: 38px;
                padding: 4px 8px;
                font-size: 7px;
            }
        }


        /* =====================================================
           HP SANGAT KECIL
        ===================================================== */

        @media (max-width: 400px) {

            .content {
                padding-left: 10px;
                padding-right: 10px;
            }


            .topbar {
                padding-left: 12px;
                padding-right: 12px;
            }


            .btn-add {
                font-size: 8px;
                padding: 7px 10px;
            }
        }

    </style>

</body>
</html>