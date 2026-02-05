<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('peserta', function (Blueprint $table) {
            $table->string('nim_peserta', 8)->primary(); // [cite: 91, 130]
            $table->string('nama_peserta', 30); // [cite: 92, 131]
            $table->text('alamat'); // [cite: 93, 132]
            $table->string('email', 50); // [cite: 94, 133]
            $table->string('angkatan', 4); // [cite: 101, 134]
            $table->string('jurusan', 25); // [cite: 102, 135]
            $table->string('password'); // [cite: 103]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peserta');
    }
};
