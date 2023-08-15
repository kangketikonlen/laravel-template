<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\System\Role;
use App\Models\System\AppInfo;
use Database\Seeders\System\AppInfoSeeder;
use Illuminate\Database\Seeder;
use Database\Seeders\System\RoleSeeder;
use Database\Seeders\System\UserSeeder;
use Database\Seeders\System\ModuleSeeder;
use Database\Seeders\System\NavbarSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $seeder = [];

        if (Role::count() == 0) {
            $seeder[] = RoleSeeder::class;
        }

        if (User::count() == 0) {
            $seeder[] = UserSeeder::class;
        }

        $seeder[] = NavbarSeeder::class;
        $seeder[] = ModuleSeeder::class;

        if (AppInfo::count() == 0) {
            $seeder[] = AppInfoSeeder::class;
        }

        $this->call($seeder);
    }
}
