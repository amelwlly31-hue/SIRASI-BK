<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('kelas');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%")
                    ->orWhere('role', 'like', "%{$search}%")
                    ->orWhereHas('kelas', function ($k) use ($search) {
                        $k->where('nama_kelas', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->orderBy('role')->orderBy('nama')->paginate(10)->withQueryString();
        $daftarKelas = Kelas::all();

        return view('users.index', compact('users', 'daftarKelas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,guru_bk,wali_kelas',
            'id_kelas' => 'nullable|required_if:role,wali_kelas|exists:kelas,id_kelas',
        ], [
            'id_kelas.required_if' => 'Kelas binaan wajib dipilih untuk peran Wali Kelas.',
            'username.unique' => 'Username / NIP tersebut sudah terdaftar.',
            'password.min' => 'Password baru minimal 6 karakter.',
        ]);

        $userData = [
            'nama' => $validated['nama'],
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'id_kelas' => $validated['role'] === 'wali_kelas' ? $validated['id_kelas'] : null,
        ];

        User::create($userData);

        return redirect()->route('users.index')->with('success', 'Akun pengguna baru berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'username' => [
                'required',
                'string',
                'max:50',
                Rule::unique('users', 'username')->ignore($user->id_user, 'id_user'),
            ],
            'password' => 'nullable|string|min:6',
            'role' => 'required|in:admin,guru_bk,wali_kelas',
            'id_kelas' => 'nullable|required_if:role,wali_kelas|exists:kelas,id_kelas',
        ], [
            'id_kelas.required_if' => 'Kelas binaan wajib dipilih untuk peran Wali Kelas.',
            'username.unique' => 'Username / NIP tersebut sudah digunakan akun lain.',
            'password.min' => 'Password baru minimal 6 karakter.',
        ]);

        $updateData = [
            'nama' => $validated['nama'],
            'username' => $validated['username'],
            'role' => $validated['role'],
            'id_kelas' => $validated['role'] === 'wali_kelas' ? $validated['id_kelas'] : null,
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);

        return redirect()->route('users.index')->with('success', 'Data akun pengguna berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Pengaman: Jangan hapus akun sendiri yang sedang login
        if (Auth::user()->id_user == $user->id_user) {
            return redirect()->route('users.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif.');
        }

        // Pengaman: Jangan hapus akun Guru BK utama
        if ($user->username === 'adminbk' || ($user->isGuruBK() && User::where('role', 'guru_bk')->count() <= 1)) {
            return redirect()->route('users.index')->with('error', 'Akun Guru BK utama tidak dapat dihapus demi integritas data konseling.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Akun pengguna berhasil dihapus.');
    }
}
