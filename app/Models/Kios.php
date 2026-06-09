<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kios extends Model
{
    use HasFactory;

    /**
     * Properti fillable yang sudah disinkronkan dengan database admin & pedagang.
     * Mengubah 'nama_toko' menjadi 'nama_usaha' dan menambahkan 'nama_pedagang' 
     * agar terhindar dari Mass Assignment Protection.
     */
    protected $fillable = [
        'no_kios',
        'blok',
        'nama_usaha',     // DIPERBAIKI: Menyesuaikan kolom asli database kelola admin
        'nama_pedagang',  // DIPERBAIKI: Mengizinkan penyimpanan nama pemilik/pedagang kios
        'jenis_usaha',
        'status'
    ];

    public function pedagang()
    {
        return $this->hasOne(Pedagang::class, 'kios_id');
    }
}