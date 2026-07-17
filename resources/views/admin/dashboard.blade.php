<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Glamora Beauty - Admin System</title>

    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>

<body>

<div id="page-admin" class="page active">

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="nav-logo">
            <a href="{{ url('/') }}">
                <img src="{{ asset('img/img1.png') }}" alt="Glamora Beauty Logo" class="main-logo">
            </a>
        </div>

        <div class="nav-user">
            <span>Administrator</span>
            <form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit" class="btn-logout">
        Keluar
    </button>
</form>
        </div>
    </nav>


    <div class="admin-layout">

        <!-- SIDEBAR -->
        <aside class="admin-sidebar">
            <div class="admin-menu-item active" onclick="showAdminTab('dashboard', this)">
                Dashboard Overview
            </div>

            <div class="admin-menu-item" onclick="showAdminTab('produk', this)">
                Kelola Produk
            </div>

            <div class="admin-menu-item" onclick="showAdminTab('kategori', this)">
                Kelola Katalog
            </div>

            <div class="admin-menu-item" onclick="showAdminTab('review', this)">
                Ulasan Customer
            </div>

            <div class="admin-menu-item" onclick="showAdminTab('user', this)">
                Akun User
            </div>
        </aside>


        <!-- CONTENT -->
        <main class="admin-content">

            <!-- ALERT -->
            @if(session('success'))
                <div class="alert-success">
                    {{ session('success') }}
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


            <!-- ================= DASHBOARD ================= -->
            <section class="admin-tab-content active" id="tab-dashboard">

                <h1 class="admin-title">Dashboard Overview</h1>
                <p class="admin-subtitle">Selamat datang di halaman admin Glamora Beauty.</p>

                <div class="dashboard-cards">

                    <div class="dashboard-card">
                        <h3>Total Produk</h3>
                        <p>{{ $totalProduk ?? 0 }}</p>
                    </div>

                    <div class="dashboard-card">
                        <h3>Total Katalog</h3>
                        <p>{{ $totalKategori ?? 0 }}</p>
                    </div>

                    <div class="dashboard-card">
                        <h3>Total Ulasan</h3>
                        <p>{{ $totalUlasan ?? 0 }}</p>
                    </div>

                    <div class="dashboard-card">
                        <h3>Total User</h3>
                        <p>{{ isset($users) ? $users->count() : 0 }}</p>
                    </div>

                </div>


                <h2 class="admin-section-title">Daftar Pesanan</h2>

                <div class="table-wrap">
                    <table class="admin-table">
                        <thead>
                           <tr>
                                <th>ID</th>
                                <th>Penerima</th>
                                <th>Alamat</th>
                                <th>Produk</th>
                                <th>Estimasi Tiba</th>
                                <th>Pengiriman</th>
                                <th>Pembayaran</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($orders as $order)
                               <tr>
                                <td>{{ $order->id_pesanan }}</td>
                                <td>{{ $order->nama_penerima }}</td>
                                <td>
                                    {{ $order->alamat }},
                                    {{ $order->kota }}
                                </td>
                               <td>
                                   @foreach($order->detailPesanan as $detail)
                                    • {{ $detail->produk->nama_produk ?? '-' }}
                                    @if($detail->produkVarian)
                                        (
                                        @if(!empty($detail->produkVarian->nama_varian))
                                            {{ $detail->produkVarian->nama_varian }}
                                        @elseif($detail->produkVarian->warnaKulit)
                                            {{ $detail->produkVarian->warnaKulit->nama_warna_kulit }}
                                        @endif
                                        )
                                    @endif
                                    ({{ $detail->jumlah }}x)
                                    <br><br>
                                @endforeach
                                </td>
                                <td>
                                    {{ $order->estimasi_tiba }}
                                </td>
                                <td>{{ $order->metode_pengiriman }}</td>
                                <td>{{ $order->metode_pembayaran ?? '-' }}</td>
                                <td>
                                    Rp {{ number_format($order->total_bayar, 0, ',', '.') }}
                                </td>
                                <td>
                                    {{ $order->status_pesanan ?? '-' }}
                                </td>
                                <td class="action-cell">
                                    <button
                                        class="btn-edit"
                                        data-id="{{ $order->id_pesanan }}"
                                        data-status="{{ $order->status_pesanan }}"
                                        onclick="openStatusModal(this)">
                                        Edit
                                    </button>
                                    <form
                                        action="/admin/pesanan/delete/{{ $order->id_pesanan }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus pesanan ini?')"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="btn-delete">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="empty-table">
                                        Belum ada pesanan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </section>



            <!-- ================= KELOLA PRODUK ================= -->
            <section class="admin-tab-content" id="tab-produk">

                <div class="admin-page-header">
                    <div>
                        <h1 class="admin-title">Kelola Daftar Produk</h1>
                        <p class="admin-subtitle">Produk yang sudah kamu masukkan ke database.</p>
                    </div>

                    <button class="btn-add" onclick="openTambahProdukModal()">
                    + Tambah Produk
                    </button>
                </div>

                <div class="table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID Produk</th>
                                <th>Gambar</th>
                                <th>Nama Produk</th>
                                <th>Katalog</th>
                                <th>Jenis Kulit</th>
                                <th>Masalah Kulit</th>
                                <th>Warna Kulit</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($produk as $item)
                                <tr>
                                    <td>{{ $item->id_produk }}</td>

                                    <td>
                                        @if(!empty($item->gambar_produk))
                                            <img 
                                                src="{{ asset('img/produk/'.$item->gambar_produk) }}"
                                                alt="{{ $item->nama_produk }}"
                                                class="admin-product-img">
                                        @else
                                            <div class="admin-img-placeholder">No Img</div>
                                        @endif
                                    </td>

                                    <td>
                                        <strong>{{ $item->nama_produk }}</strong>
                                        <br>
                                        <small>{{ $item->brand }}</small>
                                    </td>

                                    <td>{{ $item->katalog->nama_katalog ?? '-' }}</td>

                                    <td>{{ $item->jenisKulit->nama_jenis_kulit ?? '-' }}</td>

                                    <td>{{ $item->masalahKulit->nama_masalah_kulit ?? '-' }}</td>

                                    <td>
                                        {{ $item->produkVarian->first()->warnaKulit->nama_warna_kulit ?? '-' }}
                                    </td>

                                    <td>
                                        Rp {{ number_format($item->produkVarian->first()->harga ?? 0, 0, ',', '.') }}
                                    </td>

                                    <td>
                                        {{ $item->produkVarian->first()->stock ?? 0 }}
                                    </td>

                                    <td class="action-cell">
                                        <button class="btn-edit"
                                            data-id="{{ $item->id_produk }}"
                                            onclick="openEditProdukModal(this)">
                                            Edit
                                        </button>

                                        <form action="{{ route('admin.produk.destroy', $item->id_produk) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin hapus produk ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-delete">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="empty-table">
                                        Belum ada produk di database.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </section>

            <!-- ================= KELOLA KATEGORI ================= -->
