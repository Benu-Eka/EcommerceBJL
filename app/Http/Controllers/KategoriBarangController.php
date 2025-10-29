<?php

namespace App\Http\Controllers;

use App\Models\KategoriBarang;
use Illuminate\Http\Request;

class KategoriBarangController extends Controller
{
    public function index()
    {
        $kategoris = KategoriBarang::all(); // ambil semua kategori
        return view('index', compact('kategoris')); // kirim ke view
    }
}
