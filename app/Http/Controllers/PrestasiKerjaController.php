<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NilaiPrestasiKerja;
use App\Models\Pegawai;

class PrestasiKerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pegawaiId = auth()->user()->pegawai_id;
        $nilai_prestasi_kerja = NilaiPrestasiKerja::with('pegawai')->where('pegawai_id', $pegawaiId)->get();
        return view('frontend.prestasi', compact('nilai_prestasi_kerja'));
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

        $pegawai = Pegawai::with('prestasiKerja')->findOrFail($id);
        $nilai_prestasi_kerja = $pegawai->prestasiKerja;

        return view('backend.pegawai.nilai_prestasi_kerja', compact('pegawai', 'nilai_prestasi_kerja'));
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
