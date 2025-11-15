<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';
    protected $primaryKey = 'payment_id';

    protected $fillable = [
        'order_id',
        'metode',
        'jumlah',
        'status',
        'transaction_id',
        'signature_key',
        'response_payload'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}

