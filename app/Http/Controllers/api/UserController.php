<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::get();

        return response()->json([
            'status' => 200,
            'users' => $users
        ]);
    }

    public function show($id)
    {
        $user = User::find($id);
        return response()->json([
            'status' => 200,
            'user' => $user
        ]);
    }
}