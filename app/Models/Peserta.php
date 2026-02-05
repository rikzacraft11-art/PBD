<?php

namespace App\Models;

// WAJIB: Gunakan Authenticatable agar fitur login berfungsi
use Illuminate\Foundation\Auth\User as Authenticatable; 
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Peserta extends Authenticatable 
{
    use HasFactory, Notifiable;

    protected $table = 'peserta';
    
    // Beritahu Laravel bahwa Primary Key Anda adalah nim_peserta, bukan 'id'
    protected $primaryKey = 'nim_peserta'; 
    
    // Karena NIM adalah string dan bukan angka auto-increment
    public $incrementing = false; 
    protected $keyType = 'string';

    protected $fillable = [
        'nim_peserta', 
        'nama_peserta', 
        'email', 
        'password', 
        'jurusan', 
        'angkatan', 
        'alamat'
    ];

    // Keamanan agar password tidak ikut tampil saat data dipanggil
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Relasi ke Tabel Pendaftaran
     * Satu peserta bisa memiliki banyak pendaftaran seminar
     */
    public function pendaftarans()
    {
        // Parameter: Model tujuan, Foreign Key di tabel pendaftaran, Local Key di tabel peserta
        return $this->hasMany(Pendaftaran::class, 'nim_peserta', 'nim_peserta');
    }
}