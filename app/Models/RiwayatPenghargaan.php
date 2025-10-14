<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RiwayatPenghargaan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'pegawai_id',
        'nm_penghargaan',
        'no_urut',
        'no_sertifikat',
        'tgl_sertifikat',
        'pejabat_penetap',
        'link'
    ];


    protected $table = 'riwayat_penghargaan';
    protected $dates = ['deleted_at'];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
