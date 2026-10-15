<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Konseling;
use App\Models\TindakLanjut;
use App\Models\Penjadwalan;
use App\Models\User;
use App\Models\Kelas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

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
            $daftarSiswa = collect();
            $jadwalSiswa = collect();

            if ($idKelas) {
                $totalSiswaKelas = Siswa::where('id_kelas', $idKelas)->count();
                $siswaLaki = Siswa::where('id_kelas', $idKelas)->where('jenis_kelamin', 'L')->count();
                $siswaPerempuan = Siswa::where('id_kelas', $idKelas)->where('jenis_kelamin', 'P')->count();

                $pengajuanPending = Penjadwalan::where('status', 'Diajukan')
                    ->whereHas('siswa', function ($q) use ($idKelas) {
                        $q->where('id_kelas', $idKelas);
                    })->count();

                $daftarSiswa = Siswa::where('id_kelas', $idKelas)
                    ->orderBy('nama_siswa')
                    ->limit(8)
                    ->get();

                // Jadwal bimbingan siswa kelas ini (tanpa catatan konseling rahasia)
                $jadwalSiswa = Penjadwalan::with('siswa')
                    ->whereHas('siswa', function ($q) use ($idKelas) {
                        $q->where('id_kelas', $idKelas);
                    })
                    ->orderBy('tanggal', 'desc')
                    ->orderBy('waktu_mulai', 'desc')
                    ->limit(5)
                    ->get();
            }

            return view('dashboard.wali_kelas', compact(
                'kelas',
                'totalSiswaKelas',
                'siswaLaki',
                'siswaPerempuan',
                'pengajuanPending',
                'daftarSiswa',
                'jadwalSiswa'
            ));
        }

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
}
