<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Detail Produk — Glamora Beauty</title>

  <link rel="stylesheet" href="{{ asset('css/detail-produk.css') }}">

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


<!-- ===== DETAIL PRODUK ===== -->

@php
    $showShade = !in_array($produk->id_katalog, [8,9,10]);
@endphp

<div class="detail-wrap">

    <a href="{{ $backUrl }}" class="back-btn">
    ← Kembali
    </a>

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert-error">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert-error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <div class="detail-grid">

        <!-- GAMBAR PRODUK -->
        <div class="detail-img">
            <img src="{{ asset('img/produk/' . $produk->gambar_produk) }}"
                 alt="{{ $produk->nama_produk }}">
        </div>


        <!-- INFO PRODUK -->
        <div class="detail-info">

            <div class="detail-brand">
                {{ $produk->brand }}
            </div>

            <div class="detail-name">
                {{ $produk->nama_produk }}
            </div>

            <div class="detail-price" id="harga-produk">
                Rp {{ number_format($produk->produkVarian->first()->harga ?? 0, 0, ',', '.') }}
            </div>
 
            <div class="detail-stock" id="stok-produk">
                Stok: {{ $produk->produkVarian->first()->stock ?? 0 }}
            </div>

            @if($showShade)
            <div class="form-group" style="margin:20px 0;">
                <label>Pilih Shade</label>

                <select id="shade-select" class="shade-select">
                @foreach($produk->produkVarian as $varian)
                <option
                    value="{{ $varian->id_produk_varian }}"
                    data-harga="{{ $varian->harga }}"
                    data-stock="{{ $varian->stock }}">
                   @if($varian->nama_varian)
                    {{ $varian->nama_varian }}
                    @if($varian->warnaKulit)
                        ({{ $varian->warnaKulit->nama_warna_kulit }})
                    @endif
                @else
                    {{ $varian->warnaKulit->nama_warna_kulit ?? 'Shade' }}
                @endif
                </option>
                @endforeach
                </select>
            </div>
            @endif

            <div class="detail-desc">
                {!! nl2br(e(preg_replace("/(\r?\n){3,}/", "\n\n", $produk->deskripsi_produk))) !!}
            </div>

            <div class="detail-tags">
                <span class="detail-tag">
                    {{ $produk->jenisKulit->nama_jenis_kulit ?? '-' }}
                </span>

                <span class="detail-tag">
                    {{ $produk->warnaKulit->nama_warna_kulit ?? '-' }}
                </span>

                <span class="detail-tag">
                    {{ $produk->masalahKulit->nama_masalah_kulit ?? '-' }}
                </span>
            </div>


            <!-- QUANTITY -->
            <div class="detail-qty">
                <button type="button" class="qty-btn" onclick="changeQty(-1)">
                    −
                </button>

                <span class="qty-num" id="qty-num">1</span>

                <button type="button" class="qty-btn" onclick="changeQty(1)">
                    +
                </button>
            </div>


            <!-- FORM KERANJANG -->
            <form action="/keranjang" method="POST">
                @csrf

                <input type="hidden" name="produk_id" value="{{ $produk->id_produk }}">

                <input
                type="hidden"
                name="id_produk_varian"
                id="varian-input"
                value="{{ optional($produk->produkVarian->first())->id_produk_varian }}">

                <input type="hidden" name="qty" id="qty-input" value="1">


                <div class="detail-actions">

                    <input type="hidden"
                        name="id_produk"
                        value="{{ $produk->id_produk }}">

                    <input
                    type="hidden"
                    name="id_produk_varian"
                    id="checkout-varian"
                    value="{{ optional($produk->produkVarian->first())->id_produk_varian }}">

                    <input type="hidden"
                        name="qty"
                        id="checkout-qty"
                        value="1">

                    <button
                        type="button"
                        onclick="checkoutLangsung()"
                        class="btn-primary btn-block">
                        Checkout
                    </button>
                   

                    <button type="submit" class="btn-secondary btn-block">
                        Simpan ke Keranjang
                    </button>
                </div>
            </form>

        </div>
    </div>


    <!-- ===== ULASAN PRODUK ===== -->
    <section class="review-section">

        <div class="review-header">
            <h2>Review Pembeli</h2>
            <p>Review dari pelanggan yang sudah membeli produk ini.</p>
        </div>


        <!-- FORM REVIEW -->
        @if(!session('user_id'))

            <div class="review-notice">
                <div class="review-notice-icon">🔒</div>
                <div>
                    <h3>Login untuk memberi ulasan</h3>
                    <p>Silakan login terlebih dahulu sebelum memberikan ulasan produk.</p>
                </div>
            </div>

        @elseif(($canReview ?? false) && !($alreadyReviewed ?? false))

            <div class="review-form-card">
                <h3>Tulis Ulasan</h3>
                <p>Bagikan pengalamanmu setelah membeli produk ini.</p>

                <form action="{{ route('review.store') }}" method="POST">
                    @csrf

                    <input type="hidden" name="id_produk" value="{{ $produk->id_produk }}">

                    <div class="form-group">
                        <label>Rating</label>

                        <select name="rating" required>
                            <option value="">Pilih rating</option>
                            <option value="5">5 ★ Sangat Baik</option>
                            <option value="4">4 ★ Baik</option>
                            <option value="3">3 ★ Cukup</option>
                            <option value="2">2 ★ Kurang</option>
                            <option value="1">1 ★ Buruk</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Ulasan Kamu</label>

                        <textarea name="komentar"
                                  rows="4"
                                  placeholder="Ceritakan pengalamanmu dengan produk ini..."
                                  required></textarea>
                    </div>

                    <button type="submit" class="btn-review">
                        Kirim Ulasan
                    </button>
                </form>
            </div>

        @elseif($alreadyReviewed ?? false)

            <div class="review-notice">
                <div class="review-notice-icon">✅</div>
                <div>
                    <h3>Ulasan sudah dikirim</h3>
                    <p>Kamu sudah memberikan ulasan untuk produk ini.</p>
                </div>
            </div>

        @else

            <div class="review-notice">
                <div class="review-notice-icon">🛍️</div>
                <div>
                    <h3>Belum bisa memberi ulasan</h3>
                    <p>Kamu harus membeli produk ini terlebih dahulu sebelum memberikan ulasan.</p>
                </div>
            </div>

        @endif


        <!-- LIST REVIEW -->
        <div class="review-list">

            @forelse($produk->review as $review)

                <div class="review-card">

                    <div class="review-main">
                        <div class="review-user">
                            <div class="review-avatar">
                                {{ strtoupper(substr($review->user->nama_user ?? 'U', 0, 1)) }}
                            </div>

                            <div>
                                <strong>{{ $review->user->nama_user ?? 'User' }}</strong>

                                <p class="review-text">
                                    {{ $review->komentar }}
                                </p>
                            </div>
                        </div>

                        <div class="review-stars">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    ★
                                @else
                                    ☆
                                @endif
                            @endfor
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-review-card">
                    <div class="empty-review-icon">💬</div>
                    <h3>Belum ada ulasan</h3>
                    <p>Produk ini belum memiliki ulasan dari pembeli.</p>
                </div>
            @endforelse
        </div>
    </section>

</div>
<script src="{{ asset('js/detail.js') }}"></script>

</body>
</html>