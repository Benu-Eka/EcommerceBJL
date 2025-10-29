<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokBarang extends Model
{
    use HasFactory;

    protected $table = 'stok_barangs'; // sesuaikan nama tabel stok kamu
    protected $primaryKey = 'id_stok'; // atau kolom primary key sebenarnya
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'kode_barang',
        'jumlah',
        'lokasi',
        'tanggal_masuk',
        'tanggal_keluar'
    ];

    // Relasi balik ke Barang
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'kode_barang', 'kode_barang');
    }
}
