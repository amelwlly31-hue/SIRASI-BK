<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PasswordChangeLoginTest extends TestCase
{
    use DatabaseTransactions;

    public function test_walikelas77_password_change_uses_the_same_database_record_as_login(): void
    {
        $this->assertSame(
            config('database.connections.' . config('database.default') . '.database'),
            DB::connection()->getDatabaseName(),
            'Test DB connection must use the configured website database.'
        );

        $user = User::query()->where('username', 'walikelas77')->firstOrFail();
        $userId = $user->id_user;
        $oldPassword = 'Test-old-password-77';
        $newPassword = 'Test-new-password-77';

        // This is rolled back by DatabaseTransactions when the test completes.
        $user->password = Hash::make($oldPassword);
        $user->save();

        $shortPasswordResponse = $this->actingAs($user)->put(route('pengaturan.password.update'), [
            'password_lama' => $oldPassword,
            'password_baru' => 'short7',
            'password_baru_confirmation' => 'short7',
        ]);

        $shortPasswordResponse->assertSessionHasErrors('password_baru');
        $this->assertTrue(Hash::check($oldPassword, User::query()->findOrFail($userId)->password));

        $changeResponse = $this->actingAs($user)->put(route('pengaturan.password.update'), [
            'password_lama' => $oldPassword,
            'password_baru' => $newPassword,
            'password_baru_confirmation' => $newPassword,
        ]);

        $changeResponse
            ->assertRedirect(route('pengaturan.index'))
            ->assertSessionHas('success');

        $storedUser = User::query()->findOrFail($userId);
        $this->assertSame('walikelas77', $storedUser->username);
        $this->assertNotSame($oldPassword, $storedUser->password);
        $this->assertTrue(Hash::check($newPassword, $storedUser->password));
        $this->assertFalse(Hash::check($oldPassword, $storedUser->password));

        $this->post(route('logout'));

        $this->post(route('login.process'), [
            'username' => $storedUser->username,
            'password' => $newPassword,
        ])->assertRedirect(route('dashboard'));

        $this->post(route('logout'));

        $this->post(route('login.process'), [
            'username' => $storedUser->username,
            'password' => $oldPassword,
        ])->assertSessionHasErrors('username');
    }
}
