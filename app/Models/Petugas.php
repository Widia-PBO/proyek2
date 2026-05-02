<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // <-- Ini Kuncinya

class Petugas extends Authenticatable
{
    use HasFactory;

    // Pastikan fillable sesuai dengan kolom di database kamu
    protected $fillable = [
        'id_petugas', 'nama_petugas', 'username', 'password', 'wilayah_tugas', 'kontak', 'status'
    ];

    protected $hidden = [
        'password',
    ];
    // Relasi: Satu Petugas bisa mencatat banyak data Pembayaran
    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class, 'petugas_id');
    }
}   
