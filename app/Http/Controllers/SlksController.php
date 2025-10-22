<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiwayatSlks;
use App\Models\Pegawai;

class SlksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // 1. Ambil ID Pegawai dari user yang sedang login (HANYA INI YANG BERBEDA)
        $pegawaiId = auth()->user()->pegawai_id;

        // 2. Logika Sorting dan Filtering
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('direction', 'desc');

        // Tentukan kolom yang diizinkan untuk diurutkan
        $allowedColumns = ['created_at', 'updated_at']; 
        
        if (!in_array($sortBy, $allowedColumns)) {
            $sortBy = 'created_at';
        }

        // Pastikan arah pengurutan selalu 'asc' atau 'desc'
        $sortDirection = (strtolower($sortDirection) == 'asc') ? 'asc' : 'desc';

        // 3. Eksekusi Query dengan Filter, Pagination, dan Sorting
        $riwayat_slks = RiwayatSlks::where('pegawai_id', $pegawaiId) // Filter berdasarkan ID User yang login
                                                ->orderBy($sortBy, $sortDirection) // Terapkan sorting
                                                ->paginate(10) // Terapkan pagination
                                                ->withQueryString(); // Pertahankan parameter filter

        // 4. Kembalikan View (Kirim variabel sorting/filtering)
        return view('frontend.slks', compact(
            'riwayat_slks',  
            'sortBy', 
            'sortDirection'
        ));
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
        // 🔍 Validasi field wajib diisi
        $request->validate([
            'slks' => 'required|string|max:255',
            'no_kepres' => 'nullable|string|max:100|unique:riwayat_slks,no_kepres',
            'tgl_kepres' => 'required|date',
            'status' => 'required|string|max:50',
        ], [
            'no_kepres.unique' => 'Nomor SLKS sudah digunakan / Nomor SLKS harus berbeda dengan yang lain.',
        ]);

        // ✅ Simpan riwayat SLKS
        RiwayatSlks::create([
            'pegawai_id' => $request->pegawai_id,
            'slks' => $request->slks,
            'no_kepres' => $request->no_kepres,
            'tgl_kepres' => $request->tgl_kepres,
            'pimpinan' => $request->pimpinan,
            'status' => $request->status,
        ]);

        return redirect()->route('backend.slks.show', $request->pegawai_id)
            ->with('success', '✅ Data Riwayat SLKS berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        // Amankan ID Pegawai di session
        session(['pegawai_id' => $id]); 

        // 1. Ambil data satu Pegawai (Wajib untuk Header Profil)
        $pegawai = Pegawai::findOrFail($id);
        
        // --- 2. Logika Sorting (Tetap sama) ---
        $sortBy = $request->get('sort_by', 'created_at'); 
        $sortDirection = $request->get('direction', 'desc');

        // Kolom yang diizinkan untuk diurutkan di tabel
        $allowedColumns = ['created_at', 'updated_at'];
        
        if (!in_array($sortBy, $allowedColumns)) {
            $sortBy = 'created_at';
        }
        $sortDirection = (strtolower($sortDirection) == 'asc') ? 'asc' : 'desc';

        // --- 3. Eksekusi Query ---
        
        $riwayat_slks = RiwayatSlks::where('pegawai_id', $id)
                                        ->orderBy($sortBy, $sortDirection)
                                        ->paginate(10)
                                        ->withQueryString();

        // --- 4. Kembalikan View ---
        return view('backend.pegawai.riwayat_slks', compact('pegawai', 'riwayat_slks', 'sortBy', 'sortDirection'));
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
        $slks = RiwayatSlks::findOrFail($id);
        // 🔍 Validasi data edit
        $request->validate([
            'slks' => 'required|string|max:255',
            'no_kepres' => 'nullable|string|max:100|unique:riwayat_slks,no_kepres,' . $id,
            'tgl_kepres' => 'required|date',
            'status' => 'required|string|max:50',
        ], [
            'no_kepres.unique' => 'Nomor SLKS sudah digunakan / Nomor SLKS harus berbeda dengan yang lain.',
        ]);

        // ✅ Update data
        $slks->update([
            'slks' => $request->slks,
            'no_kepres' => $request->no_kepres,
            'tgl_kepres' => $request->tgl_kepres,
            'pimpinan' => $request->pimpinan,
            'status' => $request->status,
        ]);

        return redirect()->route('backend.slks.show', $request->pegawai_id) ->with('success', '✅ Data Riwayat SLKS berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $riwayat_slks = RiwayatSlks::findOrFail($id);
        $riwayat_slks->delete(); // ✅ Hapus data riwayat slks (soft delete)

        return redirect()->back()->with('success', '✅ Data Riwayat SLKS berhasil dihapus.');
    }
}
