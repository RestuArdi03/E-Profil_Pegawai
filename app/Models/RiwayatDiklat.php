<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RiwayatDiklat extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'pegawai_id',
        'nm_diklat',
        'jpl',
        'tgl_mulai',
        'tgl_selesai',
        'no_sertifikat',
        'tgl_sertifikat',
        'penyelenggara',
    ];

    protected $table = 'riwayat_diklat';
    protected $dates = ['deleted_at'];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
    
}
