<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            $user = auth()->user();
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status' => 200,
                'message' => 'Login successful',
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Invalid credentials',
            ], 401);
        }
    }
}
