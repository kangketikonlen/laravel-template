<?php

namespace Database\Seeders\System\Subnavbar;

use Illuminate\Database\Seeder;
use App\Models\System\Subnavbar;

class SettingSubnavbarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sub = Subnavbar::create([
            'navbar_id' => '2',
            'name' => 'Informasi Institusi',
            'url' => '/setting/institution',
            'roles' => 'general'
        ]);
        $code = explode("/", $sub->url)[2];
        $sub->update(['code' => $code]);

        $sub = Subnavbar::create([
            'navbar_id' => '2',
            'name' => 'Custom Module',
            'url' => '/setting/custom-module',
            'roles' => 'general'
        ]);
        $code = explode("/", $sub->url)[2];
        $sub->update(['code' => $code]);
    }
}
