<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\KategoriBarang;
use Illuminate\Http\Request;

class KategoriBarangController extends Controller
{
public function index(Request $request)
    {
        $query = Barang::query()
            ->where('barangs.is_visible', 1);

        $searchTerm = $request->input('q');

        // 🔍 PENCARIAN
        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nama_barang', 'like', '%' . $searchTerm . '%')
                  ->orWhere('kode_barang', 'like', '%' . $searchTerm . '%');
            });
        }

        // 🔃 SORTING
        $sort = $request->input('sort', 'terbaru');

        switch ($sort) {
            case 'terlaris':
                $query->leftJoin('order_items', 'order_items.kode_barang', '=', 'barangs.kode_barang')
                      ->leftJoin('orders', function ($join) {
                          $join->on('orders.id', '=', 'order_items.order_id')
                               ->where('orders.status', 'selesai');
                      })
                      ->select(
                          'barangs.*',
                          DB::raw('COALESCE(SUM(order_items.qty), 0) as total_terjual')
                      )
                      ->groupBy('barangs.kode_barang')
                      ->orderByDesc('total_terjual');
                break;

            case 'termurah':
                $query->orderBy('harga_jual', 'asc');
                break;

            case 'termahal':
                $query->orderBy('harga_jual', 'desc');
                break;

            case 'terbaru':
            default:
                $query->orderBy('berlaku_mulai', 'desc');
                break;
        }

        $products = $query->paginate(12);
    
        $kategoris = KategoriBarang::all(); // ambil semua kategori
        return view('index', compact('kategoris', 'products', 'searchTerm')); // kirim ke view
    }
}
