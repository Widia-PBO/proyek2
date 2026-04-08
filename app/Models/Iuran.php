<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Iuran extends Model {
    protected $primaryKey = 'id_iuran';
    protected $fillable = ['nama_iuran', 'nominal_tarif'];

    public function tagihans() { return $this->hasMany(Tagihan::class, 'id_iuran'); }
}
