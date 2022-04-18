<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Rules\Password;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Traits\UploadFile;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class ProfileController extends Controller
{
    use UploadFile;

    protected function passwordRules()
    {
        return ['required', 'string', new Password, 'confirmed'];
    }

    public function profile() {
        return view('admin.user.profile');
    }

    public function passwordChange() {
        return view('admin.user.change_password');
    }

    public function passwordUpdate(Request $request) {
        $user = User::find(auth()->user()->id);

        $validator = Validator::make($request->all(), [
            'current_password' => ['required', 'string'],
            'password' => $this->passwordRules(),
        ]);
        $validator->after(function ($validator) use ($request, $user) {
            if (! isset($request['current_password']) || ! Hash::check($request['current_password'], $user->password)) {
                $validator->errors()->add('current_password', __('admin.current_password_no_match'));
            }
        });
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user->forceFill([
            'password' => Hash::make($request['password']),
        ])->save();

        return back()->with('success', __('admin.password_change_succsess'));
    }

    public function profileUpdate(Request $request) {
        $user = User::find(auth()->user()->id);
        $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:40', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'string', 'email', 'max:100', Rule::unique('users')->ignore($user->id)],
            'avatar' => ['nullable', 'mimes:png,jpg,jpeg', 'max:1024'],
        ]);

        // Upload Profile Avatar
        if (isset($request['avatar'])) {
            $image_path = $this->saveFile($request->file('avatar'), 'profile-photos');

            // Remove Old Image
            Storage::delete('public/' . auth()->user()->profile_photo_path);

            // Update Database
            $user->forceFill([
                'profile_photo_path' => $image_path,
            ])->save();
        }

        if ($request['email'] !== $user->email && $user instanceof MustVerifyEmail) {
            $user->email_verified_at = null;
        }

        $user->forceFill([
            'name' => $request['name'],
            'email' => $request['email'],
        ])->save();

        return back()->with('success', __('admin.profile_update_succsess'));
    }
}
