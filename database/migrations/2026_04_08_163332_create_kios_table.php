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
    Schema::create('kios', function (Blueprint $table) {
        $table->id();
        $table->string('no_kios')->unique();
        $table->string('nama_usaha');
        $table->string('jenis_usaha');
        $table->string('nama_pemilik');
        $table->string('blok');
        $table->string('username')->unique();
        $table->string('password'); // <-- INI TAMBAHANNYA
        $table->enum('status', ['Aktif', 'Non Aktif'])->default('Aktif');
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
