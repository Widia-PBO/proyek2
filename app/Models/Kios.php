<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kios extends Model
{
    use HasFactory;

    // Hapus baris protected $primaryKey = 'id_kios'; jika sebelumnya ada

    // Izinkan semua kolom ini untuk diisi/diedit (Mencegah error Mass Assignment)
    protected $fillable = [
        'no_kios',
        'nama_usaha',
        'jenis_usaha',
        'nama_pemilik',
        'blok',
        'username',
        'password',
        'status',
    ];

    // Sembunyikan password
    protected $hidden = [
        'password',
    ];
}           