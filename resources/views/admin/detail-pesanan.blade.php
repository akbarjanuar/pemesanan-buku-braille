<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan - BrailleKita</title>
    
    <!-- Ikon FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary: #c62828;
            --background: #f4f6f9;
            --surface: #ffffff;
            --text-dark: #111111;
            --text-muted: #757575;
            --border: #e0e0e0;
        }

        *, *::before, *::after { box-sizing: border-box; }

        /* ===== BASE & TOPBAR ===== */
        .menu-toggle { display: inline-flex !important; align-items: center; justify-content: center; width: 24px; height: 24px; padding: 0; color: var(--text-muted); background: none; border: none; cursor: pointer; font-size: 20px; flex-shrink: 0; }
        .menu-toggle:hover { color: var(--primary); }
        .topbar-title { font-size: 20px; font-weight: 900; font-family: 'Georgia', serif; color: var(--text-dark); margin-left: 10px; }
        
        /* ===== LAYOUT DETAIL ===== */
        .content-area { padding: 32px; overflow-y: auto; flex-grow: 1; }
        
        .back-link {
            display: inline-block;
            font-family: 'Georgia', serif;
            font-weight: 900;
            color: var(--primary);
            font-size: 18px;
            margin-bottom: 24px;
            text-decoration: none;
            letter-spacing: 0.5px;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 24px;
            align-items: start;
        }

        .col-left { display: flex; flex-direction: column; gap: 24px; }
        .col-right { display: flex; flex-direction: column; gap: 24px; }

        /* ===== CARD ===== */
        .card {
            background-color: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 28px;
            position: relative;
        }
        
        .card-title {
            font-size: 18px;
            font-weight: 900;
            font-family: 'Georgia', serif;
            color: var(--text-dark);
            margin-bottom: 24px;
        }

        /* ===== ALASAN BATAL BOX ===== */
        .card-cancel {
            background-color: #f9d8d8;
            border: 1px solid #f2b6b6;
            border-radius: 12px;
            padding: 20px 28px;
            color: var(--primary);
            font-family: 'Georgia', serif;
            font-weight: 900;
            font-size: 16px;
        }

        /* ===== ORDER INFO GRID ===== */
        .order-info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 28px 24px;
        }

        .info-group label {
            display: block;
            font-size: 13px;
            color: var(--text-muted);
            margin-bottom: 6px;
        }

        .info-group p {
            font-size: 16px;
            font-weight: 900; /* Disesuaikan dengan desain: tebal & serif */
            font-family: 'Georgia', serif;
            color: var(--text-dark);
            margin: 0;
            letter-spacing: 0.2px;
        }

        .status-text-top {
            position: absolute;
            top: 28px;
            right: 28px;
            font-size: 14px;
            font-weight: 800;
        }

        /* Mapping Warna Status Sesuai Desain */
        .color-dikirim { color: #0097a7; } /* Biru */
        .color-dicetak { color: #fbc02d; } /* Kuning */
        .color-selesai { color: #2e7d32; } /* Hijau */
        .color-diproses { color: #e65100; } /* Oranye */
        .color-batal { color: #c62828; } /* Merah */

        /* ===== LIST BUKU ===== */
        .book-item {
            display: flex;
            gap: 20px;
            margin-bottom: 24px;
        }
        .book-item:last-child { margin-bottom: 0; }
        
        .book-cover {
            width: 70px;
            height: 90px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .braille-dots {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4px;
        }
        .braille-dots span {
            width: 5px;
            height: 5px;
            background-color: rgba(255, 255, 255, 0.4);
            border-radius: 50%;
        }

        .book-details { display: flex; flex-direction: column; justify-content: center; }
        .book-details h4 { font-size: 14px; font-weight: 800; color: var(--text-dark); margin: 0 0 6px 0; }
        .book-details p.meta { font-size: 13px; color: var(--text-muted); margin: 0 0 8px 0; }
        
        .stock-available { font-size: 13px; color: #2e7d32; font-weight: 700; margin: 0; }
        .stock-empty { font-size: 13px; color: #c62828; font-weight: 700; margin: 0; }

        /* ===== ALAMAT PENGIRIMAN ===== */
        .address-text { font-size: 14px; color: var(--text-muted); margin: 0 0 16px 0; line-height: 1.6; }
        .address-note { font-size: 13px; color: var(--text-muted); margin: 0; }

        /* ===== BUTTON ACTION ===== */
        .btn-outline {
            display: block;
            width: 100%;
            padding: 14px;
            background: transparent;
            border: 1px solid #d0d0d0;
            border-radius: 8px;
            text-align: center;
            font-size: 14px;
            font-weight: 700;
            color: var(--text-muted);
            cursor: pointer;
            transition: 0.2s;
            font-family: inherit;
        }
        .btn-outline:hover { background-color: #f9f9f9; color: var(--text-dark); }

        /* ===== TIMELINE RIWAYAT STATUS ===== */
        .timeline {
            position: relative;
            padding-left: 28px;
            margin-top: 10px;
        }
        .timeline::before {
            content: '';
            position: absolute;
            top: 6px;
            bottom: 14px;
            left: 7px;
            width: 2px;
            background: #e0e0e0;
        }
        
        .timeline-item {
            position: relative;
            margin-bottom: 28px;
        }
        .timeline-item:last-child { margin-bottom: 0; }
        
        .timeline-dot {
            position: absolute;
            left: -32.5px;
            top: 2px;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background-color: #e0e0e0; /* Default abu-abu untuk history masa lalu */
            border: 4px solid var(--surface);
            box-sizing: content-box;
            z-index: 2;
        }
        
        /* Titik Terakhir / Active SELALU Merah di desain */
        .timeline-item.active .timeline-dot { background-color: var(--primary); }
        
        .timeline-time { font-size: 12px; color: #9e9e9e; margin: 0 0 4px 0; }
        .timeline-title { font-size: 14px; font-weight: 800; color: var(--text-dark); margin: 0 0 4px 0; }
        .timeline-desc { font-size: 12px; color: var(--text-muted); margin: 0; }

        @media (max-width: 1024px) {
            .detail-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    {{-- SIDEBAR ADMIN --}}
    @include('partials.admin-nav', ['activeMenu' => 'permintaan-buku'])

    {{-- MAIN WRAPPER --}}
    <div class="main-wrapper">

        {{-- TOPBAR --}}
        <header class="topbar">
            <div class="topbar-left">
                <button type="button" class="menu-toggle" aria-label="Buka atau tutup sidebar">
                    <i class="fas fa-bars"></i>
                </button>
                <span class="topbar-title">Detail Pesanan</span>
            </div>

            <div class="topbar-right">
                <i class="far fa-bell notification-bell"></i>
                <div class="user-profile">
                    <span>{{ auth()->user()->nama ?? 'Admin' }}</span>
                    <i class="fas fa-user-circle"></i>
                </div>
            </div>
        </header>

        {{-- CONTENT --}}
        <main class="content-area">

            {{-- BACK LINK --}}
            <a href="{{ route('admin.permintaan-buku') }}" class="back-link">
                &larr; Permintaan Buku
            </a>

            <div class="detail-grid">
                
                {{-- KOLOM KIRI --}}
                <div class="col-left">
                    
                    {{-- KARTU 1: INFO PESANAN --}}
                    <div class="card">
                        @php
                            $dbStatus = $pesanan->status;
                            $statusColor = 'color-diproses'; 
                            
                            if(in_array($dbStatus, ['Sedang Dikirim', 'Siap Dikirim'])) $statusColor = 'color-dikirim';
                            elseif(in_array($dbStatus, ['Sedang Dicetak', 'Menunggu Pencetakan'])) $statusColor = 'color-dicetak';
                            elseif($dbStatus == 'Selesai') $statusColor = 'color-selesai';
                            elseif(in_array($dbStatus, ['Dibatalkan', 'Kendala'])) $statusColor = 'color-batal';
                        @endphp

                        {{-- Teks status di pojok kanan atas --}}
                        <div class="status-text-top {{ $statusColor }}">
                            {{ $pesanan->status }}
                        </div>

                        <div class="order-info-grid">
                            <div class="info-group">
                                <label>Nomor Pesanan</label>
                                <p>WYG-{{ date('Y', strtotime($pesanan->created_at)) }}-{{ str_pad($pesanan->id, 4, '0', STR_PAD_LEFT) }}</p>
                            </div>
                            <div class="info-group">
                                <label>Tanggal Pesanan</label>
                                <p>{{ \Carbon\Carbon::parse($pesanan->created_at)->translatedFormat('j F Y') }}</p>
                            </div>
                            <div class="info-group">
                                <label>Pelanggan</label>
                                <p>{{ $pesanan->user->nama ?? $pesanan->nama_penerima ?? '-' }}</p>
                            </div>
                            <div class="info-group">
                                <label>Jenis Permohonan</label>
                                <p>{{ $pesanan->jenis_pesanan ?? 'Pribadi' }}</p>
                            </div>
                            <div class="info-group">
                                <label>Email</label>
                                <p>{{ $pesanan->user->email ?? '-' }}</p>
                            </div>
                            <div class="info-group">
                                <label>Nomor HP</label>
                                <p>{{ $pesanan->telepon ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- KARTU 2: BUKU YANG DIPESAN --}}
                    <div class="card">
                        <div class="card-title">Buku yang dipesan</div>
                        
                        @php
                            $colors = ['#455a64', '#7b1fa2', '#ff5722', '#c2185b']; 
                        @endphp

                        @forelse($pesanan->details as $index => $detail)
                            <div class="book-item">
                                <div class="book-cover" style="background-color: {{ $colors[$index % count($colors)] }};">
                                    <div class="braille-dots">
                                        <span></span><span></span>
                                        <span></span><span></span>
                                        <span></span><span></span>
                                    </div>
                                </div>
                                <div class="book-details">
                                    <h4>{{ $detail->buku->judul ?? 'Judul Buku Tidak Ditemukan' }}</h4>
                                    <p class="meta">{{ $detail->buku->kategori ?? 'Kategori' }} . {{ $detail->jumlah }} Eksemplar</p>
                                    
                                    {{-- Logika Simulasi Indikator Stok Sesuai Gambar --}}
                                    @if(in_array($dbStatus, ['Sedang Dicetak', 'Menunggu Pencetakan']))
                                        <p class="stock-empty"><i class="far fa-times-circle"></i> Stok Kosong</p>
                                    @else
                                        <p class="stock-available">✔ Stok Tersedia</p>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p style="color: var(--text-muted); font-size: 14px;">Tidak ada data buku.</p>
                        @endforelse
                    </div>

                    {{-- KARTU KHUSUS: ALASAN PEMBATALAN (Hanya Tampil Jika Dibatalkan) --}}
                    @if(in_array($dbStatus, ['Dibatalkan', 'Kendala']))
                        <div class="card-cancel">
                            Alasan Pembatalan: {{ $pesanan->alasan_pembatalan ?? 'Salah memilih buku' }}
                        </div>
                    @endif

                    {{-- KARTU 3: ALAMAT PENGIRIMAN --}}
                    <div class="card">
                        <div class="card-title">Alamat Pengiriman</div>
                        <p class="address-text">
                            {{ $pesanan->alamat_lengkap ?? '-' }}<br>
                            @if($pesanan->kecamatan)
                                Kecamatan {{ $pesanan->kecamatan }}, 
                            @endif
                            @if($pesanan->kota)
                                {{ $pesanan->kota }}, 
                            @endif
                            @if($pesanan->provinsi)
                                {{ $pesanan->provinsi }} 
                            @endif
                            {{ $pesanan->kode_pos ?? '' }}
                        </p>
                        <p class="address-note">
                            Catatan: {{ $pesanan->catatan ?? '-' }}
                        </p>
                    </div>

                </div>

                {{-- KOLOM KANAN --}}
                <div class="col-right">
                    
                    {{-- KARTU 4: AKSI --}}
                    <div class="card">
                        <div class="card-title">Aksi</div>
                        <button class="btn-outline">Tambah Catatan</button>
                    </div>

                    {{-- KARTU 5: RIWAYAT STATUS --}}
                    <div class="card">
                        <div class="card-title">Riwayat Status</div>
                        
                        <div class="timeline">
                            @php
                                $waktuAwal = \Carbon\Carbon::parse($pesanan->created_at);
                            @endphp

                            {{-- KONDISI 1: MENUNGGU DIPROSES --}}
                            @if(in_array($dbStatus, ['Permintaan Baru', 'Menunggu Diproses', 'Sedang Diproses']))
                                <div class="timeline-item active">
                                    <div class="timeline-dot"></div>
                                    <p class="timeline-time">{{ $waktuAwal->translatedFormat('j M Y, H.i') }}</p>
                                    <p class="timeline-title">Menunggu diproses</p>
                                </div>
                            @endif

                            {{-- KONDISI 2: SEDANG DICETAK --}}
                            @if(in_array($dbStatus, ['Menunggu Pencetakan', 'Sedang Dicetak']))
                                <div class="timeline-item">
                                    <div class="timeline-dot"></div>
                                    <p class="timeline-time">{{ $waktuAwal->translatedFormat('j M Y, H.i') }}</p>
                                    <p class="timeline-title">Menunggu diproses</p>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-dot"></div>
                                    <p class="timeline-time">{{ $waktuAwal->copy()->addHours(3)->translatedFormat('j M Y, H.i') }}</p>
                                    <p class="timeline-title">Diproses</p>
                                    <p class="timeline-desc">Sedang dicek ketersediaan</p>
                                </div>
                                <div class="timeline-item active">
                                    <div class="timeline-dot"></div>
                                    <p class="timeline-time">{{ $waktuAwal->copy()->addDays(1)->translatedFormat('j M Y, H.i') }}</p>
                                    <p class="timeline-title">Menunggu pencetakan</p>
                                    <p class="timeline-desc">Buku tidak tersedia, Menunggu pencetakan</p>
                                </div>
                            @endif

                            {{-- KONDISI 3: SEDANG DIKIRIM --}}
                            @if(in_array($dbStatus, ['Siap Dikirim', 'Sedang Dikirim']))
                                <div class="timeline-item">
                                    <div class="timeline-dot"></div>
                                    <p class="timeline-time">{{ $waktuAwal->translatedFormat('j M Y, H.i') }}</p>
                                    <p class="timeline-title">Menunggu diproses</p>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-dot"></div>
                                    <p class="timeline-time">{{ $waktuAwal->copy()->addHours(5)->translatedFormat('j M Y, H.i') }}</p>
                                    <p class="timeline-title">Diproses</p>
                                    <p class="timeline-desc">Sedang dicek ketersediaan</p>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-dot"></div>
                                    <p class="timeline-time">{{ $waktuAwal->copy()->addDays(1)->translatedFormat('j M Y, H.i') }}</p>
                                    <p class="timeline-title">Siap dikirim</p>
                                    <p class="timeline-desc">Buku tersedia, siap dikirim</p>
                                </div>
                                <div class="timeline-item active">
                                    <div class="timeline-dot"></div>
                                    <p class="timeline-time">{{ $waktuAwal->copy()->addDays(2)->translatedFormat('j M Y, H.i') }}</p>
                                    <p class="timeline-title">Dikirim</p>
                                    <p class="timeline-desc">Buku sedang dikirim</p>
                                </div>
                            @endif

                            {{-- KONDISI 4: SELESAI --}}
                            @if($dbStatus == 'Selesai')
                                <div class="timeline-item">
                                    <div class="timeline-dot"></div>
                                    <p class="timeline-time">{{ $waktuAwal->translatedFormat('j M Y, H.i') }}</p>
                                    <p class="timeline-title">Menunggu diproses</p>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-dot"></div>
                                    <p class="timeline-time">{{ $waktuAwal->copy()->addHours(4)->translatedFormat('j M Y, H.i') }}</p>
                                    <p class="timeline-title">Diproses</p>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-dot"></div>
                                    <p class="timeline-time">{{ $waktuAwal->copy()->addDays(1)->translatedFormat('j M Y, H.i') }}</p>
                                    <p class="timeline-title">Siap dikirim</p>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-dot"></div>
                                    <p class="timeline-time">{{ $waktuAwal->copy()->addDays(2)->translatedFormat('j M Y, H.i') }}</p>
                                    <p class="timeline-title">Sedang dikirim</p>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-dot"></div>
                                    <p class="timeline-time">{{ $waktuAwal->copy()->addDays(4)->translatedFormat('j M Y, H.i') }}</p>
                                    <p class="timeline-title">Diterima</p>
                                </div>
                                <div class="timeline-item active">
                                    <div class="timeline-dot"></div>
                                    <p class="timeline-time">{{ $waktuAwal->copy()->addDays(4)->addMinutes(5)->translatedFormat('j M Y, H.i') }}</p>
                                    <p class="timeline-title">Selesai</p>
                                </div>
                            @endif

                            {{-- KONDISI 5: DIBATALKAN --}}
                            @if(in_array($dbStatus, ['Dibatalkan', 'Kendala']))
                                <div class="timeline-item">
                                    <div class="timeline-dot"></div>
                                    <p class="timeline-time">{{ $waktuAwal->translatedFormat('j M Y, H.i') }}</p>
                                    <p class="timeline-title">Menunggu diproses</p>
                                </div>
                                <div class="timeline-item active">
                                    <div class="timeline-dot"></div>
                                    <p class="timeline-time">{{ $waktuAwal->copy()->addMinutes(10)->translatedFormat('j M Y, H.i') }}</p>
                                    <p class="timeline-title">Dibatalkan</p>
                                </div>
                            @endif
                            
                        </div>
                    </div>

                </div>

            </div>
        </main>
    </div>

</body>
</html>