<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Hasil Konseling</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; padding: 32px; font: 14px Arial, sans-serif; color: #17243d; }
        .sheet { max-width: 1100px; margin: 0 auto; }
        h1 { margin: 0 0 8px; color: #173c91; font-size: 24px; }
        .meta { margin: 0 0 24px; color: #52617a; line-height: 1.6; }
        .print-actions { margin-bottom: 20px; text-align: right; }
        .print-actions button { border: 0; border-radius: 8px; padding: 10px 16px; background: #173c91; color: #fff; font-weight: 700; cursor: pointer; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #d8e0ec; text-align: left; vertical-align: top; }
        th { background: #173c91; color: #fff; }
        tbody tr:nth-child(even) { background: #f5f7fb; }
        .empty { padding: 24px; border: 1px solid #d8e0ec; border-radius: 10px; color: #52617a; text-align: center; }
        @media print {
            body { padding: 0; }
            .print-actions { display: none; }
            @page { size: A4 landscape; margin: 14mm; }
        }
        @media (max-width: 700px) {
            body { padding: 16px; }
            .sheet { overflow-x: auto; }
            table { min-width: 760px; }
        }
    </style>
</head>
<body>
    <main class="sheet">
        @if ($showPrintButton ?? true)
            <div class="print-actions"><button type="button" onclick="window.print()">Cetak Laporan</button></div>
        @endif
        <h1>Laporan Hasil Konseling</h1>
        <p class="meta">
            Periode: {{ \Carbon\Carbon::parse($tanggalMulai)->format('d-m-Y') }} s.d. {{ \Carbon\Carbon::parse($tanggalAkhir)->format('d-m-Y') }}<br>
            Kelas: {{ $labelKelas }} &middot; Siswa: {{ $labelSiswa }}
        </p>

        @if ($konseling->isEmpty())
            <div class="empty">Tidak ada data konseling berdasarkan parameter yang dipilih.</div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Jenis Masalah</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($konseling as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') : '-' }}</td>
                            <td>{{ $item->siswa->nama_siswa ?? '-' }}</td>
                            <td>{{ $item->siswa->kelas->nama_kelas ?? '-' }}</td>
                            <td>{{ $item->jenisMasalah->nama_jenis ?? '-' }}</td>
                            <td>{{ $item->status ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </main>
</body>
</html>
