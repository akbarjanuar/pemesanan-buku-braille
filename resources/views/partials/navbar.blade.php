@php
    $cartCount = auth()->check() ? \App\Models\Keranjang::where('user_id', auth()->id())->sum('jumlah') : 0;
@endphp

<style>
    .navbar { background: var(--primary, #c62828); color: white; position: sticky; top: 0; z-index: 100; }
    .navbar-container { max-width: 1200px; margin: 0 auto; padding: 0 20px; display: flex; align-items: center; gap: 12px; min-height: 64px; }
    .nav-logo { background: white; color: var(--primary, #c62828); font-weight: 700; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 6px; font-size: 18px; flex-shrink: 0; }
    .nav-brand { font-size: 20px; font-weight: 700; }
    .nav-spacer { flex-grow: 1; }

    .nav-links { display: flex; align-items: center; gap: 8px; }
    .nav-link { padding: 8px 16px; border-radius: 6px; font-weight: 700; font-size: 15px; border: 1px solid transparent; white-space: nowrap; display: flex; align-items: center; gap: 6px; }
    .nav-link.active { background-color: white; color: var(--primary, #c62828); }
    .nav-link.outline { border-color: rgba(255, 255, 255, 0.4); }
    .nav-link.outline:hover { background-color: rgba(255, 255, 255, 0.1); }

    .nav-toggle {
        display: none;
        background: transparent; border: none; color: white;
        font-size: 26px; cursor: pointer; padding: 4px 8px;
        line-height: 1;
    }

    @media (max-width: 860px) {
        .navbar-container { flex-wrap: wrap; padding: 10px 16px; }
        .nav-brand { font-size: 17px; }
        .nav-toggle { display: block; margin-left: auto; }

        .nav-links {
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
        .nav-link { justify-content: flex-start; width: 100%; }
        .nav-link.active { justify-content: flex-start; }
    }
</style>

<header class="navbar">
    <div class="navbar-container">
        <div class="nav-logo">B</div>
        <a href="/" class="nav-brand">BrailleKita</a>
        <div class="nav-spacer"></div>

        <button type="button" class="nav-toggle" id="navToggleBtn" aria-label="Buka menu">&#9776;</button>

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
                <span style="margin: 0 8px; font-size: 15px;">Halo, {{ auth()->user()->nama ?? 'Pengguna' }}</span>
                <form action="/logout" method="POST" style="display:inline; width:100%;">
                    @csrf
                    <button type="submit" class="nav-link outline" style="background:transparent; cursor:pointer; font-family: inherit; color: white; width:100%;">Keluar</button>
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
            });
        }
    })();
</script>