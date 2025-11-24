<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratJalan;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;

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


public function pay(Request $request)
{
    Log::info("PAY HIT", [
        'url' => $request->url(),
        'expectsJson' => $request->expectsJson(),
        'user' => auth('pelanggan')->user(),
    ]);

    // VALIDASI
    $request->validate([
        'nama_penerima' => 'required',
        'alamat' => 'required',
        'kota' => 'required',
        'telepon' => 'required',
    ]);

    // TOTAL SEMENTARA
    $total = 99500;

    // KONFIGURASI MIDTRANS (VERSI LAMA)
    Config::$serverKey     = config('midtrans.server_key');
    Config::$clientKey     = config('midtrans.client_key');
    Config::$isProduction  = config('midtrans.is_production');
    Config::$isSanitized   = true;
    Config::$is3ds         = true;

    // PARAMETER
    $params = [
        'transaction_details' => [
            'order_id' => 'ORDER-' . time(),
            'gross_amount' => $total,
        ],
        'customer_details' => [
            'first_name' => $request->nama_penerima,
            'phone' => $request->telepon,
            'shipping_address' => [
                'first_name' => $request->nama_penerima,
                'address' => $request->alamat,
                'city' => $request->kota,
            ]
        ]
    ];

    try {
        $snapToken = Snap::getSnapToken($params);
    } catch (\Exception $e) {
        Log::error("Midtrans Error", ["msg" => $e->getMessage()]);
        return response()->json([
            'error' => true,
            'message' => $e->getMessage()
        ], 500);
    }

    return response()->json([
        'snap_token' => $snapToken
    ]);
}
}
