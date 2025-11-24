<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriPelanggan extends Model
{
    protected $table = 'kategori_pelanggans';
    protected $primaryKey = 'kategori_pelanggan_id';

    protected $fillable = [
        'nama_kategori'
    ];

    public function pelanggan()
    {
        return $this->hasMany(Pelanggan::class, 'kategori_pelanggan_id');
    }
}
