<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders'; // penting!
    protected $primaryKey = 'order_id';
    public $incrementing = false; // karena order_id bukan auto-increment
    protected $keyType = 'string';
    protected $fillable = [
        'order_id', 
        'pelanggan_id',
        'nama_penerima',
        'alamat',
        'metode_pembayaran',
        'status',
        'total',
        'midtrans_order_id',
        'telepon' // Tambahkan jika belum ada
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


}
