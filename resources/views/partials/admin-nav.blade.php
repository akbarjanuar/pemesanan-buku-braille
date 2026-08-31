@php
    $activeMenu = $activeMenu ?? 'dashboard';
@endphp

<link href="https://fonts.googleapis.com/css2?family=Atkinson+Hyperlegible:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    :root {
        --primary: #c62828;
        --primary-hover: #b71c1c;
        --background: #f4f6f9;
        --surface: #ffffff;
        --text-dark: #111111;
        --text-muted: #757575;
        --border: #e0e0e0;
        --sidebar-width: 260px;
    }

    *, *::before, *::after {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: 'Atkinson Hyperlegible', sans-serif;
        background-color: var(--background);
        color: var(--text-dark);
        display: flex;
        height: 100vh;
        overflow: hidden;
    }

    a {
        text-decoration: none;
        color: inherit;
    }

    ul {
        list-style: none;
    }

    /* ===== SIDEBAR ===== */
    .sidebar {
        width: var(--sidebar-width);
        background-color: var(--surface);
        border-right: 1px solid var(--border);
        display: flex;
        flex-direction: column;
        flex-shrink: 0;
        transition: width 0.25s ease, transform 0.25s ease;
        overflow: hidden;
    }

    /* Sidebar tertutup di desktop */
    .sidebar.collapsed {
        width: 0;
        border-right: none;
    }

    .sidebar-brand {
        padding: 24px;
        text-align: center;
        border-bottom: 1px solid var(--border);
    }

    .sidebar-brand h1 {
        color: var(--primary);
        font-size: 24px;
        font-weight: 700;
        font-family: Georgia, serif;
    }

    .sidebar-menu {
        padding: 20px 16px;
        flex-grow: 1;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .nav-item {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 14px 16px;
        border-radius: 8px;
        color: var(--text-dark);
        font-weight: 700;
        font-size: 15px;
        transition: all 0.2s ease;
    }

    .nav-item i {
        font-size: 18px;
        width: 20px;
        text-align: center;
    }

    .nav-item:hover:not(.active) {
        background-color: #f5f5f5;
    }

    .nav-item.active {
        background-color: var(--primary);
        color: white;
    }

    .sidebar-footer {
        padding: 16px 24px;
        border-top: 1px solid var(--border);
    }

    .btn-logout {
        display: flex;
        align-items: center;
        gap: 12px;
        color: var(--primary);
        font-weight: 700;
        font-size: 15px;
        background: none;
        border: none;
        cursor: pointer;
        width: 100%;
        font-family: inherit;
    }

    .btn-logout:hover {
        color: var(--primary-hover);
    }

    /* ===== MAIN WRAPPER ===== */
    .main-wrapper {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        transition: all 0.25s ease;
    }

    /* ===== TOPBAR ===== */
    .topbar {
        height: 70px;
        background-color: var(--surface);
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 32px;
        flex-shrink: 0;
    }

    .topbar-left {
        display: flex;
        align-items: center;
        gap: 16px;
        font-size: 20px;
        font-weight: 700;
    }

    /* ===== TOMBOL HAMBURGER ===== */
    .menu-toggle {
        color: var(--text-muted);
        cursor: pointer;
        font-size: 20px;
        background: none;
        border: none;
        padding: 0;
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        width: 24px;
        height: 24px;
        flex-shrink: 0;
    }

    .menu-toggle:hover {
        color: var(--primary);
    }

    .topbar-right {
        display: flex;
        align-items: center;
        gap: 24px;
    }

    .search-box {
        position: relative;
    }

    .search-box i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        font-size: 14px;
    }

    .search-box input {
        padding: 8px 16px 8px 36px;
        border: 1px solid var(--border);
        border-radius: 20px;
        font-family: inherit;
        font-size: 14px;
        outline: none;
        width: 250px;
        transition: border-color 0.2s;
    }

    .search-box input:focus {
        border-color: var(--primary);
    }

    .notification-bell {
        font-size: 20px;
        color: var(--text-dark);
        cursor: pointer;
    }

    .user-profile {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 700;
        font-size: 15px;
        cursor: pointer;
    }

    .user-profile i {
        font-size: 24px;
    }

    .content-area {
        padding: 32px;
        overflow-y: auto;
        flex-grow: 1;
    }

    /* ===== SIDEBAR OVERLAY MOBILE ===== */
    .sidebar-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.4);
        z-index: 199;
    }

    .sidebar-overlay.open {
        display: block;
    }

    /* ===== RESPONSIVE MOBILE ===== */
    @media (max-width: 900px) {

        body {
            overflow: visible;
            height: auto;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 200;
            transform: translateX(-100%);
            box-shadow: 4px 0 16px rgba(0, 0, 0, 0.15);
        }

        /* Jangan biarkan collapsed = 0 di mobile */
        .sidebar.collapsed {
            width: var(--sidebar-width);
        }

        .sidebar.open {
            transform: translateX(0);
        }

        .menu-toggle {
            display: inline-flex !important;
        }

        .topbar {
            padding: 0 16px;
        }

        .topbar-right {
            gap: 12px;
        }

        .search-box {
            display: none;
        }

        .main-wrapper {
            height: auto;
        }

        .content-area {
            overflow-y: visible;
            padding: 20px 16px;
        }
    }
