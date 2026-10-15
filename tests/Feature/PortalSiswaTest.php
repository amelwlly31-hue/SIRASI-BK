<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Penjadwalan;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PortalSiswaTest extends TestCase
{
    use DatabaseTransactions;

    protected Siswa $siswa;
    protected Kelas $kelas;
    protected User $waliKelas;
    protected User $guruBk;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Setup Kelas & Wali Kelas
        $this->kelas = Kelas::firstOrCreate(['id_kelas' => 1], ['nama_kelas' => '7.1', 'tingkat' => 7]);

        $this->waliKelas = User::create([
            'nama' => 'Wali Kelas 7.1 Test',
            'username' => 'wali71_' . uniqid(),
            'password' => bcrypt('password123'),
            'role' => 'wali_kelas',
            'id_kelas' => $this->kelas->id_kelas,
        ]);

        $this->guruBk = User::where('role', 'guru_bk')->first() ?? User::create([
            'nama' => 'Guru BK Test',
            'username' => 'gurubk_' . uniqid(),
            'password' => bcrypt('password123'),
            'role' => 'guru_bk',
        ]);

        // 2. Setup Siswa Aktif
        $this->siswa = Siswa::create([
            'nis' => 'TESTNIS_' . rand(1000, 9999),
            'nama_siswa' => 'Budi Siswa Test',
            'jenis_kelamin' => 'L',
            'id_kelas' => $this->kelas->id_kelas,
            'status' => 'Aktif',
        ]);
    }

    public function test_guest_sees_nis_login_form_on_portal_siswa()
    {
        $response = $this->get(route('portal.siswa.index'));
        $response->assertStatus(200);
        $response->assertSee('Masuk Portal Pengajuan Siswa');
        $response->assertSee('Nomor Induk Siswa (NIS)');
    }

    public function test_student_can_login_with_valid_nis()
    {
        $response = $this->post(route('portal.siswa.login'), [
            'nis' => $this->siswa->nis,
        ]);

        $response->assertRedirect(route('portal.siswa.index'));
        $response->assertSessionHas('portal_siswa_id', $this->siswa->id_siswa);
        $response->assertSessionHas('success');

        // Buka kembali halaman portal dengan sesi aktif
        $portalResponse = $this->withSession([
            'portal_siswa_id' => $this->siswa->id_siswa,
            'portal_siswa_nis' => $this->siswa->nis,
            'portal_siswa_nama' => $this->siswa->nama_siswa,
        ])->get(route('portal.siswa.index'));

        $portalResponse->assertStatus(200);
        $portalResponse->assertSee($this->siswa->nama_siswa);
        $portalResponse->assertSee($this->siswa->nis);
        $portalResponse->assertSee('Ajukan Jadwal Bimbingan Konseling');
    }

    public function test_student_login_with_invalid_or_inactive_nis_fails()
    {
        // 1. NIS tidak terdaftar
        $invalidResponse = $this->post(route('portal.siswa.login'), [
            'nis' => '9999999999',
        ]);
        $invalidResponse->assertSessionHasErrors(['nis']);

        // 2. Siswa status Tidak Aktif
        $siswaNonAktif = Siswa::create([
            'nis' => 'INACT_' . rand(1000, 9999),
            'nama_siswa' => 'Siswa Non Aktif',
            'jenis_kelamin' => 'P',
            'id_kelas' => $this->kelas->id_kelas,
            'status' => 'Tidak Aktif',
        ]);

        $inactiveResponse = $this->post(route('portal.siswa.login'), [
            'nis' => $siswaNonAktif->nis,
        ]);
        $inactiveResponse->assertSessionHasErrors(['nis']);
    }

    public function test_student_can_submit_counseling_request_successfully()
    {
        $tglBimbingan = now()->addDays(2)->format('Y-m-d');

        $response = $this->withSession([
            'portal_siswa_id' => $this->siswa->id_siswa,
        ])->post(route('portal.siswa.ajukan'), [
            'tanggal' => $tglBimbingan,
            'waktu_mulai' => '08:30',
            'waktu_selesai' => '09:15',
            'jenis_bimbingan' => 'Konseling Belajar',
            'catatan' => 'Ingin konsultasi kesulitan belajar matematika',
        ]);

        $response->assertRedirect(route('portal.siswa.index'));
        $response->assertSessionHas('success');

        // Verifikasi data tersimpan di tabel penjadwalan dengan status 'Diajukan'
        $this->assertDatabaseHas('penjadwalan', [
            'id_siswa' => $this->siswa->id_siswa,
            'tanggal' => $tglBimbingan,
            'waktu_mulai' => '08:30:00',
            'waktu_selesai' => '09:15:00',
            'jenis_bimbingan' => 'Konseling Belajar',
            'status' => 'Diajukan',
        ]);

        // Verifikasi notifikasi terkirim
        $this->assertDatabaseHas('notifikasis', [
            'judul' => 'Pengajuan Konseling Baru dari Siswa',
            'tipe' => 'jadwal',
        ]);
    }

    public function test_student_request_fails_if_time_conflicts_with_existing_schedule()
    {
        $tglBimbingan = now()->addDays(3)->format('Y-m-d');

        // Jadwal aktif Guru BK: 10:00 - 11:00
        Penjadwalan::create([
            'id_siswa' => $this->siswa->id_siswa,
            'tanggal' => $tglBimbingan,
            'waktu_mulai' => '10:00',
            'waktu_selesai' => '11:00',
            'jenis_bimbingan' => 'Konseling Karir',
            'status' => 'Terjadwal',
        ]);

        // Siswa mencoba mengajukan di rentang bertabrakan: 10:30 - 11:30
        $response = $this->withSession([
            'portal_siswa_id' => $this->siswa->id_siswa,
        ])->post(route('portal.siswa.ajukan'), [
            'tanggal' => $tglBimbingan,
            'waktu_mulai' => '10:30',
            'waktu_selesai' => '11:30',
            'jenis_bimbingan' => 'Konseling Pribadi',
        ]);

        $response->assertSessionHasErrors(['waktu_mulai']);
        $this->assertEquals(1, Penjadwalan::where('tanggal', $tglBimbingan)->count());
    }

    public function test_student_request_cannot_have_past_date_or_invalid_time()
    {
        // 1. Tanggal di masa lalu
        $pastResponse = $this->withSession([
            'portal_siswa_id' => $this->siswa->id_siswa,
        ])->post(route('portal.siswa.ajukan'), [
            'tanggal' => now()->subDay()->format('Y-m-d'),
            'waktu_mulai' => '09:00',
            'waktu_selesai' => '10:00',
            'jenis_bimbingan' => 'Konseling Pribadi',
        ]);
        $pastResponse->assertSessionHasErrors(['tanggal']);

        // 2. Waktu selesai lebih kecil daripada waktu mulai
        $invalidTimeResponse = $this->withSession([
            'portal_siswa_id' => $this->siswa->id_siswa,
        ])->post(route('portal.siswa.ajukan'), [
            'tanggal' => now()->addDays(1)->format('Y-m-d'),
            'waktu_mulai' => '10:00',
            'waktu_selesai' => '09:00',
            'jenis_bimbingan' => 'Konseling Pribadi',
        ]);
        $invalidTimeResponse->assertSessionHasErrors(['waktu_selesai']);
    }

    public function test_end_to_end_student_request_wali_approval_and_bk_scheduling()
    {
        $tglBimbingan = now()->addDays(4)->format('Y-m-d');

        // 1. Siswa mengajukan bimbingan
        $this->withSession([
            'portal_siswa_id' => $this->siswa->id_siswa,
        ])->post(route('portal.siswa.ajukan'), [
            'tanggal' => $tglBimbingan,
            'waktu_mulai' => '08:00',
            'waktu_selesai' => '08:45',
            'jenis_bimbingan' => 'Konseling Sosial',
            'catatan' => 'Konsultasi teman sekelas',
        ]);

        $pengajuan = Penjadwalan::where('id_siswa', $this->siswa->id_siswa)->latest('id_penjadwalan')->first();
        $this->assertNotNull($pengajuan);
        $this->assertEquals('Diajukan', $pengajuan->status);

        // 2. Wali Kelas memeriksa dan menyetujui pengajuan
        $approveResponse = $this->actingAs($this->waliKelas)->patch(
            route('wali.pengajuan.approve', $pengajuan->id_penjadwalan),
            ['catatan_wali' => 'Sudah izin ke guru jam pertama.']
        );
        $approveResponse->assertRedirect(route('wali.pengajuan.index'));

        $pengajuan->refresh();
        $this->assertEquals('Disetujui_Wali', $pengajuan->status);
        $this->assertEquals($this->waliKelas->id_user, $pengajuan->id_wali);

        // 3. Siswa melihat status telah disetujui wali di portal
        $portalView = $this->withSession([
            'portal_siswa_id' => $this->siswa->id_siswa,
        ])->get(route('portal.siswa.index'));
        $portalView->assertSee('Disetujui Wali Kelas');
        $portalView->assertSee('Sudah izin ke guru jam pertama.');

        // 4. Guru BK menetapkan jadwal resmi menjadi 'Terjadwal'
        $updateResponse = $this->actingAs($this->guruBk)->put(
            route('penjadwalan.update', $pengajuan->id_penjadwalan),
            [
                'id_siswa' => $this->siswa->id_siswa,
                'tanggal' => $tglBimbingan,
                'waktu_mulai' => '08:00',
                'waktu_selesai' => '08:45',
                'jenis_bimbingan' => 'Konseling Sosial',
                'catatan' => 'Jadwal telah dikonfirmasi BK',
                'status' => 'Terjadwal',
            ]
        );
        $updateResponse->assertRedirect(route('penjadwalan.show', $pengajuan->id_penjadwalan));

        $pengajuan->refresh();
        $this->assertEquals('Terjadwal', $pengajuan->status);
    }

    public function test_end_to_end_student_request_wali_rejection_frees_slot()
    {
        $tglBimbingan = now()->addDays(5)->format('Y-m-d');

        // 1. Siswa 1 mengajukan bimbingan: 09:00 - 10:00
        $this->withSession([
            'portal_siswa_id' => $this->siswa->id_siswa,
        ])->post(route('portal.siswa.ajukan'), [
            'tanggal' => $tglBimbingan,
            'waktu_mulai' => '09:00',
            'waktu_selesai' => '10:00',
            'jenis_bimbingan' => 'Konseling Pribadi',
        ]);

        $pengajuan = Penjadwalan::where('id_siswa', $this->siswa->id_siswa)->latest('id_penjadwalan')->first();

        // 2. Wali Kelas menolak dengan alasan wajib
        $this->actingAs($this->waliKelas)->patch(
            route('wali.pengajuan.reject', $pengajuan->id_penjadwalan),
            ['catatan_wali' => 'Ada jadwal praktikum IPA wajib hadir.']
        );

        $pengajuan->refresh();
        $this->assertEquals('Ditolak_Wali', $pengajuan->status);

        // 3. Siswa 2 dapat mengajukan slot yang sama (09:00 - 10:00) karena slot bebas
        $siswa2 = Siswa::create([
            'nis' => 'TESTNIS2_' . rand(1000, 9999),
            'nama_siswa' => 'Siswa Bebas Slot',
            'jenis_kelamin' => 'P',
            'id_kelas' => $this->kelas->id_kelas,
            'status' => 'Aktif',
        ]);

        $responseSiswa2 = $this->withSession([
            'portal_siswa_id' => $siswa2->id_siswa,
        ])->post(route('portal.siswa.ajukan'), [
            'tanggal' => $tglBimbingan,
            'waktu_mulai' => '09:00',
            'waktu_selesai' => '10:00',
            'jenis_bimbingan' => 'Konseling Belajar',
        ]);

        $responseSiswa2->assertRedirect(route('portal.siswa.index'));
        $responseSiswa2->assertSessionHas('success');
    }

    public function test_student_logout_clears_session()
    {
        $response = $this->withSession([
            'portal_siswa_id' => $this->siswa->id_siswa,
            'portal_siswa_nama' => $this->siswa->nama_siswa,
        ])->post(route('portal.siswa.logout'));

        $response->assertRedirect(route('portal.siswa.index'));
        $response->assertSessionMissing('portal_siswa_id');
    }
}
