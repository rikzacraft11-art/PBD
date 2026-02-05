<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peserta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegistration()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'nim_peserta' => 'required|unique:peserta,nim_peserta|max:8',
            'nama_peserta' => 'required|max:30',
            'email' => 'required|email|max:50',
            'password' => 'required|min:6',
            'jurusan' => 'required',
            'angkatan' => 'required|max:4',
            'alamat' => 'required'
        ]);

        try {
            // 2. Simpan ke Database dengan Transaction
            \Illuminate\Support\Facades\DB::transaction(function () use ($request) {
                Peserta::create([
                    'nim_peserta' => $request->nim_peserta,
                    'nama_peserta' => $request->nama_peserta,
                    'email' => $request->email,
                    'jurusan' => $request->jurusan,
                    'angkatan' => $request->angkatan,
                    'alamat' => $request->alamat,
                    'password' => Hash::make($request->password),
                ]);
            });

            // 3. REDIRECT ke Login
            return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login dengan akun Anda.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage())->withInput();
        }
    }

    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'nim' => 'required',
            'password' => 'required'
        ]);

        // Cari peserta berdasarkan NIM
        $peserta = Peserta::where('nim_peserta', $request->nim)->first();

        // Cek kecocokan password
        if ($peserta && Hash::check($request->password, $peserta->password)) {
            Auth::login($peserta);

            // Redirect ke Dashboard setelah login manual berhasil
            return redirect()->intended(route('portal.dashboard'));
        }

        return back()->with('error', 'NIM atau Password salah.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}