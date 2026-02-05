<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seminar;
use App\Models\Peserta;
use App\Models\Pendaftaran;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PesertaController extends Controller
{
    /**
     * Menampilkan Tab "Daftar Seminar" 
     * Memperbaiki error created_at dan menangani filter aktif/selesai
     */
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'Semua');
        $today = now()->format('Y-m-d');
        $peserta = Auth::user();

        $query = Seminar::withCount('pendaftarans')
            ->with(['pendaftarans' => function($q) use ($peserta) {
                $q->where('nim_peserta', $peserta->nim_peserta);
            }]);

        if ($filter == 'Aktif') {
            $query->where('tgl_seminar', '>=', $today);
        } elseif ($filter == 'Selesai') {
            $query->where('tgl_seminar', '<', $today);
        }

        // FIX ERROR image_7e7475: Gunakan orderBy manual karena tabel tidak memiliki created_at
        $seminars = $query->orderBy('tgl_seminar', 'asc')->get();

        return view('peserta.index', compact('seminars', 'filter'));
    }

    /**
     * Menampilkan Tab "Dashboard Saya" 
     */
    public function dashboard()
    {
        $peserta = Auth::user();
        
        $dataPeserta = Peserta::with(['pendaftarans.seminar'])
            ->where('nim_peserta', $peserta->nim_peserta)
            ->first();

        $totalPoin = $dataPeserta->pendaftarans
            ->where('status_pendaftaran', 'Hadir')
            ->sum('poin_perolehan');

        $seminarBerhasil = $dataPeserta->pendaftarans
            ->where('status_pendaftaran', 'Hadir')
            ->count();

        // Diubah: Menghitung yang sudah Disetujui (Otomatis) tapi belum Hadir
        $tidakHadir = $dataPeserta->pendaftarans
            ->where('status_pendaftaran', 'Disetujui')
            ->count();

        $riwayat = $dataPeserta->pendaftarans->where('status_pendaftaran', 'Hadir');

        return view('peserta.dashboard', [
            'peserta' => $peserta,
            'totalPoin' => $totalPoin,
            'seminarBerhasil' => $seminarBerhasil,
            'tidakHadir' => $tidakHadir,
            'riwayat' => $riwayat,
            'totalTerdaftar' => $dataPeserta->pendaftarans->count()
        ]);
    }

    /**
     * Logika Pendaftaran Seminar - OTOMATIS APPROVAL
     */
    public function daftar(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'kode_seminar' => 'required|exists:seminar,kode_seminar'
        ]);

        // 2. Ambil Data Seminar
        $seminar = Seminar::where('kode_seminar', $request->kode_seminar)->firstOrFail();
        
        // 3. Ambil Data Peserta Login
        $user = Auth::user();

        // -----------------------------------------------------------
        // BAGIAN 1: CEK TANGGAL (PENCEGAHAN)
        // -----------------------------------------------------------
        $hariIni = Carbon::now()->format('Y-m-d'); // Tanggal server saat ini

        // Cek apakah pendaftaran belum dibuka
        if ($hariIni < $seminar->tgl_dibuka) {
            return back()->with('error', 'Pendaftaran belum dibuka! Harap tunggu hingga tanggal ' . Carbon::parse($seminar->tgl_dibuka)->translatedFormat('d F Y'));
        }

        // Cek apakah pendaftaran SUDAH DITUTUP (Masalah Anda disini)
        if ($hariIni > $seminar->tgl_ditutup) {
            return back()->with('error', 'Pendaftaran sudah ditutup pada tanggal ' . Carbon::parse($seminar->tgl_ditutup)->translatedFormat('d F Y'));
        }

        // -----------------------------------------------------------
        // BAGIAN 2: CEK KUOTA
        // -----------------------------------------------------------
        $jumlahPendaftar = Pendaftaran::where('kode_seminar', $request->kode_seminar)->count();
        if ($jumlahPendaftar >= $seminar->kapasitas) {
            return back()->with('error', 'Mohon maaf, kuota peserta sudah penuh.');
        }

        // -----------------------------------------------------------
        // BAGIAN 3: CEK DUPLIKASI (Agar tidak daftar 2x)
        // -----------------------------------------------------------
        $cekDuplikat = Pendaftaran::where('kode_seminar', $request->kode_seminar)
                        ->where('nim_peserta', $user->nim_peserta)
                        ->exists();
        
        if ($cekDuplikat) {
            return back()->with('error', 'Anda sudah terdaftar di seminar ini.');
        }

        // -----------------------------------------------------------
        // BAGIAN 4: SIMPAN DATA
        // -----------------------------------------------------------
        Pendaftaran::create([
            'kode_pendaftaran'   => 'REG-' . time() . rand(100, 999),
            'kode_seminar'       => $request->kode_seminar,
            'nim_peserta'        => $user->nim_peserta,
            'tanggal_pendaftaran'=> now(),
            'status_pendaftaran' => 'Terdaftar', // Default status
            'poin_perolehan'     => 0 // Poin baru didapat saat hadir
        ]);

        return back()->with('success', 'Berhasil mendaftar! Silakan cek Dashboard Saya.');
    }
}