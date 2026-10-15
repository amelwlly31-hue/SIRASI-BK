<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\KonselingController;
use App\Http\Controllers\TindakLanjutController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PenjadwalanController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PersetujuanWaliController;
use App\Http\Controllers\PortalSiswaController;
/* | | web routes | | | here is where you can register web routes for your application. these | routes are loaded by the routeserviceprovider within a group which | contains the "web" middleware group. now create something great! | */

// Rute Publik (Guest / Autentikasi)
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Portal Bimbingan Konseling Siswa Mandiri (Publik / Verifikasi NIS)
Route::prefix('portal-siswa')->name('portal.siswa.')->group(function () {
    Route::get('/', [PortalSiswaController::class, 'index'])->name('index');
    Route::post('/login', [PortalSiswaController::class, 'login'])->name('login');
    Route::post('/logout', [PortalSiswaController::class, 'logout'])->name('logout');
    Route::post('/ajukan', [PortalSiswaController::class, 'ajukan'])->name('ajukan');
});

// Rute Terproteksi Autentikasi (Semua User Login)
Route::middleware(['auth'])->group(function () {

    // Dashboard & Utilitas Bersama
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/notifikasi/{id}/baca', [KonselingController::class, 'bacaNotifikasi'])->name('notifikasi.baca');

    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
    Route::put('/pengaturan/profil', [PengaturanController::class, 'updateProfile'])->name('pengaturan.profil.update');
    Route::put('/pengaturan/password', [PengaturanController::class, 'updatePassword'])->name('pengaturan.password.update');

    Route::get('/profile-photo/{filename}', function ($filename) {
        $path = storage_path('app/public/profile/' . basename($filename));

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->file($path);
    })->name('profile.photo');

    // Akses Eksklusif: Khusus Admin
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('users', UserController::class);
    });

    // Akses Bersama: Admin dan Guru BK
    Route::middleware(['role:admin,guru_bk'])->group(function () {
        Route::patch('/siswa/{id}/toggle-status', [SiswaController::class, 'toggleStatus'])->name('siswa.toggleStatus');
        Route::post('/siswa/import', [SiswaController::class, 'import'])->name('siswa.import');
        Route::resource('siswa', SiswaController::class);
        Route::resource('penjadwalan', PenjadwalanController::class);
    });

    // Akses Eksklusif: Khusus Guru BK
    Route::middleware(['role:guru_bk'])->group(function () {
        Route::get('/riwayat-siswa', [SiswaController::class, 'riwayat'])->name('siswa.riwayat');
        Route::get('/siswa/{id}/surat-panggilan', [SiswaController::class, 'suratPanggilan'])->name('siswa.surat_panggilan');
        Route::get('/siswa/{id}/surat-panggilan/pdf', [SiswaController::class, 'suratPanggilanPdf'])->name('siswa.surat_panggilan.pdf');
        Route::get('/siswa/{id}/surat-panggilan/docx', [SiswaController::class, 'suratPanggilanDocx'])->name('siswa.surat_panggilan.docx');

        Route::resource('konseling', KonselingController::class);
        Route::resource('tindak_lanjut', TindakLanjutController::class);

        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/per-siswa', [LaporanController::class, 'perSiswa'])->name('laporan.per_siswa');
        Route::get('/laporan/rekap-masalah', [LaporanController::class, 'rekapMasalah'])->name('laporan.rekap_masalah');
    });

    // Akses Eksklusif: Khusus Wali Kelas
    Route::middleware(['role:wali_kelas'])->group(function () {
        Route::get('/wali-kelas/pengajuan', [PersetujuanWaliController::class, 'index'])->name('wali.pengajuan.index');
        Route::patch('/wali-kelas/pengajuan/{id}/approve', [PersetujuanWaliController::class, 'approve'])->name('wali.pengajuan.approve');
        Route::patch('/wali-kelas/pengajuan/{id}/reject', [PersetujuanWaliController::class, 'reject'])->name('wali.pengajuan.reject');
    });

});
