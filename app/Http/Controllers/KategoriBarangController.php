<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\KategoriBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KategoriBarangController extends Controller
{
public function index(Request $request)
    {
        $query = Barang::query()
            ->where('barangs.is_visible', 1);

        $searchTerm = $request->input('q');

        // 🔍 PENCARIAN
        if ($searchTerm) {
            $keywords = array_filter(explode(' ', $searchTerm));
            $query->where(function ($q) use ($keywords, $searchTerm) {
                // Tetap cari kode barang secara persis
                $q->where('kode_barang', 'like', '%' . $searchTerm . '%');
                
                // Cari nama barang dengan semua kata kunci (tidak harus urut)
                $q->orWhere(function($subQ) use ($keywords) {
                    foreach ($keywords as $word) {
                        $subQ->where('nama_barang', 'like', '%' . $word . '%');
                    }
                });
            });
        }

        // 🔃 SORTING
        $sort = $request->input('sort', 'terbaru');

        switch ($sort) {
            case 'terlaris':
                $query->leftJoin('order_items', 'order_items.kode_barang', '=', 'barangs.kode_barang')
                      ->leftJoin('orders', function ($join) {
                          $join->on('orders.order_id', '=', 'order_items.order_id')
                               ->where('orders.status', 'selesai');
                      })
                      ->select(
                          'barangs.*',
                          DB::raw('COALESCE(SUM(order_items.quantity), 0) as total_terjual')
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

        // REKOMENDASI PRODUK (RIWAYAT PEMBELIAN)
        $recommendations = collect();
        if (Auth::guard('pelanggan')->check()) {
            $userId = Auth::guard('pelanggan')->id();
            
            // Cari kategori produk yang sering dibeli pelanggan ini (menggunakan Eloquent agar terhindar dari error collation)
            $orders = \App\Models\Order::where('pelanggan_id', $userId)
                ->where('status', 'selesai')
                ->with('items.barang')
                ->get();

            $topCategories = $orders->flatMap(function ($order) {
                return $order->items;
            })->pluck('barang.kategori_barang_id')->filter()->countBy()->sortDesc()->take(3)->keys();

            if ($topCategories->isNotEmpty()) {
                $recommendations = Barang::where('is_visible', 1)
                    ->whereIn('kategori_barang_id', $topCategories)
                    ->inRandomOrder()
                    ->take(5)
                    ->get();
            }
        }

        // Fallback jika belum login atau belum menyelesaikan pesanan
        if ($recommendations->isEmpty()) {
            $recommendations = Barang::where('is_visible', 1)
                ->orderBy('berlaku_mulai', 'desc')
                ->take(5)
                ->get();
        }

        return view('index', compact('kategoris', 'products', 'searchTerm', 'recommendations')); // kirim ke view
    }
}
