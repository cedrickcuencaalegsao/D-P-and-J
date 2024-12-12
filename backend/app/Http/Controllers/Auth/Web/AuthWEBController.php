<?php

namespace App\Http\Controllers\Auth\WEB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class AuthWEBController extends Controller
{
    public function viewLogin()
    {
        return view('Pages.Auth.page');
    }
    public function validateLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            '_token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('/dashboard');
        }
        return redirect()->back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }
    public function viewRegister()
    {
        return view('Pages.Auth.register');
    }
    public function validateRegister(Request $request)
    {
        dd($request->all());
    }
    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect()->route('login');
    }
}
