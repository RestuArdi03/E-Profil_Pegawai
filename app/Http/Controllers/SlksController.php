<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiwayatSlks;
use App\Models\Pegawai;

class SlksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pegawaiId = auth()->user()->pegawai_id;
        $riwayat_slks = RiwayatSlks::where('pegawai_id', $pegawaiId)->get();
        return view('frontend.slks', compact('riwayat_slks'));
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
            'slks' => 'required|string|max:255',
            'no_kepres' => 'nullable|string|max:100|unique:riwayat_slks,no_kepres',
            'tgl_kepres' => 'required|date',
            'status' => 'required|string|max:50',
        ], [
            'no_kepres.unique' => 'Nomor SLKS sudah digunakan / Nomor SLKS harus berbeda dengan yang lain.',
        ]);

        // ✅ Simpan riwayat SLKS
        RiwayatSlks::create([
            'pegawai_id' => $request->pegawai_id,
            'slks' => $request->slks,
            'no_kepres' => $request->no_kepres,
            'tgl_kepres' => $request->tgl_kepres,
            'pimpinan' => $request->pimpinan,
            'status' => $request->status,
        ]);

        return redirect()->route('backend.slks.show', $request->pegawai_id)
            ->with('success', '✅ Data Riwayat SLKS berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        session(['pegawai_id' => $id]);

        $pegawai = Pegawai::with('riwayatSlks')->findOrFail($id);
        $riwayat_slks = $pegawai->riwayatSlks;

        return view('backend.pegawai.riwayat_slks', compact('pegawai', 'riwayat_slks'));
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
        $slks = RiwayatSlks::findOrFail($id);
        // 🔍 Validasi data edit
        $request->validate([
            'slks' => 'required|string|max:255',
            'no_kepres' => 'nullable|string|max:100|unique:riwayat_slks,no_kepres,' . $id,
            'tgl_kepres' => 'required|date',
            'status' => 'required|string|max:50',
        ], [
            'no_kepres.unique' => 'Nomor SLKS sudah digunakan / Nomor SLKS harus berbeda dengan yang lain.',
        ]);

        // ✅ Update data
        $slks->update([
            'slks' => $request->slks,
            'no_kepres' => $request->no_kepres,
            'tgl_kepres' => $request->tgl_kepres,
            'pimpinan' => $request->pimpinan,
            'status' => $request->status,
        ]);

        return redirect()->route('backend.slks.show', $request->pegawai_id) ->with('success', '✅ Data Riwayat SLKS berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $riwayat_slks = RiwayatSlks::findOrFail($id);
        $riwayat_slks->delete(); // ✅ Hapus data riwayat slks (soft delete)

        return redirect()->back()->with('success', '✅ Data Riwayat SLKS berhasil dihapus.');
    }
}
