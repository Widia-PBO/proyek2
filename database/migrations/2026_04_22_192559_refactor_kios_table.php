<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('kios', function (Blueprint $table) {
            $table->foreignId('pedagang_id')->nullable()->constrained('pedagangs')->onDelete('cascade')->after('id');
            $table->dropColumn(['nama_pemilik', 'username', 'password']);
        });
    }

    public function down(): void
    {
        Schema::table('kios', function (Blueprint $table) {
            $table->dropForeign(['pedagang_id']);
            $table->dropColumn('pedagang_id');
            $table->string('nama_pemilik')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
        });
    }
};