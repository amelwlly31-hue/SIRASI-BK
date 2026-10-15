<?php

namespace App\Http\Controllers;

use App\Models\Penjadwalan;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjadwalanController extends Controller
{
    public function index(Request $request)
    {
        $query = Penjadwalan::with(['siswa.kelas', 'waliKelas']);

        $siswa = Siswa::with('kelas')
            ->where('status', 'Aktif')
            ->orderBy('nama_siswa')
            ->get();

        // search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('jenis_bimbingan', 'like', '%' . $search . '%')
                    ->orWhere('catatan', 'like', '%' . $search . '%')
                    ->orWhere('status', 'like', '%' . $search . '%')
                    ->orWhereHas('siswa', function ($siswa) use ($search) {
                        $siswa->where('nama_siswa', 'like', '%' . $search . '%');
                    });
            });
        }

        // filter tanggal
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        // filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $penjadwalan = $query
            ->orderBy('tanggal')
            ->orderBy('waktu_mulai')
            ->paginate(8)
            ->withQueryString();

        return view('penjadwalan.index', compact('penjadwalan', 'siswa'));
    }

    public function create()
    {
        $siswa = Siswa::with('kelas')
            ->where('status', 'Aktif')
            ->orderBy('nama_siswa')
            ->get();

        return view('penjadwalan.create', compact('siswa'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_siswa' => 'required|exists:siswa,id_siswa',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
            'jenis_bimbingan' => 'required|string|max:255',
            'catatan' => 'nullable|string',
        ]);

        $targetStatus = $request->input('status', 'Terjadwal');

        $conflict = null;
        $penjadwalan = DB::transaction(function () use ($validated, $targetStatus, &$conflict) {
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

            $validated['status'] = $targetStatus;
            return Penjadwalan::create($validated);
        });

        if (!$penjadwalan && $conflict) {
            $errorMessage = Penjadwalan::formatConflictMessage($conflict);
            return back()
                ->withInput()
                ->withErrors(['waktu_mulai' => $errorMessage])
                ->with('error', $errorMessage);
        }

        return redirect()
            ->route('penjadwalan.index')
            ->with('success', 'Jadwal bimbingan berhasil ditambahkan.');
    }

    public function show($id)
    {
        $penjadwalan = Penjadwalan::with(['siswa.kelas', 'waliKelas'])->findOrFail($id);

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

        $validated = $request->validate([
            'id_siswa' => 'required|exists:siswa,id_siswa',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
            'jenis_bimbingan' => 'required|string|max:255',
            'catatan' => 'nullable|string',
            'status' => 'required|in:Diajukan,Disetujui_Wali,Ditolak_Wali,Terjadwal,Selesai,Dibatalkan',
        ]);

        $isSlotReleasing = in_array($validated['status'], ['Dibatalkan', 'Ditolak_Wali']);

        $conflict = null;
        $updated = DB::transaction(function () use ($penjadwalan, $validated, $isSlotReleasing, &$conflict) {
            if (!$isSlotReleasing) {
                $conflict = Penjadwalan::findConflict(
                    $validated['tanggal'],
                    $validated['waktu_mulai'],
                    $validated['waktu_selesai'],
                    $penjadwalan->id_penjadwalan,
                    Penjadwalan::ACTIVE_STATUSES,
                    true // lockForUpdate
                );

                if ($conflict) {
                    return false;
                }
            }

            $penjadwalan->update($validated);
            return true;
        });

        if (!$updated && $conflict) {
            $errorMessage = Penjadwalan::formatConflictMessage($conflict);
            return back()
                ->withInput()
                ->withErrors(['waktu_mulai' => $errorMessage])
                ->with('error', $errorMessage);
        }

        return redirect()
            ->route('penjadwalan.show', $penjadwalan->id_penjadwalan)
            ->with('success', 'Jadwal bimbingan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $penjadwalan = Penjadwalan::findOrFail($id);
        $penjadwalan->delete();

        return redirect()
            ->route('penjadwalan.index')
            ->with('success', 'Jadwal bimbingan berhasil dihapus.');
    }
}
