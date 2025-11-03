<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Hash;

class PelangganAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.pelanggan-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('pelanggan')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/'); // halaman utama
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('pelanggan')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function showRegisterForm()
    {
        return view('auth.pelanggan-register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'email' => 'required|email|unique:pelanggans,email',
            'password' => 'required|string|min:6|confirmed',
            'alamat' => 'required|string',
            'NPWP' => 'nullable|string|max:50',
            'PIC' => 'required|string|max:100',
            'kategori_pelanggan_id' => 'required|integer',
        ]);

        $data['password'] = Hash::make($data['password']);
        Pelanggan::create($data);

        return redirect()->route('pelanggan.login')->with('success', 'Registrasi berhasil, silakan login.');
    }
}
