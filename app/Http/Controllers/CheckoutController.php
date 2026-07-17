<?php

namespace App\Http\Controllers;

use App\Models\Katalog;
use App\Models\Keranjang;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    public function index()
    {
        $katalog = Katalog::all();

        $jumlahKeranjang = Keranjang::where(
            'id_user',
            session('user_id')
        )->sum('jumlah');

        return view(
            'katalog.index',
            compact(
                'katalog',
                'jumlahKeranjang'
            )
        );
    }
}