<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        \App\Models\Admin::create([
            'username' => 'admin_seminar',
            'nama_admin' => 'Administrator',
            'password' => bcrypt('123456'), // Password yang sudah disediakan
        ]);
    }
}
