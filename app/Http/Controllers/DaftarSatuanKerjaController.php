<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UnitKerja;
use App\Models\SatuanKerja;

class DaftarSatuanKerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexByUnitKerja(string $unit_kerja_id)
    {
        // 1. Ambil data Unit Kerja untuk ditampilkan di header
        $unitKerja = UnitKerja::findOrFail($unit_kerja_id);

        // 2. Ambil semua Satuan Kerja yang terkait
        $satuanKerja = SatuanKerja::where('unit_kerja_id', $unit_kerja_id)->get();

        // BARIS KRUSIAL: Menyimpan ID unit kerja yang sedang dilihat ke session
        session(['unit_kerja_id' => $unit_kerja_id]);
        
        // 3. Kirim data ke view
        return view('backend.daftar_satuan_kerja', compact('unitKerja', 'satuanKerja'));
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
        $request->validate([
            'nm_satuan_kerja' => 'required|string|unique:satuan_kerja,nm_satuan_kerja|max:50',
            'unit_kerja_id' => 'required|exists:unit_kerja,id',
        ],[
            'nm_satuan_kerja.unique' => 'Nama satuan kerja sudah terdaftar',
        ]);

        SatuanKerja::create([
            'nm_satuan_kerja' => $request->nm_satuan_kerja,
            'unit_kerja_id' => $request->unit_kerja_id,
        ]);

        // Redirect kembali ke daftar Satuan Kerja yang baru dilihat
        return redirect()->route('backend.satuan_kerja.by_unit_kerja', $request->unit_kerja_id)
                        ->with('success', '✅ Data Satuan Kerja berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        $request->validate([
            'nm_satuan_kerja' => 'required|string|unique:satuan_kerja,nm_satuan_kerja|max:50,' .$id,
            'unit_kerja_id' => 'required|exists:unit_kerja,id',
        ],[
            'nm_satuan_kerja.unique' => 'Nama satuan kerja sudah terdaftar',
        ]);

        $satuanKerja = SatuanKerja::findOrFail($id);
        $satuanKerja->nm_satuan_kerja = $request->nm_satuan_kerja;
        $satuanKerja->unit_kerja_id = $request->unit_kerja_id;
        $satuanKerja->save();

        // Redirect kembali ke daftar Satuan Kerja yang bersangkutan
        return redirect()->route('backend.satuan_kerja.by_unit_kerja', $request->unit_kerja_id)
                        ->with('success', '✅ Data Satuan Kerja berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        SatuanKerja::findOrFail($id)->delete();
        return redirect()->back()->with('success', '✅ Data Satuan Kerja berhasil dihapus.');
    }
}
