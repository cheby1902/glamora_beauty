<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\KatalogController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\MasalahKulitController;
use App\Http\Controllers\JenisKulitController;
use App\Http\Controllers\WarnaKulitController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\KonfirmasiController;
use App\Http\Controllers\StrukController;
use App\Http\Controllers\NotifikasiController;

/*
|--------------------------------------------------------------------------
| WEB ROUTES
|--------------------------------------------------------------------------
*/

/* =========================
   AUTH
========================= */

// halaman awal → landing page
Route::get('/', function () {

    if (session('user_id')) {

        if (session('role') == 'admin') {
            return redirect('/admin-dashboard');
        }

        return redirect('/welcome');
    }

    $jumlahProduk = Produk::selectRaw('id_katalog, COUNT(*) as total')
        ->groupBy('id_katalog')
        ->pluck('total', 'id_katalog');

    $katalog = Katalog::all();

    return view(
        'landing',
        compact(
            'jumlahProduk',
            'katalog'
        )
    );
});

// login
Route::get('/login', function () {

    if (session('user_id')) {

        if (session('role') == 'admin') {
            return redirect('/admin-dashboard');
        }

        return redirect('/welcome');
    }

    return view('login');
});

// register
Route::get('/register', function () {

    if (session('user_id')) {

        if (session('role') == 'admin') {
            return redirect('/admin-dashboard');
        }

        return redirect('/welcome');
    }

    return view('register');
});

// logout
Route::post('/logout', function () {

    session()->flush();

    return redirect('/');

})->name('logout');

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/logout', [UserController::class, 'logout']);

Route::get('/cek-session', function () {
    return session()->all();
});

use Illuminate\Support\Facades\Hash;
use App\Models\User;

Route::get('/buat-admin', function () {

    User::create([
        'nama_user' => 'Administrator',
        'username' => 'admin',
        'email' => 'admin@gmail.com',
        'password' => Hash::make('admin123'),
        'role' => 'admin'
    ]);

    return 'Admin berhasil dibuat';
});

// welcome 
use App\Models\Keranjang;
use App\Models\Produk;
use App\Models\Katalog;

Route::get('/welcome', function () {

    // CEK LOGIN
    if (!session('user_id')) {
        return redirect('/login');
    }

    // CEK ROLE
    if (session('role') != 'user') {
        return redirect('/admin-dashboard');
    }

    $jumlahKeranjang = Keranjang::where(
        'id_user',
        session('user_id')
    )->sum('jumlah');

    $jumlahProduk = Produk::selectRaw('id_katalog, COUNT(*) as total')
        ->groupBy('id_katalog')
        ->pluck('total', 'id_katalog');

    $katalog = Katalog::all();

    return view(
        'welcome',
        compact(
            'jumlahKeranjang',
            'jumlahProduk',
            'katalog'
        )
    );
});

/* =========================
   HALAMAN USER
========================= */

// katalog produk
Route::get('/katalog', [KatalogController::class, 'index'])
->name('produk.index');

Route::get('/detail/{id}', [DetailController::class, 'show'])
    ->name('produk.detail');

// keranjang
Route::get('/keranjang', [KeranjangController::class, 'index']);
Route::post('/keranjang', [KeranjangController::class, 'tambah']);

Route::delete(
    '/keranjang/{id}',
    [KeranjangController::class, 'destroy']
)->name('keranjang.destroy');

// checkout
Route::get('/checkout', [PesananController::class, 'checkout']);

Route::post('/checkout', [PesananController::class, 'store']);

// konfirmasi
Route::get('/konfirmasi', [KonfirmasiController::class, 'index']);

// struk
Route::get('/struk', [StrukController::class, 'index']);

// notifikasi
Route::get(
    '/notifikasi',
    [NotifikasiController::class, 'index']
);

/* =========================
   DATA MASTER
========================= */

Route::get('/produk', [ProdukController::class, 'index']);

Route::get('/produk/{id}', [ProdukController::class, 'kategori']);

Route::get('/user', [UserController::class, 'index']);
Route::post('/review', [ReviewController::class, 'store'])
    ->name('review.store');
Route::get(
    '/review/{id_produk}',
    [ReviewController::class, 'index']
);


Route::get('/masalah_kulit', [MasalahKulitController::class, 'index']);

Route::get('/jenis_kulit', [JenisKulitController::class, 'index']);

Route::get('/warna_kulit', [WarnaKulitController::class, 'index']);


/* =========================
   ADMIN
========================= */

// dashboard admin
use App\Http\Controllers\AdminController;

Route::get('/admin-dashboard', [AdminController::class, 'dashboard']);

Route::put(
    '/admin/pesanan/update-status/{id}',
    [AdminController::class, 'updateStatus']
)->name('admin.pesanan.updateStatus');

Route::delete(
    '/admin/pesanan/delete/{id}',
    [PesananController::class, 'destroy']
)->name('admin.pesanan.destroy');

Route::post('/admin/kategori/store',
    [KatalogController::class, 'store']);

Route::get('/admin/kategori/edit/{id}',
    [KatalogController::class, 'edit']);

Route::put('/admin/kategori/update/{id}',
    [KatalogController::class, 'update']);

Route::delete(
    '/admin/kategori/delete/{id}',
    [KatalogController::class, 'destroy']
);

Route::delete(
    '/admin/user/delete/{id}',
    [UserController::class, 'destroy']
)->name('admin.user.destroy');

Route::post(
    '/admin/produk/store',
    [ProdukController::class, 'store']
);

Route::put(
    '/admin/produk/update/{id}',
    [ProdukController::class, 'update']
);

Route::get(
    '/admin/produk/edit/{id}',
    [ProdukController::class, 'edit']
);

Route::delete(
    '/admin/produk/delete/{id}',
    [ProdukController::class,'destroy']
)->name('admin.produk.destroy');

Route::delete(
    '/admin/review/delete/{id}',
    [ReviewController::class, 'destroy']
)->name('admin.review.destroy');