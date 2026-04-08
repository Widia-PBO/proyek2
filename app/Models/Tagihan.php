<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model {
    protected $primaryKey = 'id_tagihan';
    protected $fillable = ['id_pedagang', 'id_iuran', 'periode', 'jumlah_tagihan', 'status_tagihan'];

    public function pedagang() { return $this->belongsTo(Pedagang::class, 'id_pedagang'); }
    public function iuran() { return $this->belongsTo(Iuran::class, 'id_iuran'); }
    public function pembayaran() { return $this->hasOne(Pembayaran::class, 'id_tagihan'); }
}