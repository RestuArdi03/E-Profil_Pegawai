<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiwayatGaji;
use App\Models\Pegawai;

class GajiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pegawaiId = auth()->user()->pegawai_id;
        $riwayat_gaji = RiwayatGaji::with('pegawai')->where('pegawai_id', $pegawaiId)->get();
        return view('frontend.gaji', compact('riwayat_gaji'));
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
            'pejabat_penetap' => 'required|string|max:255',
            'no_sk' => 'required|string|max:100|unique:riwayat_gaji,no_sk',
            'tgl_sk' => 'required|date',
            'jml_gaji' => 'required|string|max:20',
            'ket' => 'nullable|string|max:50',
        ],[
            'no_sk.unique' => 'Nomor SK sudah digunakan / Nomor SK harus berbeda dengan yang lain.',
        ]);

        // ✅ Simpan riwayat gaji
        RiwayatGaji::create([
            'pegawai_id' => $request->pegawai_id,
            'pejabat_penetap' => $request->pejabat_penetap,
            'no_sk' => $request->no_sk,
            'tgl_sk' => $request->tgl_sk,
            'jml_gaji' => $request->jml_gaji,
            'ket' => $request->ket,
        ]);

        return redirect()->route('backend.gaji.show', $request->pegawai_id)
            ->with('success', '✅ Data Riwayat Gaji berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        session(['pegawai_id' => $id]);

        $pegawai = Pegawai::with('riwayatGaji')->findOrFail($id);
        $riwayat_gaji = $pegawai->riwayatGaji;

        return view('backend.pegawai.riwayat_gaji', compact('pegawai', 'riwayat_gaji'));
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
        $gaji = RiwayatGaji::findOrFail($id);
        // 🔍 Validasi data edit
        $request->validate([
            'pegawai_id' => 'required|exists:pegawai,id',
            'pejabat_penetap' => 'required|string|max:255',
            'no_sk' => 'required|string|max:100|unique:riwayat_gaji,no_sk,' . $id,
            'tgl_sk' => 'required|date',
            'jml_gaji' => 'required|string|max:20',
            'ket' => 'nullable|string|max:50',
        ],[
            'no_sk.unique' => 'Nomor SK sudah digunakan / Nomor SK harus berbeda dengan yang lain.',
        ]);

        // ✅ Update data
        $gaji->update([
            'pejabat_penetap' => $request->pejabat_penetap,
            'no_sk' => $request->no_sk,
            'tgl_sk' => $request->tgl_sk,
            'jml_gaji' => $request->jml_gaji,
            'ket' => $request->ket,
        ]);

        return redirect()->route('backend.gaji.show', $request->pegawai_id) ->with('success', '✅ Data Riwayat Gaji berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $riwayat_gaji = RiwayatGaji::findOrFail($id);
        $riwayat_gaji->delete(); // ✅ Hapus data riwayat gaji (soft delete)

        return redirect()->back()->with('success', '✅ Data Riwayat Gaji berhasil dihapus.');
    }
}
