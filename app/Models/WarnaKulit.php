<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarnaKulit extends Model
{
    protected $table = 'warna_kulit';
    protected $primaryKey = 'id_warna_kulit';
    public $timestamps = false;
    protected $fillable = ['nama_warna_kulit'];

     public function produk()
    {
        return $this->hasMany(Produk::class, 'id_warna_kulit');
    }
}
