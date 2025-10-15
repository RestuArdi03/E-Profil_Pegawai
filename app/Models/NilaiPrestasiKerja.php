<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NilaiPrestasiKerja extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'pegawai_id',
        'tahun',
        'skp',
        'nilai_prestasi_kerja',
        'nilai_perilaku_kerja',
        'klasifikasi_nilai',
        'pejabat_penilai'
    ];

    protected $table = 'nilai_prestasi_kerja';
    protected $dates = ['deleted_at'];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
