<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kios extends Model
{
    use HasFactory;

    /**
     * Kolom yang bisa diisi secara massal.
     * Kita hapus nama_pemilik, username, dan password karena 
     * data tersebut sudah resmi pindah ke model Pedagang.
     */
    protected $fillable = [
        'pedagang_id', // Kunci foreign key ke tabel pedagangs
        'no_kios',
        'nama_usaha',
        'jenis_usaha',
        'blok',
        'status',
    ];

    /**
     * Relasi: Satu Kios dimiliki oleh satu Pedagang (Many-to-One)
     * Ini adalah benang merah yang menghubungkan kios ke pemiliknya.
     */
    public function pedagang()
    {
        // pedagang_id adalah kolom di tabel kios, id adalah primary key di tabel pedagangs
        return $this->belongsTo(Pedagang::class, 'pedagang_id', 'id');
    }
}