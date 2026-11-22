<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Pelaksanaan Layanan Bimbingan dan Konseling</title>
    <style>
        * { box-sizing: border-box; }
        html, body {
            margin: 0;
            padding: 0;
        }
        body {
            background: #eef1f5;
            color: #000;
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.25;
        }
        .print-tools {
            width: 210mm;
            margin: 18px auto 10px;
            text-align: right;
        }
        .print-tools button {
            padding: 9px 16px;
            border: 0;
            border-radius: 7px;
            background: #173c91;
            color: #fff;
            font: 700 14px Arial, sans-serif;
            cursor: pointer;
        }
        .document {
            width: 210mm;
            margin: 0 auto 20px;
            padding: 12mm 15mm 10mm 15mm;
            background: #fff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, .08);
        }
        .page-break {
            page-break-after: always;
            break-after: page;
        }
        .kop {
            width: 100%;
            border-collapse: collapse;
            border-bottom: 2.5px double #000;
            table-layout: fixed;
            margin-bottom: 6px;
        }
        .kop td {
            border: 0;
            padding: 0 0 4px;
            vertical-align: middle;
        }
        .kop-logo {
            width: 15%;
            text-align: left;
        }
        .kop-logo img {
            display: block;
            width: 65px;
            height: auto;
            margin: 0;
        }
        .logo-placeholder {
            width: 65px;
            height: 65px;
            margin: 0;
            border: 1px dashed #999;
            color: #666;
            font-size: 9pt;
            line-height: 65px;
            text-align: center;
        }
        .kop-text {
            width: 70%;
            text-align: center;
            line-height: 1.15;
        }
        .kop-text p {
            margin: 0;
            line-height: 1.2;
        }
        .kop-text .kabupaten, .kop-text .dinas {
            font-size: 11pt;
        }
        .kop-text .sekolah {
            margin: 1px 0;
            font-size: 14pt;
            font-weight: 700;
        }
        .kop-text .alamat {
            font-size: 9.5pt;
        }
        .kop-balance {
            width: 15%;
        }
        .document-title {
            margin: 0 0 6px;
            text-align: center;
        }
        .document-title h1 {
            margin: 0;
            font-size: 12pt;
            font-weight: 700;
            line-height: 1.25;
            text-decoration: underline;
        }
        .document-title p {
            margin: 2px 0 0;
            font-size: 11pt;
            font-weight: 700;
            line-height: 1.25;
        }
        .document-title .semester {
            font-size: 10.5pt;
            font-weight: 700;
        }
        .section-title {
            margin: 6px 0 3px;
            font-size: 12pt;
            font-weight: 700;
            line-height: 1.25;
        }
        .identity-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 4px;
        }
        .identity-table td {
            border: 0;
            padding: 1.5px 0;
            vertical-align: top;
            font-size: 12pt;
            line-height: 1.25;
        }
        .identity-table .label {
            width: 215px;
            white-space: nowrap;
        }
        .identity-table .colon {
            width: 16px;
            text-align: center;
        }
        .identity-table .value {
            width: auto;
        }
        .member-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 3px;
            margin-bottom: 4px;
        }
        .member-table th, .member-table td {
            border: 1px solid #000;
            padding: 2px 4px;
            font-size: 11pt;
        }
        .member-table th {
            text-align: center;
        }
        .member-table .number {
            width: 42px;
            text-align: center;
        }
        .member-table .class {
            width: 100px;
        }
        .report-box-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 3px;
            margin-bottom: 6px;
            table-layout: fixed;
        }
        .report-box-table td {
            border: 1px solid #000;
            padding: 3.5px 6px;
            font-size: 12pt;
            line-height: 1.25;
            vertical-align: top;
        }
        .report-box-table .box-label {
            width: 38%;
            font-weight: 700;
        }
        .report-box-table .box-content {
            width: 62%;
            text-align: justify;
            word-wrap: break-word;
        }
        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
            page-break-inside: avoid;
        }
        .signature-table td {
            width: 50%;
            border: 0;
            padding: 0 10px;
            vertical-align: top;
            text-align: center;
            font-size: 12pt;
            line-height: 1.25;
        }
        .signature-table p {
            margin: 1px 0;
            font-size: 12pt;
            line-height: 1.25;
        }
        .signature-space {
            height: 38px;
        }
        .signer-name {
            margin: 0;
            font-size: 12pt;
            font-weight: 700;
            text-decoration: underline;
        }
        .signer-dots {
            margin: 0;
            font-size: 12pt;
            font-weight: 400;
        }
        .signer-nip {
            margin: 2px 0 0;
            font-size: 12pt;
        }
        .confidential {
            margin-top: 8px;
            font-size: 10pt;
            font-style: italic;
            text-align: center;
        }
        @page {
            size: A4 portrait;
            margin: 12mm 15mm 10mm 15mm;
        }
        @media print {
            html, body {
                width: 100% !important;
                height: auto !important;
                margin: 0 !important;
                padding: 0 !important;
                background: #fff !important;
            }
            .print-tools, nav, aside, .sidebar, .navbar, .dashboard-sidebar {
                display: none !important;
            }
            .document {
                width: 100% !important;
                min-height: 0 !important;
                margin: 0 !important;
                padding: 0 !important;
                box-shadow: none !important;
            }
            .page-break {
                page-break-after: always !important;
                break-after: page !important;
            }
        }
        @if (!empty($pdfMode))
        html, body {
            width: 100% !important;
            height: auto !important;
            margin: 0 !important;
            padding: 0 !important;
            background: #fff !important;
        }
        @page {
            size: A4 portrait;
            margin: 10mm 12mm;
        }
        body {
            font-family: 'Times New Roman', Times, serif !important;
            font-size: 12pt !important;
            line-height: 1.12 !important;
        }
        .document {
            width: 100% !important;
            min-height: 0 !important;
            margin: 0 !important;
            padding: 0 !important;
            box-shadow: none !important;
            page-break-inside: avoid;
            break-inside: avoid-page;
        }
        .kop { margin-bottom: 4px; }
        .kop-logo { width: 12%; }
        .kop-text { width: 76%; }
        .kop-balance { width: 12%; }
        .kop td { padding-bottom: 2px; }
        .kop-logo img, .logo-placeholder { width: 58px; }
        .logo-placeholder { height: 58px; line-height: 58px; }
        .kop-text, .kop-text .kabupaten, .kop-text .dinas, .kop-text .sekolah, .kop-text .alamat { font-size: 12pt !important; }
        .kop-text .sekolah { font-weight: 700; }
        .document-title { margin-bottom: 4px; }
        .document-title h1, .document-title p, .document-title .semester { font-size: 12pt !important; }
        .section-title { margin: 4px 0 2px; }
        .identity-table { margin-bottom: 2px; border-collapse: collapse; }
        .identity-table td { padding: 2px 5px; line-height: 1.12; border: 1px solid #777; }
        .identity-table .label { width: 32%; white-space: normal; }
        .identity-table .colon { width: 3%; }
        .identity-table .value { width: 65%; }
        .report-box-table { margin-top: 2px; margin-bottom: 3px; }
        .report-box-table td { padding: 2px 4px; line-height: 1.12; }
        .report-box-table .box-label { width: 34%; }
        .report-box-table .box-content { width: 66%; }
        .narrative-item { margin: 0 0 4px; page-break-inside: avoid; }
        .narrative-item-title { margin: 0; font-size: 12pt; font-weight: 700; line-height: 1.12; }
        .narrative-item-content { margin: 0 0 2px; font-size: 12pt; line-height: 1.12; text-align: justify; overflow-wrap: anywhere; }
        .signature-table td { padding: 0 8px; line-height: 1.12; }
        .signature-table p { margin: 0; line-height: 1.12; }
        .signature-table { margin-top: 3px; }
        .signature-space { height: 28px; }
        .confidential { margin-top: 4px; }
        .page-break {
            page-break-after: always !important;
            break-after: page !important;
        }
        @endif
    </style>
</head>
<body>
    @if ($autoPrint ?? false)
        <div class="print-tools">
            <button type="button" onclick="window.print()">Cetak / Simpan PDF</button>
        </div>
    @endif

    @forelse ($reports as $report)
        @php
            $konseling = $report['konseling'];
            $jadwal = $report['jadwal'];
            $isKelompok = $report['isKelompok'];
            $tanggalLayanan = $report['tanggalLayanan'];
            $durasiMenit = $report['durasiMenit'];
            $semester = $report['semester'];
            $tahunPelajaran = $report['tahunPelajaran'];
            $guruBk = $report['guruBk'];
            $tempatLayanan = $report['tempatLayanan'];
            $tanggalTtd = $report['tanggalTtd'] ?? (\Carbon\Carbon::parse($konseling->tanggal)->locale('id')->translatedFormat('d F Y'));
        @endphp
        <main class="document {{ !$loop->last ? 'page-break' : '' }}">
            <table class="kop">
                <tr>
                    <td class="kop-logo">
                        @if (!empty($pdfMode))
                            @if (!empty($logoBase64))
                                <img src="{{ $logoBase64 }}" alt="Logo SMP Negeri 2 Dramaga">
                            @else
                                <div class="logo-placeholder">LOGO</div>
                            @endif
                        @else
                            <img src="{{ !empty($logoBase64) ? $logoBase64 : asset('images/logo-smpn2-dramaga-cropped.jpg') }}" alt="Logo SMP Negeri 2 Dramaga">
                        @endif
                    </td>
                    <td class="kop-text">
                        <p class="kabupaten">PEMERINTAH KABUPATEN BOGOR</p>
                        <p class="dinas">DINAS PENDIDIKAN</p>
                        <p class="sekolah">SMP NEGERI 2 DRAMAGA</p>
                        <p class="alamat">Jl. Raya Dramaga KM. 07, Kec. Dramaga, Kab. Bogor, Jawa Barat 16680</p>
                    </td>
                    <td class="kop-balance"></td>
                </tr>
            </table>

            <header class="document-title">
                <h1>LAPORAN PELAKSANAAN LAYANAN BIMBINGAN DAN KONSELING</h1>
                <p>{{ $isKelompok ? 'BIMBINGAN KELOMPOK' : 'KONSELING INDIVIDU' }}</p>
                <p class="semester">SEMESTER {{ strtoupper($semester) }} TAHUN PELAJARAN {{ $tahunPelajaran }}</p>
            </header>

            <section>
                <p class="section-title">A. IDENTITAS &amp; SPESIFIKASI LAYANAN</p>
                <table class="identity-table">
                    @if ($isKelompok)
                        <tr>
                            <td class="label">Topik Permasalahan / Bahasan</td>
                            <td class="colon">:</td>
                            <td class="value">{{ $konseling->masalah ?: ($konseling->jenisMasalah->nama_jenis ?? '-') }}</td>
                        </tr>
                        <tr>
                            <td class="label">Bidang Bimbingan</td>
                            <td class="colon">:</td>
                            <td class="value">{{ $konseling->jenisMasalah->nama_jenis ?? 'Pribadi / Sosial / Belajar / Karier' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Hari, Tanggal Pelaksanaan</td>
                            <td class="colon">:</td>
                            <td class="value">{{ $tanggalLayanan }}</td>
                        </tr>
                        <tr>
                            <td class="label">Waktu / Durasi</td>
                            <td class="colon">:</td>
                            <td class="value">{{ $jadwal?->waktu_mulai ? substr($jadwal->waktu_mulai, 0, 5) . '–' . substr($jadwal->waktu_selesai, 0, 5) . ' WIB' . ($durasiMenit ? ' (' . $durasiMenit . ' menit)' : '') : '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Tempat Layanan</td>
                            <td class="colon">:</td>
                            <td class="value">{{ $tempatLayanan }}</td>
                        </tr>
                        <tr>
                            <td class="label">Guru BK / Konselor</td>
                            <td class="colon">:</td>
                            <td class="value">{{ $guruBk->nama ?? '-' }}</td>
                        </tr>
                    @else
                        <tr>
                            <td class="label">Nama Siswa (Konseli)</td>
                            <td class="colon">:</td>
                            <td class="value">{{ $konseling->siswa->nama_siswa ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Kelas / NIS</td>
                            <td class="colon">:</td>
                            <td class="value">{{ $konseling->siswa->kelas->nama_kelas ?? '-' }} / {{ $konseling->siswa->nis ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Hari, Tanggal Pelaksanaan</td>
                            <td class="colon">:</td>
                            <td class="value">{{ $tanggalLayanan }}</td>
                        </tr>
                        <tr>
                            <td class="label">Waktu / Durasi</td>
                            <td class="colon">:</td>
                            <td class="value">{{ $jadwal?->waktu_mulai ? substr($jadwal->waktu_mulai, 0, 5) . '–' . substr($jadwal->waktu_selesai, 0, 5) . ' WIB' . ($durasiMenit ? ' (' . $durasiMenit . ' menit)' : '') : '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Tempat Layanan</td>
                            <td class="colon">:</td>
                            <td class="value">{{ $tempatLayanan }}</td>
                        </tr>
                        <tr>
                            <td class="label">Guru BK / Konselor</td>
                            <td class="colon">:</td>
                            <td class="value">{{ $guruBk->nama ?? '-' }}</td>
                        </tr>
                    @endif
                </table>

                @if ($isKelompok)
                    <p class="narrative-label" style="margin-top: 4px; font-weight: bold;">Anggota Kelompok</p>
                    <table class="member-table">
                        <thead><tr><th class="number">No</th><th>Nama Siswa</th><th class="class">Kelas</th></tr></thead>
                        <tbody>
                            <tr><td class="number">1</td><td>{{ $konseling->siswa->nama_siswa ?? '' }}</td><td>{{ $konseling->siswa->kelas->nama_kelas ?? '' }}</td></tr>
                            @for ($i = 2; $i <= 6; $i++)
                                <tr><td class="number">{{ $i }}</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                            @endfor
                        </tbody>
                    </table>
                @endif
            </section>

            <section>
                <p class="section-title">B. URAIAN PROSES &amp; HASIL KONSELING</p>
                @if (!empty($pdfMode))
                    <div class="narrative-item">
                        <p class="narrative-item-title">1. Gejala yang Nampak / Masalah yang Dihadapi</p>
                        <p class="narrative-item-content">{{ $konseling->masalah ?: '-' }}</p>
                    </div>
                    <div class="narrative-item">
                        <p class="narrative-item-title">2. Pendekatan dan Teknik Konseling yang Digunakan</p>
                        <p class="narrative-item-content">{{ $konseling->catatan ?: '-' }}</p>
                    </div>
                    <div class="narrative-item">
                        <p class="narrative-item-title">3. Hasil Konseling yang Dicapai</p>
                        <p class="narrative-item-content">{{ $konseling->hasil_konseling ?: '-' }}</p>
                    </div>
                    <div class="narrative-item">
                        <p class="narrative-item-title">4. Diagnosis / Kesimpulan Asesmen</p>
                        <p class="narrative-item-content">{{ $konseling->diagnosis ?: '-' }}</p>
                    </div>
                    <div class="narrative-item">
                        <p class="narrative-item-title">5. Rencana Tindak Lanjut</p>
                        <div class="narrative-item-content">
                            @php $tindakLanjutList = $konseling->tindakLanjut ?? collect(); @endphp
                            @if (filled($konseling->rencana_tindak_lanjut))
                                {{ $konseling->rencana_tindak_lanjut }}
                            @elseif ($tindakLanjutList->isNotEmpty())
                                @foreach ($tindakLanjutList as $index => $tindak)
                                    <div>{{ $tindakLanjutList->count() > 1 ? ($index + 1) . '. ' : '' }}{{ $tindak->tanggal ? \Carbon\Carbon::parse($tindak->tanggal)->format('d-m-Y') . ' — ' : '' }}{{ $tindak->tindakan }}{{ $tindak->keterangan ? ': ' . $tindak->keterangan : '' }}</div>
                                @endforeach
                            @else
                                -
                            @endif
                        </div>
                    </div>
                @else
                <table class="report-box-table">
                    <tr>
                        <td class="box-label">1. Gejala yang Nampak / Masalah yang Dihadapi</td>
                        <td class="box-content">{{ $konseling->masalah ?: '-' }}</td>
                    </tr>
                    <tr>
                        <td class="box-label">2. Pendekatan dan Teknik Konseling yang Digunakan</td>
                        <td class="box-content">{{ $konseling->catatan ?: '-' }}</td>
                    </tr>
                    <tr>
                        <td class="box-label">3. Hasil Konseling yang Dicapai</td>
                        <td class="box-content">{{ $konseling->hasil_konseling ?: '-' }}</td>
                    </tr>
                    <tr>
                        <td class="box-label">4. Diagnosis / Kesimpulan Asesmen</td>
                        <td class="box-content">{{ $konseling->diagnosis ?: '-' }}</td>
                    </tr>
                    <tr>
                        <td class="box-label">5. Rencana Tindak Lanjut</td>
                        <td class="box-content">
                            @php
                                $tindakLanjutList = $konseling->tindakLanjut ?? collect();
                            @endphp
                            @if (filled($konseling->rencana_tindak_lanjut))
                                {{ $konseling->rencana_tindak_lanjut }}
                            @elseif ($tindakLanjutList->isNotEmpty())
                                @foreach ($tindakLanjutList as $index => $tindak)
                                    <div style="{{ !$loop->last ? 'margin-bottom: 2px;' : '' }}">
                                        {{ $tindakLanjutList->count() > 1 ? ($index + 1) . '. ' : '' }}{{ $tindak->tanggal ? \Carbon\Carbon::parse($tindak->tanggal)->format('d-m-Y') . ' — ' : '' }}{{ $tindak->tindakan }}{{ $tindak->keterangan ? ': ' . $tindak->keterangan : '' }}
                                    </div>
                                @endforeach
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                </table>
                @endif
            </section>

            <section>
                <p class="section-title">C. LEMBAR TANDA TANGAN PENGESAHAN</p>
                <table class="signature-table">
                    <tr>
                        <td>
                            <p>Mengetahui,<br>Kepala SMP Negeri 2 Dramaga</p>
                            <div class="signature-space"></div>
                            <p class="signer-dots">....................................................</p>
                            <p class="signer-nip">NIP. ....................................................</p>
                        </td>
                        <td>
                            <p>Dramaga, {{ $tanggalTtd }}<br>Guru Bimbingan Konseling,</p>
                            <div class="signature-space"></div>
                            <p class="signer-name">{{ $guruBk->nama ?? '....................................................' }}</p>
                            <p class="signer-nip">NIP. ....................................................</p>
                        </td>
                    </tr>
                </table>
                <p class="confidential">Dokumen ini memuat informasi layanan bimbingan dan konseling yang bersifat rahasia.</p>
            </section>
        </main>
    @empty
        <main class="document"><p>Tidak ada data konseling untuk filter yang dipilih.</p></main>
    @endforelse
    @if ($autoPrint ?? false)
        <script>
            window.addEventListener('load', function () {
                window.setTimeout(function () { window.print(); }, 500);
            });
        </script>
    @endif
</body>
</html>
