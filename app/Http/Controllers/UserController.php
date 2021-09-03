<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;


class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function store(Request $request)
    {

        $this->validate(
            $request, [
                'email' => 'required|unique:users|email:rfc,dns',
                'name' => 'required|max:255',
                'password' => [
                    'required',
                    'string',
                    Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised(),
                    'confirmed'
                ],
                'password_confirmation' => 'required|same:password'
            ]
        );
        $user = User::create([
            'email' => $request['email'],
            'name' => $request['name'],
            'is_admin' => 0,
            'password' => Hash::make($request['password']),
            'remember_token' => csrf_token()
        ]);

        return \response()->json($user);
    }


    public function show(User $user): User
    {
        return $user;
    }
}
