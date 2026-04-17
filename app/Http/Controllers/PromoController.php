<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PromoController extends Controller
{
    public function index()
    {


        // Ambil produk flash sale (is_flash_sale = true)
        $flashsales = Barang::where('is_flash_sale', true)
                            ->where('stok_flash_sale', '>', 0)
                            ->orderBy('diskon', 'desc')
                            ->get();

        return view('promo.index', compact('flashsales'));
    }

}
