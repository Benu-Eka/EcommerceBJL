<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pelanggan extends Authenticatable
{
    use Notifiable;

    protected $table = 'pelanggans';
    protected $primaryKey = 'pelanggan_id';

    protected $fillable = [
        'nama_pelanggan',
        'PIC',
        'alamat',
        'NPWP',
        'kategori_pelanggan_id',
        'email',
        'password',
    ];

    protected $hidden = ['password', 'remember_token'];

    public function orders()
    {
        return $this->hasMany(Order::class, 'pelanggan_id');
    }

    public function kategoriPelanggan()
    {
        return $this->belongsTo(KategoriPelanggan::class, 'kategori_pelanggan_id', 'kategori_pelanggan_id');
    }

                                                                        
}
