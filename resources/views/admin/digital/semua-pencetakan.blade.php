<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Permintaan Pencetakan - BrailleKita</title>

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
            --success: #2e7d32;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: sans-serif; background: var(--background); color: var(--text-dark); display: flex; height: 100vh; overflow: hidden; }

        .main-wrapper {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }

        /* ===== TOPBAR ===== */
        .topbar {
            background-color: var(--surface);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
            height: 70px;
            min-height: 70px;
            width: 100%;
        }

        .topbar-left { display: flex; align-items: center; gap: 12px; }
        .menu-toggle { 
            display: inline-flex; align-items: center; justify-content: center; 
            width: 24px; height: 24px; color: var(--text-muted); 
            background: none; border: none; cursor: pointer; font-size: 20px; 
        }
        .topbar-title { font-size: 20px; font-weight: 900; font-family: 'Georgia', serif; color: var(--text-dark); }
        
        .topbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .notification-button {
            position: relative;
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #111111;
            font-size: 19px;
            cursor: pointer;
            border-radius: 6px;
        }
        .notification-button:hover { background: #f5f5f5; }
        .notification-dot {
            position: absolute;
            top: 7px;
            right: 7px;
            width: 7px;
            height: 7px;
            background: var(--primary);
            border-radius: 50%;
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #111111;
            font-size: 14px;
            font-weight: 700;
            white-space: nowrap;
        }
        .topbar-user:hover { color: var(--primary); }
        
        /* Disamakan ukuran foto profil menjadi 36px */
        .topbar-user img, .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
        }
        .user-avatar {
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--primary);
            color: white;
            font-weight: 700;
        }

        .page-body { padding: 32px; }
        .page-header h2 { font-size: 22px; font-weight: 900; margin-bottom: 4px; }
        .page-header p { font-size: 14px; color: var(--text-muted); margin-bottom: 32px; max-width: 700px; }

        /* ===== LAYOUT 2 KOLOM ===== */
        .content-columns { display: grid; grid-template-columns: 1fr 340px; gap: 24px; align-items: start; }

        .status-group { margin-bottom: 32px; }
        .status-group-title { font-size: 18px; font-weight: 900; margin-bottom: 16px; color: var(--text-dark); }

        /* ===== KOTAK LIST BERGABUNG (SEPERTI TABEL) ===== */
        .cetak-card-wrapper {
            background: #ffffff; 
            border: 1px solid var(--border); 
            border-radius: 12px; 
            display: flex; 
            flex-direction: column;
        }

        .cetak-card {
            padding: 24px; 
            position: relative; 
            border: 2px solid transparent; 
            border-bottom: 1px solid var(--border);
            transition: all .15s;
        }
        
        .cetak-card:last-child { border-bottom: 2px solid transparent; }

        .cetak-card.selected { 
            border-color: var(--primary); 
            border-radius: 12px; 
            background-color: #ffffff;
            z-index: 2;
        }

        .card-top-row { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px; }

        .card-top-right {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 8px;
        }

        .status-badge-text { font-size: 12px; font-weight: 800; text-align: right; }
        .status-menunggu-text { color: var(--primary); }
        .status-diproses-text { color: #e65100; }
        .status-selesai-text { color: var(--success); }
        .status-revisi-text { color: var(--primary); }

        .btn-detail-small {
            background-color: var(--primary); color: white; padding: 6px 16px; border-radius: 6px;
            font-size: 12px; font-weight: 700; border: none; cursor: pointer; display: inline-block;
        }
        .btn-detail-small:hover { background-color: #b71c1c; }

        .item-id { font-size: 16px; font-weight: 900; margin-bottom: 6px; color: var(--text-dark); }
        .item-title { font-size: 14px; color: var(--text-muted); margin-bottom: 4px; }
        .item-subtitle { font-size: 13px; color: #aaaaaa; margin-bottom: 12px; }

        .prioritas-row { font-size: 12px; color: var(--text-muted); margin-bottom: 20px; display: flex; align-items: center; gap: 8px; }
        .prioritas-badge { background: #f1f1f1; color: var(--text-dark); font-size: 11px; font-weight: 800; padding: 4px 12px; border-radius: 20px; }
        .prioritas-badge.mendesak { background: #ffebee; color: var(--primary); }

        .item-details { display: grid; grid-template-columns: 1fr 1fr 1fr; margin-bottom: 16px; gap: 10px; }
        .detail-group span { display: block; font-size: 11px; color: var(--text-muted); margin-bottom: 4px; }
        .detail-group strong { font-size: 13px; color: var(--text-dark); font-weight: 800; }

        .progress-info { display: flex; justify-content: space-between; font-size: 11px; font-weight: 800; color: var(--text-muted); margin-bottom: 8px; }
        .progress-track { width: 100%; height: 14px; background-color: #eeeeee; border-radius: 8px; overflow: hidden; }
        .progress-fill { height: 100%; border-radius: 8px; transition: width .3s ease; }
        .progress-fill.red { background-color: var(--primary); }
        .progress-fill.green { background-color: var(--success); }

        .empty-state-box {
            padding: 32px; text-align: center; color: var(--text-muted); font-size: 14px;
            background: #ffffff; border: 1px solid var(--border); border-radius: 12px;
        }

        /* ===== PANEL DETAIL (KANAN) ===== */
        .detail-panel {
            background: #ffffff; border: 1px solid var(--border); border-radius: 12px;
            padding: 24px; position: sticky; top: 24px;
        }
        .detail-panel-title { font-size: 16px; font-weight: 900; margin-bottom: 20px; color: var(--text-dark); }

        .detail-panel-empty { color: var(--text-muted); font-size: 13px; text-align: center; padding: 30px 8px; }

        .detail-book-row { display: flex; gap: 14px; margin-bottom: 20px; }
        .detail-book-cover {
            width: 48px; height: 48px; border-radius: 8px; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
        }
        .detail-book-cover .dots { display: grid; grid-template-columns: repeat(2, 5px); gap: 3px; }
        .detail-book-cover .dots span { width: 5px; height: 5px; background: rgba(255,255,255,0.6); border-radius: 50%; }
        .detail-book-info .detail-book-title { font-size: 14px; font-weight: 800; margin-bottom: 4px; color: var(--text-dark); }
        .detail-book-info .detail-book-sub { font-size: 12px; color: var(--text-muted); margin-bottom: 2px;}

        .detail-progress-info { display: flex; justify-content: space-between; font-size: 11px; color: var(--text-muted); margin-bottom: 8px; font-weight: 700; }
        .detail-progress-track { width: 100%; height: 12px; background: #eeeeee; border-radius: 6px; overflow: hidden; margin-bottom: 24px; }
        .detail-progress-fill { height: 100%; border-radius: 6px; background: var(--primary); transition: width .3s ease; }
        .detail-progress-fill.green { background: var(--success); }

        .detail-form-label { font-size: 13px; font-weight: 800; margin-bottom: 10px; color: var(--text-dark); }
        
        .detail-update-row { display: flex; gap: 10px; margin-bottom: 24px; }
        .detail-update-row input {
            flex-grow: 1; border: 1px solid var(--border); border-radius: 6px;
            padding: 10px 14px; font-size: 14px; font-family: inherit; outline: none;
        }
        .detail-update-row input:focus { border-color: var(--primary); }
        .detail-update-row input:disabled { background: #f9f9f9; color: #a1a1a1; cursor: not-allowed; }

        .btn-update-jumlah {
            background: var(--primary); color: white; border: none; padding: 10px 20px;
            border-radius: 6px; font-size: 13px; font-weight: 800; cursor: pointer; font-family: inherit;
        }
        .btn-update-jumlah:hover:not(:disabled) { background: #b71c1c; }
        .btn-update-jumlah:disabled { background: #bdbdbd; cursor: not-allowed; }

        .btn-mulai-proses {
            width: 100%; background: var(--primary); color: white; border: none;
            padding: 12px; border-radius: 8px; font-size: 14px; font-weight: 800; cursor: pointer;
            margin-bottom: 12px; font-family: inherit; transition: .2s;
        }
        .btn-mulai-proses:hover:not(:disabled) { background: #b71c1c; }
        .btn-mulai-proses:disabled { background: #bdbdbd; cursor: not-allowed; }

        .btn-ubah-status {
            width: 100%; background: white; color: var(--text-dark); border: 1px solid var(--border);
            padding: 12px; border-radius: 8px; font-size: 14px; font-weight: 800; cursor: pointer; font-family: inherit; transition: .2s;
        }
        .btn-ubah-status:hover:not(:disabled) { background: #f5f5f5; }
        .btn-ubah-status:disabled { background: #ffffff; color: #bdbdbd; border-color: #eaeaea; cursor: not-allowed; }

        @media (max-width: 900px) {
            .content-columns { grid-template-columns: 1fr; }
            .detail-panel { position: static; }
        }

        /* ===== MODAL UBAH STATUS ===== */
        .modal-overlay {
            display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.45);
            z-index: 300; align-items: center; justify-content: center; padding: 20px;
        }
        .modal-overlay.open { display: flex; }

        .modal-box { background: #ffffff; border-radius: 12px; width: 100%; max-width: 380px; padding: 24px; }
        .modal-header-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .modal-title { font-size: 16px; font-weight: 900; }
        .modal-close-btn { background: none; border: none; font-size: 18px; color: var(--text-muted); cursor: pointer; }

        .modal-form-label { font-size: 13px; font-weight: 800; margin-bottom: 8px; }

        .status-select-wrapper { position: relative; margin-bottom: 24px; }
        .status-select-btn {
            width: 100%; background: #ffffff; border: 1px solid var(--border); border-radius: 8px;
            padding: 12px 14px; font-family: inherit; font-size: 14px; font-weight: 700;
            cursor: pointer; display: flex; align-items: center; justify-content: space-between; color: var(--text-dark);
        }
        .status-select-btn:hover { border-color: var(--primary); }
        .status-select-menu {
            display: none; position: absolute; top: calc(100% + 4px); left: 0; right: 0;
            background: #ffffff; border: 1px solid var(--border); border-radius: 8px;
            box-shadow: 0 4px 14px rgba(0,0,0,0.12); z-index: 10; overflow: hidden;
        }
        .status-select-menu.open { display: block; }
        .status-select-item {
            display: block; padding: 12px 14px; font-size: 13px; font-weight: 700;
            color: var(--text-dark); cursor: pointer;
        }
        .status-select-item:hover { background: #f5f5f5; }
        .status-select-item.selected { background: #1976d2; color: white; }

        .modal-actions-status { display: flex; gap: 10px; }
        .btn-modal-batal {
            flex: 1; background: white; border: 1px solid var(--border); color: var(--text-dark);
            padding: 12px; border-radius: 8px; font-weight: 800; font-size: 13px; cursor: pointer; font-family: inherit;
        }
        .btn-modal-batal:hover { background: #f5f5f5; }
        .btn-modal-simpan-status {
            flex: 1; background: var(--primary); color: white; border: none;
            padding: 12px; border-radius: 8px; font-weight: 800; font-size: 13px; cursor: pointer; font-family: inherit;
        }
        .btn-modal-simpan-status:hover { background: #b71c1c; }
    </style>
</head>
<body>

    @include('partials.admin-digital-nav', ['activeMenu' => $activeMenu ?? 'pencetakan'])

    <!-- MAIN CONTENT -->
    <div class="main-wrapper">
        <header class="topbar">
            <div class="topbar-left">
                <button type="button" class="menu-toggle"><i class="fas fa-bars"></i></button>
                <span class="topbar-title">Permintaan Pencetakan</span>
            </div>
            
            <div class="topbar-right">
                <!-- Ikon Notifikasi dengan Titik Merah -->
                <div class="notification-button">
                    <i class="far fa-bell"></i>
                    <span class="notification-dot"></span>
                </div>

                <!-- Profil Pengguna -->
                <a href="{{ route('admin.profile') }}" class="topbar-user">
                    <span style="font-weight: 700; font-size: 15px;">
                        {{ auth()->user()->nama ?? 'Admin Digital' }}
                    </span>
                    
                    <div class="user-avatar">
                        @if(auth()->user()->foto_profil)
                            <img src="{{ auth()->user()->foto_profil }}" alt="Foto Profile">
                        @else
                            <i class="fas fa-user" style="font-size: 16px;"></i>
                        @endif
                    </div>
                </a>
            </div>
        </header>

        <div class="page-body">
            <div class="page-header">
                <h2>Permintaan Pencetakan</h2>
                <p>Kelola permintaan pencetakan Buku Braille yang belum tersedia dan pantau prosesnya hingga selesai dicetak.</p>
            </div>

            @php
                $dataPencetakan = $daftarPencetakan ?? collect();
                
                $menungguDiproses = $dataPencetakan->filter(function($item) {
                    return strtolower($item->status) === 'menunggu diproses';
                });

                $sudahDiproses = $dataPencetakan->filter(function($item) {
                    return strtolower($item->status) !== 'menunggu diproses';
                });
            @endphp

            <div class="content-columns">

                <!-- KOLOM KIRI: LIST -->
                <div>
                    <!-- KELOMPOK 1: MENUNGGU DIPROSES -->
                    @if($menungguDiproses->count() > 0)
                        <div class="status-group">
                            <div class="status-group-title">Menunggu Diproses</div>
                            <div class="cetak-card-wrapper">
                                @foreach($menungguDiproses as $cetak)
                                    @php
                                        $selesai = $cetak->buku_selesai ?? 0;
                                        $target = $cetak->target_buku ?? 1;
                                        $persen = ($target > 0) ? round(($selesai / $target) * 100) : 0;
                                        $isSelesai = $persen >= 100;
                                        $prioritas = $cetak->prioritas ?? 'Normal';
                                        $judul = $cetak->buku->judul ?? 'Judul Buku';
                                        $warnaCover = $cetak->buku->warna_cover ?? '#c62828';
                                        
                                        $s = strtolower($cetak->status);
                                        $badgeClass = 'status-menunggu-text';
                                        if (str_contains($s, 'selesai')) $badgeClass = 'status-selesai-text';
                                        elseif (str_contains($s, 'dicetak')) $badgeClass = 'status-dicetak-text';
                                        elseif (str_contains($s, 'revisi')) $badgeClass = 'status-revisi-text';
                                        elseif (str_contains($s, 'diproses') && !str_contains($s, 'menunggu')) $badgeClass = 'status-diproses-text';
                                    @endphp

                                    <div class="cetak-card" id="card-{{ $cetak->id }}">
                                        <div class="card-top-row">
                                            <div class="item-id">{{ $cetak->kode_cetak }}</div>
                                            <div class="card-top-right">
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
                    @endif

                    <!-- KELOMPOK 2: DIPROSES -->
                    @if($sudahDiproses->count() > 0)
                        <div class="status-group">
                            <div class="status-group-title">Diproses</div>
                            <div class="cetak-card-wrapper">
                                @foreach($sudahDiproses as $cetak)
                                    @php
                                        $selesai = $cetak->buku_selesai ?? 0;
                                        $target = $cetak->target_buku ?? 1;
                                        $persen = ($target > 0) ? round(($selesai / $target) * 100) : 0;
                                        $isSelesai = $persen >= 100;
                                        $prioritas = $cetak->prioritas ?? 'Normal';
                                        $judul = $cetak->buku->judul ?? 'Judul Buku';
                                        $warnaCover = $cetak->buku->warna_cover ?? '#c62828';
                                        
                                        $s = strtolower($cetak->status);
                                        $badgeClass = 'status-menunggu-text';
                                        if (str_contains($s, 'selesai')) $badgeClass = 'status-selesai-text';
                                        elseif (str_contains($s, 'dicetak')) $badgeClass = 'status-dicetak-text';
                                        elseif (str_contains($s, 'revisi')) $badgeClass = 'status-revisi-text';
                                        elseif (str_contains($s, 'diproses') && !str_contains($s, 'menunggu')) $badgeClass = 'status-diproses-text';
                                    @endphp

                                    <div class="cetak-card" id="card-{{ $cetak->id }}">
                                        <div class="card-top-row">
                                            <div class="item-id">{{ $cetak->kode_cetak }}</div>
                                            <div class="card-top-right">
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
                    @endif

                    @if($menungguDiproses->count() == 0 && $sudahDiproses->count() == 0)
                        <div class="empty-state-box">
                            Belum ada data permintaan pencetakan untuk divisi Literasi Digital.
                        </div>
                    @endif
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
    </div>

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
                <button type="button" class="btn-modal-simpan-status" id="btnSimpanUbahStatus">Simpan</button>
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

            detailButtons.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    document.querySelectorAll('.cetak-card').forEach(function (c) { 
                        c.classList.remove('selected'); 
                    });
                    
                    document.getElementById('card-' + this.dataset.id).classList.add('selected');

                    idTerpilih = this.dataset.id;
                    var targetTerpilih = parseInt(this.dataset.target, 10) || 0;
                    var selesai = parseInt(this.dataset.selesai, 10) || 0;
                    var persen = this.dataset.persen;
                    var currentStatus = this.dataset.status.toLowerCase();

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

                    if (currentStatus === 'menunggu diproses' || currentStatus === 'menunggu') {
                        inputJumlah.disabled = true;
                        btnUpdate.disabled = true;
                        btnUbahStatus.disabled = true;
                        
                        btnMulaiProses.disabled = false;
                        btnMulaiProses.textContent = 'Mulai Proses';
                    } else {
                        inputJumlah.disabled = false;
                        btnUpdate.disabled = false;
                        btnUbahStatus.disabled = false;
                        
                        btnMulaiProses.disabled = true;
                        btnMulaiProses.textContent = 'Sudah Diproses';
                    }

                    panelEmpty.style.display = 'none';
                    panelContent.style.display = 'block';
                });
            });

            /* ===== MULAI PROSES ===== */
            btnMulaiProses.addEventListener('click', function () {
                if (!idTerpilih) return;
                
                btnMulaiProses.disabled = true;
                btnMulaiProses.textContent = 'Memproses...';

                fetch('/admin/digital/pencetakan/update/' + idTerpilih, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ status: 'Diproses' }) 
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) window.location.reload();
                    else { alert('Gagal memulai proses.'); btnMulaiProses.textContent = 'Mulai Proses'; btnMulaiProses.disabled = false; }
                }).catch(err => {
                    console.error(err);
                    alert('Terjadi kesalahan.');
                    btnMulaiProses.disabled = false;
                    btnMulaiProses.textContent = 'Mulai Proses';
                });
            });

            /* ===== UPDATE JUMLAH SELESAI ===== */
            btnUpdate.addEventListener('click', function () {
                if (!idTerpilih) return;

                var jumlahBaru = parseInt(inputJumlah.value, 10);
                if (isNaN(jumlahBaru) || jumlahBaru < 0) return alert('Masukkan jumlah yang valid.');

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
                .then(res => res.json())
                .then(data => {
                    if (data.success) window.location.reload();
                    else { alert('Gagal.'); btnUpdate.disabled = false; btnUpdate.textContent = 'Update'; }
                });
            });

            /* ===== MODAL UBAH STATUS ===== */
            var ubahStatusModal = document.getElementById('ubahStatusModal');
            var statusSelectBtn = document.getElementById('statusSelectBtn');
            var statusSelectMenu = document.getElementById('statusSelectMenu');
            var statusSelectLabel = document.getElementById('statusSelectLabel');
            var statusSelectItems = document.querySelectorAll('.status-select-item');
            var statusBaruTerpilih = null;

            statusSelectBtn.addEventListener('click', () => statusSelectMenu.classList.toggle('open'));

            statusSelectItems.forEach(item => {
                item.addEventListener('click', function () {
                    statusSelectItems.forEach(i => i.classList.remove('selected'));
                    this.classList.add('selected');
                    statusSelectLabel.textContent = this.dataset.value;
                    statusBaruTerpilih = this.dataset.value;
                    statusSelectMenu.classList.remove('open');
                });
            });

            document.getElementById('btnCloseUbahStatus').addEventListener('click', () => ubahStatusModal.classList.remove('open'));
            document.getElementById('btnBatalUbahStatus').addEventListener('click', () => ubahStatusModal.classList.remove('open'));

            btnUbahStatus.addEventListener('click', function () {
                if (!idTerpilih) return;
                var statusSaatIni = document.querySelector('.btn-lihat-detail[data-id="' + idTerpilih + '"]').dataset.status;
                statusSelectLabel.textContent = statusSaatIni;
                statusBaruTerpilih = statusSaatIni;
                ubahStatusModal.classList.add('open');
            });

            document.getElementById('btnSimpanUbahStatus').addEventListener('click', function () {
                if (!idTerpilih || !statusBaruTerpilih) return;

                this.disabled = true;
                this.textContent = 'Menyimpan...';

                fetch('/admin/digital/pencetakan/update/' + idTerpilih, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ status: statusBaruTerpilih })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) window.location.reload();
                    else { alert('Gagal.'); this.disabled = false; this.textContent = 'Simpan'; }
                });
            });

        })();
    </script>
</body>
</html>