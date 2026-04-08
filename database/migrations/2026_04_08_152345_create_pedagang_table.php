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
        Schema::create('pedagang', function (Blueprint $table) {
    $table->id('id_pedagang');
    $table->string('nama_pedagang');
    $table->text('alamat');
    $table->string('no_hp');
    $table->unsignedBigInteger('id_kios'); // Foreign Key 
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedagang');
    }
};
