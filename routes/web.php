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
use App\Http\Controllers\OrganisaasiController;
use App\Http\Controllers\PrestasiKerjaController;
use App\Http\Controllers\AsesmenController;
use App\Http\Controllers\KesejahteraanController;
use App\Http\Controllers\KeluargaController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\DaftarPegawaiController;
// use App\Http\Controllers\DaftarInstansiController; // Dihapus, karena fungsinya dipindahkan ke InstansiController
use App\Http\Controllers\InstansiController; 

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sini tempat kamu mendaftarkan rute web untuk aplikasimu.
|
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
    Route::get('/organisasi', [OrganisaasiController::class, 'index'])->name('organisasi');
    Route::get('/prestasi', [PrestasiKerjaController::class, 'index'])->name('prestasi');
    Route::get('/asesmen', [AsesmenController::class, 'index'])->name('asesmen');
    Route::get('/kesejahteraan', [KesejahteraanController::class, 'index'])->name('kesejahteraan');
    Route::get('/keluarga', [KeluargaController::class, 'index'])->name('keluarga');
    Route::get('/dokumen', [DokumenController::class, 'index'])->name('dokumen');
});

// ==== BACKEND (ADMIN) ====
Route::prefix('/admin')->name('backend.')->middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/beranda', [BBerandaController::class, 'index'])->name('beranda');
    Route::get('/daftar-pegawai', [DaftarPegawaiController::class, 'index'])->name('daftar_pegawai');
    
    // PERUBAHAN KRUSIAL DI BAWAH INI:

    // 1. Rute untuk Daftar Instansi (Index) DIUBAH untuk menargetkan InstansiController@index.
    // Ini menggunakan nama rute lama ('backend.daftar_instansi') agar tidak perlu mengubah semua Redirect.
    Route::get('/daftar-instansi', [InstansiController::class, 'index'])->name('daftar_instansi'); 
    
    // 2. Rute Resource untuk Instansi DIUBAH agar TIDAK mengecualikan 'index'.
    // Karena kita sudah punya rute 'daftar_instansi' di atas yang menuju InstansiController@index,
    // kita cukup mengecualikan 'show' saja (sesuai logika di controller kamu).
    Route::resource('instansi', InstansiController::class)->except(['show']); 
    // CATATAN: Karena 'daftar_instansi' sudah mendaftarkan rute index,
    // kita tetap bisa menggunakan resource di atas, asalkan kita mengubah 
    // semua link 'backend.instansi.index' (jika ada) menjadi 'backend.daftar_instansi'.
    // Agar lebih konsisten, kita biarkan saja resource Instansi tanpa index, dan hanya menggunakan
    // rute GET di atas, dan memastikan semua link mengacu ke 'backend.daftar_instansi'.
    // Route::resource('instansi', InstansiController::class)->except(['index', 'show']); // Kode asli kamu. Kita pakai ini saja.
    // Biar lebih bersih, kita buat rute Resource Instansi yang hanya berisi CRUD (kecuali Index & Show)
    // dan rute 'daftar-instansi' khusus untuk Index.
    
    Route::resource('instansi', InstansiController::class)->except(['index', 'show']); 

    Route::resource('pegawai', PegawaiController::class);

});
