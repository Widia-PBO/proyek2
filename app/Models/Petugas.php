<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    use HasFactory;

    // Hapus baris protected $primaryKey = 'id_petugas'; jika sebelumnya ada

    protected $fillable = [
        'id_petugas',
        'nama_petugas',
        'username',
        'password',
        'wilayah_tugas',
        'kontak',
        'status',
    ];

    protected $hidden = [
        'password',
    ];
}