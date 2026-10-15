<?php

namespace App\Http\Controllers;

use App\Models\Penjadwalan;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PersetujuanWaliController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $idKelas = $user->id_kelas;
        $kelas = $user->kelas;

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
        $baseQuery = Penjadwalan::whereHas('siswa', function ($q) use ($idKelas) {
            $q->where('id_kelas', $idKelas);
        });

        // Hitung metrik ringkasan status
        $totalMenunggu = (clone $baseQuery)->where('status', 'Diajukan')->count();
        $totalDisetujui = (clone $baseQuery)->where('status', 'Disetujui_Wali')->count();
        $totalDitolak = (clone $baseQuery)->where('status', 'Ditolak_Wali')->count();
        $totalTerjadwal = (clone $baseQuery)->whereIn('status', ['Terjadwal', 'Selesai'])->count();

        // Query untuk tabel dengan relasi dan filter
        $query = Penjadwalan::with(['siswa.kelas', 'waliKelas'])
            ->whereHas('siswa', function ($q) use ($idKelas) {
                $q->where('id_kelas', $idKelas);
            });

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Pencarian nama siswa atau NIS
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('siswa', function ($q) use ($search) {
                $q->where('nama_siswa', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        $pengajuan = $query->orderByRaw("CASE WHEN status = 'Diajukan' THEN 1 ELSE 2 END")
            ->orderBy('tanggal', 'desc')
            ->orderBy('waktu_mulai', 'desc')
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

        // 1. Validasi Otorisasi Kelas Sisi Server (Wajib)
        if (!$user->id_kelas || !$penjadwalan->siswa || $penjadwalan->siswa->id_kelas !== $user->id_kelas) {
            abort(403, 'Anda hanya berhak memproses pengajuan siswa dari kelas binaan Anda.');
        }

        // 2. Validasi Status Transisi
        if ($penjadwalan->status !== 'Diajukan') {
            return back()->with('error', 'Hanya pengajuan berstatus "Diajukan" yang dapat disetujui.');
        }

        // 3. Validasi Input
        $validated = $request->validate([
            'catatan_wali' => 'nullable|string|max:500',
        ]);

        // 4. Update Status Persetujuan & Audit Trail
        $penjadwalan->update([
            'status' => 'Disetujui_Wali',
            'id_wali' => $user->id_user,
            'waktu_persetujuan_wali' => now(),
            'catatan_wali' => $validated['catatan_wali'] ?? null,
        ]);

        // 5. Terbitkan Notifikasi untuk Guru BK
        $namaSiswa = $penjadwalan->siswa->nama_siswa ?? 'Siswa';
        $namaKelas = $penjadwalan->siswa->kelas->nama_kelas ?? '-';
        $tglFormatted = Carbon::parse($penjadwalan->tanggal)->isoFormat('D MMMM Y');

        Notifikasi::create([
            'judul' => 'Pengajuan Disetujui Wali Kelas',
            'pesan' => "Pengajuan bimbingan {$penjadwalan->jenis_bimbingan} untuk {$namaSiswa} (Kelas {$namaKelas}) pada tanggal {$tglFormatted} telah disetujui oleh Wali Kelas. Silakan tetapkan jadwal final.",
            'tipe' => 'jadwal',
            'dibaca' => false,
            'id_konseling' => null,
        ]);

        return redirect()->route('wali.pengajuan.index')
            ->with('success', 'Pengajuan konseling siswa berhasil disetujui.');
    }

    public function reject(Request $request, $id)
    {
        $penjadwalan = Penjadwalan::with('siswa.kelas')->findOrFail($id);
        $user = Auth::user();

        // 1. Validasi Otorisasi Kelas Sisi Server (Wajib)
        if (!$user->id_kelas || !$penjadwalan->siswa || $penjadwalan->siswa->id_kelas !== $user->id_kelas) {
            abort(403, 'Anda hanya berhak memproses pengajuan siswa dari kelas binaan Anda.');
        }

        // 2. Validasi Status Transisi
        if ($penjadwalan->status !== 'Diajukan') {
            return back()->with('error', 'Hanya pengajuan berstatus "Diajukan" yang dapat ditolak.');
        }

        // 3. Validasi Input (Alasan Wajib Diisi)
        $validated = $request->validate([
            'catatan_wali' => 'required|string|min:5|max:500',
        ], [
            'catatan_wali.required' => 'Alasan penolakan wajib diisi untuk koordinasi.',
            'catatan_wali.min' => 'Alasan penolakan minimal 5 karakter.',
        ]);

        // 4. Update Status Penolakan & Audit Trail
        $penjadwalan->update([
            'status' => 'Ditolak_Wali',
            'id_wali' => $user->id_user,
            'waktu_persetujuan_wali' => now(),
            'catatan_wali' => $validated['catatan_wali'],
        ]);

        // 5. Terbitkan Notifikasi
        $namaSiswa = $penjadwalan->siswa->nama_siswa ?? 'Siswa';
        $namaKelas = $penjadwalan->siswa->kelas->nama_kelas ?? '-';

        Notifikasi::create([
            'judul' => 'Pengajuan Ditolak Wali Kelas',
            'pesan' => "Pengajuan bimbingan untuk {$namaSiswa} (Kelas {$namaKelas}) ditolak oleh Wali Kelas dengan alasan: \"{$validated['catatan_wali']}\".",
            'tipe' => 'jadwal',
            'dibaca' => false,
            'id_konseling' => null,
        ]);

        return redirect()->route('wali.pengajuan.index')
            ->with('success', 'Pengajuan konseling siswa telah ditolak.');
    }
}
