<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
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
}
