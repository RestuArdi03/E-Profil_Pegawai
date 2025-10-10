<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RiwayatSlks extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'riwayat_slks';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'slks',
        'no_kepres',
        'tgl_kepres',
        'status',
        'pegawai_id',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function scopeForPegawai($query, $pegawaiId)
    {
        return $query->where('pegawai_id', $pegawaiId);
    }
}
