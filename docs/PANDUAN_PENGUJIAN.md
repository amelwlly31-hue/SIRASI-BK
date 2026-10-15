# PANDUAN MENJALANKAN PENGUJIAN SISTEM SIRASI-BK
**Sistem Informasi Riwayat Administrasi dan Penjadwalan Bimbingan Konseling Siswa**  
**SMP Negeri 2 Dramaga, Kabupaten Bogor**

---

## 1. Persiapan Lingkungan Uji Coba

Sebelum menjalankan pengujian otomatis maupun uji coba manual di browser:

1. **Pastikan Web Server Apache & Basis Data MySQL Berjalan**:
   - Buka **XAMPP Control Panel**, lalu pastikan modul **Apache** dan **MySQL** berstatus *Running* (port standar: 80/443 untuk Apache dan 3306 untuk MySQL).
   - Atau melalui terminal PowerShell:
     ```powershell
     # Memastikan MySQL berjalan
     c:\xampp\mysql\bin\mysqld.exe --defaults-file="c:\xampp\mysql\bin\my.ini" --standalone
     ```

2. **Periksa Konfigurasi Database di `.env`**:
   Pastikan konfigurasi koneksi basis data pada berkas `.env` sesuai dengan basis data lokal:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=sirasi_bk
   DB_USERNAME=root
   DB_PASSWORD=
   ```

---

## 2. Menjalankan Pengujian Otomatis (*Automated Feature Testing*)

Sistem SIRASI-BK dilengkapi dengan test suite lengkap berbasis PHPUnit / Laravel Test Runner untuk memastikan seluruh alur dan otorisasi berfungsi sempurna.

### A. Menjalankan Seluruh Pengujian (41 Test Cases)
Buka terminal PowerShell pada direktori proyek (`c:\xampp\htdocs\SIRASI-BK`), lalu jalankan:

```powershell
php artisan test
```

**Hasil yang Diharapkan:**
```text
   PASS  Tests\Unit\ExampleTest
   PASS  Tests\Feature\AntiBentrokJadwalTest
   PASS  Tests\Feature\DashboardAndUserManagementTest
   PASS  Tests\Feature\ExampleTest
   PASS  Tests\Feature\PortalSiswaTest
   PASS  Tests\Feature\RoleAuthorizationTest
   PASS  Tests\Feature\SystemIntegrationTest
   PASS  Tests\Feature\WaliKelasApprovalTest

   Tests:  41 passed
```

### B. Menjalankan Pengujian Spesifik per Modul
Anda dapat menjalankan pengujian per berkas modul secara terpisah:

- **Pengujian Integrasi Menyeluruh Lintas Peran**:
  ```powershell
  php artisan test --filter=SystemIntegrationTest
  ```
- **Pengujian Logika Anti-Bentrok Jadwal Guru BK**:
  ```powershell
  php artisan test --filter=AntiBentrokJadwalTest
  ```
- **Pengujian Alur Persetujuan Wali Kelas**:
  ```powershell
  php artisan test --filter=WaliKelasApprovalTest
  ```
- **Pengujian Portal Mandiri Siswa**:
  ```powershell
  php artisan test --filter=PortalSiswaTest
  ```
- **Pengujian Hak Akses & Matriks Otorisasi Role**:
  ```powershell
  php artisan test --filter=RoleAuthorizationTest
  ```

---

## 3. Langkah Uji Coba Manual di Web Browser (*Live Walkthrough*)

Untuk menguji aplikasi secara langsung melalui browser (misal: Google Chrome atau Microsoft Edge):

### Langkah 1: Jalankan Server Pengembangan Lokal
Jalankan perintah berikut di terminal:
```powershell
php artisan serve
```
Aplikasi akan dapat diakses melalui URL: `http://127.0.0.1:8000` (atau melalui `http://localhost/SIRASI-BK/public/`).

---

### Langkah 2: Skenario Uji Coba 1 — Pengajuan Siswa Mandiri
1. Buka browser dan arahkan ke alamat:  
   `http://127.0.0.1:8000/portal-siswa`
2. Pada form masuk siswa, ketikkan salah satu NIS aktif, misalnya:  
   **NIS**: `70701` (Nama Siswa: Andi Pratama, Kelas 7.7)  
   Lalu klik tombol **"Masuk ke Portal Siswa"**.
3. Sistem akan membuka dashboard siswa. Periksa nama siswa dan kelas binaannya.
4. Pilih tanggal konseling (misalnya tanggal 2 hari ke depan). Perhatikan bagian **"Slot Jadwal Guru BK yang Sudah Terisi"** untuk melihat ketersediaan jam.
5. Isi formulir pengajuan:
   - **Jam Mulai**: `09:00`
   - **Jam Selesai**: `10:00`
   - **Jenis Layanan**: Pilih salah satu (misal: *Konseling Belajar*)
   - **Alasan / Catatan**: Tulis kebutuhan konseling Anda.
   - Klik **"Kirim Pengajuan Bimbingan"**.
