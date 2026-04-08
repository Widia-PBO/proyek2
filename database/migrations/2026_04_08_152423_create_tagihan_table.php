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
    $table->unsignedBigInteger('id_pedagang'); // Foreign Key 
    $table->unsignedBigInteger('id_iuran'); // Foreign Key 
    $table->date('periode');
    $table->decimal('jumlah_tagihan', 10, 2);
    $table->string('status_tagihan');
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
