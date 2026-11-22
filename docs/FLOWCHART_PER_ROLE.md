# Flowchart Sistem SIRASI-BK per Role

Dokumen ini merangkum alur aplikasi sesuai rute, middleware role, dan proses layanan yang tersedia. Diagram menggunakan Mermaid; buka file ini di editor/penampil Markdown yang mendukung Mermaid untuk melihat bentuk flowchart.

## 1. Alur Umum Autentikasi

```mermaid
flowchart TD
    A([Mulai]) --> B{Pilih jalur akses}
    B -->|Staf sekolah| C[Halaman login staf]
    C --> D[Isi username dan password]
    D --> E{Kredensial valid?}
    E -->|Tidak| F[Tampilkan pesan kesalahan]
    F --> D
    E -->|Ya| G[Regenerasi sesi dan buka dashboard]
    G --> H{Role pengguna}
    H -->|Admin| I[Dashboard Admin]
    H -->|Guru BK| J[Dashboard Guru BK]
    H -->|Wali Kelas| K[Dashboard kelas binaan]
    H -->|Siswa| L[Alihkan ke Portal Siswa]
    B -->|Portal mandiri siswa| M[Portal Siswa tanpa login staf]
    I --> N[Keluar: logout]
    J --> N
    K --> N
    L --> O[Keluar dari sesi portal]
    M --> O
    N --> P([Selesai])
    O --> P
```

> Akun siswa yang masuk melalui `/login` diarahkan ke portal. Siswa juga dapat memakai portal publik dan verifikasi identitas/NIS untuk mengajukan layanan.

## 2. Admin

```mermaid
flowchart TD
    A([Mulai]) --> B[Login staf]
    B --> C{Login berhasil?}
    C -->|Tidak| B
    C -->|Ya| D[Dashboard Admin: statistik pengguna, siswa, dan kelas]
    D --> E{Pilih modul}
    E -->|Kelola Pengguna| F[Tambah, lihat, ubah, atau hapus akun]
    E -->|Data Siswa| G[Lihat data siswa]
    E -->|Penjadwalan| H[Kelola jadwal bimbingan dan slot konseling]
    E -->|Pengaturan| I[Ubah profil atau password]
    F --> D
    G --> J{Aksi data siswa?}
    J -->|Tambah/Ubah/Hapus| G
    J -->|Import| G
    J -->|Aktifkan/Nonaktifkan| G
    H --> K{Jadwal bentrok?}
    K -->|Ya| L[Tampilkan penolakan bentrok]
    L --> H
    K -->|Tidak| D
    I --> D
    D --> M[Logout]
    M --> N([Selesai])
```

Admin mengelola akun, data master siswa, serta penjadwalan. Data rekam kasus konseling tidak tersedia untuk Admin.

## 3. Guru BK

```mermaid
flowchart TD
    A([Mulai]) --> B[Login staf]
    B --> C{Login berhasil?}
    C -->|Tidak| B
    C -->|Ya| D[Dashboard Guru BK: ringkasan konseling dan jadwal]
    D --> E{Pilih modul}
    E -->|Data Siswa| F[Kelola data siswa: CRUD, import, status]
    E -->|Penjadwalan| G[Kelola jadwal mengajar, slot konseling, dan pengajuan]
    E -->|Data Konseling| H[Catat atau ubah sesi konseling]
    E -->|Riwayat Siswa| I[Lihat rekam konseling siswa]
    E -->|Tindak Lanjut| J[Catat tindakan lanjutan]
    E -->|Laporan| K[Lihat rekap per siswa dan rekap masalah]
    E -->|Surat Panggilan| L[Buat/unduh surat PDF atau DOCX]
    E -->|Pengaturan| M[Ubah profil atau password]
    G --> N{Jadwal/slot bentrok?}
    N -->|Ya| O[Tampilkan pesan bentrok]
    O --> G
    N -->|Tidak| P[Simpan jadwal/slot]
    P --> D
    H --> Q[Perbarui status dan hasil sesi]
    Q --> J
    J --> D
    F --> D
    I --> D
    K --> D
    L --> D
    M --> D
    D --> R[Logout]
    R --> S([Selesai])
```

## 4. Wali Kelas

