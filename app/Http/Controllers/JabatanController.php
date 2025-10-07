<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiwayatJabatan;
use App\Models\Eselon;
use App\Models\JenisJabatan;
use App\Models\Pegawai;


class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pegawaiId = auth()->user()->pegawai_id;
        $riwayat_jabatan = RiwayatJabatan::with(['pegawai', 'eselon', 'jenis_jabatan'])->where('pegawai_id', $pegawaiId)->get();
        return view('frontend.jabatan', compact('riwayat_jabatan'));
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
        $riwayat_jabatan = RiwayatJabatan::with('eselon', 'jenis_jabatan')
                                ->where('pegawai_id', $id)
                                ->get();

        $eselon = Eselon::all();
        $jenis_jabatan = JenisJabatan::all();

        return view('backend.pegawai.riwayat_jabatan', compact('pegawai', 'riwayat_jabatan', 'eselon', 'jenis_jabatan'));
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
