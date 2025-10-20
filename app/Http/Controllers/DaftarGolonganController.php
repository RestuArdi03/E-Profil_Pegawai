<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Golongan;

class DaftarGolonganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $golongan = Golongan::all();
        return view('backend.daftar_golongan', compact('golongan'));
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
            'golru' => 'required|string|unique:golongan,golru|max:50',
        ],[
            'golru.unique' => 'Golru sudah terdaftar',
        ]);

        // ✅ Simpan data golongan
        Golongan::create([
            'golru' => $request->golru,
        ]);

        return redirect()->route('backend.daftar_golongan')
            ->with('success', '✅ Data Golongan berhasil ditambahkan.');
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
        'golru' => 'required|string|unique:golongan,golru|max:50,' . $id,
        ],[
            'golru.unique' => 'Golru sudah terdaftar',
        ]);

        $golongan = Golongan::findOrFail($id);
        $golongan->golru = $request->golru;
        $golongan->save();

        return redirect()->route('backend.daftar_golongan')->with('success', '✅ Data Golongan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $golongan = Golongan::findOrFail($id);
        $golongan->delete(); // ✅ Hapus data golongan (soft delete)

        return redirect()->back()->with('success', '✅ Data Golongan berhasil dihapus.');
    }
}
