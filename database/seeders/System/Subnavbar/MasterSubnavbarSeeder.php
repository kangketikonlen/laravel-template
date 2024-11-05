<?php

namespace Database\Seeders\System\Subnavbar;

use Illuminate\Database\Seeder;
use App\Models\System\Subnavbar;

class MasterSubnavbarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sub = Subnavbar::create([
            'navbar_id' => '1',
            'name' => 'Pengguna',
            'url' => '/master/user',
            'roles' => 'general'
        ]);
        $code = explode("/", $sub->url)[2];
        $sub->update(['code' => $code]);
    }
}
