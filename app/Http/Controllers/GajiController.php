<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiwayatGaji;
use App\Models\Pegawai;

class GajiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pegawaiId = auth()->user()->pegawai_id;
        $riwayat_gaji = RiwayatGaji::with('pegawai')->where('pegawai_id', $pegawaiId)->get();
        return view('frontend.gaji', compact('riwayat_gaji'));
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

        $pegawai = Pegawai::with('riwayatGaji')->findOrFail($id);
        $riwayat_gaji = $pegawai->riwayatGaji;

        return view('backend.pegawai.riwayat_gaji', compact('pegawai', 'riwayat_gaji'));
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
