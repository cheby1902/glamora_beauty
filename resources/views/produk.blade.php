<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Produk — Glamora Beauty</title>

  <link rel="stylesheet" href="{{ asset('css/produk.css') }}">

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
  
<!-- FILTER AREA -->

@php
    $showJenis = in_array($katalog->id_katalog,[1,2,3,4,10]);

    $showMasalah = in_array($katalog->id_katalog,[1,2,3,4,10]);

    $pakaiSimilarity = in_array($katalog->id_katalog,[1,2,3,4,10]);

    $filterAktif =
        request('jenis') ||
        request('masalah');
@endphp

<div class="filter-wrap">

    <a href="{{ url('/welcome') }}#kategori" class="back-btn">
    ← Kembali Ke Katalog
    </a>

    @if($showJenis)
    <p class="filter-label">JENIS KULIT</p>

    <div class="filter-group">

        <button type="button"
            class="tag {{ request('jenis') == 'Berminyak' ? 'active' : '' }}"
            data-group="jenis"
            data-val="Berminyak">
            Berminyak
        </button>

        <button type="button"
            class="tag {{ request('jenis') == 'Kering' ? 'active' : '' }}"
            data-group="jenis"
            data-val="Kering">
            Kering
        </button>

        <button type="button"
            class="tag {{ request('jenis') == 'Kombinasi' ? 'active' : '' }}"
            data-group="jenis"
            data-val="Kombinasi">
            Kombinasi
        </button>

        <button type="button"
            class="tag {{ request('jenis') == 'Normal' ? 'active' : '' }}"
            data-group="jenis"
            data-val="Normal">
            Normal
        </button>

        <button type="button"
            class="tag {{ request('jenis') == 'Sensitif' ? 'active' : '' }}"
            data-group="jenis"
            data-val="Sensitif">
            Sensitif
        </button>

    </div>
    @endif

    @if($showMasalah)
    <p class="filter-label">MASALAH KULIT</p>

    <div class="filter-group">

        <button type="button"
            class="tag {{ request('masalah') == 'Jerawat' ? 'active' : '' }}"
            data-group="masalah"
            data-val="Jerawat">
            Jerawat
        </button>

        <button type="button"
            class="tag {{ request('masalah') == 'Pori Besar' ? 'active' : '' }}"
            data-group="masalah"
            data-val="Pori Besar">
            Pori Besar
        </button>

        <button type="button"
            class="tag {{ request('masalah') == 'Kusam' ? 'active' : '' }}"
            data-group="masalah"
            data-val="Kusam">
            Kusam
        </button>

        <button type="button"
            class="tag {{ request('masalah') == 'Komedo' ? 'active' : '' }}"
            data-group="masalah"
            data-val="Komedo">
            Komedo
        </button>

        <button type="button"
            class="tag {{ request('masalah') == 'Warna Kulit Tidak Merata' ? 'active' : '' }}"
            data-group="masalah"
            data-val="Warna Kulit Tidak Merata">
            Warna Kulit Tidak Merata
        </button>

        <button type="button"
            class="tag {{ request('masalah') == 'Kemerahan' ? 'active' : '' }}"
            data-group="masalah"
            data-val="Kemerahan">
            Kemerahan
        </button>

    </div>
    @endif

    @if($showJenis || $showMasalah)

   @if($filterAktif)

<a href="{{ url('/produk/'.$katalog->id_katalog) }}"
   class="filter-reset">
    Reset Semua Filter
</a>

@endif

@endif

</div>

<!-- ===== PRODUK ===== -->

<section class="product-section">

    @if($produk->count() > 0)

    <div class="product-grid">

        @foreach($produk as $item)

        <a href="{{ route('produk.detail', $item->id_produk) }}"
        class="product-card">

            <div class="product-img">
            <img
                    src="{{ asset('img/produk/'.$item->gambar_produk) }}"
                    alt="{{ $item->nama_produk }}">

            </div>

            <div class="product-info">

                <div class="product-brand">
                    {{ $item->brand }}
                </div>

                <div class="product-name">
                    {{ $item->nama_produk }}
                </div>

                <div class="product-price">
                    Rp {{ number_format($item->produkVarian->first()->harga ?? 0, 0, ',', '.') }}
                </div>

                <div class="product-stock">
                    Stok: {{ $item->produkVarian->first()->stock ?? 0 }}
                </div>

                @if($pakaiSimilarity && $filterAktif)

                <div class="product-similarity">

                    Similarity:
                    {{ number_format($item->similarity,4) }}
                </div>
                @endif

            </div>
        </a>

        @endforeach

    </div>

    @else

    <div class="empty-state">
        Produk Belum Tersedia.
    </div>

    @endif

</section>

  <div class="toast" id="toast"></div>

  <script src="{{ asset('js/filter.js') }}"></script>
  
</body>
</html>