<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Konfirmasi Pesanan — Glamora Beauty</title>

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

<!-- KONTEN -->
<div class="checkout-wrap">

    <!-- DATA PENERIMA -->
    <div class="form-section">

        <h2 class="form-section-title">
            Informasi Penerima
        </h2>

        <div class="summary-row">
            <span>Nama Penerima</span>
            <span>{{ $pesanan->nama_penerima }}</span>
        </div>

        <div class="summary-row">
            <span>Nomor HP</span>
            <span>{{ $pesanan->no_hp }}</span>
        </div>

        <div class="summary-row">
            <span>Alamat</span>
            <span>{{ $pesanan->alamat }}</span>
        </div>

        <div class="summary-row">
            <span>Kota</span>
            <span>{{ $pesanan->kota }}</span>
        </div>

        <div class="summary-row">
            <span>Kode Pos</span>
            <span>{{ $pesanan->kode_pos }}</span>
        </div>

    </div>

    <!-- PENGIRIMAN -->
    <div class="form-section">

        <h2 class="form-section-title">
            Metode Pengiriman
        </h2>

        <div class="summary-row">
            <span>Pengiriman</span>
            <span>{{ $pesanan->metode_pengiriman }}</span>
        </div>

        <div class="summary-row">
            <span>Ongkir</span>
            <span>Rp {{ number_format($pesanan->ongkos_kirim,0,',','.') }}</span>
        </div>

        <div class="summary-row">
            <span>Estimasi Tiba</span>
            <span>
                {{ \Carbon\Carbon::parse($pesanan->estimasi_tiba)->translatedFormat('d F Y') }}
            </span>
        </div>

    </div>

    <!-- PEMBAYARAN -->
    <div class="form-section">

        <h2 class="form-section-title">
            Metode Pembayaran
        </h2>

        <div class="summary-row">
            <span>Pembayaran</span>
            <span>{{ strtoupper($pesanan->metode_pembayaran) }}</span>
        </div>

@if($pesanan->metode_pembayaran == 'qris')

   @php
    $batasBayar = \Carbon\Carbon::parse($pesanan->tanggal_pesan)->addMinutes(10);
   @endphp

    <div class="payment-deadline">
        <p class="deadline-title">Bayar Sebelum</p>
        <h3>
            {{ $batasBayar->translatedFormat('d F Y, H:i') }} WIB
        </h3>
    </div>

    <div style="margin-top:20px;text-align:center;">

        <img src="{{ asset('img/qris.png') }}"
             width="250"
             alt="QRIS">

        <p style="margin-top:10px;">
            Silakan Scan QRIS untuk Melakukan Pembayaran.
        </p>

    </div>

@endif

    <!-- RINGKASAN PESANAN -->
    <div class="form-section">

        <h2 class="form-section-title">
            Ringkasan Pesanan
        </h2>

        @foreach($detailPesanan as $item)
    @php
            $subtotal = $detailPesanan->sum('subtotal');
        @endphp

        <div class="summary-row">
            <span>Subtotal</span>
            <span>
                Rp {{ number_format($subtotal,0,',','.') }}
            </span>
        </div>

        @endforeach

        <hr class="summary-divider">

        <div class="summary-row">
            <span>Ongkir</span>
            <span>
                Rp {{ number_format($pesanan->ongkos_kirim,0,',','.') }}
            </span>
        </div>

        <div class="summary-row total">
            <strong>Total Bayar</strong>

            <strong>
                Rp {{ number_format($pesanan->total_bayar,0,',','.') }}
            </strong>
        </div>

    </div>

    <a href="/struk"
       class="btn-primary">
        Selesaikan Pesanan
    </a>

</div>

</body>
</html>

