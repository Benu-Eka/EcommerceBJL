<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang; 


class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Barang::query();
        $searchTerm = $request->input('q');

        // 1. Logika Pencarian
        if ($searchTerm) {
            $query->where('nama_barang', 'like', '%' . $searchTerm . '%')
                  ->orWhere('kode_barang', 'like', '%' . $searchTerm . '%');
        }

        // 2. Logika Sorting (Tambahan)
        $sort = $request->input('sort', 'terbaru'); // Default sort 'terbaru'

        switch ($sort) {
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

        // 3. Ambil data dengan Pagination
        $products = $query->paginate(12); // Tampilkan 12 produk per halaman

        return view('product', [
            'products' => $products,
            'searchTerm' => $searchTerm,
        ]);
    }

    public function show($kode_barang)
    {
        // ambil produk berdasarkan kode_barang
        $product = Barang::where('kode_barang', $kode_barang)->firstOrFail();

        // produk terkait (kategori sama)
        $related = Barang::where('kategori_barang_id', $product->kategori_barang_id)
                        ->where('kode_barang', '!=', $kode_barang)
                        ->take(4)
                        ->get();

        return view('products.detail', compact('product', 'related'));
    }
}