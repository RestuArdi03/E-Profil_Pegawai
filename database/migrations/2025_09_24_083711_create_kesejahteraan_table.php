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
        Schema::create('kesejahteraan', function (Blueprint $table) {
            $table->id();

            $table->string('npwp');
            $table->string('no_bpjs');
            $table->string('no_taspen');
            $table->string('kepemilikan_rumah');
            $table->string('kartu_pegawai_elektronik');

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
        Schema::dropIfExists('kesejahteraan');
    }
};
