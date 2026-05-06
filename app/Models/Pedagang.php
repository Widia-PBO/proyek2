<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Kunci utama untuk login
use Illuminate\Notifications\Notifiable;

class Pedagang extends Authenticatable 
{
    use HasFactory, Notifiable;

    // Nama tabel di database
    protected $table = 'pedagangs';

    /**
     * Kolom yang boleh diisi secara massal.
     * kordinasi dengan migration: kios_id digunakan untuk relasi ke data fisik kios[cite: 14].
     */
    protected $fillable = [
        'kios_id', 
        'username', 
        'password', 
        'nama_pemilik'
    ];

    /**
     * Kolom yang harus disembunyikan saat data dipanggil (keamanan).
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // =======================================================
    // RELASI UTAMA
    // =======================================================

    /**
     * Hubungan ke data Kios.
     * Karena tabel pedagangs memiliki 'kios_id', maka relasinya adalah belongsTo[cite: 14].
     */
    public function kios() 
    { 
        return $this->belongsTo(Kios::class, 'kios_id'); 
    }

    /**
     * Relasi ke data Tagihan (Opsional sesuai perencanaan).
     */
    public function tagihans() 
    { 
        return $this->hasMany(Tagihan::class, 'pedagang_id', 'id'); 
    }
}