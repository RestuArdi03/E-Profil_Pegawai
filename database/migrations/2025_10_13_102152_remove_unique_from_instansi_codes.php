<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('instansi', function (Blueprint $table) {
            // Cek apakah index 'kd_instansi' ada sebelum dihapus
            // Nama index default Laravel biasanya [table]_[column]_unique.
            // Kita coba nama yang paling umum:
            
            // 1. Drop index 'kd_instansi'
            if (Schema::getConnection()->getDoctrineSchemaManager()->listTableDetails('instansi')->hasIndex('instansi_kd_instansi_unique')) {
                $table->dropUnique(['kd_instansi']);
            }
            
            // 2. Drop index 'kode'
            if (Schema::getConnection()->getDoctrineSchemaManager()->listTableDetails('instansi')->hasIndex('instansi_kode_unique')) {
                $table->dropUnique(['kode']); 
            }
        });
    }

    public function down(): void
    {
        // ... (biarkan method down tidak diubah) ...
    }
};