
<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voucher;
use App\Models\VoucherUser;
use Illuminate\Support\Facades\Auth;

class VoucherController extends Controller
{
    public function claim(Request $request)
    {
        $request->validate([
            'kode' => 'required'
        ]);

        if (!Auth::check()) {
            return response()->json(['error' => 'Anda harus login untuk klaim voucher'], 403);
        }

        $voucher = Voucher::where('kode', $request->kode)->first();

        if (!$voucher) {
            return response()->json(['error' => 'Voucher tidak ditemukan'], 404);
        }

        // Cek apakah user sudah klaim voucher ini
        $existing = VoucherUser::where('user_id', Auth::id())
                               ->where('voucher_id', $voucher->id)
                               ->first();

        if ($existing) {
            return response()->json(['error' => 'Voucher ini sudah pernah diklaim'], 409);
        }

        // Simpan klaim
        VoucherUser::create([
            'user_id' => Auth::id(),
            'voucher_id' => $voucher->id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Voucher berhasil diklaim!',
            'voucher' => $voucher
        ]);
    }
}
