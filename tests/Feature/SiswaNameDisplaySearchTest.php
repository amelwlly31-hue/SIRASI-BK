<?php

namespace Tests\Feature;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class SiswaNameDisplaySearchTest extends TestCase
{
    use DatabaseTransactions;

    public function test_uppercase_student_name_is_displayed_in_title_case_without_changing_the_database(): void
    {
        $kelas = Kelas::where('nama_kelas', 'VII-1')->firstOrFail();
        $siswa = Siswa::create([
            'nis' => 'T' . uniqid(),
            'nama_siswa' => 'ABIDZAR RAFIF',
            'jenis_kelamin' => 'L',
            'id_kelas' => $kelas->id_kelas,
            'status' => 'Aktif',
        ]);

        $this->assertSame('Abidzar Rafif', $siswa->fresh()->nama_siswa);
        $this->assertSame('ABIDZAR RAFIF', DB::table('siswa')->where('id_siswa', $siswa->id_siswa)->value('nama_siswa'));

        $this->actingAs(User::create([
            'nama' => 'Guru BK Uji Nama',
            'username' => 'uji_nama_' . uniqid(),
            'password' => bcrypt('temporary-test-password'),
            'role' => 'guru_bk',
            'id_kelas' => null,
        ]));

        foreach (['abidzar', 'ABIDZAR', 'Abidzar'] as $search) {
            $this->get(route('siswa.index', ['search' => $search]))
                ->assertOk()
                ->assertSee('Abidzar Rafif');
        }

        $this->get(route('siswa.show', $siswa->id_siswa))
            ->assertOk()
            ->assertSee('Abidzar Rafif');
    }
}
