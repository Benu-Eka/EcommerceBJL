<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = [
        'kode', 'nama', 'keterangan', 'nilai_diskon', 'persen_diskon', 'min_order', 'kuota', 'aktif'
    ];

    public function users()
    {
        return $this->hasMany(VoucherUser::class);
    }
}
