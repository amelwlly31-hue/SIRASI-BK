<?php

namespace App\Providers;

use App\Models\Notifikasi;
use App\Models\Penjadwalan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /* register any application services. @return void */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        try {
            if (Schema::hasTable('users') && !Schema::hasColumn('users', 'email')) {
                Schema::table('users', function (\Illuminate\Database\Schema\Blueprint $table) {
                    $table->string('email')->nullable()->unique()->after('username');
                });
            }
        } catch (\Throwable $e) {
            // abaikan jika database belum siap
        }

        View::composer('*', function ($view) {
            try {
                if (Schema::hasTable('penjadwalan') && Schema::hasTable('notifikasis')) {
                    $todayDate = now()->toDateString();
                    $jadwalHariIni = Penjadwalan::with('siswa.kelas')
                        ->whereDate('tanggal', $todayDate)
                        ->where('status', 'Terjadwal')
                        ->get();

                    foreach ($jadwalHariIni as $jadwal) {
                        $uniqueTag = "[JADWAL:{$jadwal->id_penjadwalan}]";
                        $sudahAda = Notifikasi::where('tipe', 'jadwal')
                            ->whereDate('created_at', $todayDate)
                            ->where('pesan', 'like', "%{$uniqueTag}%")
                            ->exists();

                        if (!$sudahAda) {
                            $namaSiswa = $jadwal->siswa->nama_siswa ?? 'Siswa';
                            $namaKelas = isset($jadwal->siswa->kelas->nama_kelas) ? ' (Kelas ' . $jadwal->siswa->kelas->nama_kelas . ')' : '';
                            $waktuMulai = str_replace(':', '.', substr($jadwal->waktu_mulai, 0, 5));
                            $waktuSelesai = str_replace(':', '.', substr($jadwal->waktu_selesai, 0, 5));
                            $tanggalFormatted = Carbon::parse($jadwal->tanggal)->isoFormat('D MMMM Y');

                            Notifikasi::create([
                                'judul' => 'Pengingat Jadwal BK',
                                'pesan' => "Pengingat: Jadwal bimbingan {$jadwal->jenis_bimbingan} bersama {$namaSiswa}{$namaKelas} dijadwalkan hari ini ({$tanggalFormatted}) pukul {$waktuMulai}–{$waktuSelesai} WIB. {$uniqueTag}",
                                'tipe' => 'jadwal',
                                'dibaca' => false,
                            ]);
                        }
                    }
                }

                if (Schema::hasTable('notifikasis')) {
                    // Otomatis hapus riwayat notifikasi yang SUDAH DIBACA dan melewati 24 jam sejak waktu dibaca (updated_at)
                    Notifikasi::where('dibaca', true)
                        ->where('updated_at', '<=', Carbon::now()->subHours(24))
                        ->delete();

                    $currentUser = auth()->user();
                    if ($currentUser && $currentUser->isGuruBK()) {
                        $notifikasis = Notifikasi::where('tipe', '!=', 'reset_password')
                            ->whereNull('id_kelas')
                            ->where(function ($q) use ($currentUser) {
                                $q->whereNull('id_user')
                                  ->orWhere('id_user', $currentUser->id_user);
                            })
                            ->latest()
                            ->take(10)
                            ->get();
                    } elseif ($currentUser && $currentUser->isWaliKelas()) {
                        $idKelas = $currentUser->id_kelas;
                        if (!$idKelas) {
                            $wkKelas = \App\Models\Kelas::whereHas('waliKelas', fn($q) => $q->where('id_user', $currentUser->id_user))->first();
                            if ($wkKelas) {
                                $idKelas = $wkKelas->id_kelas;
                            }
                        }
                        $notifikasis = Notifikasi::where(function ($q) use ($currentUser, $idKelas) {
                                if ($idKelas) {
                                    $q->where('id_kelas', $idKelas)
                                      ->orWhere('id_user', $currentUser->id_user);
                                } else {
                                    $q->where('id_user', $currentUser->id_user);
                                }
                            })
                            ->whereNotIn('tipe', ['konseling', 'reset_password'])
                            ->whereNull('id_konseling')
                            ->latest()
                            ->take(10)
                            ->get();
                    } elseif ($currentUser && $currentUser->isAdmin()) {
                        // Admin hanya memuat notifikasi yang relevan untuk Admin (reset_password, siswa/user, atau id_user Admin)
                        $notifikasis = Notifikasi::where(function ($q) use ($currentUser) {
                                $q->whereIn('tipe', ['reset_password', 'siswa', 'user'])
                                  ->orWhere('id_user', $currentUser->id_user);
                            })
                            ->whereNotIn('tipe', ['konseling', 'jadwal', 'penjadwalan'])
                            ->whereNull('id_konseling')
                            ->whereNull('id_kelas')
                            ->latest()
                            ->take(10)
                            ->get();
                    } else {
                        $notifikasis = collect();
                    }

                    // Saring notifikasi yang merujuk pada jadwal yang sudah dihapus agar tidak menampilkan data usang
                    $notifikasis = $notifikasis->filter(function ($notif) {
                        if (preg_match('/\[JADWAL:(\d+)\]/', (string) $notif->pesan, $m)) {
                            return Penjadwalan::where('id_penjadwalan', (int) $m[1])->exists();
                        }
                        if (preg_match('/Kode(?:\s+Izin)?:\s*(BK-[A-Z0-9]{6})/', (string) $notif->pesan, $m)) {
                            return Penjadwalan::where('kode_pengajuan', $m[1])->exists();
                        }
                        return true;
                    })->values();

                    $view->with('notifikasis', $notifikasis);
                }
            } catch (\Throwable $e) {
                // abaikan jika database belum siap
            }
        });
    }
}
