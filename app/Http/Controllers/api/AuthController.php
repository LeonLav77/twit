<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use Illuminate\Http\Request;
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
}
