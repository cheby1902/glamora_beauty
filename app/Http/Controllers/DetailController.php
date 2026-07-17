<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Keranjang;
use App\Models\Pesanan;
use App\Models\Review;

class DetailController extends Controller
{
    public function index()
    {
        $produk = Produk::all();

        return view('katalog', compact('produk'));
    }

public function show(Request $request, $id)
{

if (!session()->has('user_id')) {

    return redirect('/login');

}

    $produk = Produk::with([
        'review.user',
        'produkVarian.warnaKulit'
    ])->findOrFail($id);

    $jumlahKeranjang = Keranjang::where(
        'id_user',
        session('user_id')
    )->sum('jumlah');

    $canReview = false;
    $alreadyReviewed = false;

    if (session()->has('user_id')) {

        $alreadyReviewed = Review::where(
            'id_user',
            session('user_id')
        )
        ->where(
            'id_produk',
            $id
        )
        ->exists();

        $canReview = Pesanan::where(
            'id_user',
            session('user_id')
        )
        ->whereHas('detailPesanan', function ($q) use ($id) {
            $q->where('id_produk', $id);
        })
        ->exists();
    }

    $backUrl = url()->previous();

    return view(
        'detail',
        compact(
            'produk',
            'jumlahKeranjang',
            'canReview',
            'alreadyReviewed',
            'backUrl'
        )
    );
}
}