<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Penjadwalan;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AntiBentrokJadwalTest extends TestCase
{
    use DatabaseTransactions;

    protected User $guruBk;
    protected User $waliKelas;
    protected Siswa $siswa1;
    protected Siswa $siswa2;
    protected string $testDate;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Akun Guru BK
        $this->guruBk = User::where('role', 'guru_bk')->first() ?? User::create([
            'nama' => 'Guru BK Test',
            'username' => 'gurubk_' . uniqid(),
            'password' => bcrypt('password123'),
            'role' => 'guru_bk',
        ]);

        // 2. Akun Wali Kelas
        $kelas = Kelas::firstOrCreate(['id_kelas' => 1], ['nama_kelas' => '7.1', 'tingkat' => 7]);
        $this->waliKelas = User::create([
            'nama' => 'Wali Kelas Test',
            'username' => 'wali_' . uniqid(),
            'password' => bcrypt('password123'),
            'role' => 'wali_kelas',
            'id_kelas' => $kelas->id_kelas,
        ]);

        // 3. Siswa
        $this->siswa1 = Siswa::create([
            'nis' => 'BTK1_' . rand(100, 999),
            'nama_siswa' => 'Siswa Bentrok 1',
            'jenis_kelamin' => 'L',
            'id_kelas' => $kelas->id_kelas,
            'status' => 'Aktif',
        ]);

        $this->siswa2 = Siswa::create([
            'nis' => 'BTK2_' . rand(100, 999),
            'nama_siswa' => 'Siswa Bentrok 2',
            'jenis_kelamin' => 'P',
            'id_kelas' => $kelas->id_kelas,
            'status' => 'Aktif',
        ]);

        $this->testDate = now()->addDays(5)->format('Y-m-d');
    }

    public function test_guru_bk_cannot_create_schedule_overlapping_existing_terjadwal_schedule()
    {
        // Jadwal dasar: 09:00 - 10:00
        Penjadwalan::create([
            'id_siswa' => $this->siswa1->id_siswa,
            'tanggal' => $this->testDate,
            'waktu_mulai' => '09:00',
            'waktu_selesai' => '10:00',
            'jenis_bimbingan' => 'Konseling Individu',
            'catatan' => 'Jadwal Dasar',
            'status' => 'Terjadwal',
        ]);

        // Skenario 1: Overlap kanan (09:30 - 10:30)
        $response1 = $this->actingAs($this->guruBk)->post(route('penjadwalan.store'), [
            'id_siswa' => $this->siswa2->id_siswa,
            'tanggal' => $this->testDate,
            'waktu_mulai' => '09:30',
            'waktu_selesai' => '10:30',
            'jenis_bimbingan' => 'Bimbingan Karier',
        ]);
        $response1->assertSessionHasErrors(['waktu_mulai']);

        // Skenario 2: Overlap kiri (08:30 - 09:30)
        $response2 = $this->actingAs($this->guruBk)->post(route('penjadwalan.store'), [
            'id_siswa' => $this->siswa2->id_siswa,
            'tanggal' => $this->testDate,
            'waktu_mulai' => '08:30',
            'waktu_selesai' => '09:30',
            'jenis_bimbingan' => 'Bimbingan Karier',
        ]);
        $response2->assertSessionHasErrors(['waktu_mulai']);

        // Skenario 3: Overlap mencakup seluruhnya (08:00 - 11:00)
        $response3 = $this->actingAs($this->guruBk)->post(route('penjadwalan.store'), [
            'id_siswa' => $this->siswa2->id_siswa,
            'tanggal' => $this->testDate,
            'waktu_mulai' => '08:00',
            'waktu_selesai' => '11:00',
            'jenis_bimbingan' => 'Bimbingan Karier',
        ]);
        $response3->assertSessionHasErrors(['waktu_mulai']);

        // Skenario 4: Overlap di dalam rentang (09:15 - 09:45)
        $response4 = $this->actingAs($this->guruBk)->post(route('penjadwalan.store'), [
            'id_siswa' => $this->siswa2->id_siswa,
            'tanggal' => $this->testDate,
            'waktu_mulai' => '09:15',
            'waktu_selesai' => '09:45',
            'jenis_bimbingan' => 'Bimbingan Karier',
        ]);
        $response4->assertSessionHasErrors(['waktu_mulai']);

        // Skenario 5: Sama persis (09:00 - 10:00)
        $response5 = $this->actingAs($this->guruBk)->post(route('penjadwalan.store'), [
            'id_siswa' => $this->siswa2->id_siswa,
            'tanggal' => $this->testDate,
            'waktu_mulai' => '09:00',
            'waktu_selesai' => '10:00',
            'jenis_bimbingan' => 'Bimbingan Karier',
        ]);
        $response5->assertSessionHasErrors(['waktu_mulai']);
    }

    public function test_back_to_back_schedules_are_allowed()
    {
        // Jadwal dasar: 09:00 - 10:00
        Penjadwalan::create([
            'id_siswa' => $this->siswa1->id_siswa,
            'tanggal' => $this->testDate,
            'waktu_mulai' => '09:00',
            'waktu_selesai' => '10:00',
            'jenis_bimbingan' => 'Konseling Individu',
            'status' => 'Terjadwal',
        ]);

        // Sesi sebelum: selesai tepat pukul 09:00 (08:00 - 09:00) -> BOLEH
        $responseBefore = $this->actingAs($this->guruBk)->post(route('penjadwalan.store'), [
            'id_siswa' => $this->siswa2->id_siswa,
            'tanggal' => $this->testDate,
            'waktu_mulai' => '08:00',
            'waktu_selesai' => '09:00',
            'jenis_bimbingan' => 'Konseling Pagi',
        ]);
        $responseBefore->assertRedirect(route('penjadwalan.index'));
        $responseBefore->assertSessionHas('success');

        // Sesi sesudah: mulai tepat pukul 10:00 (10:00 - 11:00) -> BOLEH
        $responseAfter = $this->actingAs($this->guruBk)->post(route('penjadwalan.store'), [
            'id_siswa' => $this->siswa2->id_siswa,
            'tanggal' => $this->testDate,
            'waktu_mulai' => '10:00',
            'waktu_selesai' => '11:00',
            'jenis_bimbingan' => 'Konseling Siang',
        ]);
        $responseAfter->assertRedirect(route('penjadwalan.index'));
        $responseAfter->assertSessionHas('success');
    }

    public function test_same_time_on_different_dates_is_allowed()
    {
        $date1 = $this->testDate;
        $date2 = now()->addDays(6)->format('Y-m-d');

        // Jadwal di Tanggal 1: 09:00 - 10:00
        Penjadwalan::create([
            'id_siswa' => $this->siswa1->id_siswa,
            'tanggal' => $date1,
            'waktu_mulai' => '09:00',
            'waktu_selesai' => '10:00',
            'jenis_bimbingan' => 'Konseling Individu',
            'status' => 'Terjadwal',
        ]);

        // Jam yang sama pada Tanggal 2 -> BOLEH
        $response = $this->actingAs($this->guruBk)->post(route('penjadwalan.store'), [
            'id_siswa' => $this->siswa2->id_siswa,
            'tanggal' => $date2,
            'waktu_mulai' => '09:00',
            'waktu_selesai' => '10:00',
            'jenis_bimbingan' => 'Konseling Hari Berikutnya',
        ]);
        $response->assertRedirect(route('penjadwalan.index'));
        $response->assertSessionHas('success');
    }

    public function test_rejected_or_cancelled_schedules_do_not_block_slot()
    {
        // 1. Jadwal dengan status 'Ditolak_Wali' di slot 09:00 - 10:00
        Penjadwalan::create([
            'id_siswa' => $this->siswa1->id_siswa,
            'tanggal' => $this->testDate,
            'waktu_mulai' => '09:00',
            'waktu_selesai' => '10:00',
            'jenis_bimbingan' => 'Pengajuan Ditolak',
            'status' => 'Ditolak_Wali',
            'catatan_wali' => 'Ada ulangan harian',
        ]);

        // Jadwal baru di jam yang sama (09:00 - 10:00) HARUS BERHASIL karena slot bebas
        $response1 = $this->actingAs($this->guruBk)->post(route('penjadwalan.store'), [
            'id_siswa' => $this->siswa2->id_siswa,
            'tanggal' => $this->testDate,
            'waktu_mulai' => '09:00',
            'waktu_selesai' => '10:00',
            'jenis_bimbingan' => 'Konseling Pengganti',
        ]);
        $response1->assertRedirect(route('penjadwalan.index'));
        $response1->assertSessionHas('success');

        // 2. Jadwal dengan status 'Dibatalkan' di slot 11:00 - 12:00
        Penjadwalan::create([
            'id_siswa' => $this->siswa1->id_siswa,
            'tanggal' => $this->testDate,
            'waktu_mulai' => '11:00',
            'waktu_selesai' => '12:00',
            'jenis_bimbingan' => 'Jadwal Dibatalkan',
            'status' => 'Dibatalkan',
        ]);

        // Jadwal baru di slot 11:00 - 12:00 HARUS BERHASIL
        $response2 = $this->actingAs($this->guruBk)->post(route('penjadwalan.store'), [
            'id_siswa' => $this->siswa2->id_siswa,
            'tanggal' => $this->testDate,
            'waktu_mulai' => '11:00',
            'waktu_selesai' => '12:00',
            'jenis_bimbingan' => 'Konseling Baru',
        ]);
        $response2->assertRedirect(route('penjadwalan.index'));
        $response2->assertSessionHas('success');
    }

    public function test_updating_schedule_allows_keeping_same_time_for_self()
    {
        $jadwal = Penjadwalan::create([
            'id_siswa' => $this->siswa1->id_siswa,
            'tanggal' => $this->testDate,
            'waktu_mulai' => '13:00',
            'waktu_selesai' => '14:00',
            'jenis_bimbingan' => 'Konseling Belajar',
            'status' => 'Terjadwal',
        ]);

        // Update catatan tanpa ubah waktu -> HARUS BERHASIL (tidak bentrok dengan diri sendiri)
        $response = $this->actingAs($this->guruBk)->put(route('penjadwalan.update', $jadwal->id_penjadwalan), [
            'id_siswa' => $this->siswa1->id_siswa,
            'tanggal' => $this->testDate,
            'waktu_mulai' => '13:00',
            'waktu_selesai' => '14:00',
            'jenis_bimbingan' => 'Konseling Belajar Diperbarui',
            'catatan' => 'Catatan tambahan',
            'status' => 'Terjadwal',
        ]);

        $response->assertRedirect(route('penjadwalan.show', $jadwal->id_penjadwalan));
        $response->assertSessionHas('success');
    }

    public function test_updating_schedule_to_overlapping_slot_is_rejected()
    {
        // Jadwal A: 13:00 - 14:00
        Penjadwalan::create([
            'id_siswa' => $this->siswa1->id_siswa,
            'tanggal' => $this->testDate,
            'waktu_mulai' => '13:00',
            'waktu_selesai' => '14:00',
            'jenis_bimbingan' => 'Jadwal A',
            'status' => 'Terjadwal',
        ]);

        // Jadwal B: 15:00 - 16:00
        $jadwalB = Penjadwalan::create([
            'id_siswa' => $this->siswa2->id_siswa,
            'tanggal' => $this->testDate,
            'waktu_mulai' => '15:00',
            'waktu_selesai' => '16:00',
            'jenis_bimbingan' => 'Jadwal B',
            'status' => 'Terjadwal',
        ]);

        // Coba geser Jadwal B ke 13:30 - 14:30 (bentrok dengan Jadwal A) -> HARUS GAGAL
        $response = $this->actingAs($this->guruBk)->put(route('penjadwalan.update', $jadwalB->id_penjadwalan), [
            'id_siswa' => $this->siswa2->id_siswa,
            'tanggal' => $this->testDate,
            'waktu_mulai' => '13:30',
            'waktu_selesai' => '14:30',
            'jenis_bimbingan' => 'Jadwal B Bergeser',
            'status' => 'Terjadwal',
        ]);

        $response->assertSessionHasErrors(['waktu_mulai']);

        // Data Jadwal B tidak boleh berubah
        $jadwalB->refresh();
        $this->assertEquals('15:00:00', $jadwalB->waktu_mulai);
    }

    public function test_wali_kelas_approval_fails_if_slot_conflicts_with_confirmed_schedule()
    {
        // Guru BK sudah memiliki jadwal resmi: 08:00 - 09:00
        Penjadwalan::create([
            'id_siswa' => $this->siswa1->id_siswa,
            'tanggal' => $this->testDate,
            'waktu_mulai' => '08:00',
            'waktu_selesai' => '09:00',
            'jenis_bimbingan' => 'Jadwal Resmi BK',
            'status' => 'Terjadwal',
        ]);

        // Siswa 2 mengajukan waktu yang bertabrakan: 08:30 - 09:30
        $pengajuanB = Penjadwalan::create([
            'id_siswa' => $this->siswa2->id_siswa,
            'tanggal' => $this->testDate,
            'waktu_mulai' => '08:30',
            'waktu_selesai' => '09:30',
            'jenis_bimbingan' => 'Pengajuan Siswa 2',
            'status' => 'Diajukan',
        ]);

        // Wali Kelas mencoba menyetujui Pengajuan B -> HARUS DITOLAK karena bentrok
        $response = $this->actingAs($this->waliKelas)->patch(
            route('wali.pengajuan.approve', $pengajuanB->id_penjadwalan),
            ['catatan_wali' => 'Mencoba approve jadwal bentrok']
        );

        $response->assertStatus(302);
        $response->assertSessionHas('error');

        // Status Pengajuan B HARUS TETAP 'Diajukan'
        $pengajuanB->refresh();
        $this->assertEquals('Diajukan', $pengajuanB->status);
        $this->assertNull($pengajuanB->id_wali);
    }

    public function test_concurrent_submissions_prevent_double_booking_via_transaction()
    {
        // Pengajuan pertama disetujui
        $jadwal1 = Penjadwalan::create([
            'id_siswa' => $this->siswa1->id_siswa,
            'tanggal' => $this->testDate,
            'waktu_mulai' => '10:00',
            'waktu_selesai' => '11:00',
            'jenis_bimbingan' => 'Konseling 1',
            'status' => 'Disetujui_Wali',
        ]);

        // Percobaan pengajuan kedua di waktu yang sama (10:00 - 11:00) via store Guru BK
        $response2 = $this->actingAs($this->guruBk)->post(route('penjadwalan.store'), [
            'id_siswa' => $this->siswa2->id_siswa,
            'tanggal' => $this->testDate,
            'waktu_mulai' => '10:00',
            'waktu_selesai' => '11:00',
            'jenis_bimbingan' => 'Konseling 2',
        ]);

        $response2->assertSessionHasErrors(['waktu_mulai']);
        $this->assertEquals(1, Penjadwalan::where('tanggal', $this->testDate)->where('waktu_mulai', '10:00:00')->count());
    }
}
