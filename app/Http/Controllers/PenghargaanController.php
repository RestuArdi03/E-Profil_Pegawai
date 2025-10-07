<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiwayatPenghargaan;
use App\Models\Pegawai;

class PenghargaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pegawaiId = auth()->user()->pegawai_id;
        $riwayat_penghargaan = RiwayatPenghargaan::with('pegawai')->where('pegawai_id', $pegawaiId)->get();
        return view('frontend.penghargaan', compact('riwayat_penghargaan'));
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

        $pegawai = Pegawai::with('riwayatPenghargaan')->findOrFail($id);
        $riwayat_penghargaan = $pegawai->riwayatPenghargaan;

        return view('backend.pegawai.riwayat_penghargaan', compact('pegawai', 'riwayat_penghargaan'));
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
