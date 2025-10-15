<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class RiwayatKesejahteraanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pegawaiId = DB::table('pegawai')->first()->id;
        DB::table('riwayat_kesejahteraan')->insert([
            'npwp' => 2023123455667,
            'no_bpjs' => 5112345678372,
            'no_taspen' => 850987655,
            'Kepemilikan_rumah' => 'milik sendiri',
            'kartu_pegawai_elektronik' => 'tidak ada',
            'pegawai_id' => $pegawaiId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
