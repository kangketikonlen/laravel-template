<?php

namespace Database\Seeders\System\Module\Support;

use App\Models\System\Module;
use App\Models\System\Navbar;
use Illuminate\Database\Seeder;
use App\Models\System\Subnavbar;

class GeneralSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $navbars = Navbar::get();
        $subnavbars = Subnavbar::get();
        //
        $code = uniqid('mod-', true);
        //
        $navbarArray = [];
        foreach ($navbars as $navbar) {
            if (in_array('general', explode(',', $navbar->roles))) {
                $navbarArray[] = $navbar->id;
            }
        }
        $subnavbarArray = [];
        foreach ($subnavbars as $subnavbar) {
            if ($subnavbar->roles === 'general') {
                $subnavbarArray[] = $subnavbar->code;
            }
        }
        Module::create([
            'code' => $code,
            'icon' => 'fa-wrench',
            'description' => 'General Setting',
            'url' => '/dashboard/switch?mod=' . $code,
            'navbars' => implode(',', $navbarArray),
            'subnavbars' => implode(',', $subnavbarArray),
            'roles' => 1,
            'role_code' => 'general'
        ]);
    }
}
