<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pedagangs', function (Blueprint $table) {
            $table->id(); 
            $table->string('nama_pemilik');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('whatsapp')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pedagangs');
    }
};