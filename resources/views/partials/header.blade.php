<header class="bg-green-700 text-white">
    <div class="container mx-auto px-6 py-6">
        <h1 class="text-2xl font-bold">Sistem Manajemen Data Lingkungan</h1>
        <p class="text-sm mt-1 text-green-100">Platform Monitoring dan Pengelolaan Data Lingkungan</p>
    </div>
    
    <nav class="bg-white border-b border-gray-200">
        <div class="container mx-auto px-6">
            <ul class="flex space-x-8">
                <li>
                    <a href="{{ route('dashboard') }}" 
                       class="inline-block py-4 px-1 {{ request()->routeIs('dashboard') ? 'text-green-600 border-b-2 border-green-600' : 'text-gray-600 hover:text-green-600' }}">
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('wwtp.index') }}" 
                       class="inline-block py-4 px-1 {{ request()->routeIs('wwtp.*') ? 'text-green-600 border-b-2 border-green-600' : 'text-gray-600 hover:text-green-600' }}">
                        WWTP
                    </a>
                </li>
                <li>
                    <a href="{{ route('tps-produksi.index') }}" 
                       class="inline-block py-4 px-1 {{ request()->routeIs('tps-produksi.*') ? 'text-green-600 border-b-2 border-green-600' : 'text-gray-600 hover:text-green-600' }}">
                        TPS Produksi
                    </a>
                </li>
                <li>
                    <a href="{{ route('tps-domestik.index') }}" 
                       class="inline-block py-4 px-1 {{ request()->routeIs('tps-domestik.*') ? 'text-green-600 border-b-2 border-green-600' : 'text-gray-600 hover:text-green-600' }}">
                        TPS Domestik
                    </a>
                </li>
                <li>
                    <a href="{{ route('profile.index') }}" 
                       class="inline-block py-4 px-1 {{ request()->routeIs('profile.*') ? 'text-green-600 border-b-2 border-green-600' : 'text-gray-600 hover:text-green-600' }}">
                        Profile
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</header>