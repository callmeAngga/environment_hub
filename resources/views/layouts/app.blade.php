<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', 'Sistem Manajemen Data Lingkungan - Indofood')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    <!-- CSS Files - Load BOTH -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"> <!-- CSS LAMA tetap ada -->
    <link rel="stylesheet" href="{{ asset('css/header-footer.css') }}"> <!-- CSS BARU khusus header/footer -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    @stack('styles')
</head>

<body>
    <!-- Loading Overlay -->
    <div id="loading-overlay" style="display: none;">
        <div class="loading-spinner"></div>
    </div>

    @include('partials.header')

    <main class="main-content">
        @yield('content')
    </main>

    @include('partials.footer')

    @stack('scripts')
    
    <script>
        // Global loading functions
        function showLoading() {
            document.getElementById('loading-overlay').style.display = 'flex';
        }
        
        function hideLoading() {
            document.getElementById('loading-overlay').style.display = 'none';
        }
        
        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('mobile-menu-toggle');
            const navList = document.querySelector('.header-nav .nav-list');
            
            if (menuToggle && navList) {
                menuToggle.addEventListener('click', function() {
                    navList.classList.toggle('active');
                    this.classList.toggle('active');
                });
            }
        });
    </script>
</body>

</html>