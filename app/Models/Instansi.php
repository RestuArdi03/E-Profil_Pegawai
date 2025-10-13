<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Instansi.
 * Digunakan untuk berinteraksi dengan tabel 'instansi' di database.
 */
class Instansi extends Model
{
    use HasFactory;

    // KUNCI PERBAIKAN: Secara eksplisit menentukan nama tabel.
    // Jika tidak ada ini, Laravel akan mencari tabel 'instansis'.
    protected $table = 'instansi'; 

    // Default-nya Laravel menggunakan primary key 'id', tidak perlu dideklarasikan.
    // protected $primaryKey = 'id'; 
    
    // Tentukan kolom mana yang boleh diisi (mass assignment)
    protected $fillable = [
    'nm_instansi',
    'kd_instansi',
    'kode',
    'alamat_instansi',
    'telp_instansi',
    'fax_instansi',
    'urutan_instansi',
    ];

    protected static function boot()
        {
        parent::boot();

        // Saat sebuah instance baru Instansi akan dibuat
        static::creating(function ($instansi) {
            // Cari nilai urutan_instansi tertinggi yang ada
            $maxOrder = static::max('urutan_instansi');
            
            // Set urutan_instansi untuk data baru = Max + 1. 
            // Jika maxOrder null (tabel kosong), akan menjadi 1.
            $instansi->urutan_instansi = $maxOrder + 1;
        });
    }
}
