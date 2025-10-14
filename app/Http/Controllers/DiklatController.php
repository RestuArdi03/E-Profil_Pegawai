<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiwayatDiklat;
use App\Models\Pegawai;

class DiklatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pegawaiId = auth()->user()->pegawai_id;
        $riwayat_diklat = RiwayatDiklat::with('pegawai')->where('pegawai_id', $pegawaiId)->get();
        return view('frontend.diklat', compact('riwayat_diklat'));
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
            'nm_diklat' => 'required|string|max:255',
            'jpl' => 'required|string',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date',
            'no_sertifikat' => 'required|string|max:100|unique:riwayat_diklat,no_sertifikat',
            'tgl_sertifikat' => 'required|date',
            'penyelenggara' => 'required|string|max:255',
        ], [
            'no_sertifikat.unique' => 'Nomor sertifikat sudah digunakan / Nomor sertifikat harus berbeda dengan yang lain.',
        ]);

        // ✅ Simpan riwayat diklat
        RiwayatDiklat::create([
            'pegawai_id' => $request->pegawai_id,
            'nm_diklat' => $request->nm_diklat,
            'jpl' => $request->jpl,
            'tgl_mulai' => $request->tgl_mulai,
            'tgl_selesai' => $request->tgl_selesai,
            'no_sertifikat' => $request->no_sertifikat,
            'tgl_sertifikat' => $request->tgl_sertifikat,
            'penyelenggara' => $request->penyelenggara,
        ]);

        return redirect()->route('backend.diklat.show', $request->pegawai_id)
            ->with('success', '✅ Data Riwayat Diklat berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        session(['pegawai_id' => $id]);

        $pegawai = Pegawai::with('riwayatDiklat')->findOrFail($id);
        $riwayat_diklat = $pegawai->riwayatDiklat;

        return view('backend.pegawai.riwayat_diklat', compact('pegawai', 'riwayat_diklat'));
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
        $rd = RiwayatDiklat::findOrFail($id);
        // 🔍 Validasi data edit
        $request->validate([
            'nm_diklat' => 'required|string|max:255',
            'jpl' => 'required|string',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date',
            'no_sertifikat' => 'required|string|max:100|unique:riwayat_diklat,no_sertifikat,' . $id,
            'tgl_sertifikat' => 'required|date',
            'penyelenggara' => 'required|string|max:255',
        ], [
            'no_sertifikat.unique' => 'Nomor sertifikat sudah digunakan / Nomor sertifikat harus berbeda dengan yang lain.',
        ]);

        // ✅ Update data
        $rd->update([
            'nm_diklat' => $request->nm_diklat,
            'jpl' => $request->jpl,
            'tgl_mulai' => $request->tgl_mulai,
            'tgl_selesai' => $request->tgl_selesai,
            'no_sertifikat' => $request->no_sertifikat,
            'tgl_sertifikat' => $request->tgl_sertifikat,
            'penyelenggara' => $request->penyelenggara,
        ]);

        return redirect()->route('backend.diklat.show', $request->pegawai_id) ->with('success', '✅ Data Riwayat Diklat berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $riwayat_diklat = RiwayatDiklat::findOrFail($id);
        $riwayat_diklat->delete(); // ✅ Hapus data riwayat diklat (soft delete)

        return redirect()->back()->with('success', '✅ Data Riwayat Diklat berhasil dihapus.');
    }
}
