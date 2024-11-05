<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProfileController extends Controller
{
    protected string $url = "/profile";

    public function index(): View
    {
        $data['user'] = Auth::user();
        return view('pages.profile', $data);
    }

    public function update(Request $request): RedirectResponse
    {
        $formFields = $request->validate([
            'name' => 'required',
            'username' => 'required',
            'picture' => 'image|max:1024'
        ]);

        if ($request->hasFile('picture')) {
            /** @var \Illuminate\Http\UploadedFile $file */
            $file = $request->file('picture');
            $filename = 'picture-' . date("ymdhis") . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/images/profile/', $filename);
            $formFields['picture'] = '/storage/images/profile/' . $filename;
        }

        $user = User::find(Auth::user()?->id);
        $user?->update($formFields);

        $this->invalidate_session($request);

        return redirect($this->url)->with('alert', ['message' => 'Data has been updated!', 'status' => 'success']);
    }

    public function reset(): RedirectResponse
    {
        $countData = User::count();
        $serialCode = str_pad(strval($countData + 1), 4, "0", STR_PAD_LEFT);
        $newPassword = "USR" . $serialCode . "P";

        $hashedPassword['password'] = bcrypt($newPassword);
        $user = User::find(Auth::user()?->id);
        $user?->update($hashedPassword);

        return redirect($this->url)->with('alert', ['message' => 'Password has been reset, your new password is ' . $newPassword, 'status' => 'success']);
    }

    private function invalidate_session(Request $request): void
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->flush();
    }
}
