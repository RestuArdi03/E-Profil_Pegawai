<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiwayatAsesmen;
use App\Models\Pegawai;

class AsesmenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pegawaiId = auth()->user()->pegawai_id;
        $riwayat_asesmen = RiwayatAsesmen::with('pegawai')->where('pegawai_id', $pegawaiId)->get();
        return view('frontend.asesmen', compact('riwayat_asesmen'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 🔍 Validasi field wajib diisi
        $request->validate([
            'pegawai_id' => 'required|exists:pegawai,id',
            'tgl_asesmen' => 'required|date',
            'tujuan_asesmen' => 'required|string|max:255',
            'metode_asesmen' => 'required|string|max:255',
            'gambaran_potensi' => 'required|string|max:255',
            'gambaran_kompetensi' => 'required|string|max:255',
            'saran_pengembangan' => 'nullable|string|max:255',
        ]);

        // ✅ Simpan riwayat asesmen
        RiwayatAsesmen::create([
            'pegawai_id' => $request->pegawai_id,
            'tgl_asesmen' => $request->tgl_asesmen,
            'tujuan_asesmen' => $request->tujuan_asesmen,
            'metode_asesmen' => $request->metode_asesmen,
            'gambaran_potensi' => $request->gambaran_potensi,
            'gambaran_kompetensi' => $request->gambaran_kompetensi,
            'saran_pengembangan' => $request->saran_pengembangan,
        ]);

        return redirect()->route('backend.asesmen.show', $request->pegawai_id)
            ->with('success', '✅ Data Riwayat Asesmen berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        session(['pegawai_id' => $id]);

        $pegawai = Pegawai::with('riwayatAsesmen')->findOrFail($id);
        $riwayat_asesmen = $pegawai->riwayatAsesmen;

        return view('backend.pegawai.riwayat_asesmen', compact('pegawai', 'riwayat_asesmen'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $asesmen = RiwayatAsesmen::findOrFail($id);
        // 🔍 Validasi data edit
        $request->validate([
            'tgl_asesmen' => 'required|date',
            'tujuan_asesmen' => 'required|string|max:255',
            'metode_asesmen' => 'required|string|max:255',
            'gambaran_potensi' => 'required|string|max:255',
            'gambaran_kompetensi' => 'required|string|max:255',
            'saran_pengembangan' => 'nullable|string|max:50',
        ]);

        // ✅ Update data
        $asesmen->update([
            'tgl_asesmen' => $request->tgl_asesmen,
            'tujuan_asesmen' => $request->tujuan_asesmen,
            'metode_asesmen' => $request->metode_asesmen,
            'gambaran_potensi' => $request->gambaran_potensi,
            'gambaran_kompetensi' => $request->gambaran_kompetensi,
            'saran_pengembangan' => $request->saran_pengembangan,
        ]);

        return redirect()->route('backend.asesmen.show', $request->pegawai_id) ->with('success', '✅ Data Riwayat Asesmen berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $riwayat_asesmen = RiwayatAsesmen::findOrFail($id);
        $riwayat_asesmen->delete(); // ✅ Hapus data riwayat asesmen (soft delete)

        return redirect()->back()->with('success', '✅ Data Riwayat Asesmen berhasil dihapus.');
    }
}