</style>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<aside class="sidebar" id="adminSidebar">

    <div class="sidebar-brand">
        <h1>BrailleKita</h1>
    </div>

    <nav class="sidebar-menu">

        <a href="/admin/dashboard"
           class="nav-item {{ $activeMenu === 'dashboard' ? 'active' : '' }}">
            <i class="fas fa-th-large"></i>
            Dashboard
        </a>

        <a href="/admin/permintaan-buku"
           class="nav-item {{ $activeMenu === 'permintaan-buku' ? 'active' : '' }}">
            <i class="far fa-file-alt"></i>
            Permintaan Buku
        </a>

        <a href="/admin/kelola-buku"
           class="nav-item {{ $activeMenu === 'kelola-buku' ? 'active' : '' }}">
            <i class="fas fa-book"></i>
            Kelola Buku
        </a>

        <a href="/admin/pencetakan"
           class="nav-item {{ $activeMenu === 'pencetakan' ? 'active' : '' }}">
            <i class="fas fa-print"></i>
            Pencetakan
        </a>

        <a href="#"
           class="nav-item {{ $activeMenu === 'pengiriman' ? 'active' : '' }}">
            <i class="fas fa-truck"></i>
            Pengiriman
        </a>

        <a href="/admin/data-pelanggan"
           class="nav-item {{ $activeMenu === 'data-pelanggan' ? 'active' : '' }}">
            <i class="fas fa-users"></i>
            Data Pelanggan
        </a>

        <a href="#"
           class="nav-item {{ $activeMenu === 'permintaan-bahan' ? 'active' : '' }}">
            <i class="fas fa-layer-group"></i>
            Permintaan Bahan
        </a>

        <a href="#"
           class="nav-item {{ $activeMenu === 'laporan' ? 'active' : '' }}">
            <i class="fas fa-chart-line"></i>
            Laporan
        </a>

        <a href="#"
           class="nav-item {{ $activeMenu === 'profile' ? 'active' : '' }}">
            <i class="far fa-user"></i>
            Profile
        </a>

    </nav>

    <div class="sidebar-footer">
        <form action="/logout" method="POST" style="margin: 0;">
            @csrf

            <button type="submit" class="btn-logout">
                <i class="fas fa-sign-out-alt"></i>
                Keluar
            </button>
        </form>
    </div>

</aside>

<script>
    (function () {

        var sidebar = document.getElementById('adminSidebar');
        var overlay = document.getElementById('sidebarOverlay');

        document.addEventListener('click', function (e) {

            var toggleBtn = e.target.closest('.menu-toggle');

            if (!toggleBtn) {
                return;
            }

            /* =========================
               DESKTOP / LAPTOP
               ========================= */
            if (window.innerWidth > 900) {

                sidebar.classList.toggle('collapsed');

                return;
            }

            /* =========================
               MOBILE / HP
               ========================= */

            sidebar.classList.toggle('open');
            overlay.classList.toggle('open');

        });

        /* Klik area gelap untuk menutup sidebar di HP */
        overlay.addEventListener('click', function () {

            sidebar.classList.remove('open');
            overlay.classList.remove('open');

        });

    })();
</script>