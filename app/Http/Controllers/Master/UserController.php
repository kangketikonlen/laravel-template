<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    protected string $url = "/master/user";

    public function index(Request $request): View
    {
        $data['query'] = $request->input('query');
        $data['users'] = User::where('role_id', 2)->paginate(10)->appends(request()->query());
        return view('pages.master.user.index', $data);
    }

    public function create(): View
    {
        return view('pages.master.user.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $formFields = $request->validate([
            'name' => 'required',
            'username' => 'required',
            'password' => 'required'
        ]);

        $formFields['role_id'] = 2;
        $formFields['password'] = bcrypt($formFields['password']);
        User::create($formFields);

        return redirect($this->url)->with('alert', ['message' => 'Data has been saved!', 'status' => 'success']);
    }

    public function edit(User $user): View
    {
        $data['user'] = $user;
        return view('pages.master.user.edit', $data);
    }

    public function update(User $user, Request $request): RedirectResponse
    {
        $formFields = $request->validate([
            'name' => 'required',
            'username' => 'required'
        ]);

        $user->update($formFields);

        return redirect($this->url)->with('alert', ['message' => 'Data has been updated!', 'status' => 'success']);
    }

    public function reset_password(User $user): RedirectResponse
    {
        $countData = User::count();
        $serialCode = str_pad(strval($countData + 1), 4, "0", STR_PAD_LEFT);
        $newPassword = "USR" . $serialCode . "P";

        $hashedPassword['password'] = bcrypt($newPassword);
        $user->update($hashedPassword);

        return redirect($this->url)->with('alert', ['message' => 'Password has been reset, your new password is ' . $newPassword, 'status' => 'success']);
    }

    public function delete(User $user): RedirectResponse
    {
        $user->delete();

        return redirect($this->url)->with('alert', ['message' => 'Data has been deleted!', 'status' => 'danger']);
    }

    public function options(Request $request): string|false
    {
        $query = $request->input('q');
        $data = User::select('id', 'name as description')->where('name', 'like', '%' . $query . '%')->get();
        return json_encode($data);
    }
}
