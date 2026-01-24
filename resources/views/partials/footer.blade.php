<footer class="site-footer">
    <div class="footer-main">
        <div class="container">
            <div class="footer-grid">
                <!-- Company Info -->
                <div class="footer-column">
                    <h3 class="footer-title">PT Indofood</h3>
                    <p class="footer-text">
                        Sistem Manajemen Data Lingkungan untuk monitoring dan pengelolaan data lingkungan secara terpadu dan terintegrasi.
                    </p>
                </div>

                <!-- Quick Links -->
                <div class="footer-column">
                    <h3 class="footer-title">Quick Links</h3>
                    <ul class="footer-links">
                        <li><a href="{{ route('dashboard') }}"><i class="fas fa-chevron-right"></i> Dashboard</a></li>
                        <li><a href="{{ route('wwtp.index') }}"><i class="fas fa-chevron-right"></i> WWTP</a></li>
                        <li><a href="{{ route('tps-produksi.index') }}"><i class="fas fa-chevron-right"></i> TPS Produksi</a></li>
                        <li><a href="{{ route('tps-domestik.index') }}"><i class="fas fa-chevron-right"></i> TPS Domestik</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="footer-column">
                    <h3 class="footer-title">Kontak</h3>
                    <ul class="footer-contact">
                        <li>
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Jakarta, Indonesia</span>
                        </li>
                        <li>
                            <i class="fas fa-phone"></i>
                            <span>+62 21 xxxx xxxx</span>
                        </li>
                        <li>
                            <i class="fas fa-envelope"></i>
                            <span>info@indofood.co.id</span>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="container">
            <div class="footer-bottom-content">
                <p class="footer-copyright">
                    © {{ date('Y') }} PT Indofood. All Rights Reserved.
                </p>
            </div>
        </div>
    </div>
</footer>