<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use App\Models\Pelanggan;
use App\Models\KategoriPelanggan;

class ProfileController extends Controller
{

    public function index()
    {
        $pelanggan = Auth::guard('pelanggan')->user()
                        ->load('kategoriPelanggan');

        return view('profile.index', compact('pelanggan'));
    }


    /**
     * Tampilkan form profil pelanggan.
     */
    public function edit(Request $request)
    {
        $pelanggan = Auth::guard('pelanggan')->user();

        if (!$pelanggan) {
            return redirect()->route('pelanggan.login.form')->withErrors([
                'auth' => 'Silakan login terlebih dahulu.'
            ]);
        }

        // Ambil semua kategori dari DB
        $kategori = KategoriPelanggan::orderBy('kategori_pelanggan')->get();

        return view('profile.form', compact('pelanggan', 'kategori'));
    }

    /**
     * Update informasi profil pelanggan.
     */
        public function update(Request $request)
        {
            $pelanggan = Auth::guard('pelanggan')->user();

            if (!$pelanggan) {
                return redirect()->route('pelanggan.login.form')->withErrors([
                    'auth' => 'Silakan login terlebih dahulu.'
                ]);
            }

            $data = $request->validate([
                'nama_pelanggan' => 'required|string|max:255',
                'email' => 'required|email|unique:pelanggans,email,' . $pelanggan->pelanggan_id . ',pelanggan_id',
                'alamat' => 'required|string',
                'NPWP' => 'nullable|string|max:50',
                'PIC' => 'required|string|max:100',
                'kategori_pelanggan_id' => 'required|exists:kategori_pelanggans,kategori_pelanggan_id', // ← WAJIB
                'password' => 'nullable|min:6|confirmed',
            ]);
            

            // Update password jika diisi
            if (!empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }

            // Update data pelanggan
            $pelanggan->update($data);

            return redirect()
                ->route('profile.edit')
                ->with('success', 'Profil berhasil diperbarui!');
        }


    /**
     * Hapus akun pelanggan.
     */
    public function destroy(Request $request)
    {
        $pelanggan = Auth::guard('pelanggan')->user();

        if (!$pelanggan) {
            return redirect()->route('pelanggan.login.form')->withErrors([
                'auth' => 'Silakan login terlebih dahulu.'
            ]);
        }

        $request->validate([
            'password' => ['required'],
        ]);

        if (!Hash::check($request->password, $pelanggan->password)) {
            return back()->withErrors(['password' => 'Password tidak sesuai.']);
        }

        Auth::guard('pelanggan')->logout();
        $pelanggan->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('status', 'Akun berhasil dihapus.');
    }
}
