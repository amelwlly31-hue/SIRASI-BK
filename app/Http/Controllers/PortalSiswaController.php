<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Penjadwalan;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PortalSiswaController extends Controller
{
    /**
     * Menampilkan antarmuka Portal Siswa Mandiri.
     */
    public function index(Request $request)
    {
        $siswa = $this->resolveActiveSiswa();

        if (!$siswa) {
            return view('portal_siswa.index', [
                'siswa' => null,
                'pengajuan' => collect(),
                'jadwalTerisi' => collect(),
                'selectedDate' => null,
            ]);
        }

        // Ambil riwayat pengajuan mandiri siswa yang sedang aktif
        $pengajuan = Penjadwalan::with('waliKelas')
            ->where('id_siswa', $siswa->id_siswa)
            ->orderBy('tanggal', 'desc')
            ->orderBy('waktu_mulai', 'desc')
            ->get();

        // Cek ketersediaan slot jadwal Guru BK pada tanggal tertentu (default hari ini / request)
        $selectedDate = $request->input('tanggal', Carbon::today()->format('Y-m-d'));
        $jadwalTerisi = Penjadwalan::where('tanggal', $selectedDate)
            ->whereIn('status', Penjadwalan::ACTIVE_STATUSES)
            ->orderBy('waktu_mulai')
            ->get(['id_penjadwalan', 'waktu_mulai', 'waktu_selesai', 'jenis_bimbingan', 'status']);

        return view('portal_siswa.index', compact('siswa', 'pengajuan', 'jadwalTerisi', 'selectedDate'));
    }

    /**
     * Verifikasi identitas siswa via NIS (Nomor Induk Siswa).
     */
    public function login(Request $request)
    {
        $request->validate([
            'nis' => 'required|string',
        ], [
            'nis.required' => 'Nomor Induk Siswa (NIS) wajib diisi.',
        ]);

        $nisInput = trim($request->input('nis'));

        $siswa = Siswa::with(['kelas.waliKelas'])
            ->where('nis', $nisInput)
            ->where('status', 'Aktif')
            ->first();

        if (!$siswa) {
            return back()
                ->withInput()
                ->withErrors(['nis' => 'NIS tidak ditemukan atau status siswa tidak aktif di SMPN 2 Dramaga. Silakan hubungi Guru BK.']);
        }

        // Simpan sesi portal siswa
        session([
            'portal_siswa_id' => $siswa->id_siswa,
            'portal_siswa_nis' => $siswa->nis,
            'portal_siswa_nama' => $siswa->nama_siswa,
        ]);

        return redirect()
            ->route('portal.siswa.index')
            ->with('success', "Selamat datang di Portal Bimbingan Konseling, {$siswa->nama_siswa}!");
    }

    /**
     * Keluar dari sesi portal siswa.
     */
    public function logout(Request $request)
    {
        session()->forget(['portal_siswa_id', 'portal_siswa_nis', 'portal_siswa_nama']);

        return redirect()
            ->route('portal.siswa.index')
            ->with('info', 'Anda telah keluar dari sesi Portal Siswa.');
    }

    /**
     * Memproses formulir pengajuan konseling mandiri oleh siswa.
     */
    public function ajukan(Request $request)
    {
        $siswa = $this->resolveActiveSiswa();

        if (!$siswa) {
            return redirect()
                ->route('portal.siswa.index')
                ->with('error', 'Sesi siswa telah berakhir. Silakan masukkan NIS Anda kembali.');
        }

        $validated = $request->validate([
            'tanggal' => 'required|date|after_or_equal:today',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
            'jenis_bimbingan' => 'required|string|max:255',
            'catatan' => 'nullable|string|max:500',
        ], [
            'tanggal.required' => 'Tanggal bimbingan wajib diisi.',
            'tanggal.after_or_equal' => 'Tanggal bimbingan tidak boleh di masa lalu.',
            'waktu_mulai.required' => 'Waktu mulai bimbingan wajib diisi.',
            'waktu_selesai.required' => 'Waktu selesai bimbingan wajib diisi.',
            'waktu_selesai.after' => 'Waktu selesai harus lebih besar daripada waktu mulai.',
            'jenis_bimbingan.required' => 'Jenis layanan bimbingan wajib dipilih.',
        ]);

        // Validasi Anti-Bentrok Jadwal Guru BK dengan DB::transaction dan lockForUpdate
        $conflict = null;
        $pengajuan = DB::transaction(function () use ($validated, $siswa, &$conflict) {
            $conflict = Penjadwalan::findConflict(
                $validated['tanggal'],
                $validated['waktu_mulai'],
                $validated['waktu_selesai'],
                null,
                Penjadwalan::ACTIVE_STATUSES,
                true // lockForUpdate
            );

            if ($conflict) {
                return null;
            }

            return Penjadwalan::create([
                'id_siswa' => $siswa->id_siswa,
                'tanggal' => $validated['tanggal'],
                'waktu_mulai' => $validated['waktu_mulai'],
                'waktu_selesai' => $validated['waktu_selesai'],
                'jenis_bimbingan' => $validated['jenis_bimbingan'],
                'catatan' => $validated['catatan'] ?? null,
                'status' => 'Diajukan', // Status awal pengajuan siswa
            ]);
        });

        if (!$pengajuan && $conflict) {
            $waktu = substr($conflict->waktu_mulai, 0, 5) . ' - ' . substr($conflict->waktu_selesai, 0, 5);
            $errorMessage = "Waktu yang Anda pilih bentrok dengan jadwal konseling lain yang sudah aktif pada pukul {$waktu}. Silakan pilih jam atau tanggal lain.";

            return back()
                ->withInput()
                ->withErrors(['waktu_mulai' => $errorMessage])
                ->with('error', $errorMessage);
        }

        // Terbitkan notifikasi sistem untuk Wali Kelas dan Guru BK
        $namaKelas = $siswa->kelas->nama_kelas ?? '-';
        $tglFormatted = Carbon::parse($validated['tanggal'])->isoFormat('D MMMM Y');
        $waktu = $validated['waktu_mulai'] . ' - ' . $validated['waktu_selesai'];

        Notifikasi::create([
            'judul' => 'Pengajuan Konseling Baru dari Siswa',
            'pesan' => "Siswa {$siswa->nama_siswa} (Kelas {$namaKelas}) mengajukan bimbingan {$validated['jenis_bimbingan']} pada {$tglFormatted} pukul {$waktu}. Menunggu verifikasi dan izin dari Wali Kelas.",
            'tipe' => 'jadwal',
            'dibaca' => false,
            'id_konseling' => null,
        ]);

        return redirect()
            ->route('portal.siswa.index')
            ->with('success', 'Pengajuan bimbingan konseling berhasil dikirim! Pengajuan Anda akan diperiksa dan disetujui terlebih dahulu oleh Wali Kelas Anda sebelum ditetapkan jadwal resminya oleh Guru BK.');
    }

    /**
     * Menyelesaikan objek Siswa aktif dari sesi atau user login.
     */
    protected function resolveActiveSiswa(): ?Siswa
    {
        // 1. Cek sesi NIS mandiri
        $siswaId = session('portal_siswa_id');
        if ($siswaId) {
            return Siswa::with(['kelas.waliKelas'])->find($siswaId);
        }

        // 2. Cek jika login menggunakan akun user bertipe 'siswa'
        if (Auth::check() && Auth::user()->isSiswa()) {
            $siswa = Siswa::with(['kelas.waliKelas'])
                ->where('nis', Auth::user()->username)
                ->first();

            if ($siswa) {
                session([
                    'portal_siswa_id' => $siswa->id_siswa,
                    'portal_siswa_nis' => $siswa->nis,
                    'portal_siswa_nama' => $siswa->nama_siswa,
                ]);
                return $siswa;
            }
        }

        return null;
    }
}
