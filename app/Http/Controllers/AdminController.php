<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seminar;
use App\Models\Pendaftaran;
use App\Models\Peserta;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // =========================================================================
    // 1. DASHBOARD & AUTH
    // =========================================================================

    public function dashboard()
    {
        $today = now()->format('Y-m-d');

        // 1. STATISTIK UTAMA
        $stats = [
            'total_seminar' => Seminar::count(),
            'seminar_aktif' => Seminar::where('tgl_seminar', '>=', $today)->count(),
            'total_pendaftar' => Pendaftaran::count(),
            'peserta_hadir' => Pendaftaran::where('status_pendaftaran', 'Hadir')->count(),
            'total_poin' => Pendaftaran::where('status_pendaftaran', 'Hadir')->sum('poin_perolehan'),
        ];

        $stats['persen_hadir'] = $stats['total_pendaftar'] > 0
            ? round(($stats['peserta_hadir'] / $stats['total_pendaftar']) * 100) : 0;

        // 2. DATA UNTUK GRAFIK KATEGORI (WAJIB ADA)
        // Mengelompokkan jumlah seminar berdasarkan kategori
        $chartKategori = Seminar::selectRaw('kategori_seminar, count(*) as total')
            ->groupBy('kategori_seminar')
            ->pluck('total', 'kategori_seminar');

        // 3. DATA UNTUK GRAFIK STATUS (WAJIB ADA)
        // Membandingkan seminar Aktif vs Selesai
        $seminarSelesai = $stats['total_seminar'] - $stats['seminar_aktif'];
        $chartStatus = [
            'Aktif' => $stats['seminar_aktif'],
            'Selesai' => $seminarSelesai
        ];

        // 4. TABEL LIST
        $upcoming = Seminar::withCount('pendaftarans')
            ->where('tgl_seminar', '>=', $today)
            ->orderBy('tgl_seminar', 'asc')
            ->take(3)->get();

        $popular = Seminar::withCount('pendaftarans')
            ->orderBy('pendaftarans_count', 'desc')
            ->take(5)->get();

        // PENTING: Jangan lupa mengirim $chartKategori dan $chartStatus ke view
        return view('admin.dashboard', compact('stats', 'upcoming', 'popular', 'chartKategori', 'chartStatus'));
    }



    // =========================================================================
    // 2. MANAJEMEN SEMINAR (CRUD)
    // =========================================================================

    // Tampilkan Daftar Seminar
    public function indexSeminar()
    {
        $seminars = Seminar::withCount('pendaftarans')->orderBy('created_at', 'desc')->get();
        return view('admin.seminar', compact('seminars'));
    }

    // Simpan Seminar Baru (CREATE)
    public function storeSeminar(Request $request)
    {
        $request->validate([
            'nama_seminar' => 'required|string|max:100',
            'penyelenggara' => 'required|string|max:100',
            'tgl_dibuka' => 'required|date',
            'tgl_ditutup' => 'required|date|after_or_equal:tgl_dibuka',
            'tgl_seminar' => 'required|date|after_or_equal:tgl_ditutup',
            'lokasi' => 'required',
            'kategori_seminar' => 'required|max:20',
            'poin_seminar' => 'required|integer',
            'kapasitas' => 'required|integer',
        ]);

        try {
            DB::transaction(function () use ($request) {
                // Generate Kode Unik: "SEM-" + 10 Karakter Random
                $kode = 'SEM-' . strtoupper(Str::random(10));

                Seminar::create([
                    'kode_seminar' => $kode,
                    'nama_seminar' => $request->nama_seminar,
                    'penyelenggara' => $request->penyelenggara,
                    'tgl_dibuka' => $request->tgl_dibuka,
                    'tgl_ditutup' => $request->tgl_ditutup,
                    'tgl_seminar' => $request->tgl_seminar,
                    'kapasitas' => $request->kapasitas,
                    'lokasi' => $request->lokasi,
                    'kategori_seminar' => $request->kategori_seminar,
                    'poin_seminar' => $request->poin_seminar,
                ]);
            });

            return redirect()->route('admin.seminar')->with('success', 'Seminar berhasil disimpan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage())->withInput();
        }
    }

    // Ambil Data untuk Modal Edit (AJAX READ)
    public function edit($kode_seminar)
    {
        $seminar = Seminar::where('kode_seminar', $kode_seminar)->firstOrFail();
        return response()->json($seminar);
    }

    // Update Data Seminar (UPDATE)
    public function update(Request $request, $kode_seminar)
    {
        $seminar = Seminar::where('kode_seminar', $kode_seminar)->firstOrFail();

        $request->validate([
            'nama_seminar' => 'required|string|max:100',
            'penyelenggara' => 'required|string|max:100',
            'tgl_dibuka' => 'required|date',
            'tgl_ditutup' => 'required|date',
            'tgl_seminar' => 'required|date',
            'lokasi' => 'required',
            'kategori_seminar' => 'required',
            'poin_seminar' => 'required|integer',
            'kapasitas' => 'required|integer'
        ]);

        $seminar->update($request->all());

        return redirect()->back()->with('success', 'Data seminar berhasil diperbarui!');
    }

    // Hapus Seminar (DELETE)
    public function destroy($kode_seminar)
    {
        $seminar = Seminar::where('kode_seminar', $kode_seminar)->firstOrFail();

        // Validasi Keamanan: Jangan hapus jika sudah ada pendaftar
        if ($seminar->pendaftarans()->count() > 0) {
            return redirect()->back()->with('error', 'Gagal hapus! Seminar ini sudah memiliki pendaftar.');
        }

        $seminar->delete();

        return redirect()->back()->with('success', 'Seminar berhasil dihapus.');
    }

    // Ambil Data Pendaftar untuk Modal Detail (AJAX READ)
    public function getPendaftar($kode_seminar) // FIXED: Rename variable for clarity
    {
        // Cari seminar berdasarkan ID uniknya (kode_seminar)
        // Jika parameter di Route {id} mengirim kode_seminar, gunakan where('kode_seminar', $id)
        // Jika mengirim ID angka, gunakan findOrFail($id)
        // Sesuai perbaikan sebelumnya, kita asumsikan ID di sini adalah kode_seminar

        $seminar = Seminar::with(['pendaftarans.peserta'])
            ->where('kode_seminar', $kode_seminar)
            ->firstOrFail();

        $total = $seminar->pendaftarans->count();

        $stats = [
            'total' => $total,
            'tersedia' => $seminar->kapasitas - $total,
            'persen' => $seminar->kapasitas > 0 ? round(($total / $seminar->kapasitas) * 100) : 0
        ];

        return response()->json([
            'seminar' => $seminar, // Data Seminar & Pendaftarnya
            'stats' => $stats    // Statistik tambahan
        ]);
    }

    // =========================================================================
    // 3. ABSENSI & CHECK-IN
    // =========================================================================

    public function absensi()
    {
        $today = now()->format('Y-m-d');

        // Hanya tampilkan seminar HARI INI di dropdown absensi
        $seminars = \App\Models\Seminar::whereDate('tgl_seminar', $today)
            ->orderBy('nama_seminar', 'asc')
            ->get();

        return view('admin.absensi', compact('seminars'));
    }

    public function checkIn(Request $request)
    {
        $request->validate(['kode_pendaftaran' => 'required']);

        $pendaftaran = \App\Models\Pendaftaran::with(['seminar', 'peserta'])
            ->where('kode_pendaftaran', $request->kode_pendaftaran)
            ->first();

        if ($pendaftaran) {
            $today = now()->format('Y-m-d');
            $tglSeminar = $pendaftaran->seminar->tgl_seminar;

            // Validasi: Belum Jadwalnya
            if ($today < $tglSeminar) {
                return back()->with('error', 'Gagal! Seminar belum dimulai. Jadwal: ' . \Carbon\Carbon::parse($tglSeminar)->translatedFormat('d F Y'));
            }

            // Validasi: Sudah Lewat (Mengaktifkan validasi H+1 tidak bisa absen)
            if ($today > $tglSeminar) {
                return back()->with('error', 'Gagal! Tanggal seminar sudah terlewat. Absensi ditutup.');
            }

            // Validasi: Sudah Absen
            if ($pendaftaran->status_pendaftaran == 'Hadir') {
                return back()->with('error', 'Peserta ini sudah melakukan absensi sebelumnya.');
            }

            // Proses Check-in
            $pendaftaran->update([
                'status_pendaftaran' => 'Hadir',
                'poin_perolehan' => $pendaftaran->seminar->poin_seminar
            ]);

            return back()->with('success', 'Berhasil! Peserta ' . $pendaftaran->peserta->nama_peserta . ' telah hadir.');
        }

        return back()->with('error', 'Data pendaftaran tidak ditemukan/Kode salah.');
    }
    // =========================================================================
    // 4. SERTIFIKAT
    // =========================================================================
    public function sertifikat()
    {
        // Ambil data pendaftaran yang statusnya 'Hadir'
        $pendaftarans = Pendaftaran::with(['peserta', 'seminar'])
            ->where('status_pendaftaran', 'Hadir')
            ->orderBy('tanggal_pendaftaran', 'desc')
            ->get();

        return view('admin.sertifikat', compact('pendaftarans'));
    }
}