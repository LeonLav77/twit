<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use Laravel\Passport\Token;
use Illuminate\Http\Request;
use Laravel\Passport\RefreshToken;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request){
        $login = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (!(Auth::attempt($login))) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
            $token = Auth::user()->createToken('authToken')->accessToken;
            return response()->json(['token' => $token]);
        
    }

    public function register(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|max:55',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
        
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);
        
        $token = $user->createToken('authToken')->accessToken;
        
        return response()->json(['token' => $token]);
    }
    public function logout(){
        // revoke token
        
        Auth::logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
    public function me(){
        return response()->json(Auth::user());
    }
    public function refresh(){
        // revoke old token
        $oldToken = Auth::user()->token();
        $oldToken->revoke();
        return response()->json(['token' => Auth::user()->createToken('authToken')->accessToken]);
    }
}
