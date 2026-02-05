<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    // Menentukan nama tabel
    protected $table = 'pendaftaran';

    // Primary key tabel ini
    protected $primaryKey = 'kode_pendaftaran';
    
    // Nonaktifkan incrementing karena kode_pendaftaran adalah string
    public $incrementing = false;
    protected $keyType = 'string';

    /**
     * PERBAIKAN UTAMA:
     * Nonaktifkan timestamps otomatis karena tabel tidak memiliki kolom created_at/updated_at.
     * Ini akan mengatasi error "Unknown column 'updated_at'".
     */
    public $timestamps = false;

    // Kolom yang boleh diisi secara massal
    protected $fillable = [
        'kode_pendaftaran',
        'kode_seminar',
        'nim_peserta',
        'status_pendaftaran',
        'tanggal_pendaftaran',
        'poin_perolehan'
    ];

    /**
     * Relasi ke Model Peserta
     */
    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'nim_peserta', 'nim_peserta');
    }

    /**
     * Relasi ke Model Seminar
     */
    public function seminar()
    {
        return $this->belongsTo(Seminar::class, 'kode_seminar', 'kode_seminar');
    }

    /**
     * Relasi ke Model Absensi
     */
    public function absensi()
    {
        return $this->hasOne(Absensi::class, 'kode_pendaftaran', 'kode_pendaftaran');
    }
}