<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Permintaan Bahan - Admin</title>
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
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; }

        html, body {
            height: 100%;
            background: var(--background);
            color: var(--text-dark);
        }

        body {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        .main-wrapper {
            flex: 1;
            min-width: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            background: #ffffff;
            overflow: hidden;
        }

        .topbar {
            height: 70px; min-height: 70px; background: #ffffff;
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 28px; flex-shrink: 0; z-index: 100;
        }
        .topbar-left { display: flex; align-items: center; gap: 14px; }
        .menu-toggle {
            width: 38px; height: 38px; display: inline-flex; align-items: center; justify-content: center;
            border: none; background: transparent; color: #757575; font-size: 21px; cursor: pointer; border-radius: 6px;
        }
        .menu-toggle:hover { background: #f5f5f5; }
        .topbar-title { font-size: 20px; font-weight: 700; color: #111111; }
        .topbar-right { display: flex; align-items: center; gap: 20px; }

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
            text-decoration: none; color: var(--text-dark); cursor: pointer;
        }
        .user-avatar {
            width: 36px; height: 36px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            background: #111; color: white; font-size: 16px; overflow: hidden;
        }
        .user-avatar img { width: 100%; height: 100%; object-fit: cover; }

        .content-area {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 30px 40px 60px;
            width: 100%;
            max-width: none;
        }

        .back-link {
            display: inline-block; color: var(--primary); text-decoration: none;
            font-size: 13px; font-weight: 600; margin-bottom: 15px;
        }

        .page-header h1 { font-size: 20px; font-weight: 700; margin-bottom: 4px; }
        .page-header p { color: var(--text-muted); font-size: 13px; margin-bottom: 22px; }

        .section-card {
            border: 1px solid var(--border); border-radius: 12px;
            padding: 24px; margin-bottom: 22px; background: #ffffff;
        }
        .section-header {
            display: flex; align-items: center; gap: 12px; margin-bottom: 20px;
        }
        .circle-num {
            width: 28px; height: 28px; background: var(--primary); color: white;
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 14px; flex-shrink: 0;
        }
        .section-header h2 { font-size: 15px; font-weight: 700; }

        .form-group { margin-bottom: 16px; }
        .form-group label {
            display: block; font-size: 13px; font-weight: 600;
            color: #333; margin-bottom: 7px;
        }
        .form-group label .required { color: #c62828; }

        .form-control {
            width: 100%; height: 42px; padding: 0 14px;
            border: 1px solid var(--border); border-radius: 7px;
            font-size: 13px; color: #333; outline: none; background: #fff;
        }
        .form-control:focus { border-color: var(--primary); }
        select.form-control { cursor: pointer; }

        .form-row {
            display: grid; grid-template-columns: 1fr 1fr; gap: 16px;
        }

        .file-upload {
            border: 1.5px dashed #c7c7c7; border-radius: 8px;
            padding: 28px 16px; text-align: center; background: #fafafa;
            cursor: pointer; transition: 0.2s;
        }
        .file-upload:hover { border-color: var(--primary); background: #fff5f5; }
        .file-upload input[type="file"] { display: none; }
        .file-upload i { font-size: 22px; color: #999; margin-bottom: 8px; display: block; }
        .file-upload-text { font-size: 13px; color: #888; }
        .file-upload-name {
            font-size: 13px; color: var(--primary); font-weight: 600;
            margin-top: 8px; display: none;
        }

        .info-box {
            background: #e3f2fd; border: 1px solid #90caf9;
            border-radius: 8px; padding: 12px 14px;
            font-size: 12px; color: #1565c0; line-height: 1.5;
            margin-top: 14px;
        }

        .info-box-warning {
            background: #fff8e1; border: 1px solid #ffcc80;
            border-radius: 8px; padding: 12px 14px;
            font-size: 13px; color: #e65100; line-height: 1.5;
            margin-bottom: 22px;
            display: flex; align-items: center; gap: 10px;
        }

        .form-actions {
            display: flex; justify-content: flex-end; gap: 12px;
            margin-top: 8px; padding-top: 10px;
        }

        .btn-batal, .btn-kembali {
            background: #fff; border: 1px solid var(--border); color: #555;
            padding: 11px 22px; border-radius: 7px; font-size: 13px;
            font-weight: 600; cursor: pointer; text-decoration: none;
            display: inline-flex; align-items: center; gap: 6px;
        }
        .btn-batal:hover, .btn-kembali:hover { background: #f5f5f5; }

        .btn-submit, .btn-ringkasan {
            background: var(--primary); border: none; color: white;
            padding: 11px 22px; border-radius: 7px; font-size: 13px;
            font-weight: 600; cursor: pointer;
        }
        .btn-submit:hover, .btn-ringkasan:hover { background: var(--primary-hover); }

        .ringkasan-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px 40px;
        }
        .ringkasan-item label {
            display: block;
            font-size: 12px;
            color: var(--text-muted);
            margin-bottom: 4px;
        }
        .ringkasan-item .value {
            font-size: 14px;
            font-weight: 700;
            color: #222;
            line-height: 1.4;
        }

        .step-form { display: block; }
        .step-ringkasan { display: none; }

        @media (max-width: 650px) {
            .content-area { padding: 20px 14px 40px; }
            .form-row, .ringkasan-grid { grid-template-columns: 1fr; }
            .form-actions { flex-direction: column-reverse; }
            .btn-batal, .btn-kembali, .btn-submit, .btn-ringkasan {
                width: 100%; justify-content: center;
            }
        }
    </style>
</head>
<body>

    @php
        $isManual = str_contains(request()->path(), 'manual');
        $routeStore = $isManual ? route('admin.manual.permintaan-bahan.store') : route('admin.digital.permintaan-bahan.store');
        $routeIndex = $isManual ? route('admin.manual.permintaan-bahan') : route('admin.digital.permintaan-bahan');
        $divisiNama = $isManual ? 'Literasi Manual' : 'Literasi Digital';
        $profileRoute = $isManual ? route('admin.manual.profile') : route('admin.digital.profile');
    @endphp

    @if($isManual)
        @include('partials.admin-manual-nav', ['activeMenu' => $activeMenu ?? 'profile'])
    @else
        {{-- Jika pakai partial digital, sesuaikan atau biarkan navigasi Anda --}}
    @endif

    <div class="main-wrapper">
        <div class="topbar">
            <div class="topbar-left">
                <button type="button" class="menu-toggle">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="topbar-title">Ajukan Permintaan Bahan</div>
            </div>
            <div class="topbar-right">
                <div class="notification-button">
                    <i class="far fa-bell"></i>
                    <span class="notification-dot"></span>
                </div>
                <a href="{{ $profileRoute }}" class="topbar-user">
                    <span style="font-weight: 700; font-size: 15px;">
                        {{ auth()->user()->nama ?? 'Admin' }}
                    </span>
                    <div class="user-avatar">
                        @if(auth()->user()->foto_profil)
                            <img src="{{ auth()->user()->foto_profil }}" alt="Profile">
                        @else
                            <i class="fas fa-user"></i>
                        @endif
                    </div>
                </a>
            </div>
        </div>

        <main class="content-area">
            <a href="{{ $routeIndex }}" class="back-link" id="linkKembaliList">&larr; Kembali</a>

            <div class="page-header">
                <h1>Ajukan Permintaan Bahan</h1>
                <p>Ajukan kebutuhan bahan yang diperlukan untuk mendukung proses pencetakan buku braille.</p>
            </div>

            <form method="POST" action="{{ $routeStore }}" enctype="multipart/form-data" id="formAjukan">
                @csrf

                {{-- ========== STEP 1: FORM ========== --}}
                <div class="step-form" id="stepForm">

                    <div class="section-card">
                        <div class="section-header">
                            <div class="circle-num">1</div>
                            <h2>Informasi Pencetakan</h2>
                        </div>
                        <div class="form-group">
                            <label>Id Pencetakan <span class="required">*</span></label>
                            <select name="pencetakan_id" id="inputPencetakan" class="form-control" required>
                                <option value="">--Pilih Pekerjaan Pencetakan--</option>
                                @foreach($daftarPencetakan ?? [] as $p)
                                    <option value="{{ $p->id }}"
                                        data-kode="{{ $p->kode_cetak ?? ('PRNT-' . $p->id) }}"
                                        data-buku="{{ $p->buku->judul ?? '-' }}">
                                        {{ $p->kode_cetak ?? ('PRNT-' . $p->id) }}
                                        @if($p->buku) — {{ $p->buku->judul }} @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="section-card">
                        <div class="section-header">
                            <div class="circle-num">2</div>
                            <h2>Informasi Bahan</h2>
                        </div>
                        <div class="form-group">
                            <label>Nama Bahan <span class="required">*</span></label>
                            <input type="text" name="nama_bahan" id="inputNamaBahan" class="form-control" placeholder="Contoh: Kertas Braille" required value="{{ old('nama_bahan') }}">
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Jumlah <span class="required">*</span></label>
                                <input type="number" name="jumlah" id="inputJumlah" class="form-control" placeholder="Contoh: 10" min="1" required value="{{ old('jumlah') }}">
                            </div>
                            <div class="form-group">
                                <label>Satuan <span class="required">*</span></label>
                                <select name="satuan" id="inputSatuan" class="form-control" required>
                                    <option value="">--Pilih Satuan--</option>
                                    <option value="Rim">Rim</option>
                                    <option value="Lembar">Lembar</option>
                                    <option value="Buah">Buah</option>
                                    <option value="Pack">Pack</option>
                                    <option value="Kg">Kg</option>
                                    <option value="Roll">Roll</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Tujuan Penggunaan <span class="required">*</span></label>
                            <input type="text" name="keperluan" id="inputKeperluan" class="form-control" placeholder="Contoh: untuk pencetakan buku braille" required value="{{ old('keperluan') }}">
                        </div>
                    </div>

                    <div class="section-card">
                        <div class="section-header">
                            <div class="circle-num">3</div>
                            <h2>Dokumen Surat Pengajuan</h2>
                        </div>
                        <div class="form-group">
                            <label>Upload Surat Dokumen <span class="required">*</span></label>
                            <div class="file-upload" id="fileDropArea">
                                <input type="file" name="surat_dokumen" id="inputSurat" accept=".pdf,.doc,.docx" required>
                                <i class="fas fa-cloud-upload-alt"></i>
                                <div class="file-upload-text">Pilih file surat (PDF/DOC/DOCX)</div>
                                <div class="file-upload-name" id="fileNameDisplay"></div>
                            </div>
                        </div>
                        <div class="info-box">
                            Informasi: Surat pengajuan akan diperiksa terlebih dahulu oleh Admin Pengiriman sebelum diteruskan ke proses tanda tangan.
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="{{ $routeIndex }}" class="btn-batal">Batal</a>
                        <button type="button" class="btn-ringkasan" id="btnLihatRingkasan">Lihat Ringkasan</button>
                    </div>
                </div>

                {{-- ========== STEP 2: RINGKASAN ========== --}}
                <div class="step-ringkasan" id="stepRingkasan">

                    <div class="info-box-warning">
                        <i class="fas fa-info-circle"></i>
                        Periksa ringkasan sebelum mengirim pengajuan.
                    </div>

                    <div class="section-card">
                        <div class="section-header">
                            <div class="circle-num">4</div>
                            <h2>Ringkasan Permintaan</h2>
                        </div>

                        <div class="ringkasan-grid">
                            <div class="ringkasan-item">
                                <label>Divisi Pengaju</label>
                                <div class="value">{{ $divisiNama }}</div>
                            </div>
                            <div class="ringkasan-item">
                                <label>PIC</label>
                                <div class="value" id="rPic">{{ auth()->user()->nama ?? '-' }}</div>
                            </div>
                            <div class="ringkasan-item">
                                <label>Tanggal Pengajuan</label>
                                <div class="value" id="rTanggal">{{ now()->translatedFormat('d F Y') }}</div>
                            </div>
                            <div class="ringkasan-item">
                                <label>Id Pencetakan</label>
                                <div class="value" id="rIdPencetakan">-</div>
                            </div>
                            <div class="ringkasan-item">
                                <label>Nama Buku</label>
                                <div class="value" id="rNamaBuku">-</div>
                            </div>
                            <div class="ringkasan-item">
                                <label>Nama Bahan</label>
                                <div class="value" id="rNamaBahan">-</div>
                            </div>
                            <div class="ringkasan-item">
                                <label>Jumlah</label>
                                <div class="value" id="rJumlah">-</div>
                            </div>
                            <div class="ringkasan-item">
                                <label>Tujuan Penggunaan</label>
                                <div class="value" id="rKeperluan">-</div>
                            </div>
                            <div class="ringkasan-item">
                                <label>Dokumen Surat</label>
                                <div class="value" id="rDokumen">-</div>
                            </div>
                        </div>
                    </div>

                    <div class="info-box" style="margin-bottom: 22px;">
                        Setelah dikirim, status permintaan akan menjadi <strong>Menunggu Pemeriksaan</strong> dan akan diperiksa oleh Admin Pengiriman.
                    </div>

                    <div class="form-actions" style="justify-content: space-between;">
                        <button type="button" class="btn-kembali" id="btnKembaliForm">
                            &larr; Kembali ke Form
                        </button>
                        <button type="submit" class="btn-submit">Ajukan Permintaan</button>
                    </div>
                </div>

            </form>
        </main>
    </div>

    <script>
        (function () {
            var stepForm = document.getElementById('stepForm');
            var stepRingkasan = document.getElementById('stepRingkasan');
            var btnLihat = document.getElementById('btnLihatRingkasan');
            var btnKembali = document.getElementById('btnKembaliForm');

            var inputPencetakan = document.getElementById('inputPencetakan');
            var inputNamaBahan = document.getElementById('inputNamaBahan');
            var inputJumlah = document.getElementById('inputJumlah');
            var inputSatuan = document.getElementById('inputSatuan');
            var inputKeperluan = document.getElementById('inputKeperluan');
            var inputSurat = document.getElementById('inputSurat');
            var fileDropArea = document.getElementById('fileDropArea');
            var fileNameDisplay = document.getElementById('fileNameDisplay');

            if (fileDropArea && inputSurat) {
                fileDropArea.addEventListener('click', function () { inputSurat.click(); });
                inputSurat.addEventListener('change', function () {
                    if (inputSurat.files && inputSurat.files.length > 0) {
                        fileNameDisplay.style.display = 'block';
                        fileNameDisplay.textContent = inputSurat.files[0].name;
                    } else {
                        fileNameDisplay.style.display = 'none';
                        fileNameDisplay.textContent = '';
                    }
                });
            }

            if (btnLihat) {
                btnLihat.addEventListener('click', function () {
                    var form = document.getElementById('formAjukan');
                    if (!form.checkValidity()) {
                        form.reportValidity();
                        return;
                    }

                    var opt = inputPencetakan.options[inputPencetakan.selectedIndex];
                    var kode = opt.getAttribute('data-kode') || '-';
                    var buku = opt.getAttribute('data-buku') || '-';

                    document.getElementById('rIdPencetakan').textContent = kode;
                    document.getElementById('rNamaBuku').textContent = buku;
                    document.getElementById('rNamaBahan').textContent = inputNamaBahan.value || '-';
                    document.getElementById('rJumlah').textContent =
                        (inputJumlah.value || '-') + ' ' + (inputSatuan.value || '');
                    document.getElementById('rKeperluan').textContent = inputKeperluan.value || '-';
                    document.getElementById('rDokumen').textContent =
                        (inputSurat.files && inputSurat.files[0])
                            ? inputSurat.files[0].name
                            : '-';

                    stepForm.style.display = 'none';
                    stepRingkasan.style.display = 'block';
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
            }

            if (btnKembali) {
                btnKembali.addEventListener('click', function () {
                    stepRingkasan.style.display = 'none';
                    stepForm.style.display = 'block';
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
            }
        })();
    </script>
</body>
</html>