<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instansi; // Import model Instansi yang baru

/**
 * Controller untuk mengelola halaman daftar Instansi di backend.
 */
class DaftarInstansiController extends Controller
{
    /**
     * Menampilkan daftar semua Instansi.
     */
    public function index()
    {
        // Mengambil semua data Instansi dari database
        $instansi = Instansi::all();

        // Mengirim data Instansi ke view 'backend.daftar_instansi'
        // Variabel yang dikirimkan ke view adalah 'instansis'
        return view('backend.daftar_instansi', compact('instansi'));
    }

    // Anda dapat menambahkan method create, store, edit, update, dan destroy
    // di sini jika ingin mengelola data Instansi secara CRUD.
}
