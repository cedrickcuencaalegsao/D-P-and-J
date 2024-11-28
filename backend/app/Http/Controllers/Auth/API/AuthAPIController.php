<?php

namespace App\Http\Controllers\Auth\API;

use App\Application\User\RegisterUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Response\ActionResponse;

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
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return $this->actionResponse->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();

        $input['password'] = bcrypt($input['password']);
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

        return $this->actionResponse->sendResponse($user, 'Login successful');
    }
    public function logout(Request $request)
    {
        // if ($request->isMethod('post')) {
        // } else{

        // }
        $request->user()->tokens()->delete();
        // return response()->json(true, 200);
        return response()->json([
            'message' => 'Logged out from all devices successfully'
        ]);
    }
}
