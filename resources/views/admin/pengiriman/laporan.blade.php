<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - BrailleKita</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: sans-serif; background: var(--background); color: var(--text-dark); }
        .menu-toggle { display: inline-flex; align-items: center; justify-content: center; width: 24px; height: 24px; color: var(--text-muted); background: none; border: none; cursor: pointer; font-size: 20px; }
        .topbar-title { font-size: 20px; font-weight: 900; font-family: 'Georgia', serif; color: var(--text-dark); margin-left: 10px; }
        .content-area { padding: 32px; flex-grow: 1; overflow-y: auto; }
        .page-header-row { display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 16px; margin-bottom: 24px; }
        .page-header h2 { font-size: 22px; font-weight: 700; margin-bottom: 4px; }
        .page-header p { color: var(--text-muted); font-size: 14px; max-width: 600px; }
        .btn-export { background: var(--primary); color: white; border: none; padding: 11px 20px; border-radius: 8px; font-size: 14px; font-weight: 700; font-family: inherit; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; white-space: nowrap; text-decoration: none; }
        .btn-export:hover { background: var(--primary-hover); }
        .ringkasan-card { background: var(--surface); border: 1px solid var(--border); border-radius: 12px; padding: 20px 24px; margin-bottom: 24px; }
        .ringkasan-title { font-size: 16px; font-weight: 700; margin-bottom: 4px; }
        .ringkasan-desc { font-size: 13px; color: var(--text-muted); margin-bottom: 18px; }
        .filter-row { display: flex; flex-wrap: wrap; align-items: center; gap: 10px; }
        .quick-filter-group { display: flex; flex-wrap: nowrap; overflow-x: auto; gap: 8px; }
        .quick-filter-btn { background: white; border: 1px solid var(--border); border-radius: 8px; padding: 9px 16px; font-size: 13px; font-weight: 700; color: var(--text-dark); cursor: pointer; font-family: inherit; white-space: nowrap; flex-shrink: 0; text-decoration: none;}
        .quick-filter-btn:hover { border-color: var(--primary); }
        .quick-filter-btn.active { background: var(--primary); border-color: var(--primary); color: white; }
        .date-range-group { display: flex; align-items: center; gap: 10px; margin-left: auto; flex-wrap: wrap; }
        .date-field { display: flex; flex-direction: column; gap: 4px; }
        .date-field label { font-size: 11px; color: var(--text-muted); font-weight: 700; }
        .date-field input { border: 1px solid var(--border); border-radius: 6px; padding: 8px 10px; font-family: inherit; font-size: 13px; outline: none; background: white; }
        .date-field input:focus { border-color: var(--primary); }
        .btn-terapkan { background: var(--primary); color: white; border: none; padding: 9px 18px; border-radius: 8px; font-size: 13px; font-weight: 700; font-family: inherit; cursor: pointer; align-self: flex-end; }
        .btn-terapkan:hover { background: var(--primary-hover); }
        .laporan-section { margin-bottom: 28px; }
        .laporan-section-title { font-size: 16px; font-weight: 700; margin-bottom: 12px; }
        .table-card { background-color: var(--surface); border: 1px solid var(--border); border-radius: 12px; overflow: hidden; }
        .table-wrapper { width: 100%; overflow-x: auto; }
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th { background-color: #f1f1f1; padding: 12px 20px; text-align: left; font-size: 12px; color: var(--text-muted); font-weight: 700; white-space: nowrap; }
        .data-table td { padding: 14px 20px; border-bottom: 1px solid var(--border); font-size: 13px; font-weight: 700; color: var(--text-dark); white-space: nowrap; }
        .data-table tr:last-child td { border-bottom: none; }
        .empty-state { padding: 20px; text-align: center; color: var(--text-muted); font-size: 14px; font-weight: normal; }
        .status-dikirim { color: #0097a7; }
        .status-dicetak { color: #fbc02d; }
        .status-selesai, .status-tersedia, .status-aktif { color: #2e7d32; }
        .status-diproses, .status-menunggu { color: #e65100; }
        .status-batal { color: #c62828; }
        @media (max-width: 700px) { .filter-row { flex-direction: column; align-items: stretch; } .date-range-group { margin-left: 0; width: 100%; } .date-field { flex: 1; } .btn-terapkan { align-self: stretch; } .btn-export { width: 100%; justify-content: center; } }
        
        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.45); z-index: 300; align-items: center; justify-content: center; padding: 20px; }
        .modal-overlay.open { display: flex; }
        .modal-box { background: var(--surface); border-radius: 12px; width: 100%; max-width: 440px; max-height: 88vh; overflow-y: auto; padding: 24px; }
        .modal-title { font-size: 18px; font-weight: 700; margin-bottom: 4px; }
        .modal-subtitle { font-size: 13px; color: var(--text-muted); margin-bottom: 18px; }
        .modal-section-label { font-size: 13px; font-weight: 700; color: var(--text-muted); margin: 18px 0 10px 0; }
        .option-radio-list { display: flex; flex-direction: column; gap: 8px; }
        .option-radio-item { display: flex; align-items: center; gap: 12px; border: 1px solid var(--border); border-radius: 8px; padding: 12px 14px; cursor: pointer; font-size: 14px; font-weight: 700; transition: border-color .15s, background-color .15s; }
        .option-radio-item:hover { border-color: var(--primary); }
        .option-radio-item.selected { border-color: var(--primary); background: #fdecea; }
        .option-radio-item input[type="radio"] { width: 17px; height: 17px; accent-color: var(--primary); flex-shrink: 0; }
        .modal-actions { display: flex; gap: 12px; margin-top: 22px; }
        .btn-modal-cancel { flex: 1; background: white; border: 1px solid var(--border); color: var(--text-dark); padding: 12px; border-radius: 8px; font-weight: 700; font-size: 14px; cursor: pointer; font-family: inherit; }
        .btn-modal-cancel:hover { background: #f5f5f5; }
        .btn-export-excel { flex: 1; background: #bdbdbd; color: white; border: none; padding: 12px; border-radius: 8px; font-weight: 700; font-size: 14px; cursor: not-allowed; font-family: inherit; }
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

            <div class="topbar-right" style="display: flex; align-items: center; gap: 24px;">
                <i class="far fa-bell notification-bell" style="font-size: 20px; cursor: pointer;"></i>

                <a href="{{ route('admin.profile') }}" style="display: flex; align-items: center; gap: 12px; text-decoration: none; color: var(--text-dark); cursor: pointer;">
                    <span style="font-weight: 700; font-size: 15px;">
                        {{ auth()->user()->nama ?? 'Admin Pengiriman' }}
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
                        <a href="{{ route('admin.laporan', ['range' => 'hari-ini']) }}" class="quick-filter-btn {{ $range == 'hari-ini' ? 'active' : '' }}">Hari Ini</a>
                        <a href="{{ route('admin.laporan', ['range' => 'minggu-ini']) }}" class="quick-filter-btn {{ $range == 'minggu-ini' ? 'active' : '' }}">Minggu Ini</a>
                        <a href="{{ route('admin.laporan', ['range' => 'bulan-ini']) }}" class="quick-filter-btn {{ $range == 'bulan-ini' ? 'active' : '' }}">Bulan Ini</a>
                        <a href="{{ route('admin.laporan', ['range' => '6-bulan']) }}" class="quick-filter-btn {{ $range == '6-bulan' ? 'active' : '' }}">6 Bulan Terakhir</a>
                    </div>

                    <form action="{{ route('admin.laporan') }}" method="GET" class="date-range-group">
                        <div class="date-field">
                            <label>Tanggal mulai</label>
                            <input type="date" name="start_date" value="{{ $startDate ?? '' }}" required>
                        </div>
                        <div class="date-field">
                            <label>Tanggal akhir</label>
                            <input type="date" name="end_date" value="{{ $endDate ?? '' }}" required>
                        </div>
                        <button type="submit" class="btn-terapkan">Terapkan</button>
                    </form>
                </div>
            </div>

            <!-- ================= DATA PESANAN ================= -->
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
                                    <th>Status Pesanan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pesanans as $p)
                                    <tr>
                                        <td>{{ $p->nomor_pesanan ?? 'ORD-'.$p->id }}</td>
                                        <td>{{ \Carbon\Carbon::parse($p->created_at)->translatedFormat('j F Y') }}</td>
                                        <td>{{ $p->nama_penerima ?? optional($p->user)->nama ?? '-' }}</td>
                                        <td>{{ $p->jenis_pesanan ?? 'Pribadi' }}</td>
                                        <td>
                                            @foreach($p->details as $d)
                                                {{ optional($d->buku)->judul }} ({{ $d->jumlah }} eks)@if(!$loop->last), @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            @php
                                                $statusClass = 'status-diproses';
                                                if(in_array($p->status, ['Selesai', 'Siap Dikirim'])) $statusClass = 'status-selesai';
                                                elseif(in_array($p->status, ['Dikirim', 'Sedang Dikirim'])) $statusClass = 'status-dikirim';
                                                elseif($p->status == 'Dibatalkan') $statusClass = 'status-batal';
                                            @endphp
                                            <span class="{{ $statusClass }}">{{ $p->status }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="empty-state">Tidak ada data pesanan pada periode ini.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ================= DATA BUKU ================= -->
            <div class="laporan-section">
                <div class="laporan-section-title">Data Buku</div>
                <div class="table-card">
                    <div class="table-wrapper">
                        <table class="data-table" id="tabelDataBuku">
                            <thead>
                                <tr>
                                    <th>Judul Buku</th>
                                    <th>Kategori</th>
                                    <th>Pengarang</th>
                                    <th>Penerbit</th>
                                    <th>Stok (Tersedia)</th>
                                    <th>Batas Pemesanan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bukus as $b)
                                    <tr>
                                        <td>{{ $b->judul }}</td>
                                        <td>{{ $b->kategori ?? '-' }}</td>
                                        <td>{{ $b->pengarang ?? '-' }}</td>
                                        <td>{{ $b->penerbit ?? '-' }}</td>
                                        <td>{{ $b->stok }} eksemplar</td>
                                        <td>{{ $b->batas_pemesanan }} eksemplar</td>
                                        <td>
                                            @if($b->stok > 0)
                                                <span class="status-tersedia">Tersedia</span>
                                            @else
                                                <span class="status-menunggu">Habis / Perlu Dicetak</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="7" class="empty-state">Belum ada data buku.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ================= DATA PENCETAKAN ================= -->
            <div class="laporan-section">
                <div class="laporan-section-title">Data Pencetakan</div>
                <div class="table-card">
                    <div class="table-wrapper">
                        <table class="data-table" id="tabelDataPencetakan">
                            <thead>
                                <tr>
                                    <th>Kode Cetak</th>
                                    <th>Tanggal</th>
                                    <th>Judul Buku</th>
                                    <th>Jumlah</th>
                                    <th>Divisi</th>
                                    <th>PIC</th>
                                    <th>Deadline</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pencetakans as $pc)
                                    <tr>
                                        <td>{{ $pc->kode_cetak }}</td>
                                        <td>{{ \Carbon\Carbon::parse($pc->created_at)->translatedFormat('j M Y') }}</td>
                                        <td>{{ optional($pc->buku)->judul ?? '-' }}</td>
                                        <td>{{ $pc->jumlah }}</td>
                                        <td>{{ $pc->divisi }}</td>
                                        <td>{{ $pc->pic }}</td>
                                        <td>{{ \Carbon\Carbon::parse($pc->deadline)->translatedFormat('j M Y') }}</td>
                                        <td>
                                            @php
                                                $sClass = 'status-diproses';
                                                if($pc->status == 'Selesai') $sClass = 'status-selesai';
                                                elseif($pc->status == 'Dibatalkan') $sClass = 'status-batal';
                                            @endphp
                                            <span class="{{ $sClass }}">{{ $pc->status }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="8" class="empty-state">Tidak ada data pencetakan pada periode ini.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ================= DATA PELANGGAN ================= -->
            <div class="laporan-section">
                <div class="laporan-section-title">Data Pelanggan</div>
                <div class="table-card">
                    <div class="table-wrapper">
                        <table class="data-table" id="tabelDataPelanggan">
                            <thead>
                                <tr>
                                    <th>Nama Pelanggan</th>
                                    <th>Email</th>
                                    <th>Nomor Telepon</th>
                                    <th>Alamat</th>
                                    <th>Tanggal Daftar</th>
                                    <th>Total Pesanan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pelanggans as $plg)
                                    <tr>
                                        <td>{{ $plg->nama }}</td>
                                        <td>{{ $plg->email }}</td>
                                        <td>{{ $plg->nomor_telepon ?? '-' }}</td>
                                        <td>{{ $plg->alamat ?? '-' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($plg->created_at)->translatedFormat('j F Y') }}</td>
                                        <td>{{ $plg->pesanan_count }} pesanan</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="empty-state">Tidak ada pendaftaran pelanggan baru pada periode ini.</td></tr>
                                @endforelse
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
                <label class="option-radio-item"><input type="radio" name="jenisData" value="pesanan"> Data Pesanan</label>
                <label class="option-radio-item"><input type="radio" name="jenisData" value="buku"> Data Buku</label>
                <label class="option-radio-item"><input type="radio" name="jenisData" value="pencetakan"> Data Pencetakan</label>
                <label class="option-radio-item"><input type="radio" name="jenisData" value="pelanggan"> Data Pelanggan</label>
                <label class="option-radio-item"><input type="radio" name="jenisData" value="semua"> Semua Data</label>
            </div>

            <div class="modal-section-label">Periode Data</div>
            <div class="option-radio-list" id="periodeList">
                <label class="option-radio-item"><input type="radio" name="periodeData" value="sesuai-filter"> Sesuai Tampilan Saat Ini</label>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn-modal-cancel" id="btnExportCancel">Batal</button>
                <button type="button" class="btn-export-excel" id="btnExportExcel" disabled>Export ke Excel</button>
            </div>
        </div>
    </div>

    <script>
        (function () {
            var modal = document.getElementById('exportModal');
            var btnOpen = document.getElementById('btnOpenExportModal');
            var btnCancel = document.getElementById('btnExportCancel');
            var btnExport = document.getElementById('btnExportExcel');

            var dataTypeItems = document.querySelectorAll('#dataTypeList .option-radio-item');
            var periodeItems = document.querySelectorAll('#periodeList .option-radio-item');
            var jenisDataRadios = document.querySelectorAll('input[name="jenisData"]');
            var periodeRadios = document.querySelectorAll('input[name="periodeData"]');

            function resetModal() {
                jenisDataRadios.forEach(function (r) { r.checked = false; });
                periodeRadios.forEach(function (r) { r.checked = false; });
                dataTypeItems.forEach(function (i) { i.classList.remove('selected'); });
                periodeItems.forEach(function (i) { i.classList.remove('selected'); });
                btnExport.disabled = true;
                btnExport.classList.remove('enabled');
            }

            btnOpen.addEventListener('click', function () { resetModal(); modal.classList.add('open'); });
            btnCancel.addEventListener('click', function () { modal.classList.remove('open'); });

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

            function ambilHtmlTabel(jenis) {
                var mapId = {
                    'pesanan': 'tabelDataPesanan',
                    'buku': 'tabelDataBuku',
                    'pencetakan': 'tabelDataPencetakan',
                    'pelanggan': 'tabelDataPelanggan',
                };

                if (jenis === 'semua') {
                    var semuaHtml = '';
                    var judulSection = {
                        'pesanan': 'Data Pesanan',
                        'buku': 'Data Buku',
                        'pencetakan': 'Data Pencetakan',
                        'pelanggan': 'Data Pelanggan',
                    };
                    Object.keys(mapId).forEach(function (key) {
                        var tabel = document.getElementById(mapId[key]);
                        if(tabel) semuaHtml += '<h3>' + judulSection[key] + '</h3>' + tabel.outerHTML + '<br><br>';
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
                var htmlTabel = ambilHtmlTabel(jenis);
                var namaFile = 'Laporan_' + jenis + '_' + new Date().toISOString().slice(0, 10);
                unduhSebagaiExcel(namaFile, htmlTabel);
                modal.classList.remove('open');
            });
        })();
    </script>
</body>
</html>