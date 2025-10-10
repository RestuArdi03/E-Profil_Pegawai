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
        Schema::create('riwayat_kgb', function (Blueprint $table) {
            $table->id();

            $table->string('pejabat_penetap');
            $table->string('no_sk');
            $table->date('tgl_sk');
            $table->date('tgl_tmt');
            $table->decimal('jml_gaji', 15, 2);
            $table->string('ket')->nullable();
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
        Schema::dropIfExists('riwayat_kgb');
    }
};
