<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Strata;

class DaftarStrataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $strata = Strata::all();
        return view('backend.daftar_strata', compact('strata'));
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
            'nm_strata' => 'required|string|max:50',
            'jurusan' => 'required|string|max:50',
        ]);

        // ✅ Simpan data strata
        Strata::create([
            'nm_strata' => $request->nm_strata,
            'jurusan' => $request->jurusan,
        ]);

        return redirect()->route('backend.daftar_strata')
            ->with('success', '✅ Data Strata berhasil ditambahkan.');
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
        'nm_strata' => 'required|string|max:50',
        'jurusan' => 'required|string|max:50',
        ]);

        $strata = Strata::findOrFail($id);
        $strata->nm_strata = $request->nm_strata;
        $strata->jurusan = $request->jurusan;
        $strata->save();

        return redirect()->route('backend.daftar_strata')->with('success', '✅ Data Strata berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $strata = Strata::findOrFail($id);
        $strata->delete(); // ✅ Hapus data strata (soft delete)

        return redirect()->back()->with('success', '✅ Data Strata berhasil dihapus.');
    }
}
