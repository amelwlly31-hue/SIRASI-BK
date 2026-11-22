<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Penjadwalan;
use App\Models\SlotKonseling;
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

    public function test_guest_can_open_public_portal_without_login()
    {
        $indexResponse = $this->get(route('portal.siswa.index'));
        $indexResponse->assertStatus(200);
        $indexResponse->assertSee('Izin Wali Kelas');
        $indexResponse->assertSee('Jadwal Konseling');
        $indexResponse->assertSee('Cek Status');
        $indexResponse->assertSee('Tentang');

        $createResponse = $this->get(route('portal.siswa.create'));
        $createResponse->assertStatus(200);
        $createResponse->assertSee('Tahap 1 — Ajukan Permohonan Izin kepada Wali Kelas');
        $createResponse->assertDontSee('Tahap 2 — Jadwal Konseling kepada Guru BK');
        $createResponse->assertSee('Jadwal Konseling');

        $lockedScheduleResponse = $this->get(route('portal.siswa.jadwal'));
        $lockedScheduleResponse->assertRedirect(route('portal.siswa.create'));

        $statusResponse = $this->get(route('portal.siswa.status'));
        $statusResponse->assertStatus(200);
        $statusResponse->assertSee('Izin Wali Kelas');
        $statusResponse->assertSee('Jadwal Konseling');

        $aboutResponse = $this->get(route('portal.siswa.tentang'));
        $aboutResponse->assertStatus(200);
        $aboutResponse->assertSee('Izin Wali Kelas');
        $aboutResponse->assertSee('Jadwal Konseling');
    }

    public function test_student_can_submit_permission_request_to_wali_kelas()
    {
        $response = $this->post(route('portal.siswa.izin'), [
            'id_kelas' => $this->kelas->id_kelas,
            'id_siswa' => $this->siswa->id_siswa,
            'jenis_bimbingan' => 'Konseling Belajar',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Permohonan izin berhasil dikirim, menunggu persetujuan Wali Kelas');

        $izin = Penjadwalan::where('id_siswa', $this->siswa->id_siswa)->latest('id_penjadwalan')->first();
        $this->assertNotNull($izin);
        $this->assertNotEmpty($izin->kode_pengajuan);
        $this->assertEquals('Diajukan', $izin->status);
        $this->assertFalse($izin->hasSubmittedSchedule());
        $this->assertNull($izin->catatan);

        $dashboard = $this->actingAs($this->waliKelas)->get(route('dashboard'));
        $dashboard->assertStatus(200);
        $dashboard->assertSee($this->siswa->nama_siswa);
        $dashboard->assertSee('Menunggu Persetujuan Wali Kelas');

        $approvalPage = $this->get(route('wali.pengajuan.index'));
        $approvalPage->assertStatus(200);
        $approvalPage->assertSee($this->siswa->nama_siswa);
        $approvalPage->assertSee($izin->kode_pengajuan);
    }

    public function test_existing_student_from_another_class_can_submit_and_refresh_persisted_permission()
    {
        // Use a real active student already in the database, not a generated student fixture.
        $siswaLain = Siswa::where('status', 'Aktif')
            ->where('id_kelas', '<>', $this->kelas->id_kelas)
            ->whereDoesntHave('penjadwalan', function ($query) {
                $query->whereIn('status', ['Diajukan', 'Disetujui_Wali']);
            })
            ->orderBy('id_siswa')
            ->first();

        $this->assertNotNull($siswaLain, 'An existing active student without a pending permission is required for this integration check.');

        // Temporarily associate the transactional Wali account with the real student's class.
        // DatabaseTransactions restores this mapping and the new permission after the test.
        $this->waliKelas->update(['id_kelas' => $siswaLain->id_kelas]);

        $response = $this->post(route('portal.siswa.izin'), [
            'id_kelas' => $siswaLain->id_kelas,
            'id_siswa' => $siswaLain->id_siswa,
            'jenis_bimbingan' => 'Konseling Sosial',
        ]);

        $izin = Penjadwalan::where('id_siswa', $siswaLain->id_siswa)
            ->latest('id_penjadwalan')
            ->first();
        $this->assertNotNull($izin);
        $this->assertSame('Diajukan', $izin->status);
        $this->assertSame($siswaLain->id_kelas, $izin->siswa->id_kelas);
        $this->assertMatchesRegularExpression('/^BK-[A-Z0-9]{6}$/', $izin->kode_pengajuan);
        $response->assertRedirect(route('portal.siswa.create', [
            'kode_pengajuan' => $izin->kode_pengajuan,
            'konfirmasi_izin' => 1,
        ]));

        $confirmationUrl = $response->headers->get('Location');
        $confirmation = $this->get($confirmationUrl);
        $confirmation->assertOk()
            ->assertSee('Permohonan izin berhasil dikirim, menunggu persetujuan Wali Kelas')
            ->assertSee($izin->kode_pengajuan);
        $this->assertNull($confirmation->viewData('lockedSiswa'));
        $this->assertNull($confirmation->viewData('izinAktif'));

        $html = $confirmation->getContent();
        preg_match('/<select\s+id="izinKelasSelect".*?<\/select>/s', $html, $kelasForm);
        preg_match('/<select\s+id="izinSiswaSelect".*?<\/select>/s', $html, $siswaForm);
        preg_match('/<select\s+id="izinJenisBimbinganSelect".*?<\/select>/s', $html, $layananForm);
        $this->assertNotEmpty($kelasForm);
        $this->assertNotEmpty($siswaForm);
        $this->assertNotEmpty($layananForm);
        $this->assertSame(0, preg_match('/\bselected\b/', $kelasForm[0]));
        $this->assertSame(0, preg_match('/\bselected\b/', $siswaForm[0]));
        $this->assertSame(1, preg_match('/<option value="Konseling Individu"\s+selected>/', $layananForm[0]));
        $this->assertSame(0, preg_match('/<option value="Konseling Sosial"\s+selected>/', $layananForm[0]));

        // Refresh remains a database-backed confirmation and the Wali sees the stored row.
        $refreshed = $this->get($confirmationUrl);
        $refreshed->assertOk()->assertSee($izin->kode_pengajuan);
        $dashboard = $this->actingAs($this->waliKelas)->get(route('dashboard'));
        $dashboard->assertOk()->assertSee($siswaLain->nama_siswa);
        $approval = $this->get(route('wali.pengajuan.index'));
        $approval->assertOk()->assertSee($siswaLain->nama_siswa)->assertSee($izin->kode_pengajuan);
    }

    public function test_student_cannot_submit_schedule_without_approved_wali_permission()
    {
        $tglBimbingan = now()->addDays(2)->format('Y-m-d');

        // 1. Belum pernah mengajukan izin sama sekali -> Ditolak
        $noPermissionResponse = $this->post(route('portal.siswa.ajukan'), [
            'id_kelas' => $this->kelas->id_kelas,
            'id_siswa' => $this->siswa->id_siswa,
            'tanggal' => $tglBimbingan,
            'waktu_mulai' => '08:30',
            'waktu_selesai' => '09:15',
            'jenis_bimbingan' => 'Konseling Belajar',
            'catatan' => 'Catatan rahasia',
        ]);
        $noPermissionResponse->assertSessionHasErrors(['izin_wali']);
        $this->assertEquals(0, Penjadwalan::where('id_siswa', $this->siswa->id_siswa)->count());

        // 2. Sudah mengajukan izin, tetapi status masih 'Diajukan' (menunggu Wali Kelas) -> Ditolak
        $izinPending = Penjadwalan::create([
            'kode_pengajuan' => Penjadwalan::generateKodePengajuan(),
            'id_siswa' => $this->siswa->id_siswa,
            'tanggal' => now()->format('Y-m-d'),
            'waktu_mulai' => '00:00:00',
            'waktu_selesai' => '00:00:00',
            'jenis_bimbingan' => 'Konseling Belajar',
            'status' => 'Diajukan',
        ]);

        $pendingResponse = $this->post(route('portal.siswa.ajukan'), [
            'id_kelas' => $this->kelas->id_kelas,
            'id_siswa' => $this->siswa->id_siswa,
            'kode_pengajuan' => $izinPending->kode_pengajuan,
            'tanggal' => $tglBimbingan,
            'waktu_mulai' => '08:30',
            'waktu_selesai' => '09:15',
            'jenis_bimbingan' => 'Konseling Belajar',
        ]);
        $pendingResponse->assertSessionHasErrors(['izin_wali']);
        $izinPending->refresh();
        $this->assertFalse($izinPending->hasSubmittedSchedule());

        // 3. Izin ditolak oleh Wali Kelas ('Ditolak_Wali') -> Ditolak mengajukan jadwal
        $izinPending->update([
            'status' => 'Ditolak_Wali',
            'id_wali' => $this->waliKelas->id_user,
            'catatan_wali' => 'Ada ulangan harian.',
        ]);

        $rejectedResponse = $this->post(route('portal.siswa.ajukan'), [
            'id_kelas' => $this->kelas->id_kelas,
            'id_siswa' => $this->siswa->id_siswa,
            'kode_pengajuan' => $izinPending->kode_pengajuan,
            'tanggal' => $tglBimbingan,
            'waktu_mulai' => '08:30',
            'waktu_selesai' => '09:15',
            'jenis_bimbingan' => 'Konseling Belajar',
        ]);
        $rejectedResponse->assertSessionHasErrors(['izin_wali']);
        $izinPending->refresh();
        $this->assertFalse($izinPending->hasSubmittedSchedule());
    }

    public function test_schedule_page_requires_approved_permission_and_displays_only_schedule_step()
    {
        $izin = Penjadwalan::create([
            'kode_pengajuan' => Penjadwalan::generateKodePengajuan(),
            'id_siswa' => $this->siswa->id_siswa,
            'tanggal' => now()->format('Y-m-d'),
            'waktu_mulai' => '00:00:00',
            'waktu_selesai' => '00:00:00',
            'jenis_bimbingan' => 'Konseling Belajar',
            'status' => 'Diajukan',
            'id_wali' => $this->waliKelas->id_user,
        ]);

        $scheduleUrl = route('portal.siswa.jadwal', [
            'id_kelas' => $this->kelas->id_kelas,
            'id_siswa' => $this->siswa->id_siswa,
            'kode_pengajuan' => $izin->kode_pengajuan,
        ]);

        $this->get($scheduleUrl)->assertRedirect(route('portal.siswa.create'));

        $izin->update(['status' => 'Disetujui_Wali']);
        $response = $this->get($scheduleUrl);

        $response->assertStatus(200);
        $response->assertSee('Jadwal Konseling');
        $response->assertSee('Tahap 2 — Jadwal Konseling kepada Guru BK');
        $response->assertDontSee('Tahap 1 — Ajukan Permohonan Izin kepada Wali Kelas');
        $response->assertSee('Izin Wali Kelas');
        $response->assertSee('Cek Status');
        $response->assertSee('Tentang');
    }

    public function test_selecting_name_alone_is_not_enough_to_submit_schedule_or_view_status()
    {
        $izinApproved = Penjadwalan::create([
            'kode_pengajuan' => Penjadwalan::generateKodePengajuan(),
            'id_siswa' => $this->siswa->id_siswa,
            'tanggal' => now()->format('Y-m-d'),
            'waktu_mulai' => '00:00:00',
            'waktu_selesai' => '00:00:00',
            'jenis_bimbingan' => 'Konseling Pribadi',
            'status' => 'Disetujui_Wali',
            'id_wali' => $this->waliKelas->id_user,
        ]);

        // 1. Siswa lain mencoba mengajukan jadwal hanya dengan memilih kelas & nama tanpa kode_pengajuan
        $spoofScheduleResponse = $this->post(route('portal.siswa.ajukan'), [
            'id_kelas' => $this->kelas->id_kelas,
            'id_siswa' => $this->siswa->id_siswa,
            'kode_pengajuan' => '',
            'tanggal' => now()->addDays(2)->format('Y-m-d'),
            'waktu_mulai' => '09:00',
            'waktu_selesai' => '09:45',
            'jenis_bimbingan' => 'Konseling Pribadi',
        ]);
        $spoofScheduleResponse->assertSessionHasErrors(['kode_pengajuan']);
        $izinApproved->refresh();
        $this->assertFalse($izinApproved->hasSubmittedSchedule());

        // 2. Siswa lain mencoba melihat status hanya dengan memilih kelas & nama tanpa kode_pengajuan
        $spoofStatusResponse = $this->post(route('portal.siswa.status'), [
            'id_kelas' => $this->kelas->id_kelas,
            'id_siswa' => $this->siswa->id_siswa,
        ]);
        $spoofStatusResponse->assertStatus(200);
        $spoofStatusResponse->assertSee('Verifikasi Diperlukan');
        $spoofStatusResponse->assertDontSee($izinApproved->kode_pengajuan);
    }

    public function test_student_request_fails_if_time_conflicts_with_existing_schedule()
    {
        $tglBimbingan = now()->addDays(3)->format('Y-m-d');

        // Jadwal aktif Guru BK: 10:00 - 11:00
        Penjadwalan::create([
            'kode_pengajuan' => Penjadwalan::generateKodePengajuan(),
            'id_siswa' => $this->siswa->id_siswa,
            'tanggal' => $tglBimbingan,
            'waktu_mulai' => '10:00',
            'waktu_selesai' => '11:00',
            'jenis_bimbingan' => 'Konseling Karir',
            'status' => 'Terjadwal',
        ]);

        // Siswa 2 sudah mendapat izin Wali Kelas
        $siswa2 = Siswa::create([
            'nis' => 'TESTNIS2_' . rand(1000, 9999),
            'nama_siswa' => 'Siswa Kedua Test',
            'jenis_kelamin' => 'P',
            'id_kelas' => $this->kelas->id_kelas,
            'status' => 'Aktif',
        ]);

        $izinSiswa2 = Penjadwalan::create([
            'kode_pengajuan' => Penjadwalan::generateKodePengajuan(),
            'id_siswa' => $siswa2->id_siswa,
            'tanggal' => now()->format('Y-m-d'),
            'waktu_mulai' => '00:00:00',
            'waktu_selesai' => '00:00:00',
            'jenis_bimbingan' => 'Konseling Pribadi',
            'status' => 'Disetujui_Wali',
            'id_wali' => $this->waliKelas->id_user,
        ]);

        // Siswa 2 mencoba mengajukan di rentang bertabrakan: 10:30 - 11:30
        $response = $this->post(route('portal.siswa.ajukan'), [
            'id_kelas' => $this->kelas->id_kelas,
            'id_siswa' => $siswa2->id_siswa,
            'kode_pengajuan' => $izinSiswa2->kode_pengajuan,
            'tanggal' => $tglBimbingan,
            'waktu_mulai' => '10:30',
            'waktu_selesai' => '11:30',
            'jenis_bimbingan' => 'Konseling Pribadi',
        ]);

        $response->assertSessionHasErrors(['waktu_mulai']);
        $izinSiswa2->refresh();
        $this->assertFalse($izinSiswa2->hasSubmittedSchedule());
    }

    public function test_end_to_end_wali_permission_then_student_schedule_then_bk_confirmation()
    {
        $tglBimbingan = now()->addDays(4)->format('Y-m-d');

        // Slot yang dipilih pada Tahap 1 hanya menjadi konteks permohonan izin.
        $slot = SlotKonseling::create([
            'id_user' => $this->guruBk->id_user,
            'tanggal' => $tglBimbingan,
            'waktu_mulai' => '08:30:00',
            'waktu_selesai' => '09:15:00',
            'durasi_menit' => 45,
            'status' => 'Tersedia',
            'keterangan' => 'Slot Pagi 45 Menit',
        ]);

        // 1. Siswa mengajukan permohonan izin ke Wali Kelas (Tahap 1)
        $izinResponse = $this->post(route('portal.siswa.izin'), [
            'id_kelas' => $this->kelas->id_kelas,
            'id_siswa' => $this->siswa->id_siswa,
            'jenis_bimbingan' => 'Konseling Sosial',
            'id_slot' => $slot->id_slot,
            'tanggal' => $tglBimbingan,
            'waktu_mulai' => '08:30',
            'waktu_selesai' => '09:15',
        ]);
        $izinResponse->assertRedirect();

        $pengajuan = Penjadwalan::where('id_siswa', $this->siswa->id_siswa)->latest('id_penjadwalan')->first();
        $this->assertNotNull($pengajuan);
        $this->assertEquals('Diajukan', $pengajuan->status);
        $this->assertFalse($pengajuan->hasSubmittedSchedule());
        $this->assertNull($pengajuan->id_slot);
        $slot->refresh();
        $this->assertEquals('Tersedia', $slot->status_slot);

        $statusBeforeApproval = $this->get(route('portal.siswa.status', ['kode_pengajuan' => $pengajuan->kode_pengajuan]));
        $statusBeforeApproval->assertStatus(200);
        $statusBeforeApproval->assertSee('Tanggal Permohonan Izin');
        $statusBeforeApproval->assertDontSee('<div class="status-info-label">Waktu Jadwal</div>', false);
        $statusBeforeApproval->assertDontSee('Terjadwal Resmi');

        // 2. Wali Kelas login dan menyetujui permohonan izin siswa di kelasnya
        $approveResponse = $this->actingAs($this->waliKelas)->patch(
            route('wali.pengajuan.approve', $pengajuan->id_penjadwalan),
            ['catatan_wali' => 'Diizinkan mengikuti bimbingan konseling.']
        );
        $approveResponse->assertRedirect(route('wali.pengajuan.index'));

        $pengajuan->refresh();
        $this->assertEquals('Disetujui_Wali', $pengajuan->status);
        $this->assertEquals($this->waliKelas->id_user, $pengajuan->id_wali);
        $this->assertFalse($pengajuan->hasSubmittedSchedule());
        $slot->refresh();
        $this->assertEquals('Tersedia', $slot->status_slot);

        $schedulePage = $this->get(route('portal.siswa.jadwal', [
            'id_kelas' => $this->kelas->id_kelas,
            'id_siswa' => $this->siswa->id_siswa,
            'kode_pengajuan' => $pengajuan->kode_pengajuan,
        ]));
        $schedulePage->assertStatus(200);
        $schedulePage->assertSee('Tahap 2 — Jadwal Konseling kepada Guru BK');

        // 3. Setelah izin disetujui Wali Kelas, siswa mengajukan jadwal konseling beserta catatan rahasia untuk Guru BK
        $catatanRahasiaSiswa = 'Rahasia hanya untuk Guru BK: masalah pertemanan di kelas.';
        $scheduleResponse = $this->post(route('portal.siswa.ajukan'), [
            'id_kelas' => $this->kelas->id_kelas,
            'id_siswa' => $this->siswa->id_siswa,
            'kode_pengajuan' => $pengajuan->kode_pengajuan,
            'id_slot' => $slot->id_slot,
            'tanggal' => $tglBimbingan,
            'waktu_mulai' => '08:30',
            'waktu_selesai' => '09:15',
            'jenis_bimbingan' => 'Konseling Sosial',
            'catatan' => $catatanRahasiaSiswa,
        ]);
        $scheduleResponse->assertRedirect();
        $scheduleResponse->assertSessionHas('pengajuan_berhasil', true);

        $pengajuan->refresh();
        $slot->refresh();
        // Persetujuan izin Wali Kelas TIDAK otomatis membuat jadwal menjadi 'Terjadwal' oleh Guru BK
        $this->assertEquals('Disetujui_Wali', $pengajuan->status);
        $this->assertNotEquals('Terjadwal', $pengajuan->status);
        $this->assertTrue($pengajuan->hasSubmittedSchedule());
        $this->assertEquals($slot->id_slot, $pengajuan->id_slot);
        $this->assertEquals('Menunggu_Diproses', $slot->status);
        $this->assertEquals('08:30:00', $pengajuan->waktu_mulai);
        $this->assertEquals('09:15:00', $pengajuan->waktu_selesai);
        $this->assertEquals($catatanRahasiaSiswa, $pengajuan->catatan);

        $statusAwaitingBk = $this->get(route('portal.siswa.status', ['kode_pengajuan' => $pengajuan->kode_pengajuan]));
        $statusAwaitingBk->assertStatus(200);
        $statusAwaitingBk->assertSee('Izin Diterima (Menunggu Jadwal BK)');
        $statusAwaitingBk->assertDontSee('Terjadwal Resmi');
        $statusAwaitingBk->assertDontSee('<div class="status-info-label">Waktu Jadwal</div>', false);

        // 4. Pastikan halaman Wali Kelas TIDAK menampilkan catatan pribadi konseling siswa tersebut
        $waliPageResponse = $this->actingAs($this->waliKelas)->get(route('wali.pengajuan.index'));
        $waliPageResponse->assertStatus(200);
        $waliPageResponse->assertDontSee($catatanRahasiaSiswa);

        // 5. Guru BK menetapkan jadwal resmi menjadi 'Terjadwal'
        $updateResponse = $this->actingAs($this->guruBk)->put(
            route('penjadwalan.update', $pengajuan->id_penjadwalan),
            [
                'id_siswa' => $this->siswa->id_siswa,
                'tanggal' => $tglBimbingan,
                'waktu_mulai' => '08:30',
                'waktu_selesai' => '09:15',
                'jenis_bimbingan' => 'Konseling Sosial',
                'catatan' => $catatanRahasiaSiswa,
                'status' => 'Terjadwal',
            ]
        );
        $updateResponse->assertRedirect(route('penjadwalan.show', $pengajuan->id_penjadwalan));

        $pengajuan->refresh();
        $slot->refresh();
        $this->assertEquals('Terjadwal', $pengajuan->status);
        $this->assertEquals('Dipesan', $slot->status);

        $statusAfterConfirmation = $this->get(route('portal.siswa.status', ['kode_pengajuan' => $pengajuan->kode_pengajuan]));
        $statusAfterConfirmation->assertStatus(200);
        $statusAfterConfirmation->assertSee('Terjadwal Resmi dengan Guru BK');
        $statusAfterConfirmation->assertSee('Waktu Jadwal');
    }

    public function test_slot_checker_moved_to_beranda_and_shows_opened_slots_from_db()
    {
        $testDate = now()->addDays(3)->format('Y-m-d');
        $formattedDate = now()->addDays(3)->format('d/m/Y');

        // 1. Beranda memuat fitur Cek Slot Ketersediaan Konseling Guru BK di search bar atas
        $indexResponse = $this->get(route('portal.siswa.index'));
        $indexResponse->assertStatus(200);
        $indexResponse->assertSee('Cek Slot Ketersediaan Konseling Guru BK');
        $indexResponse->assertSee('Cek Slot Konseling');
        // Saat pertama kali dibuka tanpa menekan tombol cek, notifikasi pesan tidak muncul
        $indexResponse->assertDontSee('Slot konseling belum tersedia pada tanggal');
        $indexResponse->assertDontSee('Slot konseling pada tanggal');
        // Bagian hasil cek slot dan alur di bawah halaman sudah dihapus
        $indexResponse->assertDontSee('slot-section');
        $indexResponse->assertDontSee('Daftar Slot Kosong Mendatang');

        // 2. Cek tanggal yang belum dibuka slotnya oleh Guru BK -> Pesan singkat muncul dengan format dd/mm/yyyy
        $emptyDate = now()->addDays(5)->format('Y-m-d');
        $emptyFormatted = now()->addDays(5)->format('d/m/Y');
        $emptyCheckResponse = $this->get(route('portal.siswa.index', ['tanggal_cek' => $emptyDate]));
        $emptyCheckResponse->assertStatus(200);
        $emptyCheckResponse->assertSee("Slot konseling belum tersedia pada tanggal {$emptyFormatted}. Silakan pilih tanggal lain.");

        // 3. Guru BK membuka slot konseling di database
        $slot = SlotKonseling::create([
            'id_user' => $this->guruBk->id_user,
            'tanggal' => $testDate,
            'waktu_mulai' => '10:00:00',
            'waktu_selesai' => '10:45:00',
            'durasi_menit' => 45,
            'status' => 'Tersedia',
            'keterangan' => 'Slot Uji Coba Beranda',
        ]);

        // Cek slot pada tanggal tersebut via query tanggal_cek di Beranda (mendukung format Y-m-d maupun dd/mm/yyyy)
        $checkResponse = $this->get(route('portal.siswa.index', ['tanggal_cek' => $testDate]));
        $checkResponse->assertStatus(200);
        $checkResponse->assertSee($formattedDate);
        $checkResponse->assertSee('10:00 - 10:45 WIB');
        $checkResponse->assertSee('Slot Kosong (Tersedia)');
        $checkResponse->assertSee('Izin Wali Kelas');

        $checkDmyResponse = $this->get(route('portal.siswa.index', ['tanggal_cek' => $formattedDate]));
        $checkDmyResponse->assertStatus(200);
        $checkDmyResponse->assertSee($formattedDate);
        $checkDmyResponse->assertSee('10:00 - 10:45 WIB');

        // Jika slot sudah diajukan siswa lain (ada pengajuan aktif) -> Tampilkan pesan singkat sesuai permintaan
        $pengajuanLain = Penjadwalan::create([
            'kode_pengajuan' => Penjadwalan::generateKodePengajuan(),
            'id_siswa' => $this->siswa->id_siswa,
            'id_slot' => $slot->id_slot,
            'tanggal' => $testDate,
            'waktu_mulai' => '10:00:00',
            'waktu_selesai' => '10:45:00',
            'jenis_bimbingan' => 'Konseling Pribadi',
            'status' => 'Diajukan',
            'id_wali' => $this->waliKelas->id_user,
        ]);
        $bookedResponse = $this->get(route('portal.siswa.index', ['tanggal_cek' => $testDate]));
        $bookedResponse->assertStatus(200);
        $bookedResponse->assertSee("Slot konseling pada tanggal {$formattedDate} sudah diajukan oleh siswa lain. Silakan pilih tanggal lain.");

        // 4. Pastikan fitur cek slot telah dipisahkan dari halaman Ajukan Jadwal Konseling
        $izin = Penjadwalan::create([
            'kode_pengajuan' => Penjadwalan::generateKodePengajuan(),
            'id_siswa' => $this->siswa->id_siswa,
            'tanggal' => now()->format('Y-m-d'),
            'waktu_mulai' => '00:00:00',
            'waktu_selesai' => '00:00:00',
            'jenis_bimbingan' => 'Konseling Belajar',
            'status' => 'Disetujui_Wali',
            'id_wali' => $this->waliKelas->id_user,
        ]);

        $schedulePage = $this->get(route('portal.siswa.jadwal', [
            'id_kelas' => $this->kelas->id_kelas,
            'id_siswa' => $this->siswa->id_siswa,
            'kode_pengajuan' => $izin->kode_pengajuan,
        ]));

        $schedulePage->assertStatus(200);
        // Fitur cek slot tidak lagi berada di halaman formulir pengajuan jadwal
        $schedulePage->assertDontSee('Cek Slot Konseling');
        // Namun formulir pengajuan dan dropdown slot tetap dipertahankan
        $schedulePage->assertSee('formAjukanBimbingan');
        $schedulePage->assertSee('slotSelectInput');
        $schedulePage->assertSee('Pilih Slot Ketersediaan Konseling Guru BK');
    }
}
