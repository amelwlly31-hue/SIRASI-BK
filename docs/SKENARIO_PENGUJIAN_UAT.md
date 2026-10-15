# MATRIKS SKENARIO PENGUJIAN & UJI COBA (UAT) SIRASI-BK
**Sistem Informasi Riwayat Administrasi dan Penjadwalan Bimbingan Konseling Siswa**  
**SMP Negeri 2 Dramaga, Kabupaten Bogor**

Dokumen ini memuat skenario pengujian komprehensif untuk validasi fungsional sistem, keamanan data (*Least Privilege*), dan integritas operasional lintas peran.

---

## 1. Kredensial Uji Coba Default Sistem

Untuk memfasilitasi pengujian manual pada lingkungan lokal, gunakan akun-akun resmi yang telah disediakan pada basis data sistem:

| Peran (Role) | Username | Password | Penugasan / NIS | Keterangan |
| :--- | :--- | :--- | :--- | :--- |
| **Admin** | `admin` | `password123` | - | Hak penuh manajemen pengguna & master siswa. |
| **Guru BK** | `gurubk` | `password123` | - | Hak penuh operasional konseling, jadwal, & laporan. |
| **Wali Kelas** | `walikelas71` | `password123` | Kelas `7.1` (ID: 1) | Khusus persetujuan & monitoring siswa kelas 7.1. |
| **Siswa (Portal)** | *Tidak Perlu* | *Tanpa Password*| NIS: `70701` | Siswa aktif (Andi Pratama, Kelas 7.7). |
| **Siswa (Portal)** | *Tidak Perlu* | *Tanpa Password*| NIS: `095431` | Siswa aktif (Amel, Kelas 9.10). |

> [!NOTE]
> Siswa masuk ke Portal Mandiri di `/portal-siswa` hanya dengan memverifikasi Nomor Induk Siswa (NIS) aktif tanpa memerlukan akun password sistem.

---

## 2. Matriks Skenario Uji Coba Berdasarkan Peran

### A. Peran Administrator (`admin`)

| ID Uji | Fitur / Fungsi | Langkah Pengujian | Data Masukan Uji | Hasil yang Diharapkan | Status Pengujian |
| :--- | :--- | :--- | :--- | :--- | :---: |
| **ADM-01** | Login Admin | Masuk ke `/login` dengan kredensial admin | User: `admin`, Pass: `password123` | Berhasil login, dialihkan ke `/dashboard` tampilan khusus Admin (metrik user & master data). | **PASS (Otomatis)** |
| **ADM-02** | Tambah Akun Pengguna | Masuk ke `/users/create`, isi formulir, klik simpan | Nama: "Wali 8.1", User: "wali81", Role: `wali_kelas`, Kelas: 8.1 | Akun tersimpan di tabel `users`, muncul flash success di daftar pengguna `/users`. | **PASS (Otomatis)** |
| **ADM-03** | Validasi Duplikasi Username | Tambah user dengan username yang sudah ada | User: `admin` | Formulir ditolak dengan pesan error validasi "Username sudah terdaftar". | **PASS (Otomatis)** |
| **ADM-04** | Edit & Nonaktifkan User | Buka `/users/{id}/edit`, ubah data user | Edit nama pengguna | Data terupdate di database dan daftar pengguna. | **PASS (Otomatis)** |
| **ADM-05** | Tambah Siswa Baru | Buka `/siswa/create`, isi data siswa lengkap | NIS: "88801", Nama: "Siswa Baru", Kelas: 7.1 | Siswa tersimpan di tabel `siswa`, notifikasi siswa baru dibuat. | **PASS (Otomatis)** |
| **ADM-06** | Toggle Status Siswa | Klik tombol toggle status pada baris siswa di `/siswa` | ID Siswa aktif | Status berubah menjadi "Tidak Aktif" (atau sebaliknya). | **PASS (Otomatis)** |
| **ADM-07** | Proteksi Hapus Siswa Berriwayat | Klik hapus siswa yang telah memiliki sesi konseling | Siswa yang memiliki catatan di tabel `konseling` | Penghapusan ditolak, muncul pesan peringatan bahwa siswa memiliki riwayat konseling. | **PASS (Otomatis)** |
| **ADM-08** | Proteksi Privasi Catatan Kasus | Admin mencoba membuka `/siswa/{id}` atau `/konseling` | URL langsung `/siswa/1` atau `/konseling` | **Akses ditolak (HTTP 403 Forbidden)**. Admin tidak dapat membaca catatan konseling privat. | **PASS (Otomatis)** |
| **ADM-09** | Import Excel Siswa | Upload berkas template Excel di `/siswa/import` | Berkas `.xlsx` sesuai template | Data siswa terimpor massal ke kelas tujuan. | **Butuh Uji Manual** |

