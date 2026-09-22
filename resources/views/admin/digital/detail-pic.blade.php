<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail PIC - Admin Literasi Digital</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    @include('partials.admin-digital-nav')

    <div class="main-wrapper">
        <header class="topbar">
            <div class="topbar-left">
                <button type="button" class="menu-toggle"><i class="fas fa-bars"></i></button>
                <span class="page-title">Detail PIC</span>
            </div>
            
            <div class="topbar-right">
                <!-- Ikon Notifikasi dengan Titik Merah -->
                <div class="notification-button">
                    <i class="far fa-bell"></i>
                    <span class="notification-dot"></span>
                </div>
                
                <!-- Profil Pengguna -->
                <a href="{{ route('admin.profile') }}" style="display: flex; align-items: center; gap: 12px; text-decoration: none; color: var(--text-dark); cursor: pointer;">
                    <span style="font-weight: 700; font-size: 15px;">
                        {{ auth()->user()->nama ?? 'Admin Digital' }}
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

        <main class="content">
            <a href="{{ route('admin.digital.pic') }}" class="btn-back">
                &larr; Kembali
            </a>

            <!-- SECTION 1: Informasi PIC -->
            <div class="section-container">
                <div class="section-title">
                    <div class="circle-badge">1</div>
                    <h2>Informasi PIC</h2>
                </div>
                <div class="info-card">
                    <div class="info-row">
                        <span class="info-label">Nama PIC</span>
                        <span class="info-value">: {{ $data['nama'] ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Status</span>
                        <span class="info-value text-success">: {{ $data['status'] ?? 'Aktif' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Jabatan</span>
                        <span class="info-value">: {{ $data['jabatan'] ?? 'Staf Literasi Digital' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Keterangan</span>
                        <span class="info-value">: {{ $data['keterangan'] ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Nomor Telpon</span>
                        <span class="info-value">: {{ $data['nomor_telepon'] ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <!-- SECTION 2: Daftar Kerjaan -->
            <div class="section-container">
                <div class="section-title">
                    <div class="circle-badge">2</div>
                    <h2>Daftar Kerjaan</h2>
                </div>
                
                <div class="table-container-wrapper">
                    <!-- Toolbar (Pilih Kerjaan & Alihkan) -->
                    <div class="table-toolbar">
                        <button type="button" class="btn-pilih-kerjaan" id="btnPilihKerjaan">
                            <i class="fas fa-filter"></i> Pilih kerjaan
                        </button>
                        <button type="button" class="btn-alihkan" id="btnAlihkanTrigger" disabled>
                            <i class="fas fa-exchange-alt"></i> Alihkan PIC
                        </button>
                    </div>

                    <div class="table-container">
                        <table class="kerjaan-table" id="kerjaanTable">
                            <thead>
                                <tr>
                                    <th class="col-checkbox"></th>
                                    <th>No</th>
                                    <th>Id Pencetakan</th>
                                    <th>Judul Buku</th>
                                    <th>Jumlah Buku</th>
                                    <th>Deadline</th>
                                    <th>Prioritas</th>
                                    <th>Status</th>
                                    <th>Alihkan Kepada</th>
                                    <th>Alasan Pengalihan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($daftarKerjaan ?? [] as $index => $kerjaan)
                                    <tr>
                                        <td class="col-checkbox">
                                            <label class="custom-checkbox">
                                                <input type="checkbox" class="row-checkbox" 
                                                    value="{{ $kerjaan->id }}"
                                                    data-kode="{{ $kerjaan->kode_cetak ?? '-' }}"
                                                    data-judul="{{ $kerjaan->buku->judul ?? '-' }}"
                                                    data-jumlah="{{ $kerjaan->target_buku ?? $kerjaan->jumlah ?? 0 }}"
                                                    data-status="{{ $kerjaan->status ?? 'Menunggu diproses' }}">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $kerjaan->kode_cetak ?? '-' }}</td>
                                        <td>{{ $kerjaan->buku->judul ?? '-' }}</td>
                                        <td>{{ $kerjaan->target_buku ?? $kerjaan->jumlah ?? 0 }}</td>
                                        <td>{{ $kerjaan->deadline ? \Carbon\Carbon::parse($kerjaan->deadline)->translatedFormat('d F Y') : '-' }}</td>
                                        <td><span class="badge-normal">{{ $kerjaan->prioritas ?? 'Normal' }}</span></td>
                                        <td><span class="text-red-status">{{ $kerjaan->status ?? '-' }}</span></td>
                                        <td>{{ $kerjaan->alihkan_kepada ?? '-' }}</td>
                                        <td>{{ $kerjaan->alasan_pengalihan ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" style="text-align: center; color: var(--text-muted); padding: 30px;">
                                            Belum ada daftar kerjaan aktif untuk PIC ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- MODAL ALIHKAN PIC -->
    <div class="modal-overlay" id="modalAlihkan">
        <div class="modal-box">
            <div class="modal-header">
                <h3 class="modal-title">Alihkan PIC</h3>
                <button type="button" class="modal-close" id="btnCloseModal">&times;</button>
            </div>
            
            <form action="{{ route('admin.digital.pic.alihkan') }}" method="POST" class="modal-form">
                @csrf
                <!-- Hidden input untuk menampung ID pencetakan yang dipilih -->
                <input type="hidden" name="pencetakan_ids" id="inputPencetakanIds">

                <div class="form-group">
                    <label>PIC saat ini <span class="text-muted-small">(tidak dapat diubah)</span></label>
                    <input type="text" class="form-control" value="{{ $data['nama'] ?? '' }}" readonly style="background: #fafafa; color: #555;">
                </div>

                <div class="form-group">
                    <label>Pekerjaan yang dialihan <span class="text-muted-small">(tidak dapat diubah)</span></label>
                    <!-- Container untuk card pekerjaan dinamis -->
                    <div id="previewPekerjaanContainer" class="preview-container">
                        <!-- Konten akan dirender melalui JS -->
                    </div>
                </div>

                <div class="form-group">
                    <label>Alihkan kepada <span class="text-red">*</span></label>
                    <select name="pic_tujuan" class="form-control custom-select" required>
                        <option value="">--Pilih PIC Tujuan--</option>
                        @foreach($semuaPic ?? [] as $opsiPic)
                            <option value="{{ $opsiPic->nama }}">{{ $opsiPic->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Alasan pengalihan <span class="text-red">*</span></label>
                    <select name="alasan_pengalihan" class="form-control custom-select" required>
                        <option value="">--Pilih Alasan--</option>
                        <option value="PIC sedang sibuk">PIC sedang sibuk</option>
                        <option value="Membagian pekerjaan">Membagian pekerjaan</option>
                        <option value="Kendala Lainnya">Kendala Lainnya</option>
                    </select>
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn-batal" id="btnBatalModal">Batal</button>
                    <button type="submit" class="btn-simpan">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        :root { --primary: #c62828; --primary-hover: #b71c1c; --bg-color: #fcfcfc; --border-color: #eaeaea; --text-main: #111111; --text-muted: #888888; --success: #2e7d32;}
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { display: flex; width: 100%; min-height: 100vh; background-color: var(--bg-color); color: var(--text-main); }
        .main-wrapper { flex: 1; display: flex; flex-direction: column; background-color: #f4f6f9; overflow: hidden;}
        
        .topbar { height: 70px; display: flex; align-items: center; justify-content: space-between; padding: 0 32px; background-color: #ffffff; border-bottom: 1px solid var(--border-color); }
        .topbar-left { display: flex; align-items: center; gap: 16px; }
        .menu-toggle { background: transparent; border: none; font-size: 20px; cursor: pointer; color: var(--text-main); }
        .page-title { font-size: 20px; font-weight: 900; font-family: 'Georgia', serif; }
        
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
        
        .content { flex: 1; padding: 32px 40px; overflow-y: auto; }
        
        .btn-back { display: inline-block; color: var(--primary); font-size: 14px; font-weight: 900; text-decoration: none; margin-bottom: 32px; font-style: italic;}
        .btn-back:hover { text-decoration: underline; }

        .section-container { margin-bottom: 40px; }
        .section-title { display: flex; align-items: center; gap: 12px; margin-bottom: 16px; }
        .circle-badge { width: 32px; height: 32px; background-color: var(--primary); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 16px; }
        .section-title h2 { font-size: 18px; font-weight: 900; }

        /* Card Info */
        .info-card { background: #ffffff; border: 1px solid var(--border-color); border-radius: 12px; padding: 32px; display: grid; grid-template-columns: 1fr 1fr; gap: 24px; row-gap: 32px; }
        .info-row { display: flex; font-size: 14px; }
        .info-label { width: 140px; color: var(--text-muted); font-weight: 600; }
        .info-value { font-weight: 800; color: var(--text-main); }
        .text-success { color: var(--success); }

        /* Table Area */
        .table-container-wrapper { background: #ffffff; border: 1px solid var(--border-color); border-radius: 12px; padding: 24px; }
        .table-toolbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        
        .btn-pilih-kerjaan { background: #ffffff; border: 1px solid var(--border-color); color: var(--text-main); padding: 8px 16px; border-radius: 20px; font-size: 12px; font-weight: 800; cursor: pointer; transition: 0.2s; }
        .btn-pilih-kerjaan:hover { background: #f5f5f5; }
        
        .btn-alihkan { background: var(--primary); color: white; border: none; padding: 10px 20px; border-radius: 8px; font-size: 12px; font-weight: 800; cursor: pointer; transition: 0.2s; }
        .btn-alihkan:disabled { background: #e0e0e0; color: #a1a1a1; cursor: not-allowed; }
        
        .table-container { overflow-x: auto; }
        .kerjaan-table { width: 100%; border-collapse: collapse; min-width: 900px; }
        .kerjaan-table th { background: #f0eeee; padding: 14px; font-size: 12px; font-weight: 900; color: #666; text-align: left; }
        .kerjaan-table td { padding: 16px 14px; font-size: 13px; font-weight: 800; color: #222; border-bottom: 1px solid var(--border-color); }
        .kerjaan-table th.col-checkbox, .kerjaan-table td.col-checkbox { display: none; width: 40px; text-align: center; }
        
        .kerjaan-table.show-checkboxes th.col-checkbox, .kerjaan-table.show-checkboxes td.col-checkbox { display: table-cell; }

        .badge-normal { background: #e0e0e0; padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 800; }
        .text-red-status { color: var(--primary); font-style: italic; }

        /* Custom Checkbox Red */
        .custom-checkbox { position: relative; display: inline-block; width: 20px; height: 20px; cursor: pointer; }
        .custom-checkbox input { opacity: 0; width: 0; height: 0; }
        .checkmark { position: absolute; top: 0; left: 0; height: 20px; width: 20px; background-color: #fff; border: 2px solid #ccc; border-radius: 4px; transition: 0.2s; }
        .custom-checkbox input:checked ~ .checkmark { background-color: var(--primary); border-color: var(--primary); }
        .checkmark:after { content: ""; position: absolute; display: none; left: 6px; top: 2px; width: 5px; height: 10px; border: solid white; border-width: 0 2px 2px 0; transform: rotate(45deg); }
        .custom-checkbox input:checked ~ .checkmark:after { display: block; }

        /* ===== MODAL CSS ===== */
        .modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 1000; display: none; align-items: center; justify-content: center; padding: 20px; }
        .modal-overlay.open { display: flex; }
        .modal-box { background: #ffffff; border-radius: 16px; width: 100%; max-width: 420px; padding: 28px 32px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
        
        .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
        .modal-title { font-size: 16px; font-weight: 900; color: #111; }
        .modal-close { background: none; border: none; font-size: 24px; color: #aaa; cursor: pointer; }
        
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-size: 12px; font-weight: 800; margin-bottom: 8px; color: #111; }
        .text-red { color: var(--primary); }
        .text-muted-small { color: #aaa; font-weight: 500; font-size: 10px; }
        
        .form-control { width: 100%; border: 1px solid var(--border-color); border-radius: 8px; padding: 10px 14px; font-size: 13px; font-weight: 600; outline: none; font-family: inherit; color: #333; }
        .form-control:focus { border-color: var(--primary); }
        
        .custom-select { appearance: none; background: url('data:image/svg+xml;utf8,<svg fill="%23333" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/><path d="M0 0h24v24H0z" fill="none"/></svg>') no-repeat right 10px center; background-color: #fff; cursor: pointer; }

        /* Preview Pekerjaan Card */
        .preview-container { display: flex; flex-direction: column; gap: 10px; max-height: 140px; overflow-y: auto; }
        .job-card { display: flex; justify-content: space-between; align-items: center; padding: 12px; border: 1px solid #ffd2d2; background: #fffcfc; border-radius: 8px; }
        .job-left strong { font-size: 13px; font-weight: 900; color: #111; display: block; margin-bottom: 4px; }
        .job-left span { font-size: 11px; color: #666; }
        .job-right { text-align: right; }
        .status-badge { display: inline-block; background: #ffebee; color: var(--primary); border: 1px solid var(--primary); font-size: 9px; font-weight: 800; padding: 3px 8px; border-radius: 20px; margin-bottom: 4px; }
        .job-right span.buku-count { font-size: 11px; font-weight: 800; color: #333; }

        .modal-actions { display: flex; justify-content: center; gap: 12px; margin-top: 32px; }
        .btn-batal { padding: 10px 32px; background: #ffffff; border: 1px solid #ccc; border-radius: 8px; color: #555; font-weight: 800; font-size: 13px; cursor: pointer; transition: 0.2s; }
        .btn-batal:hover { background: #f5f5f5; }
        .btn-simpan { padding: 10px 32px; background: var(--primary); border: none; border-radius: 8px; color: #fff; font-weight: 800; font-size: 13px; cursor: pointer; transition: 0.2s; }
        .btn-simpan:hover { background: var(--primary-hover); }
    </style>

    <script>
        const btnPilihKerjaan = document.getElementById('btnPilihKerjaan');
        const btnAlihkanTrigger = document.getElementById('btnAlihkanTrigger');
        const table = document.getElementById('kerjaanTable');
        
        // Modal elements
        const modalAlihkan = document.getElementById('modalAlihkan');
        const btnCloseModal = document.getElementById('btnCloseModal');
        const btnBatalModal = document.getElementById('btnBatalModal');
        const previewContainer = document.getElementById('previewPekerjaanContainer');
        const inputPencetakanIds = document.getElementById('inputPencetakanIds');

        // Toggle Mode Pilih
        btnPilihKerjaan.addEventListener('click', function() {
            table.classList.toggle('show-checkboxes');
            const checkboxes = document.querySelectorAll('.row-checkbox');
            
            if(table.classList.contains('show-checkboxes')){
                btnPilihKerjaan.style.background = '#e0e0e0';
            } else {
                btnPilihKerjaan.style.background = '#ffffff';
                checkboxes.forEach(cb => cb.checked = false);
                checkSelected();
            }
        });

        // Pantau klik checkbox
        document.addEventListener('change', function(e) {
            if(e.target && e.target.classList.contains('row-checkbox')) {
                checkSelected();
            }
        });

        function checkSelected() {
            const checkboxes = document.querySelectorAll('.row-checkbox');
            const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
            btnAlihkanTrigger.disabled = !anyChecked;
        }

        // Buka Modal Pengalihan
        btnAlihkanTrigger.addEventListener('click', function() {
            const checkboxes = document.querySelectorAll('.row-checkbox:checked');
            let ids = [];
            let previewHTML = '';

            checkboxes.forEach(cb => {
                ids.push(cb.value);
                const kode = cb.getAttribute('data-kode');
                const judul = cb.getAttribute('data-judul');
                const status = cb.getAttribute('data-status');
                const jumlah = cb.getAttribute('data-jumlah');

                previewHTML += `
                    <div class="job-card">
                        <div class="job-left">
                            <strong>${kode}</strong>
                            <span>${judul}</span>
                        </div>
                        <div class="job-right">
                            <span class="status-badge">${status}</span><br>
                            <span class="buku-count">${jumlah} Buku</span>
                        </div>
                    </div>
                `;
            });

            // Isi array id ke hidden input
            inputPencetakanIds.value = ids.join(',');
            // Render card ke UI
            previewContainer.innerHTML = previewHTML;
            // Tampilkan Modal
            modalAlihkan.classList.add('open');
        });

        // Tutup Modal
        btnCloseModal.addEventListener('click', () => modalAlihkan.classList.remove('open'));
        btnBatalModal.addEventListener('click', () => modalAlihkan.classList.remove('open'));
    </script>
</body>
</html>