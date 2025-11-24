<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoucherUser extends Model
{
    protected $fillable = [
        'voucher_id', 'pelanggan_id', 'kode', 'claimed_at'
    ];

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }

    public function pelanggan()
    {
        return $this->belongsTo(\App\Models\Pelanggan::class, 'pelanggan_id', 'pelanggan_id');
    }
}
