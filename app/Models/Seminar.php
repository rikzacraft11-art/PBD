<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seminar extends Model
{
    use HasFactory;

    // PENTING: Karena nama tabel di database Anda 'seminar' (bukan seminars)
    protected $table = 'seminar'; 
    
    // Setting Primary Key (Karena pakai String 'SEM-XXX')
    protected $primaryKey = 'kode_seminar';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kode_seminar', 
        'nama_seminar', 
        'penyelenggara', 
        'tgl_dibuka', 
        'tgl_ditutup',
        'tgl_seminar', 
        'lokasi', 
        'kapasitas', 
        'kategori_seminar', 
        'poin_seminar'
    ];

    // Relasi ke Pendaftaran
    public function pendaftarans()
    {
        return $this->hasMany(Pendaftaran::class, 'kode_seminar', 'kode_seminar');
    }
}