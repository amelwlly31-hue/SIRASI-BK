# SIRASI-BK
**Sistem Informasi Riwayat Administrasi dan Penjadwalan Bimbingan Konseling Siswa**  
**SMP Negeri 2 Dramaga, Kabupaten Bogor**

SIRASI-BK adalah aplikasi web berbasis **Laravel & MySQL** yang dirancang untuk mendukung operasional layanan Bimbingan dan Konseling (BK) di SMP Negeri 2 Dramaga. Sistem ini memfasilitasi integrasi kolaboratif antara **Admin**, **Guru BK**, **Wali Kelas**, dan **Siswa** dengan tetap menjunjung tinggi prinsip kerahasiaan (*Least Privilege*) catatan kasus konseling siswa.

---

## Fitur Utama Sistem

1. **Autentikasi Multi-Peran & Tiga Dashboard Khusus**:
   - **Admin**: Manajemen akun pengguna, data master siswa, kalender bimbingan, dan rekapitulasi data sekolah.
   - **Guru BK**: Pencatatan sesi konseling kasus, tindak lanjut evaluasi, pelaporan rekap masalah, dan pembuatan surat panggilan resmi.
   - **Wali Kelas**: Pemantauan siswa kelas binaan serta verifikasi persetujuan/penolakan pengajuan konseling siswa.
2. **Portal Pengajuan Konseling Mandiri Siswa (`/portal-siswa`)**:
   - Masuk mandiri berbasis verifikasi **Nomor Induk Siswa (NIS)** tanpa perlu registrasi akun staf.
   - Pemeriksaan jadwal Guru BK yang sudah terisi (*live slot lookup*) untuk menghindari pemilihan jam sibuk.
   - Formulir pengajuan bimbingan mandiri dan pelacakan status bertingkat secara transparan.
3. **Persetujuan Bertingkat Wali Kelas (*Multi-Class Isolation*)**:
   - Pengajuan siswa wajib diverifikasi oleh Wali Kelas binaannya sebelum ditetapkan jadwal resminya oleh Guru BK.
   - Isolasi data kelas yang ketat menjamin Wali Kelas hanya dapat melihat dan memproses siswa dari kelas yang ditugaskan.
4. **Validasi Anti-Bentrok Jadwal Guru BK (*Concurrency Safe*)**:
   - Mencegah jadwal bimbingan yang tumpang tindih waktu (*overlapping*) pada tanggal yang sama.
   - Penguncian baris basis data (`lockForUpdate`) dalam transaksi (`DB::transaction`) untuk mencegah jadwal ganda saat pengajuan bersamaan.
   - Otomatis membebaskan slot jam saat jadwal dibatalkan atau ditolak.
5. **Proteksi Privasi & Integritas Data (*Least Privilege*)**:
   - Catatan sensitif kasus konseling hanya dapat diakses oleh Guru BK (Admin dan Wali Kelas diblokir dengan HTTP 403 Forbidden).
   - Data master siswa terlindungi dari penghapusan sembarangan jika siswa telah memiliki riwayat konseling.

---

## Kredensial Pengujian Cepat (*Default Demo Accounts*)

| Peran (Role) | Username / Login | Password | Penugasan Kelas / NIS |
| :--- | :--- | :--- | :--- |
| **Admin** | `admin` | `password123` | Administrator Sistem |
| **Guru BK** | `gurubk` | `password123` | Ruang BK SMPN 2 Dramaga |
| **Wali Kelas** | `walikelas71` | `password123` | Wali Kelas `7.1` |
| **Siswa (Portal)** | NIS: `70701` | *Tanpa Password* | Andi Pratama (Kelas 7.7) |
| **Siswa (Portal)** | NIS: `095431` | *Tanpa Password* | Amel (Kelas 9.10) |

---

## Petunjuk Instalasi & Menjalankan Aplikasi

### 1. Persyaratan Sistem
- PHP $\ge$ 8.0 dengan ekstensi `pdo_mysql`, `mbstring`, `openssl`, `gd`, `zip`.
- MySQL Server $\ge$ 5.7 atau MariaDB (tersedia di XAMPP).
- Composer.

### 2. Konfigurasi Basis Data
Salin `.env.example` ke `.env` dan sesuaikan koneksi basis data:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sirasi_bk
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Menjalankan Server Aplikasi
Jalankan perintah berikut di terminal:
```bash
php artisan serve
```
Akses aplikasi melalui browser:
- Halaman Login Staf: `http://127.0.0.1:8000/login`
- Portal Pengajuan Siswa: `http://127.0.0.1:8000/portal-siswa`

---

## Menjalankan Pengujian Otomatis (*Automated Testing*)

Aplikasi dilengkapi dengan rangkaian pengujian fitur otomatis (*Feature Tests*) dengan cakupan menyeluruh:
```bash
# Menjalankan seluruh 41 test cases (100% PASS)
php artisan test
```

Pengujian per modul:
```bash
# Uji Integrasi Menyeluruh Lintas Peran
php artisan test --filter=SystemIntegrationTest

# Uji Validasi Anti-Bentrok Jadwal
php artisan test --filter=AntiBentrokJadwalTest

# Uji Alur Persetujuan Wali Kelas
php artisan test --filter=WaliKelasApprovalTest

# Uji Portal Siswa Mandiri
php artisan test --filter=PortalSiswaTest
```

---

## Dokumentasi Proyek Lengkap

Dokumentasi terperinci telah disediakan pada direktori `docs/`:
- [`docs/DOKUMENTASI_SISTEM.md`](docs/DOKUMENTASI_SISTEM.md): Arsitektur sistem, struktur fitur, skema basis data, dan peta rute.
- [`docs/SKENARIO_PENGUJIAN_UAT.md`](docs/SKENARIO_PENGUJIAN_UAT.md): Matriks pengujian User Acceptance Testing (UAT) untuk seluruh peran, fitur teruji vs belum teruji, dan catatan kendala.
- [`docs/PANDUAN_PENGUJIAN.md`](docs/PANDUAN_PENGUJIAN.md): Panduan langkah demi langkah menjalankan pengujian otomatis dan simulasi pengujian manual di browser.
