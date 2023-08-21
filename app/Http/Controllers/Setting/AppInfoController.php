<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\System\AppInfo;
use Illuminate\Http\Request;

class AppInfoController extends Controller
{
    protected $url = "/setting/info";

    public function index()
    {
        $data['appInfo'] = AppInfo::first();
        return view('pages.setting.info.index', $data);
    }

    public function update(Request $request)
    {
        $formFields = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'dev' => 'required',
            'dev_url' => 'required',
            'registered' => 'required'
        ]);

        $appInfo = AppInfo::first();
        $appInfo->update($formFields);

        return redirect($this->url)->with('alert', ['message' => 'Data has been updated!', 'status' => 'success']);
    }
}
