<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    public function download($kode_pendaftaran)
    {
        // 1. Ambil Data Pendaftaran
        $pendaftaran = Pendaftaran::with(['peserta', 'seminar'])
            ->where('kode_pendaftaran', $kode_pendaftaran)
            ->firstOrFail();

        // 2. Validasi Hak Akses
        // Prioritas 1: Jika user adalah Admin, boleh akses semua
        if (Auth::guard('admin')->check()) {
            // Admin allowed - bypass ownership check
        }
        // Prioritas 2: Jika user adalah Peserta
        elseif (Auth::guard('web')->check()) {
            if ($pendaftaran->nim_peserta !== Auth::user()->nim_peserta) {
                abort(403, 'Unauthorized action.');
            }
        }
        // Jika tidak login sama sekali
        else {
            abort(403, 'Unauthorized action.');
        }

        // 3. Validasi Status "Hadir"
        if ($pendaftaran->status_pendaftaran !== 'Hadir') {
            return back()->with('error', 'Sertifikat hanya tersedia jika Anda telah menghadiri seminar.');
        }

        // 4. Generate PDF
        $pdf = Pdf::loadView('pdf.certificate', [
            'pendaftaran' => $pendaftaran,
            'peserta' => $pendaftaran->peserta,
            'seminar' => $pendaftaran->seminar
        ]);

        // Opsional: Set paper size landscape
        $pdf->setPaper('A4', 'landscape');

        // 5. Download / Stream
        return $pdf->download('Sertifikat-' . $pendaftaran->peserta->nama_peserta . '.pdf');
    }
}
