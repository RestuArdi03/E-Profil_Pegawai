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
        // 🔍 Validasi field wajib diisi
        $request->validate([
            'pegawai_id' => 'required|exists:pegawai,id',
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:100|unique:data_keluarga,nik',
            'tmpt_lahir' => 'required|string|max:100',
            'tgl_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string|max:50',
            'status_keluarga' => 'required|string|max:50',
            'pendidikan' => 'required|string|max:50',
            'pekerjaan' => 'nullable|string|max:100',
            'nip' => 'nullable|string|max:100|unique:data_keluarga,nip',
        ], [
            'nik.unique' => 'NIK sudah digunakan / NIK harus berbeda dengan yang lain.',
            'nip.unique' => 'NIP sudah digunakan / NIP harus berbeda dengan yang lain.',
        ]);

        // ✅ Simpan data keluarga
        DataKeluarga::create([
            'pegawai_id' => $request->pegawai_id,
            'nama' => $request->nama,
            'nik' => $request->nik,
            'tmpt_lahir' => $request->tmpt_lahir,
            'tgl_lahir' => $request->tgl_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'status_keluarga' => $request->status_keluarga,
            'pendidikan' => $request->pendidikan,
            'pekerjaan' => $request->pekerjaan,
            'nip' => $request->nip,
        ]);

        return redirect()->route('backend.keluarga.show', $request->pegawai_id)
            ->with('success', '✅ Data Keluarga berhasil ditambahkan.');
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
        $keluarga = DataKeluarga::findOrFail($id);
        // 🔍 Validasi data edit
        $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:100|unique:data_keluarga,nik,' . $id,
            'tmpt_lahir' => 'required|string|max:100',
            'tgl_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string|max:50',
            'status_keluarga' => 'required|string|max:50',
            'pendidikan' => 'required|string|max:50',
            'pekerjaan' => 'nullable|string|max:100',
            'nip' => 'nullable|string|max:100|unique:data_keluarga,nip,' . $id
        ], [
            'nik.unique' => 'NIK sudah digunakan / NIK harus berbeda dengan yang lain.',
            'nip.unique' => 'NIP sudah digunakan / NIP harus berbeda dengan yang lain.',
        ]);

        // ✅ Update data
        $keluarga->update([
            'nama' => $request->nama,
            'nik' => $request->nik,
            'tmpt_lahir' => $request->tmpt_lahir,
            'tgl_lahir' => $request->tgl_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'status_keluarga' => $request->status_keluarga,
            'pendidikan' => $request->pendidikan,
            'pekerjaan' => $request->pekerjaan,
            'nip' => $request->nip,
        ]);

        return redirect()->route('backend.keluarga.show', $request->pegawai_id) ->with('success', '✅ Data Keluarga berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data_keluarga = DataKeluarga::findOrFail($id);
        $data_keluarga->delete(); // ✅ Hapus data keluarga (soft delete)

        return redirect()->back()->with('success', '✅ Data Keluarga berhasil dihapus.');
    }
}
