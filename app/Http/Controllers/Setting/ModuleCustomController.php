<?php

namespace App\Http\Controllers\Setting;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\System\Navbar;
use App\Models\System\Subnavbar;
use App\Models\System\ModuleCustom;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Models\System\ModuleCustomUser;

class ModuleCustomController extends Controller
{
    protected string $url = "/setting/custom-module";

    public function index(Request $request): View
    {
        $data['query'] = $request->input('query');
        $data['moduleCustoms'] = ModuleCustom::paginate(10)->appends(request()->query());
        return view('pages.setting.module-custom.index', $data);
    }

    public function create(): View
    {
        return view('pages.setting.module-custom.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $formFields = $request->validate([
            'description' => 'required'
        ]);

        $countData = ModuleCustom::count();
        $code = "TSK-" . str_pad($countData + 1, 4, '0', STR_PAD_LEFT);

        $moduleData['code'] = $code;
        $moduleData['icon'] = "fa-list";
        $moduleData['url'] = '/dashboard/switch-task?code=' . $code;
        $moduleData['description'] = $formFields['description'];
        $newModule = ModuleCustom::create($moduleData);

        return redirect($this->url . '/' . $newModule->id . '/edit')->with('alert', ['message' => 'Data tersimpan, silahkan pilih daftar isi apa saja yang akan ditambahkan!', 'status' => 'success']);
    }

    public function add_user(ModuleCustom $moduleCustom): View
    {
        $data['moduleCustom'] = $moduleCustom;
        return view('pages.setting.module-custom.add-user', $data);
    }

    public function store_user(ModuleCustom $moduleCustom, Request $request): RedirectResponse
    {
        $formFields = $request->validate([
            'user_id' => 'required'
        ]);

        foreach ($formFields['user_id'] as $user) {
            $moduleCustomUser['user_id'] = $user;
            $moduleCustomUser['module_custom_id'] = $moduleCustom->id;
            $isExists = ModuleCustomUser::where($moduleCustomUser)->first();
            if (empty($isExists)) {
                ModuleCustomUser::create($moduleCustomUser);
            }
        }

        return redirect($this->url)->with('alert', ['message' => 'Data has been updated!', 'status' => 'success']);
    }

    public function edit(ModuleCustom $moduleCustom): View
    {
        $data['moduleCustom'] = $moduleCustom;
        $data['navs'] = Navbar::get();
        return view('pages.setting.module-custom.edit', $data);
    }

    public function update(ModuleCustom $moduleCustom, Request $request): RedirectResponse
    {
        $formFields = $request->validate([
            'subnavbars' => 'required'
        ]);

        // Checking the navnars
        $navbars = [];
        foreach ($formFields['subnavbars'] as $subnavbar) {
            $subnavbar = Subnavbar::find($subnavbar);
            if (!in_array($subnavbar->navbar_id, $navbars)) {
                $navbars[] = $subnavbar->navbar_id;
            }
        }

        $formFields['navbars'] = implode(",", $navbars);
        $formFields['subnavbars'] = implode(",", $formFields['subnavbars']);

        $moduleCustom->update($formFields);

        return redirect($this->url)->with('alert', ['message' => 'Data has been updated!', 'status' => 'success']);
    }

    public function delete(ModuleCustom $moduleCustom): RedirectResponse
    {
        $moduleCustom->delete();

        return redirect($this->url)->with('alert', ['message' => 'Data has been deleted!', 'status' => 'danger']);
    }
}
