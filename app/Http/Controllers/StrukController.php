<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Keranjang;

class StrukController extends Controller
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

    if (session('checkout_from') == 'cart') {

        Keranjang::where(
            'id_user',
            session('user_id')
        )->delete();

        session()->forget('checkout_from');
    }

        if (!$pesanan) {
            return 'Pesanan tidak ditemukan';
        }

        // Aktifkan notifikasi setelah user menyelesaikan pesanan
        $pesanan->update([
            'status_dibaca' => 0
        ]);
        
        $detailPesanan = DetailPesanan::with([
    'produk',
    'produkVarian.warnaKulit'
    ])
    ->where(
        'id_pesanan',
        $pesanan->id_pesanan
    )
    ->get();

        $produkReview = $detailPesanan->first();

        $jumlahKeranjang = Keranjang::where(
            'id_user',
            session('user_id')
        )->sum('jumlah');

        return view('struk', compact(
            'pesanan',
            'detailPesanan',
            'produkReview',
            'jumlahKeranjang'
        ));
    }
}