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
                    $notifikasis = Notifikasi::latest()
                        ->take(10)
                        ->get();
                    $view->with('notifikasis', $notifikasis);
                }
            } catch (\Throwable $e) {
                // abaikan jika database belum siap
            }
        });
    }
}
