<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\Pegawai;
use App\Models\Instansi;
use App\Models\UnitKerja;
use App\Models\SatuanKerja;
use App\Models\JenisJabatan;
use App\Models\Eselon;
use App\Models\User;
use App\Models\Golongan;
use App\Models\Strata;
use App\Models\Agama;

class BBerandaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 1. Ambil Jumlah Data (Count) - (Tetap sama)
        $pegawaiCount = Pegawai::count();
        $instansiCount = Instansi::count();
        $unit_kerjaCount = UnitKerja::count();
        $satuan_kerjaCount = SatuanKerja::count();
        $jenis_jabatanCount = JenisJabatan::count();
        $eselonCount = Eselon::count();
        $usersCount = User::count();
        $golonganCount = Golongan::count();
        $strataCount = Strata::count();
        $agamaCount = Agama::count();

        // 2. Ambil Update Data Terbaru (latestUpdates)
        
        $modelsToTrack = [
            'Pegawai' => Pegawai::class,
            'Instansi' => Instansi::class,
            'Unit Kerja' => UnitKerja::class,
            'Satuan Kerja' => SatuanKerja::class,
            'Jabatan' => JenisJabatan::class,
            'Eselon' => Eselon::class,
            'User' => User::class,
            'Golongan' => Golongan::class,
            'Strata' => Strata::class,
            'Agama' => Agama::class,
        ];
        
        $allUpdates = collect();

        foreach ($modelsToTrack as $label => $modelClass) {
            // Mengambil data yang Dibuat, Diubah, DAN Dihapus (Soft Deleted)
            $updates = $modelClass::withTrashed() 
                                    ->orderBy('updated_at', 'desc')
                                    ->take(5) 
                                    ->get();

            $mappedUpdates = $updates->map(function ($item) use ($label) {
                
                $tipeUpdate = '';
                $timestamp = $item->updated_at; 
                
                // --- Logika Penentuan Tipe Update (Create, Update, Delete) ---
                if ($item->deleted_at) {
                    $tipeUpdate = 'Hapus Data';
                    // Gunakan deleted_at sebagai waktu aksi Hapus
                    $timestamp = $item->deleted_at; 
                } else {
                    // Cek created_at vs updated_at (dalam toleransi 5 detik)
                    $isCreated = $item->created_at->diffInSeconds($item->updated_at) < 5;
                    $tipeUpdate = $isCreated ? 'Tambah Data' : 'Edit Data';
                    // $timestamp tetap updated_at
                }
                
                // --- Logika Penentuan Deskripsi ---
                // $kolomUpdate akan berfungsi sebagai label jenis item
                $kolomUpdate = $label; 
                $dataUpdate = 'N/A';
                
                // Penentuan nama item yang di-update
                if ($label === 'Pegawai') {
                    $dataUpdate = $item->nama ?? $item->nip ?? 'N/A';
                } elseif ($label === 'Instansi') {
                    $dataUpdate = $item->nm_instansi ?? 'N/A';
                } elseif ($label === 'Unit Kerja') {
                    $dataUpdate = $item->nm_unit_kerja ?? 'N/A';
                } elseif ($label === 'Satuan Kerja') {
                    $dataUpdate = $item->nm_satuan_kerja ?? 'N/A';
                } elseif ($label === 'Jabatan') {
                    $dataUpdate = $item->jenis_jabatan ?? 'N/A';
                } elseif ($label === 'Eselon') {
                    $dataUpdate = $item->nm_eselon ?? 'N/A';
                } elseif ($label === 'User') {
                    $dataUpdate = $item->username ?? 'N/A';
                } elseif ($label === 'Golongan') {
                    $dataUpdate = $item->golru ?? 'N/A';
                } elseif ($label === 'Strata') {
                    $dataUpdate = $item->nm_strata ?? 'N/A';
                } elseif ($label === 'Agama') {
                    $dataUpdate = $item->nm_agama ?? 'N/A';
                } else {
                    $kolomUpdate = $label;
                    $dataUpdate = $item->id ;
                }


                return [
                    'kategori'     => $label, // Kolom Tabel
                    'kolom_update' => $kolomUpdate, // Kolom Kolom (Deskripsi Field)
                    'data_update'  => $dataUpdate, // Kolom Data Update (Nama Item)
                    'tipe_update'  => $tipeUpdate, // Kolom Tipe Update (Tambah/Edit/Hapus)
                    'created_at'   => $timestamp,  // Kolom Tanggal Update
                ];
            });

            $allUpdates = $allUpdates->merge($mappedUpdates);
        }

        // Gabungkan dan urutkan 10 data terbaru secara keseluruhan
        // Menggunakan created_at (yang telah disesuaikan) untuk sorting
        $latestUpdates = $allUpdates->sortByDesc('created_at')->take(10); 

        // 3. Kirim semua variabel ke view menggunakan compact
        return view('backend.beranda', compact(
            'pegawaiCount',
            'instansiCount',
            'unit_kerjaCount',
            'satuan_kerjaCount',
            'jenis_jabatanCount',
            'eselonCount',
            'usersCount',
            'golonganCount',
            'strataCount',
            'agamaCount',
            'latestUpdates'
        ));
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
        //
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
