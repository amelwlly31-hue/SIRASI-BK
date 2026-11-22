<?php

namespace App\Http\Controllers;

use App\Models\JadwalMengajarBk;
use App\Models\Kelas;
use App\Models\Penjadwalan;
use App\Models\Siswa;
use App\Models\SlotKonseling;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenjadwalanController extends Controller
{
    public function index(Request $request)
    {
        $query = Penjadwalan::with(['siswa.kelas', 'waliKelas', 'slotKonseling']);

        $siswa = Siswa::with('kelas')
            ->where('status', 'Aktif')
            ->orderBy('nama_siswa')
            ->get();

        $kelasList = Kelas::orderBy('id_kelas')->get();

        // Search jadwal bimbingan siswa
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('jenis_bimbingan', 'like', '%' . $search . '%')
                    ->orWhere('catatan', 'like', '%' . $search . '%')
                    ->orWhere('status', 'like', '%' . $search . '%')
                    ->orWhere('kode_pengajuan', 'like', '%' . $search . '%')
                    ->orWhereHas('siswa', function ($siswa) use ($search) {
                        $siswa->whereNameLike($search)
                            ->orWhere('nis', 'like', '%' . $search . '%')
                            ->orWhereHas('kelas', function ($kelas) use ($search) {
                                $kelas->where('nama_kelas', 'like', '%' . $search . '%');
                            });
                    });
            });
        }

        // Filter tanggal
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Sinkronisasi status slot konseling terlebih dahulu agar relasi selalu konsisten
        $slotDates = SlotKonseling::select('tanggal')->distinct()->pluck('tanggal');
        foreach ($slotDates as $tgl) {
            SlotKonseling::syncSlotStatusesOnDate($tgl);
        }

        $penjadwalan = $query
            ->orderBy('tanggal')
            ->orderBy('waktu_mulai')
            ->paginate(8)
            ->withQueryString();

        // Daftar Jadwal Mengajar Guru BK
        $jadwalMengajar = JadwalMengajarBk::with('kelas')
            ->orderByRaw("CASE hari
                WHEN 'Senin' THEN 1
                WHEN 'Selasa' THEN 2
                WHEN 'Rabu' THEN 3
                WHEN 'Kamis' THEN 4
                WHEN 'Jumat' THEN 5
                WHEN 'Sabtu' THEN 6
                ELSE 7 END")
            ->orderBy('waktu_mulai')
            ->get();

        // Filter & Daftar Slot Ketersediaan Konseling
        $slotQuery = SlotKonseling::query();
        if ($request->filled('slot_tanggal')) {
            $slotQuery->whereDate('tanggal', $request->slot_tanggal);
        } elseif ($request->filled('tanggal')) {
            $slotQuery->whereDate('tanggal', $request->tanggal);
        }

        if ($request->filled('status_slot')) {
            $slotQuery->where('status_slot', $request->status_slot);
        }

        $slotKonseling = $slotQuery
            ->orderBy('tanggal')
            ->orderBy('waktu_mulai')
            ->get();

        // Ringkasan metrik slot & jadwal
        $allSlots = SlotKonseling::all();
        $slotStats = [
            'tersedia' => $allSlots->where('effective_status', SlotKonseling::STATUS_TERSEDIA)->count(),
            'menunggu' => $allSlots->where('effective_status', SlotKonseling::STATUS_MENUNGGU)->count(),
            'dipesan' => $allSlots->where('effective_status', SlotKonseling::STATUS_DIPESAN)->count(),
            'tidak_tersedia' => $allSlots->where('effective_status', SlotKonseling::STATUS_TIDAK_TERSEDIA)->count(),
        ];

        return view('penjadwalan.index', compact(
            'penjadwalan',
            'siswa',
            'kelasList',
            'jadwalMengajar',
            'slotKonseling',
            'slotStats'
        ));
    }

    public function create()
    {
        $siswa = Siswa::with('kelas')
            ->where('status', 'Aktif')
            ->orderBy('nama_siswa')
            ->get();

        $slotTersedia = SlotKonseling::where('status_slot', SlotKonseling::STATUS_TERSEDIA)
            ->where('tanggal', '>=', Carbon::today()->format('Y-m-d'))
            ->orderBy('tanggal')
            ->orderBy('waktu_mulai')
            ->get();

        return view('penjadwalan.create', compact('siswa', 'slotTersedia'));
    }

    public function store(Request $request)
    {
        // Jika memilih dari id_slot yang tersedia dan waktu belum diisi manual
        if ($request->filled('id_slot')) {
            $slotRef = SlotKonseling::find($request->input('id_slot'));
            if ($slotRef) {
                $request->merge([
                    'tanggal' => $request->input('tanggal') ?: $slotRef->tanggal,
                    'waktu_mulai' => $request->input('waktu_mulai') ?: substr($slotRef->waktu_mulai, 0, 5),
                    'waktu_selesai' => $request->input('waktu_selesai') ?: substr($slotRef->waktu_selesai, 0, 5),
                ]);
            }
        }

        $validated = $request->validate([
            'id_siswa' => 'required|exists:siswa,id_siswa',
            'id_slot' => 'nullable|exists:slot_konseling,id_slot',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
            'jenis_bimbingan' => 'required|string|max:255',
            'catatan' => 'nullable|string',
        ]);

        $targetStatus = $request->input('status', 'Terjadwal');

        $conflictError = null;
        $penjadwalan = DB::transaction(function () use ($validated, $targetStatus, &$conflictError) {
            // 1. Cek bentrok dengan Jadwal Mengajar Guru BK
            $teachingConflict = JadwalMengajarBk::findConflictOnDate(
                $validated['tanggal'],
                $validated['waktu_mulai'],
                $validated['waktu_selesai'],
                true
            );

            if ($teachingConflict) {
                $conflictError = JadwalMengajarBk::formatConflictMessage($teachingConflict);
                return null;
            }

            // 2. Cek bentrok dengan Jadwal Bimbingan Siswa lainnya
            $conflict = Penjadwalan::findConflict(
                $validated['tanggal'],
                $validated['waktu_mulai'],
                $validated['waktu_selesai'],
                null,
                Penjadwalan::ACTIVE_STATUSES,
                true // lockForUpdate
            );

            if ($conflict) {
                $conflictError = Penjadwalan::formatConflictMessage($conflict);
                return null;
            }

            // 3. Cek bentrok dengan Slot Konseling yang ditandai Tidak Tersedia atau sudah terisi
            $overlappingSlot = SlotKonseling::findConflict(
                $validated['tanggal'],
                $validated['waktu_mulai'],
                $validated['waktu_selesai'],
                null,
                true
            );

            if ($overlappingSlot) {
                if ($overlappingSlot->status_slot === SlotKonseling::STATUS_TIDAK_TERSEDIA) {
                    $waktuSlot = substr($overlappingSlot->waktu_mulai, 0, 5) . ' - ' . substr($overlappingSlot->waktu_selesai, 0, 5);
                    $conflictError = "Waktu bimbingan bertabrakan dengan slot konseling yang berstatus Tidak Tersedia pada pukul {$waktuSlot}.";
                    return null;
                }

                // Pastikan slot yang sama tidak digunakan oleh siswa lain secara bersamaan
                $slotHolder = Penjadwalan::where('id_slot', $overlappingSlot->id_slot)
                    ->whereIn('status', Penjadwalan::ACTIVE_STATUSES)
                    ->with('siswa')
                    ->lockForUpdate()
                    ->first();

                if ($slotHolder) {
                    $conflictError = Penjadwalan::formatConflictMessage($slotHolder);
                    return null;
                }

                // Tautkan dengan slot apabila waktu berada pada slot yang sama
                $validated['id_slot'] = $validated['id_slot'] ?? $overlappingSlot->id_slot;
            }

            $validated['status'] = $targetStatus;
            $created = Penjadwalan::create($validated);

            SlotKonseling::syncSlotStatusesOnDate($validated['tanggal']);

            return $created;
        });

        if (!$penjadwalan && $conflictError) {
            return back()
                ->withInput()
                ->withErrors(['waktu_mulai' => $conflictError])
                ->with('error', $conflictError);
        }

        return redirect()
            ->route('penjadwalan.index')
            ->with('success', 'Jadwal bimbingan berhasil ditambahkan.');
    }

    public function show($id)
    {
        $penjadwalan = Penjadwalan::with(['siswa.kelas', 'waliKelas', 'slotKonseling'])->findOrFail($id);

        return view('penjadwalan.show', compact('penjadwalan'));
    }

    public function edit($id)
    {
        $penjadwalan = Penjadwalan::findOrFail($id);
        $siswa = Siswa::with('kelas')
            ->where('status', 'Aktif')
            ->orderBy('nama_siswa')
            ->get();

        return view('penjadwalan.edit', compact('penjadwalan', 'siswa'));
    }

    public function update(Request $request, $id)
    {
        $penjadwalan = Penjadwalan::findOrFail($id);
        $oldTanggal = $penjadwalan->tanggal;

        $validated = $request->validate([
            'id_siswa' => 'required|exists:siswa,id_siswa',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
            'jenis_bimbingan' => 'required|string|max:255',
            'catatan' => 'nullable|string',
            'status' => 'required|in:Diajukan,Disetujui_Wali,Ditolak_Wali,Terjadwal,Selesai,Dibatalkan',
        ]);

        if (
            in_array($validated['status'], ['Terjadwal', 'Selesai'], true)
            && ($validated['waktu_mulai'] === '00:00' || $validated['waktu_selesai'] === '00:00')
        ) {
            $msg = 'Silakan tentukan jam bimbingan yang valid terlebih dahulu sebelum mengonfirmasi jadwal menjadi Terjadwal.';
            return back()
                ->withInput()
                ->withErrors(['waktu_mulai' => $msg])
                ->with('error', $msg);
        }

        $isSlotReleasing = in_array($validated['status'], ['Dibatalkan', 'Ditolak_Wali'], true);
        $hasValidTime = $validated['waktu_mulai'] !== '00:00' && $validated['waktu_selesai'] !== '00:00';
        $shouldBindSlot = in_array($validated['status'], ['Terjadwal', 'Selesai'], true)
            || !empty($penjadwalan->id_slot)
            || $hasValidTime;

        $conflictError = null;
        $updated = DB::transaction(function () use ($penjadwalan, $validated, $isSlotReleasing, $shouldBindSlot, $oldTanggal, &$conflictError) {
            if (!$isSlotReleasing) {
                // 1. Cek bentrok dengan Jadwal Mengajar Guru BK
                $teachingConflict = JadwalMengajarBk::findConflictOnDate(
                    $validated['tanggal'],
                    $validated['waktu_mulai'],
                    $validated['waktu_selesai'],
                    true
                );

                if ($teachingConflict) {
                    $conflictError = JadwalMengajarBk::formatConflictMessage($teachingConflict);
                    return false;
                }

                // 2. Cek bentrok dengan Jadwal Bimbingan Siswa lainnya
                $conflict = Penjadwalan::findConflict(
                    $validated['tanggal'],
                    $validated['waktu_mulai'],
                    $validated['waktu_selesai'],
                    $penjadwalan->id_penjadwalan,
                    Penjadwalan::ACTIVE_STATUSES,
                    true // lockForUpdate
                );

                if ($conflict) {
                    $conflictError = Penjadwalan::formatConflictMessage($conflict);
                    return false;
                }

                // 3. Cek apakah slot ditandai Tidak Tersedia
                $overlappingSlot = SlotKonseling::findConflict(
                    $validated['tanggal'],
                    $validated['waktu_mulai'],
                    $validated['waktu_selesai'],
                    null,
                    true
                );

                if ($overlappingSlot && $overlappingSlot->status_slot === SlotKonseling::STATUS_TIDAK_TERSEDIA) {
                    $waktuSlot = substr($overlappingSlot->waktu_mulai, 0, 5) . ' - ' . substr($overlappingSlot->waktu_selesai, 0, 5);
                    $conflictError = "Waktu bimbingan bertabrakan dengan slot konseling yang berstatus Tidak Tersedia pada pukul {$waktuSlot}.";
                    return false;
                }

                if ($overlappingSlot && $shouldBindSlot) {
                    // Pastikan slot yang sama tidak digunakan oleh dua siswa sekaligus
                    $slotHolder = Penjadwalan::where('id_slot', $overlappingSlot->id_slot)
                        ->where('id_penjadwalan', '!=', $penjadwalan->id_penjadwalan)
                        ->whereIn('status', Penjadwalan::ACTIVE_STATUSES)
                        ->with('siswa')
                        ->lockForUpdate()
                        ->first();

                    if ($slotHolder) {
                        $conflictError = Penjadwalan::formatConflictMessage($slotHolder);
                        return false;
                    }
                }

                if ($shouldBindSlot) {
                    $validated['id_slot'] = $overlappingSlot ? $overlappingSlot->id_slot : null;
                }
            } else {
                $validated['id_slot'] = null;
            }

            $penjadwalan->update($validated);

            SlotKonseling::syncSlotStatusesOnDate($oldTanggal);
            if ($validated['tanggal'] !== $oldTanggal) {
                SlotKonseling::syncSlotStatusesOnDate($validated['tanggal']);
            }

            return true;
        });

        if (!$updated && $conflictError) {
            return back()
                ->withInput()
                ->withErrors(['waktu_mulai' => $conflictError])
                ->with('error', $conflictError);
        }

        $redirectTo = $request->input('redirect_to');
        if ($redirectTo === 'index') {
            return redirect()
                ->route('penjadwalan.index')
                ->with('success', 'Data berhasil diperbarui.');
        }

        if ($redirectTo && (str_starts_with($redirectTo, url('/')) || (str_starts_with($redirectTo, '/') && !str_starts_with($redirectTo, '//')))) {
            return redirect($redirectTo)
                ->with('success', 'Data berhasil diperbarui.');
        }

        return redirect()
            ->route('penjadwalan.show', $penjadwalan->id_penjadwalan)
            ->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $penjadwalan = Penjadwalan::findOrFail($id);
        $tanggal = $penjadwalan->tanggal;
        $penjadwalan->delete();

        if ($tanggal) {
            SlotKonseling::syncSlotStatusesOnDate($tanggal);
        }

        return redirect()
            ->route('penjadwalan.index')
            ->with('success', 'Jadwal bimbingan berhasil dihapus.');
    }

    /**
     * =========================================================================
     * PENGELOLAAN JADWAL MENGAJAR GURU BK
     * =========================================================================
     */
    public function storeJadwalMengajar(Request $request)
    {
        $validated = $request->validate([
            'hari' => 'nullable|required_without:tanggal|string|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'tanggal' => 'nullable|date',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
            'id_kelas' => 'nullable|exists:kelas,id_kelas',
            'mata_pelajaran' => 'nullable|string|max:150',
            'catatan' => 'nullable|string|max:500',
        ], [
            'hari.required_without' => 'Hari mengajar wajib dipilih.',
            'waktu_mulai.required' => 'Waktu mulai mengajar wajib diisi.',
            'waktu_selesai.required' => 'Waktu selesai mengajar wajib diisi.',
            'waktu_selesai.after' => 'Waktu selesai mengajar harus setelah waktu mulai.',
        ]);

        $tanggal = $validated['tanggal'] ?? null;
        $hari = !empty($tanggal)
            ? JadwalMengajarBk::resolveHariFromTanggal($tanggal)
            : $validated['hari'];

        $waktuMulai = JadwalMengajarBk::normalizeTime($validated['waktu_mulai']);
        $waktuSelesai = JadwalMengajarBk::normalizeTime($validated['waktu_selesai']);

        $conflictError = null;
        $jadwal = DB::transaction(function () use ($hari, $tanggal, $waktuMulai, $waktuSelesai, $validated, &$conflictError) {
            // 1. Cek bentrok dengan Jadwal Mengajar lain di hari/tanggal yang sama
            $teachingConflict = JadwalMengajarBk::findTeachingConflict(
                $hari,
                $tanggal,
                $waktuMulai,
                $waktuSelesai,
                null,
                true
            );

            if ($teachingConflict) {
                $conflictError = JadwalMengajarBk::formatConflictMessage($teachingConflict);
                return null;
            }

            // 2. Cek bentrok dengan Slot Konseling yang sudah dibuka pada hari/tanggal tersebut
            $slotCandidates = SlotKonseling::where('status_slot', '!=', SlotKonseling::STATUS_TIDAK_TERSEDIA)
                ->where('waktu_mulai', '<', $waktuSelesai)
                ->where('waktu_selesai', '>', $waktuMulai)
                ->lockForUpdate()
                ->get();

            foreach ($slotCandidates as $slot) {
                $matchesDate = !empty($tanggal)
                    ? $slot->tanggal === $tanggal
                    : mb_strtolower(JadwalMengajarBk::resolveHariFromTanggal($slot->tanggal)) === mb_strtolower($hari);

                if ($matchesDate) {
                    $waktuSlot = substr($slot->waktu_mulai, 0, 5) . ' - ' . substr($slot->waktu_selesai, 0, 5);
                    $conflictError = "Jadwal mengajar berbenturan dengan Slot Konseling aktif pada tanggal {$slot->tanggal} ({$hari}) pukul {$waktuSlot}. Silakan tutup atau hapus slot konseling tersebut terlebih dahulu.";
                    return null;
                }
            }

            // 3. Cek bentrok dengan Jadwal Bimbingan Siswa yang aktif pada hari/tanggal tersebut
            $bookingCandidates = Penjadwalan::with('siswa')
                ->whereIn('status', Penjadwalan::ACTIVE_STATUSES)
                ->where(function ($q) {
                    $q->where('waktu_mulai', '!=', '00:00:00')
                        ->orWhere('waktu_selesai', '!=', '00:00:00');
                })
                ->where(function ($q) {
                    $q->whereNotNull('id_slot')
                        ->orWhereIn('status', ['Terjadwal', 'Selesai']);
                })
                ->where('waktu_mulai', '<', $waktuSelesai)
                ->where('waktu_selesai', '>', $waktuMulai)
                ->lockForUpdate()
                ->get();

            foreach ($bookingCandidates as $booking) {
                $matchesDate = !empty($tanggal)
                    ? $booking->tanggal === $tanggal
                    : mb_strtolower(JadwalMengajarBk::resolveHariFromTanggal($booking->tanggal)) === mb_strtolower($hari);

                if ($matchesDate) {
                    $conflictError = Penjadwalan::formatConflictMessage($booking);
                    return null;
                }
            }

            return JadwalMengajarBk::create([
                'id_guru_bk' => Auth::id(),
                'hari' => $hari,
                'tanggal' => $tanggal,
                'waktu_mulai' => $validated['waktu_mulai'],
                'waktu_selesai' => $validated['waktu_selesai'],
                'id_kelas' => $validated['id_kelas'] ?? null,
                'mata_pelajaran' => !empty($validated['mata_pelajaran']) ? $validated['mata_pelajaran'] : 'Bimbingan Klasikal BK',
                'catatan' => $validated['catatan'] ?? null,
                'is_active' => true,
            ]);
        });

        if (!$jadwal && $conflictError) {
            return back()
                ->withInput()
                ->withErrors(['waktu_mulai' => $conflictError])
                ->with('error', $conflictError);
        }

        return redirect()
            ->route('penjadwalan.index')
            ->with('success', 'Jadwal mengajar Guru BK berhasil ditambahkan.');
    }

    public function updateJadwalMengajar(Request $request, $id)
    {
        $jadwal = JadwalMengajarBk::findOrFail($id);

        $validated = $request->validate([
            'hari' => 'nullable|required_without:tanggal|string|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'tanggal' => 'nullable|date',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
            'id_kelas' => 'nullable|exists:kelas,id_kelas',
            'mata_pelajaran' => 'nullable|string|max:150',
            'catatan' => 'nullable|string|max:500',
            'is_active' => 'nullable|boolean',
        ]);

        $tanggal = $validated['tanggal'] ?? null;
        $hari = !empty($tanggal)
            ? JadwalMengajarBk::resolveHariFromTanggal($tanggal)
            : $validated['hari'];
        $isActive = $request->has('is_active') ? (bool) $request->input('is_active') : true;

        $waktuMulai = JadwalMengajarBk::normalizeTime($validated['waktu_mulai']);
        $waktuSelesai = JadwalMengajarBk::normalizeTime($validated['waktu_selesai']);

        $conflictError = null;
        $updated = DB::transaction(function () use ($jadwal, $hari, $tanggal, $waktuMulai, $waktuSelesai, $isActive, $validated, &$conflictError) {
            if ($isActive) {
                $teachingConflict = JadwalMengajarBk::findTeachingConflict(
                    $hari,
                    $tanggal,
                    $waktuMulai,
                    $waktuSelesai,
                    $jadwal->id_jadwal_mengajar,
                    true
                );

                if ($teachingConflict) {
                    $conflictError = JadwalMengajarBk::formatConflictMessage($teachingConflict);
                    return false;
                }

                $slotCandidates = SlotKonseling::where('status_slot', '!=', SlotKonseling::STATUS_TIDAK_TERSEDIA)
                    ->where('waktu_mulai', '<', $waktuSelesai)
                    ->where('waktu_selesai', '>', $waktuMulai)
                    ->lockForUpdate()
                    ->get();

                foreach ($slotCandidates as $slot) {
                    $matchesDate = !empty($tanggal)
                        ? $slot->tanggal === $tanggal
                        : mb_strtolower(JadwalMengajarBk::resolveHariFromTanggal($slot->tanggal)) === mb_strtolower($hari);

                    if ($matchesDate) {
                        $waktuSlot = substr($slot->waktu_mulai, 0, 5) . ' - ' . substr($slot->waktu_selesai, 0, 5);
                        $conflictError = "Jadwal mengajar berbenturan dengan Slot Konseling aktif pada tanggal {$slot->tanggal} ({$hari}) pukul {$waktuSlot}.";
                        return false;
                    }
                }
            }

            $jadwal->update([
                'hari' => $hari,
                'tanggal' => $tanggal,
                'waktu_mulai' => $validated['waktu_mulai'],
                'waktu_selesai' => $validated['waktu_selesai'],
                'id_kelas' => $validated['id_kelas'] ?? null,
                'mata_pelajaran' => !empty($validated['mata_pelajaran']) ? $validated['mata_pelajaran'] : 'Bimbingan Klasikal BK',
                'catatan' => $validated['catatan'] ?? null,
                'is_active' => $isActive,
            ]);

            return true;
        });

        if (!$updated && $conflictError) {
            return back()
                ->withInput()
                ->withErrors(['waktu_mulai' => $conflictError])
                ->with('error', $conflictError);
        }

        return redirect()
            ->route('penjadwalan.index')
            ->with('success', 'Jadwal mengajar Guru BK berhasil diperbarui.');
    }

    public function destroyJadwalMengajar($id)
    {
        $jadwal = JadwalMengajarBk::findOrFail($id);
        $jadwal->delete();

        return redirect()
            ->route('penjadwalan.index')
            ->with('success', 'Jadwal mengajar Guru BK berhasil dihapus.');
    }

    /**
     * =========================================================================
     * PENGELOLAAN SLOT KETERSEDIAAN KONSELING (JAM OPERASIONAL 08:00 - 15:00)
     * =========================================================================
     */
    public function storeSlot(Request $request)
    {
        if ($request->filled('status') && !$request->filled('status_slot')) {
            $request->merge(['status_slot' => $request->input('status')]);
        }
        if ($request->filled('keterangan') && !$request->filled('catatan')) {
            $request->merge(['catatan' => $request->input('keterangan')]);
        }

        // Hitung waktu_selesai otomatis apabila durasi_menit atau durasi_jam dikirim dan waktu_selesai belum diisi
        if ($request->filled('waktu_mulai') && !$request->filled('waktu_selesai')) {
            $durasiMenitInput = null;
            if ($request->filled('durasi_menit')) {
                $durasiMenitInput = (int) $request->input('durasi_menit');
            } elseif ($request->filled('durasi_jam')) {
                $durasiMenitInput = (int) round(((float) $request->input('durasi_jam')) * 60);
            }

            if ($durasiMenitInput && $durasiMenitInput > 0) {
                try {
                    $computedEnd = Carbon::createFromFormat('H:i', substr(trim($request->input('waktu_mulai')), 0, 5))
                        ->addMinutes($durasiMenitInput)
                        ->format('H:i');
                    $request->merge(['waktu_selesai' => $computedEnd]);
                } catch (\Throwable $e) {
                    // Biarkan validator menangani format waktu_mulai
                }
            }
        }

        $validated = $request->validate([
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
            'durasi_menit' => 'nullable|integer|min:15|max:420',
            'status_slot' => 'nullable|in:Tersedia,Menunggu_Diproses,Dipesan,Tidak_Tersedia',
            'catatan' => 'nullable|string|max:500',
        ], [
            'tanggal.required' => 'Tanggal slot konseling wajib diisi.',
            'waktu_mulai.required' => 'Waktu mulai slot wajib diisi.',
            'waktu_selesai.required' => 'Waktu selesai slot wajib diisi.',
            'waktu_selesai.after' => 'Waktu selesai slot harus lebih besar daripada waktu mulai.',
        ]);

        // Validasi Jam Operasional 08:00 - 15:00 WIB
        if (!SlotKonseling::isWithinOperationalHours($validated['waktu_mulai'], $validated['waktu_selesai'])) {
            $msg = 'Slot konseling wajib berada dalam jam operasional layanan BK pukul 08:00 sampai 15:00 WIB.';
            return back()
                ->withInput()
                ->withErrors([
                    'waktu_mulai' => $msg,
                    'waktu_selesai' => $msg,
                ])
                ->with('error', $msg);
        }

        $durasiMenit = SlotKonseling::calculateDurationMinutes($validated['waktu_mulai'], $validated['waktu_selesai']);
        if (!empty($validated['durasi_menit']) && (int) $validated['durasi_menit'] !== $durasiMenit) {
            // Sesuaikan waktu_selesai dengan durasi_menit jika durasi_menit dipilih secara eksplisit namun melebihi jam operasional
            $durasiMenit = SlotKonseling::calculateDurationMinutes($validated['waktu_mulai'], $validated['waktu_selesai']);
        }

        $statusSlot = $validated['status_slot'] ?? SlotKonseling::STATUS_TERSEDIA;

        $conflictError = null;
        $slot = DB::transaction(function () use ($validated, $durasiMenit, $statusSlot, &$conflictError) {
            // 1. Cek bentrok dengan Jadwal Mengajar Guru BK
            $teachingConflict = JadwalMengajarBk::findConflictOnDate(
                $validated['tanggal'],
                $validated['waktu_mulai'],
                $validated['waktu_selesai'],
                true
            );

            if ($teachingConflict) {
                $conflictError = JadwalMengajarBk::formatConflictMessage($teachingConflict);
                return null;
            }

            // 2. Cek bentrok dengan Slot Konseling lain di tanggal yang sama
            $existingSlotConflict = SlotKonseling::findConflict(
                $validated['tanggal'],
                $validated['waktu_mulai'],
                $validated['waktu_selesai'],
                null,
                true,
                [
                    SlotKonseling::STATUS_TERSEDIA,
                    SlotKonseling::STATUS_MENUNGGU,
                    SlotKonseling::STATUS_DIPESAN,
                ]
            );

            if ($existingSlotConflict) {
                $waktu = substr($existingSlotConflict->waktu_mulai, 0, 5) . ' - ' . substr($existingSlotConflict->waktu_selesai, 0, 5);
                $conflictError = "Slot konseling berbenturan dengan slot lain yang sudah dibuka pada pukul {$waktu}.";
                return null;
            }

            // 3. Cek bentrok dengan Jadwal Bimbingan Siswa aktif
            $bookingConflict = Penjadwalan::findConflict(
                $validated['tanggal'],
                $validated['waktu_mulai'],
                $validated['waktu_selesai'],
                null,
                Penjadwalan::ACTIVE_STATUSES,
                true,
                true
            );

            if ($bookingConflict) {
                $conflictError = Penjadwalan::formatConflictMessage($bookingConflict);
                return null;
            }

            return SlotKonseling::create([
                'id_guru_bk' => Auth::id(),
                'tanggal' => $validated['tanggal'],
                'waktu_mulai' => $validated['waktu_mulai'],
                'waktu_selesai' => $validated['waktu_selesai'],
                'durasi_menit' => $durasiMenit,
                'status_slot' => $statusSlot,
                'catatan' => $validated['catatan'] ?? null,
            ]);
        });

        if (!$slot && $conflictError) {
            return back()
                ->withInput()
                ->withErrors(['waktu_mulai' => $conflictError])
                ->with('error', $conflictError);
        }

        return redirect()
            ->route('penjadwalan.index')
            ->with('success', "Slot ketersediaan konseling ({$slot->formatted_duration}) berhasil dibuka.");
    }

    public function updateSlot(Request $request, $id)
    {
        $slot = SlotKonseling::findOrFail($id);

        if ($request->filled('waktu_mulai') && !$request->filled('waktu_selesai') && $request->filled('durasi_menit')) {
            try {
                $computedEnd = Carbon::createFromFormat('H:i', substr(trim($request->input('waktu_mulai')), 0, 5))
                    ->addMinutes((int) $request->input('durasi_menit'))
                    ->format('H:i');
                $request->merge(['waktu_selesai' => $computedEnd]);
            } catch (\Throwable $e) {
            }
        }

        $validated = $request->validate([
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
            'status_slot' => 'required|in:Tersedia,Menunggu_Diproses,Dipesan,Tidak_Tersedia',
            'catatan' => 'nullable|string|max:500',
        ]);

        if (!SlotKonseling::isWithinOperationalHours($validated['waktu_mulai'], $validated['waktu_selesai'])) {
            $msg = 'Slot konseling wajib berada dalam jam operasional layanan BK pukul 08:00 sampai 15:00 WIB.';
            return back()
                ->withInput()
                ->withErrors([
                    'waktu_mulai' => $msg,
                    'waktu_selesai' => $msg,
                ])
                ->with('error', $msg);
        }

        $durasiMenit = SlotKonseling::calculateDurationMinutes($validated['waktu_mulai'], $validated['waktu_selesai']);

        $conflictError = null;
        $updated = DB::transaction(function () use ($slot, $validated, $durasiMenit, &$conflictError) {
            if ($validated['status_slot'] !== SlotKonseling::STATUS_TIDAK_TERSEDIA) {
                $teachingConflict = JadwalMengajarBk::findConflictOnDate(
                    $validated['tanggal'],
                    $validated['waktu_mulai'],
                    $validated['waktu_selesai'],
                    true
                );

                if ($teachingConflict) {
                    $conflictError = JadwalMengajarBk::formatConflictMessage($teachingConflict);
                    return false;
                }
            }

            $existingSlotConflict = SlotKonseling::findConflict(
                $validated['tanggal'],
                $validated['waktu_mulai'],
                $validated['waktu_selesai'],
                $slot->id_slot,
                true
            );

            if ($existingSlotConflict) {
                $waktu = substr($existingSlotConflict->waktu_mulai, 0, 5) . ' - ' . substr($existingSlotConflict->waktu_selesai, 0, 5);
                $conflictError = "Slot konseling berbenturan dengan slot lain pada pukul {$waktu}.";
                return false;
            }

            // Jika slot sedang memiliki permohonan jadwal siswa yang aktif, cegah penutupan paksa atau penggeseran yang memutus jadwal
            $activeBooking = Penjadwalan::where('id_slot', $slot->id_slot)
                ->whereIn('status', Penjadwalan::ACTIVE_STATUSES)
                ->lockForUpdate()
                ->first() ?? Penjadwalan::findConflict(
                    $slot->tanggal,
                    $slot->waktu_mulai,
                    $slot->waktu_selesai,
                    null,
                    Penjadwalan::ACTIVE_STATUSES,
                    true,
                    true
                );

            if ($activeBooking && $validated['status_slot'] === SlotKonseling::STATUS_TIDAK_TERSEDIA) {
                $conflictError = 'Slot ini sedang menunggu diproses atau sudah dipesan siswa. Batalkan jadwal siswa terlebih dahulu sebelum menonaktifkan slot.';
                return false;
            }

            $oldSlotTanggal = $slot->tanggal;

            $slot->update([
                'tanggal' => $validated['tanggal'],
                'waktu_mulai' => $validated['waktu_mulai'],
                'waktu_selesai' => $validated['waktu_selesai'],
                'durasi_menit' => $durasiMenit,
                'status_slot' => $validated['status_slot'],
                'catatan' => $validated['catatan'] ?? null,
            ]);

            // Jika slot memiliki pengajuan aktif yang terikat pada id_slot ini, sinkronkan tanggal & jamnya
            Penjadwalan::where('id_slot', $slot->id_slot)
                ->whereIn('status', Penjadwalan::ACTIVE_STATUSES)
                ->update([
                    'tanggal' => $validated['tanggal'],
                    'waktu_mulai' => $validated['waktu_mulai'],
                    'waktu_selesai' => $validated['waktu_selesai'],
                ]);

            SlotKonseling::syncSlotStatusesOnDate($validated['tanggal']);
            if ($oldSlotTanggal && $oldSlotTanggal !== $validated['tanggal']) {
                SlotKonseling::syncSlotStatusesOnDate($oldSlotTanggal);
            }

            return true;
        });

        if (!$updated && $conflictError) {
            return back()
                ->withInput()
                ->withErrors(['waktu_mulai' => $conflictError])
                ->with('error', $conflictError);
        }

        return redirect()
            ->route('penjadwalan.index')
            ->with('success', 'Slot ketersediaan konseling berhasil diperbarui.');
    }

    public function destroySlot($id)
    {
        $slot = SlotKonseling::findOrFail($id);

        $activeBooking = Penjadwalan::where('id_slot', $slot->id_slot)
            ->whereIn('status', Penjadwalan::ACTIVE_STATUSES)
            ->first() ?? Penjadwalan::findConflict(
                $slot->tanggal,
                $slot->waktu_mulai,
                $slot->waktu_selesai,
                null,
                Penjadwalan::ACTIVE_STATUSES,
                false,
                true
            );

        if ($activeBooking) {
            return back()->with('error', 'Slot konseling yang sedang menunggu diproses atau sudah dipesan oleh siswa tidak dapat dihapus.');
        }

        $slot->delete();

        return redirect()
            ->route('penjadwalan.index')
            ->with('success', 'Slot ketersediaan konseling berhasil dihapus.');
    }
}
