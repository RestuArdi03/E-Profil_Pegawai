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
        Schema::create('riwayat_diklat', function (Blueprint $table) {
            $table->id();
            
            $table->string('nm_diklat');
            $table->integer('jpl');
            $table->date('tgl_mulai');
            $table->date('tgl_selesai');
            $table->string('no_sertifikat');
            $table->date('tgl_sertifikat');
            $table->string('penyelenggara');
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
        Schema::dropIfExists('riwayat_diklat');
    }
};
