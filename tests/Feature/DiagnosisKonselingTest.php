<?php

namespace Tests\Feature;

use App\Models\Kelas;
use App\Models\Konseling;
use App\Models\Siswa;
use App\Models\TindakLanjut;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DiagnosisKonselingTest extends TestCase
{
    use DatabaseTransactions;

    protected User $guruBk;
    protected User $admin;
    protected User $waliKelas;
    protected Siswa $siswa;
    protected Siswa $siswaLain;
    protected int $idJenis;

    protected function setUp(): void
    {
        parent::setUp();

        $kelas = Kelas::create([
            'nama_kelas' => '99.1',
            'tingkat' => 99,
        ]);

        $this->guruBk = $this->buatPengguna('guru_bk');
        $this->admin = $this->buatPengguna('admin');
        $this->waliKelas = $this->buatPengguna('wali_kelas', $kelas->id_kelas);

        $this->idJenis = (int) DB::table('jenis_masalah')->insertGetId([
            'nama_jenis' => 'Diagnosis test ' . uniqid(),
            'keterangan' => 'Fixture untuk pengujian diagnosis.',
        ]);

        $this->siswa = $this->buatSiswa($kelas->id_kelas, 'A');
        $this->siswaLain = $this->buatSiswa($kelas->id_kelas, 'B');
    }

    public function test_guru_bk_can_create_and_edit_diagnosis_without_implicitly_completing_session(): void
    {
        $payload = $this->payload($this->siswa, 'Diagnosis awal manual');

        $this->actingAs($this->guruBk)
            ->post(route('konseling.store'), $payload)
            ->assertRedirect(route('konseling.index'));

        $session = Konseling::where('id_siswa', $this->siswa->id_siswa)->firstOrFail();

        $this->assertSame('Diagnosis awal manual', $session->diagnosis);
        $this->assertSame('Proses', $session->status);

        $this->actingAs($this->guruBk)
            ->get(route('konseling.edit', $session->id_konseling))
            ->assertOk()
            ->assertSee('Diagnosis awal manual');

        $this->actingAs($this->guruBk)
            ->put(route('konseling.update', $session->id_konseling), $this->payload(
                $this->siswa,
                'Diagnosis dilengkapi manual',
                'Proses'
            ))
            ->assertRedirect(route('konseling.show', $session->id_konseling));

        $session->refresh();
        $this->assertSame('Diagnosis dilengkapi manual', $session->diagnosis);
        $this->assertSame('Proses', $session->status);

        $this->actingAs($this->guruBk)
            ->get(route('siswa.show', [$this->siswa->id_siswa, 'from' => 'riwayat']))
            ->assertOk()
            ->assertSee(route('konseling.show', $session->id_konseling));

        $this->actingAs($this->guruBk)
            ->get(route('konseling.show', $session->id_konseling))
            ->assertOk()
            ->assertSee('Diagnosis dilengkapi manual')
            ->assertSee('Proses');
    }

    public function test_per_student_report_shows_only_selected_students_session_diagnosis_results_and_follow_up(): void
    {
        $session = Konseling::create($this->payload(
            $this->siswa,
            'Diagnosis laporan siswa A',
            'Selesai',
            'Hasil konseling siswa A'
        ));
        TindakLanjut::create([
            'id_konseling' => $session->id_konseling,
            'tanggal' => '2026-10-26',
            'tindakan' => 'Tindak lanjut siswa A',
            'keterangan' => 'Keterangan tindak lanjut siswa A',
        ]);

        Konseling::create($this->payload(
            $this->siswaLain,
            'Diagnosis rahasia siswa B',
            'Selesai',
            'Hasil siswa B yang tidak boleh tercampur'
        ));

        $this->actingAs($this->guruBk)
            ->get(route('laporan.index', [
                'jenis' => 'per_siswa',
                'id_siswa' => $this->siswa->id_siswa,
            ]))
            ->assertOk()
            ->assertSee($this->siswa->nama_siswa)
            ->assertSee($this->siswa->nis)
            ->assertSee('Diagnosis laporan siswa A')
            ->assertSee('Hasil konseling siswa A')
            ->assertSee('Tindak lanjut siswa A')
            ->assertSee('Keterangan tindak lanjut siswa A')
            ->assertDontSee('Diagnosis rahasia siswa B')
            ->assertDontSee('Hasil siswa B yang tidak boleh tercampur');
    }

    public function test_legacy_session_with_null_diagnosis_renders_in_detail_and_report(): void
    {
        $session = Konseling::create($this->payload($this->siswa, null, 'Proses'));

        $this->actingAs($this->guruBk)
            ->get(route('konseling.show', $session->id_konseling))
            ->assertOk()
            ->assertDontSee('DIAGNOSIS / KESIMPULAN ASESMEN');

        $this->actingAs($this->guruBk)
            ->get(route('laporan.index', [
                'jenis' => 'per_siswa',
                'id_siswa' => $this->siswa->id_siswa,
            ]))
            ->assertOk()
            ->assertSee('Belum dicatat');
    }

    public function test_only_guru_bk_can_open_diagnosis_forms_details_and_student_reports(): void
    {
        $session = Konseling::create($this->payload($this->siswa, 'Diagnosis terbatas'));

        foreach ([$this->admin, $this->waliKelas] as $unauthorizedUser) {
            $this->actingAs($unauthorizedUser)
                ->get(route('konseling.create'))
                ->assertForbidden();

            $this->actingAs($unauthorizedUser)
                ->post(route('konseling.store'), $this->payload(
                    $this->siswa,
                    'Tidak boleh dibuat'
                ))
                ->assertForbidden();

            $this->actingAs($unauthorizedUser)
                ->get(route('konseling.edit', $session->id_konseling))
                ->assertForbidden();

            $this->actingAs($unauthorizedUser)
                ->get(route('konseling.show', $session->id_konseling))
                ->assertForbidden();

            $this->actingAs($unauthorizedUser)
                ->get(route('laporan.index', ['jenis' => 'per_siswa', 'id_siswa' => $this->siswa->id_siswa]))
                ->assertForbidden();

            $this->actingAs($unauthorizedUser)
                ->put(route('konseling.update', $session->id_konseling), $this->payload(
                    $this->siswa,
                    'Tidak boleh disimpan'
                ))
                ->assertForbidden();
        }
    }

    protected function buatPengguna(string $role, ?int $idKelas = null): User
    {
        return User::create([
            'nama' => 'Diagnosis Test ' . $role . ' ' . uniqid(),
            'username' => 'diagnosis_' . $role . '_' . uniqid(),
            'password' => bcrypt('test-password'),
            'role' => $role,
            'id_kelas' => $idKelas,
        ]);
    }

    protected function buatSiswa(int $idKelas, string $suffix): Siswa
    {
        return Siswa::create([
            'nis' => 'DIAG-' . $suffix . '-' . uniqid(),
            'nama_siswa' => 'Siswa Diagnosis ' . $suffix,
            'jenis_kelamin' => $suffix === 'A' ? 'L' : 'P',
            'id_kelas' => $idKelas,
            'status' => 'Aktif',
        ]);
    }

    protected function payload(Siswa $siswa, ?string $diagnosis, string $status = 'Proses', string $hasil = 'Hasil konseling uji'): array
    {
        return [
            'id_siswa' => $siswa->id_siswa,
            'id_jenis' => $this->idJenis,
            'tanggal' => '2026-10-26',
            'masalah' => 'Masalah uji diagnosis.',
            'hasil_konseling' => $hasil,
            'diagnosis' => $diagnosis,
            'catatan' => null,
            'status' => $status,
        ];
    }
}
