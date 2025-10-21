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
    public function indexByInstansi(Request $request, string $instansi_id) // <-- Terima Request & ID
    {
        // --- 1. Amankan ID dan Simpan ke Session ---
        
        // Prioritaskan old('instansi_id') jika ada, lalu ID dari URL
        $id = old('instansi_id', $instansi_id); 
        
        // Ambil data Instansi (Gunakan findOrFail karena ID Instansi wajib ada)
        $instansi = Instansi::findOrFail($id); 

        // BARIS KRUSIAL: Menyimpan ID Instansi yang sedang dilihat ke session
        session(['instansi_id' => $instansi_id]); 


        // --- 2. Logika Sorting dan Filtering (Diambil dari Index Golongan) ---
        
        $sortBy = $request->get('sort_by', 'created_at'); 
        $sortDirection = $request->get('direction', 'desc');

        // Tentukan kolom yang diizinkan untuk diurutkan di tabel unit_kerja
        $allowedColumns = ['created_at', 'updated_at', 'nm_unit_kerja']; // <-- Sesuaikan kolom Unit Kerja
        
        if (!in_array($sortBy, $allowedColumns)) {
            $sortBy = 'created_at';
        }


        // --- 3. Eksekusi Query dengan Filter dan Pagination ---
        
        $unitKerja = UnitKerja::where('instansi_id', $id) // <-- Filter berdasarkan Instansi ID
                            ->orderBy($sortBy, $sortDirection)
                            ->paginate(10)
                            ->withQueryString(); // <-- Pertahankan parameter filter saat navigasi
        
        // Ganti variabel $unitKerja yang lama dengan hasil pagination
        
        // --- 4. Kembalikan View ---
        return view('backend.daftar_unit_kerja', compact('instansi', 'unitKerja', 'sortBy', 'sortDirection'));
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
