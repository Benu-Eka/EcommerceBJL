<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'total',
        'status',
        'payment_method',
        'tracking_number',
        'delivery_date'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
