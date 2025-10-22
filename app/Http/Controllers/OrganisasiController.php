<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiwayatOrganisasi;
use App\Models\Pegawai;

class OrganisasiController extends Controller
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
        $riwayat_organisasi = RiwayatOrganisasi::where('pegawai_id', $pegawaiId) // Filter berdasarkan ID User yang login
                                                ->orderBy($sortBy, $sortDirection) // Terapkan sorting
                                                ->paginate(10) // Terapkan pagination
                                                ->withQueryString(); // Pertahankan parameter filter

        // 4. Kembalikan View (Kirim variabel sorting/filtering)
        return view('frontend.organisasi', compact(
            'riwayat_organisasi', 
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
            'organisasi' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'masa_jabatan' => 'required|string|max:255',
            'no_sk' => 'required|string|max:100|unique:riwayat_organisasi,no_sk',
            'tgl_sk' => 'required|date',
            'pejabat_penetap' => 'required|string|max:255',
        ], [
            'no_sk.unique' => 'Nomor SK sudah digunakan / Nomor SK harus berbeda dengan yang lain.',
        ]);

        // ✅ Simpan riwayat organisasi
        RiwayatOrganisasi::create([
            'pegawai_id' => $request->pegawai_id,
            'organisasi' => $request->organisasi,
            'jabatan' => $request->jabatan,
            'masa_jabatan' => $request->masa_jabatan,
            'no_sk' => $request->no_sk,
            'tgl_sk' => $request->tgl_sk,
            'pejabat_penetap' => $request->pejabat_penetap,
        ]);

        return redirect()->route('backend.organisasi.show', $request->pegawai_id)
            ->with('success', '✅ Data Riwayat Organisasi berhasil ditambahkan.');
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
        
        $riwayat_organisasi = RiwayatOrganisasi::where('pegawai_id', $id)
                                        ->orderBy($sortBy, $sortDirection)
                                        ->paginate(10)
                                        ->withQueryString();

        // --- 4. Kembalikan View ---
        return view('backend.pegawai.riwayat_organisasi', compact('pegawai', 'riwayat_organisasi', 'sortBy', 'sortDirection'));
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
        $org = RiwayatOrganisasi::findOrFail($id);
        // 🔍 Validasi data edit
        $request->validate([
            'organisasi' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'masa_jabatan' => 'required|string|max:255',
            'no_sk' => 'required|string|max:100|unique:riwayat_organisasi,no_sk,' . $id,
            'tgl_sk' => 'required|date',
            'pejabat_penetap' => 'required|string|max:255',
        ], [
            'no_sk.unique' => 'Nomor SK sudah digunakan / Nomor SK harus berbeda dengan yang lain.',
        ]);

        // ✅ Update data
        $org->update([
            'organisasi' => $request->organisasi,
            'jabatan' => $request->jabatan,
            'masa_jabatan' => $request->masa_jabatan,
            'no_sk' => $request->no_sk,
            'tgl_sk' => $request->tgl_sk,
            'pejabat_penetap' => $request->pejabat_penetap,
        ]);

        return redirect()->route('backend.organisasi.show', $request->pegawai_id) ->with('success', '✅ Data Riwayat Organisasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $riwayat_organisasi = RiwayatOrganisasi::findOrFail($id);
        $riwayat_organisasi->delete(); // ✅ Hapus data riwayat organisasi (soft delete)

        return redirect()->back()->with('success', '✅ Data Riwayat Organisasi berhasil dihapus.');
    }
}
