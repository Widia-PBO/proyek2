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
    Schema::create('petugas', function (Blueprint $table) {
        $table->id();
        $table->string('id_petugas')->unique();
        $table->string('nama_petugas');
        $table->string('username')->unique();
        $table->string('password'); // <-- INI TAMBAHANNYA
        $table->string('wilayah_tugas');
        $table->string('kontak');
        $table->enum('status', ['Aktif', 'Non Aktif'])->default('Aktif');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('petugas');
    }
};
