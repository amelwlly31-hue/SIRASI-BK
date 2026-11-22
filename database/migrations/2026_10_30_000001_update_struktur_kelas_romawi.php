<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        foreach ([7 => 'VII', 8 => 'VIII', 9 => 'IX'] as $tingkat => $romawi) {
            for ($nomor = 1; $nomor <= 10; $nomor++) {
                $namaLama = "{$tingkat}.{$nomor}";
                $namaBaru = "{$romawi}-{$nomor}";
                DB::table('kelas')->where('nama_kelas', $namaLama)->update([
                    'nama_kelas' => $namaBaru,
                    'tingkat' => $tingkat,
                ]);
            }

            foreach (['A', 'B'] as $bagian) {
                if ($tingkat === 9 && $bagian === 'B') {
                    continue;
                }

                DB::table('kelas')->where('nama_kelas', "{$tingkat}{$bagian}")->update([
                    'nama_kelas' => "{$romawi}-{$bagian}",
                    'tingkat' => $tingkat,
                ]);
            }
        }

        foreach ([7 => 'VII', 8 => 'VIII', 9 => 'IX'] as $tingkat => $romawi) {
            for ($nomor = 1; $nomor <= 10; $nomor++) {
                DB::table('kelas')->updateOrInsert(
                    ['nama_kelas' => "{$romawi}-{$nomor}"],
                    ['tingkat' => $tingkat]
                );
            }

            foreach ($tingkat === 9 ? ['A'] : ['A', 'B'] as $bagian) {
                DB::table('kelas')->updateOrInsert(
                    ['nama_kelas' => "{$romawi}-{$bagian}"],
                    ['tingkat' => $tingkat]
                );
            }
        }

        DB::table('kelas')->where('nama_kelas', 'IX-B')->delete();
        DB::table('kelas')->where('nama_kelas', '9B')->delete();
    }

    public function down()
    {
        // The migration preserves class ids and relationships; reverse renaming is omitted
        // because the prior class labels were inconsistent and ambiguous.
    }
};
