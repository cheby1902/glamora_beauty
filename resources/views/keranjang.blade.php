<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Keranjang — Glamora Beauty</title>

  <link rel="stylesheet" href="{{ asset('css/keranjang.css') }}">

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

  <div class="cart-wrap">
    <div class="cart-header">
   <a href="/welcome" class="back-btn">
    ← Kembali
</a>
      <h1 class="section-title">Keranjang Belanja</h1>
    </div>

    <!-- Keranjang kosong -->
    <div id="empty-cart" style="display:none" class="empty-cart">
      <div class="empty-cart-icon">🛒</div>
      <p class="empty-cart-title">Keranjangmu masih kosong</p>
      <p class="empty-cart-sub">Yuk, temukan produk yang cocok untuk kulitmu!</p>
      <a href="welcome.blade.php" class="btn-primary">Jelajahi Katalog</a>
    </div>

    <!-- Isi keranjang -->
    <div id="cart-content">
      <div class="cart-layout">

        <!-- Daftar item -->
<div class="cart-items">
@foreach($keranjang as $item)

<div class="cart-item">

    <div class="cart-item-info">

        <h3>
            {{ $item->produk->nama_produk }}
            @if($item->produkVarian)
                (
                @if($item->produkVarian->nama_varian)
                    {{ $item->produkVarian->nama_varian }}
                @elseif($item->produkVarian->warnaKulit)
                    {{ $item->produkVarian->warnaKulit->nama_warna_kulit }}
                @endif
                )
            @endif
        </h3>

        <p>
            Harga:
            Rp {{ number_format($item->produkVarian->harga,0,',','.') }}
        </p>

        <p>Qty: {{ $item->jumlah }}</p>

        <p>
            Subtotal:
            Rp {{ number_format($item->produkVarian->harga * $item->jumlah,0,',','.') }}
        </p>
    </div>

    <form action="{{ route('keranjang.destroy', $item->id_keranjang) }}"
      method="POST"
      onsubmit="return confirm('Yakin ingin menghapus produk ini dari keranjang?')">
        @csrf
        @method('DELETE')

        <button type="submit" class="btn-delete">
            Hapus
        </button>
    </form>

</div>

@endforeach

</div>
          <!-- Diisi oleh JS -->
        </div>

        <!-- Ringkasan belanja -->
        <div class="cart-summary">
          <div class="summary-card">
            <h2 class="summary-title">Ringkasan Belanja</h2>

            <div class="summary-rows" id="summary-rows">
              <!-- Diisi oleh JS -->
            </div>

            <hr class="summary-divider">

           <div class="summary-total">
          <span>Total</span>
          <span>
              Rp {{ number_format($total,0,',','.') }}
          </span>
        </div>

           <a href="{{ url('/checkout?from=cart') }}" class="btn-primary btn-block">
              Lanjut ke Checkout
          </a>
          </div>
        </div>

      </div>
    </div>
  </div>

  <div class="toast" id="toast"></div>


<script src="../js/auth.js"></script>
<script src="../js/ui.js"></script>
</body>
</html>