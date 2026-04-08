<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Setoran extends Model {
    protected $primaryKey = 'id_setoran';
    protected $fillable = ['id_petugas', 'tanggal_setor', 'total_setoran'];

    public function petugas() { return $this->belongsTo(Petugas::class, 'id_petugas'); }
}
