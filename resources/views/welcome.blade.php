<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nama Produk Anda - Landing Page Keren</title>
    <link rel="stylesheet" href="{{ asset ('assets/css/style.css') }}">
</head>
<body>

    <header class="header" >
        <div class="container">
            <h1 class="logo">
             <img src="assets/img/logo.jpg" style="height:50px; vertical-align:middle; margin-right:10px;">    
            SILIT LAUNDRY</h1>
            <nav class="nav">
                <a href="#features">Tentang Kami</a>
                <a href="#testimonials">Testimoni</a>
                <a href="#contact">Kontak</a>
                <a href="{{ route('login') }}" class="footer-link">Login</a>  
                {{-- <a href="{{ route('register') }}" class="footer-link">Register</a> --}}
            </nav>
        </div>
    </header>

    <section class="slider" id="slide">

       <div class="slider-container">
         <button onclick="prevSlide()" class="btn-left">⟵</button>

  <button onclick="nextSlide()" class="btn-right">⟶</button>
  <div class="slider" id="slider">
    <div class="slide" style="background-image: url('{{ asset('assets/img/slide1.webp') }}')"></div>
    <div class="slide" style="background-image: url('{{ asset('assets/img/slide2.webp') }}')">

          <h2>Solusi Terbaik untuk Kebutuhan Anda</h2>
        
        <p class="bottom">Lorem ipsum dolor sit amet consectetur adipisicing elit. Illo minus rerum iste eligendi mollitia cum veritatis quas iure deleniti doloremque. Cumque libero dolore voluptatem veritatis est animi rem harum ad.</p>
            <a href="#cta" class="button">Dapatkan Sekarang Juga!</a>
    </div>
    <div class="slide" style="background-image: url('{{ asset('assets/img/tim7.webp') }}')"></div>

     <!-- Tombol -->
 
  </div>

    </section>

    <section id="features" class="features">
        <div class="container">
            <h2>Tentang Kami </h2>
            <div class="feature-grid">
                <div class="feature-item">
                     <img src="assets/img/kami1.png" alt="Logo Laundry" class="feature-logo">
                    <p>
                        Kami adalah layanan laundry modern yang hadir untuk membantu Anda menjaga kebersihan dan kesegaran pakaian setiap hari. Dengan dukungan tenaga profesional, mesin cuci berteknologi terbaru, serta penggunaan deterjen berkualitas, kami berkomitmen memberikan hasil terbaik untuk setiap cucian.
                    </p>
                </div>
                <div class="feature-item">
                     <img src="assets/img/kami2.png" alt="Logo Laundry" class="feature-logo">
                    <p>Kami memahami betapa berharganya waktu Anda, karena itu kami menyediakan layanan antar jemput gratis, sehingga Anda bisa tetap fokus pada aktivitas penting tanpa harus repot mengurus cucian.</p>
                </div>
                <div class="feature-item">
                     <img src="assets/img/kami3.png" alt="Logo Laundry" class="feature-logo">
                    <p>Visi kami adalah menjadi pilihan utama masyarakat dalam layanan laundry dengan mengutamakan kebersihan, ketepatan waktu, dan kepuasan pelanggan.</p>
                </div>
            </div>
        </div>
    </section>

    <section style="display:flex; align-items:center; gap:20px; max-width:1000px; margin:40px auto; font-family:Arial, sans-serif;">
  
  <!-- Gambar -->
  <div style="flex:1;">
    <img src="assets/img/slide4.webp" alt="Outbound Pangalengan" style="width:100%; border-radius:10px;">
  </div>

  <!-- Box Deskripsi -->
  <div style="flex:1; margin-left:-100px; text-align:left; background-color:#007bff; color:#fff; padding:20px; border-radius:15px;">
    <h2 style="margin-top:0; font-size:22px;">Team 7 <br>Silit Laundry</h2>
    <hr style="width:50px; border:2px solid #fff; margin:10px 0;">
    <p style="line-height:1.6; font-size:16px;">
      Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi sed reiciendis magni nam nesciunt, voluptates iure esse incidunt est itaque corrupti. Iste, sapiente praesentium. Nostrum quis iure beatae deserunt consectetur!
    </p>
    <a href="#" style="display:inline-block; margin-top:15px; padding:10px 20px; background:#fff; color:#333; text-decoration:none; border-radius:25px; font-weight:bold;">
      Selengkapnya &nbsp; ›
    </a>
  </div>

