<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kelas;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // 1. Akun Admin Uji
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'nama' => 'Administrator Sistem',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'id_kelas' => null,
            ]
        );

        // 2. Akun Guru BK Uji
        User::updateOrCreate(
            ['username' => 'gurubk'],
            [
                'nama' => 'Guru BK SMPN 2 Dramaga',
                'password' => Hash::make('password123'),
                'role' => 'guru_bk',
                'id_kelas' => null,
            ]
        );

        // 3. Akun Wali Kelas 7.1 Uji
        $kelas71 = Kelas::where('nama_kelas', '7.1')->first();
        $idKelas = $kelas71 ? $kelas71->id_kelas : 1;

        User::updateOrCreate(
            ['username' => 'walikelas71'],
            [
                'nama' => 'Wali Kelas 7.1',
                'password' => Hash::make('password123'),
                'role' => 'wali_kelas',
                'id_kelas' => $idKelas,
            ]
        );
    }
}
