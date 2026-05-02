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
    Schema::table('pedagangs', function (Blueprint $table) {
        // Nambahin kolom biar tabel pedagang tahu dia milik kios yang mana
        $table->unsignedBigInteger('kios_id')->after('id')->nullable();
    });
}

public function down(): void
{
    Schema::table('pedagangs', function (Blueprint $table) {
        $table->dropColumn('kios_id');
    });
}
};
