<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SatuanKerja extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'satuan_kerja';
    protected $dates = ['deleted_at'];
    protected $fillable = ['nm_satuan_kerja', 'unit_kerja_id'];
    
    public function unit_kerja()
    {
        return $this->belongsTo(UnitKerja::class);
    }

     // ambil 1 satuan kerja terbaru
    public function latestSatuanKerja()
    {
        return $this->hasOne(SatuanKerja::class, 'unit_kerja_id')
                    ->latest('created_at'); // atau latest('id') sesuai kolom
    }
}
