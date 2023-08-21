<?php

namespace App\Http\Controllers\Setting;

use Illuminate\Http\Request;
use App\Models\System\Institution;
use App\Http\Controllers\Controller;

class InstitutionController extends Controller
{
    protected $url = "/setting/institution";

    public function index()
    {
        $data['institution'] = Institution::first();
        return view('pages.setting.institution.index', $data);
    }

    public function update(Request $request)
    {
        $formFields = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'email' => 'required',
            'website' => 'required',
            'contact' => 'required',
            'logo' => 'image|max:1024',
            'background' => 'image|max:1024',
        ]);

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = 'logo-' . date("ymdhis") . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/images/logo/', $filename);
            $formFields['logo'] = '/storage/images/logo/' . $filename;
        }

        if ($request->hasFile('background')) {
            $file = $request->file('background');
            $filename = 'background-' . date("ymdhis") . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/images/background/', $filename);
            $formFields['background'] = '/storage/images/background/' . $filename;
        }

        $institution = Institution::first();
        $institution->update($formFields);

        return redirect($this->url)->with('alert', ['message' => 'Data has been updated!', 'status' => 'warning']);
    }
}
