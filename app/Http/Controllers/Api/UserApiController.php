<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;


class UserApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.basic', ['except' => [
            'register',
            'login',
        ]]);
    }

    public function register(Request $request)
    {

        $validator = Validator::make($request->all(),
            [
                'email' => 'required|unique:users|email:rfc,dns',
                'name' => 'required|max:255',
                'password' => [
                    'required',
//                    'string',
//                    Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised(),
//                    'confirmed'
                ],
                'password_confirmation' => 'required|same:password'
            ]
        );
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()]);
        }


        User::create([
            'email' => $request['email'],
            'name' => $request['name'],
            'password' => Hash::make($request['password']),
            'is_admin' => 0,
            'remember_token' => Str::random(10)
        ]);

        return \response([
            'message' => 'Registration successful'
        ], 200);
    }

    public function login(Request $request)
    {
        Validator::make($request->all(),
            [
                'email' => 'required|unique:users|email:rfc,dns',
                'password' => [
                    'required',
                    'string',
//                    Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised(),
//                    'confirmed'
                ],
            ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                \auth()->login($user);
                return \response([
                        'message' => 'logged in successful',
                        'user' => $user
                    ]
                    , 200);
            } else {
                return \response(['message' => 'Password mismatch'], 422);
            }
        } else {
            return \response(['message' => 'User EMAIL does not exists!'], 422);
        }
    }

    public function logout()
    {
        Auth::logout();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);

    }
}
