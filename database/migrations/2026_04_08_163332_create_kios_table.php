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
        Schema::create('kios', function (Blueprint $table) {
    $table->id('id_kios');
    $table->string('nomor_kios');
    $table->string('lokasi');
    $table->string('status_kios'); // Tersedia atau Terisi
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kios');
    }
};
