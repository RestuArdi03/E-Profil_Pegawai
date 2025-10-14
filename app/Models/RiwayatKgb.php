<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RiwayatKgb extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'riwayat_kgb';
    protected $dates = ['deleted_at'];

    protected $fillable = [
    'pegawai_id',
    'pejabat_penetap',
    'no_sk',
    'tgl_sk',
    'tgl_tmt',
    'jml_gaji',
    'ket',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
