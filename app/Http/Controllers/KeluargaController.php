<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataKeluarga;
use App\Models\Pegawai;

class KeluargaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pegawaiId = auth()->user()->pegawai_id;
        $data_keluarga = DataKeluarga::with('pegawai')->where('pegawai_id', $pegawaiId)->get();
        return view('frontend.keluarga', compact('data_keluarga'));
        
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

        $pegawai = Pegawai::with('dataKeluarga')->findOrFail($id);
        $data_keluarga = $pegawai->dataKeluarga;

        return view('backend.pegawai.data_keluarga', compact('pegawai', 'data_keluarga'));
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
