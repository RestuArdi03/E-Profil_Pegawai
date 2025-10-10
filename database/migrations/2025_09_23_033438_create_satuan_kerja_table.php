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
        Schema::create('satuan_kerja', function (Blueprint $table) {
            $table->id();

            $table->string('nm_satuan_kerja');
            $table->unsignedBigInteger('unit_kerja_id');
            $table->foreign('unit_kerja_id')->references('id')->on('unit_kerja')->onDelete('cascade');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('satuan_kerja');
    }
};
