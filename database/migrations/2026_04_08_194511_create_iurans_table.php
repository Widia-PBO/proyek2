<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('iurans', function (Blueprint $table) {
        $table->id();
        
        // Relasi ke tabel Kios
        $table->foreignId('kios_id')->constrained('kios')->onDelete('cascade');
        
        // Relasi ke tabel Petugas
        $table->foreignId('petugas_id')->nullable()->constrained('petugas')->onDelete('set null');
        
        $table->integer('nominal');
        $table->enum('metode', ['Tunai', 'Transfer']);
        $table->date('tgl_bayar');
        $table->enum('status', ['Lunas', 'Pending'])->default('Lunas');
        $table->timestamps();
    });
}       

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iurans');
    }
};
