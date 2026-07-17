<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Keranjang;
use App\Models\Review;

class NotifikasiController extends Controller
{
    public function index()
    {

if (!session()->has('user_id')) {

        return redirect('/login');

    }

      $notifikasi = Pesanan::with([
    'detailPesanan.produk',
    'detailPesanan.produkVarian.warnaKulit'
    ])
    ->where(
        'id_user',
        session('user_id')
    )
->latest('id_pesanan')
->get()

->filter(function ($pesanan) {

    // selain Sudah Tiba selalu tampil
    if ($pesanan->status_pesanan != 'Sudah Tiba') {
        return true;
    }

    // kalau Sudah Tiba cek review
    foreach ($pesanan->detailPesanan as $detail) {

        $sudahReview = Review::where(
            'id_user',
            session('user_id')
        )
        ->where(
            'id_produk',
            $detail->id_produk
        )
        ->exists();

        if (!$sudahReview) {
            return true;
        }
    }

        return false;
        })
        ->values();

        Pesanan::where(
            'id_user',
            session('user_id')
        )->update([
            'status_dibaca' => 1
        ]);

        $jumlahKeranjang = Keranjang::where(
            'id_user',
            session('user_id')
        )->sum('jumlah');

        return view(
            'notifikasi',
            compact(
                'notifikasi',
                'jumlahKeranjang'
            )
        );
    }
}
