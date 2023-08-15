<?php

namespace Database\Seeders\General\Master;

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
            'navbar_id' => '1',
            'name' => 'Pengguna',
            'url' => '/master/user',
            'roles' => 'general'
        ]);
    }
}
