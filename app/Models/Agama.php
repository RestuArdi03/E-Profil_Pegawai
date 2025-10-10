<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agama extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'agama';
    protected $dates = ['deleted_at'];
    protected $fillable = ['nm_agama'];

    public function pegawai()
    {
        return $this->hasMany(Pegawai::class);
    }

}
