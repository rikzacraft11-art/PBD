<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SeminarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
    \App\Models\Seminar::create([
        'kode_seminar' => 'SEM001',
        'nama_seminar' => 'International Conference on AI 2026',
        'penyelenggara' => 'IEEE Computer Society',
        'tgl_dibuka' => '2026-01-01',
        'tgl_ditutup' => '2026-02-10',
        'tgl_seminar' => '2026-02-15',
        'kapasitas' => 500,
        'lokasi' => 'Jakarta Convention Center',
        'kategori_seminar' => 'Internasional', // Akan berwarna Ungu
        'poin_seminar' => 10 // Poin kategori Internasional [cite: 36]
    ]);
    }
}
