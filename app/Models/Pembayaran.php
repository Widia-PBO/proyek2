<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    // Relasi ke petugas yang menginput tagihan iuran
    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'petugas_id');
    }

    public function kios()
    {
        return $this->belongsTo(Kios::class, 'kios_id');
    }
}