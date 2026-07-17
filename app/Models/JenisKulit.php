<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisKulit extends Model
{
    protected $table = 'jenis_kulit';
    protected $primaryKey = 'id_jenis_kulit';
    public $timestamps = false;
    protected $fillable = ['nama_jenis_kulit'];

     public function produk()
    {
        return $this->hasMany(Produk::class, 'id_jenis_kulit');
    }
}

