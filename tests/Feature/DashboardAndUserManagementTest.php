<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Kelas;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DashboardAndUserManagementTest extends TestCase
{
    use DatabaseTransactions;

    public function test_login_page_redirects_authenticated_user_to_dashboard()
    {
        $user = User::where('role', 'guru_bk')->first();
        if ($user) {
            $response = $this->actingAs($user)->get('/login');
            $response->assertStatus(302);
            $response->assertRedirect(route('dashboard'));
        }
    }

    public function test_guru_bk_dashboard_renders_with_counseling_metrics()
    {
        $guruBk = User::where('role', 'guru_bk')->first();
        $this->assertNotNull($guruBk);

        $response = $this->actingAs($guruBk)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertViewIs('dashboard.index');
        $response->assertViewHasAll([
            'totalSiswa',
            'totalKonseling',
            'konselingBulanIni',
            'totalTindakLanjut',
            'siswaPerhatian',
            'riwayatKonseling',
            'konselingPerBulan',
            'jadwalBimbingan',
        ]);
    }

    public function test_admin_dashboard_renders_and_has_crud_user_access()
    {
        $admin = User::where('role', 'admin')->first();
        $this->assertNotNull($admin);

        // 1. Dashboard Admin
        $response = $this->actingAs($admin)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertViewIs('dashboard.admin');
        $response->assertViewHasAll([
            'totalUser',
            'totalAdmin',
            'totalGuruBK',
            'totalWaliKelas',
            'totalSiswa',
            'siswaAktif',
            'totalKelas',
            'usersTerbaru',
        ]);

        // 2. Akses Kelola Pengguna
        $usersPage = $this->actingAs($admin)->get('/users');
        $usersPage->assertStatus(200);
        $usersPage->assertViewIs('users.index');

        // 3. Tambah Akun Baru
        $testUsername = 'test_wali_' . time();
        $createResponse = $this->actingAs($admin)->post('/users', [
            'nama' => 'Test Wali Kelas Otomatis',
            'username' => $testUsername,
            'password' => 'password123',
            'role' => 'wali_kelas',
            'id_kelas' => 1,
        ]);
        $createResponse->assertStatus(302);
        $createResponse->assertSessionHas('success');

        $newUser = User::where('username', $testUsername)->first();
        $this->assertNotNull($newUser);
        $this->assertEquals(1, $newUser->id_kelas);

        // 4. Update Akun
        $kelasTujuan = Kelas::where('id_kelas', '<>', 1)->value('id_kelas');
        $this->assertNotNull($kelasTujuan, 'A second class is required to verify changing a Wali Kelas assignment.');
        $updateResponse = $this->actingAs($admin)->put('/users/' . $newUser->id_user, [
            'nama' => 'Test Wali Kelas Terupdate',
            'username' => $testUsername,
            'role' => 'wali_kelas',
            'id_kelas' => $kelasTujuan,
        ]);
        $updateResponse->assertStatus(302);
        $updateResponse->assertSessionHas('success');
        $this->assertEquals($kelasTujuan, $newUser->fresh()->id_kelas);

        // 5. Hapus Akun Baru
        $deleteResponse = $this->actingAs($admin)->delete('/users/' . $newUser->id_user);
        $deleteResponse->assertStatus(302);
        $deleteResponse->assertSessionHas('success');

        // 6. Pengaman: Admin tidak dapat menghapus akunnya sendiri
        $selfDelete = $this->actingAs($admin)->delete('/users/' . $admin->id_user);
        $selfDelete->assertStatus(302);
        $selfDelete->assertSessionHas('error');

        // 7. Pengaman: Akses rute BK privat tetap ditolak 403
        $this->actingAs($admin)->get('/konseling')->assertStatus(403);
        $this->actingAs($admin)->get('/laporan')->assertStatus(403);
    }

    public function test_wali_kelas_dashboard_renders_class_data_and_forbidden_routes()
    {
        $waliKelas = User::where('role', 'wali_kelas')->whereNotNull('id_kelas')->first();
        $this->assertNotNull($waliKelas);

        // 1. Dashboard Wali Kelas
        $response = $this->actingAs($waliKelas)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertViewIs('dashboard.wali_kelas');
        $response->assertViewHasAll([
            'kelas',
            'totalSiswaKelas',
            'siswaLaki',
            'siswaPerempuan',
            'daftarSiswa',
            'jadwalSiswa',
        ]);

        // 2. Rute terlarang untuk Wali Kelas (403)
        $this->actingAs($waliKelas)->get('/users')->assertStatus(403);
        $this->actingAs($waliKelas)->get('/konseling')->assertStatus(403);
        $this->actingAs($waliKelas)->get('/laporan')->assertStatus(403);
        $this->actingAs($waliKelas)->get('/siswa')->assertStatus(403);
    }

    public function test_wali_kelas_without_class_renders_dashboard_gracefully()
    {
        $unassignedWali = new User([
            'id_user' => 999,
            'nama' => 'Wali Tanpa Kelas',
            'username' => 'walitanpakelas',
            'role' => 'wali_kelas',
            'id_kelas' => null,
        ]);

        $response = $this->actingAs($unassignedWali)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertViewIs('dashboard.wali_kelas');
        $this->assertNull($response->viewData('kelas'));
        $this->assertEquals(0, $response->viewData('totalSiswaKelas'));
    }
}
