<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Corrected the namespace for User model

class AuthController extends Controller
{
    // Register user
    public function register(Request $request)
    {

        // Validation
        $attr = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email', // Corrected the table name
            'password' => 'required|min:6|confirmed',
        ]);

        // Create user
        $user = User::create([
            'name' => $attr['name'],
            'email' => $attr['email'],
            'password' => bcrypt($attr['password']),

            
        ]);

        // Return user & token in response
        return response([
            'user' => $user,
            'token' => $user->createToken('secret')->plainTextToken,
        ], 200);
    }

    // Login user
    public function login(Request $request)
    {

        // Validation
        $attr = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Attempt login
        if (! Auth::attempt($attr)) {
            return response([
                'message' => 'Invalid credentials.',
            ], 403);
        }

        // Return user & token in response
        return response([
            'user' => Auth::user(), // Corrected the syntax
            'token' => Auth::user()->createToken('secret')->plainTextToken,
        ], 200);
    }

    // Logout
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response([
            'message' => 'Logout success.',
        ], 200);
    }

    // Get user details
    public function user()
    {
        return response([
            'user' => Auth::user(),
        ], 200);
    }


    //updateuser

    public function update(Request $request)
    {
        $attrs = $request->validate([
            'name'=> 'required|string'

        ]); 
        $image = $this->saveImage($request -> image, 'profiles');

        auth()->user()->update([
               'name'=>$attrs['name'],
               'image'=>$image

        ]);

        return response([
            'message'=>'user updated.',
            'user' => Auth::user(),
        ], 200);
    }
}
