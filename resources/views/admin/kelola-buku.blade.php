<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Buku - BrailleKita</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary: #c62828; --surface: #ffffff; --text-dark: #111111; --text-muted: #757575; --border: #e0e0e0; --background: #f4f6f9; }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: sans-serif; background: var(--background); }

        .menu-toggle { display: inline-flex; align-items: center; justify-content: center; width: 24px; height: 24px; color: var(--text-muted); background: none; border: none; cursor: pointer; font-size: 20px; }
        .topbar-title { font-size: 20px; font-weight: 900; font-family: 'Georgia', serif; color: var(--text-dark); margin-left: 10px; }
        .content-area { padding: 32px; flex-grow: 1; overflow-y: auto; }

        .page-header h2 { font-size: 22px; font-weight: 900; font-family: 'Georgia', serif; margin-bottom: 6px; }
        .page-header p { color: var(--text-muted); font-size: 14px; margin-bottom: 24px; }

        .toolbar { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 20px; gap: 16px; flex-wrap: wrap; }
        .search-box { flex-grow: 1; max-width: 400px; }
        .search-box label { display: block; font-size: 13px; font-weight: 700; color: var(--text-dark); margin-bottom: 8px; }
        .search-box input { width: 100%; padding: 10px 14px; border: 1px solid var(--border); border-radius: 6px; font-size: 14px; outline: none; }
        .search-box input:focus { border-color: var(--primary); }
        .btn-add { background: var(--primary); color: white; padding: 10px 20px; border-radius: 6px; font-weight: 700; font-size: 14px; text-decoration: none; display: inline-block; border: none; cursor: pointer; }

        /* Table */
        .table-card { background: var(--surface); border: 1px solid var(--border); border-radius: 12px; overflow: hidden; }
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th { background: #eaeaea; padding: 14px 20px; text-align: left; font-size: 13px; color: var(--text-muted); font-weight: 700; }
        .data-table td { padding: 16px 20px; border-bottom: 1px solid var(--border); vertical-align: middle; }
        .data-table tr:last-child td { border-bottom: none; }

        /* Book Item in Table */
        .book-cell { display: flex; align-items: center; gap: 16px; }
        .book-cover { width: 36px; height: 48px; border-radius: 4px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .braille-dots { display: grid; grid-template-columns: 1fr 1fr; gap: 3px; }
        .braille-dots span { width: 4px; height: 4px; background: rgba(255,255,255,0.5); border-radius: 50%; }
        .book-info h4 { font-size: 14px; font-weight: 800; color: var(--text-dark); margin-bottom: 4px; }
        .book-info p { font-size: 12px; color: var(--text-muted); }

        .col-text { font-size: 14px; font-weight: 700; color: var(--text-dark); }
        .btn-edit { background: var(--primary); color: white; padding: 6px 16px; border-radius: 6px; font-size: 13px; font-weight: 700; text-decoration: none; display: inline-block; }
    </style>
</head>
<body>
    @include('partials.admin-nav', ['activeMenu' => 'kelola-buku'])
    <div class="main-wrapper">
        <header class="topbar">
            <div class="topbar-left">
                <button type="button" class="menu-toggle"><i class="fas fa-bars"></i></button>
                <span class="topbar-title">Kelola Buku</span>
            </div>
            <div class="topbar-right">
                <i class="far fa-bell notification-bell"></i>
                <div class="user-profile"><span>{{ auth()->user()->nama ?? 'Admin' }}</span><i class="fas fa-user-circle"></i></div>
            </div>
        </header>

        <main class="content-area">
            <div class="page-header">
                <h2>Kelola Buku</h2>
                <p>Atur dan perbarui koleksi Buku Braille yang tersedia untuk dipesan oleh customer.</p>
            </div>

            <div class="toolbar">
                <form action="{{ route('admin.kelola-buku') }}" method="GET" class="search-box">
                    <label>Cari buku</label>
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari judul atau nama pengarang..." onchange="this.form.submit()">
                </form>
                <a href="{{ route('admin.tambah-buku') }}" class="btn-add">+ Tambah buku baru</a>
            </div>

            <div class="table-card">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Buku</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                            <th>Maks. Pesan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $colors = ['#0288d1', '#7b1fa2', '#2e7d32', '#455a64', '#ff5722', '#e64a19', '#d32f2f', '#388e3c']; @endphp
                        @forelse($daftarBuku as $index => $buku)
                        <tr>
                            <td>
                                <div class="book-cell">
                                    <div class="book-cover" style="background-color: {{ $colors[$index % count($colors)] }};">
                                        <div class="braille-dots"><span></span><span></span><span></span><span></span><span></span><span></span></div>
                                    </div>
                                    <div class="book-info">
                                        <h4>{{ $buku->judul }}</h4>
                                        <p>Oleh {{ $buku->pengarang ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="col-text">{{ $buku->kategori ?? '-' }}</td>
                            <td class="col-text">{{ $buku->stok }}</td>
                            <td class="col-text">{{ $buku->batas_pemesanan ?? 1 }}</td>
                            <td><a href="{{ route('admin.edit-buku', $buku->id) }}" class="btn-edit">Edit</a></td>
                        </tr>
                        @empty
                        <tr><td colspan="5" style="text-align: center; padding: 20px;">Belum ada buku.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>