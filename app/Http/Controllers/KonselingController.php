<?php

namespace App\Http\Controllers;

use App\Models\Konseling;
use App\Models\Siswa;
use App\Models\JenisMasalah;
use App\Models\Kelas;
use App\Models\Notifikasi;
use App\Models\Penjadwalan;
use Illuminate\Http\Request;

class KonselingController extends Controller
{
    public function index(Request $request)
    {
        $query = Konseling::with([
            'siswa.kelas',
            'jenisMasalah',
            'tindakLanjut'
        ]);

        // search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('masalah', 'like', '%' . $search . '%')
                    ->orWhere('hasil_konseling', 'like', '%' . $search . '%')
                    ->orWhere('catatan', 'like', '%' . $search . '%')
                    ->orWhere('rencana_tindak_lanjut', 'like', '%' . $search . '%')
                    ->orWhereHas('siswa', function ($siswa) use ($search) {
                        $siswa->whereNameLike($search)
                            ->orWhere('nis', 'like', '%' . $search . '%')
                            ->orWhereHas('kelas', function ($kelas) use ($search) {
                                $kelas->where('nama_kelas', 'like', '%' . $search . '%');
                            });
                    })
                    ->orWhereHas('jenisMasalah', function ($jenis) use ($search) {
                        $jenis->where('nama_jenis', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('tindakLanjut', function ($tindak) use ($search) {
                        $tindak->where('tindakan', 'like', '%' . $search . '%')
                            ->orWhere('keterangan', 'like', '%' . $search . '%');
                    });
            });
        }

        // filter kelas
        if ($request->filled('kelas')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('id_kelas', $request->kelas);
            });
        }

        // filter tanggal
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        // filter periode
        if ($request->filled('periode')) {
            switch ($request->periode) {
                case 'bulan_ini':
                    $query->whereBetween('tanggal', [
                        now()->startOfMonth()->format('Y-m-d'),
                        now()->endOfMonth()->format('Y-m-d')
                    ]);
                    break;

                case 'bulan_lalu':
                    $bulanLalu = now()->subMonth();
                    $query->whereBetween('tanggal', [
                        $bulanLalu->copy()->startOfMonth()->format('Y-m-d'),
                        $bulanLalu->copy()->endOfMonth()->format('Y-m-d')
                    ]);
                    break;

                case 'tahun_ini':
                    $query->whereBetween('tanggal', [
                        now()->startOfYear()->format('Y-m-d'),
                        now()->endOfYear()->format('Y-m-d')
                    ]);
                    break;
            }
        }

        // filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $kelas = Kelas::all();
        $konseling = $query
            ->orderByDesc('tanggal')
            ->paginate(8)
            ->withQueryString();

        return view('konseling.index', compact('konseling', 'kelas'));
    }

    public function create(Request $request)
    {
        $siswa = Siswa::with('kelas')
            ->whereHas('penjadwalan', function ($query) {
                $query->where('status', 'Terjadwal');
            })
            ->orderBy('nama_siswa', 'asc')
            ->get();

        $jenisMasalah = JenisMasalah::orderBy('nama_jenis')->get();
        $selectedSiswa = $request->id_siswa;

        return view('konseling.create', compact('siswa', 'jenisMasalah', 'selectedSiswa'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_siswa' => 'required|exists:siswa,id_siswa',
            'id_jenis' => 'required|exists:jenis_masalah,id_jenis',
            'tanggal' => 'required|date',
            'masalah' => 'required|string',
            'hasil_konseling' => 'required|string',
            'diagnosis' => 'nullable|string',
            'rencana_tindak_lanjut' => 'nullable|string',
            'catatan' => 'nullable|string',
            'status' => 'required|in:Proses,Selesai',
        ]);

        $konseling = Konseling::create($validated);
        $siswa = Siswa::find($validated['id_siswa']);

        Penjadwalan::where('id_siswa', $validated['id_siswa'])
            ->where('status', 'Terjadwal')
            ->update(['status' => 'Selesai']);

        Notifikasi::create([
            'judul' => 'Konseling Baru',
            'pesan' => 'Data konseling baru untuk siswa ' . $siswa->nama_siswa . ' berhasil ditambahkan.',
            'tipe' => 'konseling',
            'dibaca' => false,
            'id_konseling' => $konseling->id_konseling,
        ]);

        return redirect()
            ->route('konseling.index')
            ->with('success', 'Catatan konseling berhasil ditambahkan.');
    }

    public function show($id)
    {
        $konseling = Konseling::with([
            'siswa.kelas',
            'jenisMasalah',
            'tindakLanjut'
        ])->findOrFail($id);

        return view('konseling.show', compact('konseling'));
    }

    public function edit($id)
    {
        $konseling = Konseling::findOrFail($id);
        $siswa = Siswa::with('kelas')->orderBy('nama_siswa')->get();
        $jenisMasalah = JenisMasalah::orderBy('nama_jenis')->get();

        return view('konseling.edit', compact('konseling', 'siswa', 'jenisMasalah'));
    }

    public function update(Request $request, $id)
    {
        $konseling = Konseling::findOrFail($id);

        $validated = $request->validate([
            'id_siswa' => 'required|exists:siswa,id_siswa',
            'id_jenis' => 'required|exists:jenis_masalah,id_jenis',
            'tanggal' => 'required|date',
            'masalah' => 'required|string',
            'hasil_konseling' => 'required|string',
            'diagnosis' => 'nullable|string',
            'rencana_tindak_lanjut' => 'nullable|string',
            'catatan' => 'nullable|string',
            'status' => 'required|string|max:30',
        ]);

        try {
            $konseling->update($validated);
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui catatan konseling. Silakan periksa kembali data Anda.');
        }

        $redirectTo = $request->input('redirect_to');
        if ($redirectTo && (str_starts_with($redirectTo, url('/')) || (str_starts_with($redirectTo, '/') && !str_starts_with($redirectTo, '//')))) {
            return redirect($redirectTo)
                ->with('success', 'Data berhasil diperbarui.');
        }

        return redirect()
            ->route('konseling.show', $konseling->id_konseling)
            ->with('success', 'Data berhasil diperbarui.');
    }

    public function bacaNotifikasi($id)
    {
        $notifikasi = Notifikasi::findOrFail($id);
        $user = auth()->user();

        if ($user && $user->isWaliKelas()) {
            if ($notifikasi->id_konseling || in_array($notifikasi->tipe, ['konseling', 'reset_password'], true)) {
                return redirect()->route('dashboard');
            }

            $idKelas = $user->id_kelas
                ?? Kelas::whereHas('waliKelas', fn($q) => $q->where('id_user', $user->id_user))->value('id_kelas');

            $isAllowed = ($idKelas && (int) $notifikasi->id_kelas === (int) $idKelas)
                || ((int) $notifikasi->id_user === (int) $user->id_user);

            if (!$isAllowed) {
                return redirect()->route('wali.pengajuan.index');
            }

            $notifikasi->update([
                'dibaca' => true,
                'updated_at' => now(),
            ]);

            return redirect()->route('wali.pengajuan.index');
        }

        if ($user && $user->isAdmin()) {
            if ($notifikasi->id_konseling || in_array($notifikasi->tipe, ['konseling', 'jadwal', 'penjadwalan'], true) || $notifikasi->id_kelas !== null) {
                return redirect()->route('dashboard');
            }

            $isAllowed = in_array($notifikasi->tipe, ['reset_password', 'siswa', 'user'], true)
                || ((int) $notifikasi->id_user === (int) $user->id_user);

            if ($isAllowed) {
                $notifikasi->update([
                    'dibaca' => true,
                    'updated_at' => now(),
                ]);
            }

            if (in_array($notifikasi->tipe, ['reset_password', 'user'], true)) {
                return redirect()->route('users.index');
            }

            if ($notifikasi->tipe === 'siswa') {
                return redirect()->route('siswa.index');
            }

            return redirect()->route('dashboard');
        }

        if ($user && $user->isGuruBK()) {
            $isAllowed = $notifikasi->tipe !== 'reset_password'
                && $notifikasi->id_kelas === null
                && ($notifikasi->id_user === null || (int) $notifikasi->id_user === (int) $user->id_user);

            if ($isAllowed) {
                $notifikasi->update([
                    'dibaca' => true,
                    'updated_at' => now(),
                ]);
            }

            if ($notifikasi->id_konseling) {
                return redirect()->route('konseling.show', $notifikasi->id_konseling);
            }

            if ($notifikasi->tipe === 'siswa') {
                return redirect()->route('siswa.index');
            }

            if ($notifikasi->tipe === 'jadwal' || $notifikasi->tipe === 'penjadwalan') {
                return redirect()->route('penjadwalan.index');
            }

            return redirect()->route('konseling.index');
        }

        return redirect()->route('dashboard');
    }

    public function markAllRead(Request $request)
    {
        $user = auth()->user();
        if ($user) {
            $query = Notifikasi::where('dibaca', false);
            if ($user->isWaliKelas()) {
                $idKelas = $user->id_kelas
                    ?? Kelas::whereHas('waliKelas', fn($q) => $q->where('id_user', $user->id_user))->value('id_kelas');
                $query->whereNotIn('tipe', ['konseling', 'reset_password'])
                    ->whereNull('id_konseling')
                    ->where(function ($q) use ($user, $idKelas) {
                        if ($idKelas) {
                            $q->where('id_kelas', $idKelas)
                              ->orWhere('id_user', $user->id_user);
                        } else {
                            $q->where('id_user', $user->id_user);
                        }
                    });
            } elseif ($user->isAdmin()) {
                $query->where(function ($q) use ($user) {
                        $q->whereIn('tipe', ['reset_password', 'siswa', 'user'])
                          ->orWhere('id_user', $user->id_user);
                    })
                    ->whereNotIn('tipe', ['konseling', 'jadwal', 'penjadwalan'])
                    ->whereNull('id_konseling')
                    ->whereNull('id_kelas');
            } elseif ($user->isGuruBK()) {
                $query->where('tipe', '!=', 'reset_password')
                    ->whereNull('id_kelas')
                    ->where(function ($q) use ($user) {
                        $q->whereNull('id_user')
                          ->orWhere('id_user', $user->id_user);
                    });
            }
            $query->update([
                'dibaca' => true,
                'updated_at' => now(),
            ]);
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back();
    }

    public function destroy($id)
    {
        $konseling = Konseling::findOrFail($id);
        $konseling->delete();

        return redirect()
            ->route('konseling.index')
            ->with('success', 'Catatan konseling berhasil dihapus.');
    }
}
