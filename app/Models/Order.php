<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
         'user_id', 'nama_penerima', 'alamat', 'metode_pembayaran', 'status', 'total'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
