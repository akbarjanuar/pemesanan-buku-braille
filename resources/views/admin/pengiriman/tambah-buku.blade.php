<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku Baru - BrailleKita</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary: #c62828; --primary-hover: #b71c1c; --surface: #ffffff; --text-dark: #111111; --text-muted: #757575; --border: #e0e0e0; --background: #f4f6f9; }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: sans-serif; background: var(--background); color: var(--text-dark); }

        .menu-toggle { display: inline-flex; align-items: center; justify-content: center; width: 24px; height: 24px; color: var(--text-muted); background: none; border: none; cursor: pointer; font-size: 20px; }
        .topbar-title { font-size: 20px; font-weight: 900; font-family: 'Georgia', serif; color: var(--text-dark); margin-left: 10px; }
        .content-area { padding: 32px; max-width: 900px; margin: 0 auto; width: 100%; }

        .back-link { display: inline-block; font-weight: 700; color: var(--primary); font-size: 14px; margin-bottom: 20px; text-decoration: none; }
        .back-link:hover { text-decoration: underline; }
        
        .form-card { background: var(--surface); border: 1px solid var(--border); border-radius: 12px; padding: 32px; }
        .form-title { font-size: 20px; font-weight: 900; font-family: 'Georgia', serif; margin-bottom: 28px; }

        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px; }
        @media (max-width: 768px) { .form-grid { grid-template-columns: 1fr; } }
        
        .form-group { margin-bottom: 0; }
        .form-group label { display: block; font-weight: 800; font-size: 14px; margin-bottom: 8px; color: var(--text-dark); }
        .form-group label span { color: var(--primary); }
        .form-control { width: 100%; padding: 12px 14px; border: 1px solid var(--border); border-radius: 8px; font-size: 14px; font-family: inherit; color: var(--text-dark); outline: none; background: white; }
        .form-control:focus { border-color: var(--primary); }
        
        textarea.form-control { resize: vertical; min-height: 100px; }
        
        .form-actions { display: flex; justify-content: flex-end; gap: 12px; margin-top: 32px; }
        .btn-cancel { padding: 12px 24px; border: 1px solid var(--border); border-radius: 8px; background: white; color: var(--text-dark); font-weight: 700; text-decoration: none; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; }
        .btn-cancel:hover { background: #f5f5f5; }
        .btn-save { padding: 12px 24px; border: none; border-radius: 8px; background: var(--primary); color: white; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; }
        .btn-save:hover { background: var(--primary-hover); }
    </style>
</head>
<body>
    @include('partials.admin-nav', ['activeMenu' => 'kelola-buku'])
    
    <div class="main-wrapper">
        <header class="topbar">
            <div class="topbar-left">
                <button type="button" class="menu-toggle"><i class="fas fa-bars"></i></button>
                <span class="topbar-title">Tambah Buku Baru</span>
            </div>

            <div class="topbar-right" style="display: flex; align-items: center; gap: 24px;">
                <i class="far fa-bell notification-bell" style="font-size: 20px; cursor: pointer;"></i>

                <a href="{{ route('admin.profile') }}" style="display: flex; align-items: center; gap: 12px; text-decoration: none; color: var(--text-dark); cursor: pointer;">
                    <span style="font-weight: 700; font-size: 15px;">
                        {{ auth()->user()->nama ?? 'Admin Pengiriman' }}
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

        <main class="content-area">
            <a href="{{ route('admin.kelola-buku') }}" class="back-link">&larr; Kembali</a>

            <div class="form-card">
                <h2 class="form-title">Tambah Buku Baru</h2>
                
                <form action="{{ route('admin.store-buku') }}" method="POST">
                    @csrf
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Judul Buku <span>*</span></label>
                            <input type="text" name="judul" class="form-control" value="{{ old('judul') }}" required>
                        </div>
                        <div class="form-group">
                            <label>Pengarang <span>*</span></label>
                            <input type="text" name="pengarang" class="form-control" value="{{ old('pengarang') }}" required>
                        </div>

                        <div class="form-group">
                            <label>Kategori</label>
                            <select name="kategori" class="form-control">
                                @php
                                    $categories = ['Fiksi', 'Non-Fiksi', 'Pendidikan', 'Agama', 'Sains', 'Sejarah', 'Seni & Budaya', 'Lainnya'];
                                @endphp
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}" {{ old('kategori') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Penerbit</label>
                            <input type="text" name="penerbit" class="form-control" value="{{ old('penerbit') }}">
                        </div>

                        <div class="form-group">
                            <label>Stok <span>*</span></label>
                            <input type="number" name="stok" class="form-control" value="{{ old('stok', 0) }}" required min="0">
                        </div>
                        <div class="form-group">
                            <label>ISBN</label>
                            <input type="text" name="isbn" class="form-control" value="{{ old('isbn') }}">
                        </div>

                        <div class="form-group">
                            <label>Batas pemesanan per akun <span>*</span></label>
                            <input type="number" name="batas_pemesanan" class="form-control" value="{{ old('batas_pemesanan', 0) }}" required min="0">
                        </div>
                        <div class="form-group">
                            <label>Tahun terbit</label>
                            <input type="date" name="tahun_terbit" class="form-control" value="{{ old('tahun_terbit') }}">
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" placeholder="Panduan praktis menerapkan prinsip psikologi positif dalam kehidupan sehari-hari untuk meningkatkan kesejahteraan mental.">{{ old('deskripsi') }}</textarea>
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('admin.kelola-buku') }}" class="btn-cancel">Batal</a>
                        <button type="submit" class="btn-save">Simpan Buku</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>