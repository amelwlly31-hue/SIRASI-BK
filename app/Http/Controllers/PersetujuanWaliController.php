<?php

namespace App\Http\Controllers;

use App\Models\Penjadwalan;
use App\Models\SlotKonseling;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PersetujuanWaliController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        abort_unless($user && $user->isWaliKelas(), 403, 'Halaman ini khusus untuk Wali Kelas.');
        $idKelas = $user->id_kelas;
        $kelas = $user->kelas;

        if (!$idKelas && $user) {
            $foundKelas = \App\Models\Kelas::whereHas('waliKelas', fn($q) => $q->where('id_user', $user->id_user))->first();
            if ($foundKelas) {
                $idKelas = $foundKelas->id_kelas;
                $kelas = $foundKelas;
                $user->update(['id_kelas' => $idKelas]);
            }
        }

        if (!$idKelas) {
            return view('wali_kelas.pengajuan', [
                'kelas' => null,
                'pengajuan' => collect(),
                'totalMenunggu' => 0,
                'totalDisetujui' => 0,
                'totalDitolak' => 0,
                'totalTerjadwal' => 0,
            ]);
        }

        // Query dasar terisolasi untuk kelas binaan ini saja
        $baseQuery = Penjadwalan::whereHas('siswa', function ($sub) use ($idKelas) {
            $sub->where('id_kelas', $idKelas);
        });

        // Hitung metrik ringkasan status
        $totalMenunggu = (clone $baseQuery)->where('status', 'Diajukan')->count();
        $totalDisetujui = (clone $baseQuery)->where('status', 'Disetujui_Wali')->count();
        $totalDitolak = (clone $baseQuery)->where('status', 'Ditolak_Wali')->count();
        $totalTerjadwal = (clone $baseQuery)->whereIn('status', ['Terjadwal', 'Selesai'])->count();

        // Query untuk tabel dengan relasi dan filter (tanpa kolom catatan pribadi konseling siswa)
        $query = Penjadwalan::select([
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
            ->with(['siswa.kelas', 'waliKelas'])
            ->whereHas('siswa', function ($sub) use ($idKelas) {
                $sub->where('id_kelas', $idKelas);
            });

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Pencarian nama siswa, NIS, atau kode izin
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($sub) use ($search) {
                $sub->where('kode_pengajuan', 'like', "%{$search}%")
                    ->orWhereHas('siswa', function ($q) use ($search) {
                        $q->whereNameLike($search)
                          ->orWhere('nis', 'like', "%{$search}%");
                    });
            });
        }

        $pengajuan = $query->orderByRaw("CASE WHEN status = 'Diajukan' THEN 1 ELSE 2 END")
            ->orderBy('tanggal', 'desc')
            ->orderBy('id_penjadwalan', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('wali_kelas.pengajuan', compact(
            'kelas',
            'pengajuan',
            'totalMenunggu',
            'totalDisetujui',
            'totalDitolak',
            'totalTerjadwal'
        ));
    }

    public function approve(Request $request, $id)
    {
        $penjadwalan = Penjadwalan::with('siswa.kelas')->findOrFail($id);
        $user = Auth::user();
        abort_unless($user && $user->isWaliKelas(), 403, 'Aksi ini khusus untuk Wali Kelas.');

        // 1. Validasi Otorisasi Kelas Sisi Server (Wajib)
        $this->authorizeClassRequest($user, $penjadwalan, 'Anda hanya berhak memberikan izin untuk siswa dari kelas binaan Anda.');

        // 2. Validasi Status Transisi
        if ($penjadwalan->status !== 'Diajukan') {
            return back()->with('error', 'Permohonan izin ini sudah diproses sebelumnya dan tidak dapat disetujui ulang.');
        }

        // 3. Validasi Input
        $validated = $request->validate([
            'catatan_wali' => 'nullable|string|max:500',
        ]);

        // 4. Catat Approval Izin Siswa oleh Wali Kelas dengan proteksi transaksi lockForUpdate
        // Catatan: Persetujuan izin Wali Kelas TIDAK otomatis menyetujui jadwal konseling Guru BK ('Terjadwal').
        $processed = DB::transaction(function () use ($id, $user, $validated) {
            $locked = Penjadwalan::with('siswa.kelas')->lockForUpdate()->findOrFail($id);
            $this->authorizeClassRequest($user, $locked, 'Anda hanya berhak memberikan izin untuk siswa dari kelas binaan Anda.');

            if ($locked->status !== 'Diajukan') {
                return false;
            }

            $locked->update([
                'status' => 'Disetujui_Wali',
                'id_wali' => $user->id_user,
                'waktu_persetujuan_wali' => now(),
                'catatan_wali' => $validated['catatan_wali'] ?? null,
            ]);

            SlotKonseling::syncSlotStatusesOnDate($locked->tanggal);

            $namaSiswa = $locked->siswa->nama_siswa ?? 'Siswa';
            $namaKelas = $locked->siswa->kelas->nama_kelas ?? '-';
            $tglFormatted = Carbon::parse($locked->tanggal)->isoFormat('D MMMM Y');

            Notifikasi::create([
                'judul' => 'Izin Konseling Siswa Disetujui Wali Kelas',
                'pesan' => "Wali Kelas telah memberikan izin bagi {$namaSiswa} (Kelas {$namaKelas}) untuk mengikuti bimbingan {$locked->jenis_bimbingan} (tanggal permohonan {$tglFormatted}). Siswa kini dapat melanjutkan pengajuan jadwal konseling. [JADWAL:{$locked->id_penjadwalan}]",
                'tipe' => 'jadwal',
                'dibaca' => false,
                'id_konseling' => null,
            ]);

            return true;
        });

        if (!$processed) {
            return back()->with('error', 'Permohonan izin ini sudah diproses sebelumnya dan tidak dapat disetujui ulang.');
        }

        return redirect()->route('wali.pengajuan.index')
            ->with('success', 'Izin siswa untuk mengikuti bimbingan konseling berhasil diberikan.');
    }

    public function reject(Request $request, $id)
    {
        $penjadwalan = Penjadwalan::with('siswa.kelas')->findOrFail($id);
        $user = Auth::user();
        abort_unless($user && $user->isWaliKelas(), 403, 'Aksi ini khusus untuk Wali Kelas.');

        // 1. Validasi Otorisasi Kelas Sisi Server (Wajib)
        $this->authorizeClassRequest($user, $penjadwalan, 'Anda hanya berhak memproses izin untuk siswa dari kelas binaan Anda.');

        // 2. Validasi Status Transisi
        if ($penjadwalan->status !== 'Diajukan') {
            return back()->with('error', 'Permohonan izin ini sudah diproses sebelumnya dan tidak dapat ditolak ulang.');
        }

        // 3. Validasi Input (Alasan Penolakan Izin Wajib Diisi)
        $validated = $request->validate([
            'catatan_wali' => 'required|string|min:5|max:500',
        ], [
            'catatan_wali.required' => 'Alasan penolakan / kendala izin wajib diisi.',
            'catatan_wali.min' => 'Alasan penolakan minimal 5 karakter.',
        ]);

        // 4. Catat Penolakan Izin dengan proteksi transaksi lockForUpdate
        $processed = DB::transaction(function () use ($id, $user, $validated) {
            $locked = Penjadwalan::with('siswa.kelas')->lockForUpdate()->findOrFail($id);
            $this->authorizeClassRequest($user, $locked, 'Anda hanya berhak memproses izin untuk siswa dari kelas binaan Anda.');

            if ($locked->status !== 'Diajukan') {
                return false;
            }

            $locked->update([
                'status' => 'Ditolak_Wali',
                'id_wali' => $user->id_user,
                'waktu_persetujuan_wali' => now(),
                'catatan_wali' => $validated['catatan_wali'],
            ]);

            // Bebaskan kembali slot konseling ke status Tersedia jika izin ditolak oleh Wali Kelas
            SlotKonseling::syncSlotStatusesOnDate($locked->tanggal);

            $namaSiswa = $locked->siswa->nama_siswa ?? 'Siswa';
            $namaKelas = $locked->siswa->kelas->nama_kelas ?? '-';

            Notifikasi::create([
                'judul' => 'Izin Waktu Konseling Belum Disetujui Wali Kelas',
                'pesan' => "Wali Kelas belum dapat memberikan izin untuk {$namaSiswa} (Kelas {$namaKelas}) dengan alasan: \"{$validated['catatan_wali']}\". [JADWAL:{$locked->id_penjadwalan}]",
                'tipe' => 'jadwal',
                'dibaca' => false,
                'id_konseling' => null,
            ]);

            return true;
        });

        if (!$processed) {
            return back()->with('error', 'Permohonan izin ini sudah diproses sebelumnya dan tidak dapat ditolak ulang.');
        }

        return redirect()->route('wali.pengajuan.index')
            ->with('success', 'Permohonan izin siswa berhasil ditolak beserta catatan alasan.');
    }

    /** Ensure authorization is still valid for the locked row before changing its status. */
    private function authorizeClassRequest($user, Penjadwalan $penjadwalan, string $message): void
    {
        $penjadwalan->loadMissing('siswa.kelas');
        $userKelasId = $user?->id_kelas;
        if (!$userKelasId && $user) {
            $userKelasId = \App\Models\Kelas::whereHas('waliKelas', fn($q) => $q->where('id_user', $user->id_user))->value('id_kelas');
        }

        $isClassMatch = $userKelasId && $penjadwalan->siswa && (int) $penjadwalan->siswa->id_kelas === (int) $userKelasId;

        if (!$isClassMatch) {
            abort(403, $message);
        }
    }
}
