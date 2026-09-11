<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permintaan Bahan - BrailleKita</title>
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
            --green: #2e7d32;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: sans-serif; background: var(--background); color: var(--text-dark); }
        .menu-toggle { display: inline-flex; align-items: center; justify-content: center; width: 24px; height: 24px; color: var(--text-muted); background: none; border: none; cursor: pointer; font-size: 20px; }
        .topbar-title { font-size: 20px; font-weight: 900; font-family: 'Georgia', serif; color: var(--text-dark); margin-left: 10px; }
        .content-area { padding: 32px; flex-grow: 1; overflow-y: auto; }
        .page-header-row { display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 16px; margin-bottom: 24px; }
        .page-header h2 { font-size: 22px; font-weight: 700; margin-bottom: 4px; }
        .page-header p { color: var(--text-muted); font-size: 14px; max-width: 600px; }

        /* ===== LIST VIEW ===== */
        .filter-card { background: var(--surface); border: 1px solid var(--border); border-radius: 12px; padding: 20px 24px; margin-bottom: 24px; }
        .filter-card-title { font-size: 16px; font-weight: 700; margin-bottom: 4px; }
        .filter-card-desc { font-size: 13px; color: var(--text-muted); margin-bottom: 18px; }
        .status-select { border: 1px solid var(--border); border-radius: 8px; padding: 10px 16px; font-family: inherit; font-size: 13px; font-weight: 700; color: var(--text-dark); background: white; cursor: pointer; outline: none; }
        .status-select:focus { border-color: var(--primary); }

        .table-card { background-color: var(--surface); border: 1px solid var(--border); border-radius: 12px; overflow: hidden; }
        .table-wrapper { width: 100%; overflow-x: auto; }
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th { background-color: #f1f1f1; padding: 12px 20px; text-align: left; font-size: 12px; color: var(--text-muted); font-weight: 700; white-space: nowrap; }
        .data-table td { padding: 14px 20px; border-bottom: 1px solid var(--border); font-size: 13px; font-weight: 700; color: var(--text-dark); }
        .data-table td.keperluan-cell { white-space: normal; min-width: 220px; font-weight: 400; }
        .data-table tr:last-child td { border-bottom: none; }
        .empty-state { padding: 20px; text-align: center; color: var(--text-muted); font-size: 14px; font-weight: normal; }

        .status-dikirim { color: #0097a7; }
        .status-dicetak { color: #fbc02d; }
        .status-selesai, .status-tersedia, .status-aktif { color: var(--green); }
        .status-diproses, .status-menunggu { color: #e65100; }
        .status-batal { color: var(--primary); }

        .btn-detail { background: var(--primary); color: white; border: none; padding: 7px 18px; border-radius: 6px; font-size: 12px; font-weight: 700; font-family: inherit; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-detail:hover { background: var(--primary-hover); }

        /* ===== DETAIL VIEW ===== */
        #viewDetail { display: none; max-width: 760px; }

        .btn-kembali { display: inline-flex; align-items: center; gap: 6px; color: var(--primary); font-size: 13px; font-weight: 700; text-decoration: none; margin-bottom: 20px; background: none; border: none; cursor: pointer; font-family: inherit; padding: 0; }
        .btn-kembali:hover { text-decoration: underline; }

        .section-block { margin-bottom: 24px; }
        .section-title-row { display: flex; align-items: center; gap: 10px; margin-bottom: 12px; }
        .step-number-badge { width: 22px; height: 22px; border-radius: 50%; background: var(--primary); color: white; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; flex-shrink: 0; }
        .section-title { font-size: 15px; font-weight: 700; color: var(--text-dark); }

        .info-card { background: var(--surface); border: 1px solid var(--border); border-radius: 12px; padding: 20px 24px; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px 24px; }
        .info-item { display: flex; gap: 8px; font-size: 13px; }
        .info-label { color: var(--text-muted); min-width: 110px; }
        .info-value { font-weight: 700; color: var(--text-dark); }
        .info-item.keperluan-item { grid-column: 1 / -1; }

        .timeline { padding: 6px 4px; }
        .timeline-item { display: flex; gap: 14px; position: relative; padding-bottom: 22px; }
        .timeline-item:last-child { padding-bottom: 0; }
        .timeline-item:not(:last-child)::after { content: ''; position: absolute; left: 13px; top: 28px; bottom: -22px; width: 2px; background: var(--border); }
        .timeline-icon { width: 27px; height: 27px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; z-index: 1; font-size: 12px; font-weight: 700; }
        .timeline-icon.done { background: var(--green); color: white; }
        .timeline-icon.current { background: var(--primary); color: white; }
        .timeline-icon.pending { background: #e0e0e0; color: #9e9e9e; }
        .timeline-body { padding-top: 2px; }
        .timeline-title { font-size: 13.5px; font-weight: 700; }
        .timeline-title.done { color: var(--green); }
        .timeline-title.current { color: var(--primary); }
        .timeline-title.pending { color: #9e9e9e; }
        .timeline-desc { font-size: 12px; color: var(--text-muted); margin-top: 2px; }
        .timeline-desc.pending { color: #bdbdbd; }

        .info-box { border: 1px solid #90caf9; background: #e3f2fd; color: #1565c0; padding: 10px 14px; border-radius: 8px; font-size: 12.5px; display: flex; align-items: center; gap: 8px; margin-top: 18px; }

        .tindakan-label { font-size: 13px; font-weight: 700; color: var(--text-muted); margin: 20px 0 10px 0; }

        .btn-primary-action { background: var(--primary); color: white; border: none; padding: 11px 20px; border-radius: 8px; font-size: 13px; font-weight: 700; font-family: inherit; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; }
        .btn-primary-action:hover { background: var(--primary-hover); }

        .kendala-textarea { width: 100%; min-height: 90px; border: 1px solid var(--border); border-radius: 10px; padding: 14px; font-family: inherit; font-size: 13px; resize: vertical; outline: none; margin-bottom: 16px; }
        .kendala-textarea:focus { border-color: var(--primary); }

        @media (max-width: 700px) { .filter-card { padding: 16px; } }
        @media (max-width: 600px) { .info-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>

    @include('partials.admin-nav', ['activeMenu' => 'permintaan-bahan'])

    <div class="main-wrapper">
        <header class="topbar">
            <div class="topbar-left">
                <button type="button" class="menu-toggle"><i class="fas fa-bars"></i></button>
                <span class="topbar-title" id="topbarTitle">Permintaan Bahan</span>
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

            {{-- ====================== VIEW: LIST ====================== --}}
            <div id="viewList">

                <div class="page-header-row">
                    <div class="page-header">
                        <h2>Permintaan Bahan</h2>
                    </div>
                </div>

                <div class="filter-card">
                    <div class="filter-card-title">Permohonan Bahan</div>
                    <div class="filter-card-desc">Kelola dan pantau pengajuan kebutuhan bahan dari Literasi Manual dan Literasi Digital hingga proses permintaan selesai.</div>

                    <select class="status-select" id="filterStatus">
                        <option value="semua">Semua Status</option>
                        <option value="menunggu">Menunggu Tanda Tangan</option>
                        <option value="diproses">Menunggu Diproses</option>
                        <option value="selesai">Selesai</option>
                    </select>
                </div>

                <div class="table-card">
                    <div class="table-wrapper">
                        <table class="data-table" id="tabelPermintaanBahan">
                            <thead>
                                <tr>
                                    <th>Id Permintaan</th>
                                    <th>Tanggal</th>
                                    <th>Divisi</th>
                                    <th>Nama Bahan</th>
                                    <th>Keperluan</th>
                                    <th>Status Surat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    // DATA DUMMY — nanti diganti data asli dari controller ($permintaanBahan)
                                    $permintaanBahan = [
                                        [
                                            'id' => 'BHN-2025-0001',
                                            'tanggal' => '11 Januari 2025',
                                            'divisi' => 'Literasi Manual',
                                            'bahan' => 'Kertas Braille',
                                            'jumlah' => '50000',
                                            'satuan' => 'Lembar',
                                            'keperluan' => 'Pencetakan buku untuk pesanan bulan Januari 2025',
                                            'status' => 'Menunggu Tanda Tangan',
                                            'statusClass' => 'status-menunggu',
                                            'pengaju' => 'Dewi Kusuma',
                                            'prioritas' => 'Normal',
                                        ],
                                        [
                                            'id' => 'BHN-2025-0002',
                                            'tanggal' => '13 Januari 2025',
                                            'divisi' => 'Literasi Digital',
                                            'bahan' => 'Binding Cover',
                                            'jumlah' => '2000',
                                            'satuan' => 'Lembar',
                                            'keperluan' => 'Cover untuk buku yang selesai cetak',
                                            'status' => 'Menunggu Diproses',
                                            'statusClass' => 'status-dicetak',
                                            'pengaju' => 'Rian Saputra',
                                            'prioritas' => 'Tinggi',
                                        ],
                                        [
                                            'id' => 'BHN-2025-0022',
                                            'tanggal' => '5 Desember 2024',
                                            'divisi' => 'Literasi Manual',
                                            'bahan' => 'Lakban Bening',
                                            'jumlah' => '50',
                                            'satuan' => 'Roll',
                                            'keperluan' => 'Pengemasan buku',
                                            'status' => 'Selesai',
                                            'statusClass' => 'status-selesai',
                                            'pengaju' => 'Dewi Kusuma',
                                            'prioritas' => 'Normal',
                                        ],
                                    ];
                                @endphp

                                @forelse ($permintaanBahan as $item)
                                    <tr>
                                        <td>{{ $item['id'] }}</td>
                                        <td>{{ $item['tanggal'] }}</td>
                                        <td>{{ $item['divisi'] }}</td>
                                        <td>{{ $item['bahan'] }}</td>
                                        <td class="keperluan-cell">{{ $item['keperluan'] }}</td>
                                        <td><span class="{{ $item['statusClass'] }}">{{ $item['status'] }}</span></td>
                                        <td>
                                            <button
                                                type="button"
                                                class="btn-detail btn-lihat-detail"
                                                data-id="{{ $item['id'] }}"
                                                data-tanggal="{{ $item['tanggal'] }}"
                                                data-divisi="{{ $item['divisi'] }}"
                                                data-bahan="{{ $item['bahan'] }}"
                                                data-jumlah="{{ $item['jumlah'] }}"
                                                data-satuan="{{ $item['satuan'] }}"
                                                data-keperluan="{{ $item['keperluan'] }}"
                                                data-pengaju="{{ $item['pengaju'] }}"
                                                data-prioritas="{{ $item['prioritas'] }}"
                                            >Detail</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="7" class="empty-state">Belum ada permintaan bahan.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            {{-- ====================== VIEW: DETAIL ====================== --}}
            <div id="viewDetail">

                <button type="button" class="btn-kembali" id="btnKembali">
                    <i class="fas fa-arrow-left"></i> Kembali
                </button>

                {{-- 1. Informasi Permintaan --}}
                <div class="section-block">
                    <div class="section-title-row">
                        <span class="step-number-badge">1</span>
                        <span class="section-title">Informasi Permintaan</span>
                    </div>
                    <div class="info-card">
                        <div class="info-grid">
                            <div class="info-item"><span class="info-label">Id Permintaan</span><span class="info-value">: <span id="dId"></span></span></div>
                            <div class="info-item"><span class="info-label">Nama Pengaju</span><span class="info-value">: <span id="dPengaju"></span></span></div>
                            <div class="info-item"><span class="info-label">Divisi</span><span class="info-value">: <span id="dDivisi"></span></span></div>
                            <div class="info-item"><span class="info-label">Prioritas</span><span class="info-value">: <span id="dPrioritas"></span></span></div>
                            <div class="info-item"><span class="info-label">Tanggal Pengajuan</span><span class="info-value">: <span id="dTanggal"></span></span></div>
                        </div>
                    </div>
                </div>

                {{-- 2. Detail Bahan --}}
                <div class="section-block">
                    <div class="section-title-row">
                        <span class="step-number-badge">2</span>
                        <span class="section-title">Detail Bahan</span>
                    </div>
                    <div class="info-card">
                        <div class="info-grid">
                            <div class="info-item"><span class="info-label">Nama Bahan</span><span class="info-value">: <span id="dBahan"></span></span></div>
                            <div class="info-item"><span class="info-label">Jumlah</span><span class="info-value">: <span id="dJumlah"></span></span></div>
                            <div class="info-item"><span class="info-label">Satuan</span><span class="info-value">: <span id="dSatuan"></span></span></div>
                            <div class="info-item keperluan-item"><span class="info-label">Keperluan</span><span class="info-value">: <span id="dKeperluan"></span></span></div>
                        </div>
                    </div>
                </div>

                {{-- 3. Proses Permintaan --}}
                <div class="section-block">
                    <div class="section-title-row">
                        <span class="step-number-badge">3</span>
                        <span class="section-title">Proses Permintaan</span>
                    </div>
                    <div class="info-card">
                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-icon done"><i class="fas fa-check"></i></div>
                                <div class="timeline-body">
                                    <div class="timeline-title done">Menunggu diproses</div>
                                    <div class="timeline-desc">Permintaan telah diajukan oleh divisi terkait.</div>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-icon done"><i class="fas fa-check"></i></div>
                                <div class="timeline-body">
                                    <div class="timeline-title done">Diproses</div>
                                    <div class="timeline-desc">Admin Pengiriman mulai menangani permintaan.</div>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-icon done"><i class="fas fa-check"></i></div>
                                <div class="timeline-body">
                                    <div class="timeline-title done">Surat Dibuat</div>
                                    <div class="timeline-desc">Surat permohonan kebutuhan bahan telah dibuat.</div>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-icon current">4</div>
                                <div class="timeline-body">
                                    <div class="timeline-title current">Menunggu Tanda Tangan</div>
                                    <div class="timeline-desc">Surat menunggu proses tanda tangan.</div>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-icon pending">5</div>
                                <div class="timeline-body">
                                    <div class="timeline-title pending">Sudah Ditandatangani</div>
                                    <div class="timeline-desc pending">Surat telah selesai ditandatangani.</div>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-icon pending">6</div>
                                <div class="timeline-body">
                                    <div class="timeline-title pending">Selesai</div>
                                    <div class="timeline-desc pending">Permintaan bahan telah selesai diproses.</div>
                                </div>
                            </div>
                        </div>

                        <div class="info-box">
                            <i class="fas fa-info-circle"></i> Surat sedang menunggu tanda tangan
                        </div>

                        <div class="tindakan-label">Tindakan Selanjutnya</div>
                        <button type="button" class="btn-primary-action">
                            <i class="fas fa-chevron-right"></i> Tandai Sudah Ditandatangani
                        </button>
                    </div>
                </div>

                {{-- 4. Tindakan Tambahan --}}
                <div class="section-block">
                    <div class="section-title-row">
                        <span class="step-number-badge">4</span>
                        <span class="section-title">Tindakan Tambahan</span>
                    </div>
                    <div class="info-card">
                        <textarea class="kendala-textarea" placeholder="Jelaskan kendala yang dialami terkait permintaan ini (opsional)..."></textarea>
                        <button type="button" class="btn-primary-action">
                            <i class="fas fa-triangle-exclamation"></i> Laporkan Kendala
                        </button>
                    </div>
                </div>

            </div>

        </main>
    </div>

    <script>
        (function () {
            var viewList = document.getElementById('viewList');
            var viewDetail = document.getElementById('viewDetail');
            var topbarTitle = document.getElementById('topbarTitle');
            var btnKembali = document.getElementById('btnKembali');
            var tombolDetail = document.querySelectorAll('.btn-lihat-detail');

            function tampilkanDetail(data) {
                document.getElementById('dId').textContent = data.id;
                document.getElementById('dPengaju').textContent = data.pengaju;
                document.getElementById('dDivisi').textContent = data.divisi;
                document.getElementById('dPrioritas').textContent = data.prioritas;
                document.getElementById('dTanggal').textContent = data.tanggal;
                document.getElementById('dBahan').textContent = data.bahan;
                document.getElementById('dJumlah').textContent = data.jumlah;
                document.getElementById('dSatuan').textContent = data.satuan;
                document.getElementById('dKeperluan').textContent = data.keperluan;

                viewList.style.display = 'none';
                viewDetail.style.display = 'block';
                topbarTitle.textContent = 'Detail Permintaan Bahan';
                window.scrollTo(0, 0);
            }

            function kembaliKeList() {
                viewDetail.style.display = 'none';
                viewList.style.display = 'block';
                topbarTitle.textContent = 'Permintaan Bahan';
                window.scrollTo(0, 0);
            }

            tombolDetail.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    tampilkanDetail({
                        id: btn.dataset.id,
                        tanggal: btn.dataset.tanggal,
                        divisi: btn.dataset.divisi,
                        bahan: btn.dataset.bahan,
                        jumlah: btn.dataset.jumlah,
                        satuan: btn.dataset.satuan,
                        keperluan: btn.dataset.keperluan,
                        pengaju: btn.dataset.pengaju,
                        prioritas: btn.dataset.prioritas,
                    });
                });
            });

            btnKembali.addEventListener('click', kembaliKeList);
        })();
    </script>

</body>
</html>