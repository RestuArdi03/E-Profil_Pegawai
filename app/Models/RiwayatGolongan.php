<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RiwayatGolongan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'riwayat_golongan';
    protected $dates = ['deleted_at'];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function golongan()
    {
        return $this->belongsTo(Golongan::class);
    }
}