---

### B. Peran Guru BK (`guru_bk`)

| ID Uji | Fitur / Fungsi | Langkah Pengujian | Data Masukan Uji | Hasil yang Diharapkan | Status Pengujian |
| :--- | :--- | :--- | :--- | :--- | :---: |
| **GBK-01** | Login Guru BK | Masuk ke `/login` dengan kredensial Guru BK | User: `gurubk`, Pass: `password123` | Berhasil login, dialihkan ke `/dashboard` dengan metrik statistik konseling & grafik kasus. | **PASS (Otomatis)** |
| **GBK-02** | Buat Jadwal Konseling Manual | Buka `/penjadwalan/create`, pilih siswa, jam mulai & selesai | Tgl: Besok, Jam: 08:00 - 09:00, Siswa: Andi Pratama | Jadwal tersimpan dengan status `Terjadwal`. | **PASS (Otomatis)** |
| **GBK-03** | Validasi Anti-Bentrok Jadwal | Buat jadwal kedua yang bertabrakan waktu dengan jadwal pertama | Tgl: Sama, Jam: 08:30 - 09:30 | Ditolak oleh server dengan pesan detail bentrok slot waktu dan nama siswa yang menempati. | **PASS (Otomatis)** |
| **GBK-04** | Jadwal Sambung (Back-to-Back)| Buat jadwal ketiga tepat di akhir jadwal pertama | Tgl: Sama, Jam: 09:00 - 10:00 | Berhasil disimpan tanpa bentrok karena batas akhir dan awal tepat bersentuhan. | **PASS (Otomatis)** |
| **GBK-05** | Finalisasi Pengajuan Disetujui | Buka `/penjadwalan`, edit pengajuan berstatus `Disetujui_Wali` | Ubah status menjadi `Terjadwal` | Status terupdate menjadi `Terjadwal`, jadwal resmi mengikat. | **PASS (Otomatis)** |
| **GBK-06** | Catat Hasil Sesi Konseling | Buka `/konseling/create`, pilih siswa, jenis masalah, isi hasil | Masalah: "Motivasi", Hasil: "Disepakati rencana belajar" | Rekam konseling tersimpan dengan status awal `Proses`. | **PASS (Otomatis)** |
| **GBK-07** | Catat Tindak Lanjut | Buka detail konseling, klik Tambah Tindak Lanjut | Tindakan: "Evaluasi mingguan", Keterangan: "Siswa patuh" | Tindak lanjut tersimpan dan terhubung ke konseling terkait. | **PASS (Otomatis)** |
| **GBK-08** | Laporan Rekapitulasi Kasus | Buka `/laporan`, filter berdasarkan periode tanggal / jenis masalah | Tanggal awal dan akhir bulan berjalan | Tabel menampilkan rekapitulasi sesi dan persentase jenis masalah. | **PASS (Otomatis)** |
| **GBK-09** | Cetak Surat Panggilan Ortu | Buka siswa berriwayat $\ge 3$ konseling, klik Surat Panggilan | Format PDF / DOCX | Dokumen surat resmi terunduh dengan kop sekolah SMPN 2 Dramaga. | **Butuh Uji Manual** |
| **GBK-10** | Pembatasan Hak Akses | Guru BK mencoba membuka menu manajemen user `/users` | URL langsung `/users` | **Akses ditolak (HTTP 403 Forbidden)**. | **PASS (Otomatis)** |

---

### C. Peran Wali Kelas (`wali_kelas`)

