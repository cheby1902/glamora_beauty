<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Glamora Beauty</title>
  <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
</head>
<body>

  <!-- ===== NAVBAR ===== -->
  <nav class="navbar">
    <div class="nav-logo">
      <a href="#home">
       <img src="{{ asset('img/img1.png') }}" alt="Glamora Beauty Logo" class="main-logo">
      </a>
    </div>

    <div class="nav-links">
    <a href="{{ url('/') }}">Beranda</a>
    <a href="#kategori">Katalog</a>
    </div>

    <div class="nav-user">
      <button class="btn-login" onclick="window.location.href='/login'">
        Masuk
      </button>
    </div>
  </nav>

  <!-- ===== HERO ===== -->
  <section id="home" class="hero">

    <img src="{{ asset('img/bg-hero.png') }}" class="hero-bg" alt="">

    <div class="hero-content">

        <div class="hero-eyebrow">
            Glamora Beauty
        </div>

        <h1 class="hero-title">
            Makeup yang <em>merayakan</em><br>
            kulitmu
        </h1>

        <p class="hero-desc">
            Temukan produk yang diformulasikan khusus sesuai jenis kulit,
            masalah kulit, dan warna kulitmu.
        </p>

        <button class="btn-primary" onclick="scrollToKategori()">
            Jelajahi Katalog
        </button>

    </div>

</section>

  <!-- ===== KATEGORI ===== -->
  <section id="kategori" class="section">
    <div class="section-title">
      Kategori Unggulan
    </div>
    <div class="section-sub">
      Temukan produk berdasarkan jenis makeup favoritmu
    </div>

<div class="katalog-grid">

@foreach($katalog as $kat)

    <a href="{{ url('/login?pesan=login') }}" class="katalog-card">

        <img src="{{ $kat->gambar_katalog }}"
             class="katalog-icon"
             alt="{{ $kat->nama_katalog }}">

        <div class="katalog-name">
            {{ $kat->nama_katalog }}
        </div>

        <div class="katalog-count">
            {{ $jumlahProduk[$kat->id_katalog] ?? 0 }} Produk
        </div>

    </a>

@endforeach

</div>


  <script>
    function scrollToKategori()  {
      document.getElementById('kategori').scrollIntoView({
        behavior: 'smooth'
      });
    }
  </script>
  <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>