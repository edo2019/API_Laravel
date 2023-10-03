<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        //validator
        // $validator = validator::make($request->all(), [

        //     'name' => 'required|string',
        //     'email' => 'required|email|unique:users',
        //     'phoneNo' => 'required|phoneNo|unique:users',
        //     'password' => 'required|string|min:6',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json(['error' => $validator->errors()], 400);
        // }

        // Create a new user
        $user = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phoneNo' => $request->input('phoneNo'),
            'password' => Hash::make($request->input('password')),
        ]);

        $user->save();

        return response()->json(['message' => 'User registered successfully'], 201);

    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return response()->json('welcome here');
        } else {
            return response()->json('error');
        }
    }
}
