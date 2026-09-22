<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Permintaan Bahan - Admin Literasi Digital</title>
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
        html, body { background: var(--background); color: var(--text-dark); min-height: 100vh; overflow-y: auto !important; }
        body { display: flex; }

        .main-wrapper { flex: 1; display: flex; flex-direction: column; background: #ffffff; min-width: 0; min-height: 100vh; }

        .topbar {
            height: 70px; min-height: 70px; background: #ffffff;
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 28px; position: sticky; top: 0; z-index: 100;
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

        .content-area { padding: 30px 40px 60px; max-width: 720px; width: 100%; }

        .back-link {
            display: inline-block; color: var(--primary); text-decoration: none;
            font-size: 13px; font-weight: 600; margin-bottom: 15px;
        }

        .page-header h1 { font-size: 20px; font-weight: 700; margin-bottom: 4px; }
        .page-header p { color: var(--text-muted); font-size: 13px; margin-bottom: 28px; }

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

        .form-actions {
            display: flex; justify-content: flex-end; gap: 12px;
            margin-top: 8px; padding-top: 10px;
        }

        .btn-batal {
            background: #fff; border: 1px solid var(--border); color: #555;
            padding: 11px 22px; border-radius: 7px; font-size: 13px;
            font-weight: 600; cursor: pointer; text-decoration: none;
            display: inline-flex; align-items: center;
        }
        .btn-batal:hover { background: #f5f5f5; }

        .btn-submit {
            background: var(--primary); border: none; color: white;
            padding: 11px 22px; border-radius: 7px; font-size: 13px;
            font-weight: 600; cursor: pointer;
        }
        .btn-submit:hover { background: var(--primary-hover); }

        @media (max-width: 650px) {
            .content-area { padding: 20px 14px 40px; }
            .form-row { grid-template-columns: 1fr; }
            .form-actions { flex-direction: column-reverse; }
            .btn-batal, .btn-submit { width: 100%; justify-content: center; }
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
                <div class="topbar-title">Ajukan Permintaan Bahan</div>
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
                            <img src="{{ auth()->user()->foto_profil }}" alt="Profile">
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
                <h1>Ajukan Permintaan Bahan</h1>
                <p>Ajukan kebutuhan bahan yang diperlukan untuk mendukung proses pencetakan buku braille.</p>
            </div>

            <form method="POST" action="{{ route('admin.digital.permintaan-bahan.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="section-card">
                    <div class="section-header">
                        <div class="circle-num">1</div>
                        <h2>Informasi Pencetakan</h2>
                    </div>

                    <div class="form-group">
                        <label>Id Pencetakan <span class="required">*</span></label>
                        <select name="pencetakan_id" class="form-control" required>
                            <option value="">--Pilih Pekerjaan Pencetakan--</option>
                            @foreach($daftarPencetakan ?? [] as $p)
                                <option value="{{ $p->id }}">
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
                        <input type="text" name="nama_bahan" class="form-control" placeholder="Contoh: Kertas Braille" required value="{{ old('nama_bahan') }}">
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Jumlah <span class="required">*</span></label>
                            <input type="number" name="jumlah" class="form-control" placeholder="Contoh: 10" min="1" required value="{{ old('jumlah') }}">
                        </div>
                        <div class="form-group">
                            <label>Satuan <span class="required">*</span></label>
                            <select name="satuan" class="form-control" required>
                                <option value="">--Pilih Satuan--</option>
                                <option value="Rim" {{ old('satuan') == 'Rim' ? 'selected' : '' }}>Rim</option>
                                <option value="Lembar" {{ old('satuan') == 'Lembar' ? 'selected' : '' }}>Lembar</option>
                                <option value="Buah" {{ old('satuan') == 'Buah' ? 'selected' : '' }}>Buah</option>
                                <option value="Pack" {{ old('satuan') == 'Pack' ? 'selected' : '' }}>Pack</option>
                                <option value="Kg" {{ old('satuan') == 'Kg' ? 'selected' : '' }}>Kg</option>
                                <option value="Roll" {{ old('satuan') == 'Roll' ? 'selected' : '' }}>Roll</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Tujuan Penggunaan <span class="required">*</span></label>
                        <input type="text" name="keperluan" class="form-control" placeholder="Contoh: untuk pencetakan buku braille" required value="{{ old('keperluan') }}">
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
                    <a href="{{ route('admin.digital.permintaan-bahan') }}" class="btn-batal">Batal</a>
                    <button type="submit" class="btn-submit">Ajukan Permintaan</button>
                </div>
            </form>
        </main>
    </div>

    <script>
        (function () {
            var fileInput = document.getElementById('inputSurat');
            var fileDropArea = document.getElementById('fileDropArea');
            var fileNameDisplay = document.getElementById('fileNameDisplay');

            if (fileDropArea && fileInput) {
                fileDropArea.addEventListener('click', function () {
                    fileInput.click();
                });

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