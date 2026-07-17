<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Review — Glamora Beauty</title>

  <link rel="stylesheet" href="{{ asset('css/review.css') }}">

  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
</head>

<body>

<!-- ===== NAVBAR ===== -->
  <nav class="navbar">
    <div class="nav-logo">
      <a href="{{ url('/welcome') }}">
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

    <a href="/notifikasi" class="notif-btn">
        🔔
        <span class="notif-count">
            {{ $jumlahNotifikasi ?? 0 }}
        </span>
    </a>
    </div>
    <div class="nav-user">
      <form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit" class="btn-logout">
        Keluar
    </button>
</form>
    </div>

  </nav>

      <div class="review-form-wrap">

      <form action="/review" method="POST">
      @csrf

      <input type="hidden"
            name="id_produk"
            value="{{ $produk->id_produk }}">

      <div class="review-form-card">

      <h2 class="review-form-title">Tulis Ulasan</h2>
      <p class="review-form-sub" id="review-produk-info"></p>

      <div class="form-group">
    <label>RATING</label>

    <div class="rating-stars">
        <input type="radio" name="rating" value="5" id="star5">
        <label for="star5">★</label>

        <input type="radio" name="rating" value="4" id="star4">
        <label for="star4">★</label>

        <input type="radio" name="rating" value="3" id="star3">
        <label for="star3">★</label>

        <input type="radio" name="rating" value="2" id="star2">
        <label for="star2">★</label>

        <input type="radio" name="rating" value="1" id="star1">
        <label for="star1">★</label>
    </div>
</div>

      <div class="form-group">
        <label for="review-text">REVIEW KAMU</label>
       <textarea
        name="komentar"
        id="review-text"
        rows="4"
        placeholder="Ceritakan pengalamanmu dengan produk ini...">
      </textarea>
      </div>

      <p class="form-error" id="review-error"></p>

      <div class="form-actions"><a href="{{ url()->previous() }}" class="btn-outline btn-sm">
          Batal
      </a>
        <button type="submit" class="btn-primary btn-sm">
          Kirim Review
      </button>
      </div>
    </div>
  </div>

  <div class="toast" id="toast"></div>

 <script src="{{ asset('js/storage.js') }}"></script>
  <script src="{{ asset('js/auth.js') }}"></script>
  <script src="{{ asset('js/data.js') }}"></script>
  <script src="{{ asset('js/ui.js') }}"></script>
  
  </script>
</body>
</html>