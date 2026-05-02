<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PasarSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Super Admin
        User::create([
            'name'      => 'Admin Haziq',
            'username'  => 'admin_haziqq',
            'password'  => Hash::make('admin123'),
            'role'      => 'admin',
            'nip'       => '123456789',
            'email'     => 'admin@pasarsidorejo.com',
            'whatsapp'  => '08123456789',
            'jabatan'   => 'Super Admin',
            'wilayah'   => 'Seluruh Pasar'
        ]);

        // Tuan Muda bisa menambahkan data awal Petugas atau Kios di sini jika mau
    }
}