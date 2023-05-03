<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(FederalEntitySeeder::class);
        $this->call(MunicipalitySeeder::class);
        $this->call(ZipCodeSeeder::class);
        $this->call(SettlementSeeder::class);
    }
}
