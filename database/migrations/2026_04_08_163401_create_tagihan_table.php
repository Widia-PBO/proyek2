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
        Schema::create('tagihan', function (Blueprint $table) {
    $table->id('id_tagihan');
    $table->unsignedBigInteger('id_pedagang');
    $table->unsignedBigInteger('id_iuran');
    $table->date('periode'); // Bulan/Tahun tagihan
    $table->decimal('jumlah_tagihan', 10, 2);
    $table->string('status_tagihan'); // Belum Bayar atau Lunas
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihan');
    }
};
