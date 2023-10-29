<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>SAZ.Net</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ asset('/assets/img/brand/atas.png') }}" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">


  <!-- GooglFe Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('/assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{ asset('/assets/css/style.css') }}" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Appland
  * Updated: Jul 27 2023 with Bootstrap v5.3.1
  * Template URL: https://bootstrapmade.com/free-bootstrap-app-landing-page-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top  header-transparent ">
    <div class="container d-flex align-items-center justify-content-between">

      <div class="logo">
                <img src="{{ asset('/assets/img/brand/logo1.png') }}">
            </a>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="index.html"><img src="{{ asset('/assets/img/logo.png" alt="" class=') }}"img-fluid"></a>-->
      </div>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
          <li><a class="nav-link scrollto" href="#about">About</a></li>
          <li><a class="nav-link scrollto" href="#pricing">Packages</a></li>
          <li><a class="nav-link scrollto" href="#contact">Contact</a></li>
          <li class="nav-item">
            <a href="{{ route('login') }}" class="nav-link">
                <span class="nav-link-inner--text">Login</span>
            </a>
        </li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center">

    <div class="container">
      <div class="row">
        <div class="col-lg-6 d-lg-flex flex-lg-column justify-content-center align-items-stretch pt-5 pt-lg-0 order-2 order-lg-1" data-aos="fade-up">
          <div>
          <h1>SAZ.Net</h1>
<h2>Rasakan kebebasan internet tanpa batasan bersama SAZ.Net. Langganan sekarang untuk akses internet andal dan praktis. Membuat dunia online lebih dekat dan lebih terhubung.</h2>

            <a href="{{ route('register') }}" class="download-btn text-center"> Langganan Sekarang </a>
          </div>
        </div>
        <div class="col-lg-6 d-lg-flex flex-lg-column align-items-stretch order-1 order-lg-2 hero-img" data-aos="fade-up">
          <img src="{{ asset('/assets/img/landing.png') }}" class="img-fluid" alt="">
        </div>
      </div>
    </div>

  </section><!-- End Hero -->

  <main id="main">

  <section id="about" class="about">
      <div class="container" data-aos="fade-up">


      <div class="section-title">
    <h2>About SAZ.Net</h2>
</div>

<div class="row">
    <div class="col-md-6">
        <img src="{{ asset('/assets/img/brand/logoatas.png') }}" class="img-fluid" alt="">
    </div>
    <div class="col-md-6">
        <p>
            Selamat datang di SAZ.Net, tempat di mana teknologi bertemu dengan komitmen pribadi. Kami adalah penyedia layanan internet yang bertekad untuk menghadirkan pengalaman terkoneksi yang tak hanya andal, tetapi juga mendalam secara personal.
        </p>
        <p>
            Nama "SAZ" adalah singkatan dari Salwa Adia Zahra, pendiri kami, yang memiliki visi untuk memberikan pengalaman internet yang tak hanya melayani, tetapi juga merangkul setiap pelanggan dengan cinta dan perhatian.
        </p>
        <p>
            Misi kami adalah sederhana: kami berusaha untuk memberikan akses internet yang berkualitas tinggi yang tidak hanya memenuhi kebutuhan digital Anda, tetapi juga meningkatkan kehidupan sehari-hari Anda. Kami berkomitmen untuk menciptakan pengalaman terkoneksi yang memungkinkan Anda menjelajahi dunia, berkomunikasi, dan mencapai potensi Anda dengan lebih mudah.
        </p>
        <p>
            Kami yakin bahwa koneksi internet adalah pintu gerbang menuju masa depan yang lebih terhubung. Oleh karena itu, kami mengintegrasikan nilai-nilai kami dalam setiap aspek layanan kami: Personalitas, Kualitas, Inovasi, dan Dukungan Pelanggan.
        </p>
        <p>
            Di belakang setiap koneksi yang kami sediakan adalah tim yang berdedikasi dan berpengetahuan luas dalam bidang teknologi internet. Dari teknisi jaringan hingga tim dukungan pelanggan, setiap anggota tim kami berusaha keras untuk memberikan pengalaman yang tak tertandingi kepada pelanggan kami.
        </p>
        <p>
            Terima kasih atas kepercayaan Anda kepada SAZ.Net sebagai mitra terpercaya Anda dalam dunia terkoneksi. Kami berkomitmen untuk terus memenuhi harapan Anda dan memberikan pengalaman terkoneksi yang tak terlupakan.
        </p>
    </div>
</div>


    <!-- ======= Pricing Section ======= -->
    <section id="pricing" class="pricing">
        <div class="container">

          <div class="section-title">
          <h2>Package Options</h2>
            <p></p>
          </div>

          <div class="row no-gutters">
            @foreach ($pakets as $id => $paket)
            <div class="col-lg-4 box" data-aos="fade-right">
                <h3>{{ $paket->nama_paket }}</h3>
                <h4>{{ $paket->paket }}</h4>
                <h3>Rp {{ number_format($paket->abodemen,0,',','.') }}<span>/bulan</span></h3>
                <a href="{{ route('register', ['selected_paket_id' => $paket->id]) }}" class="btn btn-primary my-4">Berlangganan Sekarang</a>

              </div>

            @endforeach

          </div>

        </div>
      </section><!-- End Pricing Section -->

      <section id="contact" class="contact">
  <div class="container" data-aos="fade-up">

    <div class="section-title">
      <h2>Contact Us</h2>
    </div>

    <div class="row">
      <!-- Kotak Pertama -->
      <div class="col-md-6">
        <div class="contact-box">
          <i class="fas fa-envelope"></i> <!-- Ikon email -->
          <h3>Email</h3>
          <p>salwaadiazahraa@gmail.com</p>
        </div>
      </div>

      <!-- Kotak Kedua -->
      <div class="col-md-6">
        <div class="contact-box">
          <i class="fas fa-phone"></i> <!-- Ikon telepon -->
          <h3>Nomor Telepon</h3>
          <p>+62 838 0324 6357</p>
        </div>
      </div>

      <!-- Kotak Ketiga -->
      <div class="col-md-6">
  <div class="contact-box">
      <i class="fa fa-map-pin"></i> <!-- Ikon alamat -->
      <h3>Alamat</a></h3>
    <p><a href="https://maps.app.goo.gl/NtQ8h9BHCP24V8jN8" target="_blank">Jl. Nasional 11 242, RT.03/RW.04, Sindangsari, Kec. Bogor Tim.</p>
    </a>
  </div>
</div>

      <!-- Kotak Keempat -->
      <div class="col-md-6">
        <div class="contact-box">
          <i class="fas fa-globe"></i> <!-- Ikon situs web -->
          <h3>Website</h3>
          <p><a href="https://www.sazdotnet.com">www.sazdotnet.com</a></p>
        </div>
      </div>
    </div>
  </div>
</section>





  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">

    <div class="footer-newsletter">

    <div class="container py-4">
      <div class="copyright">
        &copy; Copyright <strong><span>SAZ.Net</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/free-bootstrap-app-landing-page-template/ -->
        Designed by Salwa Adia Zahra
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ asset('/assets/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('/assets/vendor/php-email-form/validate.js') }}"></script>

  <!-- Template Main JS File -->
  <script src="{{ asset('/assets/js/main.js') }}"></script>


</body>

</html>
