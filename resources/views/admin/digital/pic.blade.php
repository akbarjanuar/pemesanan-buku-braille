<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PIC - Admin Literasi Digital</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

    @include('partials.admin-digital-nav', ['activeMenu' => $activeMenu ?? 'pic'])

    <div class="main-wrapper">
        <!-- TOPBAR DISAMAKAN -->
        <header class="topbar">
            <div class="topbar-left">
                <button type="button" class="menu-toggle">
                    <i class="fas fa-bars"></i>
                </button>
                <span class="page-title">PIC</span>
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

        <!-- CONTENT -->
        <main class="content">
            <div class="content-header">
                <div class="page-heading">
                    <h1>Daftar PIC</h1>
                    <p>Penanggung jawab setiap pekerjaan pencetakan.</p>
                </div>
                <!-- Tombol ini memicu Modal -->
                <button type="button" class="btn-add" id="btnTambahPic">
                    <i class="fas fa-plus"></i> Tambah PIC
                </button>
            </div>

            <!-- TABLE -->
            <div class="table-container">
                <table class="pic-table">
                    <thead>
                        <tr>
                            <th>Nama PIC</th>
                            <th>Nomor Telepon</th>
                            <th>Pekerjaan Aktif</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($daftarPic ?? [] as $pic)
                            <tr>
                                <td>{{ $pic->nama }}</td>
                                <td>{{ $pic->nomor_telepon ?? '-' }}</td>
                                <td>{{ $pic->pekerjaan_aktif ?? 0 }}</td>
                                <td>
                                    <!-- Arahkan ke rute detail -->
                                    <a href="{{ route('admin.digital.pic.detail', $pic->id) }}" class="btn-detail">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center; color: var(--text-muted); padding: 30px;">
                                    Belum ada data PIC yang terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <!-- MODAL TAMBAH PIC -->
    <div class="modal-overlay" id="modalTambahPic">
        <div class="modal-box">
            <div class="modal-header">
                <h3 class="modal-title">Tambah PIC Baru</h3>
                <button type="button" class="modal-close" id="btnCloseModal">&times;</button>
            </div>
            <form action="{{ route('admin.digital.pic.store') }}" method="POST" class="modal-form">
                @csrf
                <div class="form-group">
                    <label>Nama PIC <span class="text-red">*</span></label>
                    <input type="text" name="nama" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Nomor Telpon <span class="text-red">*</span></label>
                    <input type="text" name="nomor_telepon" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Keterangan <span class="text-muted">(opsional)</span></label>
                    <textarea name="keterangan" class="form-control" rows="3"></textarea>
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn-batal" id="btnBatalModal">Batal</button>
                    <button type="submit" class="btn-simpan">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        :root {
            --primary: #c62828;
            --primary-hover: #b71c1c;
            --bg-color: #fcfcfc;
            --border-color: #eaeaea;
            --text-main: #111111;
            --text-muted: #888888;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; }
        body { display: flex; width: 100%; min-height: 100vh; background-color: var(--bg-color); color: var(--text-main); overflow: hidden; }

        .main-wrapper { flex: 1; width: calc(100% - 260px); display: flex; flex-direction: column; background-color: #f4f6f9; }
        
        /* TOPBAR STYLES */
        .topbar { width: 100%; height: 70px; display: flex; align-items: center; justify-content: space-between; padding: 0 32px; background-color: #ffffff; border-bottom: 1px solid var(--border-color); flex-shrink: 0; }
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
        .content-header { display: flex; align-items: flex-end; justify-content: space-between; margin-bottom: 24px; }
        .page-heading h1 { font-size: 24px; font-weight: 900; margin-bottom: 6px; }
        .page-heading p { font-size: 14px; color: var(--text-muted); }

        .btn-add { display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; background-color: var(--primary); color: #ffffff; border: none; border-radius: 6px; font-size: 14px; font-weight: 800; cursor: pointer; transition: 0.2s; }
        .btn-add:hover { background-color: var(--primary-hover); }

        .table-container { background-color: #ffffff; border: 1px solid var(--border-color); border-radius: 12px; overflow: hidden; }
        .pic-table { width: 100%; min-width: 700px; border-collapse: collapse; }
        .pic-table th { padding: 16px 24px; background-color: #f4f4f4; color: #555; font-size: 13px; font-weight: 800; text-align: left; }
        .pic-table td { padding: 16px 24px; border-top: 1px solid var(--border-color); color: #333; font-size: 14px; font-weight: 600; }
        .pic-table th:nth-child(3), .pic-table td:nth-child(3), .pic-table th:nth-child(4), .pic-table td:nth-child(4) { text-align: center; }

        .btn-detail { display: inline-flex; padding: 6px 18px; background-color: var(--primary); color: #ffffff; border-radius: 6px; text-decoration: none; font-size: 12px; font-weight: 800; transition: 0.2s; }
        .btn-detail:hover { background-color: var(--primary-hover); }

        /* ===== MODAL CSS ===== */
        .modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 1000; display: none; align-items: center; justify-content: center; padding: 20px; }
        .modal-overlay.open { display: flex; }
        .modal-box { background: #ffffff; border-radius: 16px; width: 100%; max-width: 450px; padding: 32px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
        .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
        .modal-title { font-size: 18px; font-weight: 900; }
        .modal-close { background: none; border: none; font-size: 24px; color: #aaa; cursor: pointer; }
        .modal-close:hover { color: #333; }

        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; font-size: 13px; font-weight: 800; margin-bottom: 8px; }
        .text-red { color: var(--primary); }
        .text-muted { color: #aaa; font-weight: normal; font-size: 12px; }
        .form-control { width: 100%; border: 1px solid var(--border-color); border-radius: 8px; padding: 12px 14px; font-size: 14px; outline: none; font-family: inherit; }
        .form-control:focus { border-color: var(--primary); }

        .modal-actions { display: flex; gap: 12px; margin-top: 32px; }
        .btn-batal { flex: 1; padding: 12px; background: #ffffff; border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-main); font-weight: 800; cursor: pointer; transition: 0.2s; }
        .btn-batal:hover { background: #f5f5f5; }
        .btn-simpan { flex: 1; padding: 12px; background: var(--primary); border: none; border-radius: 8px; color: #fff; font-weight: 800; cursor: pointer; transition: 0.2s; }
        .btn-simpan:hover { background: var(--primary-hover); }
    </style>

    <script>
        // Modal Logic
        const btnTambahPic = document.getElementById('btnTambahPic');
        const modalTambahPic = document.getElementById('modalTambahPic');
        const btnCloseModal = document.getElementById('btnCloseModal');
        const btnBatalModal = document.getElementById('btnBatalModal');

        btnTambahPic.addEventListener('click', () => modalTambahPic.classList.add('open'));
        btnCloseModal.addEventListener('click', () => modalTambahPic.classList.remove('open'));
        btnBatalModal.addEventListener('click', () => modalTambahPic.classList.remove('open'));
    </script>
</body>
</html>