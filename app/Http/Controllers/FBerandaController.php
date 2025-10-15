<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\RiwayatPendidikan;
use App\Models\RiwayatJabatan;
use App\Models\RiwayatPlhPlt;
use App\Models\RiwayatGolongan;
use App\Models\RiwayatDiklat;
use App\Models\RiwayatKgb;
use App\Models\RiwayatPenghargaan;
use App\Models\RiwayatSlks;
use App\Models\RiwayatOrganisasi;
use App\Models\NilaiPrestasiKerja; 
use App\Models\RiwayatAsesmen;
use App\Models\RiwayatKesejahteraan;
use App\Models\DataKeluarga;
use App\Models\Dokumen;
use App\Models\RiwayatGaji;
 


class FBerandaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pegawaiId = auth()->user()->pegawai_id;
        // ambil data terbaru dari masing-masing tabel
        $updates = collect();

        // ambil data terbaru dari masing-masing tabel
        $updates = $updates->merge(
            RiwayatPendidikan::where('pegawai_id', $pegawaiId)->latest()->take(5)->get()->map(function ($item) {
                return [
                    'nama' => 'Riwayat Pendidikan',
                    'created_at' => $item->created_at,
                ];
            })
        );
        
        $updates = $updates->merge(
            RiwayatJabatan::where('pegawai_id', $pegawaiId)->latest()->take(5)->get()->map(function ($item) {
                return [
                    'nama' => 'Riwayat Jabatan',
                    'created_at' => $item->created_at,
                ];
            })
        );
        
        $updates = $updates->merge(
            RiwayatPlhPlt::where('pegawai_id', $pegawaiId)->latest()->take(5)->get()->map(function ($item) {
                return [
                    'nama' => 'Riwayat PLH/PLT',
                    'created_at' => $item->created_at,
                ];
            })
        );

        $updates = $updates->merge(
            RiwayatGolongan::where('pegawai_id', $pegawaiId)->latest()->take(5)->get()->map(function ($item) {
                return [
                    'nama' => 'Riwayat Golongan',
                    'created_at' => $item->created_at,
                ];
            })
        );
        
        $updates = $updates->merge(
            RiwayatDiklat::where('pegawai_id', $pegawaiId)->latest()->take(5)->get()->map(function ($item) {
                return [
                    'nama' => 'Riwayat Diklat',
                    'created_at' => $item->created_at,
                ];
            })
        );
        
        $updates = $updates->merge(
            RiwayatGaji::where('pegawai_id', $pegawaiId)->latest()->take(5)->get()->map(function ($item) {
                return [
                    'nama' => 'Riwayat Gaji',
                    'created_at' => $item->created_at,
                ];
            })
        );
        
        $updates = $updates->merge(
            RiwayatKgb::where('pegawai_id', $pegawaiId)->latest()->take(5)->get()->map(function ($item) {
                return [
                    'nama' => 'Riwayat KGB',
                    'created_at' => $item->created_at,
                ];
            })
        );
        
        $updates = $updates->merge(
            RiwayatPenghargaan::where('pegawai_id', $pegawaiId)->latest()->take(5)->get()->map(function ($item) {
                return [
                    'nama' => 'Riwayat Penghargaan',
                    'created_at' => $item->created_at,
                ];
            })
        );

        $updates = $updates->merge(
            RiwayatSlks::where('pegawai_id', $pegawaiId)->latest()->take(5)->get()->map(function ($item) {
                return [
                    'nama' => 'Riwayat SLKS',
                    'created_at' => $item->created_at,
                ];
            })
        );

        $updates = $updates->merge(
            RiwayatOrganisasi::where('pegawai_id', $pegawaiId)->latest()->take(5)->get()->map(function ($item) {
                return [
                    'nama' => 'Riwayat Organisasi',
                    'created_at' => $item->created_at,
                ];
            })
        );

        $updates = $updates->merge(
            NilaiPrestasiKerja::where('pegawai_id', $pegawaiId)->latest()->take(5)->get()->map(function ($item) {
                return [
                    'nama' => 'Nilai Prestasi Kerja',
                    'created_at' => $item->created_at,
                ];
            })
        );
        
        $updates = $updates->merge(
            RiwayatAsesmen::where('pegawai_id', $pegawaiId)->latest()->take(5)->get()->map(function ($item) {
                return [
                    'nama' => 'Riwayat Asesmen',
                    'created_at' => $item->created_at,
                ];
            })
        );

        $updates = $updates->merge(
            RiwayatKesejahteraan::where('pegawai_id', $pegawaiId)->latest()->take(5)->get()->map(function ($item) {
                return [
                    'nama' => 'Riwayat Kesejahteraan',
                    'created_at' => $item->created_at,
                ];
            })
        );
        
        $updates = $updates->merge(
            DataKeluarga::where('pegawai_id', $pegawaiId)->latest()->take(5)->get()->map(function ($item) {
                return [
                    'nama' => 'Data Keluarga',
                    'created_at' => $item->created_at,
                ];
            })
        );

        $updates = $updates->merge(
            Dokumen::with('folder')->where('pegawai_id', $pegawaiId)->latest()->take(5)->get()->map(function ($item) {
                return [
                    'nama' => 'Dokumen',
                    'created_at' => $item->created_at,
                ];
            })
        );

        // urutkan semua data berdasarkan created_at terbaru
        $latestUpdates = $updates->sortByDesc('created_at')->take(10);

        return view('frontend.beranda',[
            'pendidikanCount' => RiwayatPendidikan::where('pegawai_id', auth()->user()->pegawai_id)->count(),
            'jabatanCount' => RiwayatJabatan::where('pegawai_id', auth()->user()->pegawai_id)->count(),
            'plhpltCount' => RiwayatPlhPlt::where('pegawai_id', auth()->user()->pegawai_id)->count(),
            'golonganCount' => RiwayatGolongan::where('pegawai_id', auth()->user()->pegawai_id)->count(),
            'diklatCount' => RiwayatDiklat::where('pegawai_id', auth()->user()->pegawai_id)->count(),
            'gajiCount' => RiwayatGaji::where('pegawai_id', auth()->user()->pegawai_id)->count(),
            'kgbCount' => RiwayatKgb::where('pegawai_id', auth()->user()->pegawai_id)->count(),
            'penghargaanCount' => RiwayatPenghargaan::where('pegawai_id', auth()->user()->pegawai_id)->count(),
            'slksCount' => RiwayatSlks::where('pegawai_id', auth()->user()->pegawai_id)->count(),
            'organisasiCount' => RiwayatOrganisasi::where('pegawai_id', auth()->user()->pegawai_id)->count(),
            'prestasiCount' => NilaiPrestasiKerja::where('pegawai_id', auth()->user()->pegawai_id)->count(),
            'asesmenCount' => RiwayatAsesmen::where('pegawai_id', auth()->user()->pegawai_id)->count(),
            'kesejahteraanCount' => RiwayatKesejahteraan::where('pegawai_id', auth()->user()->pegawai_id)->count(),
            'keluargaCount' => DataKeluarga::where('pegawai_id', auth()->user()->pegawai_id)->count(),
            'dokumenCount' => Dokumen::where('pegawai_id', auth()->user()->pegawai_id)->count()
        ], compact('latestUpdates'));
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
