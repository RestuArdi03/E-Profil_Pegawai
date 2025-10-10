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
        Schema::create('nilai_prestasi_kerja', function (Blueprint $table) {
            $table->id();

            $table->string('tahun', 4); 
            $table->decimal('skp');
            $table->decimal('nilai_perilaku_kerja');
            $table->decimal('nilai_prestasi_kerja');
            $table->string('klasifikasi_nilai'); 
            $table->string('pejabat_penilai');

            $table->unsignedBigInteger('pegawai_id');
            $table->foreign('pegawai_id')->references('id')->on('pegawai')->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_prestasi_kerja');
    }
};
