<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelasSeeder extends Seeder
{
    public function run()
    {
        foreach ([7 => 'VII', 8 => 'VIII', 9 => 'IX'] as $tingkat => $romawi) {
            for ($nomor = 1; $nomor <= 10; $nomor++) {
                DB::table('kelas')->updateOrInsert(
                    ['nama_kelas' => "{$romawi}-{$nomor}"],
                    ['tingkat' => $tingkat]
                );
            }

            foreach (['A', 'B'] as $bagian) {
                if ($tingkat === 9 && $bagian === 'B') {
                    continue;
                }

                DB::table('kelas')->updateOrInsert(
                    ['nama_kelas' => "{$romawi}-{$bagian}"],
                    ['tingkat' => $tingkat]
                );
            }
        }
    }
}
