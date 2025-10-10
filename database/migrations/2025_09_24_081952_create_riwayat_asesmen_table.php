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
        Schema::create('riwayat_asesmen', function (Blueprint $table) {
            $table->id();

            $table->date('tgl_asesmen');
            $table->string('tujuan_asesmen');
            $table->string('metode_asesmen');
            $table->string('gambaran_potensi');
            $table->string('gambaran_kompetensi');
            $table->string('saran_pengembangan');

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
        Schema::dropIfExists('riwayat_asesmen');
    }
};
