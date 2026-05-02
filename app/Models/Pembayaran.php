<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    // Izinkan semua kolom diisi secara massal
    protected $guarded = ['id'];

    // Relasi: Satu pembayaran ini milik satu Kios
    public function kios()
    {
        return $this->belongsTo(Kios::class, 'kios_id');
    }

    // Relasi: Satu pembayaran ini dicatat oleh satu Petugas
    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'petugas_id');
    }
}