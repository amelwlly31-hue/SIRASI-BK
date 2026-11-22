<?php

namespace App\Http\Controllers;

use App\Models\Konseling;
use App\Models\Kelas;
use App\Models\Penjadwalan;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as XlsxWriter;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\SimpleType\Jc;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $jenisLaporan = $request->input('jenis', 'periode');

        if (!in_array($jenisLaporan, [
            'periode',
            'per_siswa',
            'rekap_masalah',
        ], true)) {
            $jenisLaporan = 'periode';
        }

        $tanggalMulai = $request->tanggal_mulai
            ?? now()->startOfMonth()->format('Y-m-d');

        $tanggalAkhir = $request->tanggal_akhir
            ?? now()->endOfMonth()->format('Y-m-d');

        if ($tanggalMulai && $tanggalAkhir && $tanggalMulai > $tanggalAkhir) {
            [$tanggalMulai, $tanggalAkhir] = [$tanggalAkhir, $tanggalMulai];
        }

        $idKelas = $request->id_kelas;
        $idSiswa = $request->id_siswa;

        $kelas = Kelas::all();

        $siswa = Siswa::with('kelas')
            ->orderBy('nama_siswa')
            ->get();

        // Pastikan filter siswa pada laporan periode tidak tercampur lintas kelas apabila kelas dipilih
        if ($jenisLaporan === 'periode' && $idKelas && $idSiswa) {
            $siswaCocokKelas = $siswa->firstWhere('id_siswa', (int) $idSiswa);
            if (!$siswaCocokKelas || (int) $siswaCocokKelas->id_kelas !== (int) $idKelas) {
                $idSiswa = null;
            }
        }

        $konseling = collect();
        $siswaTerpilih = null;
        $konselingSiswa = collect();
        $rekapMasalah = collect();
        $totalKonselingMasalah = 0;
        $totalJenisMasalah = 0;
        $masalahTerbanyak = null;
        $totalUntukPersen = 1;

        if ($jenisLaporan === 'periode') {
            $query = Konseling::with([
                'siswa.kelas',
                'jenisMasalah',
                'tindakLanjut',
            ])
                ->whereBetween('tanggal', [
                    $tanggalMulai,
                    $tanggalAkhir,
                ])
                ->orderBy('tanggal', 'asc');

            if ($idKelas) {
                $query->whereHas('siswa', function ($query) use ($idKelas) {
                    $query->where('id_kelas', $idKelas);
                });
            }

            if ($idSiswa) {
                $query->where('id_siswa', $idSiswa);
            }

            $konseling = $query->get();
        }

        if ($jenisLaporan === 'per_siswa' && $idSiswa) {
            $siswaTerpilih = Siswa::with('kelas')
                ->findOrFail($idSiswa);

            $konselingSiswa = Konseling::with([
                'jenisMasalah',
                'tindakLanjut',
            ])
                ->where('id_siswa', $idSiswa)
                ->orderByDesc('tanggal')
                ->get();
        }

        if ($jenisLaporan === 'rekap_masalah') {
            $konselingRekap = Konseling::with('jenisMasalah')->get();

            $rekapMasalah = $konselingRekap
                ->groupBy('id_jenis')
                ->map(function ($items) {
                    return [
                        'nama_jenis' => optional(
                            $items->first()->jenisMasalah
                        )->nama_jenis ?? 'Tidak Diketahui',
                        'jumlah' => $items->count(),
                    ];
                })
                ->sortByDesc('jumlah')
                ->values();

            $totalKonselingMasalah = $konselingRekap->count();
            $totalJenisMasalah = $rekapMasalah->count();
            $masalahTerbanyak = $rekapMasalah->first();
            $totalUntukPersen = max($totalKonselingMasalah, 1);
        }

        return view('laporan.index', compact(
            'jenisLaporan',
            'konseling',
            'kelas',
            'siswa',
            'tanggalMulai',
            'tanggalAkhir',
            'idKelas',
            'idSiswa',
            'siswaTerpilih',
            'konselingSiswa',
            'rekapMasalah',
            'totalKonselingMasalah',
            'totalJenisMasalah',
            'masalahTerbanyak',
            'totalUntukPersen'
        ));
    }

    public function perSiswa(Request $request)
    {
        return redirect()->route('laporan.index', array_filter([
            'jenis' => 'per_siswa',
            'id_siswa' => $request->id_siswa,
        ]));
    }

    public function rekapMasalah()
    {
        return redirect()->route('laporan.index', [
            'jenis' => 'rekap_masalah',
        ]);
    }

    public function preview(Request $request)
    {
        return view('laporan.cetak', array_merge(
            $this->getPeriodeReportData($request),
            ['showPrintButton' => true]
        ));
    }

    public function cetakIndividu($id)
    {
        $konseling = Konseling::with([
            'siswa.kelas',
            'jenisMasalah',
            'tindakLanjut',
        ])->findOrFail($id);

        $logoPath = public_path('images/logo-smpn2-dramaga-cropped.jpg');
        $logoBase64 = is_file($logoPath)
            ? 'data:image/jpeg;base64,' . base64_encode(file_get_contents($logoPath))
            : '';

        return view('laporan.cetak-konseling', [
            'reports' => [$this->getOfficialReportData($konseling)],
            'autoPrint' => !request()->boolean('preview'),
            'pdfMode' => false,
            'logoBase64' => $logoBase64,
        ]);
    }

    public function exportPdf(Request $request)
    {
        $records = $this->getPeriodeReportData($request)['konseling'];
        $reports = $records->map(fn (Konseling $item) => $this->getOfficialReportData($item))->all();
        $logoPath = public_path('images/logo-smpn2-dramaga-cropped.jpg');
        $logoBase64 = is_file($logoPath)
            ? 'data:image/jpeg;base64,' . base64_encode(file_get_contents($logoPath))
            : '';

        if (!file_exists(storage_path('fonts'))) {
            mkdir(storage_path('fonts'), 0755, true);
        }

        return Pdf::loadView('laporan.cetak-konseling', [
            'reports' => $reports,
            'autoPrint' => false,
            'pdfMode' => true,
            'logoBase64' => $logoBase64,
        ])
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isRemoteEnabled' => true,
                'isHtml5ParserEnabled' => true,
                'dpi' => 150,
                'defaultFont' => 'Times-Roman',
            ])
            ->download('laporan-konseling.pdf');
    }

    public function exportRekapExcel(Request $request)
    {
        $data = $this->getPeriodeReportData($request);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Rekap Konseling');

        $sheet->fromArray([
            ['No', 'Tanggal', 'Nama Siswa', 'Kelas', 'Jenis Masalah', 'Status'],
        ], null, 'A1');

        foreach ($data['konseling'] as $index => $item) {
            $sheet->fromArray([[
                $index + 1,
                $item->tanggal ? Carbon::parse($item->tanggal)->format('d-m-Y') : '-',
                $item->siswa->nama_siswa ?? '-',
                $item->siswa->kelas->nama_kelas ?? '-',
                $item->jenisMasalah->nama_jenis ?? '-',
                $item->status ?? '-',
            ]], null, 'A' . ($index + 2));
        }

        $sheet->getStyle('A1:F1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '173C91']],
            'alignment' => ['horizontal' => 'center'],
        ]);
        $sheet->freezePane('A2');
        $sheet->setAutoFilter('A1:F' . max($sheet->getHighestRow(), 1));
        foreach (range('A', 'F') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $path = tempnam(sys_get_temp_dir(), 'laporan-rekap-');
        (new XlsxWriter($spreadsheet))->save($path);

        return response()->download($path, 'rekapitulasi-data-konseling.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }

    public function exportDocx(Request $request)
    {
        $records = $this->getPeriodeReportData($request)['konseling'];
        $reports = $records->map(fn (Konseling $item) => $this->getOfficialReportData($item))->all();
        $word = new PhpWord();
        $word->setDefaultFontName('Times New Roman');
        $word->setDefaultFontSize(12);
        $word->setDefaultParagraphStyle(['spaceAfter' => 0]);
        $section = $word->addSection([
            'pageSizeW' => 11906,
            'pageSizeH' => 16838,
            'marginTop' => 567,
            'marginBottom' => 567,
            'marginLeft' => 850,
            'marginRight' => 850,
        ]);

        $logoPath = public_path('images/logo-smpn2-dramaga-cropped.jpg');
        foreach ($reports as $index => $report) {
            if ($index > 0) {
                $section->addPageBreak();
            }
            $this->addOfficialReportToWord($section, $report, $logoPath);
        }
        if (empty($reports)) {
            $section->addText('Tidak ada data konseling untuk filter yang dipilih.', ['name' => 'Times New Roman', 'size' => 12]);
        }

        $path = tempnam(sys_get_temp_dir(), 'laporan-konseling-');
        if ($path === false) {
            throw new \RuntimeException('Tidak dapat menyiapkan berkas laporan DOCX.');
        }
        // PHPWord creates the ZIP package itself; remove tempnam's empty file first.
        unlink($path);
        IOFactory::createWriter($word, 'Word2007')->save($path);

        $package = new \ZipArchive();
        // PHPWord's native addText() currently writes raw &, < and > in w:t nodes.
        // Escape only text-node contents so WordprocessingML tags and attributes stay intact.
        if ($package->open($path) === true) {
            $documentXml = $package->getFromName('word/document.xml');
            if ($documentXml !== false) {
                $documentXml = preg_replace_callback(
                    '/(<w:t\b[^>]*>)(.*?)(<\/w:t>)/s',
                    static function (array $match): string {
                        $text = html_entity_decode($match[2], ENT_QUOTES | ENT_XML1, 'UTF-8');
                        return $match[1] . htmlspecialchars($text, ENT_XML1 | ENT_QUOTES, 'UTF-8') . $match[3];
                    },
                    $documentXml
                );
                $package->addFromString('word/document.xml', $documentXml);
            }
            $package->close();
        }

        $validPackage = $package->open($path) === true
            && $package->locateName('[Content_Types].xml') !== false
            && $package->locateName('word/document.xml') !== false;
        if ($validPackage) {
            for ($i = 0; $i < $package->numFiles; $i++) {
                $entry = $package->getNameIndex($i);
                if (!str_ends_with(strtolower($entry), '.xml')) {
                    continue;
                }
                $xml = $package->getFromIndex($i);
                $dom = new \DOMDocument();
                if ($xml === false || !$dom->loadXML($xml, LIBXML_NONET)) {
                    $validPackage = false;
                    break;
                }
            }
        }
        if (!$validPackage) {
            if ($package->status === \ZipArchive::ER_OK) {
                $package->close();
            }
            if (is_file($path)) {
                unlink($path);
            }
            throw new \RuntimeException('Berkas laporan DOCX gagal dibuat dengan format Office yang valid.');
        }
        $package->close();

        return response()->download($path, 'laporan-resmi-konseling.docx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ])->deleteFileAfterSend(true);
    }

    private function getOfficialReportData(Konseling $konseling): array
    {
        $konseling->loadMissing(['siswa.kelas', 'jenisMasalah', 'tindakLanjut']);
        $tanggal = Carbon::parse($konseling->tanggal);
        $jadwal = Penjadwalan::with('slotKonseling.guruBk')
            ->where('id_siswa', $konseling->id_siswa)
            ->whereDate('tanggal', $konseling->tanggal)
            ->orderByDesc('id_penjadwalan')
            ->first();
        $tahunAwal = $tanggal->month >= 7 ? $tanggal->year : $tanggal->year - 1;

        return [
            'konseling' => $konseling,
            'jadwal' => $jadwal,
            'isKelompok' => stripos($jadwal->jenis_bimbingan ?? '', 'kelompok') !== false,
            'tanggalLayanan' => $tanggal->locale('id')->translatedFormat('l, d F Y'),
            'tanggalTtd' => $tanggal->locale('id')->translatedFormat('d F Y'),
            'durasiMenit' => ($jadwal?->waktu_mulai && $jadwal?->waktu_selesai)
                ? Carbon::parse($jadwal->waktu_mulai)->diffInMinutes(Carbon::parse($jadwal->waktu_selesai))
                : null,
            'semester' => $tanggal->month >= 7 ? 'Ganjil' : 'Genap',
            'tahunPelajaran' => $tahunAwal . '/' . ($tahunAwal + 1),
            'guruBk' => $jadwal?->slotKonseling?->guruBk ?? auth()->user(),
            'tempatLayanan' => 'Ruang BK SMPN 2 Dramaga',
        ];
    }

    private function addOfficialReportToWord($section, array $report, string $logoPath): void
    {
        $konseling = $report['konseling'];
        $jadwal = $report['jadwal'];
        $guruBk = $report['guruBk'];
        $isKelompok = $report['isKelompok'];
        $bodyStyle = ['alignment' => Jc::BOTH, 'spaceAfter' => 20, 'lineHeight' => 1.0];
        $labelStyle = ['bold' => true, 'size' => 12, 'name' => 'Times New Roman'];

        $kop = $section->addTable(['borderSize' => 0, 'cellMargin' => 0, 'width' => 100 * 50]);
        $kopRow = $kop->addRow();
        if (is_file($logoPath)) {
            $kopRow->addCell(1500)->addImage($logoPath, ['width' => 58, 'height' => 58, 'alignment' => Jc::CENTER]);
        } else {
            $kopRow->addCell(1500)->addText(' ');
        }
        $kopText = $kopRow->addCell(7800);
        $kopText->addText('PEMERINTAH KABUPATEN BOGOR', ['size' => 12], ['alignment' => Jc::CENTER, 'spaceAfter' => 0]);
        $kopText->addText('DINAS PENDIDIKAN', ['size' => 12], ['alignment' => Jc::CENTER, 'spaceAfter' => 0]);
        $kopText->addText('SMP NEGERI 2 DRAMAGA', ['bold' => true, 'size' => 12], ['alignment' => Jc::CENTER, 'spaceAfter' => 0]);
        $kopText->addText('Jl. Raya Dramaga KM. 07, Kec. Dramaga, Kab. Bogor, Jawa Barat 16680', ['size' => 12], ['alignment' => Jc::CENTER, 'spaceAfter' => 0]);
        $section->addText(' ', [], [
            'borderBottomSize' => 4,
            'borderBottomColor' => '000000',
            'borderBottomStyle' => 'single',
            'spaceBefore' => 0,
            'spaceAfter' => 100,
        ]);

        $section->addText('LAPORAN PELAKSANAAN LAYANAN BIMBINGAN DAN KONSELING', ['bold' => true, 'size' => 12, 'underline' => 'single'], ['alignment' => Jc::CENTER, 'spaceAfter' => 0]);
        $section->addText($isKelompok ? 'BIMBINGAN KELOMPOK' : 'KONSELING INDIVIDU', ['bold' => true, 'size' => 12], ['alignment' => Jc::CENTER, 'spaceAfter' => 0]);
        $section->addText('SEMESTER ' . strtoupper($report['semester']) . ' TAHUN PELAJARAN ' . $report['tahunPelajaran'], ['bold' => true, 'size' => 12], ['alignment' => Jc::CENTER, 'spaceAfter' => 60]);

        $section->addText('A. IDENTITAS & SPESIFIKASI LAYANAN', $labelStyle, ['spaceBefore' => 35, 'spaceAfter' => 20]);
        $identity = $section->addTable(['borderSize' => 6, 'borderColor' => '777777', 'cellMargin' => 35]);
        if ($isKelompok) {
            $this->addWordIdentityRow($identity, 'Topik Permasalahan / Bahasan', $konseling->masalah ?: ($konseling->jenisMasalah->nama_jenis ?? '-'));
            $this->addWordIdentityRow($identity, 'Bidang Bimbingan', $konseling->jenisMasalah->nama_jenis ?? 'Pribadi / Sosial / Belajar / Karier');
            $this->addWordIdentityRow($identity, 'Hari, Tanggal, Waktu & Tempat', $report['tanggalLayanan'] . ($jadwal?->waktu_mulai ? ', ' . substr($jadwal->waktu_mulai, 0, 5) . '–' . substr($jadwal->waktu_selesai, 0, 5) . ' WIB' : '') . ', ' . $report['tempatLayanan']);
            $section->addText('Anggota Kelompok', $labelStyle, ['spaceBefore' => 35, 'spaceAfter' => 20]);
            $members = $section->addTable(['borderSize' => 6, 'borderColor' => '222222', 'cellMargin' => 25]);
            $members->addRow();
            $members->addCell(600)->addText('No', ['bold' => true, 'size' => 12], ['alignment' => Jc::CENTER]);
            $members->addCell(6100)->addText('Nama Siswa', ['bold' => true, 'size' => 12], ['alignment' => Jc::CENTER]);
            $members->addCell(2400)->addText('Kelas', ['bold' => true, 'size' => 12], ['alignment' => Jc::CENTER]);
            for ($memberNo = 1; $memberNo <= 6; $memberNo++) {
                $members->addRow();
                $members->addCell(600)->addText((string) $memberNo, ['size' => 12], ['alignment' => Jc::CENTER]);
                $members->addCell(6100)->addText($memberNo === 1 ? ($konseling->siswa->nama_siswa ?? '') : ' ', ['size' => 12]);
                $members->addCell(2400)->addText($memberNo === 1 ? ($konseling->siswa->kelas->nama_kelas ?? '') : ' ', ['size' => 12]);
            }
        } else {
            $this->addWordIdentityRow($identity, 'Nama Siswa (Konseli)', $konseling->siswa->nama_siswa ?? '-');
            $this->addWordIdentityRow($identity, 'Kelas / NIS', ($konseling->siswa->kelas->nama_kelas ?? '-') . ' / ' . ($konseling->siswa->nis ?? '-'));
            $this->addWordIdentityRow($identity, 'Hari, Tanggal Pelaksanaan', $report['tanggalLayanan']);
            $waktu = $jadwal?->waktu_mulai
                ? substr($jadwal->waktu_mulai, 0, 5) . '–' . substr($jadwal->waktu_selesai, 0, 5) . ' WIB' . ($report['durasiMenit'] ? ' (' . $report['durasiMenit'] . ' menit)' : '')
                : '................................';
            $this->addWordIdentityRow($identity, 'Waktu / Durasi', $waktu);
            $this->addWordIdentityRow($identity, 'Tempat Layanan', $report['tempatLayanan']);
            $this->addWordIdentityRow($identity, 'Guru BK / Konselor', $guruBk->nama ?? '-');
        }

        $section->addText('B. URAIAN PROSES & HASIL KONSELING', $labelStyle, ['spaceBefore' => 160, 'spaceAfter' => 60]);
        $section->addText('Gejala yang Nampak / Masalah yang Dihadapi', $labelStyle, ['spaceAfter' => 30]);
        $section->addText($konseling->masalah ?: '-', ['size' => 12], $bodyStyle);
        $section->addText('Pendekatan dan Teknik Konseling yang Digunakan', $labelStyle, ['spaceAfter' => 30]);
        $section->addText($konseling->catatan ?: '-', ['size' => 12], $bodyStyle);
        $section->addText('Hasil Konseling yang Dicapai', $labelStyle, ['spaceAfter' => 30]);
        $section->addText($konseling->hasil_konseling ?: '-', ['size' => 12], $bodyStyle);
        $section->addText('Diagnosis / Kesimpulan Asesmen', $labelStyle, ['spaceAfter' => 30]);
        $section->addText($konseling->diagnosis ?: '-', ['size' => 12], $bodyStyle);
        $section->addText('Rencana Tindak Lanjut (Follow-Up)', $labelStyle, ['spaceAfter' => 30]);
        if (filled($konseling->rencana_tindak_lanjut)) {
            $section->addText($konseling->rencana_tindak_lanjut, ['size' => 12], $bodyStyle);
        } elseif ($konseling->tindakLanjut->isEmpty()) {
            $section->addText('-', ['size' => 12], $bodyStyle);
        } else {
            foreach ($konseling->tindakLanjut as $i => $tindak) {
                $section->addText(($konseling->tindakLanjut->count() > 1 ? ($i + 1) . '. ' : '') . ($tindak->tanggal ? Carbon::parse($tindak->tanggal)->format('d-m-Y') . ' — ' : '') . $tindak->tindakan . ($tindak->keterangan ? ': ' . $tindak->keterangan : ''), ['size' => 12], $bodyStyle);
            }
        }

        $section->addText('C. LEMBAR TANDA TANGAN PENGESAHAN', $labelStyle, ['spaceBefore' => 180, 'spaceAfter' => 60]);
        $signatures = $section->addTable(['borderSize' => 0, 'cellMargin' => 80]);
        $signatureRow = $signatures->addRow();
        $left = $signatureRow->addCell(4700);
        $left->addText('Mengetahui,', ['size' => 11], ['alignment' => Jc::CENTER]);
        $left->addText('Kepala SMP Negeri 2 Dramaga', ['size' => 11], ['alignment' => Jc::CENTER]);
        $left->addTextBreak(4);
        $left->addText('....................................................', ['size' => 12], ['alignment' => Jc::CENTER]);
        $left->addText('NIP. ....................................................', ['size' => 12], ['alignment' => Jc::CENTER]);
        $right = $signatureRow->addCell(4700);
        $right->addText('Dramaga, ' . $report['tanggalTtd'], ['size' => 12], ['alignment' => Jc::CENTER]);
        $right->addText('Guru Bimbingan Konseling,', ['size' => 12], ['alignment' => Jc::CENTER]);
        $right->addTextBreak(4);
        $right->addText($guruBk->nama ?? '....................................................', ['bold' => true, 'underline' => 'single', 'size' => 12], ['alignment' => Jc::CENTER]);
        $right->addText('NIP. ....................................................', ['size' => 12], ['alignment' => Jc::CENTER]);
        $section->addText('Dokumen ini memuat informasi layanan bimbingan dan konseling yang bersifat rahasia.', ['italic' => true, 'size' => 12], ['alignment' => Jc::CENTER, 'spaceBefore' => 120]);
    }

    private function addWordIdentityRow($table, string $label, string $value): void
    {
        $row = $table->addRow();
        $row->addCell(3100)->addText($label, ['size' => 12]);
        $row->addCell(250)->addText(':', ['size' => 12]);
        $row->addCell(5850)->addText($value, ['size' => 12]);
    }

    private function getPeriodeReportData(Request $request): array
    {
        $tanggalMulai = $request->input('tanggal_mulai', now()->startOfMonth()->format('Y-m-d'));
        $tanggalAkhir = $request->input('tanggal_akhir', now()->endOfMonth()->format('Y-m-d'));

        if ($tanggalMulai && $tanggalAkhir && $tanggalMulai > $tanggalAkhir) {
            [$tanggalMulai, $tanggalAkhir] = [$tanggalAkhir, $tanggalMulai];
        }

        $idKelas = $request->input('id_kelas');
        $idSiswa = $request->input('id_siswa');

        if ($idKelas && $idSiswa) {
            $kelasSiswa = Siswa::where('id_siswa', $idSiswa)->value('id_kelas');
            if (!$kelasSiswa || (int) $kelasSiswa !== (int) $idKelas) {
                $idSiswa = null;
            }
        }

        $query = Konseling::with(['siswa.kelas', 'jenisMasalah'])
            ->whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir])
            ->orderBy('tanggal', 'asc');

        if ($idKelas) {
            $query->whereHas('siswa', function ($query) use ($idKelas) {
                $query->where('id_kelas', $idKelas);
            });
        }

        if ($idSiswa) {
            $query->where('id_siswa', $idSiswa);
        }

        return [
            'konseling' => $query->get(),
            'tanggalMulai' => $tanggalMulai,
            'tanggalAkhir' => $tanggalAkhir,
            'idKelas' => $idKelas,
            'idSiswa' => $idSiswa,
            'labelKelas' => $idKelas
                ? (Kelas::where('id_kelas', $idKelas)->value('nama_kelas') ?? '-')
                : 'Semua Kelas',
            'labelSiswa' => $idSiswa
                ? (Siswa::where('id_siswa', $idSiswa)->value('nama_siswa') ?? '-')
                : 'Semua Siswa',
        ];
    }
}
