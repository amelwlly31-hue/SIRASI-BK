<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Hapus akun warisan yang memakai identitas Guru BK dengan role Admin.
        User::where('username', 'adminbk')
            ->where('nama', 'Guru BK')
            ->where('role', 'admin')
            ->delete();

        // Akun default Administrator.
        $administrator = User::firstOrCreate(
            ['username' => 'admin'],
            [
                'nama' => 'Administrator',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'id_kelas' => null,
            ]
        );
        $administrator->forceFill([
            'nama' => 'Administrator',
            'role' => 'admin',
            'id_kelas' => null,
        ])->save();

        // Akun default Guru BK.
        $guruBk = User::firstOrCreate(
            ['username' => 'gurubk'],
            [
                'nama' => 'Guru BK',
                'password' => Hash::make('gurubk123'),
                'role' => 'guru_bk',
                'id_kelas' => null,
            ]
        );
        $guruBk->forceFill([
            'nama' => 'Guru BK',
            'role' => 'guru_bk',
            'id_kelas' => null,
        ])->save();

        // Akun Wali Kelas yang sudah dibuat untuk sekolah tetap dipertahankan.
    }
}
