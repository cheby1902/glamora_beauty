<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'user';

    protected $primaryKey = 'id_user';

    public $timestamps = false;

   protected $fillable = [
    'nama_user',
    'username',
    'email',
    'password',
    'role',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function keranjang()
    {
        return $this->hasMany(Keranjang::class, 'id_user');
    }

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'id_user');
    }

    public function review()
    {
        return $this->hasMany(Review::class, 'id_user');
    }
}