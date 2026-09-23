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
            --light-green: #e8f5e9;
            --orange: #e65100;
            --light-orange: #fff3e0;
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

        /* TOPBAR & LAYOUT DASAR */
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
        .topbar-left { display: flex; align-items: center; gap: 14px; }
        .menu-toggle {
            width: 38px; height: 38px; display: inline-flex; align-items: center; justify-content: center;
            border: none; background: transparent; color: var(--text-muted); cursor: pointer; font-size: 19px; border-radius: 6px;
        }
        .menu-toggle:hover { background: #f5f5f5; }
        .topbar-title { font-size: 20px; font-weight: 700; color: var(--text-dark); }
        .topbar-right { display: flex; align-items: center; gap: 24px; }
        .notification-button {
            width: 38px; height: 38px; display: flex; align-items: center; justify-content: center;
            color: var(--text-dark); font-size: 19px; cursor: pointer; border-radius: 6px; position: relative;
        }
        .notification-button:hover { background: #f5f5f5; }
        .notification-dot { position: absolute; top: 7px; right: 7px; width: 7px; height: 7px; background: var(--primary); border-radius: 50%; }
        
        .content-area { flex: 1; overflow-y: auto; padding: 32px; background: #ffffff; }

        .success-message {
            background: var(--green); color: white; padding: 12px 20px; border-radius: 8px;
            margin-bottom: 24px; font-size: 14px; font-weight: 700;
        }

        /* VIEW LIST */
        #viewList { width: 100%; }
        .page-header-row { display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 16px; margin-bottom: 24px; }
        .page-header h2 { font-size: 22px; font-weight: 700; margin-bottom: 4px; }
        
        .filter-card { background: var(--surface); border: 1px solid var(--border); border-radius: 12px; padding: 20px 24px; margin-bottom: 24px; }
        .filter-card-title { font-size: 16px; font-weight: 700; margin-bottom: 4px; }
        .filter-card-desc { font-size: 13px; color: var(--text-muted); margin-bottom: 18px; line-height: 1.5; }
        .status-select {
            border: 1px solid var(--border); border-radius: 8px; padding: 10px 16px; font-family: inherit;
            font-size: 13px; font-weight: 700; color: var(--text-dark); background: white; cursor: pointer; outline: none; min-width: 170px;
        }

        .request-list { display: flex; flex-direction: column; gap: 12px; }
        .request-card { background: #ffffff; border: 1px solid var(--border); border-radius: 8px; padding: 16px 20px; transition: 0.2s ease; }
        .request-card:hover { border-color: #cfcfcf; box-shadow: 0 2px 8px rgba(0,0,0,0.04); }
        .request-card-top { display: flex; justify-content: space-between; align-items: flex-start; gap: 20px; margin-bottom: 12px; }
        .request-id { font-size: 13px; font-weight: 700; color: #333333; margin-bottom: 3px; }
        .request-material { font-size: 14px; font-weight: 700; color: #111111; }
        .request-quantity { font-size: 12px; color: var(--text-muted); margin-top: 3px; }
        
        .request-status { font-size: 11px; font-weight: 700; text-align: right; white-space: nowrap; }
        .status-selesai, .status-tersedia, .status-aktif { color: var(--green); }
        .status-diproses, .status-menunggu { color: var(--orange); }
        .status-batal { color: var(--primary); }
        
        .request-card-middle { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; padding-bottom: 12px; }
        .request-info-label { font-size: 11px; color: var(--text-muted); margin-bottom: 3px; }
        .request-info-value { font-size: 12px; font-weight: 600; color: #333333; line-height: 1.5; }
        
        .request-card-bottom { display: flex; justify-content: flex-start; align-items: center; padding-top: 4px; }
        .btn-detail { background: var(--primary); color: white; border: none; padding: 6px 16px; border-radius: 4px; font-size: 11px; font-weight: 700; cursor: pointer; }
        .empty-state { background: #ffffff; border: 1px solid var(--border); border-radius: 8px; padding: 40px 20px; text-align: center; color: var(--text-muted); font-size: 14px; }

        /* VIEW DETAIL */
        #viewDetail { display: none; max-width: 900px; }
        .btn-kembali { display: inline-flex; align-items: center; gap: 6px; color: var(--primary); font-size: 13px; font-weight: 700; text-decoration: none; margin-bottom: 20px; background: none; border: none; cursor: pointer; padding: 0; }
        
        .detail-header { margin-bottom: 24px; }
        .detail-header h2 { font-size: 18px; font-weight: 700; margin-bottom: 4px; }
        .detail-header p { font-size: 12px; color: var(--text-muted); }

        .section-block { margin-bottom: 20px; }
        .section-title-row { display: flex; align-items: center; gap: 12px; margin-bottom: 12px; }
        .step-number-badge { width: 26px; height: 26px; border-radius: 50%; background: var(--primary); color: white; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 700; flex-shrink: 0; }
        .section-title { font-size: 15px; font-weight: 700; color: var(--text-dark); }
        
        .info-card { background: var(--surface); border: 1px solid var(--border); border-radius: 12px; padding: 24px; }
        .info-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px 24px; }
        .info-item { display: flex; font-size: 13px; line-height: 1.5; }
        .info-label { color: var(--text-muted); min-width: 140px; }
        .info-separator { margin-right: 8px; color: var(--text-muted); }
        .info-value { font-weight: 700; color: var(--text-dark); flex: 1; }
        
        /* CARD DOKUMEN */
        .doc-card { background: #f5f5f5; border-radius: 8px; padding: 16px; display: flex; align-items: center; justify-content: space-between; margin-top: 8px; }
        .doc-left { display: flex; align-items: center; gap: 16px; }
        .doc-icon { background: var(--primary); color: white; width: 40px; height: 40px; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 20px; }
        .doc-info h4 { font-size: 13px; font-weight: 700; margin-bottom: 4px; color: var(--text-dark); }
        .doc-info p { font-size: 11px; color: var(--text-muted); }
        .doc-actions { font-size: 12px; font-weight: 600; }
        .doc-actions a { color: var(--primary); text-decoration: none; margin-left: 12px; }
        .doc-actions a:hover { text-decoration: underline; }

        /* BUTTONS & FORMS */
        .btn { padding: 10px 20px; border-radius: 6px; font-size: 13px; font-weight: 700; cursor: pointer; border: 1px solid transparent; display: inline-flex; align-items: center; justify-content: center; gap: 8px; }
        .btn-primary { background: var(--primary); color: white; }
        .btn-outline { background: white; border-color: var(--border); color: var(--text-dark); }
        .btn-outline:hover { background: #f9f9f9; }
        .btn-success { background: var(--green); color: white; }
        .action-buttons { display: flex; gap: 12px; margin-top: 20px; }
        
        .alert-box { padding: 12px 16px; border-radius: 6px; font-size: 12px; margin-bottom: 16px; border: 1px solid; }
        .alert-success { background: var(--light-green); border-color: #a5d6a7; color: var(--green); }
        .alert-warning { background: var(--light-orange); border-color: #ffcc80; color: var(--orange); }
        
        .form-group { margin-bottom: 16px; }
        .form-label { display: block; font-size: 12px; font-weight: 700; margin-bottom: 6px; color: var(--text-dark); }
        .form-control { width: 100%; border: 1px solid var(--border); border-radius: 6px; padding: 10px 14px; font-size: 13px; font-family: inherit; }
        textarea.form-control { min-height: 80px; resize: vertical; }

        /* OPSI TANDA TANGAN */
        .signature-options { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-top: 16px; }
        .opt-card { border: 1px solid var(--border); border-radius: 8px; padding: 24px; text-align: center; cursor: pointer; transition: 0.2s; }
        .opt-card:hover { border-color: var(--primary); background: #fdfafa; }
        .opt-card i { font-size: 24px; color: var(--primary); margin-bottom: 12px; }
        .opt-card h4 { font-size: 14px; font-weight: 700; margin-bottom: 6px; }
        .opt-card p { font-size: 11px; color: var(--text-muted); }

        .upload-area { border: 1px dashed var(--border); border-radius: 8px; padding: 24px; text-align: center; color: var(--text-muted); font-size: 13px; background: #fafafa; margin-bottom: 16px; }
        .upload-area i { font-size: 20px; margin-bottom: 8px; display: block; color: #bdbdbd; }

        /* TIMELINE (RIWAYAT) */
        .timeline-container { padding: 10px 20px; }
        .timeline-item { display: flex; gap: 16px; position: relative; padding-bottom: 24px; }
        .timeline-item:last-child { padding-bottom: 0; }
        .timeline-item:not(:last-child)::after {
            content: ''; position: absolute; left: 7px; top: 22px; bottom: -8px; width: 2px; background: var(--border);
        }
        .timeline-dot {
            width: 16px; height: 16px; border-radius: 50%; background: #e0e0e0; flex-shrink: 0; margin-top: 2px; z-index: 1; border: 3px solid white; box-shadow: 0 0 0 1px #e0e0e0;
        }
        .timeline-dot.active { background: var(--text-muted); box-shadow: 0 0 0 1px var(--text-muted); }
        .timeline-content h4 { font-size: 13px; font-weight: 700; color: var(--text-dark); margin-bottom: 2px; }
        .timeline-content p { font-size: 11px; color: var(--text-muted); }
        .timeline-content.inactive h4 { color: #9e9e9e; font-weight: 500; }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .info-grid, .signature-options { grid-template-columns: 1fr; }
            .doc-card { flex-direction: column; align-items: flex-start; gap: 12px; }
            .doc-actions { width: 100%; display: flex; justify-content: space-between; margin-left: 0; }
            .doc-actions a { margin-left: 0; margin-right: 12px; }
        }
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
            <div class="topbar-right">
                <div class="notification-button"><i class="far fa-bell"></i><span class="notification-dot"></span></div>
                <a href="{{ route('admin.profile') }}" style="display:flex;align-items:center;gap:12px;text-decoration:none;color:var(--text-dark);">
                    <span style="font-weight:700;font-size:15px;">{{ auth()->user()->nama ?? 'Admin Pengiriman' }}</span>
                    <div style="width:36px;height:36px;border-radius:50%;overflow:hidden;background:#111;display:flex;align-items:center;justify-content:center;color:white;">
                        @if(auth()->user()->foto_profil)
                            <img src="{{ auth()->user()->foto_profil }}" alt="Foto Profile" style="width:100%;height:100%;object-fit:cover;">
                        @else
                            <i class="fas fa-user" style="font-size:16px;"></i>
                        @endif
                    </div>
                </a>
            </div>
        </header>

        <main class="content-area">
            @if(session('success'))
                <div class="success-message">
                    <i class="fas fa-check-circle" style="margin-right:6px;"></i> {{ session('success') }}
                </div>
            @endif

            <!-- ================= VIEW LIST ================= -->
            <div id="viewList">
                <div class="page-header-row">
                    <div class="page-header"><h2>Permintaan Bahan</h2></div>
                </div>

                <div class="filter-card">
                    <div class="filter-card-title">Permohonan Bahan</div>
                    <div class="filter-card-desc">Kelola dan pantau pengajuan kebutuhan bahan dari Literasi Manual dan Literasi Digital hingga proses permintaan selesai.</div>
                    <select class="status-select" id="filterStatus" onchange="window.location.href='{{ route('admin.permintaan-bahan') }}?status=' + this.value">
                        <option value="semua" {{ ($statusFilter ?? 'semua') == 'semua' ? 'selected' : '' }}>Semua Status</option>
                        <option value="menunggu" {{ ($statusFilter ?? '') == 'menunggu' ? 'selected' : '' }}>Menunggu Pemeriksaan</option>
                        <option value="diperbaiki" {{ ($statusFilter ?? '') == 'diperbaiki' ? 'selected' : '' }}>Perlu diperbaiki</option>
                        <option value="disetujui" {{ ($statusFilter ?? '') == 'disetujui' ? 'selected' : '' }}>Disetujui / Menunggu Tanda Tangan</option>
                        <option value="selesai" {{ ($statusFilter ?? '') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>

                <div class="request-list">
                    @forelse ($permintaanBahan as $item)
                        @php
                            $statusClass = 'status-diproses';
                            if ($item->status == 'Selesai') $statusClass = 'status-selesai';
                            elseif (in_array($item->status, ['Menunggu Tanda Tangan', 'Menunggu diproses', 'Menunggu Pemeriksaan'])) $statusClass = 'status-menunggu';
                            elseif (stripos($item->status, 'Kendala') !== false || stripos($item->status, 'Perbaikan') !== false) $statusClass = 'status-batal';
                        @endphp
                        <div class="request-card">
                            <div class="request-card-top">
                                <div>
                                    <div class="request-id">{{ $item->id_permintaan ?? 'BHN-'.$item->id }}</div>
                                    <div class="request-material">{{ $item->nama_bahan }}</div>
                                    <div class="request-quantity">{{ $item->jumlah ?? '-' }} {{ $item->satuan ?? '' }}</div>
                                </div>
                                <div class="request-status {{ $statusClass }}">{{ $item->status }}</div>
                            </div>
                            <div class="request-card-middle">
                                <div>
                                    <div class="request-info-label">Tanggal Pengajuan</div>
                                    <div class="request-info-value">{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('j F Y') }}</div>
                                </div>
                                <div>
                                    <div class="request-info-label">Divisi</div>
                                    <div class="request-info-value">{{ $item->divisi }}</div>
                                </div>
                                <div>
                                    <div class="request-info-label">Keperluan</div>
                                    <div class="request-info-value">{{ $item->keperluan }}</div>
                                </div>
                                <div>
                                    <div class="request-info-label">Pengaju / PIC</div>
                                    <div class="request-info-value">{{ $item->pengaju ?? $item->pic ?? 'Anonim' }}</div>
                                </div>
                            </div>
                            <div class="request-card-bottom">
                                <button type="button" class="btn-detail btn-lihat-detail"
                                    data-id="{{ $item->id }}"
                                    data-id_tampil="{{ $item->id_permintaan ?? 'BHN-'.$item->id }}"
                                    data-tanggal="{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('j F Y') }}"
                                    data-tanggal_jam="{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('j F Y, H.i') }}"
                                    data-divisi="{{ $item->divisi }}"
                                    data-bahan="{{ $item->nama_bahan }}"
                                    data-jumlah="{{ $item->jumlah }}"
                                    data-satuan="{{ $item->satuan }}"
                                    data-keperluan="{{ $item->keperluan }}"
                                    data-pic="{{ $item->pic ?? $item->pengaju ?? '-' }}"
                                    data-status="{{ $item->status }}"
                                    data-id_pencetakan="{{ $item->pencetakan->kode_cetak ?? '-' }}"
                                    data-nama_buku="{{ $item->pencetakan->buku->judul ?? '-' }}"
                                    data-jumlah_buku="{{ $item->pencetakan->jumlah ?? '-' }}"
                                    data-file_surat="{{ $item->file_surat ?? $item->dokumen_surat }}">
                                    Detail
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">Belum ada data permintaan bahan.</div>
                    @endforelse
                </div>
            </div>

            <!-- ================= VIEW DETAIL ================= -->
            <div id="viewDetail">
                <button type="button" class="btn-kembali" id="btnKembali">
                    <i class="fas fa-arrow-left"></i> Kembali
                </button>

                <div class="detail-header">
                    <h2>Detail Permintaan Bahan</h2>
                    <p><span id="headId"></span> &bull; <span id="headTanggal"></span></p>
                </div>

                <!-- 1. Informasi Permintaan -->
                <div class="section-block">
                    <div class="section-title-row">
                        <span class="step-number-badge">1</span>
                        <span class="section-title">Informasi Permintaan</span>
                    </div>
                    <div class="info-card">
                        <div class="info-grid">
                            <div class="info-item"><span class="info-label">Id Permintaan</span><span class="info-separator">:</span><span class="info-value" id="dId"></span></div>
                            <div class="info-item"><span class="info-label">Id Pencetakan</span><span class="info-separator">:</span><span class="info-value" id="dIdPencetakan"></span></div>
                            <div class="info-item"><span class="info-label">Nama Buku</span><span class="info-separator">:</span><span class="info-value" id="dNamaBuku"></span></div>
                            <div class="info-item"><span class="info-label">Jumlah Buku</span><span class="info-separator">:</span><span class="info-value" id="dJumlahBuku"></span></div>
                            <div class="info-item"><span class="info-label">Nama Bahan</span><span class="info-separator">:</span><span class="info-value" id="dBahan"></span></div>
                            <div class="info-item"><span class="info-label">Jumlah Bahan</span><span class="info-separator">:</span><span class="info-value" id="dJumlah"></span></div>
                            <div class="info-item"><span class="info-label">Satuan</span><span class="info-separator">:</span><span class="info-value" id="dSatuan"></span></div>
                            <div class="info-item"><span class="info-label">Tujuan Penggunaan</span><span class="info-separator">:</span><span class="info-value" id="dKeperluan"></span></div>
                            <div class="info-item"><span class="info-label">PIC</span><span class="info-separator">:</span><span class="info-value" id="dPic"></span></div>
                            <div class="info-item"><span class="info-label">Tanggal Pengajuan</span><span class="info-separator">:</span><span class="info-value" id="dTanggal"></span></div>
                        </div>
                    </div>
                </div>

                <!-- 2. Dokumen Surat Pengajuan -->
                <div class="section-block">
                    <div class="section-title-row">
                        <span class="step-number-badge">2</span>
                        <span class="section-title">Dokumen Surat Pengajuan</span>
                    </div>
                    <div class="info-card" style="padding: 16px 24px;">
                        <div class="doc-card">
                            <div class="doc-left">
                                <div class="doc-icon"><i class="fas fa-file-pdf"></i></div>
                                <div class="doc-info">
                                    <h4 id="dFileName">Surat Pengajuan Kertas.pdf</h4>
                                    <p>Diunggah: <span id="dFileDate"></span></p>
                                </div>
                            </div>
                            <div class="doc-actions">
                                <a href="#" id="btnLihatDokumen" target="_blank">Lihat Dokumen</a> | 
                                <a href="#" id="btnUnduhDokumen" download>Unduh Dokumen</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. Tindak Lanjut (Dinamis via JS) -->
                <div class="section-block" id="sectionTindak">
                    <div class="section-title-row">
                        <span class="step-number-badge">3</span>
                        <span class="section-title" id="tindakTitle">Tindak - Pemeriksaan Surat</span>
                    </div>
                    <div class="info-card" id="tindakContent">
                        <!-- Konten akan di-inject oleh JavaScript sesuai status -->
                    </div>
                </div>

                <!-- 4. Riwayat Permintaan -->
                <div class="section-block">
                    <div class="section-title-row">
                        <span class="step-number-badge">4</span>
                        <span class="section-title">Riwayat Permintaan</span>
                    </div>
                    <div class="info-card" style="padding: 20px;">
                        <div class="timeline-container" id="timelineContainer">
                            <!-- Timeline di-inject oleh JavaScript -->
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <!-- TEMPLATES UNTUK SECTION 3 (Hidden) -->
    <template id="tpl-pemeriksaan">
        <p style="font-size: 13px; font-weight: 600; margin-bottom: 16px;">Apakah surat pengajuan sudah sesuai?</p>
        <div class="action-buttons" style="margin-top: 0;">
            <button class="btn btn-primary" onclick="changeState('Setujui Surat')">Setujui Surat</button>
            <button class="btn btn-outline" onclick="changeState('Ada Perbaikan')">Ada Perbaikan</button>
        </div>
    </template>

    <template id="tpl-konfirmasi-setuju">
        <div class="alert-box alert-success">
            <strong>Konfirmasi Persetujuan</strong><br>
            Surat telah diperiksa dan dinyatakan sesuai. Permintaan dapat diteruskan ke proses tanda tangan.
        </div>
        <div class="action-buttons">
            <button type="button" class="btn btn-outline" onclick="renderState('Menunggu Pemeriksaan')">Batal</button>
            <button type="button" class="btn btn-primary" id="btnProsesSetuju">Setujui Surat</button>
        </div>
    </template>

    <template id="tpl-form-perbaikan">
        <div class="alert-box alert-warning">
            Berikan catatan yang jelas agar admin literasi digital/manual dapat memperbaiki surat dengan benar.
        </div>
        <form action="{{ route('admin.permintaan-bahan.update-status') }}" method="POST">
            @csrf
            <input type="hidden" name="id" class="updateIdForm">
            <input type="hidden" name="status" value="Perlu Diperbaiki">
            
            <div class="form-group">
                <label class="form-label">Alasan Perbaikan</label>
                <input type="text" class="form-control" name="alasan" placeholder="Contoh: Format surat tidak sesuai" required>
            </div>
            <div class="form-group">
                <label class="form-label">Catatan Perbaikan *</label>
                <textarea class="form-control" name="kendala" placeholder="Masukkan alasan atau bagian surat yang perlu diperbaiki..." required></textarea>
            </div>
            <div class="action-buttons" style="justify-content: flex-end;">
                <button type="button" class="btn btn-outline" onclick="renderState('Menunggu Pemeriksaan')">Batal</button>
                <button type="submit" class="btn btn-primary">Kirim untuk perbaikan</button>
            </div>
        </form>
    </template>

    <template id="tpl-pilih-ttd">
        <div class="alert-box alert-success">
            Surat pengajuan telah diperiksa dan dinyatakan sesuai. Silakan lanjutkan ke proses tanda tangan.
        </div>
        <div class="signature-options">
            <div class="opt-card" onclick="changeState('Upload TTD Digital')">
                <i class="fas fa-file-signature"></i>
                <h4>Tanda tangan digital</h4>
                <p>Upload surat yang sudah ditandatangani secara digital (PDF/DOC/DOCX)</p>
            </div>
            <div class="opt-card" onclick="changeState('Konfirmasi TTD Langsung')">
                <i class="fas fa-pen-nib"></i>
                <h4>Tanda tangan langsung</h4>
                <p>Jadwalkan waktu dan tempat untuk tanda tangan secara langsung</p>
            </div>
        </div>
    </template>

    <template id="tpl-upload-ttd">
        <div class="alert-box alert-success" style="background: white;">
            Upload surat yang telah diperiksa dan ditandatangani secara digital
        </div>
        <form action="{{ route('admin.permintaan-bahan.upload-ttd') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" class="updateIdForm">
            
            <label class="form-label">Upload surat bertanda tangan *</label>
            <div class="upload-area">
                <i class="fas fa-file-upload"></i>
                Pilih file surat bertanda tangan (PDF/DOC/DOCX/JPG/PNG)
                <input type="file" name="surat_ttd" style="width:100%; margin-top: 10px;" required>
            </div>
            <div class="action-buttons">
                <button type="button" class="btn btn-outline" onclick="renderState('Menunggu Tanda Tangan')">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </template>

    <template id="tpl-konfirmasi-ttd-langsung">
        <div class="alert-box alert-success" style="background: white;">
            Tanda tangan dilakukan secara langsung di ruang pengiriman
        </div>
        <form action="{{ route('admin.permintaan-bahan.update-status') }}" method="POST">
            @csrf
            <input type="hidden" name="id" class="updateIdForm">
            <input type="hidden" name="status" value="Selesai">
            
            <p style="font-size: 13px; font-weight: 700; margin-bottom: 12px;">Konfirmasi pelaksanaan tanda tangan</p>
            <div class="action-buttons" style="margin-top: 0;">
                <button type="button" class="btn btn-outline" onclick="renderState('Menunggu Tanda Tangan')">Batal</button>
                <button type="submit" class="btn btn-primary">Tanda tangan telah dilakukan</button>
            </div>
        </form>
    </template>

    <template id="tpl-selesai">
        <div style="display: flex; gap: 40px; margin-bottom: 16px; font-size: 13px;">
            <div><span style="color: var(--text-muted); font-weight: 600; display:inline-block; width: 100px;">Metode</span> : Tanda tangan digital</div>
            <div><span style="color: var(--text-muted); font-weight: 600; display:inline-block; width: 100px;">Tanggal Upload</span> : <span id="tglUpload"></span></div>
        </div>
        <div style="font-size: 13px; margin-bottom: 8px;"><span style="color: var(--text-muted); font-weight: 600; display:inline-block; width: 100px;">Diunggah oleh</span> : <span id="pengunggahSelesai"></span></div>
        
        <div class="doc-card" style="margin-top: 20px;">
            <div class="doc-left">
                <div class="doc-icon"><i class="fas fa-file-pdf"></i></div>
                <div class="doc-info">
                    <h4>Surat Pengajuan Kertas Braille.pdf</h4>
                    <p>Dokumen bertanda tangan., <span id="tglSelesai"></span></p>
                </div>
            </div>
            <div class="doc-actions">
                <a href="#" id="linkLihatDokumen" target="_blank">Lihat Dokumen</a> | 
                <a href="#" id="linkUnduhDokumen" download>Unduh Dokumen</a>
            </div>
        </div>
        <div style="text-align: right; margin-top: 16px;">
            <button class="btn btn-primary">Tandai Permintaan Selesai</button>
        </div>
    </template>

    <!-- ================= JAVASCRIPT ================= -->
    <script>
        let currentItemData = {};

        function renderState(state) {
            const tindakContent = document.getElementById('tindakContent');
            const tindakTitle = document.getElementById('tindakTitle');
            let templateId = '';

            switch(state) {
                case 'Menunggu Pemeriksaan':
                case 'Menunggu diproses':
                    tindakTitle.innerText = "Tindak - Pemeriksaan Surat";
                    templateId = 'tpl-pemeriksaan';
                    break;
                case 'Setujui Surat':
                    tindakTitle.innerText = "Tindak - Pemeriksaan Surat";
                    templateId = 'tpl-konfirmasi-setuju';
                    break;
                case 'Ada Perbaikan':
                    tindakTitle.innerText = "Tindak - Pemeriksaan Surat";
                    templateId = 'tpl-form-perbaikan';
                    break;
                case 'Menunggu Tanda Tangan':
                case 'Disetujui':
                    tindakTitle.innerText = "Tindak - Proses Tanda Tangan";
                    templateId = 'tpl-pilih-ttd';
                    break;
                case 'Upload TTD Digital':
                    tindakTitle.innerText = "Tindak - Proses Tanda Tangan";
                    templateId = 'tpl-upload-ttd';
                    break;
                case 'Konfirmasi TTD Langsung':
                    tindakTitle.innerText = "Tindak - Proses Tanda Tangan";
                    templateId = 'tpl-konfirmasi-ttd-langsung';
                    break;
                case 'Selesai':
                    tindakTitle.innerText = "Tindak - Proses Tanda Tangan";
                    templateId = 'tpl-selesai';
                    break;
                default:
                    tindakTitle.innerText = "Tindak Lanjut";
                    tindakContent.innerHTML = `<p style="font-size:13px; color:#757575;">Tidak ada tindakan yang diperlukan untuk status saat ini (${state}).</p>`;
                    return;
            }

            if(templateId) {
                const template = document.getElementById(templateId);
                tindakContent.innerHTML = template.innerHTML;
                
                document.querySelectorAll('.updateIdForm').forEach(input => {
                    input.value = currentItemData.id;
                });

                // Handler AJAX agar saat klik Setujui Surat, halaman tidak reload dan langsung ke state berikutnya
                const btnProsesSetuju = document.getElementById('btnProsesSetuju');
                if(btnProsesSetuju) {
                    btnProsesSetuju.addEventListener('click', function() {
                        const formData = new FormData();
                        formData.append('_token', '{{ csrf_token() }}');
                        formData.append('id', currentItemData.id);
                        formData.append('status', 'Menunggu Tanda Tangan');

                        fetch("{{ route('admin.permintaan-bahan.update-status') }}", {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if(data.success) {
                                currentItemData.status = 'Menunggu Tanda Tangan';
                                renderState('Menunggu Tanda Tangan');
                                renderTimeline('Menunggu Tanda Tangan', currentItemData.tanggal_jam);
                            } else {
                                alert('Gagal memperbarui status.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Terjadi kesalahan jaringan.');
                        });
                    });
                }

                if(state === 'Selesai') {
                    document.getElementById('tglUpload').innerText = currentItemData.tanggal;
                    document.getElementById('tglSelesai').innerText = currentItemData.tanggal_jam;
                    document.getElementById('pengunggahSelesai').innerText = currentItemData.pic;
                    
                    const linkLihat = document.getElementById('linkLihatDokumen');
                    const linkUnduh = document.getElementById('linkUnduhDokumen');
                    
                    if(currentItemData.file_surat && currentItemData.file_surat !== 'null' && currentItemData.file_surat.trim() !== '') {
                        if(linkLihat) {
                            linkLihat.href = currentItemData.file_surat;
                            linkLihat.onclick = null;
                        }
                        if(linkUnduh) {
                            linkUnduh.href = currentItemData.file_surat;
                            linkUnduh.onclick = null;
                        }
                    } else {
                        if(linkLihat) {
                            linkLihat.href = 'javascript:void(0);';
                            linkLihat.onclick = function() { alert('Dokumen TTD belum tersedia.'); return false; };
                        }
                        if(linkUnduh) {
                            linkUnduh.href = 'javascript:void(0);';
                            linkUnduh.onclick = function() { alert('Dokumen TTD belum tersedia.'); return false; };
                        }
                    }
                }
            }
        }

        function changeState(newState) {
            renderState(newState);
        }

        function renderTimeline(status, tglJam) {
            const container = document.getElementById('timelineContainer');
            container.innerHTML = '';
            
            const stages = [
                { title: 'Permintaan Bahan diajukan', time: tglJam },
                { title: 'Surat Pengajuan diunggah', time: tglJam },
                { title: 'Surat sedang diperiksa', time: status === 'Menunggu Pemeriksaan' || status === 'Menunggu diproses' ? tglJam : (status === 'Selesai' || status === 'Menunggu Tanda Tangan' ? tglJam : '') }
            ];

            if(status.includes('Perbaikan') || status.includes('Kendala')) {
                stages.push({ title: 'Surat perlu diperbaiki', time: tglJam });
            } else if (status === 'Menunggu Tanda Tangan' || status === 'Disetujui') {
                stages.push({ title: 'Surat disetujui', time: tglJam });
            } else if (status === 'Selesai') {
                stages.push({ title: 'Surat disetujui', time: tglJam });
                stages.push({ title: 'Metode tanda tangan dipilih: Tanda Tangan Digital.', time: tglJam });
                stages.push({ title: 'Surat yang telah ditandatangani di-upload.', time: tglJam });
            }

            stages.forEach((stage, index) => {
                const isActive = stage.time !== '';
                container.innerHTML += `
                    <div class="timeline-item">
                        <div class="timeline-dot ${isActive ? 'active' : ''}"></div>
                        <div class="timeline-content ${!isActive ? 'inactive' : ''}">
                            <h4>${stage.title}</h4>
                            <p>${stage.time}</p>
                        </div>
                    </div>
                `;
            });
        }

        function tampilkanDetail(data) {
            currentItemData = data;

            document.getElementById('headId').textContent = data.id_tampil;
            document.getElementById('headTanggal').textContent = data.tanggal;

            document.getElementById('dId').textContent = data.id_tampil;
            document.getElementById('dIdPencetakan').textContent = data.id_pencetakan;
            document.getElementById('dNamaBuku').textContent = data.nama_buku;
            document.getElementById('dJumlahBuku').textContent = data.jumlah_buku;
            document.getElementById('dBahan').textContent = data.bahan;
            document.getElementById('dJumlah').textContent = data.jumlah;
            document.getElementById('dSatuan').textContent = data.satuan;
            document.getElementById('dKeperluan').textContent = data.keperluan;
            document.getElementById('dPic').textContent = data.pic;
            document.getElementById('dTanggal').textContent = data.tanggal;

            document.getElementById('dFileName').textContent = data.tanggal + " Surat Pengajuan " + data.bahan + ".pdf";
            document.getElementById('dFileDate').textContent = data.tanggal_jam;
            
            const btnLihat = document.getElementById('btnLihatDokumen');
            const btnUnduh = document.getElementById('btnUnduhDokumen');

            if(data.file_surat && data.file_surat !== 'null' && data.file_surat.trim() !== '') {
                btnLihat.href = data.file_surat;
                btnUnduh.href = data.file_surat;
                
                btnLihat.onclick = null;
                btnUnduh.onclick = null;
                
                btnLihat.style.pointerEvents = 'auto';
                btnLihat.style.color = 'var(--primary)';
                btnUnduh.style.pointerEvents = 'auto';
                btnUnduh.style.color = 'var(--primary)';
            } else {
                btnLihat.href = 'javascript:void(0);';
                btnUnduh.href = 'javascript:void(0);';
                
                const alertMsg = function() { alert('Dokumen belum tersedia dari database.'); return false; };
                btnLihat.onclick = alertMsg;
                btnUnduh.onclick = alertMsg;

                btnLihat.style.color = 'var(--text-muted)';
                btnUnduh.style.color = 'var(--text-muted)';
            }

            renderState(data.status);
            renderTimeline(data.status, data.tanggal_jam);

            document.getElementById('viewList').style.display = 'none';
            document.getElementById('viewDetail').style.display = 'block';
            document.getElementById('topbarTitle').textContent = 'Detail Permintaan Bahan';
            window.scrollTo(0, 0);
        }

        document.getElementById('btnKembali').addEventListener('click', function() {
            document.getElementById('viewDetail').style.display = 'none';
            document.getElementById('viewList').style.display = 'block';
            document.getElementById('topbarTitle').textContent = 'Permintaan Bahan';
            window.scrollTo(0, 0);
        });

        document.querySelectorAll('.btn-lihat-detail').forEach(btn => {
            btn.addEventListener('click', function() {
                tampilkanDetail(this.dataset);
            });
        });
    </script>
</body>
</html>