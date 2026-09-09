<header class="topbar">
    <div class="topbar-left">
        <button type="button" class="menu-toggle">
            <i class="fas fa-bars"></i>
        </button>
        <span class="topbar-title">{{ $title ?? 'Dashboard' }}</span>
    </div>
    
    <div class="topbar-right" style="display: flex; align-items: center; gap: 24px;">
        {{-- Ikon Notifikasi --}}
        <i class="far fa-bell notification-bell" style="font-size: 20px; cursor: pointer;"></i>
    
        {{-- Elemen Profil Clickable menuju Halaman Profil --}}
        <a href="{{ route('admin.profile') }}" style="display: flex; align-items: center; gap: 12px; text-decoration: none; color: var(--text-dark); cursor: pointer;">
            
            {{-- Nama Admin --}}
            <span style="font-weight: 700; font-size: 16px;">
                {{ auth()->user()->nama ?? 'Admin Pengiriman' }}
            </span>
            
            {{-- Foto / Ikon Avatar (Otomatis ambil dari database) --}}
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