```mermaid
flowchart TD
    A([Mulai]) --> B[Login staf]
    B --> C{Login berhasil?}
    C -->|Tidak| B
    C -->|Ya| D[Dashboard kelas binaan: siswa, jadwal, dan pengajuan]
    D --> E{Pilih modul}
    E -->|Approval Izin Siswa| F[Lihat pengajuan dari siswa kelas binaan]
    E -->|Pengaturan| G[Ubah profil atau password]
    F --> H{Keputusan Wali Kelas}
    H -->|Setujui| I[Simpan persetujuan dan catatan opsional]
    H -->|Tolak| J[Isi alasan penolakan]
    J --> K{Alasan terisi?}
    K -->|Tidak| J
    K -->|Ya| L[Simpan penolakan dan alasannya]
    I --> M[Status pengajuan diperbarui dan notifikasi dikirim]
    L --> M
    M --> N[Guru BK menindaklanjuti pengajuan yang disetujui]
    M --> O[Siswa dapat melihat status di portal]
    N --> D
    O --> D
    G --> D
    D --> P[Logout]
    P --> Q([Selesai])
```

Wali Kelas hanya memproses pengajuan siswa yang berada di kelas binaannya; akses ke catatan pribadi konseling tidak diberikan.

## 5. Siswa (Portal Mandiri)

```mermaid
flowchart TD
    A([Mulai]) --> B[Buka Portal Siswa]
    B --> C[Lihat informasi layanan dan slot yang tersedia]
    C --> D{Pilih layanan}
    D -->|Ajukan izin/konseling| E[Pilih kelas dan verifikasi identitas siswa aktif]
    E --> F{Identitas valid?}
    F -->|Tidak| G[Tampilkan kesalahan, periksa data]
    G --> E
    F -->|Ya| H[Kirim permohonan izin ke Wali Kelas]
    H --> I[Status: Diajukan; notifikasi ke Wali Kelas]
    I --> J{Keputusan Wali Kelas}
    J -->|Ditolak| K[Siswa melihat alasan penolakan]
    J -->|Disetujui| L[Siswa memilih slot konseling tersedia]
    L --> M{Slot masih tersedia?}
    M -->|Tidak| C
    M -->|Ya| N[Kirim pengajuan jadwal]
    N --> O[Guru BK memproses/finalisasi jadwal]
    O --> P{Jadwal dikonfirmasi?}
    P -->|Belum| Q[Pantau status pengajuan]
    Q --> O
    P -->|Ya| R[Lihat jadwal konseling terkonfirmasi]
    R --> S[Ikuti sesi konseling]
    D -->|Cek status| T[Verifikasi identitas/kode pengajuan]
    T --> U[Tampilkan status dan catatan yang dapat dilihat siswa]
    K --> V([Selesai])
    U --> V
    S --> V
```

## 6. Ringkasan Alur Lintas-Role Pengajuan hingga Konseling

```mermaid
sequenceDiagram
    actor S as Siswa
    participant P as Portal Siswa
    participant W as Wali Kelas
    participant G as Guru BK
    S->>P: Verifikasi identitas dan ajukan izin
    P->>W: Simpan pengajuan berstatus Diajukan + notifikasi
    W->>P: Setujui atau tolak (alasan wajib bila menolak)
    P-->>S: Status dan catatan keputusan
    alt Disetujui Wali Kelas
        S->>P: Pilih slot konseling
        P->>G: Pengajuan jadwal masuk untuk diproses
        G->>G: Validasi jadwal dan konfirmasi/finalisasi
        G-->>S: Jadwal terkonfirmasi dapat dipantau di portal
        S->>G: Mengikuti sesi konseling
        G->>G: Catat hasil konseling dan tindak lanjut
    else Ditolak Wali Kelas
        P-->>S: Tampilkan alasan penolakan
    end
```

### Role dan hak akses utama

| Role | Alur utama |
| --- | --- |
| Admin | Dashboard, kelola akun pengguna, data siswa, penjadwalan, pengaturan akun |
| Guru BK | Data siswa, jadwal dan slot, rekam konseling, riwayat, tindak lanjut, laporan, surat panggilan |
| Wali Kelas | Dashboard kelas binaan, setujui/tolak pengajuan siswa kelasnya, pengaturan akun |
| Siswa | Portal publik, cek slot, ajukan izin/jadwal, dan cek status |

