<?php

namespace App\Http\Controllers\Auth\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthWEBController extends Controller
{
    public function index()
    {
        return view('Pages.Auth.page');
    }
    public function validateLogin(Request $request)
    {
        dd($request->all());
        return redirect('/')->with('message', 'Login failed');
    }
}
