<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit(){
        return view('profile');
    }

    public function update(UpdateProfileRequest $request){

        if (Hash::check($request->old_password, auth()->user()->password)) {
            Auth()->user()->fill([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ])->save();

            $request->session()->flash('success', 'profile updated');
            return redirect()->route('profile');

        } else {
            return back()->withErrors([
                'password' => [trans('auth.failed')],
            ]);
        }

    }
}
