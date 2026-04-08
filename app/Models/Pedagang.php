<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Pedagang extends Model {
    protected $primaryKey = 'id_pedagang';
    protected $fillable = ['nama_pedagang', 'alamat', 'no_hp', 'id_kios', 'id_user'];

    public function kios() { return $this->belongsTo(Kios::class, 'id_kios'); }
    public function user() { return $this->belongsTo(User::class, 'id_user'); }
    public function tagihans() { return $this->hasMany(Tagihan::class, 'id_pedagang'); }
}