<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaldoTransaction extends Model
{
    protected $table = 'saldo_transactions';

    protected $fillable = [
        'pelanggan_id',
        'order_id',
        'tipe',
        'jumlah',
        'saldo_sebelum',
        'saldo_sesudah',
        'keterangan',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id', 'pelanggan_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }
}
