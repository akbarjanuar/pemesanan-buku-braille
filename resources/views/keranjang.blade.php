<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang - BrailleKita</title>
    <link href="https://fonts.googleapis.com/css2?family=Atkinson+Hyperlegible:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --background: #f8f8f8;
            --foreground: #111111;
            --primary: #c62828;
            --primary-hover: #b71c1c;
            --muted: #eeeeee;
            --muted-foreground: #5a5a5a;
            --border: #d4d4d4;
            --success: #2e7d32;
        }

        *, ::after, ::before { box-sizing: border-box; margin: 0; padding: 0; }
        body { background-color: var(--background); color: var(--foreground); font-family: 'Atkinson Hyperlegible', sans-serif; line-height: 1.6; }
        a { text-decoration: none; color: inherit; }

        /* Navbar */
        .navbar { background: var(--primary); color: white; position: sticky; top: 0; z-index: 100; }
        .navbar-container { max-width: 1200px; margin: 0 auto; padding: 0 20px; display: flex; align-items: center; gap: 12px; min-height: 64px; }
        .nav-logo { background: white; color: var(--primary); font-weight: 700; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 6px; font-size: 18px; }
        .nav-brand { font-size: 20px; font-weight: 700; }
        .nav-spacer { flex-grow: 1; }
        .nav-link { padding: 8px 16px; border-radius: 6px; font-weight: 700; font-size: 15px; border: 1px solid transparent; display: flex; align-items: center; gap: 6px; }
        .nav-link.active { background-color: white; color: var(--primary); }
        .nav-link.outline { border-color: rgba(255, 255, 255, 0.4); }
        .nav-link.outline:hover { background-color: rgba(255, 255, 255, 0.1); }

        /* Container & Grid Layout Sesuai Inspect */
        .main-container { max-width: 1200px; margin: 0 auto; padding: 40px 20px 60px 20px; }
        .cart-layout { 
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 28px;
            align-items: start;
        }

        /* Cart List Items */
        .cart-items { display: flex; flex-direction: column; gap: 16px; }
        
        .cart-item { 
            background: white; 
            border: 1px solid var(--border); 
            border-radius: 8px; 
            padding: 20px; 
            display: flex; 
            gap: 16px; 
            align-items: center; 
        }
        
        .cart-cover { 
            width: 64px; 
            height: 64px; 
            border-radius: 8px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            flex-shrink: 0;
        }

        .dots-small { display: grid; grid-template-columns: repeat(2, 6px); gap: 4px; }
        .dots-small span { width: 6px; height: 6px; background-color: rgba(255, 255, 255, 0.4); border-radius: 50%; }
        
        .cart-details { flex-grow: 1; display: flex; flex-direction: column; align-items: flex-start; }
        .cart-title { font-size: 18px; font-weight: 700; margin-bottom: 2px; }
        .cart-author { color: var(--muted-foreground); font-size: 14px; margin-bottom: 8px; }
        .badge-green { color: var(--success); border: 1px solid var(--success); background: #f1f8e9; padding: 2px 8px; border-radius: 4px; font-size: 13px; font-weight: 700; }

        /* Action Buttons (Minus, Plus, Delete) */
        .cart-actions { display: flex; align-items: center; gap: 12px; }
        .btn-icon { 
            width: 36px; height: 36px; 
            border: 1px solid var(--border); 
            background: white; 
            border-radius: 6px; 
            font-size: 18px; 
            display: flex; align-items: center; justify-content: center; 
            cursor: pointer; color: var(--foreground); 
        }
        .btn-icon:hover { background: var(--muted); }
        .btn-icon.delete { color: var(--primary); font-size: 16px; }
        .qty-number { font-weight: 700; font-size: 16px; min-width: 16px; text-align: center; }

        /* Summary Card */
        .summary-card { background: white; border: 1px solid var(--border); border-radius: 8px; padding: 24px; position: sticky; top: 88px; }
        .summary-title { font-size: 18px; font-weight: 700; margin-bottom: 20px; }
        
        .summary-item { display: flex; justify-content: space-between; font-size: 15px; margin-bottom: 12px; color: var(--muted-foreground); }
        .summary-item strong { color: var(--success); font-weight: 700; }
        
        .summary-divider { border-bottom: 1px solid var(--border); margin: 16px 0; }
        
        .summary-total { display: flex; justify-content: space-between; font-size: 18px; font-weight: 700; margin-bottom: 16px; }
        .summary-total strong { color: var(--success); }
        
        .promo-box { 
            background: #e8f5e9; border: 1px solid #c8e6c9; 
            padding: 12px; border-radius: 6px; 
            display: flex; gap: 8px; align-items: flex-start;
            color: #1b5e20; font-size: 13px; font-weight: 700; 
            margin-bottom: 24px; line-height: 1.4; 
        }
        
        .btn-checkout { 
            background: var(--primary); color: white; border: none; 
            padding: 16px; border-radius: 6px; font-size: 16px; font-weight: 700; 
            width: 100%; cursor: pointer; margin-bottom: 12px; font-family: inherit; 
        }
        .btn-checkout:hover { background: var(--primary-hover); }
        
        .btn-continue { 
            background: white; color: var(--foreground); border: 1px solid var(--border); 
            padding: 16px; border-radius: 6px; font-size: 16px; font-weight: 700; 
            width: 100%; cursor: pointer; display: block; text-align: center; font-family: inherit; 
        }
        .btn-continue:hover { background: var(--muted); }

        .empty-state { text-align: center; padding: 80px 20px; border: 2px dashed var(--border); border-radius: 12px; background: white; grid-column: 1 / -1; }
        .btn-primary { background: var(--primary); color: white; padding: 12px 24px; border-radius: 6px; font-weight: 700; display: inline-block; margin-top: 16px; border: none; cursor: pointer;}

        @media (max-width: 768px) {
            .cart-layout { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    @php
        // Mengambil jumlah item unik di keranjang untuk notifikasi navbar
        $cartCount = \App\Models\Keranjang::where('user_id', auth()->id())->sum('jumlah');
    @endphp

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
                    <span>{{ $cartCount }}</span>
                @endif
            </a>
            
            <span style="margin: 0 8px; font-size: 15px;">Halo, {{ auth()->user()->nama ?? 'Pengguna' }}</span>
            <form action="/logout" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="nav-link outline" style="background:transparent; cursor:pointer; font-family: inherit; color: white;">Keluar</button>
            </form>
        </div>
    </header>

    <main class="main-container">
        
        <div class="cart-layout">
            @if($daftarKeranjang->isEmpty())
                <div class="empty-state">
                    <div style="font-size: 48px; margin-bottom: 16px;">🛒</div>
                    <h3 style="font-size: 24px; font-weight: 700; margin-bottom: 8px;">Keranjang Masih Kosong</h3>
                    <p style="color: var(--muted-foreground);">Anda belum memilih buku. Silakan cari buku di katalog.</p>
                    <a href="/" class="btn-primary">Lihat Katalog</a>
                </div>
            @else
                <!-- Kolom Kiri: Daftar Item -->
                <div class="cart-items">
                    @foreach($daftarKeranjang as $item)
                        <div class="cart-item">
                            <div class="cart-cover" style="background-color: {{ $item->buku->warna_cover }};">
                                <div class="dots-small">
                                    <span></span><span></span><span></span><span></span><span></span><span></span>
                                </div>
                            </div>
                            <div class="cart-details">
                                <h3 class="cart-title">{{ $item->buku->judul }}</h3>
                                <p class="cart-author">{{ $item->buku->pengarang }}</p>
                                <div class="badge-green">Gratis</div>
                            </div>
                            <div class="cart-actions">
                                <!-- Tombol Kontrol Kuantitas (Menggunakan form agar aman) -->
                                <button type="button" class="btn-icon">−</button>
                                <span class="qty-number">{{ $item->jumlah }}</span>
                                <button type="button" class="btn-icon">+</button>
                                <form action="/keranjang/hapus/{{ $item->id }}" method="POST" style="margin-left: 8px;">
                                    @csrf
                                    <button type="submit" class="btn-icon delete">✕</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Kolom Kanan: Ringkasan Pesanan -->
                <div class="summary-card">
                    <h3 class="summary-title">Ringkasan Pesanan</h3>
                    
                    @foreach($daftarKeranjang as $item)
                        <div class="summary-item">
                            <span>{{ $item->buku->judul }} x{{ $item->jumlah }}</span>
                            <strong>Gratis</strong>
                        </div>
                    @endforeach
                    
                    <div class="summary-divider"></div>
                    
                    <div class="summary-total">
                        <span>Total</span>
                        <strong>Rp0</strong>
                    </div>

                    <a href="/pemesanan" class="btn-checkout" style="display:block; text-align:center;">Lanjutkan ke Pemesanan</a>
                    <a href="/" class="btn-continue">Lanjut Pilih Buku</a>
                </div>
            @endif
        </div>
    </main>

</body>
</html>