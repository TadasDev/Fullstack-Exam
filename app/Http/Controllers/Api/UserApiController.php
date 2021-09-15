<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserApiController extends Controller
{

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'email' => 'required|unique:users|email:rfc,dns',
                'name' => 'required|max:255',
                'password' => [
//                    'required',
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


        $user = User::create([
            'email' => $request['email'],
            'name' => $request['name'],
            'password' => Hash::make($request['password']),
            'is_admin' => 0,
        ]);

        $access_token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token' => $access_token,
            'token_type' => 'Bearer',
        ], 200);
    }

    public function login(Request $request)
    {
        Validator::make($request->all(),
            [
                'email' => 'required|unique:users|email:rfc,dns',
                'password' => [
//                    'required',
//                    'string',
//                    Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised(),
//                    'confirmed'
                ],
            ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                \auth()->login($user,true);

                $access_token = $user
                    ->createToken('auth_token')
                    ->plainTextToken;

                return response()->json([
                    'user'=>$user,
                    'token' => $access_token,
                    'token_type' => 'Bearer',
                ], 200);
            } else {
                return response()->json(['message' => 'Password mismatch'], 422);
            }
        } else {
            return response()->json(['message' => 'User EMAIL does not exists!'], 422);
        }
    }

    public function logout(): JsonResponse
    {
        $user = Auth::user();
        $user->tokens()->delete();

        return response()->json([
            'message' => 'Successfully logged out'
        ],200);
    }

    public function editProfile(Request $request){

        $user = User::find(Auth::id());
        $user->email = $request->input('email');
        $user->name = $request->input('name');
        $user->save();  // Update the data

        return response()->json([
            'message' => 'Successfully updated profile'
        ],200);
    }

}