| ID Uji | Fitur / Fungsi | Langkah Pengujian | Data Masukan Uji | Hasil yang Diharapkan | Status Pengujian |
| :--- | :--- | :--- | :--- | :--- | :---: |
| **WAL-01** | Login Wali Kelas | Masuk ke `/login` dengan akun Wali Kelas | User: `walikelas71`, Pass: `password123` | Berhasil login, dialihkan ke `/dashboard` khusus wali kelas yang menampilkan profil kelas 7.1. | **PASS (Otomatis)** |
| **WAL-02** | Isolasi Pengajuan Kelas Binaan | Buka menu `/wali-kelas/pengajuan` | Kelas Binaan: 7.1 | Hanya menampilkan pengajuan siswa dari kelas 7.1. Siswa kelas 7.2 atau lainnya **tidak terlihat**. | **PASS (Otomatis)** |
| **WAL-03** | Persetujuan Pengajuan (Approve) | Klik tombol Setujui pada pengajuan berstatus `Diajukan` | Catatan wali: "Disetujui jam ke-3" (opsional) | Status berubah menjadi `Disetujui_Wali`, tercatat tanggal & nama wali kelas penilai. | **PASS (Otomatis)** |
| **WAL-04** | Penolakan Pengajuan (Reject) | Klik tombol Tolak pada pengajuan siswa | Alasan penolakan: "Sedang ulangan harian" (wajib) | Status berubah menjadi `Ditolak_Wali`, slot waktu langsung terlepas kembali. | **PASS (Otomatis)** |
| **WAL-05** | Proteksi Aksi Lintas Kelas | Wali kelas mencoba menyetujui / menolak pengajuan siswa kelas lain via request langsung | ID pengajuan milik siswa kelas 7.2 | **Akses ditolak (HTTP 403 Forbidden)** dengan pesan "Anda hanya berhak memproses siswa kelas binaan". | **PASS (Otomatis)** |
| **WAL-06** | Pembatasan Hak Akses Sensitif | Wali kelas mencoba mengakses `/siswa`, `/konseling`, `/laporan` | URL langsung `/konseling` atau `/siswa` | **Akses ditolak (HTTP 403 Forbidden)**. Catatan riwayat masalah siswa terlindungi. | **PASS (Otomatis)** |

---

### D. Peran Siswa (Portal Mandiri: `/portal-siswa`)

| ID Uji | Fitur / Fungsi | Langkah Pengujian | Data Masukan Uji | Hasil yang Diharapkan | Status Pengujian |
| :--- | :--- | :--- | :--- | :--- | :---: |
| **SIS-01** | Akses Portal Publik | Buka halaman `/portal-siswa` tanpa login | - | Menampilkan halaman pengenalan portal dan form verifikasi NIS siswa. | **PASS (Otomatis)** |
| **SIS-02** | Verifikasi NIS Valid | Masukkan NIS siswa aktif terdaftar | NIS: `70701` | Berhasil diverifikasi, membuka sesi portal siswa, menampilkan nama, kelas, dan form pengajuan. | **PASS (Otomatis)** |
| **SIS-03** | Penolakan NIS Tidak Terdaftar | Masukkan NIS fiktif atau salah | NIS: `999999` | Ditolak dengan pesan peringatan bahwa NIS tidak ditemukan dalam data master aktif. | **PASS (Otomatis)** |
| **SIS-04** | Penolakan Siswa Tidak Aktif | Masukkan NIS siswa berstatus "Tidak Aktif" | NIS siswa non-aktif | Ditolak dengan pesan bahwa status kesiswaan sedang tidak aktif. | **PASS (Otomatis)** |
| **SIS-05** | Inspeksi Slot Guru BK | Pilih tanggal bimbingan pada form pengajuan | Tanggal yang memiliki jadwal bimbingan | Menampilkan daftar slot jam yang sudah terisi agar siswa tidak memilih jam yang sama. | **PASS (Otomatis)** |
| **SIS-06** | Kirim Pengajuan Konseling | Pilih tanggal masa depan, jam mulai, jam selesai, jenis bimbingan, catatan | Tgl: H+2, Jam: 10:00-11:00, Jenis: "Konseling Belajar" | Pengajuan terkirim, status awal `Diajukan`, muncul badge "Menunggu Persetujuan Wali Kelas". | **PASS (Otomatis)** |
| **SIS-07** | Validasi Bentrok Jadwal Siswa | Siswa mengajukan jam yang bertabrakan dengan jadwal terisi | Jam yang bentrok dengan jadwal aktif | Formulir ditolak dengan pesan peringatan bentrok waktu bimbingan. | **PASS (Otomatis)** |
| **SIS-08** | Validasi Tanggal Masa Lalu | Siswa memilih tanggal sebelum hari ini | Tanggal kemarin | Ditolak dengan pesan validasi "Tanggal bimbingan tidak boleh di masa lalu". | **PASS (Otomatis)** |
| **SIS-09** | Pantau Status Persetujuan | Refresh halaman portal setelah persetujuan / penolakan wali kelas | Sesi siswa aktif | Menampilkan status terupdate: badge "Disetujui Wali Kelas" atau catatan alasan penolakan. | **PASS (Otomatis)** |
| **SIS-10** | Selesai Sesi Portal (Logout) | Klik tombol "Keluar Sesi Siswa" | - | Sesi portal dibersihkan, dialihkan kembali ke form input NIS. | **PASS (Otomatis)** |

