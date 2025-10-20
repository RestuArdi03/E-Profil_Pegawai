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

    public function index(Request $request)
    {
        $query = Instansi::query(); // Menggunakan query()

        // Tambahkan Logic Pencarian 
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('nm_instansi', 'like', '%' . $search . '%')
                  ->orWhere('kode', 'like', '%' . $search . '%')
                  ->orWhere('kd_instansi', 'like', '%' . $search . '%');
        }

        // PERBAIKAN FINAL: Mengurutkan berdasarkan ID secara ascending (plek ketiplek DB)
        $instansi = $query->orderBy('id', 'asc') 
                          ->paginate(15)
                          ->withQueryString();

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
        // Validasi
        $validator = Validator::make($request->all(), [
            'id'              => 'required|integer|unique:instansi,id', // ID harus unik saat CREATE
            'nm_instansi'     => 'required|string|max:255',
            'kd_instansi'     => 'required|string|max:50', 
            'kode'            => 'required|string|max:20', 
            'alamat_instansi' => 'nullable|string|max:500',
            'telp_instansi'   => 'nullable|string|max:30',
            'fax_instansi'    => 'nullable|string|max:30',
            'urutan_instansi' => 'required|integer|min:0', 
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        // Simpan semua kolom
        Instansi::create($request->only(
            'id', 'nm_instansi', 'kd_instansi', 'kode',
            'alamat_instansi', 'telp_instansi', 'fax_instansi', 'urutan_instansi'
        ));
        
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


    public function update(Request $request, string $id)
    {
        $instansi = Instansi::findOrFail($id);
        
        // Validasi
        $validator = Validator::make($request->all(), [
            'id'              => 'required|integer', 
            'nm_instansi'     => 'required|string|max:255',
            
            // PERBAIKAN: Tambahkan UNIQUE, tetapi abaikan ID record yang sedang di-edit.
            // Solusi untuk mengatasi 'Duplicate entry' di DB yang bandel.
            'kd_instansi'     => 'required|string|unique:instansi,kd_instansi,' . $id . '|max:50', 
            'kode'            => 'required|string|unique:instansi,kode,' . $id . '|max:20', 
            
            'alamat_instansi' => 'nullable|string|max:500',
            'telp_instansi'   => 'nullable|string|max:30',
            'fax_instansi'    => 'nullable|string|max:30',
            'urutan_instansi' => 'required|integer|min:0', 
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput(); 
        }

        // Cek jika ID diubah (untuk keamanan)
        if ($request->input('id') != $instansi->id) {
             return Redirect::back()->withErrors(['id' => 'ID tidak boleh diubah.'])->withInput();
        }

        // UPDATE SEMUA KOLOM
        $instansi->update($request->only(
            'nm_instansi', 'kd_instansi', 'kode',
            'alamat_instansi', 'telp_instansi', 'fax_instansi', 'urutan_instansi' 
        ));

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
