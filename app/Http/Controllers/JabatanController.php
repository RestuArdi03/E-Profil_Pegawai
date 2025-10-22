<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiwayatJabatan;
use App\Models\Eselon;
use App\Models\JenisJabatan;
use App\Models\Pegawai;


class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // 1. Ambil ID Pegawai dari user yang sedang login
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
        $riwayat_jabatan = RiwayatJabatan::with('eselon', 'jenis_jabatan')
                                                ->where('pegawai_id', $pegawaiId) // Filter berdasarkan ID User yang login
                                                ->orderBy($sortBy, $sortDirection) // Terapkan sorting
                                                ->paginate(10) // Terapkan pagination
                                                ->withQueryString(); // Pertahankan parameter filter

        // 4. Ambil data tambahan
        $eselon = Eselon::all(); 
        $jenis_jabatan = JenisJabatan::all();

        // 5. Kembalikan View (Kirim variabel sorting/filtering)
        return view('frontend.jabatan', compact(
            'riwayat_jabatan', 
            'eselon', 
            'jenis_jabatan', 
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
        // 🔍 Validasi input
        $request->validate([
            'pegawai_id' => 'required|exists:pegawai,id',
            'jabatan' => 'required|string|max:255',
            'tmt' => 'required|date',
            'no_sk' => 'required|string|max:100|unique:riwayat_jabatan,no_sk',
            'tgl_sk' => 'required|date',
            'pejabat_penetap' => 'required|string|max:100',
            'jenis_mutasi' => 'required|string|max:100',
            'eselon_id' => 'required|exists:eselon,id',
            'jenis_jabatan_id' => 'required|exists:jenis_jabatan,id',
        ], [
            'no_sk.unique' => 'Nomor SK sudah digunakan. Harus berbeda dari yang lain.',
        ]);

        // ✅ Simpan data riwayat jabatan
        RiwayatJabatan::create([
            'pegawai_id' => $request->pegawai_id,
            'jabatan' => $request->jabatan,
            'eselon_id' => $request->eselon_id,
            'jenis_jabatan_id' => $request->jenis_jabatan_id,
            'tmt' => $request->tmt,
            'no_sk' => $request->no_sk,
            'tgl_sk' => $request->tgl_sk,
            'pejabat_penetap' => $request->pejabat_penetap,
            'jenis_mutasi' => $request->jenis_mutasi,
        ]);

        return redirect()
            ->route('backend.jabatan.show', $request->pegawai_id)
            ->with('success', '✅ Riwayat Jabatan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        // 1. Amankan dan Ambil Data Pegawai
        session(['pegawai_id' => $id]);
        $pegawai = Pegawai::findOrFail($id);

        // 2. Logika Sorting dan Filtering
        $sortBy = $request->get('sort_by', 'created_at'); // Default: created_at
        $sortDirection = $request->get('direction', 'desc');

        // Tentukan kolom yang diizinkan: hanya created_at dan updated_at
        $allowedColumns = ['created_at', 'updated_at']; // <-- HANYA INI YANG DIIZINKAN
        
        if (!in_array($sortBy, $allowedColumns)) {
            $sortBy = 'created_at'; // Fallback ke created_at
        }

        // Pastikan arah pengurutan selalu 'asc' atau 'desc'
        $sortDirection = (strtolower($sortDirection) == 'asc') ? 'asc' : 'desc';

        // 3. Eksekusi Query dengan Filter, Pagination, dan Sorting
        $riwayat_jabatan = RiwayatJabatan::with('eselon', 'jenis_jabatan')
                                ->where('pegawai_id', $id)
                                ->orderBy($sortBy, $sortDirection)
                                ->paginate(10)
                                ->withQueryString();

        // 4. Ambil data tambahan
        $eselon = Eselon::all();
        $jenis_jabatan = JenisJabatan::all();

        return view('backend.pegawai.riwayat_jabatan', compact('pegawai', 'riwayat_jabatan', 'eselon', 'jenis_jabatan', 'sortBy', 'sortDirection'));
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
        $riwayat_jabatan = RiwayatJabatan::findOrFail($id);
        // 🔍 Validasi data edit
        $request->validate([
            'pegawai_id' => 'required|exists:pegawai,id',
            'jabatan' => 'required|string|max:255',
            'tmt' => 'required|date',
            'no_sk' => 'required|string|max:100|unique:riwayat_jabatan,no_sk,' . $id,
            'tgl_sk' => 'required|date',
            'pejabat_penetap' => 'required|string|max:100',
            'jenis_mutasi' => 'required|string|max:100',
            'eselon_id' => 'required|exists:eselon,id',
            'jenis_jabatan_id' => 'required|exists:jenis_jabatan,id',
        ], [
            'no_sk.unique' => 'Nomor SK sudah digunakan. Harus berbeda dari yang lain.',
        ]);

        // ✅ Update data
        $riwayat_jabatan->update([
            'pegawai_id' => $request->pegawai_id,
            'jabatan' => $request->jabatan,
            'eselon_id' => $request->eselon_id,
            'jenis_jabatan_id' => $request->jenis_jabatan_id,
            'tmt' => $request->tmt,
            'no_sk' => $request->no_sk,
            'tgl_sk' => $request->tgl_sk,
            'pejabat_penetap' => $request->pejabat_penetap,
            'jenis_mutasi' => $request->jenis_mutasi,
        ]);

        return redirect()
            ->route('backend.jabatan.show', $request->pegawai_id)
            ->with('success', '✅ Riwayat jabatan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $riwayat_jabatan = RiwayatJabatan::findOrFail($id);
        $riwayat_jabatan->delete(); // ✅ Hapus data riwayat jabatan (soft delete)

        return redirect()->back()->with('success', '✅ Data Riwayat Jabatan berhasil dihapus.');
    }
}
