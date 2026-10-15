<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class RoleAuthorizationTest extends TestCase
{
    public function test_guest_is_redirected_to_login_for_protected_routes()
    {
        $protectedRoutes = [
            '/dashboard',
            '/siswa',
            '/konseling',
            '/tindak_lanjut',
            '/penjadwalan',
            '/laporan',
            '/riwayat-siswa',
            '/pengaturan',
        ];

        foreach ($protectedRoutes as $route) {
            $response = $this->get($route);
            $response->assertStatus(302);
            $response->assertRedirect(route('login'));
        }
    }

    public function test_admin_access_allowed_and_forbidden_routes()
    {
        $admin = new User([
            'id_user' => 101,
            'username' => 'test_admin',
            'nama' => 'Test Admin',
            'role' => 'admin',
        ]);

        // Diizinkan: Dashboard, Siswa, Penjadwalan
        $this->actingAs($admin)->get('/dashboard')->assertStatus(200);
        $this->actingAs($admin)->get('/siswa')->assertStatus(200);
        $this->actingAs($admin)->get('/penjadwalan')->assertStatus(200);

        // Ditolak (403): Fitur khusus Guru BK
        $this->actingAs($admin)->get('/konseling')->assertStatus(403);
        $this->actingAs($admin)->get('/laporan')->assertStatus(403);
        $this->actingAs($admin)->get('/riwayat-siswa')->assertStatus(403);
    }

    public function test_wali_kelas_access_forbidden_on_bk_and_admin_routes()
    {
        $waliKelas = new User([
            'id_user' => 102,
            'username' => 'test_walikelas',
            'nama' => 'Test Wali Kelas',
            'role' => 'wali_kelas',
        ]);

        // Diizinkan: Dashboard
        $this->actingAs($waliKelas)->get('/dashboard')->assertStatus(200);

        // Ditolak (403): Konseling, Laporan, Siswa
        $this->actingAs($waliKelas)->get('/konseling')->assertStatus(403);
        $this->actingAs($waliKelas)->get('/laporan')->assertStatus(403);
        $this->actingAs($waliKelas)->get('/siswa')->assertStatus(403);
    }

    public function test_guru_bk_access_allowed_on_bk_routes()
    {
        $guruBk = new User([
            'id_user' => 103,
            'username' => 'test_gurubk',
            'nama' => 'Test Guru BK',
            'role' => 'guru_bk',
        ]);

        // Diizinkan untuk semua rute operasional BK
        $this->actingAs($guruBk)->get('/dashboard')->assertStatus(200);
        $this->actingAs($guruBk)->get('/siswa')->assertStatus(200);
        $this->actingAs($guruBk)->get('/penjadwalan')->assertStatus(200);
        $this->actingAs($guruBk)->get('/konseling')->assertStatus(200);
        $this->actingAs($guruBk)->get('/laporan')->assertStatus(200);
        $this->actingAs($guruBk)->get('/riwayat-siswa')->assertStatus(200);
    }

    public function test_existing_adminbk_user_can_access_dashboard()
    {
        $user = User::where('username', 'adminbk')->first();
        if ($user) {
            $this->actingAs($user)->get('/dashboard')->assertStatus(200);
        }
    }
}
