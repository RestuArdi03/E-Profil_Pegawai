<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiwayatAsesmen;
use App\Models\Pegawai;

class AsesmenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pegawaiId = auth()->user()->pegawai_id;
        $riwayat_asesmen = RiwayatAsesmen::with('pegawai')->where('pegawai_id', $pegawaiId)->get();
        return view('frontend.asesmen', compact('riwayat_asesmen'));
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

        $pegawai = Pegawai::with('riwayatAsesmen')->findOrFail($id);
        $riwayat_asesmen = $pegawai->riwayatAsesmen;

        return view('backend.pegawai.riwayat_asesmen', compact('pegawai', 'riwayat_asesmen'));
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
