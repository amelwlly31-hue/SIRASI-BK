<?php

namespace App\Http\Controllers;

use App\Models\Konseling;
use App\Models\Siswa;
use App\Models\JenisMasalah;
use App\Models\Kelas;
use App\Models\Notifikasi;
use Illuminate\Http\Request;

class KonselingController extends Controller
{
    public function index(Request $request)
    {
        $query = Konseling::with([
            'siswa.kelas',
            'jenisMasalah',
            'tindakLanjut'
        ]);

        // search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('masalah', 'like', '%' . $search . '%')
                    ->orWhere('hasil_konseling', 'like', '%' . $search . '%')
                    ->orWhere('catatan', 'like', '%' . $search . '%')
                    ->orWhereHas('siswa', function ($siswa) use ($search) {
                        $siswa->where('nama_siswa', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('jenisMasalah', function ($jenis) use ($search) {
                        $jenis->where('nama_jenis', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('tindakLanjut', function ($tindak) use ($search) {
                        $tindak->where('tindakan', 'like', '%' . $search . '%')
                            ->orWhere('keterangan', 'like', '%' . $search . '%');
                    });
            });
        }

        // filter kelas
        if ($request->filled('kelas')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('id_kelas', $request->kelas);
            });
        }

        // filter tanggal
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        // filter periode
        if ($request->filled('periode')) {
            switch ($request->periode) {
                case 'bulan_ini':
                    $query->whereBetween('tanggal', [
                        now()->startOfMonth()->format('Y-m-d'),
                        now()->endOfMonth()->format('Y-m-d')
                    ]);
                    break;

                case 'bulan_lalu':
                    $bulanLalu = now()->subMonth();
                    $query->whereBetween('tanggal', [
                        $bulanLalu->copy()->startOfMonth()->format('Y-m-d'),
                        $bulanLalu->copy()->endOfMonth()->format('Y-m-d')
                    ]);
                    break;

                case 'tahun_ini':
                    $query->whereBetween('tanggal', [
                        now()->startOfYear()->format('Y-m-d'),
                        now()->endOfYear()->format('Y-m-d')
                    ]);
                    break;
            }
        }

        // filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $kelas = Kelas::all();
        $konseling = $query
            ->orderByDesc('tanggal')
            ->paginate(8)
            ->withQueryString();

        return view('konseling.index', compact('konseling', 'kelas'));
    }

    public function create(Request $request)
    {
        $siswa = Siswa::with('kelas')
            ->orderBy('nama_siswa')
            ->get();

        $jenisMasalah = JenisMasalah::orderBy('nama_jenis')->get();
        $selectedSiswa = $request->id_siswa;

        return view('konseling.create', compact('siswa', 'jenisMasalah', 'selectedSiswa'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_siswa' => 'required|exists:siswa,id_siswa',
            'id_jenis' => 'required|exists:jenis_masalah,id_jenis',
            'tanggal' => 'required|date',
            'masalah' => 'required|string',
            'hasil_konseling' => 'required|string',
            'catatan' => 'nullable|string',
        ]);

        $validated['status'] = 'Proses';
        $konseling = Konseling::create($validated);
        $siswa = Siswa::find($validated['id_siswa']);

        Notifikasi::create([
            'judul' => 'Konseling Baru',
            'pesan' => 'Data konseling baru untuk siswa ' . $siswa->nama_siswa . ' berhasil ditambahkan.',
            'tipe' => 'konseling',
            'dibaca' => false,
            'id_konseling' => $konseling->id_konseling,
        ]);

        return redirect()
            ->route('konseling.index')
            ->with('success', 'Catatan konseling berhasil ditambahkan.');
    }

    public function show($id)
    {
        $konseling = Konseling::with([
            'siswa.kelas',
            'jenisMasalah',
            'tindakLanjut'
        ])->findOrFail($id);

        return view('konseling.show', compact('konseling'));
    }

    public function edit($id)
    {
        $konseling = Konseling::findOrFail($id);
        $siswa = Siswa::with('kelas')->orderBy('nama_siswa')->get();
        $jenisMasalah = JenisMasalah::orderBy('nama_jenis')->get();

        return view('konseling.edit', compact('konseling', 'siswa', 'jenisMasalah'));
    }

    public function update(Request $request, $id)
    {
        $konseling = Konseling::findOrFail($id);

        $validated = $request->validate([
            'id_siswa' => 'required|exists:siswa,id_siswa',
            'id_jenis' => 'required|exists:jenis_masalah,id_jenis',
            'tanggal' => 'required|date',
            'masalah' => 'required|string',
            'hasil_konseling' => 'required|string',
            'catatan' => 'nullable|string',
            'status' => 'required|string|max:30',
        ]);

        $konseling->update($validated);

        return redirect()
            ->route('konseling.show', $konseling->id_konseling)
            ->with('success', 'Catatan konseling berhasil diperbarui.');
    }

    public function bacaNotifikasi($id)
    {
        $notifikasi = Notifikasi::findOrFail($id);

        $notifikasi->update([
            'dibaca' => true,
        ]);

        if ($notifikasi->id_konseling) {
            return redirect()->route('konseling.show', $notifikasi->id_konseling);
        }

        if ($notifikasi->tipe === 'siswa') {
            return redirect()->route('siswa.index');
        }

        if ($notifikasi->tipe === 'jadwal' || $notifikasi->tipe === 'penjadwalan') {
            return redirect()->route('penjadwalan.index');
        }

        return redirect()->route('konseling.index');
    }

    public function destroy($id)
    {
        $konseling = Konseling::findOrFail($id);
        $konseling->delete();

        return redirect()
            ->route('konseling.index')
            ->with('success', 'Catatan konseling berhasil dihapus.');
    }
}
