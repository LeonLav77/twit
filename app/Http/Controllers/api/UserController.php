<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(User::all());
    }
    public function show($id){
        return response()->json(User::find($id));
    }
}
