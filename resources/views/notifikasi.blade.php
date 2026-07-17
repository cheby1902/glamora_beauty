<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Notifikasi — Glamora Beauty</title>

  <link rel="stylesheet" href="{{ asset('css/notifikasi.css') }}">

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

  <div class="notif-container">

    <div class="notif-header">
        <h1>Notifikasi</h1>
        <p>Update terbaru mengenai pesananmu.</p>
    </div>

    @forelse($notifikasi as $item)

    <div class="notif-card">

        <div class="notif-icon">

            @if($item->status_pesanan == 'Sedang Dikemas')
                📦
            @elseif($item->status_pesanan == 'Sedang Dikirim')
                🚚
            @elseif($item->status_pesanan == 'Sudah Tiba')
                ✅
            @else
                ℹ️
            @endif

        </div>

        <div class="notif-content">

            <h3>
                Pesanan #{{ $item->id_pesanan }}
            </h3>

            <p>

                
                @if($item->status_pesanan == 'Sedang Dikemas')
                    Pesanan Anda sedang dikemas oleh admin.
                @elseif($item->status_pesanan == 'Sedang Dikirim')
                    Pesanan Anda sedang dalam perjalanan.
                @elseif($item->status_pesanan == 'Sudah Tiba')
                    Pesanan telah sampai di tujuan.
                @else
                    Status pesanan:
                    {{ $item->status_pesanan }}
                @endif

            </p>

            <span class="notif-date">
                {{ \Carbon\Carbon::parse($item->tanggal_pesan)->translatedFormat('d F Y H:i') }}
            </span>

            @if($item->status_pesanan == 'Sudah Tiba')

            @foreach($item->detailPesanan as $detail)

                @php
                $sudahReview = \App\Models\Review::where(
                    'id_user',
                    session('user_id')
                )
                ->where(
                    'id_produk',
                    $detail->id_produk
                )
                ->exists();
                @endphp
                    <div class="review-box">
                        <p>
                            {{ $detail->produk->nama_produk }}
                            @if($detail->produkVarian)
                                (
                                @if($detail->produkVarian->nama_varian)
                                    {{ $detail->produkVarian->nama_varian }}
                                @elseif($detail->produkVarian->warnaKulit)
                                    {{ $detail->produkVarian->warnaKulit->nama_warna_kulit }}
                                @endif
                                )
                            @endif
                        </p>

                        @if($sudahReview)
                            <span class="review-done">
                                ✔ Sudah Direview
                            </span>
                        @else
                            <a href="{{ url('/review/'.$detail->id_produk) }}"
                                class="btn-review">
                                Beri Ulasan
                            </a>
                        @endif
                    </div>
                @endforeach
            @endif

        </div>

    </div>

    @empty

    <div class="empty-cart">
        <div class="empty-cart-icon">🔔</div>

        <p class="empty-cart-title">
            Belum ada notifikasi
        </p>

        <p class="empty-cart-sub">
            Update status pesanan akan muncul di sini
        </p>
    </div>

    @endforelse

</div>

  </body>
</html>