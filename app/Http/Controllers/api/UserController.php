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
}