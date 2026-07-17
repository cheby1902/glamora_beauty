<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';

    protected $primaryKey = 'id_produk';

    public $timestamps = false;

    protected $fillable = [
    'nama_produk',
    'gambar_produk',
    'id_jenis_kulit',
    'id_katalog',
    'id_masalah_kulit',
    'deskripsi_produk',
    'brand'
];

    public function jenisKulit()
    {
        return $this->belongsTo(JenisKulit::class, 'id_jenis_kulit');
    }

    public function katalog()
    {
        return $this->belongsTo(Katalog::class, 'id_katalog');
    }

    public function masalahKulit()
    {
        return $this->belongsTo(MasalahKulit::class, 'id_masalah_kulit');
    }


    public function keranjang()
    {
        return $this->hasMany(Keranjang::class, 'id_produk');
    }

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'id_produk');
    }

    public function review()
    {
        return $this->hasMany(Review::class, 'id_produk');
    }

    public function produkVarian()
    {
    return $this->hasMany(ProdukVarian::class, 'id_produk');
    }
}