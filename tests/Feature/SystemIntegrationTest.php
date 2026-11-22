<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Penjadwalan;
use App\Models\SlotKonseling;
use App\Models\JenisMasalah;
use App\Models\Konseling;
use App\Models\TindakLanjut;
use App\Models\Notifikasi;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class SystemIntegrationTest extends TestCase
{
    use DatabaseTransactions;

    protected User $admin;
    protected User $guruBk;
    protected User $waliKelasA;
    protected User $waliKelasB;
    protected Kelas $kelasA;
    protected Kelas $kelasB;
    protected Siswa $siswaA;
    protected Siswa $siswaB;
    protected JenisMasalah $jenisMasalah;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Setup Kelas
        $this->kelasA = Kelas::firstOrCreate(['id_kelas' => 1], ['nama_kelas' => '7.1', 'tingkat' => 7]);
        $this->kelasB = Kelas::firstOrCreate(['id_kelas' => 2], ['nama_kelas' => '7.2', 'tingkat' => 7]);

        // 2. Setup Pengguna
        $this->admin = User::create([
            'nama' => 'Integration Admin',
            'username' => 'admin_int_' . uniqid(),
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        $this->guruBk = User::create([
            'nama' => 'Integration Guru BK',
            'username' => 'gurubk_int_' . uniqid(),
            'password' => bcrypt('password123'),
            'role' => 'guru_bk',
        ]);

        $this->waliKelasA = User::create([
            'nama' => 'Integration Wali Kelas 7.1',
            'username' => 'wali_a_' . uniqid(),
            'password' => bcrypt('password123'),
            'role' => 'wali_kelas',
            'id_kelas' => $this->kelasA->id_kelas,
        ]);

        $this->waliKelasB = User::create([
            'nama' => 'Integration Wali Kelas 7.2',
            'username' => 'wali_b_' . uniqid(),
            'password' => bcrypt('password123'),
            'role' => 'wali_kelas',
            'id_kelas' => $this->kelasB->id_kelas,
        ]);

        // 3. Setup Siswa Aktif
        $this->siswaA = Siswa::create([
            'nis' => 'INT_NIS_A_' . rand(1000, 9999),
            'nama_siswa' => 'Ahmad Siswa A',
            'jenis_kelamin' => 'L',
            'id_kelas' => $this->kelasA->id_kelas,
            'status' => 'Aktif',
        ]);

        $this->siswaB = Siswa::create([
            'nis' => 'INT_NIS_B_' . rand(1000, 9999),
            'nama_siswa' => 'Bunga Siswa B',
            'jenis_kelamin' => 'P',
            'id_kelas' => $this->kelasB->id_kelas,
            'status' => 'Aktif',
        ]);

        // 4. Setup Jenis Masalah
        $this->jenisMasalah = JenisMasalah::firstOrCreate(
            ['nama_jenis' => 'Pribadi'],
            ['keterangan' => 'Masalah pengembangan diri dan kepribadian']
        );
    }

    /**
     * 1. Pengujian Alur Penuh (End-to-End Lifecycle):
     * Siswa Ajukan Izin -> Wali Kelas Setujui Izin -> Siswa Ajukan Jadwal -> Guru BK Konfirmasi Jadwal -> Guru BK Sesi Konseling & Tindak Lanjut
     */
    public function test_end_to_end_counseling_lifecycle_cross_role()
    {
        $targetDate = Carbon::now()->addDays(2)->format('Y-m-d');
        $startTime = '09:00';
        $endTime = '10:00';

        // LANGKAH 1: Siswa membuka Portal Publik Tanpa Login dan mengajukan permohonan izin kepada Wali Kelas
        $izinResponse = $this->post(route('portal.siswa.izin'), [
            'id_kelas' => $this->kelasA->id_kelas,
            'id_siswa' => $this->siswaA->id_siswa,
            'jenis_bimbingan' => 'Bimbingan Belajar dan Konsentrasi',
        ]);
        $izinResponse->assertRedirect();
        $izinResponse->assertSessionHas('izin_berhasil', true);

        // Pastikan record permohonan izin tersimpan dengan status 'Diajukan' dan belum memiliki jadwal konseling
        $penjadwalan = Penjadwalan::where('id_siswa', $this->siswaA->id_siswa)
            ->latest('id_penjadwalan')
            ->first();

        $this->assertNotNull($penjadwalan);
        $this->assertNotEmpty($penjadwalan->kode_pengajuan);
        $this->assertEquals('Diajukan', $penjadwalan->status);
        $this->assertTrue($penjadwalan->isDiajukan());
        $this->assertFalse($penjadwalan->hasSubmittedSchedule());

        // LANGKAH 2: Wali Kelas A melihat daftar permohonan izin dan menyetujuinya
        $waliView = $this->actingAs($this->waliKelasA)->get(route('wali.pengajuan.index'));
        $waliView->assertStatus(200);
        $waliView->assertSee($this->siswaA->nama_siswa);

        $approveResponse = $this->actingAs($this->waliKelasA)->patch(
            route('wali.pengajuan.approve', $penjadwalan->id_penjadwalan),
            ['catatan_wali' => 'Disetujui, sudah dikoordinasikan dengan guru mapel jam ke-3.']
        );
        $approveResponse->assertRedirect();

        $penjadwalan->refresh();
        $this->assertEquals('Disetujui_Wali', $penjadwalan->status);
        $this->assertTrue($penjadwalan->isDisetujuiWali());
        $this->assertEquals($this->waliKelasA->id_user, $penjadwalan->id_wali);
        $this->assertNotNull($penjadwalan->waktu_persetujuan_wali);

        // LANGKAH 2A: Guru BK membuka slot ketersediaan konseling pada tanggal tersebut (09:00 - 10:00)
        $slot = SlotKonseling::create([
            'id_user' => $this->guruBk->id_user,
            'tanggal' => $targetDate,
            'waktu_mulai' => $startTime . ':00',
            'waktu_selesai' => $endTime . ':00',
            'durasi_menit' => 60,
            'status' => 'Tersedia',
            'keterangan' => 'Slot 1 Jam Pagi',
        ]);

        // LANGKAH 2B: Setelah izin disetujui Wali Kelas, siswa mengajukan jadwal konseling ke Guru BK
        $ajukanResponse = $this->post(route('portal.siswa.ajukan'), [
            'id_kelas' => $this->kelasA->id_kelas,
            'id_siswa' => $this->siswaA->id_siswa,
            'kode_pengajuan' => $penjadwalan->kode_pengajuan,
            'id_slot' => $slot->id_slot,
            'tanggal' => $targetDate,
            'waktu_mulai' => $startTime,
            'waktu_selesai' => $endTime,
            'jenis_bimbingan' => 'Bimbingan Belajar dan Konsentrasi',
            'catatan' => 'Sering kesulitan fokus belajar di kelas.',
        ]);
        $ajukanResponse->assertRedirect();
        $ajukanResponse->assertSessionHas('pengajuan_berhasil', true);

        $penjadwalan->refresh();
        $slot->refresh();
        $this->assertEquals('Disetujui_Wali', $penjadwalan->status);
        $this->assertTrue($penjadwalan->hasSubmittedSchedule());
        $this->assertEquals('Menunggu_Diproses', $slot->status);

        // LANGKAH 3: Guru BK melihat jadwal yang disetujui wali kelas dan mengonfirmasi ke 'Terjadwal'
        $bkView = $this->actingAs($this->guruBk)->get(route('penjadwalan.index'));
        $bkView->assertStatus(200);
        $bkView->assertSee($this->siswaA->nama_siswa);

        $updateResponse = $this->actingAs($this->guruBk)->put(
            route('penjadwalan.update', $penjadwalan->id_penjadwalan),
            [
                'id_siswa' => $this->siswaA->id_siswa,
                'tanggal' => $targetDate,
                'waktu_mulai' => $startTime,
                'waktu_selesai' => $endTime,
                'jenis_bimbingan' => 'Bimbingan Belajar dan Konsentrasi',
                'status' => 'Terjadwal',
                'catatan' => 'Dikonfirmasi, sesi akan dilaksanakan di Ruang BK 1.',
            ]
        );
        $updateResponse->assertRedirect(route('penjadwalan.show', $penjadwalan->id_penjadwalan));

        $penjadwalan->refresh();
        $slot->refresh();
        $this->assertEquals('Terjadwal', $penjadwalan->status);
        $this->assertEquals('Dipesan', $slot->status);

        // LANGKAH 4: Guru BK mencatat sesi konseling yang telah dilaksanakan
        $konselingResponse = $this->actingAs($this->guruBk)->post(route('konseling.store'), [
            'id_siswa' => $this->siswaA->id_siswa,
            'id_jenis' => $this->jenisMasalah->id_jenis,
            'tanggal' => $targetDate,
            'masalah' => 'Kesulitan membagi waktu antara kegiatan ekstrakurikuler dan belajar.',
            'hasil_konseling' => 'Siswa menyepakati pembuatan jadwal belajar harian terstruktur.',
            'catatan' => 'Perlu evaluasi dalam 2 minggu mendatang.',
        ]);
        $konselingResponse->assertRedirect(route('konseling.index'));

        $konseling = Konseling::where('id_siswa', $this->siswaA->id_siswa)->latest('id_konseling')->first();
        $this->assertNotNull($konseling);
        $this->assertEquals('Proses', $konseling->status);

        // LANGKAH 5: Guru BK mencatat tindak lanjut konseling
        $tindakLanjutResponse = $this->actingAs($this->guruBk)->post(route('tindak_lanjut.store'), [
            'id_konseling' => $konseling->id_konseling,
            'tanggal' => Carbon::parse($targetDate)->addDays(7)->format('Y-m-d'),
            'tindakan' => 'Pemeriksaan kepatuhan jadwal belajar mandiri',
            'keterangan' => 'Siswa mampu mengikuti jadwal dengan tingkat kepatuhan 85%.',
        ]);
        $tindakLanjutResponse->assertRedirect(route('konseling.show', $konseling->id_konseling));

        $this->assertDatabaseHas('tindak_lanjut', [
            'id_konseling' => $konseling->id_konseling,
            'tindakan' => 'Pemeriksaan kepatuhan jadwal belajar mandiri',
        ]);

        // LANGKAH 6: Siswa memeriksa halaman Cek Status dengan Kode Izin dan mendapati statusnya adalah 'Terjadwal' tanpa menampilkan catatan pribadi
        $portalStatusView = $this->post(route('portal.siswa.status'), [
            'id_kelas' => $this->kelasA->id_kelas,
            'id_siswa' => $this->siswaA->id_siswa,
            'kode_pengajuan' => $penjadwalan->kode_pengajuan,
        ]);
        $portalStatusView->assertStatus(200);
        $portalStatusView->assertSee('Terjadwal Resmi oleh Guru BK');
        $portalStatusView->assertDontSee('Dikonfirmasi, sesi akan dilaksanakan di Ruang BK 1.');
    }

    /**
     * 2. Pengujian Matriks Hak Akses & Pembatasan Privasi (Least Privilege):
     * Admin, Guru BK, Wali Kelas, dan Siswa memiliki batas akses yang terisolasi ketat.
     */
    public function test_least_privilege_and_unauthorized_access_across_roles()
    {
        // A. Tamu (Guest Unauthenticated) dialihkan ke Login
        $this->get('/dashboard')->assertRedirect(route('login'));
        $this->get('/siswa')->assertRedirect(route('login'));
        $this->get('/penjadwalan')->assertRedirect(route('login'));
        $this->get('/konseling')->assertRedirect(route('login'));
        $this->get('/wali-kelas/pengajuan')->assertRedirect(route('login'));

        // B. Admin: Dapat mengelola data siswa, namun tetap tidak dapat membuka fitur BK khusus
        $this->actingAs($this->admin)->get('/dashboard')->assertStatus(200);
        $this->actingAs($this->admin)->get('/users')->assertStatus(200);
        $this->actingAs($this->admin)->get('/siswa')->assertStatus(200);
        $this->actingAs($this->admin)->get(route('siswa.create'))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('siswa.edit', $this->siswaA->id_siswa))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('siswa.show', $this->siswaA->id_siswa))->assertStatus(200);
        $adminSiswaNis = 'ROLE_ADMIN_' . uniqid();
        $this->actingAs($this->admin)->post(route('siswa.store'), [
            'nis' => $adminSiswaNis,
            'nama_siswa' => 'Siswa Buatan Admin',
            'jenis_kelamin' => 'L',
            'id_kelas' => $this->kelasA->id_kelas,
        ])->assertRedirect(route('siswa.index'));
        $adminCreatedSiswa = Siswa::where('nis', $adminSiswaNis)->firstOrFail();
        $this->actingAs($this->admin)->put(route('siswa.update', $adminCreatedSiswa->id_siswa), [
            'nis' => $adminSiswaNis,
            'nama_siswa' => 'Siswa Diperbarui Admin',
            'jenis_kelamin' => 'L',
            'id_kelas' => $this->kelasA->id_kelas,
        ])->assertRedirect(route('siswa.index'));
        $this->actingAs($this->admin)->get('/penjadwalan')->assertStatus(200);

        // Akses privat konseling ditolak (403)
        $this->actingAs($this->admin)->get('/konseling')->assertStatus(403);
        $this->actingAs($this->admin)->get('/tindak_lanjut')->assertStatus(403);
        $this->actingAs($this->admin)->get('/laporan')->assertStatus(403);
        $this->actingAs($this->admin)->get('/riwayat-siswa')->assertStatus(403);
        $this->actingAs($this->admin)->get('/wali-kelas/pengajuan')->assertStatus(403);

        // C. Guru BK: Memiliki akses penuh BK, namun DILARANG mengelola akun user atau persetujuan wali kelas
        $this->actingAs($this->guruBk)->get('/dashboard')->assertStatus(200);
        $this->actingAs($this->guruBk)->get('/siswa')->assertStatus(200);
        $this->actingAs($this->guruBk)->get(route('siswa.create'))->assertStatus(200);
        $this->actingAs($this->guruBk)->get(route('siswa.edit', $this->siswaA->id_siswa))->assertStatus(200);
        $this->actingAs($this->guruBk)->get(route('siswa.show', $this->siswaA->id_siswa))->assertStatus(200);
        $guruSiswaNis = 'ROLE_GURU_' . uniqid();
        $this->actingAs($this->guruBk)->post(route('siswa.store'), [
            'nis' => $guruSiswaNis,
            'nama_siswa' => 'Siswa Buatan Guru BK',
            'jenis_kelamin' => 'P',
            'id_kelas' => $this->kelasA->id_kelas,
        ])->assertRedirect(route('siswa.index'));
        $guruCreatedSiswa = Siswa::where('nis', $guruSiswaNis)->firstOrFail();
        $this->actingAs($this->guruBk)->put(route('siswa.update', $guruCreatedSiswa->id_siswa), [
            'nis' => $guruSiswaNis,
            'nama_siswa' => 'Siswa Diperbarui Guru BK',
            'jenis_kelamin' => 'P',
            'id_kelas' => $this->kelasA->id_kelas,
        ])->assertRedirect(route('siswa.index'));
        $this->actingAs($this->guruBk)->get('/penjadwalan')->assertStatus(200);
        $this->actingAs($this->guruBk)->get('/konseling')->assertStatus(200);
        $this->actingAs($this->guruBk)->get('/tindak_lanjut')->assertRedirect(route('konseling.index'));
        $this->actingAs($this->guruBk)->get('/laporan')->assertStatus(200);
        $this->actingAs($this->guruBk)->get('/riwayat-siswa')->assertStatus(200);

        // Menu User & Persetujuan Wali ditolak (403)
        $this->actingAs($this->guruBk)->get('/users')->assertStatus(403);
        $this->actingAs($this->guruBk)->get('/wali-kelas/pengajuan')->assertStatus(403);

        // D. Wali Kelas: Akses khusus dashboard kelas & pengajuan binaan, DILARANG akses BK dan Master Siswa
        $this->actingAs($this->waliKelasA)->get('/dashboard')->assertStatus(200);
        $this->actingAs($this->waliKelasA)->get('/wali-kelas/pengajuan')->assertStatus(200);

        $this->actingAs($this->waliKelasA)->get('/users')->assertStatus(403);
        $this->actingAs($this->waliKelasA)->get('/siswa')->assertStatus(403);
        $this->actingAs($this->waliKelasA)->get(route('siswa.create'))->assertStatus(403);
        $this->actingAs($this->waliKelasA)->get(route('siswa.edit', $this->siswaA->id_siswa))->assertStatus(403);
        $this->actingAs($this->waliKelasA)->post(route('siswa.store'), [])->assertStatus(403);
        $this->actingAs($this->waliKelasA)->put(route('siswa.update', $this->siswaA->id_siswa), [])->assertStatus(403);
        $this->actingAs($this->waliKelasA)->get('/penjadwalan')->assertStatus(403);
        $this->actingAs($this->waliKelasA)->get('/konseling')->assertStatus(403);
        $this->actingAs($this->waliKelasA)->get('/tindak_lanjut')->assertStatus(403);
        $this->actingAs($this->waliKelasA)->get('/laporan')->assertStatus(403);
        $this->actingAs($this->waliKelasA)->get('/riwayat-siswa')->assertStatus(403);
    }

    /**
     * 3. Pengujian Isolasi Antar-Kelas untuk Wali Kelas (Multi-Class Isolation):
     * Wali Kelas A tidak boleh melihat atau memproses pengajuan siswa Kelas B.
     */
    public function test_multi_class_isolation_for_wali_kelas()
    {
        $targetDate = Carbon::now()->addDays(3)->format('Y-m-d');

        // Jadwal untuk Siswa A (Kelas 7.1)
        $jadwalA = Penjadwalan::create([
            'id_siswa' => $this->siswaA->id_siswa,
            'tanggal' => $targetDate,
            'waktu_mulai' => '08:00',
            'waktu_selesai' => '09:00',
            'jenis_bimbingan' => 'Masalah Kelas A',
            'status' => 'Diajukan',
        ]);

        // Jadwal untuk Siswa B (Kelas 7.2)
        $jadwalB = Penjadwalan::create([
            'id_siswa' => $this->siswaB->id_siswa,
            'tanggal' => $targetDate,
            'waktu_mulai' => '10:00',
            'waktu_selesai' => '11:00',
            'jenis_bimbingan' => 'Masalah Kelas B',
            'status' => 'Diajukan',
        ]);

        // Wali Kelas A (Kelas 7.1) membuka daftar pengajuan
        $viewWaliA = $this->actingAs($this->waliKelasA)->get(route('wali.pengajuan.index'));
        $viewWaliA->assertStatus(200);
        $viewWaliA->assertSee($this->siswaA->nama_siswa);
        $viewWaliA->assertDontSee($this->siswaB->nama_siswa);

        // Wali Kelas A mencoba menyetujui jadwal Siswa B (Kelas 7.2) -> Ditolak 403
        $illegalApprove = $this->actingAs($this->waliKelasA)->patch(
            route('wali.pengajuan.approve', $jadwalB->id_penjadwalan),
            ['catatan_wali' => 'Mencoba approve lintas kelas']
        );
        $illegalApprove->assertStatus(403);

        // Wali Kelas A mencoba menolak jadwal Siswa B (Kelas 7.2) -> Ditolak 403
        $illegalReject = $this->actingAs($this->waliKelasA)->patch(
            route('wali.pengajuan.reject', $jadwalB->id_penjadwalan),
            ['alasan_penolakan' => 'Mencoba reject lintas kelas']
        );
        $illegalReject->assertStatus(403);

        // Status Jadwal B tetap 'Diajukan'
        $jadwalB->refresh();
        $this->assertEquals('Diajukan', $jadwalB->status);
    }

    /**
     * 4. Pengujian Validasi Anti-Bentrok Jadwal Lintas Jalur (Portal, Guru BK, Wali Kelas):
     */
    public function test_anti_bentrok_validation_matrix_across_all_entry_points()
    {
        $targetDate = Carbon::now()->addDays(4)->format('Y-m-d');

        // Buat jadwal Terjadwal eksisting pada jam 08:00 - 09:30
        Penjadwalan::create([
            'id_siswa' => $this->siswaA->id_siswa,
            'tanggal' => $targetDate,
            'waktu_mulai' => '08:00',
            'waktu_selesai' => '09:30',
            'jenis_bimbingan' => 'Sesi Konseling Tetap',
            'status' => 'Terjadwal',
        ]);

        // Skenario A: Siswa B (yang sudah mendapat izin Wali Kelas) mengajukan jam yang bertabrakan (09:00 - 10:00) via portal -> Gagal
        $izinSiswaB = Penjadwalan::create([
            'kode_pengajuan' => Penjadwalan::generateKodePengajuan(),
            'id_siswa' => $this->siswaB->id_siswa,
            'tanggal' => Carbon::now()->format('Y-m-d'),
            'waktu_mulai' => '00:00:00',
            'waktu_selesai' => '00:00:00',
            'jenis_bimbingan' => 'Bimbingan Tabrakan',
            'status' => 'Disetujui_Wali',
            'id_wali' => $this->waliKelasB->id_user,
        ]);

        $conflictPortal = $this->post(route('portal.siswa.ajukan'), [
            'id_kelas' => $this->kelasB->id_kelas,
            'id_siswa' => $this->siswaB->id_siswa,
            'kode_pengajuan' => $izinSiswaB->kode_pengajuan,
            'tanggal' => $targetDate,
            'waktu_mulai' => '09:00',
            'waktu_selesai' => '10:00',
            'jenis_bimbingan' => 'Bimbingan Tabrakan',
        ]);
        $conflictPortal->assertSessionHasErrors('waktu_mulai');

        // Skenario B: Guru BK mencoba membuat jadwal baru yang menimpa slot (08:30 - 09:15) -> Gagal
        $conflictBk = $this->actingAs($this->guruBk)
            ->post(route('penjadwalan.store'), [
                'id_siswa' => $this->siswaB->id_siswa,
                'tanggal' => $targetDate,
                'waktu_mulai' => '08:30',
                'waktu_selesai' => '09:15',
                'jenis_bimbingan' => 'Bimbingan Tabrakan BK',
            ]);
        $conflictBk->assertSessionHasErrors('waktu_mulai');

        // Skenario C: Jadwal berurutan tepat (Back-to-back: 09:30 - 10:30) -> Berhasil
        $backToBack = $this->actingAs($this->guruBk)
            ->post(route('penjadwalan.store'), [
                'id_siswa' => $this->siswaB->id_siswa,
                'tanggal' => $targetDate,
                'waktu_mulai' => '09:30',
                'waktu_selesai' => '10:30',
                'jenis_bimbingan' => 'Bimbingan Sambung',
            ]);
        $backToBack->assertRedirect(route('penjadwalan.index'));
        $backToBack->assertSessionHas('success');
    }

    /**
     * 5. Pengujian Perlindungan Data Siswa (Student Deletion Protection):
     * Siswa dengan riwayat konseling tidak dapat dihapus sembarangan.
     */
    public function test_student_deletion_protection_with_counseling_history()
    {
        // Buat riwayat konseling untuk Siswa A
        Konseling::create([
            'id_siswa' => $this->siswaA->id_siswa,
            'id_jenis' => $this->jenisMasalah->id_jenis,
            'tanggal' => Carbon::now()->subDays(5)->format('Y-m-d'),
            'masalah' => 'Catatan masalah historis',
            'hasil_konseling' => 'Sudah ditangani',
            'status' => 'Selesai',
        ]);

        // Coba hapus Siswa A via Admin
        $deleteResponse = $this->actingAs($this->admin)->delete(route('siswa.destroy', $this->siswaA->id_siswa));
        $deleteResponse->assertRedirect(route('siswa.index'));
        $deleteResponse->assertSessionHas('error');

        // Siswa A harus tetap ada di basis data
        $this->assertDatabaseHas('siswa', [
            'id_siswa' => $this->siswaA->id_siswa,
        ]);

        // Siswa B (tanpa riwayat konseling) dapat dihapus dengan sukses
        $deleteSiswaB = $this->actingAs($this->admin)->delete(route('siswa.destroy', $this->siswaB->id_siswa));
        $deleteSiswaB->assertRedirect(route('siswa.index'));
        $deleteSiswaB->assertSessionHas('success');

        $this->assertDatabaseMissing('siswa', [
            'id_siswa' => $this->siswaB->id_siswa,
        ]);
    }

    /**
     * 6. Pengujian Keamanan Baca Notifikasi (Privacy Protection on Notification Routing):
     * Notifikasi konseling hanya membuka detail untuk Guru BK; Admin dan Wali diarahkan aman ke Dashboard.
     */
    public function test_notification_routing_protects_confidentiality()
    {
        $konseling = Konseling::create([
            'id_siswa' => $this->siswaA->id_siswa,
            'id_jenis' => $this->jenisMasalah->id_jenis,
            'tanggal' => Carbon::now()->format('Y-m-d'),
            'masalah' => 'Privasi Notifikasi',
            'hasil_konseling' => 'Catatan Rahasia',
            'status' => 'Proses',
        ]);

        $notif = Notifikasi::create([
            'judul' => 'Konseling Baru',
            'pesan' => 'Ada sesi konseling baru',
            'tipe' => 'konseling',
            'id_konseling' => $konseling->id_konseling,
            'dibaca' => false,
        ]);

        // Guru BK membaca notifikasi -> diarahkan ke konseling.show
        $bkClick = $this->actingAs($this->guruBk)->get(route('notifikasi.baca', $notif->id));
        $bkClick->assertRedirect(route('konseling.show', $konseling->id_konseling));

        // Admin membaca notifikasi konseling -> dialihkan aman ke dashboard (bukan konseling.show)
        $adminClick = $this->actingAs($this->admin)->get(route('notifikasi.baca', $notif->id));
        $adminClick->assertRedirect(route('dashboard'));

        // Wali Kelas membaca notifikasi konseling -> dialihkan aman ke dashboard
        $waliClick = $this->actingAs($this->waliKelasA)->get(route('notifikasi.baca', $notif->id));
        $waliClick->assertRedirect(route('dashboard'));
    }
}
