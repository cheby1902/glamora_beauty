<?php

namespace App\Http\Controllers;
use App\Models\Review;
use App\Models\Produk;
use Illuminate\Http\Request;
use App\Models\Keranjang;
use App\Models\Pesanan;

class ReviewController extends Controller
{

public function index($id_produk)
{
    $produk = Produk::findOrFail($id_produk);

    $jumlahKeranjang = Keranjang::where(
        'id_user',
        session('user_id')
    )->sum('jumlah');

    $jumlahNotifikasi = Pesanan::where(
        'id_user',
        session('user_id')
    )
    ->where('status_dibaca', 1)
    ->count();

    return view('review', [
        'produk' => $produk,
        'jumlahKeranjang' => $jumlahKeranjang,
        'jumlahNotifikasi' => $jumlahNotifikasi,
    ]);
}

    public function store(Request $request)
{

        $cekReview = Review::where(
        'id_user',
        session('user_id')
    )
    ->where(
        'id_produk',
        $request->id_produk
    )
    ->first();

    if ($cekReview) {
        return back()->with(
            'error',
            'Kamu sudah memberi ulasan untuk produk ini.'
        );
    }
    
    Review::create([
    'id_user' => session('user_id'),
    'id_produk' => $request->id_produk,
    'rating' => $request->rating,
    'komentar' => $request->komentar
]);

return redirect()->route(
    'produk.detail',
    $request->id_produk
);

}

public function destroy($id)
{
    $review = Review::findOrFail($id);

    $review->delete();

    return redirect('/admin-dashboard#review');
}

}