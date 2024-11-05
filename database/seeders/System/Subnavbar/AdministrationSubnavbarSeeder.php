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
        $sub = Subnavbar::create([
            'navbar_id' => '3',
            'name' => 'Maintenance Mode',
            'url' => '/administration/maintenance',
            'roles' => 'general'
        ]);
        $code = explode("/", $sub->url)[2];
        $sub->update(['code' => $code]);
    }
}
