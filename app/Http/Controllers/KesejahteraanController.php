<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiwayatKesejahteraan;
use App\Models\Pegawai;

class KesejahteraanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pegawaiId = auth()->user()->pegawai_id;
        $riwayat_kesejahteraan = RiwayatKesejahteraan::with('pegawai')->where('pegawai_id', $pegawaiId)->get();
        return view('frontend.kesejahteraan', compact('riwayat_kesejahteraan'));
        
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
            'npwp' => 'required|string|max:100|unique:riwayat_kesejahteraan,npwp',
            'no_bpjs' => 'required|string|max:100|unique:riwayat_kesejahteraan,no_bpjs',
            'no_taspen' => 'required|string|max:100|unique:riwayat_kesejahteraan,no_taspen',
            'kepemilikan_rumah' => 'required|string|max:100',
            'kartu_pegawai_elektronik' => 'required|string|max:100',
        ], [
            'no_taspen.unique' => 'NPWP sudah digunakan / NPWP harus berbeda dengan yang lain.',
            'no_taspen.unique' => 'Nomor BPJS sudah digunakan / Nomor BPJS harus berbeda dengan yang lain.',
            'no_taspen.unique' => 'Nomor Taspen sudah digunakan / Nomor Taspen harus berbeda dengan yang lain.',
        ]);

        // ✅ Simpan riwayat kesejahteraan
        RiwayatKesejahteraan::create([
            'pegawai_id' => $request->pegawai_id,
            'npwp' => $request->npwp,
            'no_bpjs' => $request->no_bpjs,
            'no_taspen' => $request->no_taspen,
            'kepemilikan_rumah' => $request->kepemilikan_rumah,
            'kartu_pegawai_elektronik' => $request->kartu_pegawai_elektronik,
        ]);

        return redirect()->route('backend.kesejahteraan.show', $request->pegawai_id)
            ->with('success', '✅ Data Riwayat Kesejahteraan berhasil ditambahkan.');
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
        
        $riwayat_kesejahteraan = RiwayatKesejahteraan::where('pegawai_id', $id)
                                        ->orderBy($sortBy, $sortDirection)
                                        ->paginate(10)
                                        ->withQueryString();

        // --- 4. Kembalikan View ---
        return view('backend.pegawai.riwayat_kesejahteraan', compact('pegawai', 'riwayat_kesejahteraan', 'sortBy', 'sortDirection'));
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
        $data = RiwayatKesejahteraan::findOrFail($id);
        // 🔍 Validasi data edit
        $request->validate([
            'npwp' => 'required|string|max:100|unique:riwayat_kesejahteraan,npwp,' . $id,
            'no_bpjs' => 'required|string|max:100|unique:riwayat_kesejahteraan,no_bpjs,' . $id,
            'no_taspen' => 'required|string|max:100|unique:riwayat_kesejahteraan,no_taspen,' . $id,
            'kepemilikan_rumah' => 'required|string|max:100',
            'kartu_pegawai_elektronik' => 'required|string|max:100',
        ], [
            'no_taspen.unique' => 'NPWP sudah digunakan / NPWP harus berbeda dengan yang lain.',
            'no_taspen.unique' => 'Nomor BPJS sudah digunakan / Nomor BPJS harus berbeda dengan yang lain.',
            'no_taspen.unique' => 'Nomor Taspen sudah digunakan / Nomor Taspen harus berbeda dengan yang lain.',
        ]);

        // ✅ Update data
        $data->update([
            'npwp' => $request->npwp,
            'no_bpjs' => $request->no_bpjs,
            'no_taspen' => $request->no_taspen,
            'kepemilikan_rumah' => $request->kepemilikan_rumah,
            'kartu_pegawai_elektronik' => $request->kartu_pegawai_elektronik,
        ]);

        return redirect()->route('backend.kesejahteraan.show', $request->pegawai_id) ->with('success', '✅ Data Riwayat Kesejahteraan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $riwayat_kesejahteraan = RiwayatKesejahteraan::findOrFail($id);
        $riwayat_kesejahteraan->delete(); // ✅ Hapus data riwayat kesejahteraan (soft delete)

        return redirect()->back()->with('success', '✅ Data Riwayat Kesejahteraan berhasil dihapus.');
    }
}
