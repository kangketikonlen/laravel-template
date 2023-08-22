<?php

namespace App\Http\Controllers\Administration;

use Illuminate\Support\Str;
use App\Models\System\AppInfo;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

class MaintenanceController extends Controller
{
    protected $url = "/administration/maintenance";

    public function index()
    {
        $data['appInfo'] = AppInfo::first();
        return view('pages.administration.maintenance.index', $data);
    }

    public function process()
    {
        $randomSecret = Str::random(32);
        $appInfo = AppInfo::first();

        if (app()->isDownForMaintenance()) {
            Artisan::call('up');
            $data['is_maintenance'] = 0;
            $message = "Maintenance mode is now OFF.";
            $appInfo->update($data);
        } else {
            Artisan::call('down --secret=' . $randomSecret);
            $data['is_maintenance'] = 1;
            $message = "Maintenance mode is now ON.";
            $appInfo->update($data);
            return redirect($randomSecret)->with('alert', ['message' => $message, 'status' => 'danger']);
        }

        return redirect($this->url)->with('alert', ['message' => $message, 'status' => 'danger']);
    }
}
