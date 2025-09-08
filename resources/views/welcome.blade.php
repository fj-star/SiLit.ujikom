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
            <h1 class="logo">SILIT LAUNDRY</h1>
            <nav class="nav">
                <a href="#features">Fitur</a>
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
            <h2>Mengapa Memilih Kami?</h2>
            <div class="feature-grid">
                <div class="feature-item">
                    <h4>Fitur 1</h4>
                    <p>Deskripsi singkat tentang fitur pertama. Jelaskan manfaatnya bagi pengguna, bukan hanya namanya.</p>
                </div>
                <div class="feature-item">
                    <h4>Fitur 2</h4>
                    <p>Deskripsi singkat tentang fitur kedua. Tunjukkan bagaimana fitur ini menyelesaikan masalah pengguna.</p>
                </div>
                <div class="feature-item">
                    <h4>Fitur 3</h4>
                    <p>Deskripsi singkat tentang fitur ketiga. Beri tahu mengapa fitur ini membuat produk Anda unik.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="testimonials" class="testimonials">
        <div class="container">
            <h3>Apa Kata Mereka?</h3>
            <div class="testimonial-item">
                <p>"Produk ini benar-benar luar biasa! Sangat membantu dan mudah digunakan. Saya sangat merekomendasikannya!"</p>
                <cite>- Nama Pengguna 1</cite>
            </div>
            <div class="testimonial-item">
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

    <footer id="contact" class="footer">
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
    </footer>
<!-- <script>
  const hero = document.getElementById('hero');
  const images = [
    "{{ asset('assets/img/slide1.jpg') }}",
    "{{ asset('assets/img/slide2.jpg') }}",
    "{{ asset('assets/img/slide3.jpg') }}"
  ];

  let index = 0;
  function changeBackground() {
    hero.style.backgroundImage = `url(${images[index]})`;
   index = (index + 1) % images.length;

  }

  changeBackground();
  setInterval(changeBackground, 5000); // ganti setiap 5 detik
</script> -->


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



</body>
</html>

