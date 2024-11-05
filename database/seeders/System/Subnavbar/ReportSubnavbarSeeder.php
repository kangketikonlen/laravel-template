<?php

namespace Database\Seeders\System\Subnavbar;

use Illuminate\Database\Seeder;
use App\Models\System\Subnavbar;

class ReportSubnavbarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sub = Subnavbar::create([
            'navbar_id' => '4',
            'name' => 'Riwayat Aktivitas',
            'url' => '/report/activity-log',
            'roles' => 'general'
        ]);
        $code = explode("/", $sub->url)[2];
        $sub->update(['code' => $code]);

        $sub = Subnavbar::create([
            'navbar_id' => '4',
            'name' => 'Riwayat Error',
            'url' => '/report/error-log',
            'roles' => 'general'
        ]);
        $code = explode("/", $sub->url)[2];
        $sub->update(['code' => $code]);
    }
}
