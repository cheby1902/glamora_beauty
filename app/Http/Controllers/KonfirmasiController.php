<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Keranjang;
use Illuminate\Http\Request;

class KonfirmasiController extends Controller
{

public function index()
{
    if (!session()->has('user_id')) {

        return redirect('/login');

    }

    $pesanan = Pesanan::where(
        'id_user',
        session('user_id')
    )
    ->latest('id_pesanan')
    ->first();

    $detailPesanan = $pesanan
        ? $pesanan->detailPesanan()->with('produk')->get()
        : collect();

    $jumlahKeranjang = Keranjang::where(
        'id_user',
        session('user_id')
    )->sum('jumlah');

    return view('konfirmasi', compact(
        'pesanan',
        'detailPesanan',
        'jumlahKeranjang'
    ));
}
}