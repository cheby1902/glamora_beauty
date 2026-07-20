<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Checkout — Glamora Beauty</title>

  <link rel="stylesheet" href="{{ asset('css/checkout.css') }}">

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

  <!-- ===== CHECKOUT ===== -->
  <div class="checkout-wrap">
    <form action="/checkout" method="POST">
@csrf

@if ($errors->any())
<div style="color:red; margin-bottom:15px;">
    <ul style="padding-left:20px;">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

    <input type="hidden"
       name="id_produk"
       value="{{ $id_produk ?? '' }}">

    <input type="hidden"
          name="id_produk_varian"
          value="{{ $id_produk_varian ?? '' }}">

    <input type="hidden"
          name="qty"
       value="{{ $qty ?? 1 }}">

       <input type="hidden"
       name="from"
       value="{{ $from ?? '' }}">

    <div class="checkout-layout">

      <!-- ===== FORM KIRI ===== -->
      <div class="checkout-form">

        <!-- INFORMASI PENERIMA -->
        <div class="form-section">

          <h2 class="form-section-title">
            Informasi Penerima
          </h2>

          <div class="form-group">
            <label for="nama-penerima">
              NAMA PENERIMA
            </label>

            <input
            type="text"
            id="nama-penerima"
            name="nama_penerima"
            placeholder="Nama lengkap"
            required>
            </div>

          <div class="form-group">
            <label for="no-hp">
              NOMOR HP
            </label>

            <input
            type="tel"
            id="no-hp"
            name="no_hp"
            placeholder="08xxxxxxxxxx"
            required>
            </div>

          <div class="form-group">
            <label for="alamat">
              ALAMAT LENGKAP
            </label>

            <textarea
            id="alamat"
            name="alamat"
            rows="3"
            placeholder="Jalan, nomor rumah, RT/RW"
            required></textarea>
            </div>

          <div class="form-row">

            <div class="form-group">
              <label for="kota">KOTA</label>

              <input
            type="text"
            id="kota"
            name="kota"
            placeholder="Kota anda"
            required>
            </div>

            <div class="form-group">
              <label for="kodepos">KODE POS</label>

              <input
              type="text"
              id="kodepos"
              name="kode_pos"
              placeholder="12345"
              required>
            </div>

          </div>
  
        </div>

<!-- METODE PENGIRIMAN -->
<div class="form-section">

  <h2 class="form-section-title">
    Metode Pengiriman
  </h2>

  <div class="shipping-options" id="shipping-options">

  <label class="shipping-option">
  <input
    type="radio"
    name="metode_pengiriman"
    value="reguler"
    checked
    required>

  <div class="shipping-info">
    <span class="shipping-name">
      Reguler (3–5 hari)
    </span>

    <span class="shipping-price">
      Rp 15.000
    </span>
  </div>
</label>

  <label class="shipping-option">
    <input type="radio"
          name="metode_pengiriman"
          value="express">

    <div class="shipping-info">
      <span class="shipping-name">
        Express (1–2 hari)
      </span>

      <span class="shipping-price">
        Rp 30.000
      </span>
    </div>
  </label>

  <label class="shipping-option">
    <input type="radio"
          name="metode_pengiriman"
          value="sameday">

    <div class="shipping-info">
      <span class="shipping-name">
        Same Day
      </span>

      <span class="shipping-price">
        Rp 50.000
      </span>
    </div>
  </label>

  </div>

</div>

<!-- METODE PEMBAYARAN -->
<div class="form-section">

  <h2 class="form-section-title">
    Metode Pembayaran
  </h2>

  <div class="shipping-options">

    <label class="shipping-option">

      <input
    type="radio"
    name="metode_pembayaran"
    value="qris"
    checked
    required>

      <div class="shipping-info">
        <span class="shipping-name">
          QRIS
        </span>

        <span class="shipping-price">
          Scan QR Code
        </span>
      </div>

    </label>

    <label class="shipping-option">

      <input type="radio"
            name="metode_pembayaran"
            value="cod">

      <div class="shipping-info">
        <span class="shipping-name">
          Cash On Delivery (COD)
        </span>

        <span class="shipping-price">
          Bayar di Tempat
        </span>
      </div>

    </label>

  </div>

</div>

<p class="form-error" id="checkout-error"></p>

<button type="submit"
   class="btn-primary btn-block"
   id="btn-checkout">
  Lanjutkan Pembelian
</button>

      </div>

    </div>

  </div>
  </form>

  <!-- ===== TOAST ===== -->
  <div class="toast" id="toast"></div>

  <!-- ===== SCRIPT ===== -->
  <script src="{{ asset('js/auth.js') }}"></script>
  <script src="{{ asset('js/checkout.js') }}"></script>
  <script src="{{ asset('js/ui.js') }}"></script>

</body>
</html>