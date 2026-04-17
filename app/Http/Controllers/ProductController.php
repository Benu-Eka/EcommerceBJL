<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\KategoriBarang;


class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Barang::query();
        $searchTerm = $request->input('q');

        // 1. Logika Pencarian
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

        // 2. Filter Kategori
        $selectedKategori = $request->input('kategori', []);
        if (!empty($selectedKategori)) {
            $query->whereIn('kategori_barang_id', $selectedKategori);
        }

        // 3. Filter Rentang Harga
        if ($request->filled('harga_min')) {
            $query->where('harga_jual', '>=', $request->input('harga_min'));
        }
        if ($request->filled('harga_max')) {
            $query->where('harga_jual', '<=', $request->input('harga_max'));
        }

        // 4. Logika Sorting
        $sort = $request->input('sort', 'terbaru');

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

        // 5. Ambil data dengan Pagination
        $products = $query->paginate(12);

        // 6. Ambil semua kategori + jumlah produk visible
        $categories = KategoriBarang::withCount(['barangs' => function ($q) {
            $q->where('is_visible', true);
        }])->get();

        return view('product', [
            'products' => $products,
            'searchTerm' => $searchTerm,
            'categories' => $categories,
            'selectedKategori' => $selectedKategori,
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