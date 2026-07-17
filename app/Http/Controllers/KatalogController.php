<?php

namespace App\Http\Controllers;
use App\Models\Katalog;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    public function index()
    {
        // Mengambil semua data dari tabel katalog
        $katalog = Katalog::all();

        // Mengirim data ke file view (nanti kita buat filenya)
        return view('katalog.index', compact('katalog'));
    }

    public function store(Request $request)
{
    Katalog::create([
        'nama_katalog'   => $request->nama_katalog,
        'gambar_katalog' => $request->gambar_katalog,
    ]);

    return redirect('/admin-dashboard#kategori');
}

    public function edit($id)
    {
        $katalog = Katalog::findOrFail($id);

        return view('admin.edit-kategori', compact('katalog'));
    }

    public function update(Request $request, $id)
{
    $katalog = Katalog::findOrFail($id);

    $katalog->update([
    'nama_katalog'   => $request->nama_katalog,
    'gambar_katalog' => $request->gambar_katalog,
    ]);

    return redirect('/admin-dashboard#kategori');
}

   public function destroy($id)
{
    $katalog = Katalog::findOrFail($id);

    $katalog->delete();

    return redirect('/admin-dashboard#kategori');
}
}
