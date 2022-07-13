<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('dashboard.auth.login');
    }


    protected function attemptLogin(Request $request)
    {
        // TODO form request
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        if (\Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember')))
            return redirect()->intended('/admin/home');

        return back()->withErrors([
            'email' => [trans('auth.failed')],
        ]);
    }
}
