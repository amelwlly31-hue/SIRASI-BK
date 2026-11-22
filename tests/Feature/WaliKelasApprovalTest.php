<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Penjadwalan;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class WaliKelasApprovalTest extends TestCase
{
    use DatabaseTransactions;

    protected User $waliKelasA;
    protected User $waliKelasB;
    protected User $guruBk;
    protected User $admin;
    protected Siswa $siswaA;
    protected Siswa $siswaB;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Dapatkan atau buat kelas pengujian
        $kelasA = Kelas::firstOrCreate(['id_kelas' => 1], ['nama_kelas' => '7.1', 'tingkat' => 7]);
        $kelasB = Kelas::firstOrCreate(['id_kelas' => 4], ['nama_kelas' => '7.2', 'tingkat' => 7]);

        // 2. Akun Wali Kelas A (Kelas 7.1) dan Wali Kelas B (Kelas 7.2)
        $this->waliKelasA = User::create([
            'nama' => 'Wali Kelas 7.1 Test',
            'username' => 'wali_71_' . uniqid(),
            'password' => bcrypt('password123'),
            'role' => 'wali_kelas',
            'id_kelas' => $kelasA->id_kelas,
        ]);

        $this->waliKelasB = User::create([
            'nama' => 'Wali Kelas 7.2 Test',
            'username' => 'wali_72_' . uniqid(),
            'password' => bcrypt('password123'),
            'role' => 'wali_kelas',
            'id_kelas' => $kelasB->id_kelas,
        ]);

        // 3. Akun Guru BK & Admin
        $this->guruBk = User::where('role', 'guru_bk')->first() ?? User::create([
            'nama' => 'Guru BK Test',
            'username' => 'gurubk_' . uniqid(),
            'password' => bcrypt('password123'),
            'role' => 'guru_bk',
        ]);

        $this->admin = User::where('role', 'admin')->first() ?? User::create([
            'nama' => 'Admin Test',
            'username' => 'admin_' . uniqid(),
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        // 4. Siswa Kelas A dan Siswa Kelas B
        $this->siswaA = Siswa::create([
            'nis' => 'TESTA' . rand(100, 999),
            'nama_siswa' => 'Siswa Kelas 7.1',
            'jenis_kelamin' => 'L',
            'id_kelas' => $kelasA->id_kelas,
            'status' => 'Aktif',
        ]);

        $this->siswaB = Siswa::create([
            'nis' => 'TESTB' . rand(100, 999),
            'nama_siswa' => 'Siswa Kelas 7.2',
            'jenis_kelamin' => 'P',
            'id_kelas' => $kelasB->id_kelas,
            'status' => 'Aktif',
        ]);
    }

    public function test_non_wali_kelas_cannot_access_approval_page()
    {
        // Guest dialihkan ke login
        $guestResponse = $this->get(route('wali.pengajuan.index'));
        $guestResponse->assertRedirect(route('login'));

        // Guru BK tidak dapat mengakses rute persetujuan wali kelas (403)
        $bkResponse = $this->actingAs($this->guruBk)->get(route('wali.pengajuan.index'));
        $bkResponse->assertStatus(403);

        // Admin tidak dapat mengakses rute persetujuan wali kelas (403)
        $adminResponse = $this->actingAs($this->admin)->get(route('wali.pengajuan.index'));
        $adminResponse->assertStatus(403);
    }

    public function test_wali_kelas_session_keeps_access_to_approval_page_after_refresh()
    {
        $this->assertSame('sirasi_bk_session', config('session.cookie'));

        $loginResponse = $this->post(route('login.process'), [
            'username' => $this->waliKelasA->username,
            'password' => 'password123',
        ]);

        $loginResponse->assertRedirect(route('dashboard'));
        $this->get(route('dashboard'))
            ->assertStatus(200)
            ->assertViewIs('dashboard.wali_kelas');

        $this->get(route('wali.pengajuan.index'))
            ->assertStatus(200)
            ->assertViewIs('wali_kelas.pengajuan');

        // Refresh is another GET using the same authenticated session.
        $this->get(route('wali.pengajuan.index'))
            ->assertStatus(200)
            ->assertViewIs('wali_kelas.pengajuan');
    }

    public function test_each_role_keeps_its_session_after_refresh_without_crossing_role_boundaries()
    {
        $admin = User::create([
            'nama' => 'Admin Refresh Test',
            'username' => 'admin_refresh_' . uniqid(),
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);
        $guruBk = User::create([
            'nama' => 'Guru BK Refresh Test',
            'username' => 'gurubk_refresh_' . uniqid(),
            'password' => bcrypt('password123'),
            'role' => 'guru_bk',
        ]);

        $cases = [
            [$admin, '/users', '/wali-kelas/pengajuan', 200, 403],
            [$guruBk, '/konseling', '/wali-kelas/pengajuan', 200, 403],
            [$this->waliKelasA, '/wali-kelas/pengajuan', '/konseling', 200, 403],
        ];

        foreach ($cases as [$user, $allowedPath, $forbiddenPath, $allowedStatus, $forbiddenStatus]) {
            $this->post(route('logout'));

            $this->post(route('login.process'), [
                'username' => $user->username,
                'password' => 'password123',
            ])->assertRedirect(route('dashboard'));

            $this->get($allowedPath)->assertStatus($allowedStatus);
            $this->get($allowedPath)->assertStatus($allowedStatus); // refresh
            $this->get($forbiddenPath)->assertStatus($forbiddenStatus);
        }
    }

    public function test_wali_kelas_can_view_only_own_class_counseling_requests()
    {
        // Buat pengajuan untuk Siswa A (Kelas 7.1)
        $pengajuanA = Penjadwalan::create([
            'id_siswa' => $this->siswaA->id_siswa,
            'tanggal' => now()->addDays(2)->format('Y-m-d'),
            'waktu_mulai' => '09:00',
            'waktu_selesai' => '09:45',
            'jenis_bimbingan' => 'Konseling Individu',
            'catatan' => 'Siswa memerlukan pendampingan belajar',
            'status' => 'Diajukan',
        ]);

        // Buat pengajuan untuk Siswa B (Kelas 7.2)
        $pengajuanB = Penjadwalan::create([
            'id_siswa' => $this->siswaB->id_siswa,
            'tanggal' => now()->addDays(3)->format('Y-m-d'),
            'waktu_mulai' => '10:00',
            'waktu_selesai' => '10:45',
            'jenis_bimbingan' => 'Bimbingan Karier',
            'catatan' => 'Konsultasi minat bakat',
            'status' => 'Diajukan',
        ]);

        // Akses halaman pengajuan sebagai Wali Kelas 7.1
        $response = $this->actingAs($this->waliKelasA)->get(route('wali.pengajuan.index'));

        $response->assertStatus(200);
        $response->assertViewIs('wali_kelas.pengajuan');

        // Harus melihat Siswa Kelas 7.1
        $response->assertSee('Siswa Kelas 7.1');
        $response->assertSee('Kelas 7.1')
            ->assertSee($pengajuanA->kode_pengajuan)
            ->assertSee('Tanggal Pengajuan')
            ->assertSee('Bidang Layanan')
            ->assertSee('Tanggal &amp; Jam Diminta', false)
            ->assertSee('Setujui')
            ->assertSee('Tolak');

        // Catatan pribadi siswa TIDAK BOLEH ditampilkan kepada Wali Kelas
        $response->assertDontSee($pengajuanA->catatan);

        // Dilarang melihat Siswa Kelas 7.2 (isolasi antarkelas)
        $response->assertDontSee('Siswa Kelas 7.2');
        $response->assertDontSee('Konsultasi minat bakat');
    }

    public function test_class_scope_is_preserved_in_search_and_dashboard_for_two_wali_accounts()
    {
        $pengajuanA = Penjadwalan::create([
            'id_siswa' => $this->siswaA->id_siswa,
            'kode_pengajuan' => 'SCOPE-A-' . uniqid(),
            'tanggal' => now()->addDays(2)->format('Y-m-d'),
            'waktu_mulai' => '09:00',
            'waktu_selesai' => '09:45',
            'jenis_bimbingan' => 'Konseling Individu',
            'status' => 'Diajukan',
        ]);
        $pengajuanB = Penjadwalan::create([
            'id_siswa' => $this->siswaB->id_siswa,
            'kode_pengajuan' => 'SCOPE-B-' . uniqid(),
            'tanggal' => now()->addDays(3)->format('Y-m-d'),
            'waktu_mulai' => '10:00',
            'waktu_selesai' => '10:45',
            'jenis_bimbingan' => 'Bimbingan Karier',
            'status' => 'Diajukan',
        ]);

        $this->assertSame($this->siswaA->id_kelas, $this->waliKelasA->kelas->id_kelas);
        $this->assertSame($this->siswaB->id_kelas, $this->waliKelasB->kelas->id_kelas);

        // Searching directly for a cross-class student or request code must not bypass the base class scope.
        $searchByStudent = $this->actingAs($this->waliKelasA)
            ->get(route('wali.pengajuan.index', ['search' => $this->siswaB->nama_siswa]))
            ->assertOk();
        $this->assertCount(0, $searchByStudent->viewData('pengajuan'));

        $searchByCode = $this->actingAs($this->waliKelasA)
            ->get(route('wali.pengajuan.index', ['search' => $pengajuanB->kode_pengajuan]))
            ->assertOk();
        $this->assertCount(0, $searchByCode->viewData('pengajuan'));

        $this->actingAs($this->waliKelasB)
            ->get(route('wali.pengajuan.index'))
            ->assertOk()
            ->assertSee($this->siswaB->nama_siswa)
            ->assertDontSee($this->siswaA->nama_siswa);

        $dashboardA = $this->actingAs($this->waliKelasA)->get(route('dashboard'));
        $dashboardA->assertOk();
        $this->assertSame(1, $dashboardA->viewData('pengajuanPending'));
        $this->assertTrue($dashboardA->viewData('jadwalSiswa')->contains('id_penjadwalan', $pengajuanA->id_penjadwalan));
        $this->assertFalse($dashboardA->viewData('jadwalSiswa')->contains('id_penjadwalan', $pengajuanB->id_penjadwalan));
    }

    public function test_wali_kelas_can_approve_counseling_request_with_optional_note()
    {
        $pengajuan = Penjadwalan::create([
            'id_siswa' => $this->siswaA->id_siswa,
            'tanggal' => now()->addDays(1)->format('Y-m-d'),
            'waktu_mulai' => '00:00:00',
            'waktu_selesai' => '00:00:00',
            'jenis_bimbingan' => 'Konseling Pribadi',
            'catatan' => null,
            'status' => 'Diajukan',
        ]);

        $catatanWali = 'Disetujui. Sudah dikoordinasikan dengan guru mapel Bahasa Indonesia.';

        $response = $this->actingAs($this->waliKelasA)->patch(
            route('wali.pengajuan.approve', $pengajuan->id_penjadwalan),
            ['catatan_wali' => $catatanWali]
        );

        $response->assertStatus(302);
        $response->assertRedirect(route('wali.pengajuan.index'));
        $response->assertSessionHas('success');

        // Verifikasi perubahan data di database (status Disetujui_Wali, BUKAN Terjadwal)
        $pengajuan->refresh();
        $this->assertEquals('Disetujui_Wali', $pengajuan->status);
        $this->assertNotEquals('Terjadwal', $pengajuan->status);
        $this->assertEquals($this->waliKelasA->id_user, $pengajuan->id_wali);
        $this->assertEquals($catatanWali, $pengajuan->catatan_wali);
        $this->assertNotNull($pengajuan->waktu_persetujuan_wali);

        // Verifikasi notifikasi terkirim untuk Guru BK
        $this->assertDatabaseHas('notifikasis', [
            'judul' => 'Izin Konseling Siswa Disetujui Wali Kelas',
            'tipe' => 'jadwal',
        ]);
    }

    public function test_wali_kelas_can_reject_counseling_request_with_mandatory_reason()
    {
        $pengajuan = Penjadwalan::create([
            'id_siswa' => $this->siswaA->id_siswa,
            'tanggal' => now()->addDays(2)->format('Y-m-d'),
            'waktu_mulai' => '00:00:00',
            'waktu_selesai' => '00:00:00',
            'jenis_bimbingan' => 'Konseling Belajar',
            'catatan' => null,
            'status' => 'Diajukan',
        ]);

        // 1. Penolakan tanpa alasan wajib gagal validasi
        $invalidResponse = $this->actingAs($this->waliKelasA)->patch(
            route('wali.pengajuan.reject', $pengajuan->id_penjadwalan),
            ['catatan_wali' => '']
        );
        $invalidResponse->assertSessionHasErrors(['catatan_wali']);

        // 2. Penolakan dengan alasan kurang dari 5 karakter wajib gagal validasi
        $shortResponse = $this->actingAs($this->waliKelasA)->patch(
            route('wali.pengajuan.reject', $pengajuan->id_penjadwalan),
            ['catatan_wali' => 'no']
        );
        $shortResponse->assertSessionHasErrors(['catatan_wali']);

        // 3. Penolakan dengan alasan valid berhasil diproses
        $alasanValid = 'Siswa ada jadwal ujian harian pada jam pelajaran tersebut.';
        $validResponse = $this->actingAs($this->waliKelasA)->patch(
            route('wali.pengajuan.reject', $pengajuan->id_penjadwalan),
            ['catatan_wali' => $alasanValid]
        );

        $validResponse->assertStatus(302);
        $validResponse->assertRedirect(route('wali.pengajuan.index'));
        $validResponse->assertSessionHas('success');

        // Verifikasi status dan audit trail
        $pengajuan->refresh();
        $this->assertEquals('Ditolak_Wali', $pengajuan->status);
        $this->assertEquals($this->waliKelasA->id_user, $pengajuan->id_wali);
        $this->assertEquals($alasanValid, $pengajuan->catatan_wali);
        $this->assertNotNull($pengajuan->waktu_persetujuan_wali);

        // Verifikasi notifikasi terkirim
        $this->assertDatabaseHas('notifikasis', [
            'judul' => 'Izin Waktu Konseling Belum Disetujui Wali Kelas',
            'tipe' => 'jadwal',
        ]);
    }

    public function test_wali_kelas_cannot_approve_or_reject_other_class_requests()
    {
        // Pengajuan milik Siswa Kelas 7.2
        $pengajuanB = Penjadwalan::create([
            'id_siswa' => $this->siswaB->id_siswa,
            'tanggal' => now()->addDays(2)->format('Y-m-d'),
            'waktu_mulai' => '00:00:00',
            'waktu_selesai' => '00:00:00',
            'jenis_bimbingan' => 'Konseling Sosial',
            'catatan' => 'Rahasia kelas 7.2',
            'status' => 'Diajukan',
        ]);

        // Wali Kelas 7.1 mencoba menyetujui pengajuan siswa Kelas 7.2 -> Wajib 403 Forbidden
        $approveAttempt = $this->actingAs($this->waliKelasA)->patch(
            route('wali.pengajuan.approve', $pengajuanB->id_penjadwalan),
            ['catatan_wali' => 'Mencoba bypass lintas kelas']
        );
        $approveAttempt->assertStatus(403);

        // Wali Kelas 7.1 mencoba menolak pengajuan siswa Kelas 7.2 -> Wajib 403 Forbidden
        $rejectAttempt = $this->actingAs($this->waliKelasA)->patch(
            route('wali.pengajuan.reject', $pengajuanB->id_penjadwalan),
            ['alasan_penolakan' => 'Mencoba tolak lintas kelas']
        );
        $rejectAttempt->assertStatus(403);

        // Status di database harus tetap murni 'Diajukan' tanpa kompromi
        $pengajuanB->refresh();
        $this->assertEquals('Diajukan', $pengajuanB->status);
        $this->assertNull($pengajuanB->id_wali);
    }

    public function test_cannot_approve_or_reject_already_scheduled_or_processed_counseling()
    {
        // 1. Permohonan yang sudah Disetujui_Wali tidak boleh disetujui atau ditolak ulang
        $disetujui = Penjadwalan::create([
            'id_siswa' => $this->siswaA->id_siswa,
            'tanggal' => now()->addDays(2)->format('Y-m-d'),
            'waktu_mulai' => '00:00:00',
            'waktu_selesai' => '00:00:00',
            'jenis_bimbingan' => 'Konseling Individu',
            'status' => 'Disetujui_Wali',
            'id_wali' => $this->waliKelasA->id_user,
            'catatan_wali' => 'Sudah disetujui pertama kali',
        ]);

        $reApproveResponse = $this->actingAs($this->waliKelasA)->patch(
            route('wali.pengajuan.approve', $disetujui->id_penjadwalan),
            ['catatan_wali' => 'Coba approve kedua kali']
        );
        $reApproveResponse->assertRedirect();
        $reApproveResponse->assertSessionHas('error');

        $reRejectResponse = $this->actingAs($this->waliKelasA)->patch(
            route('wali.pengajuan.reject', $disetujui->id_penjadwalan),
            ['catatan_wali' => 'Coba ubah jadi ditolak setelah disetujui']
        );
        $reRejectResponse->assertRedirect();
        $reRejectResponse->assertSessionHas('error');

        $disetujui->refresh();
        $this->assertEquals('Disetujui_Wali', $disetujui->status);
        $this->assertEquals('Sudah disetujui pertama kali', $disetujui->catatan_wali);

        // 2. Jadwal yang sudah dikonfirmasi Guru BK ('Terjadwal')
        $terjadwal = Penjadwalan::create([
            'id_siswa' => $this->siswaA->id_siswa,
            'tanggal' => now()->addDays(3)->format('Y-m-d'),
            'waktu_mulai' => '08:30',
            'waktu_selesai' => '09:15',
            'jenis_bimbingan' => 'Konseling Individu',
            'catatan' => 'Sudah terjadwal resmi',
            'status' => 'Terjadwal',
        ]);

        $response = $this->actingAs($this->waliKelasA)->patch(
            route('wali.pengajuan.approve', $terjadwal->id_penjadwalan),
            ['catatan_wali' => 'Approve ulang']
        );

        $response->assertStatus(302);
        $response->assertSessionHas('error');

        $terjadwal->refresh();
        $this->assertEquals('Terjadwal', $terjadwal->status);
    }
}
