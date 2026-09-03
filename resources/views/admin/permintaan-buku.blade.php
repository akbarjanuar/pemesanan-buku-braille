<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permintaan Buku - BrailleKita</title>
    
    {{-- Token CSRF WAJIB ditambahkan agar update AJAX ke backend diizinkan oleh Laravel --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        :root {
            --primary: #c62828;
            --primary-hover: #b71c1c;
            --surface: #ffffff;
            --text-dark: #111111;
            --text-muted: #757575;
            --border: #e0e0e0;
            --background: #f4f6f9;
        }
        
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

        /* ===== PERBAIKAN WARNA HEADER TABEL ===== */
        .table-card { background-color: var(--surface); border: 1px solid var(--border); border-radius: 12px; overflow: hidden; }
        .table-wrapper { width: 100%; overflow-x: auto; }
        .data-table { width: 100%; border-collapse: collapse; }
        
        /* Warna abu-abu sekarang dipasang di baris tabel (TR), bukan di sel (TH) agar tidak ada celah */
        .data-table thead tr { background-color: #f1f1f1; border-bottom: 1px solid var(--border); }
        .data-table th { padding: 14px 24px; text-align: left; font-size: 13px; color: var(--text-muted); font-weight: 700; white-space: nowrap; }
        .data-table td { padding: 16px 24px; border-bottom: 1px solid var(--border); font-size: 14px; font-weight: 700; color: var(--text-dark); white-space: nowrap; vertical-align: middle; }
        .data-table tr:last-child td { border-bottom: none; }
        .data-table tbody tr:hover { background-color: #fafafa; }

        /* Kolom checklist — diperbaiki agar selnya tidak tembus pandang */
        .select-col {
            width: 0;
            padding-left: 0 !important;
            padding-right: 0 !important;
            overflow: hidden;
            transition: width 0.25s ease, padding 0.25s ease;
        }
        .select-col.visible {
            width: 44px;
            padding-left: 16px !important;
            padding-right: 12px !important;
        }
        .select-col input[type="checkbox"] { 
            width: 18px; height: 18px; cursor: pointer; accent-color: var(--primary); 
            opacity: 0; pointer-events: none; transition: opacity 0.2s ease; 
        }
        .select-col.visible input[type="checkbox"] { 
            opacity: 1; pointer-events: auto; 
        }

        /* Warna status dinamis (Sudah ditambah Return) */
        .status-dikirim { color: #0097a7 !important; }
        .status-dicetak { color: #fbc02d !important; }
        .status-selesai { color: #2e7d32 !important; }
        .status-diproses { color: #e65100 !important; }
        .status-batal { color: #c62828 !important; }
        .status-return { color: #8e24aa !important; } /* Tambahan warna Return (Ungu) */
        .status-baru { color: #1976d2 !important; }

        .btn-detail {
            background-color: var(--primary); color: white; padding: 6px 16px; border-radius: 6px;
            font-size: 13px; font-weight: 700; border: none; cursor: pointer; font-family: inherit; display: inline-block; text-decoration: none;
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
                <span style="font-size: 20px; font-weight: 900; font-family: 'Georgia', serif; margin-left: 10px;">Permintaan Buku</span>
            </div>

            <div class="topbar-right">
                <i class="far fa-bell notification-bell"></i>
                <div class="user-profile" style="display: flex; align-items: center; gap: 10px; font-weight: 700;">
                    <span>{{ auth()->user()->nama ?? 'Admin Pengiriman' }}</span>
                    <i class="fas fa-user-circle" style="font-size: 20px;"></i>
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
                            <a data-status="Diproses" class="status-filter-item">Diproses</a>
                            <a data-status="Dicetak" class="status-filter-item">Dicetak</a>
                            <a data-status="Dikirim" class="status-filter-item">Dikirim</a>
                            <a data-status="Selesai" class="status-filter-item">Selesai</a>
                            <a data-status="Return" class="status-filter-item">Return</a>
                            <a data-status="Dibatalkan" class="status-filter-item">Dibatalkan</a>
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
                                <th class="select-col" id="selectColHeader"><input type="checkbox" id="selectAllCheckbox"></th>
                                <th>Nomor</th>
                                <th>Tanggal</th>
                                <th>Pelanggan</th>
                                <th>Jenis</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($daftarPesanan as $pesanan)
                                @php
                                    // Penentuan warna kelas status
                                    $statusClass = '';
                                    $s = strtolower($pesanan->status);
                                    if(str_contains($s, 'dikirim')) $statusClass = 'status-dikirim';
                                    elseif(str_contains($s, 'dicetak')) $statusClass = 'status-dicetak';
                                    elseif(str_contains($s, 'selesai')) $statusClass = 'status-selesai';
                                    elseif(str_contains($s, 'diproses') || str_contains($s, 'menunggu')) $statusClass = 'status-diproses';
                                    elseif(str_contains($s, 'return')) $statusClass = 'status-return'; // Tambahan Return
                                    elseif(str_contains($s, 'batal')) $statusClass = 'status-batal';
                                    else $statusClass = 'status-baru';
                                @endphp
                                <tr data-status="{{ $pesanan->status }}">
                                    <td class="select-col"><input type="checkbox" class="row-checkbox" value="{{ $pesanan->id }}"></td>
                                    <td>WYG-{{ date('Y', strtotime($pesanan->created_at)) }}-{{ str_pad($pesanan->id, 4, '0', STR_PAD_LEFT) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($pesanan->created_at)->translatedFormat('j F Y') }}</td>
                                    <td>{{ $pesanan->user->nama ?? 'Nama Pelanggan' }}</td>
                                    <td>{{ $pesanan->jenis_pesanan ?? 'Pribadi' }}</td>
                                    <td class="{{ $statusClass }}">{{ $pesanan->status }}</td>
                                    <td><a href="{{ route('admin.detail-pesanan', $pesanan->id) }}" class="btn-detail">Detail</a></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" style="text-align: center; color: var(--text-muted); font-weight: normal; padding: 40px;">
                                        Belum ada permintaan buku.
                                    </td>
                                </tr>
                            @endforelse
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
                <label class="status-option">
                    <input type="radio" name="statusBaru" value="Return">
                    Return
                </label>
                <label class="status-option">
                    <input type="radio" name="statusBaru" value="Dibatalkan">
                    Dibatalkan
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
                    var status = this.dataset.status.toLowerCase();

                    statusItems.forEach(function (i) { i.classList.remove('active'); });
                    this.classList.add('active');
                    statusLabel.textContent = this.textContent;
                    statusMenu.classList.remove('open');

                    rows.forEach(function (row) {
                        var rowStatus = row.dataset.status.toLowerCase();
                        // Menggunakan .includes() agar "Menunggu Diproses" cocok saat filter "Diproses" dipilih
                        if (status === 'semua' || rowStatus.includes(status)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
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
                    setSelectMode(true);
                    docMenu.classList.add('open');
                } else {
                    setSelectMode(false);
                }
            });

            pilihSemuaBtn.addEventListener('click', function (e) {
                e.preventDefault();
                var semuaSudahDicentang = document.querySelectorAll('.row-checkbox:checked').length === rowCheckboxes.length;

                rowCheckboxes.forEach(function (cb) {
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

            /* ===== PENGIRIMAN DATA KE BACKEND (AJAX Fetch) ===== */
            btnModalSave.addEventListener('click', function () {
                if (btnModalSave.disabled) return;

                var statusTerpilih = document.querySelector('input[name="statusBaru"]:checked').value;
                var idTerpilih = Array.from(document.querySelectorAll('.row-checkbox:checked')).map(function (cb) { return cb.value; });

                var originalText = btnModalSave.textContent;
                btnModalSave.textContent = "Menyimpan...";
                btnModalSave.disabled = true;

                fetch('{{ route("admin.permintaan-buku.update-status") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        ids: idTerpilih,
                        status: statusTerpilih
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload(); // Segarkan halaman saat sukses
                    } else {
                        alert('Gagal memperbarui status. Pastikan rute sudah dibuat di web.php');
                        btnModalSave.textContent = originalText;
                        btnModalSave.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan. Pastikan database/server aktif.');
                    btnModalSave.textContent = originalText;
                    btnModalSave.disabled = false;
                });
            });

            // Klik di luar dropdown untuk menutupnya
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