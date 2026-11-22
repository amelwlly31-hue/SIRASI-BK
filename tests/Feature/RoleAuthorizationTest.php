<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class RoleAuthorizationTest extends TestCase
{
    public function test_login_page_is_available_to_guests_and_logged_in_users_are_sent_to_dashboard(): void
    {
        $this->get(route('login'))->assertOk();

        $user = new User([
            'id_user' => 99,
            'username' => 'login_redirect_test',
            'nama' => 'Login Redirect Test',
            'role' => 'guru_bk',
        ]);

        $this->actingAs($user)
            ->get(route('login'))
            ->assertRedirect(route('dashboard'));
    }

    public function test_logout_clears_authentication_and_refreshing_a_protected_url_returns_to_login(): void
    {
        $user = new User([
            'id_user' => 100,
            'username' => 'logout_test',
            'nama' => 'Logout Test',
            'role' => 'guru_bk',
        ]);

        $this->actingAs($user);
        $this->get('/pengaturan')->assertOk();

        $this->post(route('logout'))
            ->assertRedirect(route('login'));

        $this->assertGuest();
        $this->get('/siswa')->assertRedirect(route('login'));
    }

    public function test_authenticated_roles_keep_their_session_when_refreshing_shared_protected_page(): void
    {
        foreach (['admin', 'guru_bk', 'wali_kelas', 'siswa'] as $index => $role) {
            $user = new User([
                'id_user' => 110 + $index,
                'username' => 'refresh_' . $role,
                'nama' => 'Refresh Test',
                'role' => $role,
            ]);

            $protectedResponse = $this->actingAs($user)
                ->get('/profile-photo/__auth_refresh_test_missing__.jpg');
            $protectedResponse->assertNotFound();

            // A second request simulates a browser refresh with the same session.
            $this->get('/profile-photo/__auth_refresh_test_missing__.jpg')->assertNotFound();
        }
    }

    public function test_siswa_role_cannot_open_staff_siswa_management_after_dashboard_redirect(): void
    {
        $siswa = new User([
            'id_user' => 120,
            'username' => 'test_siswa_role',
            'nama' => 'Test Siswa',
            'role' => 'siswa',
        ]);

        $this->actingAs($siswa)
            ->get('/dashboard')
            ->assertRedirect(route('portal.siswa.index'));

        $this->get('/siswa')->assertRedirect(route('dashboard'));
    }

    public function test_each_role_is_redirected_from_routes_reserved_for_other_roles(): void
    {
        $restrictedRequests = [
            ['admin', '/konseling'],
            ['guru_bk', '/users'],
            ['wali_kelas', '/siswa'],
            ['siswa', '/siswa'],
        ];

        foreach ($restrictedRequests as $index => [$role, $path]) {
            $user = new User([
                'id_user' => 130 + $index,
                'username' => 'restricted_' . $role,
                'nama' => 'Role Restriction Test',
                'role' => $role,
            ]);

            $this->actingAs($user)->get($path)->assertRedirect(route('dashboard'));
        }
    }

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

    public function test_admin_access_allowed_and_redirects_from_routes_reserved_for_guru_bk()
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

        // Rute BK khusus tetap tertutup untuk admin dan kembali ke dashboard.
        $this->actingAs($admin)->get('/konseling')->assertRedirect(route('dashboard'));
        $this->actingAs($admin)->get('/laporan')->assertRedirect(route('dashboard'));
        $this->actingAs($admin)->get('/riwayat-siswa')->assertRedirect(route('dashboard'));
    }

    public function test_wali_kelas_is_redirected_from_bk_and_admin_routes()
    {
        $waliKelas = new User([
            'id_user' => 102,
            'username' => 'test_walikelas',
            'nama' => 'Test Wali Kelas',
            'role' => 'wali_kelas',
        ]);

        // Diizinkan: Dashboard
        $this->actingAs($waliKelas)->get('/dashboard')->assertStatus(200);

        // Rute staf tetap tertutup untuk wali kelas.
        $this->actingAs($waliKelas)->get('/konseling')->assertRedirect(route('dashboard'));
        $this->actingAs($waliKelas)->get('/laporan')->assertRedirect(route('dashboard'));
        $this->actingAs($waliKelas)->get('/siswa')->assertRedirect(route('dashboard'));
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
