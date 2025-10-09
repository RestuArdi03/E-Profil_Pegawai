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
    'alamat_instansi',
    'telp_instansi',
    'fax_instansi',
    'urutan_instansi',
    ];

}
