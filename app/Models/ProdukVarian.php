<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdukVarian extends Model
{
    protected $table = 'produk_varian';

    protected $primaryKey = 'id_produk_varian';

    public $timestamps = false;

    protected $fillable = [
        'id_produk',
        'id_warna_kulit',
        'nama_varian',
        'harga',
        'stock'
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }

    public function warnaKulit()
    {
        return $this->belongsTo(WarnaKulit::class, 'id_warna_kulit');
    }

    public function detailPesanan()
{
    return $this->hasMany(
        DetailPesanan::class,
        'id_produk_varian'
    );
}
}