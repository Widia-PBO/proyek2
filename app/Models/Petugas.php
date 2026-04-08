<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Petugas extends Model {
    protected $table = 'petugas'; // Karena jamaknya bukan 'petugases'
    protected $primaryKey = 'id_petugas';
    protected $fillable = ['nama_petugas', 'alamat', 'no_hp', 'id_user'];

    public function user() { return $this->belongsTo(User::class, 'id_user'); }
    public function setorans() { return $this->hasMany(Setoran::class, 'id_petugas'); }
}