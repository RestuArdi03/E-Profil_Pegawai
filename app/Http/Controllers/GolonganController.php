<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiwayatGolongan;
use App\Models\Golongan;
use App\Models\Pegawai;
use Carbon\Carbon;

class GolonganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pegawaiId = auth()->user()->pegawai_id;
        $riwayat_golongan = RiwayatGolongan::with('pegawai', 'golongan')->where('pegawai_id', $pegawaiId)->get();
        return view('frontend.golongan', compact('riwayat_golongan'));
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
            'golongan_id' => 'required',
            'tmt_golongan' => 'required|date',
            'no_sk' => 'required|string|max:100|unique:riwayat_golongan,no_sk',
            'tgl_sk' => 'required|date',
            'pejabat' => 'required|string|max:100',
        ], [
            'no_sk.unique' => 'Nomor SK sudah digunakan / Nomor SK harus berbeda dengan yang lain.',
        ]);

        // Perhitungan masa kerja
        $tmt = Carbon::parse($request->tmt_golongan);
        $now = Carbon::now();

        $tahun = $tmt->diffInYears($now);
        $bulan = $tmt->copy()->addYears($tahun)->diffInMonths($now);

        // Format modular: "10 tahun 3 bulan"
        $masaKerja = $tahun . ' Tahun ' . $bulan . ' Bulan';

        // ✅ Simpan riwayat golongan
        RiwayatGolongan::create([
            'pegawai_id' => $request->pegawai_id,
            'golongan_id' => $request->golongan_id,
            'tmt_golongan' => $request->tmt_golongan,
            'no_sk' => $request->no_sk,
            'tgl_sk' => $request->tgl_sk,
            'masa_kerja' => $masaKerja,
            'pejabat' => $request->pejabat,
        ]);

        return redirect()->route('backend.riwayat_golongan.show', $request->pegawai_id)
            ->with('success', '✅ Data Riwayat Golongan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pegawai = Pegawai::with('riwayatGolongan')->findOrFail($id);
        $golongan = Golongan::all();
        return view('backend.pegawai.riwayat_golongan', compact('pegawai', 'golongan'));
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
        $gol = RiwayatGolongan::findOrFail($id);
        // 🔍 Validasi data edit
        $request->validate([
            'golongan_id' => 'required',
            'tmt_golongan' => 'required|date',
            'no_sk' => 'required|string|max:100',
            'tgl_sk' => 'required|date',
            'pejabat' => 'required|string|max:100',
        ], [
            'no_sk.unique' => 'Nomor SK sudah digunakan / Nomor SK harus berbeda dengan yang lain.',
        ]);

        // ✅ Update data
        $gol->update([
            'golongan_id' => $request->golongan_id,
            'tmt_golongan' => $request->tmt_golongan,
            'no_sk' => $request->no_sk,
            'tgl_sk' => $request->tgl_sk,
            'pejabat' => $request->pejabat,
        ]);

        return redirect()->route('backend.riwayat_golongan.show', $request->pegawai_id) ->with('success', '✅ Data Riwayat Golongan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $riwayat_golongan = RiwayatGolongan::findOrFail($id);
        $riwayat_golongan->delete(); // ✅ Hapus data riwayat golongan (soft delete)

        return redirect()->back()->with('success', '✅ Data Riwayat Golongan berhasil dihapus.');
    }
}
