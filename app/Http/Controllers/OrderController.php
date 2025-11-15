<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratJalan;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index()
    {
        return view('orders.checkout');
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $pelangganId = Auth::id(); 

        $sj_id = 'SJ-' . now()->format('ymd') . '-' . strtoupper(substr(uniqid(), -5));
        SuratJalan::create([
            'sj_id'             => $sj_id,
            'user_id'           => 'E-Commerce',
            'pelanggan_id'      => Auth::id(),
            'tanggal_surat'     => now(),
            'status'            => 'Pending',
            'biaya_pengiriman'  => 5000.00,
            'diskon_pelanggan'  => 10.00,
            'subtotal'          => 105000.00,
        ]);

        Log::info('Surat Jalan berhasil dibuat', [
            'sj_id' => $sj_id,
            'pelanggan_id' => Auth::id(),
            'status' => 'Pending',
        ]);
        
        return redirect()->route('orders.checkout')->with('success', "Surat Jalan berhasil dibuat! ID: {$sj_id}");
    }
}
