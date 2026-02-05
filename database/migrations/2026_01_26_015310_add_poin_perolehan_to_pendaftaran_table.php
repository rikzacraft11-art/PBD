<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('pendaftaran', function (Blueprint $table) {
            // Menambahkan kolom untuk menyimpan poin setiap pendaftaran
            $table->integer('poin_perolehan')->default(0)->after('status_pendaftaran');
        });
    }

    public function down()
    {
        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->dropColumn('poin_perolehan');
        });
    }
};
