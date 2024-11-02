<?php

namespace App\Http\Controllers\Auth\API;

use App\Application\User\RegisterUser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Ensure you import your User model

class AuthAPIController extends Controller
{
    private RegisterUser $registerUser;

    public function __construct(RegisterUser $registerUser)
    {
        $this->registerUser = $registerUser;
    }

    public function login(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            $token = Str::random(60);
            $user->api_token = $token;
            $user->updated_at = now();
            $user->save();

            return response()->json([
                'user' => [
                    'id' => $user->id,
                    'roleID' => $user->roleID,
                    'firstName' => $user->first_name,
                    'lastName' => $user->last_name,
                    'email' => $user->email,
                ],
                'token' => $token
            ], 200);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }


    public function logout(Request $request)
    {
        $user = $request->user();

        if ($user) {
            $user->api_token = null;
            $user->updated_at = now();
            $user->save();

            return response()->json(['message' => 'Successfully logged out'], 200);
        }

        return response()->json(['error' => 'No user authenticated'], 401);
    }
    public function getAllUsers()
    {
        // Fetch all users using the RegisterUser service
        $userModels = $this->registerUser->findAll(); // Ensure this method is implemented correctly

        // Map the user models to an array
        $users = array_map(fn($userModel) => $userModel->toArray(), $userModels);

        // Check if the users array is empty
        if (empty($users)) {
            return response()->json(['error' => 'No users found'], 404);
        }

        // Return the users array as a JSON response
        return response()->json(compact('users'), 200);
    }
    public function profile(Request $request)
    {
        $user = Auth::user();

        return response()->json(['user' => $user], 200);
    }
}
