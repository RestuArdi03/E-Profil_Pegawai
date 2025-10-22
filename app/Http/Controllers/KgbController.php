<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiwayatKgb;
use App\Models\Pegawai;

class KgbController extends Controller
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
        $riwayat_kgb = RiwayatKgb::where('pegawai_id', $pegawaiId) // Filter berdasarkan ID User yang login
                                    ->orderBy($sortBy, $sortDirection) // Terapkan sorting
                                    ->paginate(10) // Terapkan pagination
                                    ->withQueryString(); // Pertahankan parameter filter

        // 5. Kembalikan View (Kirim variabel sorting/filtering)
        return view('frontend.kgb', compact(
            'riwayat_kgb',  
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
            'pejabat_penetap' => 'required|string|max:255',
            'no_sk' => 'required|string|max:100|unique:riwayat_kgb,no_sk',
            'tgl_sk' => 'required|date',
            'tgl_tmt' => 'required|date',
            'jml_gaji' => 'required|string|max:20',
            'ket' => 'nullable|string|max:255',
        ], [
            'no_sk.unique' => 'Nomor SK sudah digunakan / Nomor SK harus berbeda dengan yang lain.',
        ]);

        // ✅ Simpan riwayat kgb
        RiwayatKgb::create([
            'pegawai_id' => $request->pegawai_id,
            'pejabat_penetap' => $request->pejabat_penetap,
            'no_sk' => $request->no_sk,
            'tgl_sk' => $request->tgl_sk,
            'tgl_tmt' => $request->tgl_tmt,
            'jml_gaji' => $request->jml_gaji,
            'ket' => $request->ket,
        ]);

        return redirect()->route('backend.kgb.show', $request->pegawai_id)
            ->with('success', '✅ Data Riwayat KGB berhasil ditambahkan.');
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
        
        $riwayat_kgb = RiwayatKgb::where('pegawai_id', $id)
                                        ->orderBy($sortBy, $sortDirection)
                                        ->paginate(10)
                                        ->withQueryString();

        // --- 4. Kembalikan View ---
        return view('backend.pegawai.riwayat_kgb', compact('pegawai', 'riwayat_kgb', 'sortBy', 'sortDirection'));
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
        $kgb = RiwayatKgb::findOrFail($id);
        // 🔍 Validasi data edit
        $request->validate([
            'pejabat_penetap' => 'required|string|max:255',
            'no_sk' => 'required|string|max:100|unique:riwayat_kgb,no_sk,' . $id,
            'tgl_sk' => 'required|date',
            'tgl_tmt' => 'required|date',
            'jml_gaji' => 'required|string|max:20',
            'ket' => 'nullable|string|max:255',
        ], [
            'no_sk.unique' => 'Nomor SK sudah digunakan / Nomor SK harus berbeda dengan yang lain.',
        ]);

        // ✅ Update data
        $kgb->update([
            'pejabat_penetap' => $request->pejabat_penetap,
            'no_sk' => $request->no_sk,
            'tgl_sk' => $request->tgl_sk,
            'tgl_tmt' => $request->tgl_tmt,
            'jml_gaji' => $request->jml_gaji,
            'ket' => $request->ket,
        ]);

        return redirect()->route('backend.kgb.show', $request->pegawai_id) ->with('success', '✅ Data Riwayat KGB berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $riwayat_kgb = RiwayatKgb::findOrFail($id);
        $riwayat_kgb->delete(); // ✅ Hapus data riwayat kgb (soft delete)

        return redirect()->back()->with('success', '✅ Data Riwayat KGB berhasil dihapus.');
    }
}
