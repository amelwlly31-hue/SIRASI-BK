<?php

namespace App\Http\Controllers;

use App\Models\TindakLanjut;
use App\Models\Konseling;
use Illuminate\Http\Request;

class TindakLanjutController extends Controller
{
    public function index()
    {
        return redirect()->route('konseling.index');
    }

    public function create(Request $request)
    {
        $konseling = Konseling::with([
            'siswa.kelas',
            'jenisMasalah'
        ])
            ->orderByDesc('tanggal')
            ->get();

        $selectedKonseling = $request->id_konseling;

        return view('tindak_lanjut.create', compact(
            'konseling',
            'selectedKonseling'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_konseling' => 'required|exists:konseling,id_konseling',
            'tanggal' => 'required|date',
            'tindakan' => 'required|string',
            'keterangan' => 'required|string',
        ]);

        TindakLanjut::create($validated);

        return redirect()
            ->route('konseling.show', $validated['id_konseling'])
            ->with('success', 'Tindak lanjut berhasil ditambahkan.');
    }

    public function show($id)
    {
        $tindakLanjut = TindakLanjut::findOrFail($id);
        return redirect()->route('konseling.show', $tindakLanjut->id_konseling);
    }

    public function edit($id)
    {
        $tindakLanjut = TindakLanjut::findOrFail($id);

        $konseling = Konseling::with([
            'siswa.kelas',
            'jenisMasalah'
        ])
            ->orderByDesc('tanggal')
            ->get();

        return view('tindak_lanjut.edit', compact(
            'tindakLanjut',
            'konseling'
        ));
    }

    public function update(Request $request, $id)
    {
        $tindakLanjut = TindakLanjut::findOrFail($id);

        $validated = $request->validate([
            'id_konseling' => 'required|exists:konseling,id_konseling',
            'tanggal' => 'required|date',
            'tindakan' => 'required|string',
            'keterangan' => 'required|string',
        ]);

        try {
            $tindakLanjut->update($validated);
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui tindak lanjut. Silakan periksa kembali data Anda.');
        }

        $redirectTo = $request->input('redirect_to');
        if ($redirectTo && (str_starts_with($redirectTo, url('/')) || (str_starts_with($redirectTo, '/') && !str_starts_with($redirectTo, '//')))) {
            return redirect($redirectTo)
                ->with('success', 'Data berhasil diperbarui.');
        }

        return redirect()
            ->route('konseling.show', $tindakLanjut->id_konseling)
            ->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $tindakLanjut = TindakLanjut::findOrFail($id);

        $idKonseling = $tindakLanjut->id_konseling;

        $tindakLanjut->delete();

        return redirect()
            ->route('konseling.show', $idKonseling)
            ->with('success', 'Tindak lanjut berhasil dihapus.');
    }
}
