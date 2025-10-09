<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instansi;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

/**
 * Controller untuk mengelola sumber daya (resource) Instansi (CRUD).
 */
class InstansiController extends Controller
{
    /**
     * Menampilkan daftar semua Instansi.
     */
    public function index()
    {
        // Menggunakan kolom 'nm_instansi' untuk urutan
        $instansi = Instansi::orderBy('nm_instansi', 'asc')->get();
        return view('backend.instansi.daftar_instansi', compact('instansi'));
    }

    /**
     * Menampilkan form untuk membuat Instansi baru.
     */
    public function create()
    {
        return view('backend.instansi.create'); 
    }

    /**
     * Menyimpan Instansi yang baru dibuat ke storage.
     */
    public function store(Request $request)
    {
        // Perbaikan: Pastikan kolom unique disesuaikan dengan nama kolom di DB (kd_instansi)
        $validator = Validator::make($request->all(), [
            'nm_instansi' => 'required|string|max:255',
            'kd_instansi' => 'required|string|unique:instansi,kd_instansi|max:50',
            'alamat_instansi' => 'nullable|string|max:500',
            'telp_instansi'   => 'nullable|string|max:30',
            'fax_instansi'    => 'nullable|string|max:30',
            'urutan_instansi' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        // Simpan kolom 'nm_instansi' dan 'kd_instansi'
        Instansi::create($request->only('nm_instansi', 'kd_instansi'));

        return Redirect::route('backend.daftar_instansi')->with('success', 'Data Instansi berhasil ditambahkan.');
    }
    
    public function show(string $id)
    {
        return Redirect::route('backend.daftar_instansi'); 
    }

    /**
     * Menampilkan form untuk mengedit Instansi spesifik.
     */
    public function edit(string $id)
    {
        $instansi = Instansi::findOrFail($id);
        return view('backend.instansi.edit', compact('instansi')); 
    }


    /**
     * Memperbarui (Update) Instansi di storage.
     */
    public function update(Request $request, string $id)
    {
        $instansi = Instansi::findOrFail($id);
        
        // VALIDASI UNTUK NAMA INSTANSI dan KODE INSTANSI (jika diizinkan diubah)
        $validator = Validator::make($request->all(), [
            'nm_instansi' => 'required|string|max:255',
            'kd_instansi' => 'required|string|unique:instansi,kd_instansi,'.$id.'|max:10',
            'alamat_instansi' => 'nullable|string|max:500',
            'telp_instansi'   => 'nullable|string|max:30',
            'fax_instansi'    => 'nullable|string|max:30',
            'urutan_instansi' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput(); 
        }

        // Izinkan update untuk 'nm_instansi' dan 'kd_instansi'
        $instansi->update($request->only('nm_instansi', 'kd_instansi'));

        return Redirect::route('backend.daftar_instansi')->with('success', 'Data Instansi berhasil diperbarui.');
    }

    /**
     * Menghapus Instansi dari storage.
     */
    public function destroy(string $id)
    {
        $instansi = Instansi::findOrFail($id);
        $instansi->delete();

        return Redirect::route('backend.daftar_instansi')->with('success', 'Data Instansi berhasil dihapus.');
    }
}