<style>
    :root {
        --primary: #c62828; 
        --bg-color: #fcfcfc;
        --border-color: #eaeaea;
        --text-main: #111111;
        --text-muted: #888888;
        --success: #2e7d32;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
    }

    body {
        display: flex;
        height: 100vh;
        background-color: var(--bg-color);
        color: var(--text-main);
        overflow: hidden;
    }

    /* ===== SIDEBAR ===== */
    .sidebar {
        width: 260px;
        background-color: #ffffff;
        border-right: 1px solid var(--border-color);
        display: flex;
        flex-direction: column;
        padding: 24px 16px;
        transition: width 0.25s ease, transform 0.25s ease;
        overflow: hidden;
        flex-shrink: 0;
    }

    .sidebar.collapsed {
        width: 0;
        padding-left: 0;
        padding-right: 0;
        border-right: none;
    }

    .brand-logo {
        font-family: 'Georgia', serif;
        font-size: 26px;
        font-weight: 900;
        color: var(--primary);
        text-align: center;
        margin-bottom: 40px;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }

    .nav-menu {
        list-style: none;
        display: flex;
        flex-direction: column;
        gap: 8px;
        flex-grow: 1;
    }

    .nav-item {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 12px 16px;
        border-radius: 6px;
        color: var(--text-main);
        text-decoration: none;
        font-weight: 700;
        font-size: 14px;
        transition: 0.2s;
        white-space: nowrap;
    }

    .nav-item i {
        font-size: 18px;
        width: 24px;
        text-align: center;
        flex-shrink: 0;
    }

    .nav-item.active {
        background-color: var(--primary);
        color: #ffffff;
    }

    .nav-item:hover:not(.active) {
        background-color: #f5f5f5;
    }
    
    .form-logout {
        margin-top: auto;
    }

    .logout-btn {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
        color: var(--primary);
        text-decoration: none;
        font-weight: 700;
        font-size: 14px;
        padding: 16px;
        border-top: 1px solid var(--border-color);
        border-left: none;
        border-right: none;
        border-bottom: none;
        background: transparent;
        width: 100%;
        cursor: pointer;
        white-space: nowrap;
    }

    /* ===== OVERLAY (Mobile) ===== */
    .sidebar-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.4);
        z-index: 199;
    }
    .sidebar-overlay.open { display: block; }

    /* ===== RESPONSIVE MOBILE ===== */
    @media (max-width: 900px) {
        body { overflow: visible; height: auto; }

        .sidebar {
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 200;
            transform: translateX(-100%);
            box-shadow: 4px 0 16px rgba(0, 0, 0, 0.15);
            width: 260px;
        }

        .sidebar.collapsed { width: 260px; padding: 24px 16px; border-right: 1px solid var(--border-color); }

        .sidebar.open { transform: translateX(0); }

        .menu-toggle { display: inline-flex !important; }
    }
</style>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<aside class="sidebar" id="adminDigitalSidebar">
    <div class="brand-logo">BrailleKita</div>

    <ul class="nav-menu">
        <a href="{{ route('admin.digital.dashboard') }}"
           class="nav-item {{ request()->routeIs('admin.digital.dashboard') ? 'active' : '' }}">
            <i class="fas fa-list-alt"></i> Dashboard
        </a>

        <a href="{{ route('admin.digital.pencetakan') }}"
           class="nav-item {{ request()->routeIs('admin.digital.pencetakan') ? 'active' : '' }}">
            <i class="fas fa-print"></i> Permintaan Pencetakan
        </a>

        <a href="{{ route('admin.digital.pic') }}"
           class="nav-item {{ request()->routeIs('admin.digital.pic') ? 'active' : '' }}">
            <i class="fas fa-users"></i> PIC
        </a>

        <a href="{{ route('admin.permintaan-bahan') }}"
           class="nav-item {{ request()->routeIs('admin.permintaan-bahan') ? 'active' : '' }}">
            <i class="fas fa-layer-group"></i> Permintaan Bahan
        </a>

        <a href="{{ route('admin.profile') }}"
           class="nav-item {{ request()->routeIs('admin.profile') ? 'active' : '' }}">
            <i class="far fa-user"></i> Profile
        </a>
    </ul>

    <form action="{{ url('/logout') }}" method="POST" class="form-logout">
        @csrf
        <button type="submit" class="logout-btn">
            <i class="fas fa-sign-out-alt"></i> Keluar
        </button>
    </form>
</aside>

<script>
    (function () {
        var sidebar = document.getElementById('adminDigitalSidebar');
        var overlay = document.getElementById('sidebarOverlay');

        document.addEventListener('click', function (e) {
            var toggleBtn = e.target.closest('.menu-toggle');
            if (!toggleBtn) return;

            if (window.innerWidth > 900) {
                sidebar.classList.toggle('collapsed');
                return;
            }

            sidebar.classList.toggle('open');
            overlay.classList.toggle('open');
        });

        overlay.addEventListener('click', function () {
            sidebar.classList.remove('open');
            overlay.classList.remove('open');
        });
    })();
</script>