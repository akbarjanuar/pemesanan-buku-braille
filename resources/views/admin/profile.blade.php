<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - BrailleKita</title>
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
        body { font-family: sans-serif; background: var(--background); color: var(--text-dark); }

        .menu-toggle { display: inline-flex; align-items: center; justify-content: center; width: 24px; height: 24px; color: var(--text-muted); background: none; border: none; cursor: pointer; font-size: 20px; }
        .topbar-title { font-size: 20px; font-weight: 900; font-family: 'Georgia', serif; color: var(--text-dark); margin-left: 10px; }
        .content-area { padding: 32px; flex-grow: 1; overflow-y: auto; }

        /* =========================================
            HEADER & GRID
        ========================================= */
        .page-header { margin-bottom: 24px; }
        .page-header h2 { font-size: 20px; font-weight: 700; margin-bottom: 6px; }
        .page-header p { color: var(--text-muted); font-size: 13px; }

        .profile-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; margin-bottom: 24px; }
        
        .card { 
            background: var(--surface); 
            border: 1px solid var(--border); 
            border-radius: 8px; 
            padding: 24px; 
            position: relative; 
        }
        .card-header { font-size: 14px; font-weight: 700; margin-bottom: 24px; color: var(--text-dark); }
        .edit-icon { position: absolute; top: 24px; right: 24px; color: var(--text-muted); cursor: pointer; font-size: 14px; }
        .edit-icon:hover { color: var(--text-dark); }

        /* =========================================
            CARD 1: FOTO PROFILE
        ========================================= */
        .profile-center { text-align: center; }
        .avatar-lg { 
            width: 100px; height: 100px; background: var(--primary); color: white; 
            font-size: 40px; font-weight: 700; border-radius: 50%; 
            display: flex; align-items: center; justify-content: center; 
            margin: 0 auto 16px auto; 
        }
        .profile-name { font-size: 18px; font-weight: 700; margin-bottom: 4px; }
        .profile-role { font-size: 11px; color: var(--text-muted); margin-bottom: 20px; font-weight: 700; }
        
        .btn-outline { 
            background: white; border: 1px solid var(--border); color: var(--text-dark); 
            padding: 8px 16px; border-radius: 6px; font-size: 13px; font-weight: 700; 
            cursor: pointer; display: inline-flex; align-items: center; gap: 8px; 
            margin-bottom: 12px; transition: 0.2s;
        }
        .btn-outline:hover { background: #f9f9f9; border-color: #ccc; }
        .photo-format { font-size: 10px; color: var(--text-muted); }

        /* =========================================
            CARD 2: FORM INFORMASI PRIBADI
        ========================================= */
        .form-group { margin-bottom: 16px; text-align: left; }
        .form-label { display: block; font-size: 12px; font-weight: 700; margin-bottom: 8px; }
        .form-label .required { color: var(--primary); }
        .form-control { 
            width: 100%; padding: 10px 12px; border: 1px solid var(--border); 
            border-radius: 6px; font-size: 13px; font-family: inherit; color: var(--text-dark);
            outline: none; transition: border-color 0.2s;
        }
        .form-control:focus { border-color: var(--primary); }
        .form-control:disabled { background: #f9f9f9; color: var(--text-muted); }
        .form-help { font-size: 10px; color: var(--text-muted); margin-top: 4px; display: block; }
        
        .btn-submit-area { text-align: right; margin-top: 24px; }
        .btn-primary { 
            background: var(--primary); color: white; border: none; 
            padding: 10px 20px; border-radius: 6px; font-size: 13px; font-weight: 700; 
            cursor: pointer; transition: 0.2s;
        }
        .btn-primary:hover { background: var(--primary-hover); }

        /* =========================================
            CARD 3: INFORMASI AKUN
        ========================================= */
        .account-info-group { margin-bottom: 20px; }
        .account-label { font-size: 12px; font-weight: 700; color: var(--text-muted); margin-bottom: 6px; }
        .account-value { font-size: 13px; font-weight: 700; }
        .status-dot { display: inline-block; width: 8px; height: 8px; background: var(--success); border-radius: 50%; margin-right: 4px; }
        .status-active { color: var(--success); font-size: 12px; font-weight: 700; display: flex; align-items: center; }

        /* =========================================
            PENGATURAN NOTIFIKASI
        ========================================= */
        .notification-card { width: 66%; }
        .notification-header { margin-bottom: 24px; }
        .notification-header h3 { font-size: 15px; font-weight: 700; margin-bottom: 4px; }
        .notification-header p { font-size: 12px; color: var(--text-muted); }

        .notif-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
        .notif-row:last-child { margin-bottom: 0; }
        .notif-info h4 { font-size: 14px; font-weight: 700; margin-bottom: 4px; }
        .notif-info p { font-size: 12px; color: var(--text-muted); }

        /* Custom Toggle Switch */
        .toggle-switch { position: relative; display: inline-block; width: 44px; height: 24px; flex-shrink: 0; }
        .toggle-switch input { opacity: 0; width: 0; height: 0; }
        .toggle-slider { 
            position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; 
            background-color: #9e9e9e; transition: .4s; border-radius: 24px; 
        }
        .toggle-slider:before { 
            position: absolute; content: ""; height: 18px; width: 18px; 
            left: 3px; bottom: 3px; background-color: white; transition: .4s; border-radius: 50%; 
        }
        .toggle-switch input:checked + .toggle-slider { background-color: var(--primary); }
        .toggle-switch input:checked + .toggle-slider:before { transform: translateX(20px); }

        @media (max-width: 1024px) {
            .profile-grid { grid-template-columns: 1fr; }
            .notification-card { width: 100%; }
        }
    </style>
</head>

<body>

    {{-- SIDEBAR --}}
    @include('partials.admin-nav', ['activeMenu' => 'profile'])

    {{-- MAIN CONTENT --}}
    <div class="main-wrapper">

        {{-- TOPBAR --}}
        <header class="topbar">
            <div class="topbar-left">
                <button type="button" class="menu-toggle">
                    <i class="fas fa-bars"></i>
                </button>
                <span class="topbar-title">Profile</span>
            </div>
            <div class="topbar-right">
                <i class="far fa-bell notification-bell"></i>
            </div>
        </header>

        {{-- CONTENT --}}
        <main class="content-area">

            <div class="page-header">
                <h2>Profile Saya</h2>
                <p>Kelola informasi akun dan pengaturan akses Anda.</p>
            </div>

            <div class="profile-grid">
                
                {{-- CARD 1: FOTO PROFILE --}}
                <div class="card profile-center">
                    <div class="card-header" style="text-align: left;">Foto Profile</div>
                    <i class="fas fa-pen edit-icon"></i>
                    
                    <div class="avatar-lg">
                        {{ strtoupper(substr(auth()->user()->nama ?? 'A', 0, 1)) }}
                    </div>
                    <div class="profile-name">{{ auth()->user()->nama ?? 'Andika Kristian' }}</div>
                    <div class="profile-role">Admin Pengiriman &middot; Sentra Wyata Guna Bandung</div>
                    
                    <button type="button" class="btn-outline">
                        <i class="fas fa-upload"></i> Ubah Foto
                    </button>
                    <div class="photo-format">Format JPG atau PNG. Maksimal 2 MB.</div>
                </div>

                {{-- CARD 2: INFORMASI PRIBADI --}}
                <div class="card">
                    <div class="card-header">Informasi Pribadi</div>
                    <i class="fas fa-pen edit-icon"></i>

                    {{-- Alert Notifikasi Sukses --}}
                    @if(session('success'))
                        <div style="background: var(--success); color: white; padding: 12px; border-radius: 6px; margin-bottom: 16px; font-size: 13px; font-weight: 700;">
                            <i class="fas fa-check-circle" style="margin-right: 6px;"></i> {{ session('success') }}
                        </div>
                    @endif

                    {{-- Alert Notifikasi Error (jika email sudah dipakai) --}}
                    @if($errors->any())
                        <div style="background: var(--primary); color: white; padding: 12px; border-radius: 6px; margin-bottom: 16px; font-size: 13px; font-weight: 700;">
                            <i class="fas fa-exclamation-triangle" style="margin-right: 6px;"></i> Gagal menyimpan data. Pastikan format email benar dan belum digunakan.
                        </div>
                    @endif

                    <form action="{{ route('admin.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label class="form-label">Nama Lengkap <span class="required">*</span></label>
                            <input type="text" name="nama" class="form-control" value="{{ old('nama', auth()->user()->nama) }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Nomor Telepon <span class="required">*</span></label>
                            <input type="text" name="nomor_telepon" class="form-control" value="{{ old('nomor_telepon', auth()->user()->nomor_telepon) }}">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Email <span class="required">*</span></label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email) }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Divisi</label>
                            <input type="text" class="form-control" value="Pengiriman" disabled>
                            <span class="form-help">Tidak dapat diubah.</span>
                        </div>
                        
                        <div class="btn-submit-area">
                            <button type="submit" class="btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>

                {{-- CARD 3: INFORMASI AKUN --}}
                <div class="card">
                    <div class="card-header">Informasi Akun</div>

                    <div class="account-info-group">
                        <div class="account-label">ID / Username Admin</div>
                        <div class="account-value">ADM-PNG001</div>
                    </div>
                    
                    <div class="account-info-group">
                        <div class="account-label">Status Akun</div>
                        <div class="status-active"><span class="status-dot"></span> Aktif</div>
                    </div>
                    
                    <div class="account-info-group">
                        <div class="account-label">Tanggal Akun Dibuat</div>
                        <div class="account-value">{{ auth()->user()->created_at ? auth()->user()->created_at->format('j F Y') : '1 Januari 2024' }}</div>
                    </div>
                    
                    <div class="account-info-group">
                        <div class="account-label">Terakhir Log In</div>
                        <div class="account-value">1 September 2026 pukul 09.34</div>
                    </div>
                </div>

            </div>

            {{-- NOTIFIKASI PENGATURAN --}}
            @php
                $rawNotif = auth()->user()->notif_settings;
                $notif = is_string($rawNotif) ? json_decode($rawNotif, true) : ($rawNotif ?? []);
            @endphp

            <div class="card notification-card">
                <div class="notification-header">
                    <h3>Pengaturan Notifikasi</h3>
                    <p>Pilih jenis notifikasi yang ingin Anda terima.</p>
                </div>

                <div class="notif-row">
                    <div class="notif-info">
                        <h4>Permintaan Buku Baru</h4>
                        <p>Notifikasi saat customer mengirim permintaan buku baru.</p>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" class="notif-toggle-input" data-name="permintaan_buku_baru" {{ (isset($notif['permintaan_buku_baru']) && $notif['permintaan_buku_baru'] === true) ? 'checked' : '' }}>
                        <span class="toggle-slider"></span>
                    </label>
                </div>

                <div class="notif-row">
                    <div class="notif-info">
                        <h4>Update Pencetakan</h4>
                        <p>Notifikasi saat ada perubahan status pekerjaan pencetakan.</p>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" class="notif-toggle-input" data-name="update_pencetakan" {{ (isset($notif['update_pencetakan']) && $notif['update_pencetakan'] === true) ? 'checked' : '' }}>
                        <span class="toggle-slider"></span>
                    </label>
                </div>

                <div class="notif-row">
                    <div class="notif-info">
                        <h4>Pesanan Telah Diterima</h4>
                        <p>Buku telah diterima oleh customer.</p>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" class="notif-toggle-input" data-name="pesanan_diterima" {{ (isset($notif['pesanan_diterima']) && $notif['pesanan_diterima'] === true) ? 'checked' : '' }}>
                        <span class="toggle-slider"></span>
                    </label>
                </div>

                <div class="notif-row">
                    <div class="notif-info">
                        <h4>Pembatalan Pesanan</h4>
                        <p>Pelanggan membatalkan pesanan sebelum proses dilakukan.</p>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" class="notif-toggle-input" data-name="pembatalan_pesanan" {{ (isset($notif['pembatalan_pesanan']) && $notif['pembatalan_pesanan'] === true) ? 'checked' : '' }}>
                        <span class="toggle-slider"></span>
                    </label>
                </div>
            </div>

        </main>
    </div>

    {{-- SCRIPT AJAX UNTUK SIMPAN OTOMATIS TOGGLE NOTIFIKASI --}}
    <script>
        document.querySelectorAll('.notif-toggle-input').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                let settings = {};
                document.querySelectorAll('.notif-toggle-input').forEach(function(cb) {
                    settings[cb.getAttribute('data-name')] = cb.checked;
                });

                fetch("{{ route('admin.profile.notifikasi') }}", {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ settings: settings })
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        console.log('Pengaturan notifikasi berhasil diperbarui.');
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        });
    </script>

</body>
</html>