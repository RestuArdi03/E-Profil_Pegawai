<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Folder;

class DaftarFolderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) // <-- Terima objek Request
    {
        // Tentukan kolom pengurutan berdasarkan input pengguna (default: created_at)
        $sortBy = $request->get('sort_by', 'created_at'); 
        
        // Tentukan arah pengurutan (default: descending)
        $sortDirection = $request->get('direction', 'desc');

        // Pastikan input valid (opsional, tetapi disarankan)
        $allowedColumns = ['created_at', 'updated_at', 'nm_folder'];
        if (!in_array($sortBy, $allowedColumns)) {
            $sortBy = 'created_at';
        }
        
        $folder = Folder::orderBy($sortBy, $sortDirection)
                            ->paginate(10)
                            ->withQueryString(); // <-- Wajib untuk mempertahankan filter saat navigasi

        return view('backend.daftar_folder', compact('folder', 'sortBy', 'sortDirection'));
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
            'nm_folder' => 'required|string|max:50',
        ]);

        // ✅ Simpan data folder
        Folder::create([
            'nm_folder' => $request->nm_folder,
        ]);

        return redirect()->route('backend.daftar_folder')
            ->with('success', '✅ Data Folder berhasil ditambahkan.');
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
        'nm_folder' => 'required|string|max:50',
        ]);

        $folder = Folder::findOrFail($id);
        $folder->nm_folder = $request->nm_folder;
        $folder->save();

        return redirect()->route('backend.daftar_folder')->with('success', '✅ Data Folder berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $folder = Folder::findOrFail($id);
        $folder->delete(); // ✅ Hapus data folder (soft delete)

        return redirect()->back()->with('success', '✅ Data Folder berhasil dihapus.');
    }
}
