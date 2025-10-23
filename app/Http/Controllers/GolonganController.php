<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\RiwayatGolongan;
use App\Models\Golongan;
use App\Models\Pegawai;
use Carbon\Carbon;

class GolonganController extends Controller
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
        $riwayat_golongan = RiwayatGolongan::with('golongan')
                                                ->where('pegawai_id', $pegawaiId) // Filter berdasarkan ID User yang login
                                                ->orderBy($sortBy, $sortDirection) // Terapkan sorting
                                                ->paginate(10) // Terapkan pagination
                                                ->withQueryString(); // Pertahankan parameter filter

        // 4. Ambil data tambahan
        $golongan = Golongan::all(); 

        // 5. Kembalikan View (Kirim variabel sorting/filtering)
        return view('frontend.golongan', compact(
            'riwayat_golongan', 
            'golongan', 
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
            'golongan_id' => 'required',
            'tmt_golongan' => 'required|date',
            'no_sk' => 'required|string|max:100|unique:riwayat_golongan,no_sk',
            'tgl_sk' => 'required|date',
            'pejabat' => 'required|string|max:100',
        ], [
            'no_sk.unique' => 'Nomor SK sudah digunakan / Nomor SK harus berbeda dengan yang lain.',
        ]);

        // Perhitungan masa kerja
        $tmt = Carbon::parse($request->tmt_golongan);
        $now = Carbon::now();

        $tahun = $tmt->diffInYears($now);
        $bulan = $tmt->copy()->addYears($tahun)->diffInMonths($now);

        // Format modular: "10 tahun 3 bulan"
        $masaKerja = $tahun . ' Tahun ' . $bulan . ' Bulan';

        // ✅ Simpan riwayat golongan
        RiwayatGolongan::create([
            'pegawai_id' => $request->pegawai_id,
            'golongan_id' => $request->golongan_id,
            'tmt_golongan' => $request->tmt_golongan,
            'no_sk' => $request->no_sk,
            'tgl_sk' => $request->tgl_sk,
            'masa_kerja' => $masaKerja,
            'pejabat' => $request->pejabat,
        ]);

        return redirect()->route('backend.riwayat_golongan.show', $request->pegawai_id)
            ->with('success', '✅ Data Riwayat Golongan berhasil ditambahkan.');
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
        $sortBy = $request->get('sort_by', 'created_at'); 
        $sortDirection = $request->get('direction', 'desc');
        $allowedColumns = ['created_at', 'updated_at', 'tmt_golongan'];

        if (!in_array($sortBy, $allowedColumns)) {
            $sortBy = 'created_at';
        }
        
        $sortDirection = (strtolower($sortDirection) == 'asc') ? 'asc' : 'desc';

        // 3. Eksekusi Query dengan Filter, Pagination, dan Sorting
        $riwayat_golongan = RiwayatGolongan::with('golongan')
                                        ->where('pegawai_id', $id)
                                        ->orderBy($sortBy, $sortDirection)
                                        ->paginate(10)
                                        ->withQueryString();

        // 4. Ambil data tambahan (Master Golongan untuk dropdown modal)
        $golongan = Golongan::all();

        // Kembalikan view dengan semua variabel yang dibutuhkan untuk sorting/filtering
        return view('backend.pegawai.riwayat_golongan', compact(
            'pegawai', 
            'riwayat_golongan', 
            'golongan', 
            'sortBy', 
            'sortDirection'
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
        $gol = RiwayatGolongan::findOrFail($id);
        // 🔍 Validasi data edit
        $request->validate([
            'golongan_id' => 'required',
            'tmt_golongan' => 'required|date',
            'no_sk' => [
                'required',
                'string',
                'max:100',
                Rule::unique('riwayat_golongan', 'no_sk')->ignore($id), // <-- BENAR
            ],
            'tgl_sk' => 'required|date',
            'pejabat' => 'required|string|max:100',
        ], [
            'no_sk.unique' => 'Nomor SK sudah digunakan / Nomor SK harus berbeda dengan yang lain.',
        ]);

        // ✅ Update data
        $gol->update([
            'golongan_id' => $request->golongan_id,
            'tmt_golongan' => $request->tmt_golongan,
            'no_sk' => $request->no_sk,
            'tgl_sk' => $request->tgl_sk,
            'pejabat' => $request->pejabat,
        ]);

        return redirect()->route('backend.riwayat_golongan.show', $request->pegawai_id) ->with('success', '✅ Data Riwayat Golongan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $riwayat_golongan = RiwayatGolongan::findOrFail($id);
        $riwayat_golongan->delete(); // ✅ Hapus data riwayat golongan (soft delete)

        return redirect()->back()->with('success', '✅ Data Riwayat Golongan berhasil dihapus.');
    }
}
