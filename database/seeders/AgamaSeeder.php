<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgamaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('agama')->insert([
            ['nm_agama' => 'Islam'],
            ['nm_agama' => 'Kristen'],
            ['nm_agama' => 'Katolik'],
            ['nm_agama' => 'Hindu'],
            ['nm_agama' => 'Buddha'],
            ['nm_agama' => 'Konghucu'],
        ]);
    }
}
