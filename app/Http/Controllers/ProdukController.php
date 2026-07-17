<?php

namespace App\Http\Controllers;                                               

use App\Models\Produk;
use App\Models\ProdukVarian;
use App\Models\Katalog;
use Illuminate\Http\Request;
use App\Models\JenisKulit;
use App\Models\MasalahKulit;
use App\Models\WarnaKulit;
use App\Models\Keranjang;
use App\Services\ContentBasedService;

class ProdukController extends Controller
{

protected $contentBasedService;

    public function __construct()
    {
        $this->contentBasedService =
            new ContentBasedService();
    }

    public function index()
    {
        // Ambil semua data produk beserta relasinya
        $produk = Produk::with([
            'katalog',
            'jenisKulit',
            'masalahKulit',
            'produkVarian.warnaKulit'
        ])
        ->where('id_katalog', $id)
        ->get();
    }

    public function kategori(Request $request, $id)
{

if (!session()->has('user_id')) {

        return redirect('/login');

    }

    $katalog = Katalog::findOrFail($id);

    $pakaiSimilarity = in_array($id, [1,2,3,4,10]);

$query = Produk::with([
    'jenisKulit',
    'masalahKulit',
    'produkVarian.warnaKulit'
])
->where('id_katalog', $id);

$produk = $query->get();



if ($pakaiSimilarity) {
$dokumenProduk = [];

foreach ($produk as $item) {

    $dokumenProduk[$item->id_produk] =
        $this->contentBasedService
            ->buatDokumenProduk($item);

}

$tokenProduk = [];

foreach ($dokumenProduk as $idProduk => $dokumen) {

    $tokenProduk[$idProduk] =
        $this->contentBasedService
            ->tokenisasi($dokumen);

}

$tfProduk = [];

foreach ($tokenProduk as $idProduk => $token) {

    $tfProduk[$idProduk] =
        $this->contentBasedService
            ->hitungTF($token);

}

$idf = $this->contentBasedService
    ->hitungIDF($tfProduk);

    $tfidfProduk =
    $this->contentBasedService
        ->hitungTFIDF(
            $tfProduk,
            $idf
        );

        $kataUser = '';

if ($request->filled('jenis')) {
    $kataUser .= ' ' . strtolower($request->jenis);
}

if ($request->filled('masalah')) {
    $kataUser .= ' ' . strtolower($request->masalah);
}

// hanya katalog lipstick (10) yang tidak memakai warna kulit
// katalog 1,2,3,4 juga tidak memakai filter warna
if (!in_array($id, [1,2,3,4,10]) && $request->filled('warna')) {

    $kataUser .= ' ' . strtolower($request->warna);

}

$tokenUser =
    $this->contentBasedService
        ->tokenisasi($kataUser);

$tfUser =
    $this->contentBasedService
        ->hitungTF($tokenUser);

        $tfidfUser =
    $this->contentBasedService
        ->hitungTFIDFUser(
            $tfUser,
            $idf
        );

        $similarity = [];

foreach ($tfidfProduk as $idProduk => $vektor) {

    $similarity[$idProduk] =
        $this->contentBasedService
            ->hitungCosineSimilarity(
                $tfidfUser,
                $vektor
            );

}

arsort($similarity);

$pakaiFilter =
    $request->filled('jenis') ||
    $request->filled('masalah') ||
    ($id != 10 && $request->filled('warna'));

if ($pakaiFilter) {

    $idUrut = [];

    foreach ($similarity as $idProduk => $nilai) {

        if ($nilai > 0) {

            $idUrut[] = $idProduk;

        }

    }

} else {

    $idUrut = array_keys($similarity);

}

$produk = Produk::with([
    'jenisKulit',
    'masalahKulit',
    'produkVarian.warnaKulit'
])
->where('id_katalog', $id)
->whereIn('id_produk', $idUrut)
->get()
->sortBy(function ($item) use ($idUrut) {

    return array_search(
        $item->id_produk,
        $idUrut
    );

});

foreach ($produk as $item) {

    $item->similarity =
        $similarity[$item->id_produk] ?? 0;
}
}

    $jumlahKeranjang = Keranjang::where(
        'id_user',
        session('user_id')
    )->sum('jumlah');

    return view(
        'produk',
        compact(
            'produk',
            'katalog',
            'jumlahKeranjang'
        )
    );
}

   public function store(Request $request)
{
    $produk = Produk::create([
    'nama_produk' => $request->nama_produk,
    'brand' => $request->brand,
    'id_katalog' => $request->id_katalog,
    'id_jenis_kulit' => $request->id_jenis_kulit,
    'id_masalah_kulit' => $request->id_masalah_kulit,
    'deskripsi_produk' => $request->deskripsi_produk,
    'gambar_produk' => $request->gambar_produk
]);

    ProdukVarian::create([
        'id_produk' => $produk->id_produk,
        'id_warna_kulit' => $request->id_warna_kulit,
        'nama_varian' => $request->nama_varian,
        'harga' => $request->harga,
        'stock' => $request->stock
    ]);

    return redirect('/admin-dashboard#produk');
}

   public function edit($id)
{
    $produk = Produk::with('produkVarian')
        ->findOrFail($id);

    return response()->json($produk);
}

    public function update(Request $request, $id)
{
    $produk = Produk::findOrFail($id);

    $produk->update([
        'nama_produk' => $request->nama_produk,
        'brand' => $request->brand,
        'id_katalog' => $request->id_katalog,
        'id_jenis_kulit' => $request->id_jenis_kulit,
        'id_masalah_kulit' => $request->id_masalah_kulit,
        'deskripsi_produk' => $request->deskripsi_produk,
        'gambar_produk' => $request->gambar_produk
    ]);

    $varian = ProdukVarian::where(
        'id_produk',
        $produk->id_produk
    )->first();

    if ($varian) {

        $varian->update([

            'nama_varian' => $request->nama_varian,

            'id_warna_kulit' => $request->id_warna_kulit,

            'harga' => $request->harga,

            'stock' => $request->stock

        ]);
    }

    return redirect('/admin-dashboard#produk');
}

public function destroy($id)
{
    $produk = Produk::findOrFail($id);

    ProdukVarian::where(
        'id_produk',
        $produk->id_produk
    )->delete();

    $produk->delete();

    return redirect('/admin-dashboard#produk');
}

}