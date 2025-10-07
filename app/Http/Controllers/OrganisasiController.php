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
    public function index()
    {
        $pegawaiId = auth()->user()->pegawai_id;
        $riwayat_organisasi = RiwayatOrganisasi::with('pegawai')->where('pegawai_id', $pegawaiId)->get();
        return view('frontend.organisasi', compact('riwayat_organisasi'));
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

        $pegawai = Pegawai::with('riwayatOrganisasi')->findOrFail($id);
        $riwayat_organisasi = $pegawai->riwayatOrganisasi;

        return view('backend.pegawai.riwayat_organisasi', compact('pegawai', 'riwayat_organisasi'));
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
