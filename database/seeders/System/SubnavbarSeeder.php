<?php

namespace Database\Seeders\System;

use Database\Seeders\General\Master\SubnavbarSeeder as MasterSubnavbarSeeder;
use Database\Seeders\General\Setting\SubnavbarSeeder as SettingSubnavbarSeeder;
use Illuminate\Database\Seeder;

class SubnavbarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // General
        $this->call(MasterSubnavbarSeeder::class);
        $this->call(SettingSubnavbarSeeder::class);
    }
}
