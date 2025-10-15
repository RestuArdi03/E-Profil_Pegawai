<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RiwayatOrganisasi extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'pegawai_id',
        'organisasi',
        'jabatan',
        'masa_jabatan',
        'no_sk',
        'tgl_sk',
        'pejabat_penetap',
    ];

    protected $table = 'riwayat_organisasi';
    protected $dates = ['deleted_at'];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
