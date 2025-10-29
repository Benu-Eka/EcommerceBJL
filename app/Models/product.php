<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'image',
        'description',
    ];

    // Relasi ke order
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Akses URL gambar produk
    public function getImageUrlAttribute()
    {
        return $this->image 
            ? asset('build/assets/images/' . $this->image)
            : 'https://via.placeholder.com/100';
    }
}
