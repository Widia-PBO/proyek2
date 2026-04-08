<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kios;
use App\Models\Petugas;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PasarSeeder extends Seeder
{
    public function run(): void
    {
        // 1. BUAT AKUN SUPER ADMIN (Sesuai Profil Tuan Muda)
        User::create([
            'name' => 'Haziq Faiz',
            'username' => 'admin_haziq', // Tuan Muda bisa login pakai ini
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'nip' => '1927391273123',
            'email' => 'haziq@pasarbaru.com',
            'whatsapp' => '0812312371263',
            'jabatan' => 'Super Admin',
            'wilayah' => 'Seluruh Pasar',
        ]);

        // 2. BUAT DATA KIOS (Sesuai Desain Figma Halaman Data Kios)
        Kios::create([
            'no_kios' => 'A1',
            'nama_usaha' => 'Toko Supri',
            'jenis_usaha' => 'Sembako',
            'nama_pemilik' => 'Supri',
            'blok' => 'A',
            'username' => 'Supritoko',
            'password' => Hash::make('toko123'),
            'status' => 'Aktif',
        ]);

        // 3. BUAT DATA PETUGAS (Sesuai Desain Figma Halaman Data Petugas)
        Petugas::create([
            'id_petugas' => 'P001',
            'nama_petugas' => 'Budiman',
            'username' => 'budi_pasar',
            'password' => Hash::make('petugas123'),
            'wilayah_tugas' => 'Blok A',
            'kontak' => '0812312380112',
            'status' => 'Aktif',
        ]);
    }
}