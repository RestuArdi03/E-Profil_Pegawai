<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// Contoh yang BENAR di Migration Anda
    public function up()
{
    Schema::create('instansi', function (Blueprint $table) {
        $table->id(); // Biarkan ID unik (Primary Key) untuk keperluan internal database
        $table->string('nm_instansi');
        $table->string('kd_instansi')->unique();
        $table->text('alamat_instansi')->nullable();
        $table->string('telp_instansi', 30)->nullable();
        $table->string('fax_instansi', 30)->nullable();
        $table->integer('urutan_instansi')->default(99);

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instansi');
    }
};
