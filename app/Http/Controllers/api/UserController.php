<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::select('id')->find(1);

        return response()->json([
            'status' => 200,
            'users' => $users
        ]);
    }
}