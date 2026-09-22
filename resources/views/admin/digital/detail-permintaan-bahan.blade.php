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
            --primary-hover: #b71c1c;
            --background: #f4f6f9;
            --surface: #ffffff;
            --text-dark: #111111;
            --text-muted: #757575;
            --border: #e0e0e0;
            --success: #2e7d32;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; }
        
        html, body { 
            background: var(--background); 
            color: var(--text-dark); 
            min-height: 100vh; 
            overflow-y: auto !important; 
        }

        body { display: flex; }

        .main-wrapper { 
            flex: 1; 
            display: flex; 
            flex-direction: column; 
            background: #ffffff; 
            min-width: 0; 
            min-height: 100vh;
        }

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

        .topbar-left { display: flex; align-items: center; gap: 14px; }

        .menu-toggle {
            width: 38px; height: 38px;
            display: inline-flex; align-items: center; justify-content: center;
            border: none; background: transparent; color: #757575;
            font-size: 21px; cursor: pointer; border-radius: 6px;
        }
        .menu-toggle:hover { background: #f5f5f5; }

        .topbar-title { font-size: 20px; font-weight: 700; color: #111111; }

        .topbar-right { display: flex; align-items: center; gap: 20px; flex-shrink: 0; }

        .notification-button {
            position: relative; width: 38px; height: 38px;
            display: flex; align-items: center; justify-content: center;
            color: #111111; font-size: 19px; cursor: pointer; border-radius: 6px;
        }
        .notification-button:hover { background: #f5f5f5; }

        .notification-dot {
            position: absolute; top: 7px; right: 7px;
            width: 7px; height: 7px; background: var(--primary); border-radius: 50%;
        }

        .topbar-user {
            display: flex; align-items: center; gap: 12px;
            text-decoration: none; color: var(--text-dark); cursor: pointer; white-space: nowrap;
        }

        .topbar-user img, .user-avatar {
            width: 36px; height: 36px; border-radius: 50%; object-fit: cover;
        }

        .user-avatar {
            display: flex; align-items: center; justify-content: center;
            background: #111; color: white; font-size: 16px;
        }
        
        .content-area { padding: 30px 40px 60px; max-width: 900px; width: 100%; }

        .back-link { display: inline-block; color: var(--primary); text-decoration: none; font-size: 13px; font-weight: 600; margin-bottom: 15px; }
        
        .page-header h1 { font-size: 18px; font-weight: 700; margin-bottom: 4px; }
        .page-header p { color: var(--text-muted); font-size: 13px; margin-bottom: 25px; }

        .warning-box { background: #ffebee; border: 1px solid #ef5350; border-radius: 8px; padding: 20px; margin-bottom: 25px; }
        .warning-header { display: flex; align-items: center; gap: 10px; color: #c62828; font-weight: 700; font-size: 15px; margin-bottom: 10px; }
        .warning-text { font-size: 13px; color: #c62828; margin-bottom: 8px; font-weight: 600; }
        .warning-note { background: #ffffff; border: 1px solid #ef5350; padding: 12px; border-radius: 6px; font-size: 13px; color: #c62828; font-style: italic; margin-bottom: 12px; }
        .btn-upload-surat { background: var(--primary); color: white; border: none; padding: 10px 20px; border-radius: 6px; font-weight: 600; cursor: pointer; font-size: 13px; }
        .btn-upload-surat:hover { background: var(--primary-hover); }

        .section-card { border: 1px solid var(--border); border-radius: 12px; padding: 25px; margin-bottom: 25px; background: #ffffff; }
        .section-header { display: flex; align-items: center; gap: 12px; margin-bottom: 20px; }
        .circle-num { width: 28px; height: 28px; background: var(--primary); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px; }
        .section-header h2 { font-size: 16px; font-weight: 700; }

        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px 40px; }
        .info-row { display: flex; font-size: 13px; }
        .info-label { width: 140px; color: var(--text-muted); font-weight: 500; }
        .info-value { font-weight: 700; color: #333; }
        .info-colon { margin: 0 10px; font-weight: 500; }

        .doc-box { background: #f9f9f9; border: 1px solid var(--border); border-radius: 8px; padding: 15px 20px; display: flex; align-items: center; justify-content: space-between; }
        .doc-left { display: flex; align-items: center; gap: 15px; }
        .doc-icon { background: var(--primary); color: white; width: 40px; height: 40px; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 20px; }
        .doc-info h3 { font-size: 14px; font-weight: 700; margin-bottom: 2px; }
        .doc-info p { font-size: 12px; color: var(--text-muted); }
        .doc-actions a { color: var(--primary); text-decoration: none; font-size: 12px; font-weight: 600; margin-left: 15px; }
        .doc-actions a:hover { text-decoration: underline; }

        .timeline { position: relative; padding-left: 20px; margin-top: 5px; }
        .timeline::before { content: ''; position: absolute; left: 5px; top: 5px; bottom: 5px; width: 2px; background: #e0e0e0; }
        .timeline-item { position: relative; margin-bottom: 24px; }
        .timeline-item:last-child { margin-bottom: 0; }
        .timeline-dot { position: absolute; left: -20px; top: 2px; width: 12px; height: 12px; background: #bdbdbd; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 0 1px #bdbdbd; }
        .timeline-title { font-size: 14px; font-weight: 700; color: #333; margin-bottom: 2px; }
        .timeline-date { font-size: 12px; color: var(--text-muted); }
        .timeline-item.active .timeline-dot { background: var(--primary); box-shadow: 0 0 0 1px var(--primary); }

        /* TOAST SUKSES */
        .toast-success {
            position: fixed; bottom: 28px; left: 50%;
            transform: translateX(-50%) translateY(20px);
            background: #2e7d32; color: #ffffff;
            padding: 14px 22px; border-radius: 10px;
            font-size: 13px; font-weight: 600;
            display: flex; align-items: center; gap: 12px;
            box-shadow: 0 8px 24px rgba(46, 125, 50, 0.35);
            z-index: 2000; opacity: 0; visibility: hidden;
            transition: opacity 0.3s ease, transform 0.3s ease, visibility 0.3s;
            max-width: 90%; min-width: 280px;
        }
        .toast-success.show {
            opacity: 1; visibility: visible;
            transform: translateX(-50%) translateY(0);
        }
        .toast-success i { font-size: 18px; flex-shrink: 0; }
        .toast-success .toast-text { flex: 1; line-height: 1.4; }
        .toast-success .toast-close {
            background: transparent; border: none;
            color: rgba(255,255,255,0.85); font-size: 16px;
            cursor: pointer; padding: 2px 6px; border-radius: 4px; flex-shrink: 0;
        }
        .toast-success .toast-close:hover { background: rgba(255,255,255,0.15); color: #fff; }

        /* MODAL */
        .modal-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0, 0, 0, 0.45); z-index: 1000;
            align-items: center; justify-content: center; padding: 20px;
        }
        .modal-overlay.open { display: flex; }

        .modal-box {
            background: #ffffff; border-radius: 12px;
            width: 100%; max-width: 480px; max-height: 90vh;
            overflow-y: auto; box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 20px 24px 12px;
        }
        .modal-header h3 { font-size: 17px; font-weight: 700; color: #111; }

        .modal-close {
            width: 32px; height: 32px; border: none; background: transparent;
            color: #757575; font-size: 18px; cursor: pointer; border-radius: 6px;
            display: flex; align-items: center; justify-content: center;
        }
        .modal-close:hover { background: #f5f5f5; color: #111; }

        .modal-body { padding: 8px 24px 20px; }

        .modal-catatan {
            background: #ffebee; border: 1px solid #ef9a9a;
            border-radius: 8px; padding: 14px 16px; margin-bottom: 18px;
        }
        .modal-catatan-title { font-size: 13px; font-weight: 700; color: #c62828; margin-bottom: 6px; }
        .modal-catatan-text { font-size: 13px; color: #c62828; line-height: 1.5; }
        .modal-catatan-alasan { font-size: 12px; color: #c62828; margin-top: 6px; opacity: 0.9; }

        .modal-label { font-size: 13px; font-weight: 600; color: #333; margin-bottom: 8px; display: block; }

        .modal-doc-prev {
            background: #f5f5f5; border: 1px solid var(--border);
            border-radius: 8px; padding: 12px 14px; font-size: 13px;
            color: #555; margin-bottom: 18px; word-break: break-word;
        }

        .modal-file-input {
            border: 1.5px dashed #c7c7c7; border-radius: 8px;
            padding: 18px 14px; text-align: center; background: #fafafa;
            cursor: pointer; transition: 0.2s; margin-bottom: 8px;
        }
        .modal-file-input:hover { border-color: var(--primary); background: #fff5f5; }
        .modal-file-input input[type="file"] { display: none; }
        .modal-file-text { font-size: 13px; color: #888; }
        .modal-file-name { font-size: 13px; color: var(--primary); font-weight: 600; margin-top: 6px; display: none; }

        .modal-note { font-size: 12px; color: var(--text-muted); margin-top: 10px; margin-bottom: 20px; line-height: 1.5; }

        .modal-footer { display: flex; justify-content: flex-end; gap: 12px; padding: 0 24px 22px; }

        .btn-modal-batal {
            background: #ffffff; border: 1px solid var(--border); color: #555;
            padding: 10px 20px; border-radius: 7px; font-size: 13px; font-weight: 600; cursor: pointer;
        }
        .btn-modal-batal:hover { background: #f5f5f5; }

        .btn-modal-kirim {
            background: var(--primary); border: none; color: white;
            padding: 10px 20px; border-radius: 7px; font-size: 13px; font-weight: 600; cursor: pointer;
        }
        .btn-modal-kirim:hover { background: var(--primary-hover); }

        @media (max-width: 650px) {
            .content-area { padding: 20px 14px 35px; }
            .info-grid { grid-template-columns: 1fr; gap: 12px; }
            .doc-box { flex-direction: column; align-items: flex-start; gap: 12px; }
            .doc-actions { margin-left: 55px; }
            .modal-box { max-width: 100%; }
            .toast-success {
                bottom: 16px; left: 14px; right: 14px;
                transform: translateY(20px); max-width: none; min-width: 0;
            }
            .toast-success.show { transform: translateY(0); }
        }
    </style>
</head>
<body>

    @include('partials.admin-digital-nav', ['activeMenu' => $activeMenu ?? 'permintaan-bahan'])

    <div class="main-wrapper">
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
                $isPerbaikan = str_contains($status, 'perbaikan') || str_contains($status, 'kendala') || str_contains($status, 'diperbaiki');
                
                $picTampil = '-';
                if ($permintaanBahan->pencetakan && !empty($permintaanBahan->pencetakan->pic)) {
                    $picTampil = $permintaanBahan->pencetakan->pic;
                } elseif (!empty($permintaanBahan->pengaju)) {
                    $picTampil = $permintaanBahan->pengaju;
                }

                $namaDokumen = optional($permintaanBahan->created_at)->format('d.m.Y') . ' Surat Pengajuan ' . ($permintaanBahan->nama_bahan ?? 'Bahan') . '.pdf';
                $catatanPerbaikan = $permintaanBahan->catatan_kendala ?? 'Mohon perbaiki dokumen sesuai standar';
                $alasanKendala = $permintaanBahan->alasan_kendala ?? 'Terdapat kesalahan pada dokumen';
            @endphp

            @if($isPerbaikan)
            <div class="warning-box">
                <div class="warning-header">
                    <i class="fas fa-exclamation-circle"></i> Perlu Perbaikan
                </div>
                <div class="warning-text">Alasan: {{ $alasanKendala }}</div>
                <div class="warning-text">Catatan perbaikan</div>
                <div class="warning-note">"{{ $catatanPerbaikan }}"</div>
                <div class="warning-text" style="margin-bottom:15px; font-weight:500;">
                    Dokumen surat sebelumnya: {{ $namaDokumen }}
                </div>
                <button type="button" class="btn-upload-surat" id="btnOpenModal">
                    Perbaiki & Upload Surat
                </button>
            </div>
            @endif

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
                        <div class="info-row" style="margin-top:10px;"><span class="info-label">PIC</span><span class="info-colon">:</span><span class="info-value">{{ $picTampil }}</span></div>
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

            <div class="section-card">
                <div class="section-header">
                    <div class="circle-num">2</div>
                    <h2>Dokumen Surat Pengajuan</h2>
                </div>
                <div class="doc-box">
                    <div class="doc-left">
                        <div class="doc-icon"><i class="fas fa-file-pdf"></i></div>
                        <div class="doc-info">
                            <h3>{{ $namaDokumen }}</h3>
                            <p>Diunggah: {{ optional($permintaanBahan->created_at)->format('d F Y, H:i') }}</p>
                        </div>
                    </div>
                    <div class="doc-actions">
                        <a href="#">Lihat Dokumen</a> | <a href="#">Unduh Dokumen</a>
                    </div>
                </div>
            </div>

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

    {{-- TOAST --}}
    @if(session('success'))
    <div class="toast-success" id="toastSuccess">
        <i class="fas fa-check-circle"></i>
        <span class="toast-text">{{ session('success') }}</span>
        <button type="button" class="toast-close" id="btnCloseToast">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    {{-- MODAL --}}
    <div class="modal-overlay" id="modalUploadSurat">
        <div class="modal-box">
            <div class="modal-header">
                <h3>Perbaiki & Upload Surat</h3>
                <button type="button" class="modal-close" id="btnCloseModal">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form id="formUploadRevisi" 
                  method="POST" 
                  enctype="multipart/form-data"
                  action="{{ route('admin.digital.permintaan-bahan.revisi', $permintaanBahan->id) }}">
                @csrf

                <div class="modal-body">
                    <div class="modal-catatan">
                        <div class="modal-catatan-title">Catatan Perbaikan:</div>
                        <div class="modal-catatan-text">"{{ $catatanPerbaikan }}"</div>
                        <div class="modal-catatan-alasan">Alasan: {{ $alasanKendala }}</div>
                    </div>

                    <label class="modal-label">Dokumen Sebelumnya</label>
                    <div class="modal-doc-prev">{{ $namaDokumen }}</div>

                    <label class="modal-label">Upload Surat Revisi <span style="color:#c62828;">*</span></label>
                    <div class="modal-file-input" id="fileDropArea">
                        <input type="file" name="surat_revisi" id="inputSuratRevisi" accept=".pdf,.doc,.docx" required>
                        <div class="modal-file-text">Pilih file surat revisi (PDF/DOC/DOCX)</div>
                        <div class="modal-file-name" id="fileNameDisplay"></div>
                    </div>

                    <p class="modal-note">
                        Setelah dikirim, status kembali menjadi <strong>Menunggu Pemeriksaan</strong>
                    </p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-modal-batal" id="btnBatalModal">Batal</button>
                    <button type="submit" class="btn-modal-kirim">Kirim ulang untuk pemeriksaan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        (function () {
            // Toast
            var toast = document.getElementById('toastSuccess');
            var btnCloseToast = document.getElementById('btnCloseToast');

            if (toast) {
                setTimeout(function () { toast.classList.add('show'); }, 100);
                var hideTimer = setTimeout(function () { toast.classList.remove('show'); }, 4000);
                if (btnCloseToast) {
                    btnCloseToast.addEventListener('click', function () {
                        clearTimeout(hideTimer);
                        toast.classList.remove('show');
                    });
                }
            }

            // Modal
            var modal = document.getElementById('modalUploadSurat');
            var btnOpen = document.getElementById('btnOpenModal');
            var btnClose = document.getElementById('btnCloseModal');
            var btnBatal = document.getElementById('btnBatalModal');
            var fileInput = document.getElementById('inputSuratRevisi');
            var fileDropArea = document.getElementById('fileDropArea');
            var fileNameDisplay = document.getElementById('fileNameDisplay');

            function openModal() { if (modal) modal.classList.add('open'); }
            function closeModal() { if (modal) modal.classList.remove('open'); }

            if (btnOpen) btnOpen.addEventListener('click', openModal);
            if (btnClose) btnClose.addEventListener('click', closeModal);
            if (btnBatal) btnBatal.addEventListener('click', closeModal);

            if (modal) {
                modal.addEventListener('click', function (e) {
                    if (e.target === modal) closeModal();
                });
            }

            if (fileDropArea && fileInput) {
                fileDropArea.addEventListener('click', function () { fileInput.click(); });
                fileInput.addEventListener('change', function () {
                    if (fileInput.files && fileInput.files.length > 0) {
                        fileNameDisplay.style.display = 'block';
                        fileNameDisplay.textContent = fileInput.files[0].name;
                    } else {
                        fileNameDisplay.style.display = 'none';
                        fileNameDisplay.textContent = '';
                    }
                });
            }
        })();
    </script>
</body>
</html>