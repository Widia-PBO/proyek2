<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Kios extends Model {
    protected $primaryKey = 'id_kios';
    protected $fillable = ['nomor_kios', 'lokasi', 'status_kios'];

    // Kios bisa dimiliki satu pedagang
    public function pedagang() { return $this->hasOne(Pedagang::class, 'id_kios'); }
}