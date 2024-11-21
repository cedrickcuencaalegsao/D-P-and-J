<?php

namespace App\Http\Controllers\Auth\API;

use App\Application\User\RegisterUser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Response\ActionResponse;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\password;

class AuthAPIController extends Controller
{
    private RegisterUser $registerUser;

    public function __construct(RegisterUser $registerUser, protected ActionResponse $actionResponse)
    {
        $this->registerUser = $registerUser;
    }

    public function register(Request $request): JsonResponse
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return $this->actionResponse->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();

        $input['password'] = Hash::make($input['password']);
        $user = $this->registerUser->create(
            1,
            $input['firstname'],
            $input['lastname'],
            $input['email'],
            $input['password']
        );
        $success['token'] =  $user->createToken('MyApp')->plainTextToken;

        $success['name'] =  $user->name;
        $this->registerUser->updateToken($user->id, $success['token']);

        return $this->actionResponse->sendResponse($success, 'User register successfully.');
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->actionResponse->sendError('Validation Error.', $validator->errors());
        }

        $data = $request->all();
        $user = $this->registerUser->login($data['email'], $data['password']);
        if (!$user) {
            return $this->actionResponse->sendError('Unauthorized', ['error' => 'Invalid credentials']);
        }

        // Using Sanctum
        $token = $user->createToken('MyApp')->plainTextToken;
        $success['token'] = $token;
        $success['name'] = $user->getFullName();

        $this->registerUser->updateToken($user->getId(), $token);

        return $this->actionResponse->sendResponse($success, 'Login successful');
    }
}
