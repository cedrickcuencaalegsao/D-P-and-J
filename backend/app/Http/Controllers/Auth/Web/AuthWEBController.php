<?php

namespace App\Http\Controllers\Auth\WEB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthWEBController extends Controller
{
    public function viewLogin()
    {
        return view('Pages.Auth.page');
    }
    public function validateLogin(Request $request)
    {
        dd($request->all());
    }
}
