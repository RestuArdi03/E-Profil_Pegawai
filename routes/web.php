<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FBerandaController;
use App\Http\Controllers\BBerandaController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PendidikanController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\DiklatController;
use App\Http\Controllers\GolonganController;
use App\Http\Controllers\PlhPltController;
use App\Http\Controllers\GajiController;
use App\Http\Controllers\KgbController;
use App\Http\Controllers\PenghargaanController;
use App\Http\Controllers\SlksController;
use App\Http\Controllers\OrganisasiController;
use App\Http\Controllers\PrestasiKerjaController;
use App\Http\Controllers\AsesmenController;
use App\Http\Controllers\KesejahteraanController;
use App\Http\Controllers\KeluargaController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\DaftarPegawaiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root ke halaman login
Route::get('/', function () {
    return redirect()->route('login');
});

// Forgot Password
Route::get('/forgot-password', function () {
    return 'Fitur lupa password belum tersedia.';
})->name('password.request');

// ==== AUTH ====
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==== FRONTEND (USER/PEGAWAI) ====
Route::prefix('/')->name('frontend.')->middleware(['auth'])->group(function () {
    Route::get('/beranda', [FBerandaController::class, 'index'])->name('beranda');
    Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai');
    Route::get('/pendidikan', [PendidikanController::class, 'index'])->name('pendidikan');
    Route::get('/jabatan', [JabatanController::class, 'index'])->name('jabatan');
    Route::get('/plh_plt', [PlhPltController::class, 'index'])->name('plh_plt');
    Route::get('/golongan', [GolonganController::class, 'index'])->name('golongan');
    Route::get('/diklat', [DiklatController::class, 'index'])->name('diklat');
    Route::get('/gaji', [GajiController::class, 'index'])->name('gaji');
    Route::get('/kgb', [KgbController::class, 'index'])->name('kgb');
    Route::get('/penghargaan', [PenghargaanController::class, 'index'])->name('penghargaan');
    Route::get('/slks', [SlksController::class, 'index'])->name('slks');
    Route::get('/organisasi', [OrganisasiController::class, 'index'])->name('organisasi');
    Route::get('/prestasi', [PrestasiKerjaController::class, 'index'])->name('prestasi');
    Route::get('/asesmen', [AsesmenController::class, 'index'])->name('asesmen');
    Route::get('/kesejahteraan', [KesejahteraanController::class, 'index'])->name('kesejahteraan');
    Route::get('/keluarga', [KeluargaController::class, 'index'])->name('keluarga');
    Route::get('/dokumen', [DokumenController::class, 'index'])->name('dokumen');
});

// ==== BACKEND (ADMIN) ====
Route::prefix('/admin')->name('backend.')->middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/beranda', [BBerandaController::class, 'index'])->name('beranda');

    // ROUTE DAFTAR PEGAWAI
    Route::get('/daftar-pegawai', [DaftarPegawaiController::class, 'index'])->name('daftar_pegawai');
    Route::post('/daftar-pegawai/store', [DaftarPegawaiController::class, 'store'])->name('daftar_pegawai.store');
    Route::delete('/daftar-pegawai/{id}', [DaftarPegawaiController::class, 'destroy'])->name('daftar_pegawai.destroy');
    Route::get('/get-unit-kerja/{instansi}', [DaftarPegawaiController::class, 'getUnitKerja']);
    Route::get('/get-satuan-kerja/{unitKerja}', [DaftarPegawaiController::class, 'getSatuanKerja']);

    // ROUTE PROFIL PEGAWAI
    Route::get('/admin/pegawai/{pegawai}', [PegawaiController::class, 'show'])->name('backend.pegawai.show');
    Route::get('/admin/get-unit-kerja/{instansi_id}', [PegawaiController::class, 'getUnitKerja']);
    Route::get('/admin/get-satuan-kerja/{unit_kerja_id}', [PegawaiController::class, 'getSatuanKerja']);
    Route::resource('pegawai', PegawaiController::class);

    // ROUTE PENDIDIKAN
    Route::resource('riwayat_pendidikan', PendidikanController::class);
    Route::get('/riwayat_pendidikan/daftar/{pegawai}', [PendidikanController::class, 'show'])->name('pendidikan.show');
    Route::post('/riwayat_pendidikan/store', [PendidikanController::class, 'store'])->name('pendidikan.store');
    Route::delete('/riwayat_pendidikan/{id}', [PendidikanController::class, 'destroy'])->name('pendidikan.destroy');
    
    // ROUTE JABATAN
    Route::get('/riwayat_jabatan/{pegawai}', [JabatanController::class, 'show'])->name('jabatan.show');
    Route::delete('/riwayat_jabatan/{id}', [JabatanController::class, 'destroy'])->name('jabatan.destroy');
    Route::resource('riwayat_jabatan', JabatanController::class);
    Route::post('/riwayat_jabatan/store', [JabatanController::class, 'store'])->name('jabatan.store');
    
    // ROUTE PLH/PLT
    Route::get('/riwayat_plh_plt/{pegawai}', [PlhPltController::class, 'show'])->name('plh_plt.show');
    Route::delete('/riwayat_plh_plt/{id}', [PlhPltController::class, 'destroy'])->name('plh_plt.destroy');
    Route::resource('riwayat_plh_plt', PlhPltController::class);
    Route::post('/riwayat_plh_plt/store', [PlhPltController::class, 'store'])->name('plh_plt.store');

    // ROUTE GOLONGAN
    Route::get('/golongan/{pegawai}', [GolonganController::class, 'show'])->name('golongan.show');
    Route::delete('/riwayat_golongan/{id}', [GolonganController::class, 'destroy'])->name('golongan.destroy');
    Route::resource('riwayat_golongan', GolonganController::class);
    Route::post('/riwayat_golongan/store', [GolonganController::class, 'store'])->name('golongan.store');

    // ROUTE DIKLAT
    Route::get('/riwayat_diklat/{pegawai}', [DiklatController::class, 'show'])->name('diklat.show');

    // ROUTE GAJI
    Route::get('/riwayat_gaji/{pegawai}', [GajiController::class, 'show'])->name('gaji.show');

    // ROUTE KGB
    Route::get('/riwayat_kgb/{pegawai}', [KgbController::class, 'show'])->name('kgb.show');
    
    // ROUTE PENGHARGAAN
    Route::get('/riwayat_penghargaan/{pegawai}', [PenghargaanController::class, 'show'])->name('penghargaan.show');
    
    // ROUTE SLKS
    Route::get('/riwayat_slks/{pegawai}', [SlksController::class, 'show'])->name('slks.show');

    // ROUTE ORGANISASI
    Route::get('/riwayat_organisasi/{pegawai}', [OrganisasiController::class, 'show'])->name('organisasi.show');

    // ROUTE NILAI PRESTASI KERJA
    Route::get('/nilai_prestasi_kerja/{pegawai}', [PrestasiKerjaController::class, 'show'])->name('prestasiKerja.show');

    // ROUTE ASESMEN
    Route::get('/riwayat_asesmen/{pegawai}', [AsesmenController::class, 'show'])->name('asesmen.show');

    // ROUTE KESEJAHTERAAN
    Route::get('/riwayat_kesejahteraan/{pegawai}', [KesejahteraanController::class, 'show'])->name('kesejahteraan.show');

    // ROUTE KELUARGA
    Route::get('/data_keluarga/{pegawai}', [KeluargaController::class, 'show'])->name('keluarga.show');

    // ROUTE DOKUMEN
    Route::get('/dokumen/{pegawai}', [DokumenController::class, 'show'])->name('dokumen.show');
});
