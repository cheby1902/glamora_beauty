<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    protected $table = 'keranjang';

    protected $primaryKey = 'id_keranjang';

    public $timestamps = false;

    protected $fillable = [
        'id_produk',
        'id_produk_varian',
        'id_user',
        'jumlah'
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }

    public function produkVarian()
    {
        return $this->belongsTo(ProdukVarian::class, 'id_produk_varian');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}