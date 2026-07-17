<?php

namespace App\Http\Controllers;
use App\Models\MasalahKulit;
use Illuminate\Http\Request;

class MasalahKulitController extends Controller
{
    public function index()
    {
        // Ambil semua data masalah kulit
        $masalahKulit = MasalahKulit::all(); 
        
        // Kirim ke view masalah-kulit.index
        return view('masalah_kulit.index', compact('masalahkulit'));
    }
}
