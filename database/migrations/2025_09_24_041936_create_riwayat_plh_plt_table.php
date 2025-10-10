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
        Schema::create('riwayat_plh_plt', function (Blueprint $table) {
            $table->id();

            $table->string('no_sprint');
            $table->date('tgl_sprint');
            $table->date('tgl_mulai');
            $table->date('tgl_selesai');
            $table->string('jabatan_plh_plt');
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
        Schema::dropIfExists('riwayat_plh_plt');
    }
};
