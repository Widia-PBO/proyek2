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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke Kios (Siapa yang bayar)
            $table->foreignId('kios_id')->constrained('kios')->onDelete('cascade');
            
            // Relasi ke Petugas (Siapa yang nagih) - nullable karena bisa jadi bayar via transfer/sistem
            $table->foreignId('petugas_id')->nullable()->constrained('petugas')->onDelete('set null');
            
            // Detail Pembayaran Harian
            $table->date('tanggal_bayar'); // Tanggal tagihan (misal: bayar untuk tanggal 26 Maret)
            $table->decimal('total_bayar', 10, 2)->default(10000); // Sesuai Biaya Retribusi Harian
            $table->string('metode_pembayaran')->default('Tunai'); // Tunai, Transfer Mandiri, QRIS, dll
            $table->string('status')->default('Lunas'); // Lunas, Belum Lunas
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // REVISI: Menambahkan huruf 's' agar sama dengan fungsi up()
        Schema::dropIfExists('pembayarans');
    }
};  