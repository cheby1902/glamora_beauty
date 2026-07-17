<?php

namespace App\Http\Controllers;
use App\Models\WarnaKulit;
use Illuminate\Http\Request;

class WarnaKulitController extends Controller
{
    public function index()
    {
        // Ambil semua data warna kulit
        $warnaKulit = WarnaKulit::all(); 
        
        // Kirim ke view warna_kulit.index
        return view('warna_kulit.index', compact('warnaKulit'));
    }
}
