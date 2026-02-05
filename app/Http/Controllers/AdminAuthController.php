<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    /**
     * Menampilkan View Perisai Ungu
     */
    public function showLogin() {
        return view('admin.login');
    }

    /**
     * Proses Login Khusus Admin
     */
    public function login(Request $request) {
        // 1. Validasi Input
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        /**
         * 2. Attempt Login menggunakan Guard 'admin'
         * Ini memisahkan sesi Admin dari Peserta agar tidak bentrok
         */
        if (Auth::guard('admin')->attempt($credentials)) {
            // Regenerasi session untuk keamanan (mencegah 419 error di masa depan)
            $request->session()->regenerate();

            // REDIRECT LANGSUNG: Pastikan ke admin.dashboard
            return redirect()->intended(route('admin.dashboard'));
        }

        // 3. Jika gagal, kembali dengan pesan error
        return back()->with('error', 'Username atau Password admin salah.');
    }

    /**
     * Proses Logout Khusus Admin
     */
    public function logout(Request $request)
    {
        // Logout hanya untuk guard admin saja
        Auth::guard('admin')->logout();

        // Bersihkan session agar benar-benar bersih
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}