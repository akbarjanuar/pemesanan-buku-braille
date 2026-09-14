<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Permintaan Pencetakan - BrailleKita</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .menu-toggle {
        display: inline-flex; align-items: center; justify-content: center;
        width: 24px; height: 24px; color: var(--text-muted, #888);
        background: none; border: none; cursor: pointer; font-size: 20px;
    }
        .topbar-title { font-size: 20px; font-weight: 700; }

        .topbar {
        height: 70px; background-color: #ffffff; border-bottom: 1px solid var(--border-color, #eaeaea);
        display: flex; align-items: center; justify-content: space-between; padding: 0 32px;
    }
        .topbar-left { display: flex; align-items: center; gap: 16px; }
        .topbar-right { display: flex; align-items: center; gap: 24px; }
        .profile-area { display: flex; align-items: center; gap: 12px; font-weight: 700; font-size: 14px; }
        .profile-icon { font-size: 24px; }

        .main-content { flex-grow: 1; display: flex; flex-direction: column; overflow-y: auto; }

        .page-body { padding: 32px; }

        .page-header h2 { font-size: 20px; font-weight: 800; margin-bottom: 4px; }
        .page-header p { font-size: 13px; color: var(--text-muted, #888); margin-bottom: 32px; max-width: 700px; }

        /* ===== LAYOUT 2 KOLOM: LIST + DETAIL PANEL ===== */
        .content-columns { display: grid; grid-template-columns: 1fr 340px; gap: 24px; align-items: start; }

        .status-group { margin-bottom: 32px; }
        .status-group-title { font-size: 15px; font-weight: 800; margin-bottom: 14px; }

        .cetak-card-list { display: flex; flex-direction: column; gap: 16px; }

        .cetak-card {
            background: #ffffff; border: 1px solid var(--border-color, #eaeaea); border-radius: 10px;
            padding: 20px 24px; position: relative; transition: border-color .15s;
        }
        .cetak-card.selected { border-color: var(--primary, #c62828); border-width: 2px; }

        .card-top-row { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 4px; }

        .status-badge-text { font-size: 11px; font-weight: 800; margin-bottom: 8px; text-align: right; }
        .status-menunggu-text { color: var(--primary, #c62828); }
        .status-diproses-text { color: #e65100; }
        .status-selesai-text { color: var(--success, #2e7d32); }
        .status-dicetak-text { color: #fbc02d; }

        .btn-detail-small {
            background-color: var(--primary, #c62828); color: white; padding: 5px 14px; border-radius: 6px;
            font-size: 12px; font-weight: 700; border: none; cursor: pointer; text-decoration: none; display: inline-block;
        }
        .btn-detail-small:hover { background-color: #b71c1c; }

        .item-id { font-size: 15px; font-weight: 800; margin-bottom: 4px; }
        .item-title { font-size: 13px; color: var(--text-muted, #888); margin-bottom: 2px; }
        .item-subtitle { font-size: 12px; color: #aaaaaa; margin-bottom: 8px; }

        .prioritas-row { font-size: 12px; color: var(--text-muted, #888); margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
        .prioritas-badge { background: #f1f1f1; color: var(--text-main, #111); font-size: 11px; font-weight: 700; padding: 2px 10px; border-radius: 20px; }
        .prioritas-badge.mendesak { background: #ffebee; color: var(--primary, #c62828); }

        .item-details { display: grid; grid-template-columns: 1fr 1fr 1fr; margin-bottom: 16px; gap: 10px; }
        .detail-group span { display: block; font-size: 11px; color: var(--text-muted, #888); margin-bottom: 4px; }
        .detail-group strong { font-size: 12px; color: var(--text-main, #111); font-weight: 800; }

        .progress-info { display: flex; justify-content: space-between; font-size: 11px; font-weight: 700; color: var(--text-muted, #888); margin-bottom: 6px; }
        .progress-track { width: 100%; height: 12px; background-color: #eeeeee; border-radius: 6px; overflow: hidden; }
        .progress-fill { height: 100%; border-radius: 6px; transition: width .3s ease; }
        .progress-fill.red { background-color: var(--primary, #c62828); }
        .progress-fill.green { background-color: var(--success, #2e7d32); }

        .empty-state-box {
            padding: 32px; text-align: center; color: var(--text-muted, #888); font-size: 14px;
            background: #ffffff; border: 1px solid var(--border-color, #eaeaea); border-radius: 10px;
        }

        /* ===== PANEL DETAIL (KANAN) ===== */
        .detail-panel {
            background: #ffffff; border: 1px solid var(--border-color, #eaeaea); border-radius: 10px;
            padding: 22px; position: sticky; top: 24px;
        }
        .detail-panel-title { font-size: 15px; font-weight: 800; margin-bottom: 18px; }

        .detail-panel-empty { color: var(--text-muted, #888); font-size: 13px; text-align: center; padding: 24px 8px; }

        .detail-book-row { display: flex; gap: 14px; margin-bottom: 16px; }
        .detail-book-cover {
            width: 48px; height: 48px; border-radius: 8px; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
        }
        .detail-book-cover .dots { display: grid; grid-template-columns: repeat(2, 5px); gap: 3px; }
        .detail-book-cover .dots span { width: 5px; height: 5px; background: rgba(255,255,255,0.6); border-radius: 50%; }
        .detail-book-info .detail-book-title { font-size: 13px; font-weight: 800; margin-bottom: 2px; }
        .detail-book-info .detail-book-sub { font-size: 12px; color: var(--text-muted, #888); }

        .detail-progress-info { display: flex; justify-content: space-between; font-size: 11px; color: var(--text-muted, #888); margin-bottom: 6px; }
        .detail-progress-track { width: 100%; height: 10px; background: #eeeeee; border-radius: 6px; overflow: hidden; margin-bottom: 18px; }
        .detail-progress-fill { height: 100%; border-radius: 6px; background: var(--primary, #c62828); transition: width .3s ease; }
        .detail-progress-fill.green { background: var(--success, #2e7d32); }

        .detail-form-label { font-size: 12px; font-weight: 800; margin-bottom: 8px; }
        .detail-update-row { display: flex; gap: 8px; margin-bottom: 18px; }
        .detail-update-row input {
            flex-grow: 1; border: 1px solid var(--border-color, #eaeaea); border-radius: 6px;
            padding: 8px 12px; font-size: 13px; font-family: inherit; outline: none;
        }
        .detail-update-row input:focus { border-color: var(--primary, #c62828); }
        .btn-update-jumlah {
            background: var(--primary, #c62828); color: white; border: none; padding: 8px 18px;
            border-radius: 6px; font-size: 13px; font-weight: 700; cursor: pointer; font-family: inherit;
        }
        .btn-update-jumlah:hover { background: #b71c1c; }
        .btn-update-jumlah:disabled { background: #bdbdbd; cursor: not-allowed; }

        .btn-mulai-proses {
            width: 100%; background: var(--primary, #c62828); color: white; border: none;
            padding: 11px; border-radius: 6px; font-size: 13px; font-weight: 800; cursor: pointer;
            margin-bottom: 10px; font-family: inherit;
        }
        .btn-mulai-proses:hover { background: #b71c1c; }

        .btn-ubah-status {
            width: 100%; background: white; color: var(--text-main, #111); border: 1px solid var(--border-color, #eaeaea);
            padding: 11px; border-radius: 6px; font-size: 13px; font-weight: 800; cursor: pointer; font-family: inherit;
        }
        .btn-ubah-status:hover { background: #f5f5f5; }

        @media (max-width: 900px) {
            .content-columns { grid-template-columns: 1fr; }
            .detail-panel { position: static; }
        }

        @media (max-width: 700px) {
            .item-details { grid-template-columns: 1fr; gap: 8px; }
            .page-body { padding: 20px 16px; }
        }

        /* ===== MODAL UBAH STATUS ===== */
        .modal-overlay {
            display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.45);
            z-index: 300; align-items: center; justify-content: center; padding: 20px;
        }
        .modal-overlay.open { display: flex; }

        .modal-box { background: #ffffff; border-radius: 12px; width: 100%; max-width: 380px; padding: 24px; }
        .modal-header-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .modal-title { font-size: 16px; font-weight: 800; }
        .modal-close-btn { background: none; border: none; font-size: 18px; color: var(--text-muted, #888); cursor: pointer; }

        .modal-form-label { font-size: 13px; font-weight: 800; margin-bottom: 8px; }

        .status-select-wrapper { position: relative; margin-bottom: 20px; }
        .status-select-btn {
            width: 100%; background: #ffffff; border: 1px solid var(--border-color, #eaeaea); border-radius: 8px;
            padding: 10px 14px; font-family: inherit; font-size: 14px; font-weight: 700;
            cursor: pointer; display: flex; align-items: center; justify-content: space-between; color: var(--text-main, #111);
        }
        .status-select-btn:hover { border-color: var(--primary, #c62828); }
        .status-select-menu {
            display: none; position: absolute; top: calc(100% + 4px); left: 0; right: 0;
            background: #ffffff; border: 1px solid var(--border-color, #eaeaea); border-radius: 8px;
            box-shadow: 0 4px 14px rgba(0,0,0,0.12); z-index: 10; overflow: hidden;
        }
        .status-select-menu.open { display: block; }
        .status-select-item {
            display: block; padding: 10px 14px; font-size: 13px; font-weight: 700;
            color: var(--text-main, #111); cursor: pointer;
        }
        .status-select-item:hover { background: #f5f5f5; }
        .status-select-item.selected { background: #1976d2; color: white; }

        .modal-actions-status { display: flex; gap: 10px; }
        .btn-modal-batal {
            flex: 1; background: white; border: 1px solid var(--border-color, #eaeaea); color: var(--text-main, #111);
            padding: 10px; border-radius: 8px; font-weight: 700; font-size: 13px; cursor: pointer; font-family: inherit;
        }
        .btn-modal-batal:hover { background: #f5f5f5; }
        .btn-modal-simpan-status {
            flex: 1; background: var(--primary, #c62828); color: white; border: none;
            padding: 10px; border-radius: 8px; font-weight: 700; font-size: 13px; cursor: pointer; font-family: inherit;
        }
        .btn-modal-simpan-status:hover { background: #b71c1c; }
        .btn-modal-simpan-status:disabled { background: #bdbdbd; cursor: not-allowed; }
    </style>
</head>
<body>

    @include('partials.admin-digital-nav')

    <!-- MAIN CONTENT -->
    <main class="main-content">
        <header class="topbar">
            <div class="topbar-left">
                <i class="fas fa-bars menu-toggle"></i>
                <span class="topbar-title">Permintaan Pencetakan</span>
            </div>
            <div class="topbar-right">
                <div class="profile-area">
                    <i class="far fa-bell"></i>
                    <span>{{ auth()->user()->nama ?? 'Admin' }}</span>
                    <i class="fas fa-user-circle profile-icon"></i>
                </div>
            </div>
        </header>

        <div class="page-body">

            <div class="page-header">
                <h2>Permintaan Pencetakan</h2>
                <p>Kelola permintaan pencetakan Buku Braille yang belum tersedia dan pantau prosesnya hingga selesai dicetak.</p>
            </div>

            @php
                $dataPencetakan = $daftarPencetakan ?? collect();
                $dikelompokkan = $dataPencetakan->groupBy('status');
            @endphp

            <div class="content-columns">

                <!-- KOLOM KIRI: LIST -->
                <div>
                    @forelse($dikelompokkan as $statusGroup => $items)
                        @php
                            $s = strtolower($statusGroup);
                            $badgeClass = 'status-menunggu-text';
                            if (str_contains($s, 'selesai')) $badgeClass = 'status-selesai-text';
                            elseif (str_contains($s, 'dicetak')) $badgeClass = 'status-dicetak-text';
                            elseif (str_contains($s, 'diproses') && !str_contains($s, 'menunggu')) $badgeClass = 'status-diproses-text';
                        @endphp

                        <div class="status-group">
                            <div class="status-group-title">{{ $statusGroup }}</div>

                            <div class="cetak-card-list">
                                @foreach($items as $cetak)
                                    @php
                                        $selesai = $cetak->buku_selesai ?? 0;
                                        $target = $cetak->target_buku ?? 1;
                                        $persen = ($target > 0) ? round(($selesai / $target) * 100) : 0;
                                        $isSelesai = $persen >= 100;
                                        $prioritas = $cetak->prioritas ?? 'Normal';
                                        $judul = $cetak->buku->judul ?? 'Judul Buku';
                                        $warnaCover = $cetak->buku->warna_cover ?? '#c62828';
                                    @endphp
                                    <div class="cetak-card" id="card-{{ $cetak->id }}">
                                        <div class="card-top-row">
                                            <div class="item-id">{{ $cetak->kode_cetak }}</div>
                                            <div>
                                                <div class="status-badge-text {{ $badgeClass }}">{{ $cetak->status }}</div>
                                                <button
                                                    type="button"
                                                    class="btn-detail-small btn-lihat-detail"
                                                    data-id="{{ $cetak->id }}"
                                                    data-kode="{{ $cetak->kode_cetak }}"
                                                    data-judul="{{ $judul }}"
                                                    data-target="{{ $target }}"
                                                    data-selesai="{{ $selesai }}"
                                                    data-persen="{{ $persen }}"
                                                    data-warna="{{ $warnaCover }}"
                                                    data-pesanan="WYG-{{ $cetak->pesanan_id }}"
                                                    data-status="{{ $cetak->status }}"
                                                >Detail</button>
                                            </div>
                                        </div>

                                        <div class="item-title">{{ $judul }} - {{ $target }} eksemplar</div>
                                        <div class="item-subtitle">Pesanan: WYG-{{ $cetak->pesanan_id }}</div>

                                        <div class="prioritas-row">
                                            Prioritas:
                                            <span class="prioritas-badge {{ strtolower($prioritas) == 'mendesak' ? 'mendesak' : '' }}">{{ $prioritas }}</span>
                                        </div>

                                        <div class="item-details">
                                            <div class="detail-group">
                                                <span>PIC</span>
                                                <strong>{{ $cetak->pic }}</strong>
                                            </div>
                                            <div class="detail-group">
                                                <span>Target</span>
                                                <strong>{{ $target }} buku</strong>
                                            </div>
                                            <div class="detail-group" style="text-align: right;">
                                                <span>Deadline</span>
                                                <strong>{{ $cetak->deadline ? \Carbon\Carbon::parse($cetak->deadline)->translatedFormat('j F Y') : '-' }}</strong>
                                            </div>
                                        </div>

                                        <div class="progress-info">
                                            <span>{{ $selesai }} dari {{ $target }} buku selesai</span>
                                            <span style="color: #111;">{{ $persen }}%</span>
                                        </div>
                                        <div class="progress-track">
                                            <div class="progress-fill {{ $isSelesai ? 'green' : 'red' }}" style="width: {{ $persen }}%;"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <div class="empty-state-box">
                            Belum ada data permintaan pencetakan untuk divisi Literasi Digital.
                        </div>
                    @endforelse
                </div>

                <!-- KOLOM KANAN: DETAIL PANEL -->
                <div class="detail-panel" id="detailPanel">
                    <div class="detail-panel-title">Detail Pengerjaan</div>

                    <div id="detailPanelEmpty" class="detail-panel-empty">
                        Klik "Detail" pada salah satu permintaan untuk melihat ringkasan di sini.
                    </div>

                    <div id="detailPanelContent" style="display:none;">
                        <div class="detail-book-row">
                            <div class="detail-book-cover" id="detailBookCover">
                                <div class="dots"><span></span><span></span><span></span><span></span></div>
                            </div>
                            <div class="detail-book-info">
                                <div class="detail-book-title" id="detailBookTitle">-</div>
                                <div class="detail-book-sub" id="detailBookEksemplar">-</div>
                                <div class="detail-book-sub" id="detailBookPesanan">-</div>
                            </div>
                        </div>

                        <div class="detail-progress-info">
                            <span id="detailProgressText">0 dari 0 buku selesai</span>
                            <span id="detailProgressPercent">0%</span>
                        </div>
                        <div class="detail-progress-track">
                            <div class="detail-progress-fill" id="detailProgressFill" style="width:0%;"></div>
                        </div>

                        <div class="detail-form-label">Perbarui Jumlah Selesai</div>
                        <div class="detail-update-row">
                            <input type="number" min="0" id="inputJumlahSelesai" value="0">
                            <button type="button" class="btn-update-jumlah" id="btnUpdateJumlah">Update</button>
                        </div>

                        <button type="button" class="btn-mulai-proses" id="btnMulaiProses">Mulai Proses</button>
                        <button type="button" class="btn-ubah-status" id="btnUbahStatus">Ubah Status</button>
                    </div>
                </div>

            </div>

        </div>
    </main>

    <!-- MODAL UBAH STATUS -->
    <div class="modal-overlay" id="ubahStatusModal">
        <div class="modal-box">
            <div class="modal-header-row">
                <div class="modal-title">Ubah Status Pengerjaan</div>
                <button type="button" class="modal-close-btn" id="btnCloseUbahStatus"><i class="fas fa-times"></i></button>
            </div>

            <div class="modal-form-label">Status Baru</div>
            <div class="status-select-wrapper" id="statusSelectDropdown">
                <button type="button" class="status-select-btn" id="statusSelectBtn">
                    <span id="statusSelectLabel">Pilih Status</span>
                    <i class="fas fa-chevron-down" style="font-size: 11px;"></i>
                </button>
                <div class="status-select-menu" id="statusSelectMenu">
                    <div class="status-select-item" data-value="Menunggu diproses">Menunggu diproses</div>
                    <div class="status-select-item" data-value="Diproses">Diproses</div>
                    <div class="status-select-item" data-value="Menunggu bahan">Menunggu bahan</div>
                    <div class="status-select-item" data-value="Menunggu pemeriksaan">Menunggu pemeriksaan</div>
                    <div class="status-select-item" data-value="Revisi">Revisi</div>
                    <div class="status-select-item" data-value="Selesai">Selesai</div>
                </div>
            </div>

            <div class="modal-actions-status">
                <button type="button" class="btn-modal-batal" id="btnBatalUbahStatus">Batal</button>
                <button type="button" class="btn-modal-simpan-status" id="btnSimpanUbahStatus" disabled>Simpan</button>
            </div>
        </div>
    </div>

    <script>
        (function () {
            var detailButtons = document.querySelectorAll('.btn-lihat-detail');
            var panelEmpty = document.getElementById('detailPanelEmpty');
            var panelContent = document.getElementById('detailPanelContent');

            var cover = document.getElementById('detailBookCover');
            var title = document.getElementById('detailBookTitle');
            var eksemplar = document.getElementById('detailBookEksemplar');
            var pesananRef = document.getElementById('detailBookPesanan');
            var progressText = document.getElementById('detailProgressText');
            var progressPercent = document.getElementById('detailProgressPercent');
            var progressFill = document.getElementById('detailProgressFill');
            var inputJumlah = document.getElementById('inputJumlahSelesai');
            var btnUpdate = document.getElementById('btnUpdateJumlah');
            var btnMulaiProses = document.getElementById('btnMulaiProses');
            var btnUbahStatus = document.getElementById('btnUbahStatus');

            var idTerpilih = null;
            var targetTerpilih = 0;

            detailButtons.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    document.querySelectorAll('.cetak-card').forEach(function (c) { c.classList.remove('selected'); });
                    document.getElementById('card-' + this.dataset.id).classList.add('selected');

                    idTerpilih = this.dataset.id;
                    targetTerpilih = parseInt(this.dataset.target, 10) || 0;
                    var selesai = parseInt(this.dataset.selesai, 10) || 0;
                    var persen = this.dataset.persen;

                    cover.style.backgroundColor = this.dataset.warna;
                    title.textContent = this.dataset.judul;
                    eksemplar.textContent = targetTerpilih + ' eksemplar';
                    pesananRef.textContent = 'Pesanan: ' + this.dataset.pesanan;

                    progressText.textContent = selesai + ' dari ' + targetTerpilih + ' buku selesai';
                    progressPercent.textContent = persen + '%';
                    progressFill.style.width = persen + '%';
                    progressFill.classList.toggle('green', persen >= 100);

                    inputJumlah.value = selesai;
                    inputJumlah.max = targetTerpilih;

                    panelEmpty.style.display = 'none';
                    panelContent.style.display = 'block';
                });
            });

            /* ===== UPDATE JUMLAH SELESAI (terhubung ke backend asli) ===== */
            btnUpdate.addEventListener('click', function () {
                if (!idTerpilih) return;

                var jumlahBaru = parseInt(inputJumlah.value, 10);
                if (isNaN(jumlahBaru) || jumlahBaru < 0) {
                    alert('Masukkan jumlah yang valid.');
                    return;
                }

                btnUpdate.disabled = true;
                btnUpdate.textContent = 'Menyimpan...';

                fetch('/admin/digital/pencetakan/update/' + idTerpilih, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ buku_selesai: jumlahBaru })
                })
                .then(function (res) { return res.json(); })
                .then(function (data) {
                    if (data.success) {
                        window.location.reload();
                    } else {
                        alert('Gagal memperbarui jumlah selesai.');
                        btnUpdate.disabled = false;
                        btnUpdate.textContent = 'Update';
                    }
                })
                .catch(function (err) {
                    console.error(err);
                    alert('Terjadi kesalahan saat menyimpan. Pastikan endpoint backend "buku_selesai" sudah sesuai.');
                    btnUpdate.disabled = false;
                    btnUpdate.textContent = 'Update';
                });
            });

            /* ===== MODAL UBAH STATUS ===== */
            var ubahStatusModal = document.getElementById('ubahStatusModal');
            var statusSelectBtn = document.getElementById('statusSelectBtn');
            var statusSelectMenu = document.getElementById('statusSelectMenu');
            var statusSelectLabel = document.getElementById('statusSelectLabel');
            var statusSelectItems = document.querySelectorAll('.status-select-item');
            var btnCloseUbahStatus = document.getElementById('btnCloseUbahStatus');
            var btnBatalUbahStatus = document.getElementById('btnBatalUbahStatus');
            var btnSimpanUbahStatus = document.getElementById('btnSimpanUbahStatus');

            var statusBaruTerpilih = null;

            statusSelectBtn.addEventListener('click', function () {
                statusSelectMenu.classList.toggle('open');
            });

            statusSelectItems.forEach(function (item) {
                item.addEventListener('click', function () {
                    statusSelectItems.forEach(function (i) { i.classList.remove('selected'); });
                    this.classList.add('selected');
                    statusSelectLabel.textContent = this.dataset.value;
                    statusBaruTerpilih = this.dataset.value;
                    statusSelectMenu.classList.remove('open');

                    btnSimpanUbahStatus.disabled = false;
                });
            });

            function tutupModalUbahStatus() {
                ubahStatusModal.classList.remove('open');
                statusSelectMenu.classList.remove('open');
            }

            btnCloseUbahStatus.addEventListener('click', tutupModalUbahStatus);
            btnBatalUbahStatus.addEventListener('click', tutupModalUbahStatus);

            btnUbahStatus.addEventListener('click', function () {
                if (!idTerpilih) return;

                // Set pilihan default sesuai status saat ini
                var statusSaatIni = document.querySelector('.btn-lihat-detail[data-id="' + idTerpilih + '"]').dataset.status;
                statusSelectItems.forEach(function (i) {
                    i.classList.toggle('selected', i.dataset.value === statusSaatIni);
                });
                statusSelectLabel.textContent = statusSaatIni;
                statusBaruTerpilih = statusSaatIni;
                btnSimpanUbahStatus.disabled = false;

                ubahStatusModal.classList.add('open');
            });

            btnSimpanUbahStatus.addEventListener('click', function () {
                if (!idTerpilih || !statusBaruTerpilih) return;

                btnSimpanUbahStatus.disabled = true;
                btnSimpanUbahStatus.textContent = 'Menyimpan...';

                fetch('/admin/digital/pencetakan/update/' + idTerpilih, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ status: statusBaruTerpilih })
                })
                .then(function (res) { return res.json(); })
                .then(function (data) {
                    if (data.success) {
                        window.location.reload();
                    } else {
                        alert('Gagal mengubah status.');
                        btnSimpanUbahStatus.disabled = false;
                        btnSimpanUbahStatus.textContent = 'Simpan';
                    }
                })
                .catch(function (err) {
                    console.error(err);
                    alert('Terjadi kesalahan. Pastikan endpoint backend menerima field "status".');
                    btnSimpanUbahStatus.disabled = false;
                    btnSimpanUbahStatus.textContent = 'Simpan';
                });
            });

            btnMulaiProses.addEventListener('click', function () {
                // TODO: sambungkan ke endpoint untuk mengubah status jadi "Diproses"
                alert('Fitur "Mulai Proses" perlu endpoint tambahan dari backend (belum diimplementasikan).');
            });
        })();
    </script>

</body>
</html>