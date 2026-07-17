<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Katalog extends Model
{
   // 1. Kasih tahu Laravel kalau nama tabelnya 'katalog' (bukan catalogs)
    protected $table = 'katalog';

    // 2. Tentukan primary key-nya kalau bukan 'id' (misal: id_katalog)
 protected $primaryKey = 'id_katalog';

    // 3. Kalau di tabel katalog kamu nggak ada kolom 'created_at' & 'updated_at',
    // wajib tambahin ini biar nggak error pas simpan data:
    public $timestamps = false;
    
    // 4. Daftarkan kolom yang boleh diisi (mass assignment)
    protected $fillable = ['nama_katalog', 'gambar_katalog'];

    public function produk()
{
    return $this->hasMany(Produk::class, 'id_katalog');
}
}
