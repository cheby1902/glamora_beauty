<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\Katalog;
use App\Models\Review;
use App\Models\User;
use App\Models\JenisKulit;
use App\Models\MasalahKulit;
use App\Models\WarnaKulit;

class AdminController extends Controller
{
    public function dashboard()
{

if (
        !session()->has('user_id') ||
        session('role') != 'admin'
    ) {

        return redirect('/login');

    }

    $orders = Pesanan::with([
    'detailPesanan.produk',
    'detailPesanan.produkVarian'
])->get();
    $totalProduk = Produk::count();
    $totalKategori = Katalog::count();
    $totalUlasan = Review::count();
    $produk = Produk::with([
    'jenisKulit',
    'masalahKulit',
    'katalog',
    'produkVarian.warnaKulit'
    ])->get();
    $katalog = Katalog::all();
    $reviews = Review::all();
    $users = User::all();
    $jenisKulit = JenisKulit::all();
    $masalahKulit = MasalahKulit::all();
    $warnaKulit = WarnaKulit::all();

    return view(
        'admin.dashboard',
        compact(
            'orders',
            'totalProduk',
            'totalKategori',
            'totalUlasan',
            'produk',
            'katalog',
            'reviews',
            'users',
            'jenisKulit',
            'masalahKulit',
            'warnaKulit'
        )
    );
}

public function updateStatus(Request $request, $id)
{

    if (
        !session()->has('user_id') ||
        session('role') != 'admin'
    ) {

        return redirect('/login');

    }

    $pesanan = Pesanan::findOrFail($id);

    $pesanan->update([
        'status_pesanan' => $request->status_pesanan
    ]);

    return redirect()
        ->back()
        ->with('success', 'Status pesanan berhasil diupdate');
}

}