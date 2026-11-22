<?php

namespace Tests\Feature;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Tests\TestCase;

class ImportDataSiswaTest extends TestCase
{
    use DatabaseTransactions;

    public function test_upload_imports_the_jk_header_and_zero_padded_class_codes(): void
    {
        $kelasA = Kelas::where('nama_kelas', 'VII-1')->firstOrFail();
        $kelasB = Kelas::where('nama_kelas', 'VII-2')->firstOrFail();
        $this->actingAs($this->makeGuruBk());

        [$file, $path] = $this->makeExcel([
            ['NO', 'NISN', 'NAMA', 'JK', 'Kelas'],
            ['1', $nisnA = $this->uniqueNisn(), 'Import Uji VII-01', ' P ', 'VII-01'],
            ['2', $nisnB = $this->uniqueNisn(), 'Import Uji VII-02', ' L ', 'VII-02'],
        ]);

        try {
            $response = $this->post(route('siswa.import'), [
                'form_type' => 'import',
                'tingkat' => '7',
                'kelas' => 'all',
                'file' => $file,
            ]);

            $response->assertRedirect(route('siswa.index'));
            $response->assertSessionHas('import_success', '2 data siswa berhasil diimport.');
            $this->assertDatabaseHas('siswa', [
                'nis' => $nisnA,
                'nama_siswa' => 'Import Uji VII-01',
                'jenis_kelamin' => 'P',
                'id_kelas' => $kelasA->id_kelas,
            ]);
            $this->assertDatabaseHas('siswa', [
                'nis' => $nisnB,
                'nama_siswa' => 'Import Uji VII-02',
                'jenis_kelamin' => 'L',
                'id_kelas' => $kelasB->id_kelas,
            ]);

            $this->get(route('siswa.index'))
                ->assertOk()
                ->assertSee('Import Uji VII-01')
                ->assertSee('2 data siswa berhasil diimport.');
        } finally {
            @unlink($path);
        }
    }

    public function test_duplicate_nisn_is_reported_and_the_import_batch_is_not_partially_saved(): void
    {
        $kelas = Kelas::where('nama_kelas', 'IX-A')->firstOrFail();
        $existingNisn = $this->uniqueNisn();
        Siswa::create([
            'nis' => $existingNisn,
            'nama_siswa' => 'Siswa Sudah Terdaftar',
            'jenis_kelamin' => 'L',
            'id_kelas' => $kelas->id_kelas,
            'status' => 'Aktif',
        ]);
        $newNisn = $this->uniqueNisn();
        $this->actingAs($this->makeGuruBk());

        [$file, $path] = $this->makeExcel([
            ['NO', 'NISN', 'NAMA', 'JENIS KELAMIN', 'KELAS'],
            ['1', $existingNisn, 'Duplikat Uji', 'L', 'IX-A'],
            ['2', $newNisn, 'Tidak Boleh Parsial', 'P', 'IX-A'],
        ]);

        try {
            $response = $this->post(route('siswa.import'), [
                'form_type' => 'import',
                'tingkat' => '9',
                'kelas' => 'all',
                'file' => $file,
            ]);

            $response->assertRedirect(route('siswa.index'));
            $response->assertSessionHasErrors('file');
            $this->get(route('siswa.index'))
                ->assertOk()
                ->assertSee("NISN {$existingNisn} sudah terdaftar di database.");
            $this->assertDatabaseMissing('siswa', ['nis' => $newNisn]);
        } finally {
            @unlink($path);
        }
    }

    public function test_upload_maps_the_viii_b_class_from_the_selected_roman_level(): void
    {
        $kelas = Kelas::where('nama_kelas', 'VIII-B')->firstOrFail();
        $nisn = $this->uniqueNisn();
        $this->actingAs($this->makeGuruBk());

        [$file, $path] = $this->makeExcel([
            ['NO', 'NISN', 'NAMA', 'JENIS KELAMIN', 'KELAS'],
            ['1', $nisn, 'Import Uji VIII-B', 'L', 'VIII-B'],
        ]);

        try {
            $response = $this->post(route('siswa.import'), [
                'form_type' => 'import',
                'tingkat' => '8',
                'kelas' => 'all',
                'file' => $file,
            ]);

            $response->assertRedirect(route('siswa.index'));
            $response->assertSessionHas('import_success', '1 data siswa berhasil diimport.');
            $this->assertDatabaseHas('siswa', [
                'nis' => $nisn,
                'nama_siswa' => 'Import Uji VIII-B',
                'id_kelas' => $kelas->id_kelas,
            ]);
        } finally {
            @unlink($path);
        }
    }

    private function makeGuruBk(): User
    {
        return User::create([
            'nama' => 'Guru BK Uji Import',
            'username' => 'uji_import_' . uniqid(),
            'password' => bcrypt('temporary-test-password'),
            'role' => 'guru_bk',
            'id_kelas' => null,
        ]);
    }

    private function uniqueNisn(): string
    {
        do {
            $nisn = (string) random_int(1000000000, 9999999999);
        } while (Siswa::where('nis', $nisn)->exists());

        return $nisn;
    }

    private function makeExcel(array $rows): array
    {
        $temporaryPath = tempnam(sys_get_temp_dir(), 'sirasi-import-');
        $path = $temporaryPath . '.xlsx';
        @unlink($temporaryPath);

        $spreadsheet = new Spreadsheet();
        $spreadsheet->getActiveSheet()->fromArray($rows, null, 'A1');
        (new Xlsx($spreadsheet))->save($path);
        $spreadsheet->disconnectWorksheets();

        return [
            new UploadedFile(
                $path,
                'data-siswa.xlsx',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                null,
                true
            ),
            $path,
        ];
    }
}
