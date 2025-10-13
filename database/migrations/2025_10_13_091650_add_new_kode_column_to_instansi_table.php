<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('instansi', function (Blueprint $table) {
            // Kolom 'kode' baru
            $table->string('kode', 20)->unique()->nullable()->after('kd_instansi'); 
            // Saya letakkan setelah kd_instansi agar urutan di DB rapi.
        });
    }

    public function down(): void
    {
        Schema::table('instansi', function (Blueprint $table) {
            // Hapus kolom 'kode' jika rollback
            $table->dropColumn('kode');
        });
    }
};