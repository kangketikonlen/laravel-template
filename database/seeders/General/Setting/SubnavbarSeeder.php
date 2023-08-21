<?php

namespace Database\Seeders\General\Setting;

use Illuminate\Database\Seeder;
use App\Models\System\Subnavbar;

class SubnavbarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Subnavbar::create([
            'navbar_id' => '2',
            'name' => 'Informasi Aplikasi',
            'url' => '/setting/info',
            'roles' => 'general'
        ]);
        Subnavbar::create([
            'navbar_id' => '2',
            'name' => 'Informasi Institusi',
            'url' => '/setting/institution',
            'roles' => 'general'
        ]);
    }
}
