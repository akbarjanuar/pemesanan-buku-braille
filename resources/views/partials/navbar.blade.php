@php
    $cartCount = auth()->check() ? \App\Models\Keranjang::where('user_id', auth()->id())->sum('jumlah') : 0;
@endphp

<style>
    .navbar { background: var(--primary, #c62828); color: white; position: sticky; top: 0; z-index: 100; }
    .navbar-container {
        max-width: 1200px; margin: 0 auto; padding: 0 20px;
        display: flex; align-items: center; flex-wrap: wrap;
        min-height: 64px;
    }

    /* --- Urutan Elemen Desktop --- */
    .nav-logo { order: 1; background: white; color: var(--primary, #c62828); font-weight: 700; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 6px; font-size: 18px; flex-shrink: 0; margin-right: 10px; }
    .nav-brand { order: 2; font-size: 20px; font-weight: 700; margin-right: 16px; }

    /* Teks sapaan tebal (Bold) */
    .nav-greeting {
        order: 3;
        font-size: 15px;
        font-weight: 700; /* Dibuat Bold */
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 250px; 
    }

    .nav-spacer { order: 4; flex-grow: 1; }

    .nav-links { order: 5; display: flex; align-items: center; gap: 8px; }
    
    .nav-toggle { order: 6; display: none; background: transparent; border: none; color: white; font-size: 26px; cursor: pointer; padding: 4px 8px; line-height: 1; margin-left: 8px; }

    /* Penyelarasan Presisi Tinggi & Padding Semua Tombol (Desktop) */
    .nav-link { 
        height: 40px; /* Mengunci tinggi presisi sama */
        padding: 0 16px; 
        border-radius: 6px; 
        font-weight: 700; 
        font-size: 15px; 
        border: 1px solid transparent; 
        white-space: nowrap; 
        display: inline-flex; 
        align-items: center; 
        justify-content: center;
        gap: 6px; 
        cursor: pointer; 
        box-sizing: border-box;
        margin: 0;
        line-height: 1;
        font-family: inherit;
    }
    .nav-link.active { background-color: white; color: var(--primary, #c62828); }
    .nav-link.outline { border-color: rgba(255, 255, 255, 0.4); }
    .nav-link.outline:hover { background-color: rgba(255, 255, 255, 0.1); }

    .form-logout { margin: 0; padding: 0; display: inline-flex; }
    .btn-logout { background: transparent; color: white; }

    /* --- Versi Responsif (Mobile / HP) --- */
    @media (max-width: 860px) {
        .navbar-container { padding: 10px 16px; }
        .nav-brand { font-size: 17px; margin-right: 0; }

        .nav-spacer { order: 3; } 

        .nav-greeting {
            order: 4;
            margin-right: 8px;
            font-size: 14px;
            max-width: 110px;
        }

        .nav-toggle { order: 5; display: block; margin-left: 0; }

        .nav-links {
            order: 6;
            display: none;
            flex-direction: column;
            align-items: stretch;
            width: 100%;
            gap: 6px;
            padding: 12px 0 16px 0;
            border-top: 1px solid rgba(255,255,255,0.25);
            margin-top: 10px;
        }
        .nav-links.open { display: flex; }

        .nav-link { justify-content: center; width: 100%; height: 48px; padding: 0 14px; font-size: 16px; }
        .nav-link.active { justify-content: center; }

        .form-logout { display: block; width: 100%; }
        .btn-logout { width: 100%; }
    }
</style>

<header class="navbar">
    <div class="navbar-container">
        <div class="nav-logo" aria-hidden="true">B</div>
        <a href="/" class="nav-brand" aria-label="Halaman Utama Braille Kita">BrailleKita</a>

        @auth
            <span class="nav-greeting">Halo, {{ auth()->user()->nama ?? 'Pengguna' }}</span>
        @endauth

        <div class="nav-spacer"></div>

        <button type="button" class="nav-toggle" id="navToggleBtn" aria-label="Buka menu navigasi" aria-expanded="false">&#9776;</button>

        <nav class="nav-links" id="navLinks">
            <a href="/" class="nav-link {{ request()->is('/') ? 'active' : 'outline' }}">Katalog</a>
            <a href="/pesanan-saya" class="nav-link {{ request()->is('pesanan-saya*') ? 'active' : 'outline' }}">Pesanan Saya</a>
            <a href="/keranjang" class="nav-link {{ request()->is('keranjang') ? 'active' : 'outline' }}">
                Keranjang
                @if($cartCount > 0)
                    <span>{{ $cartCount }}</span>
                @endif
            </a>

            @auth
                <form action="/logout" method="POST" class="form-logout">
                    @csrf
                    <button type="submit" class="nav-link outline btn-logout" aria-label="Keluar dari akun">Keluar</button>
                </form>
            @endauth
        </nav>
    </div>
</header>

<script>
    (function () {
        var btn = document.getElementById('navToggleBtn');
        var links = document.getElementById('navLinks');
        if (btn && links) {
            btn.addEventListener('click', function () {
                links.classList.toggle('open');
                var isExpanded = links.classList.contains('open');
                btn.setAttribute('aria-expanded', isExpanded);
            });
        }
    })();
</script>