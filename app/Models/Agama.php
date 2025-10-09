<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agama extends Model
{
    use HasFactory;
    protected $table = 'agama';
    protected $fillable = ['nm_agama'];

    public function pegawai()
    {
        return $this->hasMany(Pegawai::class);
    }

}