6. Pada kolom kanan, periksa daftar **"Status Pengajuan Konseling Saya"**. Pengajuan baru akan tampil dengan badge status **"Diajukan (Menunggu Persetujuan Wali Kelas)"**.
7. Klik tombol **"Keluar Sesi Siswa"**.

---

### Langkah 3: Skenario Uji Coba 2 — Evaluasi & Persetujuan oleh Wali Kelas
*(Catatan: Sebelum menguji, pastikan akun wali kelas ditugaskan memegang kelas siswa pemohon. Misalnya siswa kelas 7.7 ditugaskan ke wali kelas yang bersangkutan)*.

1. Buka browser dan arahkan ke alamat:  
   `http://127.0.0.1:8000/login`
2. Masuk menggunakan akun Wali Kelas:
   - **Username**: `walikelas71`
   - **Password**: `password123`
3. Periksa halaman **Dashboard Wali Kelas**: Menampilkan jumlah siswa binaan dan rekap pengajuan bimbingan.
4. Buka menu samping **"Persetujuan Pengajuan"** (`/wali-kelas/pengajuan`).
5. Periksa pengajuan siswa yang tadi dikirim.
6. Berikan respon:
   - **Untuk Menyetujui**: Klik tombol centang hijau **"Setujui"**, tambahkan catatan koordinasi guru mata pelajaran jika perlu, lalu konfirmasi. Status pengajuan akan berubah menjadi **"Disetujui_Wali"**.
   - **Untuk Menolak**: Klik tombol silang merah **"Tolak"**, ketikkan alasan penolakan wajib (misal: *Siswa sedang ada ujian praktik*), lalu konfirmasi. Status pengajuan akan berubah menjadi **"Ditolak_Wali"** dan slot jam akan langsung terbuka kembali.
7. Logout dari akun Wali Kelas.

---

### Langkah 4: Skenario Uji Coba 3 — Konfirmasi Jadwal & Pencatatan oleh Guru BK
1. Buka `http://127.0.0.1:8000/login` dan masuk sebagai Guru BK:
   - **Username**: `gurubk`
   - **Password**: `password123`
2. Periksa **Dashboard Guru BK**: Memuat grafik kategori masalah siswa, rekap kasus bulanan, dan pengingat jadwal bimbingan.
3. Buka menu **"Penjadwalan"** (`/penjadwalan`):
   - Jadwal yang telah disetujui wali kelas berstatus **"Disetujui_Wali"**.
   - Klik tombol **Edit** pada jadwal tersebut, ubah statusnya menjadi **"Terjadwal"**, lalu klik **Simpan**.
4. Buka menu **"Data Konseling"** (`/konseling`):
   - Klik tombol **"Tambah Konseling"** (`/konseling/create`).
   - Pilih siswa bersangkutan, masukkan jenis masalah, hasil konseling, dan catatan.
   - Klik **Simpan**.
5. Pada halaman rincian konseling, coba klik tombol **"Tambah Tindak Lanjut"** untuk mencatat evaluasi perkembangan siswa.
6. Logout dari akun Guru BK.

---

### Langkah 5: Skenario Uji Coba 4 — Verifikasi Akhir oleh Siswa di Portal
1. Buka kembali `http://127.0.0.1:8000/portal-siswa`.
2. Masukkan NIS siswa yang sama (`70701`).
3. Periksa bagian riwayat pengajuan:
   - Status pengajuan telah terupdate menjadi **"Terjadwal"** dengan konfirmasi resmi Guru BK.
   - Catatan respon dari Wali Kelas tercantum secara transparan.

---

### Langkah 6: Skenario Uji Coba 5 — Pengelolaan Akun & Data Master oleh Admin
1. Buka `http://127.0.0.1:8000/login` dan masuk sebagai Administrator:
   - **Username**: `admin`
   - **Password**: `password123`
2. Periksa **Dashboard Admin**: Berfokus pada data statistik akun pengguna dan master kesiswaan.
3. Buka menu **"Manajemen Pengguna"** (`/users`):
   - Coba buat akun baru untuk Wali Kelas lain (misal: Wali Kelas 7.7).
   - Uji validasi duplikasi username.
4. Buka menu **"Data Siswa"** (`/siswa`):
   - Periksa bahwa Admin dapat menambah, mengedit biodata, dan mengubah status siswa aktif/nonaktif.
   - Perhatikan bahwa Admin **tidak memiliki tombol "Lihat Detail" (mata)** untuk membaca riwayat catatan kasus siswa.
5. Coba buka URL rahasia konseling secara langsung: `http://127.0.0.1:8000/konseling`.
   - Sistem akan langsung menampilkan halaman **403 Forbidden** (Hak Akses Ditolak).
