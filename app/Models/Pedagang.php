<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedagang extends Model 
{
    use HasFactory;

    // Catatan: Jika Tuan Muda menggunakan 'id' bawaan Laravel, $primaryKey tidak perlu ditulis.
    // Tapi jika Tuan Muda spesifik membuat kolomnya bernama 'id_pedagang', buka komentar di bawah ini:
    // protected $primaryKey = 'id_pedagang';

    // 1. Kolom apa saja yang boleh diisi (Sesuaikan dengan migration kita sebelumnya)
    protected $fillable = [
        'nama_pemilik', 
        'username', 
        'password', 
        'whatsapp', 
        'foto'
    ];

    // =======================================================
    // 2. RELASI UTAMA: 1 Pedagang memiliki BANYAK Kios
    // =======================================================
    public function kios() 
    { 
        // Penjelasan: Tabel Kios memegang kunci 'pedagang_id'
        return $this->hasMany(Kios::class, 'pedagang_id', 'id'); 
    }

    // =======================================================
    // 3. RELASI TAMBAHAN (Sesuai rencana Tuan Muda)
    // =======================================================
    public function tagihans() 
    { 
        return $this->hasMany(Tagihan::class, 'pedagang_id', 'id'); 
    }

    // Relasi User saya matikan sementara. 
    // Karena Pedagang sudah punya username & password sendiri, biasanya mereka tidak perlu dihubungkan lagi ke tabel users (Super Admin).
    // public function user() { return $this->belongsTo(User::class, 'id_user'); }
}   