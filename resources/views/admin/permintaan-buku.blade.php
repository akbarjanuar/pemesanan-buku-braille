<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permintaan Buku - BrailleKita</title>

    <style>
        .page-header { margin-bottom: 20px; }
        .page-header h2 { font-size: 22px; font-weight: 700; margin-bottom: 4px; }
        .page-header p { color: var(--text-muted); font-size: 14px; }

        .filter-bar {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 12px;
        }

        .filter-bar-left { display: flex; flex-direction: column; gap: 10px; }

        .status-dropdown, .doc-dropdown { position: relative; display: inline-block; }
        .status-dropdown-btn, .doc-dropdown-btn {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 10px 16px;
            font-family: inherit;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--text-dark);
            transition: border-color .15s, background-color .15s, color .15s;
        }
        .status-dropdown-btn:hover, .doc-dropdown-btn:hover { border-color: var(--primary); }
        .doc-dropdown-btn.active { border-color: var(--primary); background: #fdecea; color: var(--primary); }

        .status-dropdown-menu, .doc-dropdown-menu {
            display: none;
            position: absolute;
            top: calc(100% + 6px);
            left: 0;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            min-width: 200px;
            z-index: 10;
            overflow: hidden;
        }
        .status-dropdown-menu.open, .doc-dropdown-menu.open { display: block; }
        .status-dropdown-menu a, .doc-dropdown-menu a {
            display: block;
            padding: 10px 16px;
            font-size: 14px;
            font-weight: 700;
            color: var(--text-dark);
            cursor: pointer;
        }
        .status-dropdown-menu a:hover, .doc-dropdown-menu a:hover { background: #f5f5f5; }
        .status-dropdown-menu a.active { background: var(--primary); color: white; }

        .btn-update-status {
            background-color: #bdbdbd;
            color: white;
            border: none;
            padding: 11px 22px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 700;
            font-family: inherit;
            cursor: not-allowed;
            transition: background-color .15s;
            align-self: flex-start;
        }
        .btn-update-status.enabled {
            background-color: var(--primary);
            cursor: pointer;
        }
        .btn-update-status.enabled:hover { background-color: var(--primary-hover); }

        .table-card { background-color: var(--surface); border: 1px solid var(--border); border-radius: 12px; overflow: hidden; }
        .table-wrapper { width: 100%; overflow-x: auto; }
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th { background-color: #f1f1f1; padding: 14px 24px; text-align: left; font-size: 13px; color: var(--text-muted); font-weight: 700; white-space: nowrap; }
        .data-table td { padding: 16px 24px; border-bottom: 1px solid var(--border); font-size: 14px; font-weight: 700; color: var(--text-dark); white-space: nowrap; }
        .data-table tr:last-child td { border-bottom: none; }

        /* Kolom checklist — animasi smooth saat muncul/hilang */
        .select-col {
            width: 0;
            padding: 16px 0 !important;
            opacity: 0;
            overflow: hidden;
            transition: width 0.25s ease, padding 0.25s ease, opacity 0.2s ease;
        }
        .select-col.visible {
            width: 44px;
            padding: 16px 12px !important;
            opacity: 1;
        }
        .select-col input[type="checkbox"] { width: 18px; height: 18px; cursor: pointer; accent-color: var(--primary); }

        /* Warna status — pakai selector lebih spesifik supaya tidak ketiban aturan .data-table td */
        .data-table td.status-dikirim { color: #0097a7; }
        .data-table td.status-dicetak { color: #fbc02d; }
        .data-table td.status-selesai { color: #2e7d32; }
        .data-table td.status-diproses { color: #e65100; }
        .data-table td.status-batal { color: #c62828; }

        .btn-detail {
            background-color: var(--primary); color: white; padding: 6px 16px; border-radius: 6px;
            font-size: 13px; font-weight: 700; border: none; cursor: pointer; font-family: inherit; display: inline-block;
        }
        .btn-detail:hover { background-color: var(--primary-hover); }

        /* ===== MODAL UPDATE STATUS ===== */
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
            max-width: 420px;
            padding: 28px;
        }
        .modal-title { font-size: 18px; font-weight: 700; margin-bottom: 6px; }
        .modal-subtitle { font-size: 14px; color: var(--text-muted); margin-bottom: 20px; }

        .status-option-list { display: flex; flex-direction: column; gap: 10px; margin-bottom: 24px; }
        .status-option {
            display: flex; align-items: center; gap: 12px;
            border: 1px solid var(--border); border-radius: 8px;
            padding: 14px 16px; cursor: pointer;
            font-size: 15px; font-weight: 700;
            transition: border-color .15s, background-color .15s;
        }
        .status-option:hover { border-color: var(--primary); }
        .status-option.selected { border-color: var(--primary); background: #fdecea; }
        .status-option input[type="radio"] { width: 18px; height: 18px; accent-color: var(--primary); }

        .modal-actions { display: flex; gap: 12px; }
        .btn-modal-cancel {
            flex: 1; background: white; border: 1px solid var(--border); color: var(--text-dark);
            padding: 12px; border-radius: 8px; font-weight: 700; font-size: 14px; cursor: pointer; font-family: inherit;
        }
        .btn-modal-cancel:hover { background: #f5f5f5; }
        .btn-modal-save {
            flex: 1; background: #bdbdbd; color: white; border: none;
            padding: 12px; border-radius: 8px; font-weight: 700; font-size: 14px; cursor: not-allowed; font-family: inherit;
        }
        .btn-modal-save.enabled { background: var(--primary); cursor: pointer; }
        .btn-modal-save.enabled:hover { background: var(--primary-hover); }

        @media (max-width: 640px) {
            .filter-bar { flex-direction: column; align-items: stretch; }
            .status-dropdown-btn, .doc-dropdown-btn { width: 100%; justify-content: space-between; }
            .btn-update-status { width: 100%; }
        }
    </style>
</head>
<body>

    @include('partials.admin-nav', ['activeMenu' => 'permintaan-buku'])

    <div class="main-wrapper">

        <header class="topbar">
            <div class="topbar-left">
                <button type="button" class="menu-toggle"><i class="fas fa-bars"></i></button>
                <span>Permintaan Buku</span>
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

            <div class="page-header">
                <h2>Permintaan Buku</h2>
                <p>Semua permintaan buku dari pelanggan.</p>
            </div>

            <div class="filter-bar">
                <div class="filter-bar-left">
                    <div class="status-dropdown" id="statusDropdown">
                        <button type="button" class="status-dropdown-btn" id="statusDropdownBtn">
                            <span id="statusDropdownLabel">Semua Status</span>
                            <i class="fas fa-chevron-down" style="font-size: 12px;"></i>
                        </button>
                        <div class="status-dropdown-menu" id="statusDropdownMenu">
                            <a data-status="semua" class="status-filter-item active">Semua Status</a>
                            <a data-status="menunggu-diproses" class="status-filter-item">Menunggu Diproses</a>
                            <a data-status="sedang-dicetak" class="status-filter-item">Sedang Dicetak</a>
                            <a data-status="sedang-dikirim" class="status-filter-item">Sedang Dikirim</a>
                            <a data-status="selesai" class="status-filter-item">Selesai</a>
                            <a data-status="dibatalkan" class="status-filter-item">Dibatalkan</a>
                        </div>
                    </div>

                    <div class="doc-dropdown" id="docDropdown">
                        <button type="button" class="doc-dropdown-btn" id="docDropdownBtn">
                            <span>Pilih Dokumen</span>
                            <i class="fas fa-chevron-down" style="font-size: 12px;"></i>
                        </button>
                        <div class="doc-dropdown-menu" id="docDropdownMenu">
                            <a id="pilihSemuaBtn">Pilih semua</a>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn-update-status" id="btnUpdateStatus" disabled>Update Status</button>
            </div>

            <div class="table-card">
                <div class="table-wrapper">
                    <table class="data-table" id="permintaanTable">
                        <thead>
                            <tr>
                                <th class="select-col" id="selectColHeader" style="padding-top:14px; padding-bottom:14px;"><input type="checkbox" id="selectAllCheckbox"></th>
                                <th>Nomor</th>
                                <th>Tanggal</th>
                                <th>Pelanggan</th>
                                <th>Jenis</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- DATA DUMMY SEMENTARA — nanti diganti data asli dari database --}}
                            <tr data-status="sedang-dikirim">
                                <td class="select-col"><input type="checkbox" class="row-checkbox" value="1"></td>
                                <td>WYG-2025-0001</td>
                                <td>10 Januari 2025</td>
                                <td>Budi Santoso</td>
                                <td>Pribadi</td>
                                <td class="status-dikirim">Sedang dikirim</td>
                                <td><a href="#" class="btn-detail">Detail</a></td>
                            </tr>
                            <tr data-status="sedang-dicetak">
                                <td class="select-col"><input type="checkbox" class="row-checkbox" value="2"></td>
                                <td>WYG-2025-0002</td>
                                <td>8 Januari 2025</td>
                                <td>Budi Santoso</td>
                                <td>Pribadi</td>
                                <td class="status-dicetak">Sedang dicetak</td>
                                <td><a href="#" class="btn-detail">Detail</a></td>
                            </tr>
                            <tr data-status="selesai">
                                <td class="select-col"><input type="checkbox" class="row-checkbox" value="3"></td>
                                <td>WYG-2025-0003</td>
                                <td>1 Desember 2024</td>
                                <td>Budi Santoso</td>
                                <td>Pribadi</td>
                                <td class="status-selesai">Selesai</td>
                                <td><a href="#" class="btn-detail">Detail</a></td>
                            </tr>
                            <tr data-status="menunggu-diproses">
                                <td class="select-col"><input type="checkbox" class="row-checkbox" value="4"></td>
                                <td>WYG-2025-0004</td>
                                <td>14 Januari 2025</td>
                                <td>Yayasan Tunas Bangsa</td>
                                <td>Lembaga</td>
                                <td class="status-diproses">Menunggu diproses</td>
                                <td><a href="#" class="btn-detail">Detail</a></td>
                            </tr>
                            <tr data-status="dibatalkan">
                                <td class="select-col"><input type="checkbox" class="row-checkbox" value="5"></td>
                                <td>WYG-2025-0005</td>
                                <td>5 Januari 2025</td>
                                <td>Budi Santoso</td>
                                <td>Pribadi</td>
                                <td class="status-batal">Dibatalkan</td>
                                <td><a href="#" class="btn-detail">Detail</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>

    <!-- MODAL UPDATE STATUS -->
    <div class="modal-overlay" id="updateStatusModal">
        <div class="modal-box">
            <div class="modal-title">Update Status Pesanan</div>
            <div class="modal-subtitle"><span id="jumlahDipilih">0</span> dokumen dipilih</div>

            <div class="status-option-list">
                <label class="status-option">
                    <input type="radio" name="statusBaru" value="Diproses">
                    Diproses
                </label>
                <label class="status-option">
                    <input type="radio" name="statusBaru" value="Dicetak">
                    Dicetak
                </label>
                <label class="status-option">
                    <input type="radio" name="statusBaru" value="Dikirim">
                    Dikirim
                </label>
                <label class="status-option">
                    <input type="radio" name="statusBaru" value="Selesai">
                    Selesai
                </label>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn-modal-cancel" id="btnModalCancel">Batal</button>
                <button type="button" class="btn-modal-save" id="btnModalSave" disabled>Simpan</button>
            </div>
        </div>
    </div>

    <script>
        (function () {
            /* ===== FILTER STATUS TABEL ===== */
            var statusBtn = document.getElementById('statusDropdownBtn');
            var statusMenu = document.getElementById('statusDropdownMenu');
            var statusLabel = document.getElementById('statusDropdownLabel');
            var statusItems = document.querySelectorAll('.status-filter-item');
            var rows = document.querySelectorAll('#permintaanTable tbody tr[data-status]');

            statusBtn.addEventListener('click', function () {
                statusMenu.classList.toggle('open');
            });

            statusItems.forEach(function (item) {
                item.addEventListener('click', function (e) {
                    e.preventDefault();
                    var status = this.dataset.status;

                    statusItems.forEach(function (i) { i.classList.remove('active'); });
                    this.classList.add('active');
                    statusLabel.textContent = this.textContent;
                    statusMenu.classList.remove('open');

                    rows.forEach(function (row) {
                        row.style.display = (status === 'semua' || row.dataset.status === status) ? '' : 'none';
                    });
                });
            });

            /* ===== TOGGLE PILIH DOKUMEN (MODE CHECKLIST) ===== */
            var docBtn = document.getElementById('docDropdownBtn');
            var docMenu = document.getElementById('docDropdownMenu');
            var pilihSemuaBtn = document.getElementById('pilihSemuaBtn');
            var selectCols = document.querySelectorAll('.select-col');
            var rowCheckboxes = document.querySelectorAll('.row-checkbox');
            var selectAllCheckbox = document.getElementById('selectAllCheckbox');
            var btnUpdateStatus = document.getElementById('btnUpdateStatus');

            var selectMode = false;

            function setSelectMode(active) {
                selectMode = active;
                docBtn.classList.toggle('active', active);
                selectCols.forEach(function (col) { col.classList.toggle('visible', active); });

                if (!active) {
                    // Reset semua ceklis saat mode dimatikan
                    rowCheckboxes.forEach(function (cb) { cb.checked = false; });
                    selectAllCheckbox.checked = false;
                    docMenu.classList.remove('open');
                    updateUpdateStatusButton();
                }
            }

            function updateUpdateStatusButton() {
                var jumlahDicentang = document.querySelectorAll('.row-checkbox:checked').length;
                btnUpdateStatus.disabled = jumlahDicentang === 0;
                btnUpdateStatus.classList.toggle('enabled', jumlahDicentang > 0);
            }

            docBtn.addEventListener('click', function () {
                if (!selectMode) {
                    // Aktifkan mode pilih dokumen + buka dropdown
                    setSelectMode(true);
                    docMenu.classList.add('open');
                } else {
                    // Matikan mode pilih dokumen (batal)
                    setSelectMode(false);
                }
            });

            pilihSemuaBtn.addEventListener('click', function (e) {
                e.preventDefault();
                var semuaSudahDicentang = document.querySelectorAll('.row-checkbox:checked').length === rowCheckboxes.length;

                rowCheckboxes.forEach(function (cb) {
                    // Hanya centang baris yang sedang terlihat (sesuai filter status aktif)
                    var row = cb.closest('tr');
                    if (row.style.display !== 'none') {
                        cb.checked = !semuaSudahDicentang;
                    }
                });

                selectAllCheckbox.checked = !semuaSudahDicentang;
                updateUpdateStatusButton();
                docMenu.classList.remove('open');
            });

            selectAllCheckbox.addEventListener('change', function () {
                rowCheckboxes.forEach(function (cb) {
                    var row = cb.closest('tr');
                    if (row.style.display !== 'none') {
                        cb.checked = selectAllCheckbox.checked;
                    }
                });
                updateUpdateStatusButton();
            });

            rowCheckboxes.forEach(function (cb) {
                cb.addEventListener('change', updateUpdateStatusButton);
            });

            /* ===== MODAL UPDATE STATUS ===== */
            var modal = document.getElementById('updateStatusModal');
            var jumlahDipilihSpan = document.getElementById('jumlahDipilih');
            var statusOptions = document.querySelectorAll('.status-option');
            var radioButtons = document.querySelectorAll('input[name="statusBaru"]');
            var btnModalCancel = document.getElementById('btnModalCancel');
            var btnModalSave = document.getElementById('btnModalSave');

            btnUpdateStatus.addEventListener('click', function () {
                if (btnUpdateStatus.disabled) return;

                var jumlah = document.querySelectorAll('.row-checkbox:checked').length;
                jumlahDipilihSpan.textContent = jumlah;

                // Reset pilihan status tiap kali modal dibuka
                radioButtons.forEach(function (r) { r.checked = false; });
                statusOptions.forEach(function (opt) { opt.classList.remove('selected'); });
                btnModalSave.disabled = true;
                btnModalSave.classList.remove('enabled');

                modal.classList.add('open');
            });

            radioButtons.forEach(function (radio) {
                radio.addEventListener('change', function () {
                    statusOptions.forEach(function (opt) { opt.classList.remove('selected'); });
                    this.closest('.status-option').classList.add('selected');

                    btnModalSave.disabled = false;
                    btnModalSave.classList.add('enabled');
                });
            });

            btnModalCancel.addEventListener('click', function () {
                modal.classList.remove('open');
            });

            btnModalSave.addEventListener('click', function () {
                if (btnModalSave.disabled) return;

                var statusTerpilih = document.querySelector('input[name="statusBaru"]:checked');
                var idTerpilih = Array.from(document.querySelectorAll('.row-checkbox:checked')).map(function (cb) { return cb.value; });

                // TODO: kirim idTerpilih dan statusTerpilih.value ke backend (belum diimplementasikan)
                console.log('Update status ke:', statusTerpilih.value, 'untuk dokumen:', idTerpilih);

                modal.classList.remove('open');
                setSelectMode(false);
            });

            // Klik di luar dropdown untuk menutupnya (tidak mematikan select mode)
            document.addEventListener('click', function (e) {
                if (!statusBtn.contains(e.target) && !statusMenu.contains(e.target)) {
                    statusMenu.classList.remove('open');
                }
                if (!docBtn.contains(e.target) && !docMenu.contains(e.target)) {
                    docMenu.classList.remove('open');
                }
            });
        })();
    </script>

</body>
</html>