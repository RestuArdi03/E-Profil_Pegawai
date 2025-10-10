<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Folder extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'folder';
    protected $dates = ['deleted_at'];
    protected $fillable = ['nm_folder'];
    
    public function dokumen()
    {
        return $this->hasMany(Dokumen::class, 'folder_id');
    }
}
