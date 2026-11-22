<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Throwable;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $login = trim($validated['username']);
        $password = $validated['password'];
        $remember = $request->boolean('remember');

        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $authenticated = Auth::attempt([
            $fieldType => $login,
            'password' => $password,
        ], $remember);

        if (!$authenticated && $fieldType === 'email') {
            $authenticated = Auth::attempt([
                'username' => $login,
                'password' => $password,
            ], $remember);
        }

        if ($authenticated) {
            $request->session()->regenerate();

            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'username' => 'Username / Email atau password salah.',
        ])->withInput();
    }

    public function requestPasswordReset(Request $request)
    {
        $validated = $request->validate([
            'reset_username' => 'required|string|max:100',
            'reset_role' => 'required|in:guru_bk,wali_kelas',
        ]);

        $input = trim($validated['reset_username']);
        $role = $validated['reset_role'];

        $user = User::where('role', $role)
            ->where(function ($query) use ($input) {
                $query->where('username', $input)
                    ->orWhere('email', $input);
            })
            ->first();

        if (!$user) {
            return back()->withErrors([
                'reset_username' => 'Akun dengan Username atau Email dan role tersebut tidak ditemukan.',
            ])->withInput();
        }

        $roleLabels = [
            'guru_bk' => 'Guru BK',
            'wali_kelas' => 'Wali Kelas',
        ];

        try {
            if (Schema::hasTable('notifikasis')) {
                $adminUser = User::where('role', 'admin')->orderBy('id_user')->first();

                Notifikasi::create([
                    'judul' => 'Permintaan Reset Password',
                    'pesan' => "{$roleLabels[$role]} {$user->nama} ({$input}) mengajukan permintaan reset password akun SIRASI-BK. Silakan tindak lanjuti pada menu Kelola Pengguna.",
                    'tipe' => 'reset_password',
                    'dibaca' => false,
                    'id_konseling' => null,
                    'id_kelas' => null,
                    'id_user' => $adminUser?->id_user,
                ]);
            }
        } catch (Throwable $exception) {
            report($exception);
        }

        $message = "Permintaan reset password akun SIRASI-BK.\n\n"
            . "Nama: {$user->nama}\n"
            . "Username / Email: {$input}\n"
            . "Role: {$roleLabels[$role]}\n"
            . "Waktu: " . now()->timezone('Asia/Jakarta')->format('d-m-Y H:i:s') . " WIB\n\n"
            . "Silakan verifikasi identitas pemohon sebelum mereset password.";

        try {
            Mail::raw($message, function ($mail) {
                $mail->to('negeriduadramaga@gmail.com')
                    ->subject('Permintaan Reset Password SIRASI-BK');
            });
        } catch (Throwable $exception) {
            report($exception);
        }

        return redirect()->route('login')->with(
            'reset_success',
            'Permintaan reset password berhasil dikirim ke Administrator SMP Negeri 2 Dramaga.'
        );
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
