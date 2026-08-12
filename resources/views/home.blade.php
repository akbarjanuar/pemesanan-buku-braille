<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BrailleKita - Katalog Buku</title>
    <link href="https://fonts.googleapis.com/css2?family=Atkinson+Hyperlegible:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --background: #f8f8f8;
            --foreground: #111111;
            --card: #ffffff;
            --primary: #c62828;
            --primary-dark: #8e0000;
            --primary-light: #ef5350;
            --muted: #eeeeee;
            --muted-foreground: #5a5a5a;
            --border: #d4d4d4;
            --radius: 6px;
            --success: #2e7d32;
        }

        *, ::after, ::before { box-sizing: border-box; margin: 0; padding: 0; }
        body { background-color: var(--background); color: var(--foreground); font-family: 'Atkinson Hyperlegible', sans-serif; font-size: 16px; line-height: 1.6; }
        a { text-decoration: none; color: inherit; }
        
        /* Navbar */
        .navbar { background: var(--primary); color: white; position: sticky; top: 0; z-index: 100; }
        .navbar-container { max-width: 1200px; margin: 0 auto; padding: 0 20px; display: flex; align-items: center; gap: 12px; min-height: 64px; }
        .nav-logo { background: white; color: var(--primary); font-weight: 700; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 6px; font-size: 18px; }
        .nav-brand { font-size: 20px; font-weight: 700; color: white; }
        .nav-spacer { flex-grow: 1; }
        .nav-link { padding: 8px 16px; border-radius: 6px; font-weight: 700; font-size: 15px; display: flex; align-items: center; gap: 8px; border: 1px solid transparent; transition: 0.2s; }
        .nav-link.active { background-color: white; color: var(--primary); }
        .nav-link.outline { border-color: rgba(255, 255, 255, 0.4); color: white; }
        .nav-link.outline:hover { background-color: rgba(255, 255, 255, 0.1); }
        .nav-user { margin: 0 8px; font-size: 15px; }

        /* Badge Keranjang Navbar */
        .nav-badge { background-color: white; color: var(--primary); font-weight: 700; border-radius: 20px; padding: 2px 8px; font-size: 13px; margin-left: 4px; }

        /* Container & Hero */
        .main-container { max-width: 1200px; margin: 0 auto; padding: 24px 20px 60px 20px; }
        .hero-section { background: var(--primary); border-radius: 12px; padding: 40px 36px; margin-bottom: 36px; color: white; display: flex; flex-direction: column; gap: 12px; }
        .hero-title { font-size: 32px; font-weight: 700; margin-bottom: 4px; }
        .hero-subtitle { font-size: 18px; max-width: 800px; margin-bottom: 12px; line-height: 1.5; }
        .hero-badge { display: inline-flex; align-items: center; gap: 10px; background-color: rgba(255, 255, 255, 0.15); border: 1px solid rgba(255, 255, 255, 0.4); padding: 10px 16px; border-radius: 8px; font-weight: 700; width: fit-content; }

        /* Filter Section */
        .filter-section { background: white; border: 2px solid var(--border); border-radius: 10px; padding: 20px 24px; margin-bottom: 28px; display: flex; flex-wrap: wrap; gap: 16px; align-items: flex-end; }
        .filter-group { display: flex; flex-direction: column; gap: 8px; }
        .filter-group.search { flex-grow: 1; }
        .filter-label { font-weight: 700; font-size: 15px; }
        .form-control { padding: 12px 16px; border: 1px solid var(--border); border-radius: 6px; font-family: inherit; font-size: 15px; outline: none; width: 100%; }
        .form-control:focus { border-color: var(--primary); }
        .form-select { min-width: 250px; cursor: pointer; }

        .result-count { margin-bottom: 20px; color: var(--muted-foreground); }
        .result-count strong { color: var(--foreground); }

        /* Book Grid & Card */
        .book-grid { list-style: none; padding: 0; margin: 0; display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 20px; }
        .book-card { background: var(--card); border: 1px solid var(--border); border-radius: 10px; overflow: hidden; display: flex; flex-direction: column; }
        
        /* Area Link (Hanya Cover & Info) */
        .card-link { display: flex; flex-direction: column; flex-grow: 1; transition: opacity 0.2s; }
        .card-link:hover { opacity: 0.9; }
        
        .book-cover { height: 180px; padding: 16px; display: flex; flex-direction: column; justify-content: space-between; position: relative; text-align: center; }
        .cover-badge { background-color: var(--success); color: white; font-size: 12px; font-weight: 700; padding: 4px 10px; border-radius: 4px; width: fit-content; }
        .cover-icon { display: grid; grid-template-columns: repeat(2, 6px); gap: 6px; justify-content: center; margin: auto; }
        .cover-icon span { width: 6px; height: 6px; background-color: rgba(255, 255, 255, 0.4); border-radius: 50%; }
        .cover-title { color: white; font-weight: 700; font-size: 16px; line-height: 1.3; }

        .book-info { padding: 20px 20px 16px 20px; display: flex; flex-direction: column; flex-grow: 1; }
        .book-category { background-color: var(--muted); color: var(--muted-foreground); font-size: 12px; font-weight: 700; padding: 4px 10px; border-radius: 4px; width: fit-content; margin-bottom: 12px; }
        .book-title { font-size: 18px; font-weight: 700; margin-bottom: 4px; line-height: 1.3; }
        .book-author { color: var(--muted-foreground); font-size: 14px; margin-bottom: 20px; }
        
        .book-meta { display: flex; justify-content: space-between; align-items: center; margin-top: auto; }
        .price-text { color: var(--success); font-weight: 700; font-size: 18px; }
        .price-strike { color: #9e9e9e; font-size: 14px; text-decoration: line-through; margin-left: 4px; }
        .stock-text { color: var(--muted-foreground); font-size: 14px; }

        /* Area Action (Tombol Bawah) */
        .card-action { padding: 0 20px 20px 20px; }
        .btn-cart { width: 100%; background-color: var(--primary); color: white; border: none; padding: 12px; border-radius: 6px; font-weight: 700; font-size: 15px; font-family: inherit; cursor: pointer; transition: background-color 0.2s; }
        .btn-cart:hover { background-color: #e57373; }
        
        /* Tombol saat sudah di keranjang */
        .btn-cart.added { background-color: #e57373; cursor: default; }
        .btn-cart.added:hover { background-color: #e57373; }
        
        .btn-filter-action { width: auto; padding: 12px 24px; }
    </style>
</head>
<body>

    @php
        // Mengambil jumlah item dan ID buku yang ada di keranjang untuk user yang sedang login
        $cartCount = 0;
        $cartItemIds = [];
        if(auth()->check()){
            $cartCount = \App\Models\Keranjang::where('user_id', auth()->id())->sum('jumlah');
            $cartItemIds = \App\Models\Keranjang::where('user_id', auth()->id())->pluck('buku_id')->toArray();
        }
    @endphp

    <!-- Navbar Dinamis -->
    <header class="navbar">
        <div class="navbar-container">
            <div class="nav-logo">B</div>
            <a href="/" class="nav-brand">BrailleKita</a>
            
            <div class="nav-spacer"></div>
            
            <a href="/" class="nav-link {{ request()->is('/') ? 'active' : 'outline' }}">Katalog</a>
            <a href="/pesanan-saya" class="nav-link {{ request()->is('pesanan-saya') ? 'active' : 'outline' }}">Pesanan Saya</a>
            <a href="/keranjang" class="nav-link {{ request()->is('keranjang') ? 'active' : 'outline' }}">
                Keranjang
                @if($cartCount > 0)
                    <span class="nav-badge">{{ $cartCount }}</span>
                @endif
            </a>
            
            <span class="nav-user">Halo, {{ auth()->user()->nama ?? 'Pengguna' }}</span>
            <form action="/logout" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="nav-link outline" style="background:transparent; cursor:pointer;">Keluar</button>
            </form>
        </div>
    </header>

    <main class="main-container">
        
        <!-- Hero Section -->
        <div class="hero-section">
            <h1 class="hero-title">Katalog Buku Braille</h1>
            <p class="hero-subtitle">Temukan koleksi buku Braille untuk kebutuhan pribadi, lembaga pendidikan, dan organisasi. Semua buku tersedia <strong>gratis</strong>.</p>
            <div class="hero-badge">🎁 Semua buku Braille tersedia secara gratis</div>
        </div>

        <!-- Filter Section -->
        <form method="GET" action="/" class="filter-section">
            <div class="filter-group search">
                <label class="filter-label">Cari Buku</label>
                <input type="text" name="cari" class="form-control" placeholder="Judul atau nama pengarang..." value="{{ request('cari') }}">
            </div>
            <div class="filter-group">
                <label class="filter-label">Kategori</label>
                <select name="kategori" class="form-control form-select" onchange="this.form.submit()">
                    <option value="Semua Kategori">Semua Kategori</option>
                    @foreach ($daftarKategori as $kat)
                        <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>
                            {{ $kat }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn-cart btn-filter-action">Cari</button>

            @if(request('cari') || (request('kategori') && request('kategori') !== 'Semua Kategori'))
                <a href="/" class="btn-cart btn-filter-action" style="background-color: #757575; text-decoration: none; text-align:center;">Reset</a>
            @endif
        </form>

        <p class="result-count">Menampilkan <strong>{{ $daftarBuku->count() }}</strong> dari {{ \App\Models\Buku::count() }} buku</p>

        <!-- Book Grid -->
        <ul class="book-grid">
            @foreach ($daftarBuku as $buku)
                <li class="book-card">
                    <!-- Area Atas: Bisa diklik untuk melihat detail -->
                    <a href="/buku/{{ $buku->id }}" class="card-link">
                        <div class="book-cover" style="background-color: {{ $buku->warna_cover }};">
                            <div class="cover-badge">GRATIS</div>
                            <div class="cover-icon">
                                <span></span><span></span><span></span><span></span><span></span><span></span>
                            </div>
                            <h3 class="cover-title">{{ $buku->judul }}</h3>
                        </div>
                        <div class="book-info">
                            <span class="book-category">{{ $buku->kategori }}</span>
                            <h4 class="book-title">{{ $buku->judul }}</h4>
                            <p class="book-author">{{ $buku->pengarang }}</p>
                            <div class="book-meta">
                                <div>
                                    <span class="price-text">Gratis</span> <s class="price-strike">Rp0</s>
                                </div>
                                <span class="stock-text">Stok: {{ $buku->stok }}</span>
                            </div>
                        </div>
                    </a>
                    
                    <!-- Area Bawah: Tombol Aksi Keranjang -->
                    <div class="card-action">
                        @if(in_array($buku->id, $cartItemIds))
                            <!-- Jika buku sudah ada di keranjang -->
                            <button class="btn-cart added" disabled>✓ Di Keranjang</button>
                        @else
                            <!-- Jika buku belum ada di keranjang -->
                            <form action="/keranjang/tambah/{{ $buku->id }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-cart">+ Keranjang</button>
                            </form>
                        @endif
                    </div>
                </li>
            @endforeach
        </ul>

    </main>

</body>
</html>