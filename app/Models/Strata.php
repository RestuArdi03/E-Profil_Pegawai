<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Strata extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'nm_strata',
        'jurusan',
    ];

    protected $table = 'strata';
    protected $dates = ['deleted_at'];

}
