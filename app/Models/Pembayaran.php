<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    // Membuka kunci kolom agar bisa diisi secara otomatis (Mass Assignment)
    protected $fillable = [
        'kios_id',
        'petugas_id',
        'tanggal_bayar',
        'total_bayar',
        'metode_pembayaran',
        'status'
    ];

    // Relasi ke petugas yang menginput tagihan iuran
    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'petugas_id');
    }

    // Relasi ke kios yang membayar iuran
    public function kios()
    {
        return $this->belongsTo(Kios::class, 'kios_id');
    }
}