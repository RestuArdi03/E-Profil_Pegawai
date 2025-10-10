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
        Schema::create('riwayat_jabatan', function (Blueprint $table) {
            $table->id();

            $table->string('jabatan');
            $table->date('tmt');
            $table->string('no_sk');
            $table->date('tgl_sk');
            $table->string('pejabat_penetap');
            $table->string('jenis_mutasi');
            $table->unsignedBigInteger('pegawai_id');
            $table->foreign('pegawai_id')->references('id')->on('pegawai')->onDelete('cascade');
            $table->unsignedBigInteger('jenis_jabatan_id');
            $table->foreign('jenis_jabatan_id')->references('id')->on('jenis_jabatan')->onDelete('cascade');
            $table->unsignedBigInteger('eselon_id');
            $table->foreign('eselon_id')->references('id')->on('eselon')->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_jabatan');
    }
};
