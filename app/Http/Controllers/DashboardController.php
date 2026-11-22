<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Konseling;
use App\Models\TindakLanjut;
use App\Models\Penjadwalan;
use App\Models\Notifikasi;
use App\Models\User;
use App\Models\Kelas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var User|null $user The web guard resolves users through App\Models\User. */
        $user = Auth::user();

        // 0. Pengalihan Khusus Siswa ke Portal Siswa Mandiri
        if ($user && $user->isSiswa()) {
            return redirect()->route('portal.siswa.index');
        }

        // 1. Tampilan Khusus Admin
        if ($user && $user->isAdmin()) {
            $totalUser = User::count();
            $totalAdmin = User::where('role', 'admin')->count();
            $totalGuruBK = User::where('role', 'guru_bk')->count();
            $totalWaliKelas = User::where('role', 'wali_kelas')->count();

            $totalSiswa = Siswa::count();
            $siswaAktif = Siswa::where('status', 'Aktif')->count();
            $siswaTidakAktif = Siswa::where('status', 'Tidak Aktif')->count();

            $totalKelas = Kelas::count();
            $usersTerbaru = User::with('kelas')
                ->latest('id_user')
                ->limit(6)
                ->get();

            return view('dashboard.admin', compact(
                'totalUser',
                'totalAdmin',
                'totalGuruBK',
                'totalWaliKelas',
                'totalSiswa',
                'siswaAktif',
                'siswaTidakAktif',
                'totalKelas',
                'usersTerbaru'
            ));
        }

        // 2. Tampilan Khusus Wali Kelas
        if ($user && $user->isWaliKelas()) {
            $kelas = $user->kelas;
            $idKelas = $user->id_kelas;

            $totalSiswaKelas = 0;
            $siswaLaki = 0;
            $siswaPerempuan = 0;
            $pengajuanPending = 0;
            $totalJadwalKelas = 0;
            $daftarSiswa = collect();
            $jadwalSiswa = collect();

            if (!$idKelas && $user) {
                $foundKelas = Kelas::whereHas('waliKelas', fn($q) => $q->where('id_user', $user->id_user))->first();
                if ($foundKelas) {
                    $idKelas = $foundKelas->id_kelas;
                    $kelas = $foundKelas;
                    $user->update(['id_kelas' => $idKelas]);
                }
            }

            if ($idKelas) {
                $totalSiswaKelas = Siswa::where('id_kelas', $idKelas)->count();
                $siswaLaki = Siswa::where('id_kelas', $idKelas)->where('jenis_kelamin', 'L')->count();
                $siswaPerempuan = Siswa::where('id_kelas', $idKelas)->where('jenis_kelamin', 'P')->count();

                $baseKelasQuery = Penjadwalan::whereHas('siswa', function ($sub) use ($idKelas) {
                    $sub->where('id_kelas', $idKelas);
                });

                $pengajuanPending = (clone $baseKelasQuery)->where('status', 'Diajukan')->count();
                $totalJadwalKelas = (clone $baseKelasQuery)->count();

                $daftarSiswa = Siswa::where('id_kelas', $idKelas)
                    ->orderBy('nama_siswa')
                    ->get();

                // Jadwal bimbingan siswa kelas ini (tanpa kolom catatan pribadi konseling siswa)
                $jadwalSiswa = (clone $baseKelasQuery)
                    ->select([
                        'id_penjadwalan',
                        'kode_pengajuan',
                        'id_siswa',
                        'id_slot',
                        'tanggal',
                        'waktu_mulai',
                        'waktu_selesai',
                        'jenis_bimbingan',
                        'status',
                        'id_wali',
                        'waktu_persetujuan_wali',
                        'catatan_wali',
                        'created_at',
                        'updated_at',
                    ])
                    ->with('siswa.kelas')
                    ->orderByRaw("CASE WHEN status = 'Diajukan' THEN 0 ELSE 1 END")
                    ->orderBy('tanggal', 'desc')
                    ->orderBy('id_penjadwalan', 'desc')
                    ->limit(10)
                    ->get();
            }

            return view('dashboard.wali_kelas', compact(
                'kelas',
                'totalSiswaKelas',
                'siswaLaki',
                'siswaPerempuan',
                'pengajuanPending',
                'totalJadwalKelas',
                'daftarSiswa',
                'jadwalSiswa'
            ));
        }

        // Dashboard operasional berikut hanya untuk Guru BK. Jangan perlakukan
        // role lain yang tidak dikenal sebagai Guru BK.
        abort_unless($user && $user->isGuruBK(), 403, 'Anda tidak memiliki hak akses ke dashboard ini.');

        // 3. Tampilan Khusus Guru BK (Logika query eksisting 100% dipertahankan)
        $totalSiswa = Siswa::count();
        $totalKonseling = Konseling::count();

        $konselingBulanIni = Konseling::whereMonth(
            'tanggal',
            Carbon::now()->month
        )
        ->whereYear(
            'tanggal',
            Carbon::now()->year
        )
        ->count();

        $totalTindakLanjut = TindakLanjut::count();

        $siswaPerhatian = Siswa::with('kelas')
            ->withCount('konseling')
            ->having('konseling_count', '>=', 3)
            ->orderByDesc('konseling_count')
            ->limit(5)
            ->get();

        $riwayatKonseling = Konseling::with(['siswa.kelas', 'jenisMasalah'])
            ->orderBy('tanggal', 'desc')
            ->limit(5)
            ->get();

        $konselingPerBulan = Konseling::select(
                DB::raw('MONTH(tanggal) as bulan'),
                DB::raw('COUNT(*) as jumlah')
            )
            ->whereYear('tanggal', Carbon::now()->year)
            ->groupBy(DB::raw('MONTH(tanggal)'))
            ->orderBy('bulan')
            ->get();

        $jadwalBimbingan = Penjadwalan::with('siswa.kelas')
            ->where('tanggal', '>=', Carbon::today())
            ->orderBy('tanggal')
            ->orderBy('waktu_mulai')
            ->limit(5)
            ->get();

        return view('dashboard.index', compact(
            'totalSiswa',
            'totalKonseling',
            'konselingBulanIni',
            'totalTindakLanjut',
            'siswaPerhatian',
            'riwayatKonseling',
            'konselingPerBulan',
            'jadwalBimbingan'
        ));
    }

    /**
     * Tandai satu notifikasi sebagai sudah dibaca dan arahkan ke halaman terkait sesuai role.
     */
    public function bacaNotifikasi($id)
    {
        /** @var User|null $user The web guard resolves users through App\Models\User. */
        $user = Auth::user();
        abort_unless($user, 403);

        $notifikasi = Notifikasi::findOrFail($id);

        if ($user->isSiswa()) {
            abort_unless((int) $notifikasi->id_user === (int) $user->id_user, 403);
            $notifikasi->update(['dibaca' => true, 'updated_at' => now()]);
            return redirect()->route('portal.siswa.status');
        }

        if ($user->isWaliKelas()) {
            $idKelas = $user->id_kelas ?: Kelas::whereHas('waliKelas', fn($q) => $q->where('id_user', $user->id_user))->value('id_kelas');
            $isAllowed = ((int) $notifikasi->id_user === (int) $user->id_user)
                || ($notifikasi->id_user === null && $idKelas && (int) $notifikasi->id_kelas === (int) $idKelas);
            abort_unless($isAllowed, 403);

            $notifikasi->update(['dibaca' => true, 'updated_at' => now()]);
            return redirect()->route('wali.pengajuan.index');
        }

        if ($user->isAdmin()) {
            $isAllowed = in_array($notifikasi->tipe, ['reset_password', 'siswa', 'user'], true)
                || ((int) $notifikasi->id_user === (int) $user->id_user);
            abort_unless($isAllowed, 403);

            $notifikasi->update(['dibaca' => true, 'updated_at' => now()]);

            if (in_array($notifikasi->tipe, ['reset_password', 'user'], true)) {
                return redirect()->route('users.index');
            }

            if ($notifikasi->tipe === 'siswa') {
                return redirect()->route('siswa.index');
            }

            return redirect()->route('dashboard');
        }

        if ($user->isGuruBK()) {
            $isAllowed = $notifikasi->tipe !== 'reset_password'
                && ((int) $notifikasi->id_user === (int) $user->id_user || ($notifikasi->id_user === null && $notifikasi->id_kelas === null));
            abort_unless($isAllowed, 403);

            $notifikasi->update(['dibaca' => true, 'updated_at' => now()]);

            if (!empty($notifikasi->id_konseling) && Konseling::where('id_konseling', $notifikasi->id_konseling)->exists()) {
                return redirect()->route('konseling.show', $notifikasi->id_konseling);
            }

            if (preg_match('/\[JADWAL:(\d+)\]/', (string) $notifikasi->pesan, $matches)) {
                $idJadwal = (int) $matches[1];
                if (Penjadwalan::where('id_penjadwalan', $idJadwal)->exists()) {
                    return redirect()->route('penjadwalan.show', $idJadwal);
                }
                return redirect()->route('penjadwalan.index');
            }

            if (in_array($notifikasi->tipe, ['jadwal', 'penjadwalan'], true)) {
                return redirect()->route('penjadwalan.index');
            }

            if ($notifikasi->tipe === 'siswa') {
                return redirect()->route('siswa.index');
            }

            return back();
        }

        abort(403);
    }

    /**
     * Tandai seluruh notifikasi milik role/pengguna aktif sebagai sudah dibaca.
     */
    public function markAllNotificationsRead()
    {
        /** @var User|null $user The web guard resolves users through App\Models\User. */
        $user = Auth::user();
        abort_unless($user, 403);

        if ($user->isSiswa()) {
            Notifikasi::where('id_user', $user->id_user)
                ->where('dibaca', false)
                ->update(['dibaca' => true, 'updated_at' => now()]);
        } elseif ($user->isWaliKelas()) {
            $idKelas = $user->id_kelas ?: Kelas::whereHas('waliKelas', fn($q) => $q->where('id_user', $user->id_user))->value('id_kelas');
            Notifikasi::where('dibaca', false)
                ->whereNotIn('tipe', ['konseling', 'reset_password'])
                ->whereNull('id_konseling')
                ->where(function ($q) use ($user, $idKelas) {
                    if ($idKelas) {
                        $q->where('id_kelas', $idKelas)
                          ->orWhere('id_user', $user->id_user);
                    } else {
                        $q->where('id_user', $user->id_user);
                    }
                })
                ->update(['dibaca' => true, 'updated_at' => now()]);
        } elseif ($user->isAdmin()) {
            Notifikasi::where('dibaca', false)
                ->where(function ($q) use ($user) {
                    $q->whereIn('tipe', ['reset_password', 'siswa', 'user'])
                      ->orWhere('id_user', $user->id_user);
                })
                ->whereNotIn('tipe', ['konseling', 'jadwal', 'penjadwalan'])
                ->whereNull('id_konseling')
                ->whereNull('id_kelas')
                ->update(['dibaca' => true, 'updated_at' => now()]);
        } elseif ($user->isGuruBK()) {
            Notifikasi::where('dibaca', false)
                ->where('tipe', '!=', 'reset_password')
                ->whereNull('id_kelas')
                ->where(function ($q) use ($user) {
                    $q->whereNull('id_user')
                      ->orWhere('id_user', $user->id_user);
                })
                ->update(['dibaca' => true, 'updated_at' => now()]);
        }

        return back()->with('success', 'Semua notifikasi telah ditandai dibaca.');
    }
}
