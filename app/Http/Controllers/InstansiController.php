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

// InstansiController.php - method index()
// Kode ini sudah benar dan kita pertahankan untuk mendapatkan data terbaru di atas
// App\Http\Controllers\InstansiController.php

    public function index(Request $request)
    {
        $query = Instansi::query(); 

        // Tambahkan Logic Pencarian 
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('nm_instansi', 'like', '%' . $search . '%')
                ->orWhere('kode', 'like', '%' . $search . '%')
                ->orWhere('kd_instansi', 'like', '%' . $search . '%');
        }

        // PERBAIKAN FINAL: Mengurutkan berdasarkan ID secara ascending (plek ketiplek DB)
        $instansi = $query->orderBy('id', 'asc') // <<< DIUBAH DI SINI
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
// InstansiController.php

// ... (Di dalam class InstansiController)

    /**
     * Menyimpan Instansi yang baru dibuat ke storage.
     */
// InstansiController.php - method store()

    public function store(Request $request)
    {
        // Pastikan semua kolom yang harus diisi diberi 'required'
        $validator = Validator::make($request->all(), [
            'id'              => 'required|integer|unique:instansi,id', // ID wajib dan unik
            'nm_instansi'     => 'required|string|max:255',
            'kd_instansi'     => 'required|string|max:50', 
            'kode'            => 'required|string|max:20', 
            
            'alamat_instansi' => 'nullable|string|max:500', // Ini boleh kosong
            'telp_instansi'   => 'nullable|string|max:30',   // Ini boleh kosong
            'fax_instansi'    => 'nullable|string|max:30',     // Ini boleh kosong

            'urutan_instansi' => 'required|integer|min:0', // Urutan Wajib
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
    }

// ...
    
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
        
        $validator = Validator::make($request->all(), [
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