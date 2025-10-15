<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
        //
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'pegawai_id' => 'required|exists:pegawai,id',
            'nm_dokumen' => 'required|string|max:255',
            'folder_id' => 'required|exists:folder,id',
            'file_path' => 'required|file|mimes:pdf,doc,docx,jpg,png|max:2048', // max 2M
        ], [
            'file_path.required' => 'Dokumen wajib diunggah.',
            'file_path.file' => 'Format file tidak valid.',
            'file_path.mimes' => 'Format dokumen harus PDF, DOC, DOCX, JPG, atau PNG.',
            'file_path.max' => 'Ukuran file maksimal 2MB.',
        ]);

        // Simpan file dengan nama asli
        $filename = $request->file('file_path')->getClientOriginalName();
        $path = $request->file('file_path')->storeAs('dokumen', $filename, 'public');

        // Simpan ke database
        Dokumen::create([
            'pegawai_id' => $request->pegawai_id,
            'nm_dokumen' => $request->nm_dokumen,
            'folder_id' => $request->folder_id,
            'file_path' => $path,
        ]);

        return redirect()->route('backend.dokumen.show', $request->pegawai_id)->with('success', '✅ Dokumen berhasil disimpan!');
    }

    public function show(string $id)
    {
        session(['pegawai_id' => $id]);

        $pegawai = Pegawai::findOrFail($id);
        $dokumen = Dokumen::with('folder')->where('pegawai_id', $id)->get();

        $folder = Folder::all();

        return view('backend.pegawai.dokumen', compact('pegawai', 'dokumen', 'folder'));
    }

    public function update(Request $request, string $id)
    {
        // Pastikan validasi Anda menggunakan exists:folder,id (sesuai nama tabel Anda)
        $request->validate([
            'nm_dokumen' => 'required|string|max:255',
            'folder_id' => 'required|exists:folder,id', // Ganti 'folder' jika perlu
            'file_path' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
        ]);

        $dok = Dokumen::findOrFail($id);
        $hasNewFile = $request->hasFile('file_path');

        // 1. Update data non-file terlebih dahulu
        $dok->nm_dokumen = $request->nm_dokumen;
        $dok->folder_id = $request->folder_id;

        // 2. Logika Update File
        if ($hasNewFile) {
            // Hapus file lama (jika ada) sebelum menyimpan yang baru
            if ($dok->file_path && Storage::disk('public')->exists($dok->file_path)) {
                Storage::disk('public')->delete($dok->file_path);
            }
            
            $filename = $request->file('file_path')->getClientOriginalName();
            $path = $request->file('file_path')->storeAs('dokumen', $filename, 'public');
            $dok->file_path = $path; // Terapkan path baru
        }

        // 3. Simpan perubahan (Termasuk path baru jika di-update)
        $dok->save(); // <--- SEMUA PERUBAHAN TERSIMPAN DI SINI

        return redirect()->route('backend.dokumen.show', $request->pegawai_id)
            ->with('success', '✅ Dokumen berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $dokumen = Dokumen::findOrFail($id);
        $dokumen->delete(); // ✅ Hapus data dokumen (soft delete)

        return redirect()->back()->with('success', '✅ Data dokumen berhasil dihapus.');
    }

}
