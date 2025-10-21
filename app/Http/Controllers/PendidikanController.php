<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiwayatPendidikan;
use App\Models\Strata;
use App\Models\Pegawai;

class PendidikanController extends Controller
{
    /**
     * Display a listing of the resourc.
     */
    public function index()
    {
        $pegawaiId = auth()->user()->pegawai_id;
        $riwayat_pendidikan = RiwayatPendidikan::with(['pegawai', 'strata'])->where('pegawai_id', $pegawaiId)->get();
        return view('frontend.pendidikan', compact('riwayat_pendidikan'));
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
            'strata_id' => 'required|exists:strata,id',
            'nm_sekolah_pt' => 'required|string|max:255',
            'no_ijazah' => 'required|string|max:100|unique:riwayat_pendidikan,no_ijazah',
            'thn_lulus' => 'required|digits:4|integer|min:1950|max:' . date('Y'),
            'pimpinan' => 'required|string|max:100',
            'kode_pendidikan' => 'required|string|max:50',
        ],[
            'no_ijazah.unique' => 'Nomor ijazah sudah digunakan / Nomor ijazah harus berbeda dengan yang lain.',
        ]);

        // ✅ Simpan riwayat pendidikan
        RiwayatPendidikan::create([
            'pegawai_id' => $request->pegawai_id,
            'strata_id' => $request->strata_id,
            'nm_sekolah_pt' => $request->nm_sekolah_pt,
            'no_ijazah' => $request->no_ijazah,
            'thn_lulus' => $request->thn_lulus,
            'pimpinan' => $request->pimpinan,
            'kode_pendidikan' => $request->kode_pendidikan,
        ]);

        return redirect()->route('backend.pendidikan.show', $request->pegawai_id)
            ->with('success', '✅ Data Riwayat Pendidikan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id) // <-- Terima Request, ubah $id menjadi $pegawai_id
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
        $riwayat_pendidikan = RiwayatPendidikan::with('strata')
                                                ->where('pegawai_id', $id) // Filter berdasarkan ID Pegawai
                                                ->orderBy($sortBy, $sortDirection) // Terapkan sorting
                                                ->paginate(10) // Terapkan pagination
                                                ->withQueryString(); // Pertahankan parameter filter

        // 4. Ambil data tambahan (strata)
        $strata = Strata::all();

        // 5. Kembalikan View (Kirim variabel sorting/filtering)
        return view('backend.pegawai.riwayat_pendidikan', compact('pegawai', 'riwayat_pendidikan', 'strata', 'sortBy', 'sortDirection'
        ));
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
        $rp = RiwayatPendidikan::findOrFail($id);
        // 🔍 Validasi data edit
        $request->validate([
            'strata_id' => 'required',
            'nm_sekolah_pt' => 'required|string|max:255',
            'no_ijazah' => 'required|string|max:100|unique:riwayat_pendidikan,no_ijazah,' . $id,
            'thn_lulus' => 'required|digits:4|integer|min:1950|max:' . date('Y'),
            'pimpinan' => 'required|string|max:100',
            'kode_pendidikan' => 'required|string|max:50',
        ], [
            'no_ijazah.unique' => 'Nomor ijazah sudah digunakan / Nomor ijazah harus berbeda dengan yang lain.',
        ]);

        // ✅ Update data
        $rp->update([
            'strata_id' => $request->strata_id,
            'nm_sekolah_pt' => $request->nm_sekolah_pt,
            'no_ijazah' => $request->no_ijazah,
            'thn_lulus' => $request->thn_lulus,
            'pimpinan' => $request->pimpinan,
            'kode_pendidikan' => $request->kode_pendidikan,
        ]);

        return redirect()->route('backend.pendidikan.show', $request->pegawai_id) ->with('success', '✅ Data Riwayat Pendidikan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $riwayat_pendidikan = RiwayatPendidikan::findOrFail($id);
        $riwayat_pendidikan->delete(); // ✅ Hapus data riwayat pendidikan (soft delete)

        return redirect()->back()->with('success', '✅ Data Riwayat Pendidikan berhasil dihapus.');
    }
}
