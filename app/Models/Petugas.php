<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // Penting![cite: 16]
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Petugas extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'petugas';
    protected $fillable = ['id_petugas', 'nama_petugas', 'username', 'password', 'wilayah_tugas', 'kontak', 'status'];
    protected $hidden = ['password'];

    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class, 'petugas_id');
    }
}