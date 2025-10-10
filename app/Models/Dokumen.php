<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dokumen extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'dokumen';
    protected $dates = ['deleted_at'];

    public function folder() 
    {
        return $this->belongsTo(Folder::class);
    }

    public function pegawai() 
    {
        return $this->belongsTo(Pegawai::class);
    }
}
