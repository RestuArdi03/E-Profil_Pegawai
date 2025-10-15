<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RiwayatKesejahteraan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'pegawai_id',
        'npwp',
        'no_bpjs',
        'no_taspen',
        'kepemilikan_rumah',
        'kartu_pegawai_elektronik',
    ];

    protected $table = 'riwayat_kesejahteraan';
    protected $dates = ['deleted_at'];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
