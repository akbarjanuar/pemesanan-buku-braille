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

        .menu-toggle { display: inline-flex !important; align-items: center; justify-content: center; width: 24px; height: 24px; padding: 0; color: var(--text-muted); background: none; border: none; cursor: pointer; font-size: 20px; flex-shrink: 0; }
        .menu-toggle:hover { color: var(--primary); }
        .topbar-title { font-size: 20px; font-weight: 900; font-family: 'Georgia', serif; color: var(--text-dark); margin-left: 10px; }
        
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
            font-weight: 900;
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

        /* Mapping Warna Status */
        .color-dikirim { color: #0097a7; }
        .color-dicetak { color: #fbc02d; }
        .color-selesai { color: #2e7d32; }
        .color-diproses { color: #e65100; }
        .color-batal { color: #c62828; }
        .color-return { color: #8e24aa; }

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

        .address-text { font-size: 14px; color: var(--text-muted); margin: 0 0 16px 0; line-height: 1.6; }
        .address-note { font-size: 13px; color: var(--text-muted); margin: 0; }

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
            background-color: #e0e0e0;
            border: 4px solid var(--surface);
            box-sizing: content-box;
            z-index: 2;
        }
        
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

    @include('partials.admin-nav', ['activeMenu' => 'permintaan-buku'])

    <div class="main-wrapper">

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

        <main class="content-area">

            <a href="{{ route('admin.permintaan-buku') }}" class="back-link">
                &larr; Permintaan Buku
            </a>

            <div class="detail-grid">
                
                <div class="col-left">
                    
                    <div class="card">
                        @php
                            $dbStatus = $pesanan->status;
                            $s = strtolower($dbStatus);
                            $statusColor = 'color-diproses'; 
                            
                            if(str_contains($s, 'dikirim')) $statusColor = 'color-dikirim';
                            elseif(str_contains($s, 'dicetak')) $statusColor = 'color-dicetak';
                            elseif(str_contains($s, 'selesai')) $statusColor = 'color-selesai';
                            elseif(str_contains($s, 'batal') || str_contains($s, 'kendala')) $statusColor = 'color-batal';
                            elseif(str_contains($s, 'return')) $statusColor = 'color-return';
                        @endphp

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
                                    
                                    @if(str_contains($s, 'dicetak'))
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

                    @if(str_contains($s, 'batal'))
                        <div class="card-cancel">
                            Alasan Pembatalan: {{ $pesanan->alasan_pembatalan ?? 'Dibatalkan oleh sistem/admin.' }}
                        </div>
                    @endif

                    <div class="card">
                        <div class="card-title">Alamat Pengiriman</div>
                        <p class="address-text">
                            {{ $pesanan->alamat_lengkap ?? '-' }}<br>
                            @if($pesanan->kecamatan) Kecamatan {{ $pesanan->kecamatan }}, @endif
                            @if($pesanan->kota) {{ $pesanan->kota }}, @endif
                            @if($pesanan->provinsi) {{ $pesanan->provinsi }} @endif
                            {{ $pesanan->kode_pos ?? '' }}
                        </p>
                        <p class="address-note">
                            Catatan: {{ $pesanan->catatan ?? '-' }}
                        </p>
                    </div>

                </div>

                <div class="col-right">
                    
                    <div class="card">
                        <div class="card-title">Aksi</div>
                        <button class="btn-outline">Tambah Catatan</button>
                    </div>

                    {{-- KARTU RIWAYAT STATUS SESUAI 6 STATUS UTAMA --}}
                    <div class="card">
                        <div class="card-title">Riwayat Status</div>
                        
                        <div class="timeline">
                            @php
                                $waktuAwal = \Carbon\Carbon::parse($pesanan->created_at);
                            @endphp

                            {{-- 1. Status Dibatalkan --}}
                            @if(str_contains($s, 'batal'))
                                <div class="timeline-item">
                                    <div class="timeline-dot"></div>
                                    <p class="timeline-time">{{ $waktuAwal->translatedFormat('j M Y, H.i') }}</p>
                                    <p class="timeline-title">Diproses</p>
                                </div>
                                <div class="timeline-item active">
                                    <div class="timeline-dot"></div>
                                    <p class="timeline-time">{{ $waktuAwal->copy()->addMinutes(15)->translatedFormat('j M Y, H.i') }}</p>
                                    <p class="timeline-title">Dibatalkan</p>
                                </div>

                            {{-- 2. Status Return --}}
                            @elseif(str_contains($s, 'return'))
                                <div class="timeline-item">
                                    <div class="timeline-dot"></div>
                                    <p class="timeline-time">{{ $waktuAwal->translatedFormat('j M Y, H.i') }}</p>
                                    <p class="timeline-title">Diproses</p>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-dot"></div>
                                    <p class="timeline-time">{{ $waktuAwal->copy()->addDays(1)->translatedFormat('j M Y, H.i') }}</p>
                                    <p class="timeline-title">Dikirim</p>
                                </div>
                                <div class="timeline-item active">
                                    <div class="timeline-dot"></div>
                                    <p class="timeline-time">{{ $waktuAwal->copy()->addDays(3)->translatedFormat('j M Y, H.i') }}</p>
                                    <p class="timeline-title">Return</p>
                                </div>

                            {{-- 3. Status Selesai --}}
                            @elseif(str_contains($s, 'selesai'))
                                <div class="timeline-item">
                                    <div class="timeline-dot"></div>
                                    <p class="timeline-time">{{ $waktuAwal->translatedFormat('j M Y, H.i') }}</p>
                                    <p class="timeline-title">Diproses</p>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-dot"></div>
                                    <p class="timeline-time">{{ $waktuAwal->copy()->addHours(3)->translatedFormat('j M Y, H.i') }}</p>
                                    <p class="timeline-title">Dicetak</p>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-dot"></div>
                                    <p class="timeline-time">{{ $waktuAwal->copy()->addDays(1)->translatedFormat('j M Y, H.i') }}</p>
                                    <p class="timeline-title">Dikirim</p>
                                </div>
                                <div class="timeline-item active">
                                    <div class="timeline-dot"></div>
                                    <p class="timeline-time">{{ $waktuAwal->copy()->addDays(3)->translatedFormat('j M Y, H.i') }}</p>
                                    <p class="timeline-title">Selesai</p>
                                </div>

                            {{-- 4. Status Dikirim --}}
                            @elseif(str_contains($s, 'dikirim'))
                                <div class="timeline-item">
                                    <div class="timeline-dot"></div>
                                    <p class="timeline-time">{{ $waktuAwal->translatedFormat('j M Y, H.i') }}</p>
                                    <p class="timeline-title">Diproses</p>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-dot"></div>
                                    <p class="timeline-time">{{ $waktuAwal->copy()->addHours(3)->translatedFormat('j M Y, H.i') }}</p>
                                    <p class="timeline-title">Dicetak</p>
                                </div>
                                <div class="timeline-item active">
                                    <div class="timeline-dot"></div>
                                    <p class="timeline-time">{{ $waktuAwal->copy()->addDays(1)->translatedFormat('j M Y, H.i') }}</p>
                                    <p class="timeline-title">Dikirim</p>
                                </div>

                            {{-- 5. Status Dicetak --}}
                            @elseif(str_contains($s, 'dicetak'))
                                <div class="timeline-item">
                                    <div class="timeline-dot"></div>
                                    <p class="timeline-time">{{ $waktuAwal->translatedFormat('j M Y, H.i') }}</p>
                                    <p class="timeline-title">Diproses</p>
                                </div>
                                <div class="timeline-item active">
                                    <div class="timeline-dot"></div>
                                    <p class="timeline-time">{{ $waktuAwal->copy()->addHours(3)->translatedFormat('j M Y, H.i') }}</p>
                                    <p class="timeline-title">Dicetak</p>
                                </div>

                            {{-- 6. Status Diproses (Default awal) --}}
                            @else
                                <div class="timeline-item active">
                                    <div class="timeline-dot"></div>
                                    <p class="timeline-time">{{ $waktuAwal->translatedFormat('j M Y, H.i') }}</p>
                                    <p class="timeline-title">Diproses</p>
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