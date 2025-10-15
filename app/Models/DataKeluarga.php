<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataKeluarga extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'pegawai_id',
        'nama',
        'nik',
        'tmpt_lahir',
        'tgl_lahir',
        'jenis_kelamin',
        'status_keluarga',
        'pendidikan',
        'pekerjaan',
        'nip',
    ];

    protected $table = 'data_keluarga';
    protected $dates = ['deleted_at'];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
