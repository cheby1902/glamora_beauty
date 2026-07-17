<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keranjang;

class KeranjangController extends Controller
{
public function index()
{

if (!session()->has('user_id')) {

        return redirect('/login');

    }

    $keranjang = Keranjang::with([
    'produk',
    'produkVarian.warnaKulit'
    ])
    ->where('id_user', session('user_id'))
    ->get();

$total = 0;

foreach ($keranjang as $item) {
    $total += $item->produkVarian->harga * $item->jumlah;
}
$jumlahKeranjang = $keranjang->sum('jumlah');

    return view(
        'keranjang',
        compact(
            'keranjang',
            'total',
            'jumlahKeranjang'
        )
    );
}


public function tambah(Request $request)
{

 if (!session()->has('user_id')) {

        return redirect('/login');

    }

    Keranjang::create([
    'id_produk'         => $request->produk_id,
    'id_produk_varian'  => $request->id_produk_varian,
    'id_user'           => session('user_id'),
    'jumlah'            => $request->qty
    ]);


    return redirect('/keranjang');
}

public function destroy($id)
{

 if (!session()->has('user_id')) {

        return redirect('/login');

    }

    $item = Keranjang::where(
        'id_keranjang',
        $id
    )
    ->where(
        'id_user',
        session('user_id')
    )
    ->firstOrFail();

    $item->delete();

    return back()->with(
        'success',
        'Produk berhasil dihapus dari keranjang.'
    );
}

}