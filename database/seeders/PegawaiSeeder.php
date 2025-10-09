<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PegawaiSeeder extends Seeder
{
    public function run(): void
    {
        $instansiId = DB::table('instansi')->first()->id;
        DB::table('pegawai')->insert([
            'nama' => 'Restu Ardi Putranto',
            'nip' => '1987654321',
            'no_kk' => '1234567890123456',
            'tpt_lahir' => 'Yogyakarta',
            'tgl_lahir' => '1995-08-17',
            'no_karpeg' => 'KPG123456',
            'jenis_kelamin' => 'Laki-laki',
            'agama_id' => 1,
            'golongan_darah' => 'O',
            'status_kawin' => 'Kawin',
            'tgl_kawin' => '2020-06-01',
            'no_karis_karsu' => 'KRS987654',
            'almt_rumah' => 'Jl. Merdeka No. 10',
            'tmt_pensiun' => '2055-08-17',
            'instansi_id' => $instansiId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}