</section>


    <section id="testimonials" class="testimonials">
        <div class="container">
            <h3>Apa Kata Mereka?</h3>
            <div class="testimonial-item">
                <i class="fas fa-user-circle user-icon"></i>
                <div class="stars">⭐⭐⭐⭐⭐⭐</div>
                <p>"Produk ini benar-benar luar biasa! Sangat membantu dan mudah digunakan. Saya sangat merekomendasikannya!"</p>
                <cite>- Nama Pengguna 1</cite>
            </div>
            <div class="testimonial-item">
                <i class="fas fa-user-circle user-icon"></i>
                <div class="stars">⭐⭐⭐⭐⭐⭐</div>
                <p>"Layanan pelanggan mereka sangat responsif. Saya senang bisa menggunakan produk ini setiap hari."</p>
                <cite>- Nama Pengguna 2</cite>
            </div>
        </div>
    </section>

    <section id="cta" class="cta">
        <div class="container">
            
            <h3>Siap untuk Mulai?</h3>
            <p>Jangan lewatkan kesempatan. Gabung dengan ribuan pengguna lain yang sudah merasakan manfaatnya.</p>
            <a href="{{ route('register') }}" class="button button-cta">Daftar Sekarang!</a>
        </div>
    </section>

    <!-- <footer id="contact" class="footer">
        <div class="container">
            <div class="footer-links">
                <p>&copy; 2025  Silit. Team IT Nurul Islam Affandiyah.</p>
                <div>
                    <a href="#">Facebook</a> | 
                    <a href="#">Instagram</a>
                </div>
            </div>
            <div class="footer-auth">
                
            </div>
        </div>
    </footer> -->
<footer id="contact" class="footer" style=" background:#f8f9fa; padding:40px 0; font-family:Arial, sans-serif; color:#333;">
  <div class="container" style="align-items: center;
            max-width:1200px; margin:auto; display:flex; flex-wrap:wrap; justify-content:space-between; align-items:flex-start; gap:30px;">

    <!-- Logo dan Deskripsi -->
    <div style="flex:1 1 300px; text-align:left; max-width:350px;">
  <img src="assets/img/logo.jpg" alt="Logo" style="height:150px; margin-bottom:15px; display:block;">

  <p style="margin-bottom:20px; line-height:1.6; margin:2;">
     Menyediakan layanan Laundry Kiloan, Satuan, Dry Cleaning, Antar Jemput, 
  serta Perawatan Pakaian dengan kualitas terbaik, cepat, dan harga terjangkau 
  untuk memenuhi kebutuhan harian Anda.
  </p>

  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15846.559421137525!2d107.23371995541993!3d-6.813584899999988!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6855fe2dae0077%3A0x97d4599eeb3422c1!2sIndo%20Express%20Laundry%20Ciranjang!5e0!3m2!1sid!2sid!4v1757385591883!5m2!1sid!2sid" width="250" height="150" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

  <p style="margin-top:15px; line-height:1.6;">
    <span style="font-size:14px;">📍 Jl. Raya Bandung No.117, Ciranjang, Kec. Ciranjang, Kabupaten Cianjur, Jawa Barat 43282</span>
  </p>
</div>


    <!-- Layanan -->
    <div style="flex:1 1 200px;">
      <h3 style="margin-bottom:15px; font-size:18px;">Layanan</h3>
      <ul style="list-style:none; padding:0; line-height:1.8;">
        <li>We</li>
        <li>D</li>
        <li>C</li>
        <li>C</li>
      </ul>
    </div>

    <!-- Hubungi Kami -->
    <div style="flex:1 1 200px;">
      <h3 style="margin-bottom:15px; font-size:18px;">Hubungi Kami</h3>
      <p>PA.BUDI</p>
      <p>MANG.UJANG</p>
      <p>PA.ACENG</p>
      <p>PA.ESTRA</p>
      <p>PA.ABDUL</p>
      <p>PA.ENGKUS</p>

    </div>
  </div>

  <!-- Copyright -->
  <div style="text-align:center; margin-top:30px; font-size:14px; border-top:1px solid #8a8a8aff; padding-top:15px;">
    Copyright 2026 blablaablalbalab
  </div>
</footer>



  <script>
  const slider = document.getElementById("slider");
  const slides = document.querySelectorAll(".slide");
  let index = 0;

  function showSlide() {
    slider.style.transform = `translateX(-${index * 100}%)`;
  }

  function nextSlide() {
    index = (index + 1) % slides.length;
    showSlide();
  }

  function prevSlide() {
    index = (index - 1 + slides.length) % slides.length;
    showSlide();
  }

  // auto geser kanan tiap 5 detik
  setInterval(nextSlide, 5000);
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


</body>
</html>

