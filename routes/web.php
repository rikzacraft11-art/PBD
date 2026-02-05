<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController, PesertaController, AdminAuthController, AdminController};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- 1. RUTE GUEST (Pengunjung / Belum Login) ---
Route::middleware(['guest'])->group(function () {
    // Login & Register Peserta
    Route::get('/', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegistration'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');

    // Login Admin
    Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/admin/login', [AdminAuthController::class, 'login']);
});

// --- 2. RUTE PESERTA (Login sebagai User/Mahasiswa) ---
Route::middleware(['auth'])->group(function () {

    // DASHBOARD (Halaman Utama setelah Login)
    Route::get('/portal', [PesertaController::class, 'dashboard'])->name('portal.dashboard');

    // CARI SEMINAR (Halaman Daftar Seminar)
    Route::get('/portal/seminar', [PesertaController::class, 'index'])->name('portal.index');

    // Proses Pendaftaran Seminar
    Route::post('/daftar-seminar/proses', [PesertaController::class, 'daftar'])->name('pendaftaran.store');

    // Download Sertifikat
    Route::get('/sertifikat/{kode_pendaftaran}/download', [App\Http\Controllers\CertificateController::class, 'download'])->name('sertifikat.download');

    // Logout Peserta
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// --- 3. RUTE ADMIN (Login sebagai Admin) ---
Route::middleware(['auth:admin'])->prefix('admin')->group(function () {

    // Dashboard Admin
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Logout Admin
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    // --- MANAJEMEN SEMINAR ---

    // 1. Tampilkan & Simpan Baru
    Route::get('/seminar', [AdminController::class, 'indexSeminar'])->name('admin.seminar');
    Route::post('/seminar/store', [AdminController::class, 'storeSeminar'])->name('admin.seminar.store');

    // 2. Edit, Update, & Hapus (Menggunakan kode_seminar)
    // Rute ini WAJIB ada agar tombol Pensil dan Sampah berfungsi
    Route::get('/seminar/{kode_seminar}/edit', [AdminController::class, 'edit'])->name('admin.seminar.edit');
    Route::put('/seminar/{kode_seminar}', [AdminController::class, 'update'])->name('admin.seminar.update');
    Route::delete('/seminar/{kode_seminar}', [AdminController::class, 'destroy'])->name('admin.seminar.destroy');

    // 3. AJAX: Detail Pendaftar (Pop-up Tabel Peserta)
    Route::get('/seminar/{id}/pendaftar', [AdminController::class, 'getPendaftar'])->name('admin.seminar.pendaftar');

    // --- ABSENSI & CHECK-IN ---
    Route::get('/absensi', [AdminController::class, 'absensi'])->name('admin.absensi');
    Route::post('/absensi/checkin', [AdminController::class, 'checkIn'])->name('admin.absensi.checkin');

    Route::get('/sertifikat', [AdminController::class, 'sertifikat'])->name('admin.sertifikat');
    // Fix: Rute khusus admin untuk download sertifikat agar tidak redirect ke login peserta
    Route::get('/sertifikat/{kode_pendaftaran}/download', [App\Http\Controllers\CertificateController::class, 'download'])->name('admin.sertifikat.download');
});