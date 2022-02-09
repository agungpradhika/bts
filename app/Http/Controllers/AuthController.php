<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\User as UserResource;
use App\Http\Requests\ValidateUserRegistration;
use App\Http\Requests\ValidateUserLogin;
use App\Models\User;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    public function register(ValidateUserRegistration $request){

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'country' => $request->country,
            'postcode' => $request->postcode,
        ]); 
        
        $token = JWTAuth::fromUser($user);

        return response()->json([
            'email' => $user->email,
            'token' => $token,
            'username' => $user->username
        ]);

        // return response()->json(compact('user','token'),201);
    }

    public function login(ValidateUserLogin $request){
      
        $credentials = request(['email', 'password']);
        if (!$token = auth()->attempt($credentials)) {
            return  response()->json([ 
                'errors' => [
                    'msg' => ['Incorrect username or password.']
                ]  
            ], 401);
        }

        $user = new UserResource(auth()->user());
    
        return response()->json([
            'email' => $user->email,
            'token' => $token,
            'username' => $user->name
        ]);
    }
 
    public function user()
    { 
       return new UserResource(auth()->user());
    }
}
