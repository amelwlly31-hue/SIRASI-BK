<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Penjadwalan;
use App\Models\Notifikasi;
use Carbon\Carbon;
use Tests\TestCase;

class IzinDanNotifikasiWaliKelasTest extends TestCase
{
    /**
     * 1. Pengajuan izin siswa eksisting (Arif Hidayat, Kelas 8.8) harus tampil di dashboard
     *    dan halaman /wali-kelas/pengajuan milik Wali Kelas 8.8 yang sesuai.
     */
    public function test_existing_permission_arif_hidayat_appears_on_walikelas88_dashboard_and_pengajuan_page()
    {
        $wali88 = User::where('username', 'walikelas88')->first();
        $this->assertNotNull($wali88, 'Akun walikelas88 harus ada di database.');

        // Akses halaman /wali-kelas/pengajuan
        $responsePengajuan = $this->actingAs($wali88)->get(route('wali.pengajuan.index'));
        $responsePengajuan->assertStatus(200);
        $responsePengajuan->assertSee('Arif Hidayat');
        $responsePengajuan->assertSee('BK-6MLHFH');
        $responsePengajuan->assertSee('8.8');
        $responsePengajuan->assertSee('Terima');
        $responsePengajuan->assertSee('Tolak');

        // Isolasi: Tidak boleh melihat siswa dari kelas lain
        $responsePengajuan->assertDontSee('Andi Pratama');
        $responsePengajuan->assertDontSee('Amel');

        // Akses halaman /dashboard Wali Kelas 8.8
        $responseDashboard = $this->actingAs($wali88)->get(route('dashboard'));
        $responseDashboard->assertStatus(200);
        $responseDashboard->assertSee('Arif Hidayat');
        $responseDashboard->assertSee('Kelas 8.8');
        $responseDashboard->assertSee('Terima');
        $responseDashboard->assertSee('Tolak');
        $responseDashboard->assertSee('notification-wrapper');
    }

    /**
     * 2. Pengujian isolasi antarkelas pada akun Wali Kelas 7.7 dan 9.10
     */
    public function test_class_isolation_between_wali_kelas_accounts()
    {
        $wali77 = User::where('username', 'walikelas77')->first();
        $wali910 = User::where('username', 'walikelas910')->first();

        $this->assertNotNull($wali77, 'Akun walikelas77 harus ada di database.');
        $this->assertNotNull($wali910, 'Akun walikelas910 harus ada di database.');

        // Wali Kelas 7.7 hanya melihat siswa kelas 7.7
        $response77 = $this->actingAs($wali77)->get(route('wali.pengajuan.index'));
        $response77->assertStatus(200);
        $response77->assertSee('Andi Pratama');
        $response77->assertDontSee('Arif Hidayat');
        $response77->assertDontSee('Amel');

        // Wali Kelas 9.10 hanya melihat siswa kelas 9.10
        $response910 = $this->actingAs($wali910)->get(route('wali.pengajuan.index'));
        $response910->assertStatus(200);
        $response910->assertSee('Amel');
        $response910->assertDontSee('Arif Hidayat');
        $response910->assertDontSee('Andi Pratama');
    }

    /**
     * 3. Notifikasi pengajuan baru di dashboard Wali Kelas dengan titik merah untuk notifikasi
     *    yang belum dibuka. Titik merah hilang setelah notifikasi dibuka / ditandai dibaca.
     */
    public function test_notification_red_dot_disappears_after_opening_or_mark_all_read()
    {
        $wali88 = User::where('username', 'walikelas88')->first();
        $this->assertNotNull($wali88);

        // Buat notifikasi pengajuan baru yang belum dibaca untuk wali88
        $notif = Notifikasi::create([
            'judul' => 'Pengujian Notifikasi Merah — ' . uniqid(),
            'pesan' => 'Ada pengajuan izin baru dari siswa.',
            'tipe' => 'jadwal',
            'dibaca' => false,
            'id_kelas' => $wali88->id_kelas,
            'id_user' => $wali88->id_user,
        ]);

        // Cek dashboard: titik merah harus ada
        $resBefore = $this->actingAs($wali88)->get(route('dashboard'));
        $resBefore->assertStatus(200);
        $resBefore->assertSee('id="notificationDot"', false);

        // Tandai dibaca via endpoint mark-all-read (AJAX)
        $resMark = $this->actingAs($wali88)->postJson(route('notifikasi.markAllRead'));
        $resMark->assertStatus(200);

        // Verifikasi status dibaca di database
        $notif->refresh();
        $this->assertTrue((bool)$notif->dibaca);

        // Cek dashboard kembali: titik merah harus hilang
        $resAfter = $this->actingAs($wali88)->get(route('dashboard'));
        $resAfter->assertStatus(200);
        $resAfter->assertDontSee('id="notificationDot"', false);

        // Bersihkan notif uji
        $notif->delete();
    }

