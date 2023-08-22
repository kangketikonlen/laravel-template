<?php

namespace Database\Seeders\System\Subnavbar;

use Illuminate\Database\Seeder;
use App\Models\System\Subnavbar;

class AdministrationSubnavbarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Subnavbar::create([
            'navbar_id' => '3',
            'name' => 'Riwayat Error',
            'url' => '/administration/crash-log',
            'roles' => 'general'
        ]);
        Subnavbar::create([
            'navbar_id' => '3',
            'name' => 'Riwayat Aktivitas',
            'url' => '/administration/activity-log',
            'roles' => 'general'
        ]);
    }
}
