<?php

namespace App\Imports;

use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToCollection, WithHeadingRow
{
    protected $tingkat;
    protected $kelas;

    public function __construct($tingkat, $kelas = 'all')
    {
        $this->tingkat = (string) $tingkat;
        $this->kelas = $kelas;
    }

    public function collection(Collection $rows)
    {
        $errors = [];
        $dataSiswa = [];
        $seenNisn = [];

        /* | | ambil data kelas sesuai jenjang | */

        $kelasQuery = Kelas::where('tingkat', $this->tingkat);

        if ($this->kelas !== 'all') {
            $kelasQuery->where('id_kelas', $this->kelas);
        }

        $kelasTersedia = $kelasQuery
            ->get()
            ->keyBy('nama_kelas');

        /* | | cek file kosong | */

        if ($rows->isEmpty()) {
            throw ValidationException::withMessages([
                'file' => 'File Excel tidak memiliki data siswa.',
            ]);
        }

        /* | | validasi setiap baris excel | */

        foreach ($rows as $index => $row) {

            // nomor baris excel.
            // baris pertama setelah header = baris 2.
            $nomorBaris = $index + 2;

            // Header Excel: NO, NISN, NAMA, JK, KELAS.
            // Header lama tetap diterima agar file yang sudah digunakan tetap kompatibel.
            $nama = $this->cleanCell($row['nama'] ?? $row['nama_siswa'] ?? '');
            $nisn = $this->cleanCell($row['nisn'] ?? $row['nis'] ?? '');
            $jenisKelamin = strtoupper($this->cleanCell($row['jk'] ?? $row['jenis_kelamin'] ?? ''));
            $alamat = trim((string) ($row['alamat'] ?? ''));
            $noTelp = trim((string) ($row['no_telepon'] ?? ''));
            $namaKelas = strtoupper($this->cleanCell($row['kelas'] ?? ''));
            $namaKelas = preg_replace('/^KELAS\s+/u', '', $namaKelas);
            $namaKelas = preg_replace('/\s*[-–—‐‑]\s*/u', '-', $namaKelas);
            $namaKelas = preg_replace('/^(VII|VIII|IX)\s+(10|[1-9]|A|B)$/u', '$1-$2', $namaKelas);
            if (preg_match('/^(VII|VIII|IX)-0*([1-9]|10)$/u', $namaKelas, $kelasNumerik)) {
                $namaKelas = $kelasNumerik[1] . '-' . (int) $kelasNumerik[2];
            }

            $jenisKelamin = match ($jenisKelamin) {
                'LAKI-LAKI', 'LAKI LAKI', 'PRIA', 'MALE' => 'L',
                'PEREMPUAN', 'WANITA', 'FEMALE' => 'P',
                default => $jenisKelamin,
            };

            /* | | abaikan baris yang benar-benar kosong | */

            if (
                $nama === '' &&
                $nisn === '' &&
                $jenisKelamin === '' &&
                $alamat === '' &&
                $noTelp === '' &&
                $namaKelas === ''
            ) {
                continue;
            }

            /* | | nama siswa wajib | */

            if ($nama === '') {
                $errors[] = "Baris {$nomorBaris}: Nama Siswa wajib diisi.";
                continue;
            }

            if (strlen($nama) > 100) {
                $errors[] = "Baris {$nomorBaris}: Nama Siswa maksimal 100 karakter.";
                continue;
            }

            if ($nisn !== '') {
                if (isset($seenNisn[$nisn])) {
                    $errors[] = "Baris {$nomorBaris}: NISN {$nisn} duplikat dengan baris {$seenNisn[$nisn]} pada file Excel.";
                    continue;
                }
                if (Siswa::where('nis', $nisn)->exists()) {
                    $errors[] = "Baris {$nomorBaris}: NISN {$nisn} sudah terdaftar di database.";
                    continue;
                }
                $seenNisn[$nisn] = $nomorBaris;
            }

            /* | | jenis kelamin wajib l/p | */

            if (!in_array($jenisKelamin, ['L', 'P'])) {
                $errors[] = "Baris {$nomorBaris}: Jenis Kelamin harus L atau P.";
                continue;
            }

            /* | | kelas wajib | */

            if ($namaKelas === '') {
                $errors[] = "Baris {$nomorBaris}: Kelas wajib diisi.";
                continue;
            }

            /* | | cek kelas sesuai jenjang dan pilihan kelas | */

            if (!$kelasTersedia->has($namaKelas)) {

                if ($this->kelas === 'all') {
                    $tingkatRomawi = [7 => 'VII', 8 => 'VIII', 9 => 'IX'][(int) $this->tingkat] ?? $this->tingkat;
                    $errors[] = "Baris {$nomorBaris}: Kelas {$namaKelas} tidak termasuk jenjang {$tingkatRomawi}.";
                } else {
                    $kelasDipilih = Kelas::find($this->kelas);

                    $namaKelasDipilih = $kelasDipilih
                        ? $kelasDipilih->nama_kelas
                        : 'yang dipilih';

                    $errors[] = "Baris {$nomorBaris}: Kelas {$namaKelas} tidak sesuai. Kelas yang dipilih adalah {$namaKelasDipilih}.";
                }

                continue;
            }

            $kelas = $kelasTersedia->get($namaKelas);

            /* | | simpan data yang sudah lolos validasi | */

            $dataSiswa[] = [
                'nis' => $nisn !== '' ? $nisn : null,
                'nama_siswa' => $nama,
                'jenis_kelamin' => $jenisKelamin,
                'id_kelas' => $kelas->id_kelas,
                'alamat' => $alamat !== '' ? $alamat : null,
                'no_telp' => $noTelp !== '' ? $noTelp : null,
                'status' => 'Aktif',
            ];
        }

        /* | | kalau ada kesalahan, batalkan seluruh import | */

        if (!empty($errors)) {
            throw ValidationException::withMessages([
                'file' => $errors,
            ]);
        }

        if (empty($dataSiswa)) {
            throw ValidationException::withMessages([
                'file' => 'Tidak ada baris siswa yang dapat diimport. Pastikan file berisi data setelah baris header.',
            ]);
        }

        /* | | simpan semua data sekaligus | */

        DB::transaction(function () use ($dataSiswa) {

            foreach ($dataSiswa as $data) {
                Siswa::create($data);
            }
        });

        $this->importedCount = count($dataSiswa);
    }

    protected int $importedCount = 0;

    public function importedCount(): int
    {
        return $this->importedCount;
    }

    private function cleanCell($value): string
    {
        $value = (string) $value;

        return trim(preg_replace('/^\s+|\s+$/u', '', $value) ?? $value);
    }
}
