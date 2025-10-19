<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenisJabatan extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $fillable = ['jenis_jabatan'];
    protected $table = 'jenis_jabatan';
    protected $dates = ['deleted_at'];
}
