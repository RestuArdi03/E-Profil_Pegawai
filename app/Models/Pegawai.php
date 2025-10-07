<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;
    protected $table = 'pegawai';

    protected $fillable = [
        'nama',
        'nip',
        'no_kk',
        'tpt_lahir',
        'tgl_lahir',
        'no_karpeg',
        'agama',
        'golongan_darah',
        'status_kawin',
        'tgl_kawin',
        'no_karis_karsu',
        'almt_rumah',
        'tmt_pensiun',
        'instansi_id',
        'unit_kerja_id',
        'satuan_kerja_id',
        'foto'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'pegawai_id');
    }

    public function riwayatSlks()
    {
        return $this->hasMany(RiwayatSlks::class);
    }

    public function instansi()
    {
        return $this->belongsTo(Instansi::class);
    }

    public function riwayatGolongan()
    {
        return $this->hasMany(RiwayatGolongan::class);
    }
    
    public function riwayatPlhPlt()
    {
        return $this->hasMany(RiwayatPlhPlt::class);
    }

    public function riwayatDiklat()
    {
        return $this->hasMany(RiwayatDiklat::class);
    }

    public function riwayatGaji()
    {
        return $this->hasMany(RiwayatGaji::class);
    }

    public function riwayatKgb()
    {
        return $this->hasMany(RiwayatKgb::class);
    }

    public function riwayatPenghargaan()
    {
        return $this->hasMany(RiwayatPenghargaan::class);
    }

    public function riwayatOrganisasi()
    {
        return $this->hasMany(riwayatOrganisasi::class);
    }
    
    public function prestasiKerja()
    {
        return $this->hasMany(NilaiPrestasiKerja::class);
    }

    public function riwayatAsesmen()
    {
        return $this->hasMany(RiwayatAsesmen::class);
    }

    public function riwayatKesejahteraan()
    {
        return $this->hasMany(Kesejahteraan::class);
    }

    public function dataKeluarga()
    {
        return $this->hasMany(DataKeluarga::class);
    }

    public function Dokumen()
    {
        return $this->hasMany(Dokumen::class);
    }


    // public function unit_kerja()
    // {
    //     return $this->belongsTo(UnitKerja::class, 'unit_kerja_id');
    // }

       // relasi ke unit kerja lewat instansi
    public function unit_kerja()
    {
        return $this->belongsTo(UnitKerja::class, 'unit_kerja_id');
    }

    public function satuan_kerja()
    {
        return $this->belongsTo(SatuanKerja::class, 'satuan_kerja_id');
    }

    public function riwayatJabatan()
    {
        return $this->hasMany(RiwayatJabatan::class);
    }

}
