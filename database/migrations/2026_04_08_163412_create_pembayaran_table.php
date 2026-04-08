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
        Schema::create('pembayaran', function (Blueprint $table) {
    $table->id('id_pembayaran');
    $table->unsignedBigInteger('id_tagihan'); // Menunjuk ke Tagihan (Revisi!)
    $table->date('tanggal_bayar');
    $table->decimal('jumlah_bayar', 10, 2);
    $table->string('metode_pembayaran');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
