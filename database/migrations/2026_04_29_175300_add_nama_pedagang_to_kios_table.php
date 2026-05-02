<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kios', function (Blueprint $table) {
            // Kita tambahkan kolom nama_pedagang setelah nama_usaha
            $table->string('nama_pedagang')->after('nama_usaha')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('kios', function (Blueprint $table) {
            $table->dropColumn('nama_pedagang');
        });
    }
};