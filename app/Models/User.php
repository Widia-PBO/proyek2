<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable 
{
    use HasFactory, Notifiable;

    // KITA TIDAK PERLU DEKLARASI PRIMARY KEY LAGI KARENA LARAVEL OTOMATIS BACA 'id'
    
    // UPDATE FILLABLE AGAR SEEDER BISA MASUK SEMUA
    protected $fillable = [
        'name',
        'username',
        'password',
        'role',
        'nip',
        'email',
        'whatsapp',
        'jabatan',
        'wilayah'
    ];

    // Sembunyikan password agar lebih aman jika data dipanggil
    protected $hidden = [
        'password',
        'remember_token',
    ];
}   