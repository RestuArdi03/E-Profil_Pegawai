<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\Pegawai;
use App\Models\Instansi;
use App\Models\UnitKerja;
use App\Models\SatuanKerja;
use App\Models\User;
use App\Models\Agama;
use Illuminate\Support\Facades\Storage;


class DaftarPegawaiController extends Controller
{
    public function getUnitKerja($instansiId)
    {
        $unitKerjas = UnitKerja::where('instansi_id', $instansiId)->get();
        return response()->json($unitKerjas);
    }

    public function getSatuanKerja($unitKerjaId)
    {
        $satuanKerjas = SatuanKerja::where('unit_kerja_id', $unitKerjaId)->get();
        return response()->json($satuanKerjas);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pegawai = Pegawai::all();
        $agama = Agama::all();
        $instansis = Instansi::all();
        $unitKerjas = UnitKerja::all();
        $satuanKerjas = SatuanKerja::all();

        return view('backend.daftar_pegawai', compact('pegawai', 'agama',  'instansis', 'unitKerjas', 'satuanKerjas'));
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
        // === VALIDASI DATA ===
    $validated = $request->validate([

        // VALIDASI UNTUK AKUN USER
        'username' => 'required|unique:users,username',
        'email' => 'required|email|unique:users,email',
        'password' => [
            'required',
            'min:8',
            'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/',
            'confirmed'        
        ],
        'password_confirmation' => 'required',
        
        // VALIDASI UNTUK DATA PEGAWAI
        'nama' => 'required|string|max:255',
        'nip' => 'required|string|max:50|unique:pegawai,nip',
        'no_kk' => 'required|string|max:50',
        'tpt_lahir' => 'required|string|max:100',
        'tgl_lahir' => 'required|date',
        'no_karpeg' => 'required|string|max:50|unique:pegawai,no_karpeg',
        'agama_id' => 'required|exists:agama,id',
        'golongan_darah' => 'nullable|string|not_in:-,?,null|max:2',
        'status_kawin' => 'required|in:Kawin,Belum Kawin,Cerai',
        'tgl_kawin' => 'nullable|date|required_if:status_kawin,kawin|date',
        'no_karis_karsu' => 'required|string|max:50|unique:pegawai,no_karis_karsu',
        'almt_rumah' => 'required|string|max:255',
        'tmt_pensiun' => 'required|date',
        'instansi_id' => 'required|exists:instansi,id',
        'unit_kerja_id' => 'required|exists:unit_kerja,id',
        'satuan_kerja_id' => 'required|exists:satuan_kerja,id',
        'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ],[
        'username.unique' => 'Username sudah digunakan oleh pengguna lain.',
        'email.unique' => 'Email sudah terdaftar.',
        'password.min' => 'Password minimal 8 karakter.',
        'password.regex' => 'Password harus mengandung huruf besar, huruf kecil, angka, dan simbol.',
        'password.confirmed' => 'Konfirmasi password tidak cocok.',
    ]);

    // === SIMPAN FOTO JIKA ADA ===
    if ($request->hasFile('foto')) {
        $validated['foto'] = $request->file('foto')->store('foto_pegawai', 'public');
    }

    // === VALIDATE GOLONGAN DARAH ===
    if ($validated['golongan_darah'] === '?' || $validated['golongan_darah'] === '-') {
        $validated['golongan_darah'] = null;
    }

    // === MULAI TRANSACTION ===
    DB::transaction(function () use ($validated) {
        // Simpan data pegawai
        $pegawai = Pegawai::create([
            'nama' => $validated['nama'],
            'nip' => $validated['nip'],
            'no_kk' => $validated['no_kk'],
            'tpt_lahir' => $validated['tpt_lahir'],
            'tgl_lahir' => $validated['tgl_lahir'],
            'no_karpeg' => $validated['no_karpeg'],
            'agama_id' => $validated['agama_id'],
            'golongan_darah' => $validated['golongan_darah'],
            'status_kawin' => $validated['status_kawin'],
            'tgl_kawin' => $validated['tgl_kawin'] ?? null,
            'no_karis_karsu' => $validated['no_karis_karsu'],
            'almt_rumah' => $validated['almt_rumah'],
            'tmt_pensiun' => $validated['tmt_pensiun'],
            'instansi_id' => $validated['instansi_id'],
            'unit_kerja_id' => $validated['unit_kerja_id'],
            'satuan_kerja_id' => $validated['satuan_kerja_id'],
            'foto' => $validated['foto'] ?? null,
        ]);

        // Simpan akun user
        User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 6, // default pegawai
            'pegawai_id' => $pegawai->id,
        ]);
    });

    // 🔍 Audit isi data sebelum simpan
    logger('📦 Data yang akan disimpan:', $validated);

    // === REDIRECT DENGAN NOTIFIKASI ===
    return redirect()->route('backend.daftar_pegawai')
        ->with('success', '✅ Data pegawai berhasil ditambahkan dan akun user berhasil dibuat.');
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
        $pegawai = Pegawai::findOrFail($id);
    
        // Hapus foto jika ada
        if ($pegawai->foto) {
            Storage::disk('public')->delete($pegawai->foto);
        }

        $pegawai->delete();

        return redirect()->back()->with('success', '✅ Data pegawai berhasil dihapus.');

    }
}
