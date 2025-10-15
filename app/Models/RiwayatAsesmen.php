<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RiwayatAsesmen extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'pegawai_id',
        'tgl_asesmen',
        'tujuan_asesmen',
        'metode_asesmen',
        'gambaran_potensi',
        'gambaran_kompetensi',
        'saran_pengembangan',
    ];

    protected $table = 'riwayat_asesmen';
    protected $dates = ['deleted_at'];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
