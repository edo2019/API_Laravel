<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\User;

class AuthController extends Controller
{
    //register user

    public function register(Request $request){

    //vallidation
    $attr = $request->validate([
        'name'=>'required|string',
        'email'=>'required|email|unique:user.email',
        'password'=>'required|min:6|confirmed'
    ]);
   //create user

   $user = user::create([
      'name'=> $attr['name'],
      'email'=> $attr['email'],
      'password'=> bcrypt ($attr['password'])

   ]);

   //return user & token in response
   return response([
     'user'=>$user,
     'token'=>$user ->createToken('secret')->plainTextToken


   ],200);
   

    }
    //login user
    public function login(Request $request){

        //vallidation
        $attr = $request->validate([
          
            'email'=>'required|email',
            'password'=>'required|min:6'
        ]);
       //atempt login
        if(!Auth::attempt($attr)){

            return response([
               'message' =>'invalid credentilas.'
            ],403);
        }

    
       //return user & token in response
       return response([
         'user'=> Auth()->$user,
         'token'=> Auth()-$user ->createToken('secret')->plainTextToken
    
    
       ],200);
       
    
        }

        //logout

        public function logout(){
           auth()->user()->token()->delete();

           return response([
             'message'=>'logout success.'

           ],200);

        }

     public function user(){

         return response([
             'user'=> Auth()->user()

         ],200);
     }



}
