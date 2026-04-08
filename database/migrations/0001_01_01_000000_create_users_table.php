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
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('name'); 
        $table->string('username')->unique(); 
        $table->string('password');
        $table->string('role')->default('admin'); 
        
        // --- TAMBAHAN UNTUK PROFIL SUPER ADMIN ---
        $table->string('nip')->nullable();
        $table->string('email')->unique()->nullable();
        $table->string('whatsapp')->nullable();
        $table->string('jabatan')->default('Super Admin');
        $table->string('wilayah')->default('Seluruh Pasar');
        // -----------------------------------------
        
        $table->rememberToken();
        $table->timestamps();
    });

    // ... (biarkan kode password_reset_tokens dan sessions di bawahnya apa adanya)
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
