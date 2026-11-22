<?php

namespace Tests\Feature;

use App\Models\JadwalMengajarBk;
use App\Models\Kelas;
use App\Models\Penjadwalan;
use App\Models\Siswa;
use App\Models\SlotKonseling;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ManajemenSlotDanJadwalMengajarTest extends TestCase
{
    use DatabaseTransactions;

    protected User $guruBk;
    protected User $waliKelas;
    protected Kelas $kelas;
    protected Siswa $siswa1;
    protected Siswa $siswa2;

    protected function setUp(): void
    {
        parent::setUp();

        $this->kelas = Kelas::firstOrCreate(
            ['id_kelas' => 1],
            ['nama_kelas' => '7.1', 'tingkat' => 7]
        );

        $this->guruBk = User::where('role', 'guru_bk')->first() ?? User::create([
            'nama' => 'Guru BK Penguji',
            'username' => 'gurubk_slot_' . uniqid(),
            'password' => bcrypt('password123'),
            'role' => 'guru_bk',
        ]);

        $this->waliKelas = User::create([
            'nama' => 'Wali Kelas 7.1 Penguji',
            'username' => 'wali_slot_' . uniqid(),
            'password' => bcrypt('password123'),
            'role' => 'wali_kelas',
            'id_kelas' => $this->kelas->id_kelas,
        ]);

        $this->siswa1 = Siswa::create([
            'nis' => 'SLOT_NIS1_' . rand(1000, 9999),
            'nama_siswa' => 'Siswa Satu Penguji Slot',
            'jenis_kelamin' => 'L',
            'id_kelas' => $this->kelas->id_kelas,
            'status' => 'Aktif',
        ]);

        $this->siswa2 = Siswa::create([
            'nis' => 'SLOT_NIS2_' . rand(1000, 9999),
            'nama_siswa' => 'Siswa Dua Penguji Slot',
            'jenis_kelamin' => 'P',
            'id_kelas' => $this->kelas->id_kelas,
            'status' => 'Aktif',
        ]);
    }

    /**
     * 1. Uji pengelolaan dan validasi jadwal mengajar Guru BK beserta pencegahan bentrok antar jadwal mengajar.
     */
    public function test_guru_bk_can_manage_teaching_schedule_and_prevent_teaching_conflict()
    {
        $targetDate = Carbon::now()->addDays(5)->format('Y-m-d');
        $hariTarget = JadwalMengajarBk::dayNameFromDate($targetDate);

        // 1. Tambah jadwal mengajar baru (08:00 - 09:30)
        $storeResponse = $this->actingAs($this->guruBk)->post(route('penjadwalan.mengajar.store'), [
            'hari' => $hariTarget,
            'tanggal' => $targetDate,
            'waktu_mulai' => '08:00',
            'waktu_selesai' => '09:30',
            'id_kelas' => $this->kelas->id_kelas,
            'mata_pelajaran' => 'Bimbingan Klasikal',
            'keterangan' => 'Materi pengenalan diri kelas 7.1',
        ]);
        $storeResponse->assertRedirect();
        $storeResponse->assertSessionHas('success');

        $jadwalMengajar = JadwalMengajarBk::where('tanggal', $targetDate)->first();
        $this->assertNotNull($jadwalMengajar);
        $this->assertEquals($hariTarget, $jadwalMengajar->hari);
        $this->assertEquals('08:00:00', $jadwalMengajar->waktu_mulai);
        $this->assertEquals('09:30:00', $jadwalMengajar->waktu_selesai);

        // 2. Coba tambah jadwal mengajar lain yang berbenturan (08:30 - 10:00) pada hari yang sama -> Ditolak
        $conflictResponse = $this->actingAs($this->guruBk)->post(route('penjadwalan.mengajar.store'), [
            'hari' => $hariTarget,
            'tanggal' => $targetDate,
            'waktu_mulai' => '08:30',
            'waktu_selesai' => '10:00',
            'id_kelas' => $this->kelas->id_kelas,
            'mata_pelajaran' => 'Layanan Klasikal Lanjutan',
        ]);
        $conflictResponse->assertSessionHasErrors(['waktu_mulai']);
        $this->assertEquals(1, JadwalMengajarBk::where('tanggal', $targetDate)->count());
    }

    /**
     * 2. Uji pembukaan slot konseling dalam jam operasional 08:00-15:00 dan dukungan durasi 1 jam / 2 jam.
     */
    public function test_slot_opening_respects_operational_hours_and_custom_durations()
    {
        $targetDate = Carbon::now()->addDays(6)->format('Y-m-d');

        // 1. Tolak pembukaan slot sebelum jam 08:00 (misal 07:00 - 08:30)
        $beforeHoursResponse = $this->actingAs($this->guruBk)->post(route('penjadwalan.slot.store'), [
            'tanggal' => $targetDate,
            'waktu_mulai' => '07:00',
            'waktu_selesai' => '08:30',
            'status' => 'Tersedia',
            'keterangan' => 'Slot Terlalu Pagi',
        ]);
        $beforeHoursResponse->assertSessionHasErrors(['waktu_mulai']);

        // 2. Tolak pembukaan slot melewati jam 15:00 (misal 14:00 - 15:30)
        $afterHoursResponse = $this->actingAs($this->guruBk)->post(route('penjadwalan.slot.store'), [
            'tanggal' => $targetDate,
            'waktu_mulai' => '14:00',
            'waktu_selesai' => '15:30',
            'status' => 'Tersedia',
            'keterangan' => 'Slot Melewati Jam Operasional',
        ]);
        $afterHoursResponse->assertSessionHasErrors(['waktu_selesai']);

        // 3. Buka slot durasi 1 jam (08:00 - 09:00 -> 60 menit)
        $oneHourResponse = $this->actingAs($this->guruBk)->post(route('penjadwalan.slot.store'), [
            'tanggal' => $targetDate,
            'waktu_mulai' => '08:00',
            'waktu_selesai' => '09:00',
            'status' => 'Tersedia',
            'keterangan' => 'Slot 1 Jam Pagi',
        ]);
        $oneHourResponse->assertRedirect();
        $oneHourResponse->assertSessionHas('success');

        $slot1Jam = SlotKonseling::where('tanggal', $targetDate)->where('waktu_mulai', '08:00:00')->first();
        $this->assertNotNull($slot1Jam);
        $this->assertEquals(60, $slot1Jam->durasi_menit);
        $this->assertEquals('1 Jam', $slot1Jam->durasi_label);
        $this->assertEquals('Tersedia', $slot1Jam->status);

        // 4. Buka slot durasi 2 jam (10:00 - 12:00 -> 120 menit)
        $twoHourResponse = $this->actingAs($this->guruBk)->post(route('penjadwalan.slot.store'), [
            'tanggal' => $targetDate,
            'waktu_mulai' => '10:00',
            'waktu_selesai' => '12:00',
            'status' => 'Tersedia',
            'keterangan' => 'Slot 2 Jam Siang',
        ]);
        $twoHourResponse->assertRedirect();
        $twoHourResponse->assertSessionHas('success');

        $slot2Jam = SlotKonseling::where('tanggal', $targetDate)->where('waktu_mulai', '10:00:00')->first();
        $this->assertNotNull($slot2Jam);
        $this->assertEquals(120, $slot2Jam->durasi_menit);
        $this->assertEquals('2 Jam', $slot2Jam->durasi_label);
    }

    /**
     * 3. Uji pencegahan bentrok antara Jadwal Mengajar Guru BK, Slot Konseling, dan Penjadwalan Bimbingan.
     */
    public function test_prevent_conflict_between_teaching_schedule_and_counseling_slot()
    {
        $targetDate = Carbon::now()->addDays(7)->format('Y-m-d');
        $hariTarget = JadwalMengajarBk::dayNameFromDate($targetDate);

        // Guru BK memiliki jadwal mengajar pukul 09:00 - 10:30
        JadwalMengajarBk::create([
            'id_user' => $this->guruBk->id_user,
            'hari' => $hariTarget,
            'tanggal' => $targetDate,
            'waktu_mulai' => '09:00:00',
            'waktu_selesai' => '10:30:00',
            'id_kelas' => $this->kelas->id_kelas,
            'mata_pelajaran' => 'Bimbingan Klasikal',
            'is_aktif' => true,
        ]);

        // 1. Guru BK mencoba membuka slot konseling yang berbenturan (09:30 - 10:30) -> Ditolak
        $slotConflictResponse = $this->actingAs($this->guruBk)->post(route('penjadwalan.slot.store'), [
            'tanggal' => $targetDate,
            'waktu_mulai' => '09:30',
            'waktu_selesai' => '10:30',
            'status' => 'Tersedia',
            'keterangan' => 'Slot Bentrok Mengajar',
        ]);
        $slotConflictResponse->assertSessionHasErrors(['waktu_mulai']);
        $this->assertEquals(0, SlotKonseling::where('tanggal', $targetDate)->count());

        // 2. Guru BK mencoba membuat jadwal bimbingan langsung pada jam mengajar (09:00 - 10:00) -> Ditolak
        $jadwalConflictResponse = $this->actingAs($this->guruBk)->post(route('penjadwalan.store'), [
            'id_siswa' => $this->siswa1->id_siswa,
            'tanggal' => $targetDate,
            'waktu_mulai' => '09:00',
            'waktu_selesai' => '10:00',
            'jenis_bimbingan' => 'Konseling Pribadi',
        ]);
        $jadwalConflictResponse->assertSessionHasErrors(['waktu_mulai']);

        // 3. Guru BK membuka slot konseling pada waktu yang TIDAK berbenturan (11:00 - 12:00) -> Berhasil
        $validSlotResponse = $this->actingAs($this->guruBk)->post(route('penjadwalan.slot.store'), [
            'tanggal' => $targetDate,
            'waktu_mulai' => '11:00',
            'waktu_selesai' => '12:00',
            'status' => 'Tersedia',
            'keterangan' => 'Slot Kosong Setelah Mengajar',
        ]);
        $validSlotResponse->assertRedirect();
        $validSlotResponse->assertSessionHas('success');
        $this->assertEquals(1, SlotKonseling::where('tanggal', $targetDate)->count());
    }

    /**
     * 4. Uji bahwa jam operasional 08:00-15:00 TIDAK otomatis tersedia bagi siswa jika belum dibuka Guru BK,
     *    dan siswa hanya dapat memilih slot yang telah dibuka setelah izin Wali Kelas disetujui.
     */
    public function test_student_can_only_choose_opened_slot_after_wali_approval()
    {
        $targetDate = Carbon::now()->addDays(8)->format('Y-m-d');

        // Izin Wali Kelas untuk Siswa 1 sudah disetujui
        $izinSiswa1 = Penjadwalan::create([
            'kode_pengajuan' => Penjadwalan::generateKodePengajuan(),
            'id_siswa' => $this->siswa1->id_siswa,
            'id_wali' => $this->waliKelas->id_user,
            'tanggal' => now()->format('Y-m-d'),
            'waktu_mulai' => '00:00:00',
            'waktu_selesai' => '00:00:00',
            'jenis_bimbingan' => 'Konseling Karir',
            'status' => 'Disetujui_Wali',
            'waktu_persetujuan_wali' => now(),
        ]);

        // 1. Siswa memilih jam 10:00 - 11:00 (dalam jam operasional 08:00-15:00, tetapi BELUM dibuka Guru BK) -> Ditolak
        $unopenedSlotResponse = $this->post(route('portal.siswa.ajukan'), [
            'id_kelas' => $this->kelas->id_kelas,
            'id_siswa' => $this->siswa1->id_siswa,
            'kode_pengajuan' => $izinSiswa1->kode_pengajuan,
            'tanggal' => $targetDate,
            'waktu_mulai' => '10:00',
            'waktu_selesai' => '11:00',
            'jenis_bimbingan' => 'Konseling Karir',
        ]);
        $unopenedSlotResponse->assertSessionHasErrors(['waktu_mulai']);
        $izinSiswa1->refresh();
        $this->assertFalse($izinSiswa1->hasSubmittedSchedule());

        // 2. Guru BK membuka slot pukul 10:00 - 11:00 dengan status 'Tidak_Tersedia' -> Siswa tetap ditolak
        $closedSlot = SlotKonseling::create([
            'id_user' => $this->guruBk->id_user,
            'tanggal' => $targetDate,
            'waktu_mulai' => '10:00:00',
            'waktu_selesai' => '11:00:00',
            'durasi_menit' => 60,
            'status' => 'Tidak_Tersedia',
            'keterangan' => 'Rapat Koordinasi',
        ]);

        $unavailableResponse = $this->post(route('portal.siswa.ajukan'), [
            'id_kelas' => $this->kelas->id_kelas,
            'id_siswa' => $this->siswa1->id_siswa,
            'kode_pengajuan' => $izinSiswa1->kode_pengajuan,
            'id_slot' => $closedSlot->id_slot,
            'tanggal' => $targetDate,
            'waktu_mulai' => '10:00',
            'waktu_selesai' => '11:00',
            'jenis_bimbingan' => 'Konseling Karir',
        ]);
        $unavailableResponse->assertSessionHasErrors(['waktu_mulai']);

        // 3. Guru BK mengubah status slot menjadi 'Tersedia' -> Siswa berhasil memilih slot tersebut
        $closedSlot->update(['status' => 'Tersedia']);

        $successResponse = $this->post(route('portal.siswa.ajukan'), [
            'id_kelas' => $this->kelas->id_kelas,
            'id_siswa' => $this->siswa1->id_siswa,
            'kode_pengajuan' => $izinSiswa1->kode_pengajuan,
            'id_slot' => $closedSlot->id_slot,
            'tanggal' => $targetDate,
            'waktu_mulai' => '10:00',
            'waktu_selesai' => '11:00',
            'jenis_bimbingan' => 'Konseling Karir',
            'catatan' => 'Ingin berkonsultasi mengenai pilihan sekolah lanjutan.',
        ]);
        $successResponse->assertRedirect();
        $successResponse->assertSessionHas('pengajuan_berhasil', true);

        $izinSiswa1->refresh();
        $closedSlot->refresh();
        $this->assertTrue($izinSiswa1->hasSubmittedSchedule());
        $this->assertEquals('Disetujui_Wali', $izinSiswa1->status);
        $this->assertEquals('Menunggu_Diproses', $closedSlot->status);
    }

    /**
     * 5. Uji perlindungan pemesanan ganda (double booking) ketika permohonan masih diproses (Menunggu_Diproses).
     */
    public function test_double_booking_protection_when_slot_is_waiting_to_be_processed()
    {
        $targetDate = Carbon::now()->addDays(9)->format('Y-m-d');

        // Guru BK membuka 1 slot konseling (13:00 - 14:00)
        $slot = SlotKonseling::create([
            'id_user' => $this->guruBk->id_user,
            'tanggal' => $targetDate,
            'waktu_mulai' => '13:00:00',
            'waktu_selesai' => '14:00:00',
            'durasi_menit' => 60,
            'status' => 'Tersedia',
            'keterangan' => 'Slot Siang 1 Jam',
        ]);

        // Siswa 1 dan Siswa 2 sama-sama sudah mendapat persetujuan izin dari Wali Kelas
        $izinSiswa1 = Penjadwalan::create([
            'kode_pengajuan' => Penjadwalan::generateKodePengajuan(),
            'id_siswa' => $this->siswa1->id_siswa,
            'id_wali' => $this->waliKelas->id_user,
            'tanggal' => now()->format('Y-m-d'),
            'waktu_mulai' => '00:00:00',
            'waktu_selesai' => '00:00:00',
            'jenis_bimbingan' => 'Konseling Belajar',
            'status' => 'Disetujui_Wali',
            'waktu_persetujuan_wali' => now(),
        ]);

        $izinSiswa2 = Penjadwalan::create([
            'kode_pengajuan' => Penjadwalan::generateKodePengajuan(),
            'id_siswa' => $this->siswa2->id_siswa,
            'id_wali' => $this->waliKelas->id_user,
            'tanggal' => now()->format('Y-m-d'),
            'waktu_mulai' => '00:00:00',
            'waktu_selesai' => '00:00:00',
            'jenis_bimbingan' => 'Konseling Pribadi',
            'status' => 'Disetujui_Wali',
            'waktu_persetujuan_wali' => now(),
        ]);

        // 1. Siswa 1 memilih slot 13:00 - 14:00 terlebih dahulu -> Berhasil & mengunci slot ke 'Menunggu_Diproses'
        $firstBooking = $this->post(route('portal.siswa.ajukan'), [
            'id_kelas' => $this->kelas->id_kelas,
            'id_siswa' => $this->siswa1->id_siswa,
            'kode_pengajuan' => $izinSiswa1->kode_pengajuan,
            'id_slot' => $slot->id_slot,
            'tanggal' => $targetDate,
            'waktu_mulai' => '13:00',
            'waktu_selesai' => '14:00',
            'jenis_bimbingan' => 'Konseling Belajar',
        ]);
        $firstBooking->assertRedirect();
        $firstBooking->assertSessionHas('pengajuan_berhasil', true);

        $slot->refresh();
        $this->assertEquals('Menunggu_Diproses', $slot->status);

        // Simulasikan Siswa 2 dari perangkat/sesi browser yang berbeda
        $this->flushSession();

        // 2. Siswa 2 mencoba memesan slot yang sama ketika permohonan Siswa 1 masih diproses -> Ditolak (Anti Double Booking)
        $secondBooking = $this->post(route('portal.siswa.ajukan'), [
            'id_kelas' => $this->kelas->id_kelas,
            'id_siswa' => $this->siswa2->id_siswa,
            'kode_pengajuan' => $izinSiswa2->kode_pengajuan,
            'id_slot' => $slot->id_slot,
            'tanggal' => $targetDate,
            'waktu_mulai' => '13:00',
            'waktu_selesai' => '14:00',
            'jenis_bimbingan' => 'Konseling Pribadi',
        ]);
        $secondBooking->assertSessionHasErrors(['waktu_mulai']);

        $izinSiswa2->refresh();
        $this->assertFalse($izinSiswa2->hasSubmittedSchedule());
    }

    /**
     * 6. Uji bahwa permohonan izin Tahap 1 (dengan tanggal & jam pelajaran) tidak mengunci slot Guru BK
     *    sebelum siswa benar-benar mengajukan jadwal konseling pada Tahap 2, serta status Cek Status akurat.
     */
    public function test_tahap_1_permission_does_not_prematurely_lock_slot_before_tahap_2_schedule_submission()
    {
        $targetDate = Carbon::now()->addDays(11)->format('Y-m-d');
        $formattedDate = Carbon::now()->addDays(11)->format('d/m/Y');

        // 1. Guru BK membuka slot pukul 14:00 - 14:45 pada tanggal tersebut
        $slot = SlotKonseling::create([
            'id_user' => $this->guruBk->id_user,
            'tanggal' => $targetDate,
            'waktu_mulai' => '14:00:00',
            'waktu_selesai' => '14:45:00',
            'durasi_menit' => 45,
            'status' => 'Tersedia',
            'keterangan' => 'Slot Siang 45 Menit',
        ]);

        // 2. Siswa 1 mengajukan izin Tahap 1 pada tanggal & jam yang sama (14:00 - 14:45, id_slot masih null)
        $izinResponse = $this->post(route('portal.siswa.izin'), [
            'id_kelas' => $this->kelas->id_kelas,
            'id_siswa' => $this->siswa1->id_siswa,
            'jenis_bimbingan' => 'Konseling Pribadi',
            'tanggal' => $targetDate,
            'jam_pelajaran' => 'Kustom',
            'waktu_mulai' => '14:00',
            'waktu_selesai' => '14:45',
        ]);
        $izinResponse->assertRedirect();
        $izinResponse->assertSessionHas('izin_berhasil', true);

        $izin = Penjadwalan::where('id_siswa', $this->siswa1->id_siswa)->latest('id_penjadwalan')->first();
        $this->assertNotNull($izin);
        $this->assertNull($izin->id_slot);
        $this->assertFalse($izin->hasSubmittedSchedule());

        // Slot Guru BK harus tetap 'Tersedia' karena siswa baru meminta izin Wali Kelas (Tahap 1)
        SlotKonseling::syncSlotStatusesOnDate($targetDate);
        $slot->refresh();
        $this->assertEquals('Tersedia', $slot->status_slot);
        $this->assertEquals('Tersedia', $slot->effective_status);

        // 3. Wali Kelas menyetujui izin Siswa 1 -> Slot masih harus tetap 'Tersedia' agar bisa dipilih Siswa 1 di Tahap 2
        $this->actingAs($this->waliKelas)->patch(
            route('wali.pengajuan.approve', $izin->id_penjadwalan),
            ['catatan_wali' => 'Diizinkan oleh Wali Kelas.']
        )->assertRedirect();

        SlotKonseling::syncSlotStatusesOnDate($targetDate);
        $slot->refresh();
        $this->assertEquals('Tersedia', $slot->status_slot);

        // Cek di Beranda: slot masih ditampilkan sebagai Slot Kosong (Tersedia)
        $berandaBefore = $this->get(route('portal.siswa.index', ['tanggal_cek' => $targetDate]));
        $berandaBefore->assertStatus(200);
        $berandaBefore->assertSee('Slot Kosong (Tersedia)');
        $berandaBefore->assertSee('14:00 - 14:45 WIB');

        // 4. Siswa 1 mengajukan jadwal konseling pada Tahap 2 memilih slot tersebut -> Berhasil
        $ajukanResponse = $this->post(route('portal.siswa.ajukan'), [
            'id_kelas' => $this->kelas->id_kelas,
            'id_siswa' => $this->siswa1->id_siswa,
            'kode_pengajuan' => $izin->kode_pengajuan,
            'id_slot' => $slot->id_slot,
            'tanggal' => $targetDate,
            'waktu_mulai' => '14:00',
            'waktu_selesai' => '14:45',
            'jenis_bimbingan' => 'Konseling Pribadi',
        ]);
        $ajukanResponse->assertRedirect();
        $ajukanResponse->assertSessionHas('pengajuan_berhasil', true);

        $izin->refresh();
        $slot->refresh();
        $this->assertEquals($slot->id_slot, $izin->id_slot);
        $this->assertTrue($izin->hasSubmittedSchedule());
        $this->assertEquals('Menunggu_Diproses', $slot->status_slot);

        // 5. Cek Status menampilkan bahwa jadwal sudah diajukan (Menunggu Jadwal BK / Menunggu Guru BK)
        $statusResponse = $this->get(route('portal.siswa.status', ['kode_pengajuan' => $izin->kode_pengajuan]));
        $statusResponse->assertStatus(200);
        $statusResponse->assertSee('Izin Diterima (Menunggu Jadwal BK)');
        $statusResponse->assertSee('Izin Diterima (Menunggu Guru BK)');

        // 6. Cek di Beranda setelah diajukan: slot tidak lagi tersedia
        $berandaAfter = $this->get(route('portal.siswa.index', ['tanggal_cek' => $targetDate]));
        $berandaAfter->assertStatus(200);
        $berandaAfter->assertSee("Slot konseling pada tanggal {$formattedDate} sudah diajukan oleh siswa lain. Silakan pilih tanggal lain.");
    }

    /**
     * 7. Uji tampilan dan konfirmasi pengajuan berstatus Disetujui_Wali oleh Guru BK:
     *    - Pengajuan Disetujui_Wali tanpa id_slot tidak dianggap Terjadwal & tidak mengunci slot saat diedit dengan status Disetujui_Wali
     *    - Guru BK dapat membedakan Izin Disetujui Wali Kelas (Jadwal Belum Final) dengan Jadwal Terjadwal
     *    - Guru BK dapat mengonfirmasi pengajuan menjadi Terjadwal melalui PenjadwalanController::update()
     */
    public function test_guru_bk_can_distinguish_and_confirm_disetujui_wali_to_terjadwal()
    {
        $targetDate = Carbon::now()->addDays(12)->format('Y-m-d');

        $slot = SlotKonseling::create([
            'id_user' => $this->guruBk->id_user,
            'tanggal' => $targetDate,
            'waktu_mulai' => '09:00:00',
            'waktu_selesai' => '09:45:00',
            'durasi_menit' => 45,
            'status' => 'Tersedia',
        ]);

        // Siswa 1 baru mendapat persetujuan Wali Kelas (Tahap 1, id_slot = null)
        $izinTanpaSlot = Penjadwalan::create([
            'kode_pengajuan' => Penjadwalan::generateKodePengajuan(),
            'id_siswa' => $this->siswa1->id_siswa,
            'id_wali' => $this->waliKelas->id_user,
            'tanggal' => $targetDate,
            'waktu_mulai' => '09:00:00',
            'waktu_selesai' => '09:45:00',
            'jenis_bimbingan' => 'Konseling Pribadi',
            'catatan' => 'Jam Pelajaran 1-2',
            'status' => 'Disetujui_Wali',
            'waktu_persetujuan_wali' => now(),
        ]);

        $this->assertFalse($izinTanpaSlot->hasSubmittedSchedule());

        // Halaman penjadwalan Guru BK menampilkan pembeda Izin Disetujui Wali Kelas & Jadwal Belum Final
        $indexResponse = $this->actingAs($this->guruBk)->get(route('penjadwalan.index', ['status' => 'Disetujui_Wali']));
        $indexResponse->assertStatus(200);
        $indexResponse->assertSee('Izin Disetujui Wali Kelas');
        $indexResponse->assertSee('Jadwal Belum Final');
        $indexResponse->assertSee('Atur & Konfirmasi');

        // Jika Guru BK mengedit catatan tetapi status tetap Disetujui_Wali, tidak boleh dianggap Terjadwal atau mengunci slot
        $updateStillDisetujui = $this->actingAs($this->guruBk)->put(
            route('penjadwalan.update', $izinTanpaSlot->id_penjadwalan),
            [
                'id_siswa' => $this->siswa1->id_siswa,
                'tanggal' => $targetDate,
                'waktu_mulai' => '09:00',
                'waktu_selesai' => '09:45',
                'jenis_bimbingan' => 'Konseling Pribadi',
                'catatan' => 'Jam Pelajaran 1-2',
                'status' => 'Disetujui_Wali',
            ]
        );
        $updateStillDisetujui->assertRedirect(route('penjadwalan.show', $izinTanpaSlot->id_penjadwalan));

        $izinTanpaSlot->refresh();
        $slot->refresh();
        $this->assertEquals('Disetujui_Wali', $izinTanpaSlot->status);
        $this->assertNull($izinTanpaSlot->id_slot);
        $this->assertFalse($izinTanpaSlot->hasSubmittedSchedule());
        $this->assertEquals('Tersedia', $slot->status_slot);

        // Ketika Guru BK mengonfirmasi menjadi Terjadwal, status berubah menjadi Terjadwal & slot terkunci menjadi Dipesan
        $confirmResponse = $this->actingAs($this->guruBk)->put(
            route('penjadwalan.update', $izinTanpaSlot->id_penjadwalan),
            [
                'id_siswa' => $this->siswa1->id_siswa,
                'tanggal' => $targetDate,
                'waktu_mulai' => '09:00',
                'waktu_selesai' => '09:45',
                'jenis_bimbingan' => 'Konseling Pribadi',
                'catatan' => 'Jadwal dikonfirmasi Guru BK',
                'status' => 'Terjadwal',
                'redirect_to' => 'index',
            ]
        );
        $confirmResponse->assertRedirect(route('penjadwalan.index'));

        $izinTanpaSlot->refresh();
        $slot->refresh();
        $this->assertEquals('Terjadwal', $izinTanpaSlot->status);
        $this->assertEquals($slot->id_slot, $izinTanpaSlot->id_slot);
        $this->assertTrue($izinTanpaSlot->hasSubmittedSchedule());
        $this->assertEquals('Dipesan', $slot->status_slot);
    }
}
