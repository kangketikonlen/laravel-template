<?php

namespace Database\Seeders\Support;

use App\Models\System\Module;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Module::create([
            'icon' => 'fa-wrench',
            'description' => 'General Setting',
            'url' => '/dashboard/switch-role?role=general',
            'role_name' => 'support'
        ]);
    }
}
