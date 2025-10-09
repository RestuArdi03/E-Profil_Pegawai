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
        Schema::table('instansi', function (Blueprint $table) {
            // Ganti 'nama_kolom_lama' dengan nama kolom yang saat ini ada di database,
            // dan ganti 'kd_instansi' dengan nama kolom yang Anda inginkan (misalnya kd_instansi)
            $table->renameColumn('kode_instansi', 'kd_instansi'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('instansi', function (Blueprint $table) {
            // Jika rollback, kembalikan namanya
            $table->renameColumn('kd_instansi', 'kode_instansi');
        });
    }
};