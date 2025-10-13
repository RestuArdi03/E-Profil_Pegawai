<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('instansi', function (Blueprint $table) {
            // Tambahkan kolom kd_instansi
            $table->string('kd_instansi', 50)->nullable()->after('nm_instansi');
        });
    }

    public function down(): void
    {
        Schema::table('instansi', function (Blueprint $table) {
            $table->dropColumn('kd_instansi');
        });
    }
};