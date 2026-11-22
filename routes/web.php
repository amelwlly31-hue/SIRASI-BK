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
Route::post('/login/password-help', [AuthController::class, 'requestPasswordReset'])->name('login.password-help');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Portal Bimbingan Konseling Siswa Mandiri (Publik Tanpa Login)
Route::prefix('portal-siswa')->name('portal.siswa.')->group(function () {
    Route::get('/', [PortalSiswaController::class, 'index'])->name('index');
    Route::get('/ajukan', [PortalSiswaController::class, 'create'])->name('create');
    Route::get('/ajukan-jadwal', [PortalSiswaController::class, 'schedule'])->name('jadwal');
    Route::post('/izin', [PortalSiswaController::class, 'ajukanIzin'])->name('izin');
    Route::post('/ajukan', [PortalSiswaController::class, 'ajukan'])->name('ajukan');
    Route::match(['get', 'post'], '/cek-status', [PortalSiswaController::class, 'status'])->name('status');
    Route::get('/tentang', [PortalSiswaController::class, 'tentang'])->name('tentang');
    Route::get('/csrf-token', [PortalSiswaController::class, 'csrfToken'])->name('csrf');
    Route::post('/login', [PortalSiswaController::class, 'login'])->name('login');
    Route::post('/logout', [PortalSiswaController::class, 'logout'])->name('logout');
});

// Rute Terproteksi Autentikasi (Semua User Login)
Route::middleware(['auth'])->group(function () {

    // Dashboard & Utilitas Bersama
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/notifikasi/{id}/baca', [KonselingController::class, 'bacaNotifikasi'])->name('notifikasi.baca');
    Route::post('/notifikasi/mark-all-read', [KonselingController::class, 'markAllRead'])->name('notifikasi.markAllRead');

    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
    Route::put('/pengaturan/profil', [PengaturanController::class, 'updateProfile'])->name('pengaturan.profil.update');
    Route::delete('/pengaturan/profil/foto', [PengaturanController::class, 'deleteProfilePhoto'])->name('pengaturan.profil.photo.delete');
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
        Route::get('/admin/siswa', [SiswaController::class, 'adminIndex'])->name('admin.siswa.index');
    });

    // Akses Bersama: Admin dan Guru BK
    Route::middleware(['role:admin,guru_bk'])->group(function () {
        Route::patch('/siswa/{id}/toggle-status', [SiswaController::class, 'toggleStatus'])->name('siswa.toggleStatus');
        Route::post('/siswa/import', [SiswaController::class, 'import'])->name('siswa.import');
        Route::resource('siswa', SiswaController::class);

    });

    // Akses Penjadwalan: Admin dan seluruh variasi role Guru BK
    Route::middleware(['role:admin,guru_bk,gurubk,guru'])->group(function () {
        Route::post('/penjadwalan/jadwal-mengajar', [PenjadwalanController::class, 'storeJadwalMengajar'])->name('penjadwalan.mengajar.store');
        Route::put('/penjadwalan/jadwal-mengajar/{id}', [PenjadwalanController::class, 'updateJadwalMengajar'])->name('penjadwalan.mengajar.update');
        Route::delete('/penjadwalan/jadwal-mengajar/{id}', [PenjadwalanController::class, 'destroyJadwalMengajar'])->name('penjadwalan.mengajar.destroy');

        Route::post('/penjadwalan/slot-konseling', [PenjadwalanController::class, 'storeSlot'])->name('penjadwalan.slot.store');
        Route::put('/penjadwalan/slot-konseling/{id}', [PenjadwalanController::class, 'updateSlot'])->name('penjadwalan.slot.update');
        Route::delete('/penjadwalan/slot-konseling/{id}', [PenjadwalanController::class, 'destroySlot'])->name('penjadwalan.slot.destroy');

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

    });

    // Laporan dapat diakses Admin dan Guru BK
    Route::middleware(['role:admin,guru_bk'])->group(function () {
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/per-siswa', [LaporanController::class, 'perSiswa'])->name('laporan.per_siswa');
        Route::get('/laporan/rekap-masalah', [LaporanController::class, 'rekapMasalah'])->name('laporan.rekap_masalah');
        Route::get('/laporan/preview', [LaporanController::class, 'preview'])->name('laporan.preview');
        Route::get('/laporan/konseling/{id}/cetak', [LaporanController::class, 'cetakIndividu'])->name('laporan.konseling.cetak');
        Route::get('/laporan/export/excel', [LaporanController::class, 'exportRekapExcel'])->name('laporan.export.excel');
        Route::get('/laporan/export/pdf', [LaporanController::class, 'exportPdf'])->name('laporan.export.pdf');
        Route::get('/laporan/export/docx', [LaporanController::class, 'exportDocx'])->name('laporan.export.docx');
    });

    // Akses Eksklusif: Khusus Wali Kelas
    Route::middleware(['role:wali_kelas'])->group(function () {
        Route::get('/wali-kelas/pengajuan', [PersetujuanWaliController::class, 'index'])->name('wali.pengajuan.index');
        Route::patch('/wali-kelas/pengajuan/{id}/approve', [PersetujuanWaliController::class, 'approve'])->name('wali.pengajuan.approve');
        Route::patch('/wali-kelas/pengajuan/{id}/reject', [PersetujuanWaliController::class, 'reject'])->name('wali.pengajuan.reject');
    });

});
