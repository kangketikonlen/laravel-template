<?php

namespace Database\Seeders\System;

use App\Models\System\Module;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Database\Seeders\Support\ModuleSeeder as SupportModuleSeeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        Module::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        $this->call(SupportModuleSeeder::class);
    }
}
