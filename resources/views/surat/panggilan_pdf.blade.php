<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <style>
        @page {
            size: A4;
            margin: 15mm 20mm 15mm 20mm;
        }

        * {
            font-family: 'Times New Roman', Times, serif;
        }

        body {
            margin: 0;
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            color: #000000;
        }

        .kop {
            position: relative;
            width: 100%;
            border-bottom: 2.5px solid #000000;
            padding-bottom: 8px;
        }

        .kop-logo {
            position: absolute;
            left: 0;
            top: 2px;
            width: 75px;
            height: 69px;
            overflow: hidden;
        }

        .kop-logo img {
            display: block;
            width: 290px;
            height: 224px;
            margin-left: -107px;
            margin-top: -45px;
        }

        .kop-text {
            width: 100%;
            text-align: center;
        }

        .kop-text h1 {
            margin: 0;
            font-family: 'Times New Roman', Times, serif;
            font-size: 13pt;
            font-weight: bold;
            line-height: 1.25;
            text-align: center;
        }

        .kop-text h2 {
            margin: 3px 0;
            font-family: 'Times New Roman', Times, serif;
            font-size: 14pt;
            font-weight: bold;
            line-height: 1.25;
            text-align: center;
        }

        .kop-text p {
            margin: 2px 0 0;
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            text-align: center;
        }

        .judul {
            text-align: center;
            margin-top: 20px;
        }

        .judul h3 {
            margin: 0;
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            font-weight: bold;
            text-decoration: underline;
            text-align: center;
        }

        .judul p {
            margin-top: 4px;
            margin-bottom: 0;
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            text-align: center;
        }

        .isi {
            margin-top: 20px;
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.5;
        }

        .identitas {
            margin: 10px 0 12px 30px;
        }

        .identitas table {
            border-collapse: collapse;
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
        }

        .identitas td {
            padding: 2px 0;
            vertical-align: top;
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
        }

        .label {
            width: 110px;
        }

        .separator {
            width: 20px;
        }

        p {
            text-align: justify;
            margin: 0 0 10px;
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.5;
        }

        .isi p {
            text-align: justify;
            margin: 0 0 10px;
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.5;
        }

        .ttd {
            width: 250px;
            margin-left: auto;
            margin-top: 30px;
            text-align: center;
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
        }

        .ttd p {
            margin: 0 0 4px;
            text-align: center;
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
        }

        .ttd-space {
            height: 60px;
        }

        .ttd-nama {
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="kop">

        <div class="kop-logo">
            <img
                src="{{ public_path('images/logo-smpn2-dramaga.png') }}"
                alt="Logo"
            >
        </div>

        <div class="kop-text">
            <h1>PEMERINTAH KABUPATEN BOGOR</h1>
            <h2>SMP NEGERI 2 DRAMAGA</h2>
            <p>Jl. Raya Dramaga Km 7 Dramaga Bogor Kode Pos 16680</p>
        </div>

    </div>

    <div class="judul">
        <h3>SURAT PANGGILAN ORANG TUA/WALI</h3>
        <p>Nomor: .................................</p>
    </div>

    <div class="isi">

        <p>
            Yth. Bapak/Ibu Orang Tua/Wali dari:
        </p>

        <div class="identitas">
            <table>
                <tr>
                    <td class="label">Nama Siswa</td>
                    <td class="separator">:</td>
                    <td><strong>{{ $siswa->nama_siswa }}</strong></td>
                </tr>

                <tr>
                    <td class="label">NIS</td>
                    <td class="separator">:</td>
                    <td>{{ $siswa->nis }}</td>
                </tr>

                <tr>
                    <td class="label">Kelas</td>
                    <td class="separator">:</td>
                    <td>
                        @if(str_starts_with($siswa->kelas->nama_kelas ?? '', (string)($siswa->kelas->tingkat ?? '')))
                            {{ $siswa->kelas->nama_kelas ?? '-' }}
                        @else
                            {{ $siswa->kelas->tingkat ?? '-' }} {{ $siswa->kelas->nama_kelas ?? '' }}
                        @endif
                    </td>
                </tr>
            </table>
        </div>

        <p>
            Dengan hormat,
        </p>

        <p>
            Sehubungan dengan hasil pemantauan dan pelaksanaan layanan
            bimbingan dan konseling di sekolah, kami bermaksud mengundang
            Bapak/Ibu Orang Tua/Wali untuk hadir ke sekolah guna membicarakan
            perkembangan serta tindak lanjut bimbingan terhadap putra/putri
            Bapak/Ibu.
        </p>

        <p>
            Berdasarkan data pada Sistem Informasi Riwayat dan Administrasi
            Bimbingan Konseling, siswa tersebut telah mengikuti
            <strong>{{ $totalKonseling }} sesi konseling</strong>.
        </p>

        <p>
            Oleh karena itu, kami mengharapkan kehadiran Bapak/Ibu untuk dapat
            berdiskusi bersama Guru Bimbingan dan Konseling mengenai
            perkembangan siswa dan langkah pembinaan yang diperlukan.
        </p>

        <div class="identitas">
            <table>
                <tr>
                    <td class="label">Hari/Tanggal</td>
                    <td class="separator">:</td>
                    <td>................................................</td>
                </tr>

                <tr>
                    <td class="label">Waktu</td>
                    <td class="separator">:</td>
                    <td>................................................</td>
                </tr>

                <tr>
                    <td class="label">Tempat</td>
                    <td class="separator">:</td>
                    <td>Ruang Bimbingan dan Konseling</td>
                </tr>
            </table>
        </div>

        <p>
            Demikian surat panggilan ini kami sampaikan. Atas perhatian dan
            kerja sama Bapak/Ibu, kami ucapkan terima kasih.
        </p>

    </div>

    <div class="ttd">

        <p>
            Dramaga, {{ date('d/m/Y') }}
        </p>

        <p>
            Guru Bimbingan dan Konseling
        </p>

        <div class="ttd-space"></div>

        <p class="ttd-nama">
            ........................................
        </p>

        <p>
            NIP. ....................................
        </p>

    </div>

</body>
</html>
