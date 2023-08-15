<?php

namespace Database\Seeders\System;

use App\Models\System\AppInfo;
use Illuminate\Database\Seeder;

class AppInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AppInfo::create([
            'name' => 'Laravel Template',
            'logo' => '/storage/images/logo/default.png',
            'background' => '/storage/images/background/default.png',
            'dev' => 'Kangketik Dev',
            'dev_url' => 'https://kangketik.web.id/',
            'registered' => 'Kangketik Developer'
        ]);
    }
}
