<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model {
    protected $primaryKey = 'id_pembayaran';
    protected $fillable = ['id_tagihan', 'tanggal_bayar', 'jumlah_bayar', 'metode_pembayaran'];

    public function tagihan() { return $this->belongsTo(Tagihan::class, 'id_tagihan'); }
}