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
        Schema::create('riwayat_penghargaan', function (Blueprint $table) {
            $table->id();

            $table->string('nm_penghargaan');
            $table->string('no_urut');
            $table->string('no_sertifikat');
            $table->date('tgl_sertifikat');
            $table->string('pejabat_penetap');
            $table->string('link');
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
        Schema::dropIfExists('riwayat_penghargaan');
    }
};
