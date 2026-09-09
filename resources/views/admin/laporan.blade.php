<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - BrailleKita</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .page-header-row { display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 16px; margin-bottom: 24px; }
        .page-header h2 { font-size: 22px; font-weight: 700; margin-bottom: 4px; }
        .page-header p { color: var(--text-muted); font-size: 14px; max-width: 600px; }

        .btn-export {
            background: var(--primary); color: white; border: none;
            padding: 11px 20px; border-radius: 8px; font-size: 14px; font-weight: 700;
            font-family: inherit; cursor: pointer; display: inline-flex; align-items: center; gap: 8px;
            white-space: nowrap; text-decoration: none;
        }
        .btn-export:hover { background: var(--primary-hover); }

        .ringkasan-card {
            background: var(--surface); border: 1px solid var(--border); border-radius: 12px;
            padding: 20px 24px; margin-bottom: 24px;
        }
        .ringkasan-title { font-size: 16px; font-weight: 700; margin-bottom: 4px; }
        .ringkasan-desc { font-size: 13px; color: var(--text-muted); margin-bottom: 18px; }

        .filter-row { display: flex; flex-wrap: wrap; align-items: center; gap: 10px; }

        .quick-filter-group { display: flex; flex-wrap: nowrap; overflow-x: auto; gap: 8px; }
        .quick-filter-btn {
            background: white; border: 1px solid var(--border); border-radius: 8px;
            padding: 9px 16px; font-size: 13px; font-weight: 700; color: var(--text-dark);
            cursor: pointer; font-family: inherit; white-space: nowrap; flex-shrink: 0;
        }
        .quick-filter-btn:hover { border-color: var(--primary); }
        .quick-filter-btn.active { background: var(--primary); border-color: var(--primary); color: white; }

        .date-range-group { display: flex; align-items: center; gap: 10px; margin-left: auto; flex-wrap: wrap; }
        .date-field { display: flex; flex-direction: column; gap: 4px; }
        .date-field label { font-size: 11px; color: var(--text-muted); font-weight: 700; }
        .date-field input {
            border: 1px solid var(--border); border-radius: 6px; padding: 8px 10px;
            font-family: inherit; font-size: 13px; outline: none;
        }
        .date-field input:focus { border-color: var(--primary); }

        .btn-terapkan {
            background: var(--primary); color: white; border: none;
            padding: 9px 18px; border-radius: 8px; font-size: 13px; font-weight: 700;
            font-family: inherit; cursor: pointer; align-self: flex-end;
        }
        .btn-terapkan:hover { background: var(--primary-hover); }

        .laporan-section { margin-bottom: 28px; }
        .laporan-section-title { font-size: 16px; font-weight: 700; margin-bottom: 12px; }

        .table-card { background-color: var(--surface); border: 1px solid var(--border); border-radius: 12px; overflow: hidden; }
        .table-wrapper { width: 100%; overflow-x: auto; }
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th { background-color: #f1f1f1; padding: 12px 20px; text-align: left; font-size: 12px; color: var(--text-muted); font-weight: 700; white-space: nowrap; }
        .data-table td { padding: 14px 20px; border-bottom: 1px solid var(--border); font-size: 13px; font-weight: 700; color: var(--text-dark); white-space: nowrap; }
        .data-table tr:last-child td { border-bottom: none; }

        .status-dikirim { color: #0097a7; }
        .status-dicetak { color: #fbc02d; }
        .status-selesai { color: #2e7d32; }
        .status-diproses { color: #e65100; }
        .status-batal { color: #c62828; }
        .status-tersedia { color: #2e7d32; }
        .status-menunggu { color: #e65100; }
        .status-aktif { color: #2e7d32; }

        @media (max-width: 700px) {
            .filter-row { flex-direction: column; align-items: stretch; }
            .date-range-group { margin-left: 0; width: 100%; }
            .date-field { flex: 1; }
            .btn-terapkan { align-self: stretch; }
            .btn-export { width: 100%; justify-content: center; }
        }

        /* ===== MODAL EXPORT DATA ===== */
        .modal-overlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.45);
            z-index: 300;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .modal-overlay.open { display: flex; }

        .modal-box {
            background: var(--surface);
            border-radius: 12px;
            width: 100%;
            max-width: 440px;
            max-height: 88vh;
            overflow-y: auto;
            padding: 24px;
        }
        .modal-title { font-size: 18px; font-weight: 700; margin-bottom: 4px; }
        .modal-subtitle { font-size: 13px; color: var(--text-muted); margin-bottom: 18px; }

        .modal-section-label { font-size: 13px; font-weight: 700; color: var(--text-muted); margin: 18px 0 10px 0; }
        .modal-section-label:first-of-type { margin-top: 0; }

        .option-radio-list { display: flex; flex-direction: column; gap: 8px; }
        .option-radio-item {
            display: flex; align-items: center; gap: 12px;
            border: 1px solid var(--border); border-radius: 8px;
            padding: 12px 14px; cursor: pointer; font-size: 14px; font-weight: 700;
            transition: border-color .15s, background-color .15s;
        }
        .option-radio-item:hover { border-color: var(--primary); }
        .option-radio-item.selected { border-color: var(--primary); background: #fdecea; }
        .option-radio-item input[type="radio"] { width: 17px; height: 17px; accent-color: var(--primary); flex-shrink: 0; }

        .periode-date-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-top: 10px; }
        .periode-date-row .date-field label { font-size: 12px; }
        .periode-date-row .date-field input { width: 100%; padding: 9px 10px; }

        .modal-actions { display: flex; gap: 12px; margin-top: 22px; }
        .btn-modal-cancel {
            flex: 1; background: white; border: 1px solid var(--border); color: var(--text-dark);
            padding: 12px; border-radius: 8px; font-weight: 700; font-size: 14px; cursor: pointer; font-family: inherit;
        }
        .btn-modal-cancel:hover { background: #f5f5f5; }
        .btn-export-excel {
            flex: 1; background: #bdbdbd; color: white; border: none;
            padding: 12px; border-radius: 8px; font-weight: 700; font-size: 14px; cursor: not-allowed; font-family: inherit;
        }
        .btn-export-excel.enabled { background: var(--primary); cursor: pointer; }
        .btn-export-excel.enabled:hover { background: var(--primary-hover); }
    </style>
</head>
<body>

    @include('partials.admin-nav', ['activeMenu' => 'laporan'])

    <div class="main-wrapper">

        <header class="topbar">
            <div class="topbar-left">
                <button type="button" class="menu-toggle"><i class="fas fa-bars"></i></button>
                <span class="topbar-title">Laporan</span>
            </div>

            <div class="topbar-right">
                <i class="far fa-bell notification-bell"></i>
                <div class="user-profile">
                    <span>{{ auth()->user()->nama ?? 'Admin' }}</span>
                    <i class="fas fa-user-circle"></i>
                </div>
            </div>
        </header>

        <main class="content-area">

            <div class="page-header-row">
                <div class="page-header">
                    <h2>Laporan & Export Data</h2>
                    <p>Monitoring dan ringkasan laporan aktivitas buku, pelanggan dan data lainnya.</p>
                </div>
                <button type="button" class="btn-export" id="btnOpenExportModal"><i class="fas fa-download"></i> Export Data</button>
            </div>

            <div class="ringkasan-card">
                <div class="ringkasan-title">Ringkasan Laporan</div>
                <div class="ringkasan-desc">Pilih rentang waktu untuk melihat data laporan.</div>

                <div class="filter-row">
                    <div class="quick-filter-group" id="quickFilterGroup">
                        <button type="button" class="quick-filter-btn" data-range="hari-ini">Hari Ini</button>
                        <button type="button" class="quick-filter-btn" data-range="minggu-ini">Minggu Ini</button>
                        <button type="button" class="quick-filter-btn" data-range="bulan-ini">Bulan Ini</button>
                        <button type="button" class="quick-filter-btn active" data-range="6-bulan">6 Bulan Terakhir</button>
                    </div>

                    <div class="date-range-group">
                        <div class="date-field">
                            <label>Tanggal mulai</label>
                            <input type="date" id="tanggalMulai">
                        </div>
                        <div class="date-field">
                            <label>Tanggal akhir</label>
                            <input type="date" id="tanggalAkhir">
                        </div>
                        <button type="button" class="btn-terapkan" id="btnTerapkan">Terapkan</button>
                    </div>
                </div>
            </div>

            {{-- DATA DUMMY SEMENTARA — nanti diganti data asli dari database --}}

            <div class="laporan-section">
                <div class="laporan-section-title">Data Pesanan</div>
                <div class="table-card">
                    <div class="table-wrapper">
                        <table class="data-table" id="tabelDataPesanan">
                            <thead>
                                <tr>
                                    <th>Nomor Pesanan</th>
                                    <th>Tanggal</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Jenis</th>
                                    <th>Judul Buku</th>
                                    <th>Jumlah Pesanan</th>
                                    <th>Status Pesanan</th>
                                    <th>Tanggal Selesai</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>WYG-2026-0014</td><td>3 Januari 2026</td><td>Budi Santoso</td><td>Pribadi</td>
                                    <td>Terjemahan Al-Qur'an, Bumi Manusia</td><td>3</td>
                                    <td class="status-dikirim">Sedang dikirim</td><td>-</td>
                                </tr>
                                <tr>
                                    <td>WYG-2025-0003</td><td>1 Desember 2025</td><td>Budi Santoso</td><td>Pribadi</td>
                                    <td>Sejarah Indonesia Modern</td><td>1</td>
                                    <td class="status-selesai">Selesai</td><td>3 Desember 2025</td>
                                </tr>
                                <tr>
                                    <td>WYG-2025-0004</td><td>14 Januari 2025</td><td>Yayasan Tunas Bangsa</td><td>Lembaga</td>
                                    <td>Taman Sari Anak Wilis</td><td>40</td>
                                    <td class="status-diproses">Menunggu diproses</td><td>-</td>
                                </tr>
                                <tr>
                                    <td>WYG-2025-0005</td><td>2 Januari 2025</td><td>Siti Rahayu</td><td>Pribadi</td>
                                    <td>Pathology Word</td><td>1</td>
                                    <td class="status-batal">Dibatalkan</td><td>-</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="laporan-section">
                <div class="laporan-section-title">Data Buku</div>
                <div class="table-card">
                    <div class="table-wrapper">
                        <table class="data-table" id="tabelDataBuku">
                            <thead>
                                <tr>
                                    <th>Judul Buku</th>
                                    <th>Kategori</th>
                                    <th>Jml Permintaan</th>
                                    <th>Jml Tersedia</th>
                                    <th>Perlu Dicetak</th>
                                    <th>Sudah Dicetak</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td>Al-Qur'an dan Terjemahan</td><td>Agama</td><td>10</td><td>14</td><td>0</td><td>14</td><td class="status-tersedia">Tersedia</td></tr>
                                <tr><td>Bumi Manusia</td><td>Fiksi</td><td>12</td><td>10</td><td>2</td><td>12</td><td class="status-tersedia">Tersedia</td></tr>
                                <tr><td>Laskar Pelangi</td><td>Fiksi</td><td>8</td><td>8</td><td>0</td><td>8</td><td class="status-tersedia">Tersedia</td></tr>
                                <tr><td>Matematika SMA Kelas X</td><td>Pendidikan</td><td>50</td><td>30</td><td>20</td><td>30</td><td class="status-menunggu">Perlu Dicetak</td></tr>
                                <tr><td>Fisika untuk Semua</td><td>Pendidikan</td><td>5</td><td>4</td><td>1</td><td>4</td><td class="status-tersedia">Tersedia</td></tr>
                                <tr><td>Sejarah Indonesia Modern</td><td>Sejarah</td><td>3</td><td>3</td><td>0</td><td>3</td><td class="status-tersedia">Tersedia</td></tr>
                                <tr><td>Taman Sari Anak Wilis</td><td>Non-Fiksi</td><td>40</td><td>2</td><td>38</td><td>2</td><td class="status-menunggu">Perlu Dicetak</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="laporan-section">
                <div class="laporan-section-title">Data Pencetakan</div>
                <div class="table-card">
                    <div class="table-wrapper">
                        <table class="data-table" id="tabelDataPencetakan">
                            <thead>
                                <tr>
                                    <th>Nomor Pesanan</th>
                                    <th>Judul Buku</th>
                                    <th>Jns Pemesanan</th>
                                    <th>Jumlah</th>
                                    <th>Divisi</th>
                                    <th>PIC</th>
                                    <th>Deadline</th>
                                    <th>Progress</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>CEK-2025-0001</td><td>Fisika untuk Semua</td><td>Literasi Digital</td><td>1</td>
                                    <td>Hendra Wijaya</td><td>Hendra Wijaya</td><td>20 Januari 2025</td><td>0%</td>
                                    <td class="status-diproses">Menunggu diproses</td>
                                </tr>
                                <tr>
                                    <td>CEK-2025-0002</td><td>Matematika SMA Kelas X</td><td>Literasi Manual</td><td>50</td>
                                    <td>M. Iqbal F</td><td>M. Iqbal F</td><td>25 Januari 2025</td><td>0%</td>
                                    <td class="status-menunggu">Menunggu Bahan</td>
                                </tr>
                                <tr>
                                    <td>CEK-2024-0015</td><td>Sejarah Indonesia Modern</td><td>Literasi Digital</td><td>3</td>
                                    <td>Yuda</td><td>Yuda</td><td>5 Desember 2024</td><td>100%</td>
                                    <td class="status-selesai">Selesai</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="laporan-section">
                <div class="laporan-section-title">Data Permintaan Bahan</div>
                <div class="table-card">
                    <div class="table-wrapper">
                        <table class="data-table" id="tabelDataBahan">
                            <thead>
                                <tr>
                                    <th>No. Permintaan</th>
                                    <th>Tanggal</th>
                                    <th>Bahan Baku</th>
                                    <th>Jumlah</th>
                                    <th>Diminta Oleh</th>
                                    <th>Tanggal Dibutuhkan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td>BHN-2025-0001</td><td>9 Januari 2025</td><td>Kertas Braille</td><td>200 Lembar</td><td>Hendra Wijaya</td><td>15 Januari 2025</td><td class="status-menunggu">Menunggu Persetujuan</td></tr>
                                <tr><td>BHN-2025-0002</td><td>10 Januari 2025</td><td>Tinta Braille</td><td>10 Botol</td><td>M. Iqbal F</td><td>18 Januari 2025</td><td class="status-tersedia">Disetujui</td></tr>
                                <tr><td>BHN-2024-0088</td><td>3 Desember 2024</td><td>Sampul Buku</td><td>50 Lembar</td><td>Yuda</td><td>8 Desember 2024</td><td class="status-selesai">Selesai</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="laporan-section">
                <div class="laporan-section-title">Data Pelanggan</div>
                <div class="table-card">
                    <div class="table-wrapper">
                        <table class="data-table" id="tabelDataPelanggan">
                            <thead>
                                <tr>
                                    <th>Id Pelanggan</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Email</th>
                                    <th>Nomor Telepon</th>
                                    <th>Alamat</th>
                                    <th>Tanggal Daftar</th>
                                    <th>Jml Pesanan</th>
                                    <th>Status Akun</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td>PWG-0001</td><td>Budi Santoso</td><td>budisutanto@gmail.com</td><td>081234567890</td><td>Kota Bandung, Jawa Barat</td><td>1 April 2024</td><td>4</td><td class="status-aktif">Aktif</td></tr>
                                <tr><td>PWG-0002</td><td>Yayasan Tunas Bangsa</td><td>tunasbangsa@gmail.com</td><td>083456789012</td><td>Kota Bandung, Jawa Barat</td><td>14 April 2024</td><td>1</td><td class="status-aktif">Aktif</td></tr>
                                <tr><td>PWG-0003</td><td>SLB Negeri 1 Bandung</td><td>slbn1bdg@gmail.com</td><td>022-1234567</td><td>Kota Bandung, Jawa Barat</td><td>5 Agustus 2024</td><td>1</td><td class="status-aktif">Aktif</td></tr>
                                <tr><td>PWG-0005</td><td>Siti Rahayu</td><td>sitirahayu@gmail.com</td><td>082956760016</td><td>Kota Bandung, Jawa Barat</td><td>9 September 2024</td><td>2</td><td class="status-aktif">Aktif</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </main>
    </div>

    <!-- MODAL EXPORT DATA -->
    <div class="modal-overlay" id="exportModal">
        <div class="modal-box">
            <div class="modal-title">Export Data</div>
            <div class="modal-subtitle">Pilih data yang ingin diekspor</div>

            <div class="modal-section-label">Jenis Data</div>
            <div class="option-radio-list" id="dataTypeList">
                <label class="option-radio-item">
                    <input type="radio" name="jenisData" value="pesanan"> Data Pesanan
                </label>
                <label class="option-radio-item">
                    <input type="radio" name="jenisData" value="buku"> Data Buku
                </label>
                <label class="option-radio-item">
                    <input type="radio" name="jenisData" value="pencetakan"> Data Pencetakan
                </label>
                <label class="option-radio-item">
                    <input type="radio" name="jenisData" value="bahan"> Data Permintaan Bahan
                </label>
                <label class="option-radio-item">
                    <input type="radio" name="jenisData" value="pelanggan"> Data Pelanggan
                </label>
                <label class="option-radio-item">
                    <input type="radio" name="jenisData" value="semua"> Semua Data
                </label>
            </div>

            <div class="modal-section-label">Periode Data</div>
            <div class="option-radio-list" id="periodeList">
                <label class="option-radio-item">
                    <input type="radio" name="periodeData" value="semua"> Semua
                </label>
                <label class="option-radio-item">
                    <input type="radio" name="periodeData" value="hari-ini"> Hari Ini
                </label>
                <label class="option-radio-item">
                    <input type="radio" name="periodeData" value="minggu-ini"> Minggu Ini
                </label>
                <label class="option-radio-item">
                    <input type="radio" name="periodeData" value="bulan-ini"> Bulan Ini
                </label>
                <label class="option-radio-item">
                    <input type="radio" name="periodeData" value="custom"> Tentukan Tanggal
                </label>
            </div>

            <div class="periode-date-row" id="periodeDateRow" style="display:none;">
                <div class="date-field">
                    <label>Tanggal Awal</label>
                    <input type="date" id="exportTanggalAwal">
                </div>
                <div class="date-field">
                    <label>Tanggal Akhir</label>
                    <input type="date" id="exportTanggalAkhir">
                </div>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn-modal-cancel" id="btnExportCancel">Batal</button>
                <button type="button" class="btn-export-excel" id="btnExportExcel" disabled>Export ke Excel</button>
            </div>
        </div>
    </div>

    <script>
        (function () {
            var quickFilterBtns = document.querySelectorAll('.quick-filter-btn');

            quickFilterBtns.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    quickFilterBtns.forEach(function (b) { b.classList.remove('active'); });
                    this.classList.add('active');
                    // TODO: kirim range terpilih ke backend untuk filter data (belum diimplementasikan)
                });
            });

            document.getElementById('btnTerapkan').addEventListener('click', function () {
                var mulai = document.getElementById('tanggalMulai').value;
                var akhir = document.getElementById('tanggalAkhir').value;

                quickFilterBtns.forEach(function (b) { b.classList.remove('active'); });

                // TODO: kirim tanggalMulai & tanggalAkhir ke backend untuk filter data (belum diimplementasikan)
                console.log('Terapkan rentang tanggal:', mulai, 'sampai', akhir);
            });

            /* ===== MODAL EXPORT DATA ===== */
            var modal = document.getElementById('exportModal');
            var btnOpen = document.getElementById('btnOpenExportModal');
            var btnCancel = document.getElementById('btnExportCancel');
            var btnExport = document.getElementById('btnExportExcel');

            var dataTypeItems = document.querySelectorAll('#dataTypeList .option-radio-item');
            var periodeItems = document.querySelectorAll('#periodeList .option-radio-item');
            var periodeDateRow = document.getElementById('periodeDateRow');

            var jenisDataRadios = document.querySelectorAll('input[name="jenisData"]');
            var periodeRadios = document.querySelectorAll('input[name="periodeData"]');

            function resetModal() {
                jenisDataRadios.forEach(function (r) { r.checked = false; });
                periodeRadios.forEach(function (r) { r.checked = false; });
                dataTypeItems.forEach(function (i) { i.classList.remove('selected'); });
                periodeItems.forEach(function (i) { i.classList.remove('selected'); });
                periodeDateRow.style.display = 'none';
                btnExport.disabled = true;
                btnExport.classList.remove('enabled');
            }

            btnOpen.addEventListener('click', function () {
                resetModal();
                modal.classList.add('open');
            });

            btnCancel.addEventListener('click', function () {
                modal.classList.remove('open');
            });

            jenisDataRadios.forEach(function (radio) {
                radio.addEventListener('change', function () {
                    dataTypeItems.forEach(function (i) { i.classList.remove('selected'); });
                    this.closest('.option-radio-item').classList.add('selected');
                    checkFormValid();
                });
            });

            periodeRadios.forEach(function (radio) {
                radio.addEventListener('change', function () {
                    periodeItems.forEach(function (i) { i.classList.remove('selected'); });
                    this.closest('.option-radio-item').classList.add('selected');
                    periodeDateRow.style.display = (this.value === 'custom') ? 'grid' : 'none';
                    checkFormValid();
                });
            });

            function checkFormValid() {
                var jenisDipilih = document.querySelector('input[name="jenisData"]:checked');
                var periodeDipilih = document.querySelector('input[name="periodeData"]:checked');
                var valid = jenisDipilih && periodeDipilih;

                btnExport.disabled = !valid;
                btnExport.classList.toggle('enabled', !!valid);
            }

            /* ===== GENERATE FILE EXCEL (client-side, format .xls) ===== */

            // Ambil tabel HTML berdasarkan jenis data yang dipilih
            function ambilHtmlTabel(jenis) {
                var mapId = {
                    'pesanan': 'tabelDataPesanan',
                    'buku': 'tabelDataBuku',
                    'pencetakan': 'tabelDataPencetakan',
                    'bahan': 'tabelDataBahan',
                    'pelanggan': 'tabelDataPelanggan',
                };

                if (jenis === 'semua') {
                    var semuaHtml = '';
                    var judulSection = {
                        'pesanan': 'Data Pesanan',
                        'buku': 'Data Buku',
                        'pencetakan': 'Data Pencetakan',
                        'bahan': 'Data Permintaan Bahan',
                        'pelanggan': 'Data Pelanggan',
                    };
                    Object.keys(mapId).forEach(function (key) {
                        var tabel = document.getElementById(mapId[key]);
                        semuaHtml += '<h3>' + judulSection[key] + '</h3>' + tabel.outerHTML + '<br><br>';
                    });
                    return semuaHtml;
                }

                var tabel = document.getElementById(mapId[jenis]);
                return tabel ? tabel.outerHTML : '';
            }

            function unduhSebagaiExcel(namaFile, htmlIsiTabel) {
                var templateHtml =
                    '<html xmlns:o="urn:schemas-microsoft-com:office:office" ' +
                    'xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">' +
                    '<head><meta charset="utf-8"></head><body>' +
                    htmlIsiTabel +
                    '</body></html>';

                var blob = new Blob(['\ufeff' + templateHtml], { type: 'application/vnd.ms-excel' });
                var link = document.createElement('a');
                link.href = URL.createObjectURL(blob);
                link.download = namaFile + '.xls';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }

            btnExport.addEventListener('click', function () {
                if (btnExport.disabled) return;

                var jenis = document.querySelector('input[name="jenisData"]:checked').value;
                var periode = document.querySelector('input[name="periodeData"]:checked').value;

                // Catatan: filter berdasarkan periode/tanggal belum diterapkan ke data
                // (data masih dummy statis). Nanti disesuaikan setelah data asli dari backend tersedia.

                var htmlTabel = ambilHtmlTabel(jenis);
                var namaFile = 'Laporan_' + jenis + '_' + periode + '_' + new Date().toISOString().slice(0, 10);

                unduhSebagaiExcel(namaFile, htmlTabel);

                modal.classList.remove('open');
            });
        })();
    </script>

</body>
</html>