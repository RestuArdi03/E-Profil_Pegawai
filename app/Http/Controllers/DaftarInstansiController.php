<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instansi;

class DaftarInstansiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $instansi = Instansi::all();
        return view('backend.daftar_instansi', compact('instansi'));
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
        //🔍 Validasi field wajib diisi
        $request->validate([
            'nm_instansi' => 'required|string|unique:instansi,nm_instansi|max:50',
        ],[
            'nm_instansi.unique' => 'Nama instansi sudah terdaftar',
        ]);

        // ✅ Simpan data instansi
        Instansi::create([
            'nm_instansi' => $request->nm_instansi,
        ]);

        return redirect()->route('backend.daftar_instansi')
            ->with('success', '✅ Data Instansi berhasil ditambahkan.');
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
        'nm_instansi' => 'required|string|unique:instansi,nm_instansi|max:50,' . $id,
        ],[
            'nm_instansi.unique' => 'Nama instansi sudah terdaftar',
        ]);

        $instansi = Instansi::findOrFail($id);
        $instansi->nm_instansi = $request->nm_instansi;
        $instansi->save();

        return redirect()->route('backend.daftar_instansi')->with('success', '✅ Data Instansi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $instansi = Instansi::findOrFail($id);
        $instansi->delete(); // ✅ Hapus data instansi (soft delete)

        return redirect()->back()->with('success', '✅ Data Instansi berhasil dihapus.');
    }
}
