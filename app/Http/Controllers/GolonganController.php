<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiwayatGolongan;
use App\Models\Pegawai;

class GolonganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pegawaiId = auth()->user()->pegawai_id;
        $riwayat_golongan = RiwayatGolongan::with('pegawai', 'golongan')->where('pegawai_id', $pegawaiId)->get();
        return view('frontend.golongan', compact('riwayat_golongan'));
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
        $pegawai = Pegawai::with('riwayatGolongan')->findOrFail($id);
        return view('backend.pegawai.riwayat_golongan', compact('pegawai'));
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
