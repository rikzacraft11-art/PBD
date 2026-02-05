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
        Schema::create('pendaftaran', function (Blueprint $table) {
            $table->string('kode_pendaftaran', 30)->primary(); // [cite: 96, 152]
            $table->string('kode_seminar', 8); // [cite: 97, 153]
            $table->string('nim_peserta', 8); // [cite: 98, 154]
            $table->string('status_pendaftaran', 20)->default('Menunggu'); // [cite: 99, 155]
            $table->date('tanggal_pendaftaran'); // [cite: 100, 156]
            $table->foreign('kode_seminar')->references('kode_seminar')->on('seminar'); // [cite: 157]
            $table->foreign('nim_peserta')->references('nim_peserta')->on('peserta'); // [cite: 158]
        });

        Schema::create('absensi', function (Blueprint $table) {
            $table->string('kode_absensi', 8)->primary(); // [cite: 105, 161]
            $table->string('kode_pendaftaran', 8); // [cite: 106, 162]
            $table->date('tgl_absensi'); // [cite: 107, 163]
            $table->time('waktu_absensi'); // [cite: 108, 164]
            $table->string('status_kehadiran', 10); // [cite: 109, 165]
            $table->foreign('kode_pendaftaran')->references('kode_pendaftaran')->on('pendaftaran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran_absensi_tables');
    }
};
