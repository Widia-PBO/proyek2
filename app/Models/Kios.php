<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kios extends Model
{
    use HasFactory;

    // Nama tabel harus sama dengan yang digunakan di sisi Admin
    protected $table = 'kios'; 

protected $fillable = ['no_kios', 'blok', 'nama_usaha', 'nama_pedagang', 'jenis_usaha', 'status'];

    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class, 'kios_id');
    }
public function pedagang()
{
    // Relasi One-to-One: 1 Kios memiliki 1 Akun Pedagang
    // Berdasarkan migrasi Anda, kolom penghubungnya adalah kios_id di tabel pedagangs
    return $this->hasOne(Pedagang::class, 'kios_id');
}
}