<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiwayatPenghargaan;
use App\Models\Pegawai;

class PenghargaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pegawaiId = auth()->user()->pegawai_id;
        $riwayat_penghargaan = RiwayatPenghargaan::with('pegawai')->where('pegawai_id', $pegawaiId)->get();
        return view('frontend.penghargaan', compact('riwayat_penghargaan'));
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
            'nm_penghargaan' => 'required|string|max:255',
            'no_urut' => 'required|string|max:25',
            'no_sertifikat' => 'required|string|max:100|unique:riwayat_penghargaan,no_sertifikat',
            'tgl_sertifikat' => 'required|date',
            'pejabat_penetap' => 'required|string|max:255',
            'link' => 'required|url|max:255',
        ],[
            'no_sertifikat.unique' => 'Nomor sertifikat sudah digunakan / Nomor sertifikat harus berbeda dengan yang lain.',
        ]);

        // ✅ Simpan riwayat penghargaan
        RiwayatPenghargaan::create([
            'pegawai_id' => $request->pegawai_id,
            'nm_penghargaan' => $request->nm_penghargaan,
            'no_urut' => $request->no_urut,
            'no_sertifikat' => $request->no_sertifikat,
            'tgl_sertifikat' => $request->tgl_sertifikat,
            'pejabat_penetap' => $request->pejabat_penetap,
            'link' => $request->link,
        ]);

        return redirect()->route('backend.penghargaan.show', $request->pegawai_id)
            ->with('success', '✅ Data Riwayat Penghargaan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        session(['pegawai_id' => $id]);

        $pegawai = Pegawai::with('riwayatPenghargaan')->findOrFail($id);
        $riwayat_penghargaan = $pegawai->riwayatPenghargaan;

        return view('backend.pegawai.riwayat_penghargaan', compact('pegawai', 'riwayat_penghargaan'));
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
        $rph = RiwayatPenghargaan::findOrFail($id);
        // 🔍 Validasi data edit
        $request->validate([
            'nm_penghargaan' => 'required|string|max:255',
            'no_urut' => 'required|string|max:25',
            'no_sertifikat' => 'required|string|max:100|unique:riwayat_penghargaan,no_sertifikat,' . $id,
            'tgl_sertifikat' => 'required|date',
            'pejabat_penetap' => 'required|string|max:255',
            'link' => 'required|url|max:255',
        ],[
            'no_sertifikat.unique' => 'Nomor sertifikat sudah digunakan / Nomor sertifikat harus berbeda dengan yang lain.',
        ]);

        // ✅ Update data
        $rph->update([
            'nm_penghargaan' => $request->nm_penghargaan,
            'no_urut' => $request->no_urut,
            'no_sertifikat' => $request->no_sertifikat,
            'tgl_sertifikat' => $request->tgl_sertifikat,
            'pejabat_penetap' => $request->pejabat_penetap,
            'link' => $request->link,
        ]);

        return redirect()->route('backend.penghargaan.show', $request->pegawai_id) ->with('success', '✅ Data Riwayat Penghargaan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $riwayat_penghargaan = RiwayatPenghargaan::findOrFail($id);
        $riwayat_penghargaan->delete(); // ✅ Hapus data riwayat penghargaan (soft delete)

        return redirect()->back()->with('success', '✅ Data Riwayat Penghargaan berhasil dihapus.');
    }
}
