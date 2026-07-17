<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Struk — Glamora Beauty</title>

  <link rel="stylesheet" href="{{ asset('css/struk.css') }}">

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

  <!-- STRUK -->
  <div class="struk-wrap">

    <div class="struk-card">

      <div class="struk-check">✓</div>

      <div class="struk-logo">
        Glamora Beauty
      </div>

      <p class="struk-title">
        STRUK PEMBELIAN
      </p>

      <p class="struk-no" id="struk-no"></p>

      <hr class="struk-divider">

      <div class="struk-section-label">
        DIKIRIM KE
      </div>

      <div class="struk-alamat">
    <p>
        {{ $pesanan->nama_penerima }}
        -
        {{ $pesanan->no_hp }}
    </p>

    <p>
        {{ $pesanan->alamat }},
        {{ $pesanan->kota }},
        {{ $pesanan->kode_pos }}
    </p>
      </div>

      <hr class="struk-divider">

      <div class="struk-section-label">
        PRODUK
      </div>

      <div class="struk-items">

@foreach($detailPesanan as $item)

<div class="struk-item">
    <span>
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
    </span>

    <span>
        x{{ $item->jumlah }}
    </span>

    <span>
        Rp {{ number_format($item->subtotal,0,',','.') }}
    </span>

    </div>
    @endforeach
    </div>

      <hr class="struk-divider">

    <div class="struk-row">
        <span>Metode Pengiriman</span>
        <span>
            {{ ucfirst($pesanan->metode_pengiriman) }}
        </span>
    </div>

    <div class="struk-row">
        <span>Estimasi Tiba</span>
        <span>
            {{ \Carbon\Carbon::parse($pesanan->estimasi_tiba)->translatedFormat('d F Y') }}
        </span>
    </div>


      <div class="struk-row">
    <span>Subtotal</span>
      <span>
        Rp {{ number_format($pesanan->total_bayar - $pesanan->ongkos_kirim,0,',','.') }}
      </span>
     </div>

      <div class="struk-row">
      <span>Ongkos Kirim</span>
      <span>
        Rp {{ number_format($pesanan->ongkos_kirim,0,',','.') }}
      </span>
     </div>

      <hr class="struk-divider">

      <div class="struk-row total">
      <span>Total</span>
      <span>
        Rp {{ number_format($pesanan->total_bayar,0,',','.') }}
      </span>
     </div>

      <p class="struk-tgl" id="struk-tgl"></p>

      <hr class="struk-divider">

      <p class="struk-msg">
        Terima kasih telah berbelanja di Glamora Beauty!
      </p>

      <div class="struk-actions">

      <a href="/welcome" class="btn-outline btn-sm">
          Kembali ke Beranda
      </a>
      <a href="/notifikasi" class="btn-primary btn-sm">
      Cek Notifikasi
      </a>
      </div>
    </div>
  </div>

</body>
</html>