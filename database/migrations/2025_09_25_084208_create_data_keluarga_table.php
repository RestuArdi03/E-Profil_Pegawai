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
        Schema::create('data_keluarga', function (Blueprint $table) {
            $table->id();

            $table->string('nama');
            $table->string('nik');
            $table->string('tmpt_lahir');
            $table->date('tgl_lahir');
            $table->string('jenis_kelamin');
            $table->string('status_keluarga');
            $table->string('pendidikan');
            $table->string('pekerjaan');
            $table->string('nip');

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
        Schema::dropIfExists('data_keluarga');
    }
};
