<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kios extends Model
{
    use HasFactory;

    // Tambahkan baris ini agar kolom bisa diupdate
    protected $fillable = [
        'nama_toko',
        'jenis_usaha',
        'no_kios',
        'blok',
        'status'
    ];

    public function pedagang()
    {
        return $this->hasOne(Pedagang::class, 'kios_id');
    }
}   