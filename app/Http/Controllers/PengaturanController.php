<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PengaturanController extends Controller
{
    public function index()         // menampilkan halaman pengaturan
    {
        $user = Auth::user();

        return view('pengaturan.index', compact('user'));
    }

    public function updateProfile(Request $request)         // mengubah profil pengguna
    {
        $user = Auth::user();

        $validated = $request->validate([
            'nama' => 'required|string|max:100',

            'username' => [
                'required',
                'string',
                'max:100',
                'unique:users,username,' . $user->id_user . ',id_user',
            ],

            'foto_profil' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        $data = [
            'nama' => $validated['nama'],
            'username' => $validated['username'],
        ];

        if ($request->hasFile('foto_profil')) {
            if ($user->foto_profil) {
                Storage::disk('public')->delete($user->foto_profil);
            }

            $data['foto_profil'] = $request
                ->file('foto_profil')
                ->store('profile', 'public');
        }

        try {
            User::where('id_user', $user->id_user)
                ->update($data);
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui profil. Silakan coba lagi.');
        }

        return redirect()
            ->route('pengaturan.index')
            ->with(
                'success',
                'Data berhasil diperbarui.'
            );
    }

    public function deleteProfilePhoto()
    {
        $user = Auth::user();
        $photoPath = $user->foto_profil;

        if ($photoPath) {
            $user->foto_profil = null;
            $user->save();
            Storage::disk('public')->delete($photoPath);
        }

        return redirect()
            ->route('pengaturan.index')
            ->with('success', 'Foto profil berhasil dihapus.');
    }

    public function updatePassword(Request $request)        // mengubah password pengguna
    {
        $validated = $request->validate([
            'password_lama' => 'required|string',

            'password_baru' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'different:password_lama',
            ],
        ]);

        $user = Auth::user();

        if (!Hash::check(           // cek password lama
            $validated['password_lama'],
            $user->password
        )) {
            return back()
                ->withErrors([
                    'password_lama' =>
                        'Password lama tidak sesuai.'
                ])
                ->withInput();
        }

        $passwordHash = Hash::make($validated['password_baru']);

        // Simpan ke record user yang sedang login agar target selalu sama
        // dengan akun yang password lamanya baru saja diverifikasi.
        $user->password = $passwordHash;
        $saved = $user->save();
        $persistedUser = $saved ? $user->fresh() : null;

        // Pastikan hash di database cocok dan provider autentikasi yang dipakai
        // Auth::attempt() menerima password baru untuk username akun ini.
        $sameAccount = $persistedUser
            && (int) $persistedUser->id_user === (int) $user->id_user;
        $credentialsWork = $sameAccount && Auth::validate([
            'username' => $persistedUser->username,
            'password' => $validated['password_baru'],
        ]);

        if (
            !$sameAccount
            || !Hash::check($validated['password_baru'], $persistedUser->password)
            || !$credentialsWork
        ) {
            return back()
                ->withErrors([
                    'password_baru' => 'Password gagal disimpan. Silakan coba lagi.',
                ])
                ->withInput();
        }

        return redirect()
            ->route('pengaturan.index')
            ->with(
                'success',
                'Password berhasil diperbarui.'
            );
    }
}
