<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasalahKulit extends Model
{
    protected $table = 'masalah_kulit';
    protected $primaryKey = 'id_masalah_kulit';
    public $timestamps = false;
    protected $fillable = ['nama_masalah_kulit'];

     public function produk()
    {
        return $this->hasMany(Produk::class, 'id_masalah_kulit');
    }
}

