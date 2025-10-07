<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiwayatPlhPlt;
use App\Models\Pegawai;

class PlhPltController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pegawaiId = auth()->user()->pegawai_id;
        $riwayat_plh_plt = RiwayatPlhPlt::with('pegawai')->where('pegawai_id', $pegawaiId)->get();
        return view('frontend.plh_plt', compact('riwayat_plh_plt'));
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

        $pegawai = Pegawai::with('riwayatPlhPlt')->findOrFail($id);
        $riwayat_plh_plt = $pegawai->riwayatPlhPlt;

        return view('backend.pegawai.riwayat_plh_plt', compact('pegawai', 'riwayat_plh_plt'));
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
