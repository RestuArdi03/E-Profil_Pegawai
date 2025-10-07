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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        session(['pegawai_id' => $id]);

        $pegawai = Pegawai::findOrFail($id);
        $riwayat_pendidikan = RiwayatPendidikan::with('strata')
                                ->where('pegawai_id', $id)
                                ->orderByDesc('thn_lulus') // opsional
                                ->get();

        $strata = Strata::all();

        return view('backend.pegawai.riwayat_pendidikan', compact('pegawai', 'riwayat_pendidikan', 'strata'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
