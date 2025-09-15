<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Silit Laundry - Solusi Kebersihan Pakaian Anda</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <header class="header">
        <div class="container">
            <h1 class="logo">
                <img src="assets/img/logo.jpg" alt="Logo Silit Laundry"> Silit Laundry
            </h1>
            <nav class="nav">
                <a href="#about" class="nav-link">Tentang Kami</a>
                <a href="#services" class="nav-link">Layanan</a>
                <a href="#testimonials" class="nav-link">Testimoni</a>
                <a href="#contact" class="nav-link">Kontak</a>
                <a href="{{ route('login') }}" class="button nav-link login-button">Login</a> 
            </nav>
        </div>
    </header>

    <section class="hero-slider">
        <div class="slider-container">
            <div class="slider" id="slider">
                <div class="slide" style="background-image: url('assets/img/slide1.webp')">
                    <div class="slide-content">
                        <h2>Solusi Laundry Profesional</h2>
                        <p>Kami hadir untuk memberikan solusi kebersihan pakaian terbaik dengan teknologi modern dan pelayanan ramah.</p>
                        <a href="#cta" class="button">Pelajari Lebih Lanjut</a>
                    </div>
                </div>
                <div class="slide" style="background-image: url('assets/img/slide2.webp')">
                    <div class="slide-content">
                        <h2>Layanan Antar Jemput Gratis</h2>
                        <p>Nikmati kemudahan layanan antar jemput gratis, agar Anda bisa lebih fokus pada hal penting lainnya.</p>
                        <a href="{{ route('register') }}" class="button">Daftar Sekarang!</a>
                    </div>
                </div>
                <div class="slide" style="background-image: url('assets/img/tim7.webp')">
                    <div class="slide-content">
                         <h2>Kecepatan & Kebersihan Optimal</h2> 
                        <p>Kami memastikan pakaian Anda bersih, rapi, dan wangi dalam waktu singkat tanpa mengurangi kualitas.</p> --}}
                        <a href="#cta" class="button">Hubungi Kami</a>
                    </div>
                </div>
            </div>
            <button onclick="prevSlide()" class="btn-slider btn-left"><i class="fas fa-chevron-left"></i></button>
            <button onclick="nextSlide()" class="btn-slider btn-right"><i class="fas fa-chevron-right"></i></button>
        </div>
    </section>

    <section id="about" class="section about-us">
        <div class="container">
            <h2 class="section-title fade-in">Tentang Kami</h2>
            <div class="feature-grid fade-in">
                <div class="feature-item">
                    <i class="fas fa-soap feature-icon"></i>
                    <h3>Profesional & Berpengalaman</h3>
                    <p>Kami adalah layanan laundry modern yang hadir untuk membantu Anda menjaga kebersihan dan kesegaran pakaian setiap hari.</p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-truck-pickup feature-icon"></i>
                    <h3>Layanan Antar Jemput</h3>
                    <p>Kami memahami betapa berharganya waktu Anda, karena itu kami menyediakan layanan antar jemput gratis.</p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-hand-holding-heart feature-icon"></i>
                    <h3>Visi & Misi</h3>
                    <p>Visi kami adalah menjadi pilihan utama masyarakat dalam layanan laundry dengan mengutamakan kebersihan dan kepuasan pelanggan.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="services" class="section team-section">
        <div class="container team-content">
            <div class="team-text fade-in-left">
                <h2 class="section-title">Layanan Kami</h2>
                <hr class="divider">
                <p>Kami menawarkan berbagai layanan laundry untuk memenuhi kebutuhan spesifik Anda, mulai dari laundry kiloan, satuan, hingga dry cleaning. Setiap layanan kami ditangani dengan cermat oleh tim profesional untuk hasil yang maksimal.</p>
                <a href="#" class="button">Lihat Semua Layanan</a>
            </div>
            <div class="team-image fade-in-right">
                <img src="assets/img/slide4.webp" alt="Tim Silit Laundry">
            </div>
        </div>
    </section>

    <section id="testimonials" class="section testimonials">
        <div class="container">
            <h2 class="section-title fade-in">Apa Kata Mereka?</h2>
            <div class="testimonial-grid fade-in">
                <div class="testimonial-item">
                    <div class="rating-user-info">
                        <i class="fas fa-user-circle user-icon"></i>
                        <div class="stars">⭐⭐⭐⭐⭐</div>
                    </div>
                    <p>"Produk ini benar-benar luar biasa! Sangat membantu dan mudah digunakan. Saya sangat merekomendasikannya!"</p>
                    <cite>- Nama Pengguna 1</cite>
                </div>
                <div class="testimonial-item">
                    <div class="rating-user-info">
                        <i class="fas fa-user-circle user-icon"></i>
                        <div class="stars">⭐⭐⭐⭐⭐</div>
                    </div>
                    <p>"Layanan pelanggan mereka sangat responsif. Saya senang bisa menggunakan produk ini setiap hari."</p>
                    <cite>- Nama Pengguna 2</cite>
                </div>
            </div>
        </div>
    </section>

    <section id="cta" class="section cta-section">
        <div class="container fade-in">
            <h3 class="section-title">Siap untuk Mulai?</h3>
            <p>Dapatkan pengalaman laundry terbaik. Gabung dengan ribuan pelanggan lain yang sudah merasakan manfaatnya.</p>
            <a href="{{ route('register') }}" class="button button-cta">Daftar Sekarang!</a>
        </div>
    </section>

    <footer id="contact" class="footer">
        <div class="container">
            <div class="footer-col">
                <img src="assets/img/logo.jpg" alt="Logo Footer" class="footer-logo">
                <p>Menyediakan layanan Laundry Kiloan, Satuan, Dry Cleaning, Antar Jemput, serta Perawatan Pakaian dengan kualitas terbaik.</p>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.551608674516!2d107.13689231477317!3d-6.944208595018659!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e690a8a65f1c247%3A0x6a1c5d9c7d413c6!2sJl.%20Raya%20Bandung%20No.117%2C%20Ciranjang%2C%20Kec.%20Ciranjang%2C%20Kabupaten%20Cianjur%2C%20Jawa%20Barat%2043282!5e0!3m2!1sid!2sid!4v1638421876807!5m2!1sid!2sid" width="100%" height="200" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                <p class="footer-address">📍 Jl. Raya Bandung No.117, Ciranjang, Kab. Cianjur</p>
            </div>
            <div class="footer-col">
                <h3>Layanan</h3>
                <ul class="footer-list">
                    <li><a href="#">Laundry Kiloan</a></li>
                    <li><a href="#">Laundry Satuan</a></li>
                    <li><a href="#">Dry Cleaning</a></li>
                    <li><a href="#">Antar Jemput</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h3>Hubungi Kami</h3>
                <ul class="footer-list">
                    <li><a href="https://wa.me/6283873304630">Muhamad Fazril</a></li>
                    <li><a href="https://wa.me/6283189454760">M Rifqy</a></li>
                    <li><a href="https://wa.me/6285865812892">M Ridho</a></li>
                    <li><a href="https://wa.me/6287739973366">Aldira Firdaus</a></li>
                    <li><a href="https://wa.me/6281318316350">Fachri Rido</a></li>
                    <li><a href="https://wa.me/6285938608981">M Fiki Jamal</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>Copyright &copy; 2024 Silit Laundry. All Rights Reserved.</p>
            <div class="social-links">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </footer>

    <script src="assets/js/script.js"></script>
    <script src="assets/js/animations.js"></script>
</body>
</html>