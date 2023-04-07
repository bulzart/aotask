<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request) {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:5',
        ]);
        if ($validator->fails()) {
            $error = $validator->errors();
            return response()->json(['error' => $error], 400);
        }
 
        $user = User::create([
            'email' => $request->input('email'),
            'name' => $request->input('name'),
            'password' => Hash::make($request->input('password')),
        ]);

        $token = $user->createToken('token')->plainTextToken;
      
    
         return response()->json(['user' => $user,'token' => $token],201);
    }
    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
          
            return response()->json(['error' => $validator->errors()],400);
        }
        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
            $token = $request->user()->createToken('token');
            return response()->json(['token' => $token->plainTextToken],200);
        } else {
            return response()->json(['error' => 'Bad creds'], 401);
        }
    }
}
