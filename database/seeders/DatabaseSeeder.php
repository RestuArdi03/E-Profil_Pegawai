<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
        InstansiSeeder::class,
        UnitKerjaSeeder::class,
        SatuanKerjaSeeder::class,
        AgamaSeeder::class,
        PegawaiSeeder::class,
        StrataSeeder::class,
        RiwayatPendidikanSeeder::class,
        EselonSeeder::class,
        JenisJabatanSeeder::class,
        RiwayatJabatanSeeder::class,
        RiwayatDiklatSeeder::class,
        GolonganSeeder::class, 
        RiwayatGolonganSeeder::class,
        RiwayatPlhPltSeeder::class,
        RiwayatGajiSeeder::class,
        RiwayatKgbSeeder::class,
        RiwayatPenghargaanSeeder::class,
        RiwayatSlksSeeder::class,
        RiwayatOrganisasiSeeder::class,
        NilaiPrestasiKerjaSeeder::class,
        RiwayatAsesmenSeeder::class,
        RiwayatKesejahteraanSeeder::class,
        DataKeluargaSeeder::class,
        FolderSeeder::class,
        DokumenSeeder::class,
        UserSeeder::class,
        ]);
    }
}
