<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RiwayatJabatan extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'riwayat_jabatan';

    protected $fillable = [
        'pegawai_id',
        'jabatan',
        'eselon_id',
        'jenis_jabatan_id',
        'tmt',
        'no_sk',
        'tgl_sk',
        'pejabat_penetap',
        'jenis_mutasi',
    ];


    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function eselon()
    {
        return $this->belongsTo(Eselon::class, 'eselon_id');
    }

    public function jenis_jabatan()
    {
        return $this->belongsTo(JenisJabatan::class, 'jenis_jabatan_id');
    }

}
