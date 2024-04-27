<?php

namespace App\Http\Controllers\Setting;

use Illuminate\Http\Request;
use App\Models\System\Institution;
use App\Http\Controllers\Controller;
use App\Http\Requests\Institution\UpdateInstitutionRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class InstitutionController extends Controller
{
    protected string $url = "/setting/institution";

    public function index(): View
    {
        $data['institution'] = Institution::first();
        return view('pages.setting.institution.index', $data);
    }

    public function update(UpdateInstitutionRequest $request): RedirectResponse
    {
        $formFields = $request->validated();

        if ($request->hasFile('logo')) {
            /** @var \Illuminate\Http\UploadedFile $file */
            $file = $request->file('logo');
            $filename = 'logo-' . date("ymdhis") . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/images/logo/', $filename);
            $formFields['logo'] = '/storage/images/logo/' . $filename;
        }

        if ($request->hasFile('background')) {
            /** @var \Illuminate\Http\UploadedFile $file */
            $file = $request->file('background');
            $filename = 'background-' . date("ymdhis") . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/images/background/', $filename);
            $formFields['background'] = '/storage/images/background/' . $filename;
        }

        $institution = Institution::first();
        $institution?->update($formFields);

        return redirect($this->url)->with('alert', ['message' => 'Data has been updated!', 'status' => 'warning']);
    }
}
