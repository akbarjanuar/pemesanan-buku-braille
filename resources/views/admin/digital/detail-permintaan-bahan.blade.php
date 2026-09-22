<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Permintaan Bahan - Admin Literasi Digital</title>
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

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; }
        
        html, body { 
            background: var(--background); 
            color: var(--text-dark); 
            min-height: 100vh; 
            overflow-y: auto !important; 
        }

        body { 
            display: flex; 
        }

        .main-wrapper { 
            flex: 1; 
            display: flex; 
            flex-direction: column; 
            background: #ffffff; 
            min-width: 0; 
            min-height: 100vh;
        }

        /* TOPBAR DISAMAKAN DENGAN DASHBOARD */
        .topbar { 
            height: 70px; 
            min-height: 70px; 
            background: #ffffff; 
            border-bottom: 1px solid var(--border); 
            display: flex; 
            align-items: center; 
            justify-content: space-between; 
            padding: 0 28px; 
            position: sticky; 
            top: 0; 
            z-index: 100; 
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .menu-toggle {
            width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            background: transparent;
            color: #757575;
            font-size: 21px;
            cursor: pointer;
            border-radius: 6px;
        }

        .menu-toggle:hover {
            background: #f5f5f5;
        }

        .topbar-title { 
            font-size: 20px; 
            font-weight: 700; 
            color: #111111; 
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
            flex-shrink: 0;
        }

        /* Styling Ikon Notifikasi dengan Titik Merah */
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

        .notification-button:hover {
            background: #f5f5f5;
        }

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
            color: var(--text-dark);
            cursor: pointer;
            white-space: nowrap;
        }

        .topbar-user img,
        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
        }

        .user-avatar {
            display: flex;
            align-items: center;
            justify-content: center;
            background: #111;
            color: white;
            font-size: 16px;
        }
        
        .content-area { 
            padding: 30px 40px 60px; 
            max-width: 900px; 
            width: 100%; 
        }

        .back-link { display: inline-block; color: var(--primary); text-decoration: none; font-size: 13px; font-weight: 600; margin-bottom: 15px; }
        
        .page-header h1 { font-size: 18px; font-weight: 700; margin-bottom: 4px; }
        .page-header p { color: var(--text-muted); font-size: 13px; margin-bottom: 25px; }

        /* WARNING BOX */
        .warning-box { background: #ffebee; border: 1px solid #ef5350; border-radius: 8px; padding: 20px; margin-bottom: 25px; }
        .warning-header { display: flex; align-items: center; gap: 10px; color: #c62828; font-weight: 700; font-size: 15px; margin-bottom: 10px; }
        .warning-text { font-size: 13px; color: #c62828; margin-bottom: 8px; font-weight: 600; }
        .warning-note { background: #ffffff; border: 1px solid #ef5350; padding: 12px; border-radius: 6px; font-size: 13px; color: #c62828; font-style: italic; margin-bottom: 12px; }
        .btn-upload-surat { background: var(--primary); color: white; border: none; padding: 10px 20px; border-radius: 6px; font-weight: 600; cursor: pointer; font-size: 13px; }

        /* CARD SECTION */
        .section-card { border: 1px solid var(--border); border-radius: 12px; padding: 25px; margin-bottom: 25px; background: #ffffff; }
        .section-header { display: flex; align-items: center; gap: 12px; margin-bottom: 20px; }
        .circle-num { width: 28px; height: 28px; background: var(--primary); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px; }
        .section-header h2 { font-size: 16px; font-weight: 700; }

        /* GRID INFO */
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px 40px; }
        .info-row { display: flex; font-size: 13px; }
        .info-label { width: 140px; color: var(--text-muted); font-weight: 500; }
        .info-value { font-weight: 700; color: #333; }
        .info-colon { margin: 0 10px; font-weight: 500; }

        /* DOCUMENT BOX */
        .doc-box { background: #f9f9f9; border: 1px solid var(--border); border-radius: 8px; padding: 15px 20px; display: flex; align-items: center; justify-content: space-between; }
        .doc-left { display: flex; align-items: center; gap: 15px; }
        .doc-icon { background: var(--primary); color: white; width: 40px; height: 40px; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 20px; }
        .doc-info h3 { font-size: 14px; font-weight: 700; margin-bottom: 2px; }
        .doc-info p { font-size: 12px; color: var(--text-muted); }
        .doc-actions a { color: var(--primary); text-decoration: none; font-size: 12px; font-weight: 600; margin-left: 15px; }
        .doc-actions a:hover { text-decoration: underline; }

        /* TIMELINE */
        .timeline { position: relative; padding-left: 20px; margin-top: 5px; }
        .timeline::before { content: ''; position: absolute; left: 5px; top: 5px; bottom: 5px; width: 2px; background: #e0e0e0; }
        .timeline-item { position: relative; margin-bottom: 24px; }
        .timeline-item:last-child { margin-bottom: 0; }
        .timeline-dot { position: absolute; left: -20px; top: 2px; width: 12px; height: 12px; background: #bdbdbd; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 0 1px #bdbdbd; }
        .timeline-title { font-size: 14px; font-weight: 700; color: #333; margin-bottom: 2px; }
        .timeline-date { font-size: 12px; color: var(--text-muted); }
        
        .timeline-item.active .timeline-dot { background: var(--primary); box-shadow: 0 0 0 1px var(--primary); }
    </style>
</head>
<body>

    @include('partials.admin-digital-nav', ['activeMenu' => $activeMenu ?? 'permintaan-bahan'])

    <div class="main-wrapper">
        {{-- TOPBAR DISAMAKAN PERSIS --}}
        <div class="topbar">
            <div class="topbar-left">
                <button type="button" class="menu-toggle">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="topbar-title">Detail Permintaan Bahan</div>
            </div>

            <div class="topbar-right">
                <div class="notification-button">
                    <i class="far fa-bell"></i>
                    <span class="notification-dot"></span>
                </div>

                <a href="{{ route('admin.digital.profile') }}" class="topbar-user">
                    <span style="font-weight: 700; font-size: 15px;">
                        {{ auth()->user()->nama ?? 'Admin Digital' }}
                    </span>
                    
                    <div class="user-avatar">
                        @if(auth()->user()->foto_profil)
                            <img src="{{ auth()->user()->foto_profil }}" alt="Profile" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <i class="fas fa-user"></i>
                        @endif
                    </div>
                </a>
            </div>
        </div>

        <main class="content-area">
            <a href="{{ route('admin.digital.permintaan-bahan') }}" class="back-link">&larr; Kembali</a>
            
            <div class="page-header">
                <h1>Detail Permintaan Bahan</h1>
                <p>{{ $permintaanBahan->id_permintaan ?? $permintaanBahan->id }} . {{ optional($permintaanBahan->created_at)->format('d F Y') }}</p>
            </div>

            @php
                $status = strtolower(trim($permintaanBahan->status ?? ''));
                $isPerbaikan = str_contains($status, 'perbaikan') || str_contains($status, 'kendala');
            @endphp

            @if($isPerbaikan)
            <div class="warning-box">
                <div class="warning-header">
                    <i class="fas fa-exclamation-circle"></i> Perlu Perbaikan
                </div>
                <div class="warning-text">Alasan: {{ $permintaanBahan->alasan_kendala ?? 'Terdapat kesalahan pada dokumen' }}</div>
                <div class="warning-text">Catatan perbaikan</div>
                <div class="warning-note">"{{ $permintaanBahan->catatan_kendala ?? 'Mohon perbaiki dokumen sesuai standar' }}"</div>
                <div class="warning-text" style="margin-bottom:15px; font-weight:500;">Dokumen surat sebelumnya: {{ optional($permintaanBahan->created_at)->format('d.m.Y') }} Surat Pengajuan {{ $permintaanBahan->nama_bahan ?? 'Bahan' }}.pdf</div>
                <button class="btn-upload-surat">Perbaiki & Upload Surat</button>
            </div>
            @endif

            <!-- Section 1 -->
            <div class="section-card">
                <div class="section-header">
                    <div class="circle-num">1</div>
                    <h2>Informasi Permintaan</h2>
                </div>
                <div class="info-grid">
                    <div>
                        <div class="info-row"><span class="info-label">Id Permintaan</span><span class="info-colon">:</span><span class="info-value">{{ $permintaanBahan->id_permintaan ?? $permintaanBahan->id }}</span></div>
                        <div class="info-row" style="margin-top:10px;"><span class="info-label">Nama Buku</span><span class="info-colon">:</span><span class="info-value">{{ $permintaanBahan->pencetakan->buku->judul ?? '-' }}</span></div>
                        <div class="info-row" style="margin-top:10px;"><span class="info-label">Nama Bahan</span><span class="info-colon">:</span><span class="info-value">{{ $permintaanBahan->nama_bahan ?? $permintaanBahan->bahan ?? '-' }}</span></div>
                        <div class="info-row" style="margin-top:10px;"><span class="info-label">Satuan</span><span class="info-colon">:</span><span class="info-value">{{ $permintaanBahan->satuan ?? '-' }}</span></div>
                        <div class="info-row" style="margin-top:10px;"><span class="info-label">PIC</span><span class="info-colon">:</span><span class="info-value">{{ $permintaanBahan->pic ?? '-' }}</span></div>
                    </div>
                    <div>
                        <div class="info-row"><span class="info-label">Id Pencetakan</span><span class="info-colon">:</span><span class="info-value">{{ $permintaanBahan->pencetakan->kode_cetak ?? '-' }}</span></div>
                        <div class="info-row" style="margin-top:10px;"><span class="info-label">Jumlah Buku</span><span class="info-colon">:</span><span class="info-value">{{ $permintaanBahan->pencetakan->jumlah ?? '-' }}</span></div>
                        <div class="info-row" style="margin-top:10px;"><span class="info-label">Jumlah Bahan</span><span class="info-colon">:</span><span class="info-value">{{ $permintaanBahan->jumlah ?? '-' }}</span></div>
                        <div class="info-row" style="margin-top:10px;"><span class="info-label">Tujuan Penggunaan</span><span class="info-colon">:</span><span class="info-value">{{ $permintaanBahan->keperluan ?? '-' }}</span></div>
                        <div class="info-row" style="margin-top:10px;"><span class="info-label">Tanggal Pengajuan</span><span class="info-colon">:</span><span class="info-value">{{ optional($permintaanBahan->created_at)->format('d F Y') }}</span></div>
                    </div>
                </div>
            </div>

            <!-- Section 2 -->
            <div class="section-card">
                <div class="section-header">
                    <div class="circle-num">2</div>
                    <h2>Dokumen Surat Pengajuan</h2>
                </div>
                <div class="doc-box">
                    <div class="doc-left">
                        <div class="doc-icon"><i class="fas fa-file-pdf"></i></div>
                        <div class="doc-info">
                            <h3>{{ optional($permintaanBahan->created_at)->format('d.m.Y') }} Surat Pengajuan {{ $permintaanBahan->nama_bahan ?? 'Bahan' }}.pdf</h3>
                            <p>Diunggah: {{ optional($permintaanBahan->created_at)->format('d F Y, H:i') }}</p>
                        </div>
                    </div>
                    <div class="doc-actions">
                        <a href="#">Lihat Dokumen</a> | <a href="#">Unduh Dokumen</a>
                    </div>
                </div>
            </div>

            <!-- Section 3 -->
            <div class="section-card">
                <div class="section-header">
                    <div class="circle-num">3</div>
                    <h2>Riwayat Permintaan</h2>
                </div>
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="timeline-title">Permintaan Bahan diajukan</div>
                        <div class="timeline-date">{{ optional($permintaanBahan->created_at)->format('d F Y, H:i') }}</div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="timeline-title">Surat Pengajuan diunggah</div>
                        <div class="timeline-date">{{ optional($permintaanBahan->created_at)->format('d F Y, H:i') }}</div>
                    </div>
                    <div class="timeline-item active">
                        <div class="timeline-dot"></div>
                        <div class="timeline-title">{{ $permintaanBahan->status ?? 'Menunggu Pemeriksaan' }}</div>
                        <div class="timeline-date">{{ optional($permintaanBahan->updated_at)->format('d F Y, H:i') }}</div>
                    </div>
                </div>
            </div>

        </main>
    </div>
</body>
</html>