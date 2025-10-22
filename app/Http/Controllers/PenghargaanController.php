<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiwayatPenghargaan;
use App\Models\Pegawai;

class PenghargaanController extends Controller
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
        $riwayat_penghargaan = RiwayatPenghargaan::where('pegawai_id', $pegawaiId) // Filter berdasarkan ID User yang login
                                                ->orderBy($sortBy, $sortDirection) // Terapkan sorting
                                                ->paginate(10) // Terapkan pagination
                                                ->withQueryString(); // Pertahankan parameter filter

        // 4. Kembalikan View (Kirim variabel sorting/filtering)
        return view('frontend.penghargaan', compact(
            'riwayat_penghargaan', 
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
            'pegawai_id' => 'required|exists:pegawai,id',
            'nm_penghargaan' => 'required|string|max:255',
            'no_urut' => 'required|string|max:25',
            'no_sertifikat' => 'required|string|max:100|unique:riwayat_penghargaan,no_sertifikat',
            'tgl_sertifikat' => 'required|date',
            'pejabat_penetap' => 'required|string|max:255',
            'link' => 'required|url|max:255',
        ],[
            'no_sertifikat.unique' => 'Nomor sertifikat sudah digunakan / Nomor sertifikat harus berbeda dengan yang lain.',
        ]);

        // ✅ Simpan riwayat penghargaan
        RiwayatPenghargaan::create([
            'pegawai_id' => $request->pegawai_id,
            'nm_penghargaan' => $request->nm_penghargaan,
            'no_urut' => $request->no_urut,
            'no_sertifikat' => $request->no_sertifikat,
            'tgl_sertifikat' => $request->tgl_sertifikat,
            'pejabat_penetap' => $request->pejabat_penetap,
            'link' => $request->link,
        ]);

        return redirect()->route('backend.penghargaan.show', $request->pegawai_id)
            ->with('success', '✅ Data Riwayat Penghargaan berhasil ditambahkan.');
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
        
        $riwayat_penghargaan = RiwayatPenghargaan::where('pegawai_id', $id)
                                        ->orderBy($sortBy, $sortDirection)
                                        ->paginate(10)
                                        ->withQueryString();

        // --- 4. Kembalikan View ---
        return view('backend.pegawai.riwayat_penghargaan', compact('pegawai', 'riwayat_penghargaan', 'sortBy', 'sortDirection'));
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
        $rph = RiwayatPenghargaan::findOrFail($id);
        // 🔍 Validasi data edit
        $request->validate([
            'nm_penghargaan' => 'required|string|max:255',
            'no_urut' => 'required|string|max:25',
            'no_sertifikat' => 'required|string|max:100|unique:riwayat_penghargaan,no_sertifikat,' . $id,
            'tgl_sertifikat' => 'required|date',
            'pejabat_penetap' => 'required|string|max:255',
            'link' => 'required|url|max:255',
        ],[
            'no_sertifikat.unique' => 'Nomor sertifikat sudah digunakan / Nomor sertifikat harus berbeda dengan yang lain.',
        ]);

        // ✅ Update data
        $rph->update([
            'nm_penghargaan' => $request->nm_penghargaan,
            'no_urut' => $request->no_urut,
            'no_sertifikat' => $request->no_sertifikat,
            'tgl_sertifikat' => $request->tgl_sertifikat,
            'pejabat_penetap' => $request->pejabat_penetap,
            'link' => $request->link,
        ]);

        return redirect()->route('backend.penghargaan.show', $request->pegawai_id) ->with('success', '✅ Data Riwayat Penghargaan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $riwayat_penghargaan = RiwayatPenghargaan::findOrFail($id);
        $riwayat_penghargaan->delete(); // ✅ Hapus data riwayat penghargaan (soft delete)

        return redirect()->back()->with('success', '✅ Data Riwayat Penghargaan berhasil dihapus.');
    }
}
