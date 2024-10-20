<?php

namespace App\Http\Controllers\Auth;

use App\Application\User\RegisterUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller

{
    private RegisterUser $registerUser;
    public function __construct(RegisterUser $registerUser)
    {
        $this->registerUser = $registerUser;
    }
    public function getAllUsers()
    {
        $data = $this->registerUser->findAll();
        return response()->json(compact('data'));
    }
    public function ViewAuth()
    {
        return view('Pages.Auth.page');
    }
    
}
