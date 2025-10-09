<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('instansi', function (Blueprint $table) {
            // Kolom baru
            $table->text('alamat_instansi')->nullable();
            $table->string('telp_instansi', 30)->nullable();
            $table->string('fax_instansi', 30)->nullable();
            $table->integer('urutan_instansi')->default(99); // Beri nilai default
        });
    }

    public function down(): void
    {
        Schema::table('instansi', function (Blueprint $table) {
            // Hapus kolom jika rollback
            $table->dropColumn(['alamat_instansi', 'telp_instansi', 'fax_instansi', 'urutan_instansi']);
        });
    }
};