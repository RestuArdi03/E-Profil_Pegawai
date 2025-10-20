<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisJabatan;

class DaftarJabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jenis_jabatan = JenisJabatan::all();
        return view('backend.daftar_jabatan', compact('jenis_jabatan'));
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
            'jenis_jabatan' => 'required|string|unique:jenis_jabatan,jenis_jabatan|max:50',
        ],[
            'jenis_jabatan.unique' => 'Jenis jabatan sudah terdaftar',
        ]);

        // ✅ Simpan data jabatan
        JenisJabatan::create([
            'jenis_jabatan' => $request->jenis_jabatan,
        ]);

        return redirect()->route('backend.daftar_jabatan')
            ->with('success', '✅ Data Jabatan berhasil ditambahkan.');
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
        'jenis_jabatan' => 'required|string|unique:jenis_jabatan,jenis_jabatan|max:50,' . $id,
        ],[
            'jenis_jabatan.unique' => 'Jenis jabatan sudah terdaftar',
        ]);

        $jenis_jabatan = JenisJabatan::findOrFail($id);
        $jenis_jabatan->jenis_jabatan = $request->jenis_jabatan;
        $jenis_jabatan->save();

        return redirect()->route('backend.daftar_jabatan')->with('success', '✅ Data Jabatan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jenis_jabatan = JenisJabatan::findOrFail($id);
        $jenis_jabatan->delete(); // ✅ Hapus data jabatan (soft delete)

        return redirect()->back()->with('success', '✅ Data Jabatan berhasil dihapus.');
    }
}
