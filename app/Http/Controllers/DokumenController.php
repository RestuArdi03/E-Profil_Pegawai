<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dokumen;
use App\Models\Folder;
use App\Models\Pegawai;

class DokumenController extends Controller
{
    public function index()
    {
        $pegawaiId = auth()->user()->pegawai_id;
        $dokumen = Dokumen::with(['folder','pegawai'])->where('pegawai_id', $pegawaiId)->get();
        return view('frontend.dokumen', compact('dokumen'));
    }

    public function create()
    {
        $folders = Folder::all();
        return view('dokumen.create', compact('folders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nm_dokumen' => 'required',
            'folder_id' => 'required',
            'pegawai_id' => 'required',
            'file' => 'required|file|mimes:pdf,doc,docx|max:2048'
        ]);

        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('dokumen', $filename, 'public');

        Dokumen::create([
            'nm_dokumen' => $request->nm_dokumen,
            'folder_id' => $request->folder_id,
            'pegawai_id' => $request->pegawai_id,
            'file_path' => $path
        ]);

        return redirect()->route('dokumen.index')->with('success', 'Dokumen berhasil disimpan!');
    }

        public function show(string $id)
    {
        session(['pegawai_id' => $id]);

        $pegawai = Pegawai::with('dokumen')->findOrFail($id);
        $dokumen = $pegawai->dokumen;

        return view('backend.pegawai.dokumen', compact('pegawai', 'dokumen'));
    }
}
