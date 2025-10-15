<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiwayatOrganisasi;
use App\Models\Pegawai;

class OrganisasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pegawaiId = auth()->user()->pegawai_id;
        $riwayat_organisasi = RiwayatOrganisasi::with('pegawai')->where('pegawai_id', $pegawaiId)->get();
        return view('frontend.organisasi', compact('riwayat_organisasi'));
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
            'organisasi' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'masa_jabatan' => 'required|string|max:255',
            'no_sk' => 'required|string|max:100|unique:riwayat_organisasi,no_sk',
            'tgl_sk' => 'required|date',
            'pejabat_penetap' => 'required|string|max:255',
        ], [
            'no_sk.unique' => 'Nomor SK sudah digunakan / Nomor SK harus berbeda dengan yang lain.',
        ]);

        // ✅ Simpan riwayat organisasi
        RiwayatOrganisasi::create([
            'pegawai_id' => $request->pegawai_id,
            'organisasi' => $request->organisasi,
            'jabatan' => $request->jabatan,
            'masa_jabatan' => $request->masa_jabatan,
            'no_sk' => $request->no_sk,
            'tgl_sk' => $request->tgl_sk,
            'pejabat_penetap' => $request->pejabat_penetap,
        ]);

        return redirect()->route('backend.organisasi.show', $request->pegawai_id)
            ->with('success', '✅ Data Riwayat Organisasi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        session(['pegawai_id' => $id]);

        $pegawai = Pegawai::with('riwayatOrganisasi')->findOrFail($id);
        $riwayat_organisasi = $pegawai->riwayatOrganisasi;

        return view('backend.pegawai.riwayat_organisasi', compact('pegawai', 'riwayat_organisasi'));
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
        $org = RiwayatOrganisasi::findOrFail($id);
        // 🔍 Validasi data edit
        $request->validate([
            'organisasi' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'masa_jabatan' => 'required|string|max:255',
            'no_sk' => 'required|string|max:100|unique:riwayat_organisasi,no_sk,' . $id,
            'tgl_sk' => 'required|date',
            'pejabat_penetap' => 'required|string|max:255',
        ], [
            'no_sk.unique' => 'Nomor SK sudah digunakan / Nomor SK harus berbeda dengan yang lain.',
        ]);

        // ✅ Update data
        $org->update([
            'organisasi' => $request->organisasi,
            'jabatan' => $request->jabatan,
            'masa_jabatan' => $request->masa_jabatan,
            'no_sk' => $request->no_sk,
            'tgl_sk' => $request->tgl_sk,
            'pejabat_penetap' => $request->pejabat_penetap,
        ]);

        return redirect()->route('backend.organisasi.show', $request->pegawai_id) ->with('success', '✅ Data Riwayat Organisasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $riwayat_organisasi = RiwayatOrganisasi::findOrFail($id);
        $riwayat_organisasi->delete(); // ✅ Hapus data riwayat organisasi (soft delete)

        return redirect()->back()->with('success', '✅ Data Riwayat Organisasi berhasil dihapus.');
    }
}
