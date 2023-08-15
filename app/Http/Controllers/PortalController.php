<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\System\AppInfo;
use Illuminate\Support\Facades\Session;

class PortalController extends Controller
{
    public function index()
    {
        $data['info'] = AppInfo::first();
        return view('pages.portal', $data);
    }

    public function auth(Request $request)
    {
        $formFields = $request->validate([
            'username' => ['required', 'string', 'max:128'],
            'password' => 'required'
        ]);

        if (auth()->attempt($formFields)) {
            $request->session()->regenerate();
            $user = auth()->user();
            // Create session
            $session = array(
                'id' => $user->id,
                'name' => $user->name,
                'role_id' => $user->role_id,
                'role_name' => $user->roles->name,
                'role_description' => $user->roles->description,
                'role_url' => $user->roles->dashboard_url,
                'role_page' => $user->roles->is_landing
            );
            Session::put($session);
            return redirect('/')->with('message', 'Anda berhasil login!');
        }

        $this->invalidate_session($request);
        return back()->withErrors(['username' => 'Username atau password salah!'])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        $this->invalidate_session($request);
        return redirect('/')->with('message', 'You have been logged out!');
    }

    private function invalidate_session($request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->flush();
    }
}
