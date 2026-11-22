<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Penjadwalan;
use App\Models\JadwalMengajarBk;
use App\Models\SlotKonseling;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PortalSiswaController extends Controller
{
    /**
     * Nama kunci session & cookie terenkripsi untuk mengikat identitas siswa pada perangkat/browser
     * agar siswa tidak dapat mengintip pengajuan siswa lain hanya dengan mengganti nama atau kelas.
     */
    private const IDENTITY_LOCK_KEY = 'portal_siswa_locked_identity';

    /**
     * Mengambil identitas siswa yang sudah terikat pada sesi/perangkat saat ini (jika ada).
     */
    private function getLockedIdentity(Request $request): ?array
    {
        if (! $request->hasSession()) {
            return null;
        }

        $locked = $request->session()->get(self::IDENTITY_LOCK_KEY);

        if (!is_array($locked) && $request->hasCookie(self::IDENTITY_LOCK_KEY)) {
            $rawCookie = $request->cookie(self::IDENTITY_LOCK_KEY);
            $decoded = is_string($rawCookie) ? json_decode($rawCookie, true) : null;
            if (is_array($decoded) && isset($decoded['id_siswa'], $decoded['id_kelas'])) {
                $locked = [
                    'id_siswa' => (int) $decoded['id_siswa'],
                    'id_kelas' => (int) $decoded['id_kelas'],
                    'kode_pengajuan' => isset($decoded['kode_pengajuan']) ? (string) $decoded['kode_pengajuan'] : null,
                ];
                $request->session()->put(self::IDENTITY_LOCK_KEY, $locked);
            }
        }

        if (is_array($locked) && isset($locked['id_siswa'], $locked['id_kelas'])) {
            $exists = Siswa::where('id_siswa', (int) $locked['id_siswa'])
                ->where('id_kelas', (int) $locked['id_kelas'])
                ->exists();

            if ($exists) {
                return [
                    'id_siswa' => (int) $locked['id_siswa'],
                    'id_kelas' => (int) $locked['id_kelas'],
                    'kode_pengajuan' => isset($locked['kode_pengajuan']) ? (string) $locked['kode_pengajuan'] : null,
                ];
            }

            $request->session()->forget(self::IDENTITY_LOCK_KEY);
        }

        return null;
    }

    /**
     * Mengikat identitas siswa beserta kode permohonan izin pada sesi & cookie terenkripsi perangkat (berlaku 30 hari).
     */
    private function bindIdentity(Request $request, Siswa $siswa, ?string $kodePengajuan = null): array
    {
        $existing = $request->hasSession() ? $request->session()->get(self::IDENTITY_LOCK_KEY) : null;
        $resolvedKode = $kodePengajuan ?? (is_array($existing) && isset($existing['kode_pengajuan']) ? (string) $existing['kode_pengajuan'] : null);

        $payload = [
            'id_siswa' => (int) $siswa->id_siswa,
            'id_kelas' => (int) $siswa->id_kelas,
            'kode_pengajuan' => $resolvedKode,
        ];

        if ($request->hasSession()) {
            $request->session()->put(self::IDENTITY_LOCK_KEY, $payload);
        }
        Cookie::queue(Cookie::make(
            self::IDENTITY_LOCK_KEY,
            json_encode($payload),
            60 * 24 * 30,
            '/',
            null,
            false,
            true,
            false,
            'Lax'
        ));

        return $payload;
    }

    /**
     * Mencari data siswa aktif berdasarkan id_kelas dan id_siswa (atau nama_siswa).
     */
    private function resolveActiveSiswa(int $idKelas, $idSiswa = null, ?string $namaSiswa = null): ?Siswa
    {
        $siswa = null;

        if (!empty($idSiswa)) {
            $siswa = Siswa::with('kelas.waliKelas')
                ->where('status', 'Aktif')
                ->where('id_kelas', $idKelas)
                ->where('id_siswa', (int) $idSiswa)
                ->first();
        }

        if (!$siswa && !empty($namaSiswa)) {
            $namaInput = trim($namaSiswa);
            $siswa = Siswa::with('kelas.waliKelas')
                ->where('status', 'Aktif')
                ->where('id_kelas', $idKelas)
                ->whereRaw('LOWER(TRIM(nama_siswa)) = ?', [mb_strtolower($namaInput)])
                ->first();
        }

        return $siswa;
    }

    /**
     * 1. Halaman Beranda Portal Siswa (Pengenalan Layanan BK & Cek Slot Ketersediaan Konseling).
     */
    public function index(Request $request)
    {
        $rawDate = $request->input('tanggal_cek', $request->input('tanggal'));
        if ($rawDate) {
            try {
                if (preg_match('/^(\d{1,2})[\/\-](\d{1,2})[\/\-](\d{4})$/', $rawDate, $m)) {
                    $selectedDate = sprintf('%04d-%02d-%02d', $m[3], $m[2], $m[1]);
                } else {
                    $selectedDate = Carbon::parse($rawDate)->format('Y-m-d');
                }
            } catch (\Exception $e) {
                $selectedDate = Carbon::today()->format('Y-m-d');
            }
        } else {
            $selectedDate = Carbon::today()->format('Y-m-d');
        }

        $upcomingDates = SlotKonseling::where('tanggal', '>=', Carbon::today()->format('Y-m-d'))
            ->select('tanggal')
            ->distinct()
            ->pluck('tanggal')
            ->push($selectedDate)
            ->push(Carbon::today()->format('Y-m-d'))
            ->unique();

        foreach ($upcomingDates as $tgl) {
            SlotKonseling::syncSlotStatusesOnDate($tgl);
        }

        $slotDibuka = SlotKonseling::with('guruBk')
            ->where('tanggal', $selectedDate)
            ->orderBy('waktu_mulai')
            ->get();

        $slotTersediaMendatang = SlotKonseling::with('guruBk')
            ->where('tanggal', '>=', Carbon::today()->format('Y-m-d'))
            ->orderBy('tanggal')
            ->orderBy('waktu_mulai')
            ->get();

        return view('portal_siswa.index', compact('selectedDate', 'slotDibuka', 'slotTersediaMendatang'));
    }

    /**
     * 2. Halaman pengajuan izin Wali Kelas (Tahap 1, tanpa login).
     */
    public function create(Request $request)
    {
        return $this->renderApplicationPage($request, 'izin');
    }

    /** Halaman pengajuan jadwal konseling, dibuka hanya untuk izin yang telah disetujui. */
    public function schedule(Request $request)
    {
        return $this->renderApplicationPage($request, 'jadwal');
    }

    private function renderApplicationPage(Request $request, string $portalStep)
    {
        // Daftar seluruh kelas beserta informasi Wali Kelas untuk pilihan di formulir
        $kelasList = Kelas::with('waliKelas')->get();

        // Daftar nama siswa aktif per kelas yang tersimpan di database
        // Hanya mengambil kolom id_siswa, nama_siswa, dan id_kelas (tanpa data/catatan pribadi)
        $siswaPerKelas = Siswa::where('status', 'Aktif')
            ->orderBy('nama_siswa')
            ->get(['id_siswa', 'nama_siswa', 'id_kelas'])
            ->groupBy('id_kelas');

        // Cek ketersediaan slot jadwal Guru BK pada tanggal tertentu (tanpa mengekspos identitas siswa)
        $rawSelectedDate = $request->input('tanggal_cek', $request->input('tanggal'));
        if ($rawSelectedDate) {
            try {
                if (preg_match('/^(\d{1,2})[\/\-](\d{1,2})[\/\-](\d{4})$/', $rawSelectedDate, $m)) {
                    $selectedDate = sprintf('%04d-%02d-%02d', $m[3], $m[2], $m[1]);
                } else {
                    $selectedDate = Carbon::parse($rawSelectedDate)->format('Y-m-d');
                }
            } catch (\Exception $e) {
                $selectedDate = Carbon::today()->format('Y-m-d');
            }
        } else {
            $selectedDate = Carbon::today()->format('Y-m-d');
        }

        $upcomingDates = SlotKonseling::where('tanggal', '>=', Carbon::today()->format('Y-m-d'))
            ->select('tanggal')
            ->distinct()
            ->pluck('tanggal')
            ->push($selectedDate)
            ->unique();

        foreach ($upcomingDates as $tgl) {
            SlotKonseling::syncSlotStatusesOnDate($tgl);
        }

        $slotDibuka = SlotKonseling::where('tanggal', $selectedDate)
            ->orderBy('waktu_mulai')
            ->get();

        $slotTersediaMendatang = SlotKonseling::where('tanggal', '>=', Carbon::today()->format('Y-m-d'))
            ->orderBy('tanggal')
            ->orderBy('waktu_mulai')
            ->get();

        $jadwalTerisi = Penjadwalan::where('tanggal', $selectedDate)
            ->whereIn('status', Penjadwalan::ACTIVE_STATUSES)
            ->where(function ($q) {
                $q->where('waktu_mulai', '!=', '00:00:00')
                  ->orWhere('waktu_selesai', '!=', '00:00:00');
            })
            ->where(function ($q) {
                $q->whereNotNull('id_slot')
                  ->orWhereIn('status', ['Terjadwal', 'Selesai']);
            })
            ->orderBy('waktu_mulai')
            ->get(['waktu_mulai', 'waktu_selesai', 'status']);

        // Pre-select layanan jika siswa memilih dari kartu Layanan BK di Beranda
        $selectedLayanan = $request->input('layanan', '');

        // Tahap izin adalah formulir baru setiap kali dibuka. Ikatan sesi hanya
        // dipakai untuk tahap jadwal yang memerlukan izin yang sudah disetujui.
        $lockedIdentity = $portalStep === 'jadwal' ? $this->getLockedIdentity($request) : null;
        $lockedSiswa = null;
        $izinAktif = null;
        $kodePengajuanInput = strtoupper(trim((string) $request->input(
            'kode_pengajuan',
            $portalStep === 'jadwal' ? ($lockedIdentity['kode_pengajuan'] ?? '') : ''
        )));
        $izinRingkasan = null;
        $izinTerkirim = false;

        if ($portalStep === 'izin' && $request->boolean('konfirmasi_izin') && $kodePengajuanInput !== '') {
            // Konfirmasi dan kode selalu berasal dari record yang benar-benar tersimpan,
            // sehingga tetap terlihat setelah refresh tanpa mengisi kembali formulir.
            $izinTersimpan = Penjadwalan::with('siswa.kelas.waliKelas')
                ->where('kode_pengajuan', $kodePengajuanInput)
                ->first();

            if ($izinTersimpan && $izinTersimpan->siswa) {
                $izinTerkirim = true;
                $izinRingkasan = [
                    'kode_pengajuan' => $izinTersimpan->kode_pengajuan,
                    'nama_siswa' => $izinTersimpan->siswa->nama_siswa,
                    'kelas' => $izinTersimpan->siswa->kelas->nama_kelas ?? '-',
                    'wali_kelas' => $izinTersimpan->siswa->kelas->waliKelas->nama ?? 'Wali Kelas',
                    'tanggal' => Carbon::parse($izinTersimpan->tanggal)->isoFormat('dddd, D MMMM Y'),
                    'waktu' => substr($izinTersimpan->waktu_mulai, 0, 5) . ' - ' . substr($izinTersimpan->waktu_selesai, 0, 5) . ' WIB',
                    'layanan' => $izinTersimpan->jenis_bimbingan,
                    'status' => $izinTersimpan->status,
                ];
            }
        }

        if ($portalStep === 'jadwal' && $lockedIdentity) {
            $lockedSiswa = Siswa::with('kelas.waliKelas')->find($lockedIdentity['id_siswa'], ['id_siswa', 'nama_siswa', 'id_kelas']);
            if ($lockedSiswa) {
                $queryIzin = Penjadwalan::where('id_siswa', $lockedSiswa->id_siswa)
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
                        'catatan_wali',
                        'waktu_persetujuan_wali',
                        'created_at',
                    ]);

                if ($kodePengajuanInput !== '') {
                    $izinAktif = (clone $queryIzin)->where('kode_pengajuan', $kodePengajuanInput)->first();
                }

                if (!$izinAktif) {
                    $izinAktif = $queryIzin->orderByDesc('id_penjadwalan')->first();
                    if ($izinAktif && $kodePengajuanInput === '') {
                        $kodePengajuanInput = (string) $izinAktif->kode_pengajuan;
                    }
                }
            }
        } elseif ($portalStep === 'jadwal' && $kodePengajuanInput !== '' && $request->filled('id_kelas') && $request->filled('id_siswa')) {
            $izinCandidate = Penjadwalan::where('kode_pengajuan', $kodePengajuanInput)
                ->where('id_siswa', (int) $request->input('id_siswa'))
                ->whereHas('siswa', function ($q) use ($request) {
                    $q->where('id_kelas', (int) $request->input('id_kelas'));
                })
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
                    'catatan_wali',
                    'waktu_persetujuan_wali',
                    'created_at',
                ])
                ->first();

            if ($izinCandidate) {
                $siswaCandidate = Siswa::with('kelas.waliKelas')->find($izinCandidate->id_siswa, ['id_siswa', 'nama_siswa', 'id_kelas']);
                if ($siswaCandidate) {
                    $this->bindIdentity($request, $siswaCandidate, $izinCandidate->kode_pengajuan);
                    $lockedSiswa = $siswaCandidate;
                    $izinAktif = $izinCandidate;
                }
            }
        }

        if (
            $portalStep === 'jadwal' &&
            (!$lockedSiswa || !$izinAktif || $izinAktif->status !== 'Disetujui_Wali')
        ) {
            return redirect()
                ->route('portal.siswa.create')
                ->with('error', 'Halaman jadwal hanya dapat digunakan setelah izin Wali Kelas disetujui dan sebelum jadwal diajukan. Cek status pengajuan untuk melanjutkan.');
        }

        return response()
            ->view('portal_siswa.ajukan', compact(
                'kelasList',
                'siswaPerKelas',
                'jadwalTerisi',
                'slotDibuka',
                'slotTersediaMendatang',
                'selectedDate',
                'selectedLayanan',
                'lockedSiswa',
                'izinAktif',
                'kodePengajuanInput',
                'portalStep',
                'izinRingkasan',
                'izinTerkirim'
            ))
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache');
    }

    /**
     * TAHAP 1 (Langkah 3): Siswa mengajukan permohonan izin kepada Wali Kelas terlebih dahulu.
     * Belum memilih/mengunci slot jam konseling Guru BK dan belum mengirim catatan pribadi.
     */
    public function ajukanIzin(Request $request)
    {
        if ($request->filled('id_slot')) {
            $slotRef = SlotKonseling::find((int) $request->input('id_slot'));
            if ($slotRef) {
                $request->merge([
                    'tanggal' => $slotRef->tanggal,
                    'waktu_mulai' => substr($slotRef->waktu_mulai, 0, 5),
                    'waktu_selesai' => substr($slotRef->waktu_selesai, 0, 5),
                ]);
            }
        }

        $rules = [
            'id_kelas' => 'required|exists:kelas,id_kelas',
            'id_siswa' => 'nullable|exists:siswa,id_siswa',
            'nama_siswa' => 'nullable|string|min:2|max:100',
            'id_slot' => 'nullable|integer',
            'jenis_bimbingan' => 'required|string|max:255',
            'tanggal' => 'required|date|after_or_equal:today',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
            'jam_pelajaran' => 'nullable|string|max:100',
        ];

        // Mendukung fleksibilitas pengujian lama jika parameter waktu/tanggal belum dikirim
        if (!$request->has('tanggal')) {
            $rules['tanggal'] = 'nullable|date';
        }
        if (!$request->has('waktu_mulai')) {
            $rules['waktu_mulai'] = 'nullable|date_format:H:i';
        }
        if (!$request->has('waktu_selesai')) {
            $rules['waktu_selesai'] = 'nullable|date_format:H:i';
        }

        $validated = $request->validate($rules, [
            'id_kelas.required' => 'Kelas wajib dipilih.',
            'id_kelas.exists' => 'Kelas yang dipilih tidak valid.',
            'jenis_bimbingan.required' => 'Bidang layanan bimbingan wajib dipilih.',
            'tanggal.required' => 'Tanggal yang diinginkan wajib diisi.',
            'tanggal.after_or_equal' => 'Tanggal yang diinginkan tidak boleh di masa lalu.',
            'waktu_mulai.required' => 'Jam mulai pelajaran yang ingin ditinggalkan wajib diisi.',
            'waktu_selesai.required' => 'Jam selesai pelajaran yang ingin ditinggalkan wajib diisi.',
            'waktu_selesai.after' => 'Jam selesai harus lebih besar daripada jam mulai.',
        ]);

        $idKelas = (int) $validated['id_kelas'];
        $siswa = $this->resolveActiveSiswa($idKelas, $validated['id_siswa'] ?? null, $validated['nama_siswa'] ?? null);

        if (!$siswa) {
            return redirect()
                ->route('portal.siswa.create')
                ->withInput()
                ->withErrors(['id_siswa' => 'Silakan pilih kelas dan nama siswa aktif yang terdaftar di kelas tersebut.'])
                ->with('error', 'Data siswa tidak ditemukan pada kelas yang dipilih. Silakan pilih nama siswa dari daftar.');
        }

        // Periksa apakah siswa ini masih memiliki permohonan izin aktif
        // Pastikan siswa yang masih menunggu persetujuan tidak bisa mengajukan izin berulang kali
        $existingPendingPermission = Penjadwalan::where('id_siswa', $siswa->id_siswa)
            ->where('status', 'Diajukan')
            ->orderByDesc('id_penjadwalan')
            ->first();

        if ($existingPendingPermission) {
            return redirect()
                ->route('portal.siswa.create')
                ->withInput()
                ->withErrors(['id_siswa' => 'Siswa ini masih memiliki permohonan izin yang sedang menunggu persetujuan Wali Kelas (Kode Izin: ' . $existingPendingPermission->kode_pengajuan . ').'])
                ->with('error', 'Siswa yang dipilih masih memiliki permohonan izin aktif yang sedang menunggu persetujuan Wali Kelas (Kode Izin: ' . $existingPendingPermission->kode_pengajuan . '). Siswa tidak dapat mengajukan izin baru sebelum mendapat keputusan.');
        }

        $existingApprovedPermission = Penjadwalan::where('id_siswa', $siswa->id_siswa)
            ->where('status', 'Disetujui_Wali')
            ->orderByDesc('id_penjadwalan')
            ->first();

        if ($existingApprovedPermission) {
            return redirect()
                ->route('portal.siswa.create')
                ->withInput()
                ->withErrors(['id_siswa' => 'Siswa ini sudah memiliki permohonan izin aktif dengan Kode Izin ' . $existingApprovedPermission->kode_pengajuan . '. Gunakan kode tersebut pada halaman Cek Status atau lanjutkan jadwal.'])
                ->with('error', 'Siswa yang dipilih sudah memiliki permohonan izin aktif yang telah disetujui Wali Kelas. Silakan lanjutkan ke pengajuan jadwal konseling atau gunakan Kode Izin ' . $existingApprovedPermission->kode_pengajuan . ' untuk cek status.');
        }

        $jenisBimbingan = !empty($validated['jenis_bimbingan'])
            ? $validated['jenis_bimbingan']
            : 'Konseling Individu';

        $tanggalReq = !empty($validated['tanggal'])
            ? $validated['tanggal']
            : Carbon::today()->format('Y-m-d');

        $waktuMulaiReq = !empty($validated['waktu_mulai'])
            ? (strlen($validated['waktu_mulai']) === 5 ? $validated['waktu_mulai'] . ':00' : $validated['waktu_mulai'])
            : '08:00:00';

        $waktuSelesaiReq = !empty($validated['waktu_selesai'])
            ? (strlen($validated['waktu_selesai']) === 5 ? $validated['waktu_selesai'] . ':00' : $validated['waktu_selesai'])
            : '08:45:00';

        $catatanIzin = !empty($validated['jam_pelajaran']) ? $validated['jam_pelajaran'] : null;

        // Cari Wali Kelas dari kelas siswa untuk mengikat relasi langsung secara konsisten
        $siswa->loadMissing('kelas.waliKelas');
        $waliKelasUser = $siswa->kelas?->waliKelas
            ?? \App\Models\User::where('role', 'wali_kelas')->where('id_kelas', $siswa->id_kelas)->first();
        $idWali = $waliKelasUser ? $waliKelasUser->id_user : null;

        // Validasi pemilihan slot konseling yang dibuka Guru BK apabila slot/waktu dipilih
        $enforceSlotValidation = $request->filled('id_slot')
            || ($request->filled('tanggal') && $request->filled('waktu_mulai') && $request->filled('waktu_selesai') && $request->input('jam_pelajaran') !== 'Kustom');

        if ($enforceSlotValidation) {
            if (!SlotKonseling::isWithinOperationalHours($waktuMulaiReq, $waktuSelesaiReq)) {
                $msg = 'Slot konseling hanya tersedia dalam jam operasional layanan BK pukul 08:00 - 15:00 WIB.';
                return redirect()
                    ->route('portal.siswa.create')
                    ->withInput()
                    ->withErrors(['waktu_mulai' => $msg, 'id_slot' => $msg])
                    ->with('error', $msg);
            }
        }

        $slotErrorMessage = null;
        $duplicateActiveIzin = null;
        $izin = DB::transaction(function () use (
            $siswa,
            $validated,
            $jenisBimbingan,
            $tanggalReq,
            $waktuMulaiReq,
            $waktuSelesaiReq,
            $catatanIzin,
            $idWali,
            $enforceSlotValidation,
            &$slotErrorMessage,
            &$duplicateActiveIzin
        ) {
            $duplicateActiveIzin = Penjadwalan::where('id_siswa', $siswa->id_siswa)
                ->whereIn('status', ['Diajukan', 'Disetujui_Wali'])
                ->lockForUpdate()
                ->orderByDesc('id_penjadwalan')
                ->first();

            if ($duplicateActiveIzin) {
                return null;
            }

            $idSlot = null;
            $finalTanggal = $tanggalReq;
            $finalWaktuMulai = $waktuMulaiReq;
            $finalWaktuSelesai = $waktuSelesaiReq;

            if ($enforceSlotValidation) {
                SlotKonseling::syncSlotStatusesOnDate($tanggalReq);

                $teachingConflict = JadwalMengajarBk::findConflictOnDate(
                    $tanggalReq,
                    $waktuMulaiReq,
                    $waktuSelesaiReq,
                    true
                );

                if ($teachingConflict) {
                    $slotErrorMessage = JadwalMengajarBk::formatConflictMessage($teachingConflict);
                    return null;
                }

                $conflict = Penjadwalan::findConflict(
                    $tanggalReq,
                    $waktuMulaiReq,
                    $waktuSelesaiReq,
                    null,
                    Penjadwalan::ACTIVE_STATUSES,
                    true,
                    true
                );

                if ($conflict) {
                    $slotErrorMessage = 'Slot konseling pada jam tersebut sudah diajukan atau terjadwal untuk siswa lain. Silakan pilih slot lain yang tersedia.';
                    return null;
                }

                $lockedSlot = SlotKonseling::findMatchingSlot(
                    $tanggalReq,
                    $waktuMulaiReq,
                    $waktuSelesaiReq,
                    !empty($validated['id_slot']) ? (int) $validated['id_slot'] : null,
                    true
                );

                if (!$lockedSlot) {
                    $slotErrorMessage = 'Slot waktu yang Anda pilih belum dibuka oleh Guru BK. Siswa hanya dapat mengajukan izin dengan memilih slot konseling yang tersedia dari Guru BK.';
                    return null;
                }

                if ($lockedSlot->status_slot === SlotKonseling::STATUS_TIDAK_TERSEDIA) {
                    $slotErrorMessage = 'Slot konseling yang dipilih sedang berstatus Tidak Tersedia. Silakan pilih slot konseling lain yang tersedia.';
                    return null;
                }

                $slotUsedByOther = Penjadwalan::where('id_slot', $lockedSlot->id_slot)
                    ->whereIn('status', Penjadwalan::ACTIVE_STATUSES)
                    ->lockForUpdate()
                    ->exists();

                if ($slotUsedByOther || in_array($lockedSlot->status_slot, [SlotKonseling::STATUS_MENUNGGU, SlotKonseling::STATUS_DIPESAN], true)) {
                    $slotErrorMessage = 'Slot konseling ini sedang menunggu diproses atau sudah dipesan oleh siswa lain. Silakan pilih slot lain yang tersedia.';
                    return null;
                }

                // Tahap 1 hanya meminta izin wali kelas. Slot wajib masih tersedia
                // saat siswa mengajukan jadwal pada Tahap 2, jadi jangan mengikat
                // atau menahan slot di record permohonan izin.
                $idSlot = null;
                $finalTanggal = $lockedSlot->tanggal;
                $finalWaktuMulai = $lockedSlot->waktu_mulai;
                $finalWaktuSelesai = $lockedSlot->waktu_selesai;
            }

            $izin = $siswa->penjadwalan()->create([
                'kode_pengajuan' => Penjadwalan::generateKodePengajuan(),
                'id_slot' => $idSlot,
                'tanggal' => $finalTanggal,
                'waktu_mulai' => $finalWaktuMulai,
                'waktu_selesai' => $finalWaktuSelesai,
                'jenis_bimbingan' => $jenisBimbingan,
                'catatan' => $catatanIzin, // Menyimpan keterangan jam/periode pelajaran bila ada (tanpa catatan rahasia)
                'status' => 'Diajukan',
                'id_wali' => $idWali,
            ]);

            $namaKelas = $siswa->kelas->nama_kelas ?? '-';
            $tglFormatted = Carbon::parse($finalTanggal)->isoFormat('D MMMM Y');
            $jamRange = substr($finalWaktuMulai, 0, 5) . ' - ' . substr($finalWaktuSelesai, 0, 5) . ' WIB';

            Notifikasi::create([
                'judul' => 'Permohonan Izin Konseling Siswa — ' . $siswa->nama_siswa,
                'pesan' => "Siswa {$siswa->nama_siswa} (Kelas {$namaKelas}) mengajukan permohonan izin meninggalkan pelajaran pada {$tglFormatted} pukul {$jamRange} untuk mengikuti bimbingan konseling (Kode: {$izin->kode_pengajuan}). Menunggu persetujuan izin dari Wali Kelas.",
                'tipe' => 'jadwal',
                'dibaca' => false,
                'id_konseling' => null,
                'id_kelas' => $siswa->id_kelas,
                'id_user' => $idWali,
            ]);

            return $izin;
        });

        if (!$izin && $duplicateActiveIzin) {
            $errMsg = 'Siswa ini masih memiliki permohonan izin aktif (Kode Izin: ' . $duplicateActiveIzin->kode_pengajuan . ').';
            return redirect()
                ->route('portal.siswa.create')
                ->withInput()
                ->withErrors(['id_siswa' => $errMsg])
                ->with('error', $errMsg);
        }

        if (!$izin) {
            $errMsg = $slotErrorMessage ?: 'Slot konseling yang dipilih tidak tersedia. Silakan pilih slot konseling lain yang dibuka oleh Guru BK.';
            return redirect()
                ->route('portal.siswa.create')
                ->withInput()
                ->withErrors(['id_slot' => $errMsg, 'waktu_mulai' => $errMsg])
                ->with('error', $errMsg);
        }

        // Ikat sesi perangkat dengan siswa dan kode_pengajuan
        $this->bindIdentity($request, $siswa, $izin->kode_pengajuan);

        return redirect()
            ->route('portal.siswa.create', ['kode_pengajuan' => $izin->kode_pengajuan, 'konfirmasi_izin' => 1])
            ->with('success', 'Permohonan izin berhasil dikirim, menunggu persetujuan Wali Kelas')
            ->with('izin_berhasil', true);
    }

    /**
     * TAHAP 2: Siswa mengajukan jadwal konseling HANYA SETELAH izin Wali Kelas disetujui ('Disetujui_Wali')
     * dan HANYA pada slot ketersediaan konseling yang telah dibuka oleh Guru BK (08:00 - 15:00 WIB).
     * Persetujuan izin Wali Kelas tetap terpisah dari penetapan jadwal oleh Guru BK.
     */
    public function ajukan(Request $request)
    {
        // Apabila siswa memilih id_slot dari daftar slot yang dibuka Guru BK, sinkronkan tanggal & jamnya
        if ($request->filled('id_slot')) {
            $slotRef = SlotKonseling::find((int) $request->input('id_slot'));
            if ($slotRef) {
                $request->merge([
                    'tanggal' => $slotRef->tanggal,
                    'waktu_mulai' => substr($slotRef->waktu_mulai, 0, 5),
                    'waktu_selesai' => substr($slotRef->waktu_selesai, 0, 5),
                ]);
            }
        }

        $validated = $request->validate([
            'id_kelas' => 'required|exists:kelas,id_kelas',
            'id_siswa' => 'nullable|exists:siswa,id_siswa',
            'nama_siswa' => 'nullable|string|min:2|max:100',
            'kode_pengajuan' => 'nullable|string|max:30',
            'id_slot' => 'nullable|integer',
            'jenis_bimbingan' => 'required|string|max:255',
            'tanggal' => 'required|date|after_or_equal:today',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
            'catatan' => 'nullable|string|max:500',
        ], [
            'id_kelas.required' => 'Kelas wajib dipilih.',
            'id_kelas.exists' => 'Kelas yang dipilih tidak valid.',
            'jenis_bimbingan.required' => 'Keperluan / jenis layanan konseling wajib dipilih.',
            'tanggal.required' => 'Tanggal bimbingan wajib diisi.',
            'tanggal.after_or_equal' => 'Tanggal bimbingan tidak boleh di masa lalu.',
            'waktu_mulai.required' => 'Slot waktu mulai bimbingan wajib dipilih.',
            'waktu_selesai.required' => 'Slot waktu selesai bimbingan wajib dipilih.',
            'waktu_selesai.after' => 'Waktu selesai harus lebih besar daripada waktu mulai.',
        ]);

        $idKelas = (int) $validated['id_kelas'];
        $siswa = $this->resolveActiveSiswa($idKelas, $validated['id_siswa'] ?? null, $validated['nama_siswa'] ?? null);

        if (!$siswa) {
            return redirect()
                ->route('portal.siswa.create')
                ->withInput()
                ->withErrors(['id_siswa' => 'Silakan pilih kelas dan nama siswa yang terdaftar di kelas tersebut.'])
                ->with('error', 'Data siswa tidak ditemukan pada kelas yang dipilih. Silakan pilih nama siswa dari daftar.');
        }

        $lockedIdentity = $this->getLockedIdentity($request);

        // Cegah perubahan lintas siswa apabila sesi perangkat sudah terikat pada siswa lain
        if (
            $lockedIdentity &&
            ($lockedIdentity['id_siswa'] !== (int) $siswa->id_siswa || $lockedIdentity['id_kelas'] !== (int) $siswa->id_kelas)
        ) {
            return redirect()
                ->route('portal.siswa.create')
                ->withInput()
                ->withErrors(['id_siswa' => 'Sesi perangkat ini telah terikat pada siswa lain. Anda tidak dapat mengajukan jadwal atas nama siswa lain.'])
                ->with('error', 'Akses Dibatasi: Sesi perangkat ini telah terhubung dengan identitas siswa lain.');
        }

        // Identifikasi permohonan izin: wajib menggunakan kode_pengajuan (dari input atau dari sesi perangkat yang sudah terikat pada siswa tersebut)
        $kodePengajuan = strtoupper(trim((string) ($validated['kode_pengajuan'] ?? '')));
        if ($kodePengajuan === '' && $lockedIdentity && $lockedIdentity['id_siswa'] === (int) $siswa->id_siswa && !empty($lockedIdentity['kode_pengajuan'])) {
            $kodePengajuan = strtoupper(trim($lockedIdentity['kode_pengajuan']));
        }

        if ($kodePengajuan === '') {
            // Cek apakah siswa memiliki permohonan izin yang masih menunggu / ditolak untuk memberikan pesan yang spesifik
            $latestPermission = Penjadwalan::where('id_siswa', $siswa->id_siswa)
                ->orderByDesc('id_penjadwalan')
                ->first();

            if (!$latestPermission) {
                $msg = 'Anda belum mengajukan permohonan izin kepada Wali Kelas. Silakan ajukan permohonan izin terlebih dahulu pada Tahap 1.';
                return redirect()
                    ->route('portal.siswa.create')
                    ->withInput()
                    ->withErrors(['kode_pengajuan' => $msg, 'izin_wali' => $msg])
                    ->with('error', $msg);
            }

            if ($latestPermission->status === 'Diajukan') {
                $msg = 'Permohonan izin Anda masih menunggu persetujuan Wali Kelas. Siswa yang izinnya masih menunggu tidak dapat melanjutkan pengajuan jadwal konseling.';
                return redirect()
                    ->route('portal.siswa.create')
                    ->withInput()
                    ->withErrors(['kode_pengajuan' => $msg, 'izin_wali' => $msg])
                    ->with('error', $msg);
            }

            if ($latestPermission->status === 'Ditolak_Wali') {
                $msg = 'Permohonan izin Anda ditolak oleh Wali Kelas. Siswa yang izinnya ditolak tidak dapat melanjutkan pengajuan jadwal konseling.';
                return redirect()
                    ->route('portal.siswa.create')
                    ->withInput()
                    ->withErrors(['kode_pengajuan' => $msg, 'izin_wali' => $msg])
                    ->with('error', $msg);
            }

            $msg = 'Kode Izin (Kode Pengajuan) wajib diisi untuk memverifikasi bahwa permohonan izin adalah milik Anda. Pemilihan nama saja tidak cukup.';
            return redirect()
                ->route('portal.siswa.create')
                ->withInput()
                ->withErrors(['kode_pengajuan' => $msg])
                ->with('error', $msg);
        }

        // Cari permohonan izin berdasarkan id_siswa dan kode_pengajuan
        $izin = Penjadwalan::where('id_siswa', $siswa->id_siswa)
            ->where('kode_pengajuan', $kodePengajuan)
            ->first();

        if (!$izin) {
            $msg = 'Kode Izin tidak valid atau tidak sesuai dengan nama siswa yang dipilih. Pastikan Anda telah mengajukan izin ke Wali Kelas dan memasukkan Kode Izin yang benar.';
            return redirect()
                ->route('portal.siswa.create')
                ->withInput()
                ->withErrors(['kode_pengajuan' => $msg, 'izin_wali' => $msg])
                ->with('error', $msg);
        }

        // Pastikan status permohonan izin sudah Disetujui_Wali
        if ($izin->status === 'Diajukan') {
            $msg = 'Permohonan izin Anda (Kode: ' . $izin->kode_pengajuan . ') masih menunggu persetujuan Wali Kelas. Anda baru dapat mengajukan jadwal konseling setelah izin disetujui Wali Kelas.';
            return redirect()
                ->route('portal.siswa.create', ['kode_pengajuan' => $izin->kode_pengajuan])
                ->withInput()
                ->withErrors(['izin_wali' => $msg])
                ->with('error', $msg);
        }

        if ($izin->status === 'Ditolak_Wali') {
            $msg = 'Permohonan izin Anda (Kode: ' . $izin->kode_pengajuan . ') telah ditolak oleh Wali Kelas. Anda tidak dapat melanjutkan pengajuan jadwal konseling.';
            return redirect()
                ->route('portal.siswa.create', ['kode_pengajuan' => $izin->kode_pengajuan])
                ->withInput()
                ->withErrors(['izin_wali' => $msg])
                ->with('error', $msg);
        }

        if ($izin->status !== 'Disetujui_Wali') {
            $msg = 'Permohonan izin ini sudah berstatus "' . str_replace('_', ' ', $izin->status) . '" dan tidak dapat diubah kembali.';
            return redirect()
                ->route('portal.siswa.create', ['kode_pengajuan' => $izin->kode_pengajuan])
                ->withInput()
                ->withErrors(['izin_wali' => $msg])
                ->with('error', $msg);
        }

        if ($izin->hasSubmittedSchedule()) {
            $msg = 'Jadwal konseling untuk Kode Izin ' . $izin->kode_pengajuan . ' sudah diajukan sebelumnya dan sedang menunggu penetapan jadwal dari Guru BK.';
            return redirect()
                ->route('portal.siswa.jadwal', ['id_kelas' => $siswa->id_kelas, 'id_siswa' => $siswa->id_siswa, 'kode_pengajuan' => $izin->kode_pengajuan])
                ->withInput()
                ->withErrors(['izin_wali' => $msg])
                ->with('error', $msg);
        }

        // Validasi Jam Operasional 08:00 - 15:00 WIB
        if (!SlotKonseling::isWithinOperationalHours($validated['waktu_mulai'], $validated['waktu_selesai'])) {
            $msg = 'Slot konseling hanya tersedia dalam jam operasional layanan BK pukul 08:00 - 15:00 WIB.';
            return redirect()
                ->route('portal.siswa.jadwal', ['id_kelas' => $siswa->id_kelas, 'id_siswa' => $siswa->id_siswa, 'kode_pengajuan' => $izin->kode_pengajuan, 'tanggal_cek' => $validated['tanggal']])
                ->withInput()
                ->withErrors(['waktu_mulai' => $msg, 'id_slot' => $msg])
                ->with('error', $msg);
        }

        // Ikat sesi/perangkat ke siswa dan kode_pengajuan yang terverifikasi
        $this->bindIdentity($request, $siswa, $izin->kode_pengajuan);

        // Validasi Ketersediaan Slot Guru BK, Jadwal Mengajar, & Perlindungan Pemesanan Ganda (Double-Booking Protection)
        $conflict = null;
        $slotErrorMessage = null;
        $alreadySubmitted = false;

        $pengajuan = DB::transaction(function () use ($validated, $izin, &$conflict, &$slotErrorMessage, &$alreadySubmitted) {
            $lockedIzin = Penjadwalan::where('id_penjadwalan', $izin->id_penjadwalan)
                ->lockForUpdate()
                ->first();

            if (!$lockedIzin || $lockedIzin->status !== 'Disetujui_Wali' || $lockedIzin->hasSubmittedSchedule()) {
                $alreadySubmitted = true;
                return null;
            }

            // 1. Cek bentrok dengan Jadwal Mengajar Guru BK
            $teachingConflict = JadwalMengajarBk::findConflictOnDate(
                $validated['tanggal'],
                $validated['waktu_mulai'],
                $validated['waktu_selesai'],
                true
            );

            if ($teachingConflict) {
                $slotErrorMessage = JadwalMengajarBk::formatConflictMessage($teachingConflict);
                return null;
            }

            // 2. Cek bentrok dengan Jadwal / Permohonan Siswa lain yang sedang diproses atau sudah terjadwal
            $conflict = Penjadwalan::findConflict(
                $validated['tanggal'],
                $validated['waktu_mulai'],
                $validated['waktu_selesai'],
                $lockedIzin->id_penjadwalan,
                Penjadwalan::ACTIVE_STATUSES,
                true, // lockForUpdate
                true  // onlySubmittedSchedules
            );

            if ($conflict) {
                return null;
            }

            // Sinkronisasi status slot pada tanggal terkait sebelum mengunci slot
            SlotKonseling::syncSlotStatusesOnDate($validated['tanggal']);

            // 3. Pastikan slot telah dibuka oleh Guru BK dan berstatus Tersedia
            $lockedSlot = SlotKonseling::findMatchingSlot(
                $validated['tanggal'],
                $validated['waktu_mulai'],
                $validated['waktu_selesai'],
                !empty($validated['id_slot']) ? (int) $validated['id_slot'] : null,
                true
            );

            if (!$lockedSlot) {
                $slotErrorMessage = 'Slot waktu yang Anda pilih belum dibuka oleh Guru BK. Siswa hanya dapat memilih slot ketersediaan konseling yang telah dibuka oleh Guru BK.';
                return null;
            }

            if ($lockedSlot->status_slot === SlotKonseling::STATUS_TIDAK_TERSEDIA) {
                $slotErrorMessage = 'Slot konseling yang dipilih sedang berstatus Tidak Tersedia. Silakan pilih slot lain yang tersedia.';
                return null;
            }

            $slotUsedByOther = Penjadwalan::where('id_slot', $lockedSlot->id_slot)
                ->where('id_penjadwalan', '!=', $lockedIzin->id_penjadwalan)
                ->whereIn('status', Penjadwalan::ACTIVE_STATUSES)
                ->lockForUpdate()
                ->exists();

            if ($slotUsedByOther || in_array($lockedSlot->status_slot, [SlotKonseling::STATUS_MENUNGGU, SlotKonseling::STATUS_DIPESAN], true)) {
                $slotErrorMessage = 'Slot konseling ini sedang menunggu diproses atau sudah dipesan oleh siswa lain. Silakan pilih slot lain yang tersedia.';
                return null;
            }

            // Kunci slot menjadi Menunggu_Diproses agar terlindung dari pemesanan ganda (double booking)
            $lockedSlot->update([
                'status_slot' => SlotKonseling::STATUS_MENUNGGU,
            ]);

            $oldTanggal = $lockedIzin->tanggal;

            // Status Penjadwalan TETAP 'Disetujui_Wali' karena persetujuan Wali Kelas terpisah dari pemrosesan jadwal oleh Guru BK.
            // Guru BK yang akan memprosesnya menjadi 'Terjadwal'.
            $lockedIzin->update([
                'id_slot' => $lockedSlot->id_slot,
                'tanggal' => $lockedSlot->tanggal,
                'waktu_mulai' => $lockedSlot->waktu_mulai,
                'waktu_selesai' => $lockedSlot->waktu_selesai,
                'jenis_bimbingan' => $validated['jenis_bimbingan'],
                'catatan' => $validated['catatan'] ?? null,
                'status' => 'Disetujui_Wali',
            ]);

            SlotKonseling::syncSlotStatusesOnDate($lockedSlot->tanggal);
            if ($oldTanggal && $oldTanggal !== $lockedSlot->tanggal) {
                SlotKonseling::syncSlotStatusesOnDate($oldTanggal);
            }

            return $lockedIzin;
        });

        if ($alreadySubmitted) {
            $msg = 'Jadwal konseling untuk permohonan izin ini sudah diproses dan tidak dapat dikirim ulang.';
            return redirect()
                ->route('portal.siswa.jadwal', ['id_kelas' => $siswa->id_kelas, 'id_siswa' => $siswa->id_siswa, 'kode_pengajuan' => $izin->kode_pengajuan])
                ->withInput()
                ->withErrors(['izin_wali' => $msg])
                ->with('error', $msg);
        }

        if (!$pengajuan && $conflict) {
            $waktu = substr($conflict->waktu_mulai, 0, 5) . ' - ' . substr($conflict->waktu_selesai, 0, 5);
            $errorMessage = "Waktu yang Anda pilih bentrok dengan permohonan atau jadwal konseling lain yang sedang diproses/aktif pada pukul {$waktu}. Silakan pilih slot lain.";

            return redirect()
                ->route('portal.siswa.jadwal', ['id_kelas' => $siswa->id_kelas, 'id_siswa' => $siswa->id_siswa, 'kode_pengajuan' => $izin->kode_pengajuan, 'tanggal_cek' => $validated['tanggal']])
                ->withInput()
                ->withErrors(['waktu_mulai' => $errorMessage, 'id_slot' => $errorMessage])
                ->with('error', $errorMessage);
        }

        if (!$pengajuan && $slotErrorMessage) {
            return redirect()
                ->route('portal.siswa.jadwal', ['id_kelas' => $siswa->id_kelas, 'id_siswa' => $siswa->id_siswa, 'kode_pengajuan' => $izin->kode_pengajuan, 'tanggal_cek' => $validated['tanggal']])
                ->withInput()
                ->withErrors(['waktu_mulai' => $slotErrorMessage, 'id_slot' => $slotErrorMessage])
                ->with('error', $slotErrorMessage);
        }

        // Terbitkan notifikasi sistem untuk Guru BK bahwa siswa (yang sudah mendapat izin Wali Kelas) telah mengajukan jadwal konseling
        $namaKelas = $siswa->kelas->nama_kelas ?? '-';
        $tglFormatted = Carbon::parse($validated['tanggal'])->isoFormat('D MMMM Y');
        $waktu = $validated['waktu_mulai'] . ' - ' . $validated['waktu_selesai'];

        Notifikasi::create([
            'judul' => 'Pengajuan Jadwal Konseling Baru — ' . $siswa->nama_siswa,
            'pesan' => "Siswa {$siswa->nama_siswa} (Kelas {$namaKelas}, Kode Izin: {$pengajuan->kode_pengajuan}) yang telah disetujui izinnya oleh Wali Kelas mengajukan jadwal {$validated['jenis_bimbingan']} pada {$tglFormatted} pukul {$waktu}. Menunggu penetapan jadwal oleh Guru BK.",
            'tipe' => 'jadwal',
            'dibaca' => false,
            'id_konseling' => null,
        ]);

        return redirect()
            ->route('portal.siswa.jadwal', ['id_kelas' => $siswa->id_kelas, 'id_siswa' => $siswa->id_siswa, 'kode_pengajuan' => $pengajuan->kode_pengajuan])
            ->with('pengajuan_berhasil', true)
            ->with('pengajuan_ringkasan', [
                'kode_pengajuan' => $pengajuan->kode_pengajuan,
                'nama_siswa' => $siswa->nama_siswa,
                'kelas' => $namaKelas,
                'tanggal' => $tglFormatted,
                'waktu' => $waktu . ' WIB',
            ])
            ->with('success', 'Pengajuan jadwal konseling berhasil dikirim! Izin Wali Kelas telah terpenuhi dan jadwalmu kini menunggu konfirmasi Guru BK.');
    }

    /**
     * 3. Halaman Khusus Cek Status Pengajuan Konseling (Tanpa Login).
     *    - Siswa memilih Kelas, Nama Siswa, dan diverifikasi dengan Kode Izin (kode_pengajuan) atau sesi perangkat yang sudah terikat.
     *    - Pemilihan nama saja tanpa Kode Izin atau sesi terikat TIDAK cukup untuk membuka status siswa lain.
     *    - Menampilkan hanya Kode Izin, Tanggal Pengajuan/Jadwal, Waktu Jadwal, dan Status Pengajuan.
     *    - Tidak menampilkan alasan/catatan pribadi konseling atau hasil/riwayat konseling.
     */
    public function status(Request $request)
    {
        $kelasList = Kelas::get(['id_kelas', 'nama_kelas', 'tingkat']);

        $siswaPerKelas = Siswa::where('status', 'Aktif')
            ->orderBy('nama_siswa')
            ->get(['id_siswa', 'nama_siswa', 'id_kelas'])
            ->groupBy('id_kelas');

        $lockedIdentity = $this->getLockedIdentity($request);
        $lockedSiswa = null;
        if ($lockedIdentity) {
            $lockedSiswa = Siswa::with('kelas:id_kelas,nama_kelas,tingkat')
                ->find($lockedIdentity['id_siswa'], ['id_siswa', 'nama_siswa', 'id_kelas']);
        }

        $selectedKelasId = $request->input('id_kelas');
        $selectedSiswaId = $request->input('id_siswa');
        $namaSiswaInput = trim((string) $request->input('nama_siswa', ''));
        $kodePengajuanInput = strtoupper(trim((string) $request->input('kode_pengajuan', $lockedIdentity['kode_pengajuan'] ?? '')));

        $pencarianDilakukan = $request->filled('id_kelas') && ($request->filled('id_siswa') || $namaSiswaInput !== '');
        $aksesDitolak = false;
        $pesanAksesDitolak = null;
        $siswaTerpilih = null;
        $daftarPengajuan = collect();

        // Dukungan melacak pengajuan langsung menggunakan Kode Izin (kode_pengajuan)
        if (!$pencarianDilakukan && $kodePengajuanInput !== '') {
            $recordByKode = Penjadwalan::with('siswa.kelas:id_kelas,nama_kelas,tingkat')
                ->where('kode_pengajuan', $kodePengajuanInput)
                ->first();

            if ($recordByKode && $recordByKode->siswa) {
                if (
                    $lockedIdentity &&
                    ($lockedIdentity['id_siswa'] !== (int) $recordByKode->siswa->id_siswa || $lockedIdentity['id_kelas'] !== (int) $recordByKode->siswa->id_kelas)
                ) {
                    $aksesDitolak = true;
                    $pesanAksesDitolak = 'Akses Dibatasi: Sesi perangkat ini telah terhubung dengan data siswa "' . ($lockedSiswa->nama_siswa ?? 'Anda') . '" (Kelas ' . ($lockedSiswa->kelas->nama_kelas ?? '-') . '). Anda tidak dapat melihat pengajuan milik siswa lain dengan Kode Izin siswa lain.';
                } else {
                    if (!$lockedIdentity) {
                        $lockedIdentity = $this->bindIdentity($request, $recordByKode->siswa, $recordByKode->kode_pengajuan);
                        $lockedSiswa = $recordByKode->siswa;
                    }
                    $siswaTerpilih = $recordByKode->siswa;
                    $selectedKelasId = $recordByKode->siswa->id_kelas;
                    $selectedSiswaId = $recordByKode->siswa->id_siswa;
                    $pencarianDilakukan = true;
                    $daftarPengajuan = Penjadwalan::where('id_siswa', $siswaTerpilih->id_siswa)
                        ->orderByRaw('CASE WHEN kode_pengajuan = ? THEN 0 ELSE 1 END', [$recordByKode->kode_pengajuan])
                        ->orderByDesc('id_penjadwalan')
                        ->get([
                            'id_penjadwalan',
                            'kode_pengajuan',
                            'id_siswa',
                            'id_slot',
                            'tanggal',
                            'waktu_mulai',
                            'waktu_selesai',
                            'status',
                            'catatan_wali',
                            'waktu_persetujuan_wali',
                            'created_at',
                            'updated_at',
                        ]);
                }
            } else {
                $pencarianDilakukan = true;
                $siswaTerpilih = null;
            }
        } elseif ($pencarianDilakukan) {
            $idKelasCari = (int) $selectedKelasId;

            if ($request->filled('id_siswa')) {
                $siswaCari = Siswa::with('kelas:id_kelas,nama_kelas,tingkat')
                    ->where('id_kelas', $idKelasCari)
                    ->where('id_siswa', (int) $selectedSiswaId)
                    ->first(['id_siswa', 'nama_siswa', 'id_kelas']);
            } else {
                $siswaCari = Siswa::with('kelas:id_kelas,nama_kelas,tingkat')
                    ->where('id_kelas', $idKelasCari)
                    ->whereRaw('LOWER(TRIM(nama_siswa)) = ?', [mb_strtolower($namaSiswaInput)])
                    ->first(['id_siswa', 'nama_siswa', 'id_kelas']);
            }

            if ($siswaCari) {
                // 1. Jika sesi perangkat sudah terikat pada seorang siswa, tolak percobaan mengganti nama/kelas ke siswa lain
                if (
                    $lockedIdentity &&
                    ($lockedIdentity['id_siswa'] !== (int) $siswaCari->id_siswa || $lockedIdentity['id_kelas'] !== (int) $siswaCari->id_kelas)
                ) {
                    $aksesDitolak = true;
                    $pesanAksesDitolak = 'Akses Dibatasi: Demi menjaga privasi antar-siswa, sesi perangkat ini telah terhubung dengan data siswa "' . ($lockedSiswa->nama_siswa ?? 'Anda') . '" (Kelas ' . ($lockedSiswa->kelas->nama_kelas ?? '-') . '). Anda tidak dapat melihat pengajuan milik siswa lain dengan mengganti nama atau kelas.';
                } else {
                    // 2. Verifikasi kepemilikan permohonan:
                    // Pemilihan nama saja TIDAK cukup aman apabila sesi belum terikat pada siswa tersebut.
                    // Wajib memiliki sesi yang sudah terikat ke siswa ini ATAU menyertakan kode_pengajuan yang cocok.
                    $isBoundToThisStudent = $lockedIdentity && $lockedIdentity['id_siswa'] === (int) $siswaCari->id_siswa;
                    $validKodeRecord = null;

                    if ($kodePengajuanInput !== '') {
                        $validKodeRecord = Penjadwalan::where('id_siswa', $siswaCari->id_siswa)
                            ->where('kode_pengajuan', $kodePengajuanInput)
                            ->first(['id_penjadwalan', 'kode_pengajuan', 'id_siswa']);
                    }

                    if ($request->filled('kode_pengajuan') && !$validKodeRecord) {
                        $aksesDitolak = true;
                        $pesanAksesDitolak = 'Verifikasi Gagal: Kode Izin yang dimasukkan tidak sesuai dengan data siswa yang dipilih. Pastikan Kode Izin benar.';
                    } elseif (!$isBoundToThisStudent && !$validKodeRecord) {
                        $aksesDitolak = true;
                        $pesanAksesDitolak = 'Verifikasi Diperlukan: Pemilihan nama siswa saja tidak cukup untuk membuka status permohonan. Silakan masukkan Kode Izin (contoh: BK-XXXXXX) yang diperoleh saat mengajukan izin kepada Wali Kelas.';
                    } else {
                        if (!$lockedIdentity && $validKodeRecord) {
                            $lockedIdentity = $this->bindIdentity($request, $siswaCari, $validKodeRecord->kode_pengajuan);
                            $lockedSiswa = $siswaCari;
                        }

                        $siswaTerpilih = $siswaCari;
                        $selectedKelasId = $siswaCari->id_kelas;
                        $selectedSiswaId = $siswaCari->id_siswa;

                        // Ambil HANYA kolom non-rahasia (TIDAK mengambil catatan pribadi siswa maupun riwayat konseling)
                        $queryPengajuan = Penjadwalan::where('id_siswa', $siswaTerpilih->id_siswa);
                        if ($validKodeRecord) {
                            $queryPengajuan->orderByRaw('CASE WHEN kode_pengajuan = ? THEN 0 ELSE 1 END', [$validKodeRecord->kode_pengajuan]);
                        }

                        $daftarPengajuan = $queryPengajuan
                            ->orderByDesc('id_penjadwalan')
                            ->get([
                                'id_penjadwalan',
                                'kode_pengajuan',
                                'id_siswa',
                                'id_slot',
                                'tanggal',
                                'waktu_mulai',
                                'waktu_selesai',
                                'status',
                                'catatan_wali',
                                'waktu_persetujuan_wali',
                                'created_at',
                                'updated_at',
                            ]);
                    }
                }
            }
        } elseif ($lockedSiswa) {
            // Jika siswa baru saja mengajukan izin/jadwal atau membuka kembali halaman Cek Status di perangkat yang sama,
            // langsung tampilkan daftar pengajuan miliknya sendiri secara otomatis.
            $pencarianDilakukan = true;
            $siswaTerpilih = $lockedSiswa;
            $selectedKelasId = $lockedSiswa->id_kelas;
            $selectedSiswaId = $lockedSiswa->id_siswa;

            $daftarPengajuan = Penjadwalan::where('id_siswa', $siswaTerpilih->id_siswa)
                ->orderByDesc('id_penjadwalan')
                ->get([
                    'id_penjadwalan',
                    'kode_pengajuan',
                    'id_siswa',
                    'id_slot',
                    'tanggal',
                    'waktu_mulai',
                    'waktu_selesai',
                    'status',
                    'catatan_wali',
                    'waktu_persetujuan_wali',
                    'created_at',
                    'updated_at',
                ]);
        }

        // Respon JSON untuk pembaruan status otomatis tanpa refresh (polling)
        if ($request->ajax() || $request->wantsJson() || $request->boolean('poll')) {
            return response()->json([
                'success' => true,
                'found' => $daftarPengajuan->count() > 0,
                'items' => $daftarPengajuan->map(function ($item) use ($siswaTerpilih) {
                    $sudahJadwal = $item->hasSubmittedSchedule();
                    return [
                        'id_penjadwalan' => $item->id_penjadwalan,
                        'kode_pengajuan' => $item->kode_pengajuan,
                        'status' => $item->status,
                        'status_label' => match($item->status) {
                            'Diajukan' => 'Menunggu Persetujuan Wali Kelas',
                            'Disetujui_Wali' => $sudahJadwal ? 'Izin Diterima (Menunggu Jadwal BK)' : 'Izin Diterima (Siap Ajukan Jadwal)',
                            'Ditolak_Wali' => 'Izin Ditolak',
                            'Terjadwal' => 'Terjadwal Resmi oleh Guru BK',
                            'Selesai' => 'Selesai Dilaksanakan',
                            'Dibatalkan' => 'Jadwal Dibatalkan',
                            default => str_replace('_', ' ', $item->status),
                        },
                        'badge_class' => match($item->status) {
                            'Diajukan' => 'status-Diajukan',
                            'Disetujui_Wali' => 'status-Disetujui_Wali',
                            'Ditolak_Wali' => 'status-Ditolak_Wali',
                            'Terjadwal' => 'status-Terjadwal',
                            'Selesai' => 'status-Selesai',
                            'Dibatalkan' => 'status-Dibatalkan',
                            default => '',
                        },
                        'has_submitted_schedule' => $sudahJadwal,
                        'catatan_wali' => $item->catatan_wali,
                        'waktu_persetujuan_wali' => $item->waktu_persetujuan_wali ? Carbon::parse($item->waktu_persetujuan_wali)->isoFormat('D MMMM Y, HH:mm') . ' WIB' : null,
                        'can_continue_schedule' => $item->status === 'Disetujui_Wali' && !$sudahJadwal,
                        'schedule_url' => ($item->status === 'Disetujui_Wali' && !$sudahJadwal && $siswaTerpilih)
                            ? route('portal.siswa.jadwal', ['id_kelas' => $siswaTerpilih->id_kelas, 'id_siswa' => $siswaTerpilih->id_siswa, 'kode_pengajuan' => $item->kode_pengajuan])
                            : null,
                    ];
                }),
            ])->header('Cache-Control', 'no-store, no-cache, must-revalidate');
        }

        return response()
            ->view('portal_siswa.status', compact(
                'kelasList',
                'siswaPerKelas',
                'selectedKelasId',
                'selectedSiswaId',
                'kodePengajuanInput',
                'pencarianDilakukan',
                'siswaTerpilih',
                'daftarPengajuan',
                'lockedSiswa',
                'aksesDitolak',
                'pesanAksesDitolak'
            ))
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache');
    }

    /**
     * Endpoint ringan untuk menyegarkan token CSRF aktif pada sesi saat ini
     * apabila pengguna berpindah tab (misal setelah login/logout staf di tab lain).
     */
    public function csrfToken(Request $request)
    {
        return response()
            ->json(['token' => csrf_token()])
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache');
    }

    /**
     * 4. Halaman Khusus Tentang SIRASI-BK & Layanan BK SMP Negeri 2 Dramaga.
     */
    public function tentang()
    {
        return view('portal_siswa.tentang');
    }

    /**
     * Fallback kompatibilitas rute lama.
     */
    public function login(Request $request)
    {
        return redirect()->route('portal.siswa.index');
    }

    /**
     * Fallback kompatibilitas rute lama.
     */
    public function logout(Request $request)
    {
        return redirect()->route('portal.siswa.index');
    }
}
