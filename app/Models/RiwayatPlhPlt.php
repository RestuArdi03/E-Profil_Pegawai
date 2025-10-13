<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RiwayatPlhPlt extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'riwayat_plh_plt';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'pegawai_id',
        'no_sprint',
        'tgl_sprint',
        'tgl_mulai',
        'tgl_selesai',
        'jabatan_plh_plt',
    ];


    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }

}
