<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kesejahteraan;
use App\Models\Pegawai;

class KesejahteraanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pegawaiId = auth()->user()->pegawai_id;
        $kesejahteraan = Kesejahteraan::with('pegawai')->where('pegawai_id', $pegawaiId)->get();
        return view('frontend.kesejahteraan', compact('kesejahteraan'));
        
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

        $pegawai = Pegawai::with('riwayatKesejahteraan')->findOrFail($id);
        $kesejahteraan = $pegawai->riwayatKesejahteraan;

        return view('backend.pegawai.riwayat_kesejahteraan', compact('pegawai', 'kesejahteraan'));
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
