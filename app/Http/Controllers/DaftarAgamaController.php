<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agama;

class DaftarAgamaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $agama = Agama::all();
        return view('backend.daftar_agama', compact('agama'));
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
            'nm_agama' => 'required|string|max:50',
        ]);

        // ✅ Simpan data agama
        Agama::create([
            'nm_agama' => $request->nm_agama,
        ]);

        return redirect()->route('backend.daftar_agama')
            ->with('success', '✅ Data Agama berhasil ditambahkan.');
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
        'nm_agama' => 'required|string|max:50',
        ]);

        $agama = Agama::findOrFail($id);
        $agama->nm_agama = $request->nm_agama;
        $agama->save();

        return redirect()->route('backend.daftar_agama')->with('success', '✅ Data Agama berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $agama = Agama::findOrFail($id);
        $agama->delete(); // ✅ Hapus data agama (soft delete)

        return redirect()->back()->with('success', '✅ Data Agama berhasil dihapus.');
    }
}