    /**
     * 4. Notifikasi yang SUDAH DIBACA otomatis dihapus setelah 24 jam, sedangkan yang belum dibaca tetap dipertahankan.
     */
    public function test_notifications_older_than_one_day_are_automatically_purged_without_deleting_penjadwalan()
    {
        $wali88 = User::where('username', 'walikelas88')->first();
        $this->assertNotNull($wali88);

        $totalPenjadwalanSebelum = Penjadwalan::count();

        // Buat notifikasi yang SUDAH DIBACA dan set updated_at ke > 24 jam lalu
        $oldReadNotif = Notifikasi::create([
            'judul' => 'Notifikasi Sudah Dibaca > 24 Jam ' . uniqid(),
            'pesan' => 'Pesan pengujian kadaluarsa sudah dibaca',
            'tipe' => 'jadwal',
            'dibaca' => true,
            'id_kelas' => $wali88->id_kelas,
            'id_user' => $wali88->id_user,
        ]);
        $oldReadId = $oldReadNotif->id;
        \Illuminate\Support\Facades\DB::table('notifikasis')->where('id', $oldReadId)->update([
            'created_at' => Carbon::now()->subDays(2),
            'updated_at' => Carbon::now()->subHours(25),
        ]);

        // Buat notifikasi yang BELUM DIBACA meskipun berusia > 24 jam
        $oldUnreadNotif = Notifikasi::create([
            'judul' => 'Notifikasi Belum Dibaca > 24 Jam ' . uniqid(),
            'pesan' => 'Pesan pengujian belum dibaca',
            'tipe' => 'jadwal',
            'dibaca' => false,
            'id_kelas' => $wali88->id_kelas,
            'id_user' => $wali88->id_user,
        ]);
        $oldUnreadId = $oldUnreadNotif->id;
        \Illuminate\Support\Facades\DB::table('notifikasis')->where('id', $oldUnreadId)->update([
            'created_at' => Carbon::now()->subDays(2),
            'updated_at' => Carbon::now()->subHours(25),
        ]);

        $this->assertTrue(Notifikasi::where('id', $oldReadId)->exists());
        $this->assertTrue(Notifikasi::where('id', $oldUnreadId)->exists());

        // Kunjungi halaman yang memicu view composer di AppServiceProvider
        $this->actingAs($wali88)->get(route('dashboard'));

        // Notifikasi yang sudah dibaca > 24 jam harus sudah terhapus
        $this->assertFalse(Notifikasi::where('id', $oldReadId)->exists());

        // Notifikasi yang belum dibaca tidak boleh terhapus
        $this->assertTrue(Notifikasi::where('id', $oldUnreadId)->exists());
        $oldUnreadNotif->delete();

        // Data izin siswa di penjadwalan harus tetap utuh
        $totalPenjadwalanSesudah = Penjadwalan::count();
        $this->assertEquals($totalPenjadwalanSebelum, $totalPenjadwalanSesudah);
    }

    /**
     * 5. Siswa yang masih menunggu persetujuan (Diajukan) tidak bisa mengajukan izin berulang kali.
     */
    public function test_student_with_pending_status_cannot_submit_repeated_permission()
    {
        $pendingIzin = Penjadwalan::where('status', 'Diajukan')->with('siswa')->first();
        $this->assertNotNull($pendingIzin, 'Harus ada data izin yang berstatus Diajukan');

        $siswa = $pendingIzin->siswa;

        $response = $this->post(route('portal.siswa.izin'), [
            'portal_step' => 'izin',
            'id_kelas' => $siswa->id_kelas,
            'id_siswa' => $siswa->id_siswa,
            'jenis_bimbingan' => 'Konseling Individu',
            'tanggal' => Carbon::today()->addDays(3)->format('Y-m-d'),
            'waktu_mulai' => '08:00',
            'waktu_selesai' => '08:45',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('error');
    }

    /**
     * 6. Wali Kelas dapat memilih Terima atau Tolak, status berubah di database dan terlihat di Cek Status.
     */
    public function test_wali_kelas_can_approve_and_status_changes_reflect_on_portal_status()
    {
        $wali88 = User::where('username', 'walikelas88')->first();
        $this->assertNotNull($wali88);

        // Cari pengajuan kelas 8.8 (Arif Hidayat)
        $pengajuan = Penjadwalan::where('status', 'Diajukan')
            ->whereHas('siswa', fn($q) => $q->where('id_kelas', $wali88->id_kelas))
            ->first();

        $this->assertNotNull($pengajuan);
        $kodeIzin = $pengajuan->kode_pengajuan;

        try {
            // Wali Kelas menyetujui izin
            $responseApprove = $this->actingAs($wali88)->patch(
                route('wali.pengajuan.approve', $pengajuan->id_penjadwalan),
                ['catatan_wali' => 'Disetujui untuk konseling.']
            );
            $responseApprove->assertStatus(302);
            $responseApprove->assertSessionHas('success');

            $pengajuan->refresh();
            $this->assertEquals('Disetujui_Wali', $pengajuan->status);
            $this->assertEquals($wali88->id_user, $pengajuan->id_wali);
            $this->assertEquals('Disetujui untuk konseling.', $pengajuan->catatan_wali);

            // Verifikasi di halaman Cek Status Siswa
            $resCekStatus = $this->get(route('portal.siswa.status', ['kode_pengajuan' => $kodeIzin]));
            $resCekStatus->assertStatus(200);
            $resCekStatus->assertSee('Izin Diterima');
        } finally {
            // Kembalikan ke status semula ('Diajukan') agar data asli pengguna terjaga
            $pengajuan->update([
                'status' => 'Diajukan',
                'catatan_wali' => null,
                'waktu_persetujuan_wali' => null,
            ]);
        }
    }
}
