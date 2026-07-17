<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanan';

    protected $primaryKey = 'id_pesanan';

    public $timestamps = false;

    protected $fillable = [
    'id_user',
    'nama_penerima',
    'no_hp',
    'alamat',
    'kode_pos',
    'kota',
    'metode_pembayaran',
    'metode_pengiriman',
    'ongkos_kirim',
    'total_bayar',
    'tanggal_pesan',
    'estimasi_tiba',
    'status_pesanan',
    'status_dibaca',
];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'id_pesanan');
    }

    public function struk()
    {
        return $this->hasOne(Struk::class, 'id_pesanan');
    }
}