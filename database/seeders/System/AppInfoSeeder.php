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
            'name' => 'Larapulse',
            'logo' => '/storage/images/logo/default.png',
            'background' => '/storage/images/background/default.jpg',
            'description' => 'Larapulse Anda adalah implementasi kustom dari kerangka kerja PHP populer, Laravel. Didesain sesuai kebutuhan dengan fitur dan optimasi yang disesuaikan untuk meningkatkan efisiensi, fleksibilitas, dan performa pengembangan.',
            'dev' => 'Kangketik Dev',
            'dev_url' => 'https://kangketik.online/',
            'registered' => 'Kangketik Developer'
        ]);
    }
}
