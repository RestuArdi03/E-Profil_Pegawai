<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiwayatPlhPlt;
use App\Models\Pegawai;

class PlhPltController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pegawaiId = auth()->user()->pegawai_id;
        $riwayat_plh_plt = RiwayatPlhPlt::with('pegawai')->where('pegawai_id', $pegawaiId)->get();
        return view('frontend.plh_plt', compact('riwayat_plh_plt'));
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
            'no_sprint' => 'required|string|max:100',
            'tgl_sprint' => 'required|date',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date',
            'jabatan_plh_plt' => 'required|string|max:255',
        ]);

        // ✅ Simpan Riwayat PLH/PLT
        RiwayatPlhPlt::create([
            'pegawai_id' => $request->pegawai_id,
            'no_sprint' => $request->no_sprint,
            'tgl_sprint' => $request->tgl_sprint,
            'tgl_mulai' => $request->tgl_mulai,
            'tgl_selesai' => $request->tgl_selesai,
            'jabatan_plh_plt' => $request->jabatan_plh_plt,
        ]);

        return redirect()->route('backend.plh_plt.show', $request->pegawai_id)
            ->with('success', '✅ Data Riwayat PLH/PLT berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        session(['pegawai_id' => $id]);

        $pegawai = Pegawai::with('riwayatPlhPlt')->findOrFail($id);
        $riwayat_plh_plt = $pegawai->riwayatPlhPlt;

        return view('backend.pegawai.riwayat_plh_plt', compact('pegawai', 'riwayat_plh_plt'));
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
        $rpp = RiwayatPlhPlt::findOrFail($id);
        // 🔍 Validasi data edit
        $request->validate([
            'no_sprint' => 'required|string|max:100',
            'tgl_sprint' => 'required|date',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date',
            'jabatan_plh_plt' => 'required|string|max:255',
        ]);

        // ✅ Update data
        $rpp->update([
            'pegawai_id' => $request->pegawai_id,
            'no_sprint' => $request->no_sprint,
            'tgl_sprint' => $request->tgl_sprint,
            'tgl_mulai' => $request->tgl_mulai,
            'tgl_selesai' => $request->tgl_selesai,
            'jabatan_plh_plt' => $request->jabatan_plh_plt,
        ]);

        return redirect()->route('backend.plh_plt.show', $request->pegawai_id)
            ->with('success', '✅ Data Riwayat PLH/PLT berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $riwayat_plh_plt = RiwayatPlhPlt::findOrFail($id);
        $riwayat_plh_plt->delete(); // ✅ Hapus data Riwayat PLH/PLT (soft delete)

        return redirect()->back()->with('success', '✅ Data Riwayat PLH/PLT berhasil dihapus.');
    }
}
