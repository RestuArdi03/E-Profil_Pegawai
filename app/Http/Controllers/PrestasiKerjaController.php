<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NilaiPrestasiKerja;
use App\Models\Pegawai;

class PrestasiKerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pegawaiId = auth()->user()->pegawai_id;
        $nilai_prestasi_kerja = NilaiPrestasiKerja::with('pegawai')->where('pegawai_id', $pegawaiId)->get();
        return view('frontend.prestasi', compact('nilai_prestasi_kerja'));
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
            'tahun' => 'required|digits:4|integer|min:1950|max:' . date('Y'),
            'skp' => 'required|string|max:100',
            'nilai_prestasi_kerja' => 'required|string|max:255',
            'nilai_perilaku_kerja' => 'required|string|max:255',
            'klasifikasi_nilai' => 'required|string|max:100',
            'pejabat_penilai' => 'required|string|max:50',
        ]);

        // ✅ Simpan nilai prestasi kerja
        NilaiPrestasiKerja::create([
            'pegawai_id' => $request->pegawai_id,
            'tahun' => $request->tahun,
            'skp' => $request->skp,
            'nilai_prestasi_kerja' => $request->nilai_prestasi_kerja,
            'nilai_perilaku_kerja' => $request->nilai_perilaku_kerja,
            'klasifikasi_nilai' => $request->klasifikasi_nilai,
            'pejabat_penilai' => $request->pejabat_penilai,
        ]);

        return redirect()->route('backend.prestasiKerja.show', $request->pegawai_id)
            ->with('success', '✅ Data Nilai Prestasi Kerja berhasil ditambahkan.');
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
        
        $nilai_prestasi_kerja = NilaiPrestasiKerja::where('pegawai_id', $id)
                                        ->orderBy($sortBy, $sortDirection)
                                        ->paginate(10)
                                        ->withQueryString();

        // --- 4. Kembalikan View ---
        return view('backend.pegawai.nilai_prestasi_kerja', compact('pegawai', 'nilai_prestasi_kerja', 'sortBy', 'sortDirection'));
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
        $nilai = NilaiPrestasiKerja::findOrFail($id);
        // 🔍 Validasi data edit
        $request->validate([
            'tahun' => 'required|digits:4|integer|min:1950|max:' . date('Y'),
            'skp' => 'required|string|max:100',
            'nilai_prestasi_kerja' => 'required|string|max:255',
            'nilai_perilaku_kerja' => 'required|string|max:255',
            'klasifikasi_nilai' => 'required|string|max:100',
            'pejabat_penilai' => 'required|string|max:50',
        ]);

        // ✅ Update data
        $nilai->update([
            'tahun' => $request->tahun,
            'skp' => $request->skp,
            'nilai_prestasi_kerja' => $request->nilai_prestasi_kerja,
            'nilai_perilaku_kerja' => $request->nilai_perilaku_kerja,
            'klasifikasi_nilai' => $request->klasifikasi_nilai,
            'pejabat_penilai' => $request->pejabat_penilai,
        ]);

        return redirect()->route('backend.prestasiKerja.show', $request->pegawai_id) ->with('success', '✅ Data Nilairestasi Kerja berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $nilai_prestasi_kerja = NilaiPrestasiKerja::findOrFail($id);
        $nilai_prestasi_kerja->delete(); // ✅ Hapus data nilai prestasi kerja (soft delete)

        return redirect()->back()->with('success', '✅ Data NIlai Prestasi Kerja berhasil dihapus.');
    }
}
