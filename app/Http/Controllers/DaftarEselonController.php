<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Eselon;

class DaftarEselonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $eselon = Eselon::all();
        return view('backend.daftar_eselon', compact('eselon'));
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
            'nm_eselon' => 'required|string|max:50',
        ]);

        // ✅ Simpan data agama
        Eselon::create([
            'nm_eselon' => $request->nm_eselon,
        ]);

        return redirect()->route('backend.daftar_eselon')
            ->with('success', '✅ Data Eselon berhasil ditambahkan.');
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
        'nm_eselon' => 'required|string|max:50',
        ]);

        $eselon = Eselon::findOrFail($id);
        $eselon->nm_eselon = $request->nm_eselon;
        $eselon->save();

        return redirect()->route('backend.daftar_eselon')->with('success', '✅ Data Eselon berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $eselon = Eselon::findOrFail($id);
        $eselon->delete(); // ✅ Hapus data eselon (soft delete)

        return redirect()->back()->with('success', '✅ Data Eselon berhasil dihapus.');
    }
}
