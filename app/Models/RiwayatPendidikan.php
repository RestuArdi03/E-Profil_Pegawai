<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RiwayatPendidikan extends Model
{
    use HasFactory;

    use SoftDeletes;
    
    protected $dates = ['deleted_at'];

    protected $table = 'riwayat_pendidikan';

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function strata()
    {
        return $this->belongsTo(Strata::class, 'strata_id');
    }

    protected $fillable = [
        'pegawai_id',
        'strata_id',
        'jurusan',
        'nm_sekolah_pt',
        'no_ijazah',
        'thn_lulus',
        'pimpinan',
        'kode_pendidikan',
    ];
}
