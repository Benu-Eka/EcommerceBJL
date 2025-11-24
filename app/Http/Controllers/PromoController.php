<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voucher;
use App\Models\VoucherUser;
use App\Models\Barang;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PromoController extends Controller
{
    public function index()
    {
        // Ambil voucher aktif
        $vouchers = Voucher::where('aktif', true)->get();

        // Ambil produk flash sale (is_flash_sale = true)
        $flashsales = Barang::where('is_flash_sale', true)
                            ->where('stok_flash_sale', '>', 0)
                            ->orderBy('diskon', 'desc')
                            ->get();

        return view('promo.index', compact('vouchers', 'flashsales'));
    }

    public function claim(Request $request)
    {
        $request->validate(['kode' => 'required|string']);

        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Silakan login terlebih dahulu.'], 401);
        }

        $voucher = Voucher::where('kode', $request->kode)->where('aktif', true)->first();
        if (!$voucher) {
            return response()->json(['error' => 'Voucher tidak ditemukan atau tidak aktif.'], 404);
        }

        // cek minimal order jika perlu (kita hanya cek klaim tersedia)
        // cek apakah user sudah klaim
        $existing = VoucherUser::where('voucher_id', $voucher->id)
                               ->where('pelanggan_id', $user->pelanggan_id)
                               ->first();
        if ($existing) {
            return response()->json(['error' => 'Kamu sudah mengklaim voucher ini sebelumnya.'], 422);
        }

        // cek kuota global (jika ada)
        if (!is_null($voucher->kuota)) {
            $claimedCount = VoucherUser::where('voucher_id', $voucher->id)->count();
            if ($claimedCount >= $voucher->kuota) {
                return response()->json(['error' => 'Kuota voucher sudah habis.'], 422);
            }
        }

        // simpan klaim
        $claim = VoucherUser::create([
            'voucher_id' => $voucher->id,
            'pelanggan_id' => $user->pelanggan_id,
            'kode' => $voucher->kode,
            'claimed_at' => Carbon::now()
        ]);

        return response()->json(['message' => 'Voucher berhasil diklaim! Cek di profil/promo kamu.']);
    }
}