---

## 3. Hasil Pengujian Faktual (Teruji Otomatis vs Belum Diuji)

Berdasarkan eksekusi aktual pengujian pada sistem:

### A. Fitur yang Telah Teruji 100% Berhasil (Automated Tests via `php artisan test`)
1. **Autentikasi Multi-Peran**: Pemisahan pengalaman pengguna pasca-login menjadi 3 dashboard berbeda dan portal siswa.
2. **Matriks Otorisasi & Least Privilege**: 100% rute sensitif BK (`/konseling`, `/tindak_lanjut`, `/laporan`, `/siswa/{id}`) terbukti memblokir peran Admin dan Wali Kelas dengan HTTP 403.
3. **Isolasi Kelas Wali Kelas**: Wali kelas terbukti hanya dapat melihat dan memproses persetujuan pengajuan siswa dari kelasnya sendiri.
4. **Algoritma Validasi Anti-Bentrok Jadwal**: Seluruh variasi tabrakan (irisan awal, irisan akhir, irisan tengah, exact match) tertolak secara otomatis, sedangkan kondisi berurutan (*back-to-back*) diterima.
5. **Konkurensi & Double Booking**: Pengujian transaksi konkurensi dengan `lockForUpdate()` terbukti mencegah pesanan ganda pada slot waktu yang sama.
6. **Proteksi Integritas Data Siswa**: Penghapusan data master siswa dicegah jika siswa memiliki riwayat konseling di database.
7. **Siklus Hidup Lengkap (End-to-End)**: Pengujian rantai alur mulai dari Siswa $\rightarrow$ Wali Kelas $\rightarrow$ Guru BK terkonfirmasi sukses dan konsisten.

### B. Fitur yang Belum Diuji Secara Otomatis (Perlu Uji Manual Melalui Browser)
1. **Download Berkas PDF & DOCX Surat Panggilan**: Pengunduhan berkas fisik via `dompdf` dan PHPWord membutuhkan pembukaan langsung di browser untuk memverifikasi kerapian tata letak cetak (*print preview*) dan kop surat SMPN 2 Dramaga.
2. **Unggah Berkas Excel Master Siswa (`.xlsx`)**: Import Excel massal menggunakan package `maatwebsite/excel` perlu diuji secara manual dengan mengunggah berkas Excel nyata untuk memverifikasi kompatibilitas ekstensi PHP (`php_zip`, `php_gd`).
3. **Interaktivitas Visual Frontend (UI Client-Side)**: Efek interaktif browser seperti render chart statistik konseling (Chart.js), ikon Lucide, dan modal konfirmasi JavaScript belum diuji via headless browser.

---

## 4. Kendala & Catatan Operasional untuk Penguji

1. **Sinkronisasi Kelas Siswa dan Akun Wali Kelas pada Database Nyata**:
   - Dalam database saat ini, akun `walikelas71` ditugaskan memegang Kelas `7.1` (ID: 1).
   - Sebanyak 10 siswa sampel terdaftar di Kelas `7.7` (ID: 9).
   - **Solusi Uji Coba**: Agar akun `walikelas71` dapat melihat pengajuan siswa saat uji coba manual, pastikan siswa yang mengajukan berada di Kelas `7.1`, ATAU gunakan akun Admin (`admin`) untuk mengubah penugasan kelas akun `walikelas71` ke Kelas `7.7` melalui menu Manajemen Pengguna (`/users`).
2. **Koneksi Database MySQL Lokal**:
   - Pastikan service MySQL XAMPP berjalan pada port `3306` sebelum menjalankan aplikasi (`c:\xampp\mysql\bin\mysqld.exe`).
