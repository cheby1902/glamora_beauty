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
    <a href="{{ url('/welcome') }}">Beranda</a>
    <a href="{{ url('/welcome') }}#kategori">Katalog</a>

      <!-- KERANJANG -->
      <a href="/keranjang" class="cart-btn">
        🛒
        <span class="cart-count">
    {{ $jumlahKeranjang ?? 0 }}
</span>
      </a>
      <!-- NOTIFIKASI -->
    <a href="/notifikasi" class="notif-btn">
        🔔
        <span class="notif-count">
            {{ $jumlahNotifikasi ?? 0 }}
        </span>
    </a>
    </div>
      </a>
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

    @if(session('user_id'))

        <a href="{{ url('/produk/'.$kat->id_katalog) }}"
          class="katalog-card">

        @else

        <a href="#"
          class="katalog-card"
          onclick="showLoginModal(event)">

        @endif

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


<!-- ===== LOGIN MODAL ===== -->
<div id="loginModal" class="modal">

    <div class="modal-content">

        <span class="close-modal" onclick="closeLoginModal()">&times;</span>

        <h2>🛍️ Ingin Belanja?</h2>

        <p>
            Login terlebih dahulu untuk melihat produk,
            menambahkan ke keranjang, dan melakukan checkout.
        </p>

        <a href="/login" class="modal-btn">
            Login
        </a>

        <div class="modal-register">
            Belum punya akun?
            <a href="/register">Daftar di sini</a>
        </div>

    </div>

</div>

<script>

function showLoginModal(event){

    alert("Klik berhasil");

    event.preventDefault();

    document.getElementById("loginModal").style.display = "flex";

}

function closeLoginModal(){

    document.getElementById("loginModal").style.display = "none";

}

// klik area luar modal
window.onclick = function(event){

    let modal = document.getElementById("loginModal");

    if(event.target == modal){
        modal.style.display = "none";
    }

}

</script>

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