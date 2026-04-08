<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model {
    protected $primaryKey = 'id_admin';
    protected $fillable = ['nama_admin', 'id_user'];

    public function user() { return $this->belongsTo(User::class, 'id_user'); }
}