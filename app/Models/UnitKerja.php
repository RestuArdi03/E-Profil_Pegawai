<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnitKerja extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'unit_kerja';
    protected $dates = ['deleted_at'];
    protected $fillable = ['nm_unit_kerja'];

    public function instansi()
    {
        return $this->belongsTo(Instansi::class);
    }

    public function satuan_kerja()
    {
        return $this->hasMany(SatuanKerja::class);
    }

      // relasi hanya 1 satuan kerja terbaru
    public function latestSatuanKerja()
    {
        return $this->hasOne(SatuanKerja::class, 'unit_kerja_id')
                    ->latest('created_at'); // atau latest('id') sesuai kolom tanggal/urutan
    }
}
