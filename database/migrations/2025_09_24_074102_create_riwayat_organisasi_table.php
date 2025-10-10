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
        Schema::create('riwayat_organisasi', function (Blueprint $table) {
            $table->id();

            $table->string('organisasi');
            $table->string('jabatan');
            $table->string('masa_jabatan');
            $table->string('no_sk');
            $table->date('tgl_sk');
            $table->string('pejabat_penetap');
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
        Schema::dropIfExists('riwayat_organisasi');
    }
};
