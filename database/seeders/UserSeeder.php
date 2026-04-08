<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // 1. Buat Akun Admin (Bendahara)
        User::create([
            'username' => 'admin_aisyah',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // 2. Buat Akun Petugas Lapangan
        User::create([
            'username' => 'petugas_haziq',
            'password' => Hash::make('petugas123'),
            'role' => 'petugas',
        ]);

        // 3. Buat Akun Pedagang
        User::create([
            'username' => 'pedagang_widia',
            'password' => Hash::make('pedagang123'),
            'role' => 'pedagang',
        ]);
    }
}