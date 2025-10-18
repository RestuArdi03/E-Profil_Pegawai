<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Pegawai;

class DaftarUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('pegawai')->get();

        // Ambil semua pegawai
        $pegawai = Pegawai::all();

        // Ambil ID pegawai yang sudah dipakai user
        $pegawaiTerpakai = User::pluck('pegawai_id')->toArray();

        // Filter pegawai yang belum dipakai
        $pegawaiBelumDipakai = $pegawai->filter(function ($pgw) use ($pegawaiTerpakai) {
            return !in_array($pgw->id, $pegawaiTerpakai);
        });

        return view('backend.daftar_user', compact('users', 'pegawaiBelumDipakai', 'pegawai'));
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
        // Validasi Data
        $validated = $request->validate([
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/',
                'confirmed'        
            ],
            'password_confirmation' => 'required',
        ], [
            'username.unique' => 'Username sudah digunakan oleh pengguna lain.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.regex' => 'Password harus mengandung huruf besar, huruf kecil, angka, dan simbol.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        // ✅ Simpan data
        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'pegawai_id' => $request->pegawai_id,
            'role' => $request->role
        ]);

        return redirect()->route('backend.daftar_user')->with('success', '✅ Data User berhasil ditambahkan.');
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
        // 🔍 Validasi data edit
        $request->validate([
            'username' => 'required|string|max:50',
            'email' => 'required|string|max:50',
            'pegawai_id' => 'required',
            'role' => 'required',
        ]);
        
        $users = User::findOrFail($id);
        // ✅ Update data
        $users->update([
            'username' => $request->username,
            'email' => $request->email,
            'pegawai_id' => $request->pegawai_id,
            'role' => $request->role
        ]);

        return redirect()->route('backend.daftar_user')->with('success', '✅ Data User berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $users = User::findOrFail($id);
        $users->delete(); // ✅ Hapus data user (soft delete)

        return redirect()->back()->with('success', '✅ Data User berhasil dihapus.');
    }
}
