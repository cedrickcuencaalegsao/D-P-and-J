<?php

namespace App\Http\Controllers\Auth;

use App\Application\User\RegisterUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Response\ActionResponse;
use App\Models\User;

class AuthController extends Controller

{
    private RegisterUser $registerUser;
    private ActionResponse $actionResponse;
    public function __construct(RegisterUser $registerUser, ActionResponse $actionResponse)
    {
        $this->registerUser = $registerUser;
        $this->actionResponse = $actionResponse;
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
    /**
     * Register New User.
     * **/
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors(),
            ];

            if (!empty($errorMessages)) {
                $response['data'] = $errorMessages;
            }

            return response()->json($response, 404);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        $success['name'] =  $user->name;

        return $this->actionResponse->sendResponse($success, 'User register successfully.');
    }
    /**
     * Login api
     *
     */
    // public function login(Request $request): JsonResponse
    // {
    //     if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
    //         $user = Auth::user();
    //         $success['token'] =  $user->createToken('MyApp')->plainTextToken;
    //         $success['name'] =  $user->name;

    //         return $this->sendResponse($success, 'User login successfully.');
    //     } else {
    //         return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
    //     }
    // }
}
