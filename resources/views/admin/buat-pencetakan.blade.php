<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Permintaan Pencetakan - BrailleKita</title>
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
            --warning-bg: #fff8e1;
            --warning-border: #ffe082;
            --warning-text: #e65100;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: sans-serif; background: var(--background); color: var(--text-dark); }

        .menu-toggle {
            display: inline-flex; align-items: center; justify-content: center;
            width: 24px; height: 24px; color: var(--text-muted);
            background: none; border: none; cursor: pointer; font-size: 20px;
        }
        .topbar-title {
            font-size: 20px; font-weight: 900; font-family: 'Georgia', serif;
            color: var(--text-dark); margin-left: 10px;
        }
        .content-area { padding: 32px; flex-grow: 1; overflow-y: auto; }

        .page-header { margin-bottom: 20px; }
        .page-header h2 { font-size: 20px; font-weight: 700; margin-bottom: 4px; }
        .page-header p { color: var(--text-muted); font-size: 13px; }

        .back-link {
            display: inline-flex; align-items: center; gap: 6px;
            color: var(--primary); font-weight: 700; font-size: 14px;
            text-decoration: none; margin-bottom: 16px;
        }
        .back-link:hover { text-decoration: underline; }

        .form-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 28px;
            max-width: 720px;
        }

        .step-title {
            font-size: 15px; font-weight: 700;
            margin-bottom: 16px; display: flex; align-items: center; gap: 10px;
        }
        .step-number {
            width: 26px; height: 26px; border-radius: 50%;
            background: var(--primary); color: white;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 13px; font-weight: 700;
        }

        .form-section { margin-bottom: 28px; }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 16px;
        }
        .form-group { margin-bottom: 16px; }

        label {
            display: block; font-size: 13px; font-weight: 700;
            margin-bottom: 6px; color: var(--text-dark);
        }
        label .required { color: var(--primary); }

        .form-control, select.form-control, textarea.form-control {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            background: white;
            outline: none;
        }
        .form-control:focus { border-color: var(--primary); }
        .form-control:disabled, .form-control[readonly] {
            background: #f5f5f5; color: var(--text-muted);
        }
        textarea.form-control { min-height: 80px; resize: vertical; }

        .form-actions {
            display: flex; justify-content: flex-end; gap: 12px;
            margin-top: 28px; padding-top: 20px;
            border-top: 1px solid var(--border);
        }
        .btn {
            padding: 10px 20px; border-radius: 8px;
            font-size: 14px; font-weight: 700; font-family: inherit;
            cursor: pointer; border: none; text-decoration: none;
            display: inline-flex; align-items: center; justify-content: center;
        }
        .btn-secondary {
            background: white; border: 1px solid var(--border); color: var(--text-dark);
        }
        .btn-secondary:hover { background: #f5f5f5; }
        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover { background: var(--primary-hover); }

        .alert-warning {
            background: var(--warning-bg);
            border: 1px solid var(--warning-border);
            color: var(--warning-text);
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px 24px;
            margin-bottom: 20px;
        }
        .summary-item label {
            font-size: 12px; color: var(--text-muted); font-weight: 600; margin-bottom: 2px;
        }
        .summary-item .value { font-size: 14px; font-weight: 700; }

        .info-box {
            background: #e3f2fd;
            border: 1px solid #90caf9;
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 13px;
            color: #1565c0;
            margin-bottom: 20px;
        }

        .hidden { display: none !important; }

        @media (max-width: 700px) {
            .form-row, .summary-grid { grid-template-columns: 1fr; }
            .content-area { padding: 20px 16px; }
            .form-actions { flex-direction: column-reverse; }
            .btn { width: 100%; text-align: center; }
        }
    </style>
</head>
<body>
    @include('partials.admin-nav', ['activeMenu' => 'pencetakan'])

    <div class="main-wrapper">
        <header class="topbar">
            <div class="topbar-left">
                <button type="button" class="menu-toggle"><i class="fas fa-bars"></i></button>
                <span class="topbar-title">Pencetakan</span>
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
            <a href="/admin/pencetakan" class="back-link">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>

            <div class="page-header">
                <h2>Buat Permintaan Pencetakan</h2>
                <p>Buat permintaan pencetakan Buku Braille yang belum tersedia atau belum mencukupi untuk memenuhi pesanan pelanggan.</p>
            </div>

            <form id="formPencetakan" method="POST" action="/admin/pencetakan">
                @csrf

                {{-- STEP 1: FORM --}}
                <div id="step1" class="form-card">
                    <div class="form-section">
                        <div class="step-title">
                            <span class="step-number">1</span> Informasi Pesanan
                        </div>

                        <div class="form-group">
                            <label>Nomor Pesanan <span class="required">*</span></label>
                            <select name="pesanan_id" id="pesanan_id" class="form-control" required>
                                <option value="">-- Pilih Nomor Pesanan --</option>
                                @foreach($daftarPesanan ?? [] as $p)
                                    <option value="{{ $p->id }}"
                                        data-nama="{{ $p->nama_penerima ?? $p->user->nama ?? '-' }}"
                                        data-jenis="{{ $p->jenis_pesanan ?? '-' }}"
                                        data-alamat="{{ $p->alamat ?? $p->user->alamat ?? '-' }}">
                                        {{ $p->nomor_pesanan ?? 'ORD-'.$p->id }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Nama Pelanggan</label>
                                <input type="text" id="nama_pelanggan" class="form-control" readonly placeholder="Otomatis terisi">
                            </div>
                            <div class="form-group">
                                <label>Jenis Pemesan</label>
                                <input type="text" id="jenis_pemesan" class="form-control" readonly placeholder="Otomatis terisi">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Alamat Pelanggan</label>
                            <input type="text" id="alamat_pelanggan" class="form-control" readonly placeholder="Otomatis terisi setelah pesanan dipilih">
                        </div>
                    </div>

                    <div class="form-section">
                        <div class="step-title">
                            <span class="step-number">2</span> Informasi Buku
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Nama Buku <span class="required">*</span></label>
                                <select name="buku_id" id="buku_id" class="form-control" required>
                                    <option value="">-- Pilih Nama Buku --</option>
                                    @foreach($daftarBuku ?? [] as $b)
                                        <option value="{{ $b->id }}" data-kategori="{{ $b->kategori }}">
                                            {{ $b->judul }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Kategori Buku</label>
                                <input type="text" id="kategori_buku" class="form-control" readonly placeholder="Otomatis terisi">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Jumlah yang Dibutuhkan <span class="required">*</span></label>
                            <div style="display:flex; align-items:center; gap:10px;">
                                <input type="number" name="jumlah" id="jumlah" class="form-control" min="1" value="1" required style="max-width:120px;">
                                <span style="font-size:14px; color:var(--text-muted);">Eksemplar</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Catatan Pencetakan</label>
                            <textarea name="catatan" id="catatan" class="form-control" placeholder="Contoh: Mohon dibuat sesuai format Braille yang digunakan Sentra Wyata Guna"></textarea>
                        </div>
                    </div>

                    <div class="form-section">
                        <div class="step-title">
                            <span class="step-number">3</span> Pilih Divisi Pencetakan
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Divisi Pencetakan <span class="required">*</span></label>
                                <select name="divisi" id="divisi" class="form-control" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="Literasi Manual">Literasi Manual</option>
                                    <option value="Literasi Digital">Literasi Digital</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Target Selesai <span class="required">*</span></label>
                                <input type="date" name="target_selesai" id="target_selesai" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>PIC <span class="required">*</span></label>
                                <select name="pic" id="pic" class="form-control" required>
                                    <option value="">-- Pilih PIC --</option>
                                    <option value="Devi Kusuma">Devi Kusuma</option>
                                    <option value="Budi Santoso">Budi Santoso</option>
                                    <option value="Siti Aminah">Siti Aminah</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Status Prioritas</label>
                                <input type="text" id="prioritas" class="form-control" readonly value="Normal">
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="/admin/pencetakan" class="btn btn-secondary">Batal</a>
                        <button type="button" class="btn btn-primary" id="btnLihatRingkasan">Lihat Ringkasan</button>
                    </div>
                </div>

                {{-- STEP 2: RINGKASAN --}}
                <div id="step2" class="form-card hidden">
                    <div class="alert-warning">
                        Periksa ringkasan sebelum membuat permintaan.
                    </div>

                    <div class="step-title" style="margin-bottom:20px;">
                        <span class="step-number">4</span> Ringkasan Permintaan
                    </div>

                    <div class="summary-grid">
                        <div class="summary-item">
                            <label>Nomor Pesanan</label>
                            <div class="value" id="sum_nomor">-</div>
                        </div>
                        <div class="summary-item">
                            <label>Nama Pelanggan</label>
                            <div class="value" id="sum_nama">-</div>
                        </div>
                        <div class="summary-item">
                            <label>Jenis Pemesan</label>
                            <div class="value" id="sum_jenis">-</div>
                        </div>
                        <div class="summary-item">
                            <label>Nama Buku</label>
                            <div class="value" id="sum_buku">-</div>
                        </div>
                        <div class="summary-item">
                            <label>Kategori Buku</label>
                            <div class="value" id="sum_kategori">-</div>
                        </div>
                        <div class="summary-item">
                            <label>Jumlah</label>
                            <div class="value" id="sum_jumlah">-</div>
                        </div>
                        <div class="summary-item">
                            <label>Divisi Pencetakan</label>
                            <div class="value" id="sum_divisi">-</div>
                        </div>
                        <div class="summary-item">
                            <label>Literasi/Manual</label>
                            <div class="value" id="sum_literasi">-</div>
                        </div>
                        <div class="summary-item">
                            <label>PIC</label>
                            <div class="value" id="sum_pic">-</div>
                        </div>
                        <div class="summary-item">
                            <label>Target Selesai</label>
                            <div class="value" id="sum_target">-</div>
                        </div>
                        <div class="summary-item">
                            <label>Prioritas</label>
                            <div class="value" id="sum_prioritas">-</div>
                        </div>
                    </div>

                    <div class="info-box">
                        Setelah dibuat, pekerjaan akan otomatis muncul di menu Pencetakan dan di dashboard Literasi Manual.<br>
                        Status awal: <strong>Menunggu Diproses</strong>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" id="btnKembaliForm">← Kembali ke Form</button>
                        <button type="submit" class="btn btn-primary">Buat Permintaan Pencetakan</button>
                    </div>
                </div>
            </form>
        </main>
    </div>

    {{-- POPUP SUKSES --}}
    <div id="successModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.45); align-items:center; justify-content:center; z-index:9999;">
        <div style="background:white; border-radius:16px; padding:32px 28px 24px; text-align:center; width:90%; max-width:340px; box-shadow:0 12px 40px rgba(0,0,0,0.2);">
            <div style="width:80px; height:80px; margin:0 auto 16px; border-radius:50%; border:3px solid #c62828; display:flex; align-items:center; justify-content:center;">
                <i class="fas fa-check" style="font-size:36px; color:#2e7d32;"></i>
            </div>
            <h3 style="font-size:22px; font-weight:700; margin-bottom:8px;">Berhasil!</h3>
            <p style="font-size:14px; color:#757575; margin-bottom:20px;">Permintaan pencetakan baru berhasil dibuat.</p>
            <button type="button" id="btnModalKembali" class="btn btn-primary" style="min-width:120px;">Kembali</button>
        </div>
    </div>

    <script>
        document.getElementById('pesanan_id').addEventListener('change', function () {
            const opt = this.options[this.selectedIndex];
            document.getElementById('nama_pelanggan').value = opt.dataset.nama || '';
            document.getElementById('jenis_pemesan').value = opt.dataset.jenis || '';
            document.getElementById('alamat_pelanggan').value = opt.dataset.alamat || '';
        });

        document.getElementById('buku_id').addEventListener('change', function () {
            const opt = this.options[this.selectedIndex];
            document.getElementById('kategori_buku').value = opt.dataset.kategori || '';
        });

        document.getElementById('btnLihatRingkasan').addEventListener('click', function () {
            const form = document.getElementById('formPencetakan');
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            const pesananOpt = document.getElementById('pesanan_id').options[document.getElementById('pesanan_id').selectedIndex];
            const bukuOpt = document.getElementById('buku_id').options[document.getElementById('buku_id').selectedIndex];
            const divisi = document.getElementById('divisi').value;
            const target = document.getElementById('target_selesai').value;

            document.getElementById('sum_nomor').textContent = pesananOpt.text;
            document.getElementById('sum_nama').textContent = document.getElementById('nama_pelanggan').value || '-';
            document.getElementById('sum_jenis').textContent = document.getElementById('jenis_pemesan').value || '-';
            document.getElementById('sum_buku').textContent = bukuOpt.text || '-';
            document.getElementById('sum_kategori').textContent = document.getElementById('kategori_buku').value || '-';
            document.getElementById('sum_jumlah').textContent = (document.getElementById('jumlah').value || '0') + ' eksemplar';
            document.getElementById('sum_divisi').textContent = divisi || '-';
            document.getElementById('sum_literasi').textContent = divisi || '-';
            document.getElementById('sum_pic').textContent = document.getElementById('pic').value || '-';
            document.getElementById('sum_target').textContent = target
                ? new Date(target).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })
                : '-';
            document.getElementById('sum_prioritas').textContent = document.getElementById('prioritas').value || 'Normal';

            document.getElementById('step1').classList.add('hidden');
            document.getElementById('step2').classList.remove('hidden');
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        document.getElementById('btnKembaliForm').addEventListener('click', function () {
            document.getElementById('step2').classList.add('hidden');
            document.getElementById('step1').classList.remove('hidden');
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // Popup sukses
        document.getElementById('formPencetakan').addEventListener('submit', function (e) {
            e.preventDefault();
            document.getElementById('successModal').style.display = 'flex';
        });

        document.getElementById('btnModalKembali').addEventListener('click', function () {
            window.location.href = '/admin/pencetakan';
        });
    </script>

    {{-- POPUP SUKSES --}}
    <div id="successModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.45); align-items:center; justify-content:center; z-index:9999;">
        <div style="background:white; border-radius:16px; padding:32px 28px 24px; text-align:center; width:90%; max-width:340px; box-shadow:0 12px 40px rgba(0,0,0,0.2);">
            <div style="width:80px; height:80px; margin:0 auto 16px; border-radius:50%; border:3px solid #c62828; display:flex; align-items:center; justify-content:center;">
                <i class="fas fa-check" style="font-size:36px; color:#2e7d32;"></i>
            </div>
            <h3 style="font-size:22px; font-weight:700; margin-bottom:8px;">Berhasil!</h3>
            <p style="font-size:14px; color:#757575; margin-bottom:20px;">Permintaan pencetakan baru berhasil dibuat.</p>
            <button type="button" id="btnModalKembali" class="btn btn-primary" style="min-width:120px;">Kembali</button>
        </div>
    </div>
</body>
</html>