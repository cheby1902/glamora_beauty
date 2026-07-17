<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    protected $table = 'detail_pesanan';

    protected $primaryKey = 'id_detail';

    public $timestamps = false;

    protected $fillable = [
        'id_pesanan',
        'id_produk',
        'id_produk_varian',
        'jumlah',
        'subtotal'
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }

    public function produkVarian()
{
    return $this->belongsTo(
        ProdukVarian::class,
        'id_produk_varian'
    );
}

}