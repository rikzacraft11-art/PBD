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
        Schema::create('seminar', function (Blueprint $table) {
            $table->string('kode_seminar', 20)->primary();
            $table->string('nama_seminar', 100);
            $table->string('penyelenggara', 100);

            $table->date('tgl_dibuka');
            $table->date('tgl_ditutup');
            $table->date('tgl_seminar');

            $table->unsignedInteger('kapasitas');
            $table->text('lokasi');
            $table->string('kategori_seminar', 20);
            $table->unsignedInteger('poin_seminar');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seminar');
    }
};