<section class="admin-tab-content" id="tab-kategori">
    <div class="admin-page-header">
        <div>
            <h1 class="admin-title">Kelola Katalog</h1>
            <p class="admin-subtitle">Tambah, edit, dan hapus jenis katalog.</p>
        </div>

        <button class="btn-add" onclick="openTambahKategoriModal()">
            + Tambah Kategori
        </button>
    </div>

    <div class="table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID Katalog</th>
                    <th>Gambar</th>
                    <th>Nama Katalog</th>
                    <th>Aksi</th>
                </tr>
            </thead>

           <tbody>
    @forelse($katalog as $kat)
        <tr>
            <td>{{ $kat->id_katalog }}</td>

            <td>
                <img src="{{ $kat->gambar_katalog }}"
                     alt="{{ $kat->nama_katalog }}"
                     class="admin-category-img">
            </td>

            <td>
                <strong>{{ $kat->nama_katalog }}</strong>
            </td>

            <td class="action-cell">
    <button class="btn-edit"
            data-id="{{ $kat->id_katalog }}"
            data-nama="{{ $kat->nama_katalog }}"
            data-gambar="{{ $kat->gambar_katalog }}"
            onclick="openEditKategoriModal(this)">
        Edit
    </button>

                <form action="{{ url('/admin/kategori/delete/'.$kat->id_katalog) }}"
                      method="POST"
                      onsubmit="return confirm('Yakin ingin hapus kategori ini?')">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn-delete">
                        Hapus
                    </button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="4" class="empty-table">
                Belum ada kategori.
            </td>
        </tr>
    @endforelse
</tbody>
        </table>
    </div>

</section>



            <!-- ================= ULASAN USER ================= -->
            <section class="admin-tab-content" id="tab-review">

                <h1 class="admin-title">Ulasan Customer</h1>
                <p class="admin-subtitle">Daftar review dari customer. Admin bisa menghapus ulasan.</p>

                <div class="table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID Review</th>
                                <th>User</th>
                                <th>Produk</th>
                                <th>Rating</th>
                                <th>Komentar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($reviews as $review)
                                <tr>
                                    <td>{{ $review->id_review }}</td>
                                    <td>{{ $review->user->nama_user ?? '-' }}</td>
                                    <td>{{ $review->produk->nama_produk ?? '-' }}</td>
                                    <td>{{ $review->rating }} ★</td>
                                    <td>{{ $review->komentar }}</td>

                                    <td>
                                        <form action="{{ route('admin.review.destroy', $review->id_review) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin hapus ulasan ini?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn-delete">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="empty-table">
                                        Belum ada ulasan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </section>



            <!-- ================= AKUN USER ================= -->
            <section class="admin-tab-content" id="tab-user">

                <h1 class="admin-title">Akun User</h1>
                <p class="admin-subtitle">Daftar akun user yang terdaftar di Glamora Beauty.</p>

                <div class="table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID User</th>
                                <th>Nama User</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td>{{ $user->id_user }}</td>
                                    <td>{{ $user->nama_user }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role }}</td>

                                    <td>
                                    <form
                                        action="{{ route('admin.user.destroy',$user->id_user) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus akun user ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn-delete">
                                    Hapus
                                    </button>

                                    </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="empty-table">
                                        Belum ada akun user.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </section>

        </main>
    </div>
