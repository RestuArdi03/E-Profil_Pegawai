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
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id();

            $table->string('nama');
            $table->string('nip')->unique();
            $table->string('no_kk');
            $table->string('tpt_lahir');
            $table->date('tgl_lahir');
            $table->string('no_karpeg')->unique();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->unsignedBigInteger('agama_id');
            $table->foreign('agama_id')->references('id')->on('agama')->onDelete('restrict');
            $table->string('golongan_darah')->nullable();
            $table->enum('status_kawin', ['Kawin', 'Belum Kawin', 'Cerai']);
            $table->date('tgl_kawin')->nullable();
            $table->string('no_karis_karsu')->unique();
            $table->string('almt_rumah');
            $table->date('tmt_pensiun');
            $table->unsignedBigInteger('instansi_id');
            $table->foreign('instansi_id')->references('id')->on('instansi')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};
