<header>
    <div class="main-header">
        <div class="container">
            <h1 class="header-title">Sistem Manajemen Data Lingkungan</h1>
            <p class="header-subtitle">Platform Monitoring dan Pengelolaan Data Lingkungan</p>
        </div>
    </div>
    
    <nav class="main-nav">
        <div class="container">
            <ul class="nav-list">
                <li>
                    <a href="{{ route('dashboard') }}" 
                       class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('wwtp.index') }}" 
                       class="nav-link {{ request()->routeIs('wwtp.*') ? 'active' : '' }}">
                        WWTP
                    </a>
                </li>
                <li>
                    <a href="{{ route('tps-produksi.index') }}" 
                       class="nav-link {{ request()->routeIs('tps-produksi.*') ? 'active' : '' }}">
                        TPS Produksi
                    </a>
                </li>
                <li>
                    <a href="{{ route('tps-domestik.index') }}" 
                       class="nav-link {{ request()->routeIs('tps-domestik.*') ? 'active' : '' }}">
                        TPS Domestik
                    </a>
                </li>
                <li>
                    <a href="{{ route('profile.index') }}" 
                       class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                        Profile
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</header>