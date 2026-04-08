<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    protected $primaryKey = 'id_user';
    protected $fillable = ['username', 'password', 'role'];

    // Relasi ke profil masing-masing
    public function admin() { return $this->hasOne(Admin::class, 'id_user'); }
    public function petugas() { return $this->hasOne(Petugas::class, 'id_user'); }
    public function pedagang() { return $this->hasOne(Pedagang::class, 'id_user'); }
}