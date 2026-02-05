<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Peserta;

class PesertaSeeder extends Seeder
{
    public function run()
    {
        Peserta::create([
            'nim_peserta' => '10123010', // Sesuai NIM di dokumen [cite: 10]
            'nama_peserta' => 'Reyhan Tahira', // Sesuai nama di dokumen [cite: 9]
            'alamat' => 'Bandung',
            'email' => 'reyhan@email.com',
            'angkatan' => '2023',
            'jurusan' => 'Teknik Informatika', // [cite: 17]
            'password' => bcrypt('password123') 
        ]);
    }
}