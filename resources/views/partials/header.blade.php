<header class="site-header">
    <!-- Main Header - Gabungan Top Bar + Main Header -->
    <div class="header-main">
        <div class="container">
            <div class="header-content">
                <!-- Left: Brand -->
                <div class="header-brand">
                    <div class="brand-logo">
                        <img src="{{ asset('images/logo_environment_hub.png') }}" alt="Environment Hub Logo">
                    </div>
                    <div class="brand-text">
                        <h1 class="brand-title">Sistem Manajemen Data Lingkungan</h1>
                        <p class="brand-subtitle">PT Indofood CBP Sukses Makmur Tbk</p>
                    </div>
                </div>

                <!-- Right: User Info + Logout -->
                <div class="header-right">
                    <div class="header-user">
                        <i class="fas fa-user-circle"></i>
                        <span>{{ Auth::user()->name ?? 'User' }}</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-logout">
                            <i class="fas fa-sign-out-alt"></i>
                            Logout
                        </button>
                    </form>
                </div>

                <!-- Mobile Menu Toggle -->
                <button class="mobile-menu-toggle" id="mobile-menu-toggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="header-nav">
        <div class="container">
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-chart-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('wwtp.index') }}"
                        class="nav-link {{ request()->routeIs('wwtp.*') ? 'active' : '' }}">
                        <i class="fas fa-water"></i>
                        <span>WWTP</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('tps-produksi.index') }}"
                        class="nav-link {{ request()->routeIs('tps-produksi.*') ? 'active' : '' }}">
                        <i class="fas fa-industry"></i>
                        <span>TPS Produksi</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('tps-domestik.index') }}"
                        class="nav-link {{ request()->routeIs('tps-domestik.*') ? 'active' : '' }}">
                        <i class="fas fa-home"></i>
                        <span>TPS Domestik</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('profile.index') }}"
                        class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                        <i class="fas fa-cog"></i>
                        <span>Profile</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</header>