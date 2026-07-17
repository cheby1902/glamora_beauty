<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Struk extends Model
{
    protected $table = 'struk';

    protected $primaryKey = 'id_struk';

    public $timestamps = false;

    protected $fillable = [
        'id_pesanan',
        'nomor_struk',
        'tanggal_cetak'
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan');
    }
}