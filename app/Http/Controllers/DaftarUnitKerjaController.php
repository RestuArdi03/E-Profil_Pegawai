<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instansi;
use App\Models\UnitKerja;

class DaftarUnitKerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexByInstansi(string $instansi_id)
    {
        // Cek apakah ada old instansi_id yang dikirim setelah gagal validasi
        $id = old('instansi_id', $instansi_id); 
        
        // Ambil data Instansi (gunakan find() atau first() untuk menghindari 404 jika ID palsu)
        $instansi = Instansi::findOrFail($id); 

        // BARIS KRUSIAL: Menyimpan ID Instansi yang sedang dilihat ke session
        session(['instansi_id' => $instansi_id]);

        // Ambil Unit Kerja berdasarkan ID yang benar
        $unitKerja = UnitKerja::where('instansi_id', $id)->get();
        
        return view('backend.daftar_unit_kerja', compact('instansi', 'unitKerja'));
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
        // 1. Validasi Input
        $request->validate([
            'nm_unit_kerja' => 'required|string|unique:unit_kerja,nm_unit_kerja|max:50',
            // Pastikan instansi_id ada dan merujuk ke ID yang valid di tabel instansi
            'instansi_id' => 'required|exists:instansi,id', 
        ],[
            'nm_unit_kerja.unique' => 'Nama unit kerja sudah terdaftar',
        ]);

        // 2. Simpan Data Baru
        UnitKerja::create([
            'nm_unit_kerja' => $request->nm_unit_kerja,
            'instansi_id' => $request->instansi_id,
        ]);

        // 3. Redirect ke halaman Instansi (atau ke halaman Unit Kerja jika sudah dibuat)
        // Asumsi: Redirect kembali ke daftar Unit Kerja yang baru dilihat, menggunakan instansi_id
        return redirect()->route('backend.unit_kerja.by_instansi', $request->instansi_id)
                        ->with('success', '✅ Unit Kerja berhasil ditambahkan.');
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
        // 1. Validasi Input
        $request->validate([
            'nm_unit_kerja' => 'required|string|unique:unit_kerja,nm_unit_kerja|max:50,' .$id,
            // instansi_id tetap divalidasi, tetapi nilainya tidak wajib diubah oleh user
            'instansi_id' => 'required|exists:instansi,id', 
        ],[
            'nm_unit_kerja.unique' => 'Nama unit kerja sudah terdaftar',
        ]);

        // 2. Temukan data lama berdasarkan ID
        $unitKerja = UnitKerja::findOrFail($id);

        // 3. Perbarui Data
        $unitKerja->nm_unit_kerja = $request->nm_unit_kerja;
        $unitKerja->instansi_id = $request->instansi_id;
        $unitKerja->save();

        // 4. Redirect kembali ke daftar Unit Kerja yang bersangkutan
        return redirect()->route('backend.unit_kerja.by_instansi', $request->instansi_id)
                        ->with('success', '✅ Unit Kerja berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $unitKerja = UnitKerja::findOrFail($id);
        $unitKerja->delete(); //✅ Hapus data unit kerja (soft delete)
        
        return redirect()->back()->with('success', '✅ Data Unit Kerja berhasil dihapus.');
    }
}
