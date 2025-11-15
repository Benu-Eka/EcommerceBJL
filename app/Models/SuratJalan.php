<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratJalan extends Model
{
    use HasFactory;

    protected $table = 'surat_jalans';
    protected $primaryKey = 'sj_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'sj_id',
        'user_id',
        'pelanggan_id',
        'tanggal_surat',
        'status',
        'biaya_pengiriman',
        'diskon_pelanggan',
        'subtotal',
    ];
}