</div>



<!-- MODAL KATEGORI -->
<div class="modal-overlay" id="modal-kategori" style="display:none" onclick="closeKategoriModal(event)">
    <div class="modal-box" onclick="event.stopPropagation()">

        <div class="modal-title" id="kategori-modal-title">
            Tambah Kategori
        </div>

        <form id="kategori-form"
              action="{{ url('/admin/kategori/store') }}"
              method="POST">

            @csrf

            <div id="kategori-method"></div>

            <div class="form-group">
                <label>Nama Kategori</label>
                <input type="text"
                       name="nama_katalog"
                       id="nama_katalog"
                       placeholder="Masukkan nama kategori"
                       required>
            </div>

            <div class="form-group">
                <label>Link Gambar Kategori</label>
                <input type="url"
                       name="gambar_katalog"
                       id="gambar_katalog"
                       placeholder="https://example.com/gambar.png"
                       required>
                <small>Masukkan URL gambar ikon kategori.</small>
            </div>

            <div class="modal-actions">
                <button type="button"
                        class="btn-cancel"
                        onclick="closeKategoriModal()">
                    Batal
                </button>

                <button type="submit"
                        class="btn-submit">
                    Simpan
                </button>
            </div>

        </form>

    </div>
</div>

        <!-- MODAL PRODUK -->
<div class="modal-overlay" id="modal-produk" style="display:none" onclick="closeProdukModal(event)">
    <div class="modal-box" onclick="event.stopPropagation()">

        <div class="modal-title" id="produk-modal-title">
            Tambah Produk
        </div>

        <form
    id="produk-form"
    action="{{ url('/admin/produk/store') }}"
    method="POST">

            @csrf

            <div id="produk-method"></div>

            <div class="form-group">
                <label>Nama Produk</label>
                <input type="text" name="nama_produk" id="nama_produk" required>
            </div>

            <div class="form-group">
            <label>Nama Varian</label>
            <input type="text"
                name="nama_varian"
                placeholder="Contoh: Strawberry, Cherry">
            </div>

            <div class="form-group">
                <label>Brand</label>
                <input type="text" name="brand" id="brand" required>
            </div>
  
<div class="form-group">
    <label>Katalog</label>
    <select name="id_katalog" required>
        @foreach($katalog as $kat)
            <option value="{{ $kat->id_katalog }}">
                {{ $kat->nama_katalog }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label>Jenis Kulit</label>
    <select name="id_jenis_kulit">
        <option value="">Tidak ada</option>
        @foreach($jenisKulit as $jenis)
            <option value="{{ $jenis->id_jenis_kulit }}">
                {{ $jenis->nama_jenis_kulit }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label>Masalah Kulit</label>
    <select name="id_masalah_kulit">
        <option value="">Tidak ada</option>
        @foreach($masalahKulit as $masalah)
            <option value="{{ $masalah->id_masalah_kulit }}">
                {{ $masalah->nama_masalah_kulit }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label>Warna Kulit</label>
    <select name="id_warna_kulit">
        <option value="">Tidak ada</option>
        @foreach($warnaKulit as $warna)
            <option value="{{ $warna->id_warna_kulit }}">
                {{ $warna->nama_warna_kulit }}
            </option>
        @endforeach
    </select>
</div>

            <div class="form-group">
                <label>Harga</label>
                <input type="number" name="harga" id="harga" required>
            </div>

            <div class="form-group">
                <label>Stok</label>
                <input type="number" name="stock" id="stock" required>
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi_produk" id="deskripsi_produk"></textarea>
            </div>

   <div class="form-group">
    <label>Nama File Gambar</label>
    <input
        type="text"
        name="gambar_produk"
        id="gambar_produk"
        placeholder="Contoh: wardah_colorfit.png">
</div>

            <div class="modal-actions">
                <button type="button"
                        class="btn-cancel"
                        onclick="closeProdukModal()">
                    Batal
                </button>

                <button type="submit"
                        class="btn-submit">
                    Simpan
                </button>
            </div>

        </form>

    </div>
</div>

<!-- ===== MODAL EDIT STATUS PESANAN ===== -->
<div
    id="modal-status"
    class="modal-overlay"
    style="display:none;"
    onclick="closeStatusModal(event)">

    <div class="modal-box">

        <h2 class="modal-title">
            Edit Status Pesanan
        </h2>

        <form
            id="status-form"
            method="POST">

            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Status Pesanan</label>

                <select
                    name="status_pesanan"
                    id="status_pesanan">

                    <option value="Sedang Dikemas">
                        Sedang Dikemas
                    </option>

                    <option value="Sedang Dikirim">
                        Sedang Dikirim
                    </option>

                    <option value="Sudah Tiba">
                        Sudah Tiba
                    </option>

                </select>
            </div>

            <div class="modal-actions">

                <button
                    type="button"
                    class="btn-cancel"
                    onclick="closeStatusModal()">
                    Batal
                </button>

                <button
                    type="submit"
                    class="btn-submit">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script src="{{ asset('js/admin.js') }}"></script>

</body>
</html>