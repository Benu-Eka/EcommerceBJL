<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders'; // penting!
    protected $primaryKey = 'order_id';

    protected $fillable = [
        'pelanggan_id',
        'nama_penerima',
        'alamat',
        'metode_pembayaran',
        'status',
        'total',
        'midtrans_order_id'
    ];

    // RELASI KE PELANGGAN
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    }

    // RELASI KE DETAIL BARANG DI DALAM ORDER
    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'order_id');
    }

    // RELASI KE TABEL PEMBAYARAN (MIDTRANS)
    public function payment()
    {
        return $this->hasOne(Payment::class, 'order_id');
    }
}
