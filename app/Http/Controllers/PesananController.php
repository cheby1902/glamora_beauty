<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Keranjang;
use App\Models\DetailPesanan;
use App\Models\ProdukVarian;
use App\Models\Struk;

class PesananController extends Controller
{

    public function checkout(Request $request)
{

if (!session()->has('user_id')) {

        return redirect('/login');

    }

    $jumlahKeranjang = Keranjang::where(
        'id_user',
        session('user_id')
    )->sum('jumlah');

    return view('checkout', [
    'id_produk' => $request->id_produk,
    'id_produk_varian' => $request->id_produk_varian,
    'qty' => $request->qty,
    'jumlahKeranjang' => $jumlahKeranjang,
    'from' => $request->from
]);
}

    public function store(Request $request)
    {

if (!session()->has('user_id')) {

        return redirect('/login');

    }

// TAMBAHKAN DI SINI
    $request->validate([
        'nama_penerima' => 'required',
        'no_hp' => 'required',
        'alamat' => 'required',
        'kode_pos' => 'required',
        'kota' => 'required',
        'metode_pengiriman' => 'required',
        'metode_pembayaran' => 'required',
    ],[
        'nama_penerima.required' => 'Nama penerima wajib diisi.',
        'no_hp.required' => 'Nomor HP wajib diisi.',
        'alamat.required' => 'Alamat wajib diisi.',
        'kode_pos.required' => 'Kode pos wajib diisi.',
        'kota.required' => 'Kota wajib diisi.',
        'metode_pengiriman.required' => 'Pilih metode pengiriman.',
        'metode_pembayaran.required' => 'Pilih metode pembayaran.',
    ]);


    session([
        'checkout_from' => $request->from
    ]);

        $ongkir = match ($request->metode_pengiriman) {
            'reguler' => 15000,
            'express' => 30000,
            'sameday' => 50000,
            default => 15000,
        };

        $estimasi = match ($request->metode_pengiriman) {
            'reguler' => now()->addDays(5),
            'express' => now()->addDays(2),
            'sameday' => now()->addDay(),
            default => now()->addDays(5),
        };

        if ($request->filled('id_produk')) {

    $varian = ProdukVarian::findOrFail(
        $request->id_produk_varian
    );

    $subtotal =
        $varian->harga * $request->qty;

} else {

    $keranjang = Keranjang::where(
        'id_user',
        session('user_id')
    )->get();

    $subtotal = 0;

    foreach ($keranjang as $item) {
        $subtotal +=
            $item->produkVarian->harga *
            $item->jumlah;
    }

}
        $pesanan = Pesanan::create([
            'id_user' => session('user_id'),

            'nama_penerima' => $request->nama_penerima,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'kode_pos' => $request->kode_pos,
            'kota' => $request->kota,

            'metode_pembayaran' => $request->metode_pembayaran,
            'metode_pengiriman' => $request->metode_pengiriman,

            'ongkos_kirim' => $ongkir,

            'total_bayar' => $subtotal + $ongkir,

            'tanggal_pesan' => now(),
            'estimasi_tiba' => $estimasi,

            'status_pesanan' => 'Sedang Dikemas',

            'status_dibaca' => 1,
        ]);


Struk::create([
    'id_pesanan' => $pesanan->id_pesanan,
    'nomor_struk' => 'INV-' . date('Ymd') . '-' . str_pad($pesanan->id_pesanan, 4, '0', STR_PAD_LEFT),
    'tanggal_cetak' => now(),
]);

        if ($request->filled('id_produk')) {

    $varian = ProdukVarian::findOrFail(
        $request->id_produk_varian
    );

    DetailPesanan::create([
    'id_pesanan' => $pesanan->id_pesanan,
    'id_produk' => $request->id_produk,
    'id_produk_varian' => $request->id_produk_varian,
    'jumlah' => $request->qty,
    'subtotal' =>
        $varian->harga * $request->qty
]);

    $varian->decrement(
        'stock',
        $request->qty
    );

} else {

    $keranjang = Keranjang::where(
        'id_user',
        session('user_id')
    )->get();

    foreach ($keranjang as $item) {

        DetailPesanan::create([
    'id_pesanan' => $pesanan->id_pesanan,
    'id_produk' => $item->id_produk,

    'id_produk_varian' => $item->id_produk_varian,

    'jumlah' => $item->jumlah,
    'subtotal' =>
        $item->produkVarian->harga *
        $item->jumlah
]);

        $item->produkVarian->decrement(
            'stock',
            $item->jumlah
        );
    }

}

        return redirect('/konfirmasi');
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

    $pesanan->status_pesanan =
        $request->status_pesanan;

    $pesanan->save();

    return redirect('/admin-dashboard');
}

public function destroy($id)
{

if (
        !session()->has('user_id') ||
        session('role') != 'admin'
    ) {

        return redirect('/login');

    }
    
    DetailPesanan::where(
        'id_pesanan',
        $id
    )->delete();

    Pesanan::destroy($id);

    return back();
}

}