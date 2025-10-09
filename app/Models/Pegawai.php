<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Instansi; // Pastikan Instansi di-import

class Pegawai extends Model
{
    use HasFactory;
    protected $table = 'pegawai';

    // Pastikan instansi_id sudah ditambahkan di migrasi tabel 'pegawai'
    
    public function user()
    {
        return $this->hasOne(User::class, 'pegawai_id');
    }

    public function riwayatSlks()
    {
        return $this->hasMany(RiwayatSlks::class);
    }

    /**
     * Relasi Many-to-One: Pegawai dimiliki oleh satu Instansi.
     */
    public function instansi()
    {
        return $this->belongsTo(Instansi::class, 'instansi_id'); // Kunci asing sudah didefinisikan di migrasi
    }
    
    // Relasi ke unit kerja (melalui Instansi, jika UnitKerja terkait ke Instansi)
    public function unit_kerja()
    {
        // Asumsi: UnitKerja::class dan Instansi::class sudah di-import
        // Relasi ini akan mencari UnitKerja melalui Instansi
        return $this->hasManyThrough(
            UnitKerja::class,
            Instansi::class,
            'id',             // Foreign key di Instansi (Instansi.id)
            'instansi_id',    // Foreign key di UnitKerja (UnitKerja.instansi_id)
            'instansi_id',    // Local key di Pegawai (Pegawai.instansi_id)
            'id'              // Local key di Instansi (Instansi.id)
        );
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
